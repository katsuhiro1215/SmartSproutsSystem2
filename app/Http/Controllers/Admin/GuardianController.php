<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\GuardianResource;
use App\Http\Requests\GuardianRequest;
use Illuminate\Http\Request;
use App\Models\Guardian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

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
    public function index(Request $request): Response
    {
        // 1ページあたりの表示件数 (デフォルトは20件)
        $perPage = $request->input('per_page', 20);

        // 全生徒一覧
        $allGuardians = GuardianResource::collection(
            Guardian::allGuardians()
                ->searchKeyword($request->keyword)
                ->paginate($perPage)
        );
        // 削除されていない生徒一覧
        $guardians = GuardianResource::collection(
            Guardian::withoutTrashed()
                ->searchKeyword($request->keyword)
                ->paginate($perPage)
        );
        // 削除済み生徒一覧
        $deletedGuardians = GuardianResource::collection(
            Guardian::onlyTrashed()
                ->searchKeyword($request->keyword)
                ->paginate($perPage)
        );

        return Inertia::render('Admin/Users/Guardians/Index', [
            'allGuardians' => $allGuardians,
            'guardians' => $guardians,
            'deletedGuardians' => $deletedGuardians,
        ]);
    }

    /**
     * 保護者作成画面
     * 
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Users/Guardians/Create', [
        ]);
    }

    /**
     * 保護者登録処理
     * 
     * @param GuardianRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GuardianRequest $request): RedirectResponse
    {
        // バリデーション済みのデータを取得
        $validated = $request->validated();
        // トランザクションを開始
        try {
            DB::transaction(function () use ($validated) {
                Guardian::create($validated);
            });

            return to_route('admin.guardian.index')->with([
                'message' => '保護者を登録しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => '保護者の登録に失敗しました',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * 保護者詳細画面
     * 
     * @param Guardian $guardian
     * @return \Inertia\Response
     */
    public function show(Guardian $guardian): Response
    {
        $users = $guardian->users()->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ];
        });

        $students = $guardian->users()->with('students')->get()->flatMap(function ($user) {
            return $user->students->map(function ($student) {
                return [
                    'id' => $student->id,
                    'full_name' => $student->lastname . ' ' . $student->firstname,
                ];
            });
        });

        return Inertia::render('Admin/Users/Guardians/Show', [
            'guardian' => new GuardianResource($guardian),
            'users' => $users,
            'students' => $students,
        ]);
    }

    /**
     * 保護者編集画面
     * 
     * @param Guardian $guardian
     * @return \Inertia\Response
     */
    public function edit(Guardian $guardian): Response
    {
        return Inertia::render('Admin/Users/Guardians/Edit', [
            'guardian' => $guardian,
        ]);
    }

    /**
     * 保護者更新処理
     * 
     * @param GuardianRequest $request
     * @param Guardian $guardian
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function update(GuardianRequest $request, Guardian $guardian): RedirectResponse
    {
        // バリデーション済みのデータを取得
        $validated = $request->validated();
        // トランザクションを開始
        try {
            DB::transaction(function () use ($validated, $guardian) {
                $guardian->update($validated);
            });

            return to_route('admin.guardian.index')->with([
                'message' => '保護者を更新しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => '保護者の更新に失敗しました',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * 保護者削除処理
     * 
     * @param Guardian $guardian
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Guardian $guardian): RedirectResponse
    {
        // トランザクションを開始
        try {
            DB::transaction(function () use ($guardian) {
                $guardian->delete();
            });

            return to_route('admin.guardian.index')->with([
                'message' => '保護者を削除しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => '保護者の削除に失敗しました',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * 保護者復活処理
     * 
     * @param Guardian $guardian
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $guardian = Guardian::onlyTrashed()->find($id);

        if (!$guardian) {
            return redirect()->back()->with([
                'message' => '生徒が見つかりません',
                'status' => 'danger',
            ]);
        }

        try {
            DB::transaction(function () use ($guardian) {
                $guardian->restore();
            });

            return to_route('admin.guardian.index')->with([
                'message' => '保護者を復活しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => '保護者の復活に失敗しました',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * 保護者完全削除処理
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        $guardian = Guardian::onlyTrashed()->find($id);

        if (!$guardian) {
            return redirect()->back()->with([
                'message' => '保護者が見つかりません',
                'status' => 'danger',
            ]);
        }

        try {
            DB::transaction(function () use ($guardian) {
                $guardian->forceDelete();
            });

            return to_route('admin.guardian.index')->with([
                'message' => '保護者を完全削除しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => '保護者の完全削除に失敗しました',
                'status' => 'danger',
            ]);
        }
    }
}
