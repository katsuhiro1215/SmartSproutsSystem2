<?php

namespace App\Policies;

use App\Models\Store;
use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class StorePolicy
{
    /**
     * 新規作成画面
     */
    public function create(Admin $admin): bool
    {
        return $admin->role = "Owner" || $admin->role = "SuperAdmin" || $admin->role = "Manager";
    }

    /**
     * 組織登録処理
     */
    public function store(Admin $admin): bool
    {
        return $admin->role = "Owner" || $admin->role = "SuperAdmin" || $admin->role = "Manager";
    }

    /**
     * 組織削除処理
     */
    public function destroy(Admin $admin, Store $store): bool
    {
        return $admin->role = "Owner" || $admin->role = "SuperAdmin" || $admin->role = "Manager";
    }
}
