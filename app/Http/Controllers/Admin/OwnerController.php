<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Http\Resources\AdminAddressResource;
use App\Http\Resources\AdminProfileResource;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class OwnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    /**
     * オーナー詳細画面
     */
    public function show(Admin $admin)
    {
        $admin = Admin::findOrFail(1);
        $adminProfile = $admin->adminProfile
            ? new AdminProfileResource($admin->adminProfile)
            : null;
        $adminAddresses = $admin->adminAddresses
            ? AdminAddressResource::collection($admin->adminAddresses)
            : null;

        return Inertia::render('Admin/Owners/Show', [
            'admin' => $admin,
            'adminProfile' => $adminProfile,
            'adminAddresses' => $adminAddresses,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        return Inertia::render('Admin/Owners/Edit', [
            'admin' => $admin,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        $validatedData = $request->validated();

        try {
            DB::transaction(function () use ($admin, $validatedData) {
                $admin->update($validatedData);
            });

            return redirect()->route('admin.owner.show', $admin)->with([
                'message' => 'オーナー情報を更新しました。',
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'オーナー情報の更新に失敗しました。',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
