<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddressRequest;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class UserAddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    /**
     * ユーザー住所作成画面
     */
    public function create(User $user)
    {
        return Inertia::render('Admin/Users/Addresses/Create', [
            'user' => $user,
        ]);
    }

    /**
     * ユーザー住所登録処理
     */
    public function store(UserAddressRequest $request)
    {
        // バリデーション済みのデータを取得
        $validated = $request->validated();
        // トランザクションを開始
        try {
            DB::transaction(function () use ($validated, $request) {
                UserAddress::create($validated);
            });

            return to_route('admin.user.index')->with([
                'message' => 'ユーザーの住所を登録しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'ユーザーの住所の登録に失敗しました',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * ユーザー住所編集画面
     */
    public function edit(UserAddress $userAddress, User $user)
    {
        return Inertia::render('Admin/Users/Addresses/Edit', [
            'userAddress' => $userAddress,
        ]);
    }

    /**
     * ユーザー住所更新処理
     */
    public function update(UserAddressRequest $request, UserAddress $userAddress)
    {
        // バリデーション済みのデータを取得
        $validated = $request->validated();
        // トランザクションを開始
        try {
            DB::transaction(function () use ($validated, $userAddress, $request) {
                $userAddress->update($validated);
            });

            return to_route('admin.user.index')->with([
                'message' => 'ユーザーの住所を更新しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'ユーザーの住所の更新に失敗しました',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * ユーザー住所削除処理
     */
    public function destroy(UserAddress $userAddress)
    {
        // トランザクションを開始
        try {
            DB::transaction(function () use ($userAddress) {
                $userAddress->delete();
            });

            return to_route('admin.user.index')->with([
                'message' => 'ユーザーの住所を削除しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'ユーザーの住所の削除に失敗しました',
                'status' => 'danger',
            ]);
        }
    }
}
