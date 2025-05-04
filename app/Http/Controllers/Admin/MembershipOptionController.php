<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MembershipOptionRequest;
use App\Models\MembershipOption;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class MembershipOptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    /**
     * メンバーシップオプション一覧画面
     * 
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        return Inertia::render('Admin/MembershipOptions/Index', [
            'membershipOptions' => MembershipOption::select('id', 'name', 'status')->get(),
        ]);
    }

    /**
     * メンバーシップオプション作成画面
     * 
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        return Inertia::render('Admin/MembershipOptions/Create');
    }

    /**
     * メンバーシップオプション登録処理
     * 
     * @param MembershipOptionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function store(MembershipOptionRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        try {
            DB::transasaction(function () use ($validatedData) {
                MembershipOption::create($validatedData);
            });

            return to_route('admin.membershipOption.index')->with([
                'message' => 'メンバーシップオプションの作成に成功しました。',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.membershipOption.create')->with([
                'message' => 'メンバーシップオプションの作成に失敗しました。',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * メンバーシップオプション詳細画面
     * 
     * @param MembershipOption $membershipOption
     * @return \Inertia\Response
     */
    public function show(MembershipOption $membershipOption): Response
    {
        return Inertia::render('Admin/MembershipOptions/Show', [
            'membershipOption' => $membershipOption,
        ]);
    }

    /**
     * メンバーシップオプション編集画面
     * 
     * @param MembershipOption $membershipOption
     * @return \Inertia\Response
     */
    public function edit(MembershipOption $membershipOption): Response
    {
        return Inertia::render('Admin/MembershipOptions/Edit', [
            'membershipOption' => $membershipOption,
        ]);
    }

    /**
     * メンバーシップオプション更新処理
     * 
     * @param MembershipOptionRequest $request
     * @param MembershipOption $membershipOption
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function update(MembershipOptionRequest $request, MembershipOption $membershipOption)
    {
        $validatedData = $request->validated();

        try {
            DB::transasaction(function () use ($validatedData, $membershipOption) {
                $membershipOption->update($validatedData);
            });

            return to_route('admin.membershipOption.index')->with([
                'message' => 'メンバーシップオプションの更新に成功しました。',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.membershipOption.edit', $membershipOption)->with([
                'message' => 'メンバーシップオプションの更新に失敗しました。',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * メンバーシップオプション削除処理
     * 
     * @param MembershipOption $membershipOption
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function destroy(MembershipOption $membershipOption): RedirectResponse
    {
        try {
            DB::transaction(function () use ($membershipOption) {
                $membershipOption->delete();
            });

            return to_route('admin.membershipOption.index')->with([
                'message' => 'メンバーシップオプションの削除に成功しました。'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.membershipOption.index')->with([
                'message' => 'メンバーシップオプションの削除に失敗しました。'
            ]);
        }
    }
}
