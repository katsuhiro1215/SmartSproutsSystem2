<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequest;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;             
use Inertia\Response;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    /**
     * 組織一覧画面
     * 
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        // 認可の確認 (ポリシー)
        $this->authorize('index', Organization::class);

        $organizations = OrganizationResource::collection(
            Organization::oldest()->get()
        );

        return Inertia::render('Admin/Organizations/Index', [
            'organizations' => $organizations,
        ]);
    }

    /**
     * 組織作成画面
     * 
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        // 認可の確認 (ポリシー)
        $this->authorize('create', Organization::class);

        return Inertia::render('Admin/Organizations/Create');
    }

    /**
     * 組織登録処理
     * 
     * @param OrganizationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function store(OrganizationRequest $request): RedirectResponse
    {
        // 認可の確認 (ポリシー)
        $this->authorize('store', Organization::class);

        $validatedData = $request->validated();

        // 郵便番号のハイフンを除去
        $validatedData['postalcode'] = str_replace('-', '', $validatedData['postalcode']);
        // 画像のアップロード
        if ($request->hasFile('organization_photo_path')) {
            $validatedData['organization_photo_path'] = ImageService::uploadMiddleThumbnail($request->file('organization_photo_path'), 'organizations');
        }
        // 画像のアップロード(ロゴ)
        if ($request->hasFile('organization_logo_path')) {
            $validatedData['organization_logo_path'] = ImageService::uploadMiddleThumbnail($request->file('organization_logo_path'), 'organizations');
        }

        try {
            DB::transaction(function () use ($validatedData) {
                Organization::create($validatedData);
            });

            return to_route('admin.organization.index')->with([
                'message' => '企業の登録に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => '企業の登録に失敗しました。',
                'status' => 'error'
            ]);
        }
    }

    /**
     * 組織詳細画面
     * 
     * @param Organization $organization
     * @return \Inertia\Response
     */
    public function show(Organization $organization): Response
    {
        // 住所の結合
        $organization->full_address = $organization->prefecture . ' ' .
            $organization->city . ' ' .
            $organization->address2 . ' ' .
            $organization->address1;
        // 郵便番号のハイフンを追加
        $organization->postalcode = substr($organization->postalcode, 0, 3) . '-' . substr($organization->postalcode, 3);

        $admins = $organization->admins;
        $stores = $organization->stores;

        return Inertia::render('Admin/Organizations/Show', [
            'organization' => $organization,
            'admins' => $admins,
            'stores' => $stores,
        ]);
    }

    /**
     * 組織編集画面
     * 
     * @param Organization $organization
     * @return \Inertia\Response
     */
    public function edit(Organization $organization): Response
    {
        return Inertia::render('Admin/Organizations/Edit', [
            'organization' => $organization,
        ]);
    }

    /**
     * 組織更新処理
     * 
     * @param OrganizationRequest $request
     * @param Organization $organization
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function update(OrganizationRequest $request, Organization $organization): RedirectResponse
    {
        $validatedData = $request->validated();
        // 郵便番号のハイフンを追加
        $validatedData['postalcode'] = str_replace('-', '', $validatedData['postalcode']);
        // 画像のアップロード
        if ($request->hasFile('organization_photo_path')) {
            $validatedData['organization_photo_path'] = ImageService::uploadMiddleThumbnail($request->file('organization_photo_path'), 'organizations');
        }
        // 画像のアップロード(ロゴ)
        if ($request->hasFile('organization_logo_path')) {
            $validatedData['organization_logo_path'] = ImageService::uploadMiddleThumbnail($request->file('organization_logo_path'), 'organizations');
        }

        try {
            DB::transaction(function () use ($validatedData, $organization) {
                $organization->update($validatedData);
            });

            return to_route('admin.organization.show')->with([
                'message' => '企業の更新に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => '企業の更新に失敗しました。',
                'status' => 'error'
            ]);
        }
    }

    /**
     * 組織削除処理
     * 
     * @param Organization $organization
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Organization $organization): RedirectResponse
    {
        // 認可の確認 (ポリシー)
        $this->authorize('destroy', $organization);

        try {
            DB::transaction(function () use ($organization) {
                $organization->delete();
            });

            return to_route('admin.organization.index')->with([
                'message' => '企業の削除に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => '企業の削除に失敗しました。',
                'status' => 'error'
            ]);
        }
    }

    // メールアドレスがユニークかどうかを確認
    public function checkEmail(Request $request)
    {
        $email = $request->email;
        $exists = Organization::where('email', $email)->exists();

        return response()->json(['exists' => $exists]);
    }
}
