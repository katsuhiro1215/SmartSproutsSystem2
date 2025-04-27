<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class OrganizationPolicy
{
    /**
     * 一覧画面
     */
    public function index(Admin $admin): bool
    {
        return $admin->role = "Owner";
    }

    /**
     * 新規作成画面
     */
    public function create(Admin $admin): bool
    {
        return $admin->role = "Owner";
    }

    /**
     * 組織登録処理
     */
    public function store(Admin $admin): bool
    {
        return $admin->role = "Owner";
    }

    /**
     * 組織削除処理
     */
    public function destroy(Admin $admin, Organization $organization): bool
    {
        return $admin->role = "Owner";
    }
}
