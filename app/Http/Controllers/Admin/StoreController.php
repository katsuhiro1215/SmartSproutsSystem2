<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    /**
     * 店舗一覧画面
     * 
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        // 全店舗一覧
        $allStores = StoreResource::collection(
            Store::allStores()->get()
        );
        // 削除されていない店舗一覧
        $stores = StoreResource::collection(
            Store::withoutTrashed()->get()
        );
        // 削除済み店舗一覧
        $deletedStores = StoreResource::collection(
            Store::onlyTrashed()->get()
        );

        return Inertia::render('Admin/Stores/Index', [
            'allStores' => $allStores,
            'stores' => $stores,
            'deletedStores' => $deletedStores,
        ]);
    }

    /**
     * 店舗作成画面
     * 
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        // 認可の確認 (ポリシー)
        $this->authorize('create', Store::class);

        return Inertia::render('Admin/Stores/Create');
    }

    /**
     * 店舗登録処理
     * 
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        // 認可の確認 (ポリシー)
        $this->authorize('store', Store::class);

        $validatedData = $request->validated();

        // 郵便番号のハイフンを除去
        $validatedData['postalcode'] = str_replace('-', '', $validatedData['postalcode']);
        // 画像のアップロード
        if ($request->hasFile('store_photo_path')) {
            $validatedData['store_photo_path'] = ImageService::uploadMiddleThumbnail($request->file('store_photo_path'), 'stores');
        }
        // 画像のアップロード(ロゴ)
        if ($request->hasFile('store_logo_path')) {
            $validatedData['store_logo_path'] = ImageService::uploadMiddleThumbnail($request->file('store_logo_path'), 'store_logos');
        }

        try {
            DB::transasaction(function () use ($validatedData) {
                Store::create($validatedData);
            });

            return to_route('admin.store.index')->with([
                'message' => '店舗の作成に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.store.create')->with([
                'message' => '店舗の作成に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * 店舗詳細画面
     * 
     * @param Store $store
     * @return \Inertia\Response
     */
    public function show(Store $store): Response
    {
        // 店舗詳細
        $store = Store::with('organization')->findOrFail($store->id);
        // 住所の結合
        $store->full_address = $store->prefecture . ' ' .
            $store->city . ' ' .
            $store->address2 . ' ' .
            $store->address1;
        // 郵便番号のハイフンを追加
        $store->postalcode = substr($store->postalcode, 0, 3) . '-' . substr($store->postalcode, 3);

        return Inertia::render('Admin/Stores/Show', [
            'store' => new StoreResource($store),
        ]);
    }

    /**
     * 店舗編集画面
     * 
     * @param Store $store
     * @return \Inertia\Response
     */
    public function edit(Store $store): Response
    {
        return Inertia::render('Admin/Stores/Edit', [
            'store' => $store,
        ]);
    }

    /**
     * 店舗更新処理
     * 
     * @param StoreRequest $request
     * @param Store $store
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function update(StoreRequest $request, Store $store): RedirectResponse
    {
        $validatedData = $request->validated();
        // 郵便番号のハイフンを除去
        $validatedData['postalcode'] = str_replace('-', '', $validatedData['postalcode']);
        // 画像のアップロード
        if ($request->hasFile('store_photo_path')) {
            $validatedData['store_photo_path'] = ImageService::uploadMiddleThumbnail($request->file('store_photo_path'), 'stores');
        }
        // 画像のアップロード(ロゴ)
        if ($request->hasFile('store_logo_path')) {
            $validatedData['store_logo_path'] = ImageService::uploadMiddleThumbnail($request->file('store_logo_path'), 'store_logos');
        }

        try {
            DB::transaction(function () use ($validatedData, $store) {
                $store->update($validatedData);
            });

            return to_route('admin.store.index')->with([
                'message' => '店舗の更新に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.store.edit', $store)->with([
                'message' => '店舗の更新に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * 店舗削除処理
     * 
     * @param Store $store
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Store $store): RedirectResponse
    {
        // 認可の確認 (ポリシー)
        $this->authorize('delete', $store);

        try {
            DB::transaction(function () use ($store) {
                $store->delete();
            });

            return to_route('admin.store.index')->with([
                'message' => '店舗の削除に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.store.index')->with([
                'message' => '店舗の削除に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * 店舗復元処理
     * 
     * @param Store $store
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Store $store)
    {
        try {
            DB::transaction(function () use ($store) {
                $store->restore();
            });

            return to_route('admin.store.index')->with([
                'message' => '店舗の復元に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.store.index')->with([
                'message' => '店舗の復元に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * 店舗完全削除処理
     * 
     * @param Store $store
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Store $store)
    {
        try {
            DB::transaction(function () use ($store) {
                $store->forceDelete();
            });

            return to_route('admin.store.index')->with([
                'message' => '店舗の完全削除に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.store.index')->with([
                'message' => '店舗の完全削除に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    // コードがユニークかどうかを確認
    public function checkCode(Request $request)
    {
        $code = $request->code;
        $exists = Store::where('code', $code)->exists();

        return response()->json(['exists' => $exists]);
    }

    // メールアドレスがユニークかどうかを確認
    public function checkEmail(Request $request)
    {
        $email = $request->email;
        $exists = Store::where('email', $email)->exists();

        return response()->json(['exists' => $exists]);
    }
}
