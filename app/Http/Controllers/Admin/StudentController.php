<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\MembershipOption;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;


class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    /**
     * 生徒一覧画面
     * 
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        // 1ページあたりの表示件数 (デフォルトは20件)
        $perPage = $request->input('per_page', 20);

        // 全生徒一覧
        $allStudents = StudentResource::collection (
            Student::with('membershipOption')
                ->allStudents()
                ->searchKeyword($request->keyword)
                ->paginate($perPage)
        );
        // 削除されていない生徒一覧
        $students = StudentResource::collection (
            Student::with('membershipOption')
                ->withoutTrashed()
                ->searchKeyword($request->keyword)
                ->paginate($perPage)
        );
        // 削除済み生徒一覧
        $deletedStudents = StudentResource::collection (
            Student::with('membershipOption')
                ->onlyTrashed()
                ->searchKeyword($request->keyword)
                ->paginate($perPage)
        );
        
        return Inertia::render('Admin/Users/Students/Index', [
            'allStudents' => $allStudents,
            'students' => $students,
            'deletedStudents' => $deletedStudents,
        ]);
    }

    /**
     * 生徒作成画面
     * 
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        $membershipOptions = MembershipOption::select('id', 'name')->get()->map(function ($membershipOption) {
            return [
                'value' => $membershipOption->id,
                'label' => $membershipOption->name,
            ];
        });

        return Inertia::render('Admin/Users/Students/Create',[
            'membershipOptions' => $membershipOptions,
        ]);
    }

    /**
     * 生徒登録処理
     * 
     * @param StudentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StudentRequest $request): RedirectResponse
    {
        // バリデーション済みのデータを取得
        $validated = $request->validated();
        // トランザクションを開始
        try {
            DB::transaction(function () use ($validated) {
                Student::create($validated);
            });

            return to_route('admin.student.index')->with([
                'message' => '生徒を登録しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => '生徒の登録に失敗しました',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * 生徒詳細画面
     * 
     * @param Student $student
     * @return \Inertia\Response
     */
    public function show(Student $student): Response
    {
        $student->membershipOption()->select('id', 'name')->get()->map(function ($membershipOption) {
            return [
                'value' => $membershipOption->id,
                'label' => $membershipOption->name,
            ];
        });

        $users = $student->users()->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ];
        });

        $guardians = $student->users()->with('guardians')->get()->flatMap(function ($user) {
            return $user->guardians->map(function ($guardian) {
                return [
                    'id' => $guardian->id,
                    'full_name' => $guardian->lastname . ' ' . $guardian->firstname,
                    'relationship' => $guardian->relationship,
                    'mobile_number' => $guardian->mobile_number,
                ];
            });
        });

        return Inertia::render('Admin/Users/Students/Show', [
            'student' => new StudentResource($student),
            'users' => $users,
            'guardians' => $guardians,
        ]);
    }

    /**
     * 生徒編集画面
     * 
     * @param Student $student
     * @return \Inertia\Response
     */
    public function edit(Student $student): Response
    {
        $membershipOptions = MembershipOption::select('id', 'name')->get()->map(function ($membershipOption) {
            return [
                'value' => $membershipOption->id,
                'label' => $membershipOption->name,
            ];
        });

        return Inertia::render('Admin/Users/Students/Edit', [
            'membershipOptions' => $membershipOptions,
            'student' => $student,
        ]);
    }

    /**
     * 生徒更新処理
     * 
     * @param StudentRequest $request
     * @param Student $student
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function update(StudentRequest $request, Student $student): RedirectResponse
    {
        // バリデーション済みのデータを取得
        $validated = $request->validated();
        // トランザクションを開始
        try {
            DB::transaction(function () use ($validated, $student) {
                $student->update($validated);
            });

            return to_route('admin.student.index')->with([
                'message' => '生徒を更新しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => '生徒の更新に失敗しました',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * 生徒削除処理
     * 
     * @param Student $student
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Student $student): RedirectResponse
    {
        // トランザクションを開始
        try {
            DB::transaction(function () use ($student) {
                $student->delete();
            });

            return to_route('admin.student.index')->with([
                'message' => '生徒を削除しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => '生徒の削除に失敗しました',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * 生徒復活処理
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $student = Student::onlyTrashed()->find($id);

        if (!$student) {
            return redirect()->back()->with([
                'message' => '生徒が見つかりません',
                'status' => 'danger',
            ]);
        }

        try {
            DB::transaction(function () use ($student) {
                $student->restore();
            });

            return to_route('admin.student.index')->with([
                'message' => '生徒を復活しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => '生徒の復活に失敗しました',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * 生徒完全削除処理
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        $student = Student::onlyTrashed()->find($id);

        if (!$student) {
            return redirect()->back()->with([
                'message' => '生徒が見つかりません',
                'status' => 'danger',
            ]);
        }

        try {
            DB::transaction(function () use ($student) {
                $student->forceDelete();
            });

            return to_route('admin.student.index')->with([
                'message' => '生徒を完全削除しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => '生徒の完全削除に失敗しました',
                'status' => 'danger',
            ]);
        }
    }
}
