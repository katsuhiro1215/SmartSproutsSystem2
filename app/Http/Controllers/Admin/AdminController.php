<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Resources\AdminAddressResource;
use App\Http\Resources\AdminProfileResource;
use App\Models\Admin;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
    /**
     * 管理者一覧画面
     * 
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        // 1ページあたりの表示件数 (デフォルトは20件)
        $perPage = $request->input('per_page', 20);

        // adminProfileも一緒に取得
        $admins = Admin::with('adminProfile')->admins()->paginate($perPage);
        $deletedAdmins = Admin::with('adminProfile')->admins()->onlyTrashed()->paginate($perPage);

        return Inertia::render('Admin/Admins/Index', [
            'admins' => $admins,
            'deletedAdmins' => $deletedAdmins,
        ]);
    }

    /**
     * 管理者作成画面
     * 
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        $organizations = Organization::select('id', 'name')->get()->map(function ($organization) {
            return [
                'value' => $organization->id,
                'label' => $organization->name,
            ];
        });

        $defaultOrganizationId = $organizations->first()['value'] ?? null;

        return Inertia::render('Admin/Admins/Create', [
            'organizations' => $organizations,
            'defaultOrganizationId' => $defaultOrganizationId,
        ]);
    }

    /**
     * 管理者登録処理
     * 
     * @param StoreAdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAdminRequest $request): RedirectResponse
    {
        // 組織選択のバリデーションルールを追加
        $request->validate([
            'organization_id' => ['required', 'exists:organizations,id'],
        ]);
        // バリデーション済みのデータを取得
        $validated = $request->validated();
        // パスワードをハッシュ化
        $validated['password'] = Hash::make($validated['password']);
        // トランザクションを開始
        try {
            DB::transaction(function () use ($validated, $request) {
                $admin = Admin::create($validated);
                // Organizationとのリレーションを登録
                $organizationId = $request->input('organization_id');
                // 中間テーブルにstatusを追加して登録
                $admin->organizations()->sync([
                    $organizationId => ['status' => true],
                ]);
            });

            return to_route('admin.admin.index')->with([
                'message' => 'ユーザーを登録しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'ユーザーの登録に失敗しました',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * 管理者詳細画面
     * 
     * @param Admin $admin
     * @return \Inertia\Response
     */
    public function show(Admin $admin): Response
    {

        $adminProfile = $admin->adminProfile
            ? new AdminProfileResource($admin->adminProfile)
            : null;
        $adminAddresses = $admin->adminAddresses
            ? AdminAddressResource::collection($admin->adminAddresses)
            : null;

        return Inertia::render('Admin/Admins/Show', [
            'admin' => $admin,
            'adminProfile' => $adminProfile,
            'adminAddresses' => $adminAddresses,
        ]);
    }

    /**
     * 管理者編集画面
     * 
     * @param Admin $admin
     * @return \Inertia\Response
     */
    public function edit(Admin $admin): Response
    {
        $organizations = Organization::select('id', 'name')->get()->map(function ($organization) {
            return [
                'value' => $organization->id,
                'label' => $organization->name,
            ];
        });

        $relatedOrganizationIds = $admin->organizations->pluck('id')->toArray();

        return Inertia::render('Admin/Admins/Edit', [
            'admin' => $admin,
            'organizations' => $organizations,
            'relatedOrganizationIds' => $relatedOrganizationIds,
        ]);
    }

    /**
     * 管理者更新処理
     * 
     * @param UpdateAdminRequest $request
     * @param Admin $admin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAdminRequest $request, Admin $admin): RedirectResponse
    {
        // 組織選択のバリデーションルールを追加
        $request->validate([
            'organization_id' => ['required', 'exists:organizations,id'],
        ]);
        // バリデーション済みのデータを取得
        $validated = $request->validated();
        // トランザクションを開始
        try {
            DB::transaction(function () use ($validated, $admin, $request) {
                $admin->update($validated);
                // Organizationとのリレーションを更新
                $organizationId = $request->input('organization_id');
                // 中間テーブルにstatusを追加して登録
                $admin->organizations()->sync([
                    $organizationId => ['status' => true],
                ]);
            });

            return to_route('admin.admin.index')->with([
                'message' => 'ユーザーを更新しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'ユーザーの更新に失敗しました',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * 管理者削除処理
     * 
     * @param Admin $admin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Admin $admin): RedirectResponse
    {
        // トランザクションを開始
        try {
            DB::transaction(function () use ($admin) {
                $admin->organizations()->detach();
                $admin->delete();
            });

            return to_route('admin.admin.index')->with([
                'message' => 'ユーザーを削除しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'ユーザーの削除に失敗しました',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * 管理者復活処理
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $admin = Admin::onlyTrashed()->find($id);

        if (!$admin) {
            return redirect()->back()->with([
                'message' => '管理者が見つかりません',
                'status' => 'danger',
            ]);
        }

        try {
            DB::transaction(function () use ($admin) {
                $admin->restore();
            });

            return to_route('admin.admin.index')->with([
                'message' => '管理者を復活しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => '管理者の復活に失敗しました',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * 管理者完全削除処理
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        $admin = Admin::onlyTrashed()->find($id);

        if (!$admin) {
            return redirect()->back()->with([
                'message' => '管理者が見つかりません',
                'status' => 'danger',
            ]);
        }

        try {
            DB::transaction(function () use ($admin) {
                $admin->forceDelete();
            });

            return to_route('admin.admin.index')->with([
                'message' => '管理者を完全削除しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => '管理者の完全削除に失敗しました',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * メールアドレスのユニークチェック
     * @param Request $request
     */
    public function checkEmail(Request $request)
    {
        $email = $request->email;
        $adminId = $request->id;

        Log::info('Check Email Request:', [
            'email' => $email,
            'adminId' => $adminId,
        ]);

        $exists = Admin::where('email', $email)
            ->when($adminId, function ($query, $adminId) {
                return $query->where('id', '!=', $adminId);
            })
            ->exists();

        return response()->json(['exists' => $exists]);
    }
}
