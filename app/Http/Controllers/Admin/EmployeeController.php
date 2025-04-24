<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminProfileResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    // 従業員
    /**
     * 一覧画面
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $perPage = $request->input('per_page', 20);

        $employees = Admin::with('adminProfile')->employees()->paginate($perPage);
        $others = Admin::with('adminProfile')->others()->paginate($perPage);
        $expiredEmployees = Admin::with('adminProfile')->employees()->onlyTrashed()->paginate($perPage);
        $expiredOthers = Admin::with('adminProfile')->others()->onlyTrashed()->paginate($perPage);

        return Inertia::render('Admin/Employees/Index', [
            'employees' => $employees,
            'others' => $others,
            'expiredEmployees' => $expiredEmployees,
            'expiredOthers' => $expiredOthers,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Employees/Create');
    }
    
    /**
     * 詳細画面
     * @param \App\Models\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        $adminProfile = $admin->adminProfile
            ? new AdminProfileResource($admin->adminProfile)
            : null;

        return Inertia::render('Admin/Employees/Show', [
            'admin' => $admin,
            'adminProfile' => $adminProfile,
        ]);
    }
}
