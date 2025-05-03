<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuardianRequest;
use App\Models\Guardian;
use Inertia\Inertia;

class GuardianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    /**
     * 保護者一覧画面
     * 
     * @return \Inertia\Response
     */
    public function index()
    {


        return Inertia::render('Admin/Users/Guardians/Index', [
        ]);
    }

    /**
     * 保護者作成画面
     */
    public function create()
    {
        return Inertia::render('Admin/Users/Guardians/Create', [
        ]);
    }

    /**
     * 保護者登録処理
     */
    public function store(GuardianRequest $request)
    {
        //
    }

    /**
     * 保護者詳細画面
     */
    public function show(Guardian $guardian)
    {
        //
    }

    /**
     * 保護者編集画面
     */
    public function edit(Guardian $guardian)
    {
        //
    }

    /**
     * 保護者更新処理
     */
    public function update(GuardianRequest $request, Guardian $guardian)
    {
        //
    }

    /**
     * 保護者削除処理
     */
    public function destroy(Guardian $guardian)
    {
        //
    }

    /**
     * 保護者復活処理
     */
    public function restore(Guardian $guardian)
    {
        //
    }

    /**
     * 保護者完全削除処理
     */
    public function forceDelete(Guardian $guardian)
    {
        //
    }
}
