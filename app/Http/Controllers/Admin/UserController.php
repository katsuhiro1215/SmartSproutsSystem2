<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\GuardianResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\UserAddressResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }
    /**
     * ユーザー一覧画面
     * 
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        // 1ページあたりの表示件数 (デフォルトは20件)
        $perPage = $request->input('per_page', 20);

        // 全ユーザー一覧
        $allUsers = User::allUsers()
            ->searchKeyword($request->keyword)
            ->paginate($perPage);
        // 削除されていないユーザー一覧
        $users = User::withoutTrashed()
            ->searchKeyword($request->keyword)
            ->paginate($perPage);
        // 削除済みユーザー一覧
        $deletedUsers = User::onlyTrashed()
            ->searchKeyword($request->keyword)
            ->paginate($perPage);

        return Inertia::render('Admin/Users/Index', [
            'allUsers' => $allUsers,
            'users' => $users,
            'deletedUsers' => $deletedUsers,
        ]);
    }

    /**
     * ユーザー作成画面
     * 
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Users/Create');
    }

    /**
     * ユーザー登録処理
     * 
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        // バリデーション済みのデータを取得
        $validated = $request->validated();
        // パスワードをハッシュ化
        $validated['password'] = Hash::make($validated['password']);
        // トランザクションを開始
        try {
            DB::transaction(function () use ($validated, $request) {
                User::create($validated);
            });

            return to_route('admin.user.index')->with([
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
     * ユーザー詳細画面
     * 
     * @param User $user
     * @return \Inertia\Response
     */
    public function show(User $user): Response
    {
        $userAddresses = $user->userAddresses ? UserAddressResource::collection($user->userAddresses) : null;

        $students = $user->students ? StudentResource::collection($user->students) : null;

        $guardians = $user->guardians ? GuardianResource::collection($user->guardians) : null;

        return Inertia::render('Admin/Users/Show', [
            'user' => $user,
            'userAddresses' => $userAddresses,
            'students' => $students,
            'guardians' => $guardians,
        ]);
    }

    /**
     * ユーザー編集画面
     * 
     * @param User $user
     * @return \Inertia\Response
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Admin/Users/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * ユーザー更新処理
     * 
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        // バリデーション済みのデータを取得
        $validated = $request->validated();
        // トランザクションを開始
        try {
            DB::transaction(function () use ($validated, $user, $request) {
                $user->update($validated);
            });

            return to_route('admin.user.index')->with([
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
     * ユーザー削除処理
     * 
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        // トランザクションを開始
        try {
            DB::transaction(function () use ($user) {
                $user->delete();
            });

            return to_route('admin.user.index')->with([
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
     * ユーザー復活処理
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);

        if (!$user) {
            return redirect()->back()->with([
                'message' => 'ユーザーが見つかりません',
                'status' => 'danger',
            ]);
        }

        try {
            DB::transaction(function () use ($user) {
                $user->restore();
            });

            return to_route('admin.user.index')->with([
                'message' => 'ユーザーを復活しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'ユーザーの復活に失敗しました',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * ユーザー完全削除処理
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->find($id);

        if (!$user) {
            return redirect()->back()->with([
                'message' => 'ユーザーが見つかりません',
                'status' => 'danger',
            ]);
        }

        try {
            DB::transaction(function () use ($user) {
                $user->forceDelete();
            });

            return to_route('admin.user.index')->with([
                'message' => 'ユーザーを完全削除しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'ユーザーの完全削除に失敗しました',
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
        $userId = $request->id;

        Log::info('Check Email Request:', [
            'email' => $email,
            'userId' => $userId,
        ]);

        $exists = User::where('email', $email)
            ->when($userId, function ($query, $userId) {
                return $query->where('id', '!=', $userId);
            })
            ->exists();

        return response()->json(['exists' => $exists]);
    }
}
