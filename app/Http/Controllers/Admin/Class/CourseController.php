<?php

namespace App\Http\Controllers\Admin\Class;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseScheduleResource;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Lesson;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }
    /**
     * コース一覧画面
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        // 1ページあたりの表示件数 (デフォルトは20件) 
        $perPage = $request->input('per_page', 20);

        // 全コースカテゴリー一覧
        $allCourses = Course::allCourses()
            ->searchKeyword($request->keyword)
            ->paginate($perPage);
        // 削除されていないコースカテゴリー一覧
        $courses = Course::withoutTrashed()
            ->searchKeyword($request->keyword)
            ->paginate($perPage);
        // 削除済みコースカテゴリー一覧
        $deletedCourses = Course::onlyTrashed()
            ->searchKeyword($request->keyword)
            ->paginate($perPage);

        return Inertia::render('Admin/Classes/Courses/Index', [
            'allCourses' => $allCourses,
            'courses' => $courses,
            'deletedCourses' => $deletedCourses,
        ]);
    }

    /**
     * コース新規登録画面
     */
    public function create()
    {
        $lessons = Lesson::select('id', 'name', 'start_date')->get()->map(function ($lesson) {
            return [
                'value' => $lesson->id,
                'label' => $lesson->name,
                'start_date' => $lesson->start_date,
            ];
        });

        $courseCategories = CourseCategory::select('id', 'name')->get()->map(function ($courseCategory) {
            return [
                'value' => $courseCategory->id,
                'label' => $courseCategory->name,
            ];
        });

        // レッスンが空の場合
        if ($lessons->isEmpty()) {
            return redirect()
                ->route('admin.lesson.create')
                ->with([
                    'message' => 'レッスンが存在しません。先にレッスンを作成してください。',
                    'status' => 'danger',
                ]);
        }

        // コースカテゴリーが空の場合
        if ($courseCategories->isEmpty()) {
            return redirect()
                ->route('admin.courseCategory.create')
                ->with([
                    'message' => 'コースカテゴリーが存在しません。先にコースカテゴリーを作成してください。',
                    'status' => 'danger',
                ]);
        }

        // 最初のレッスンのIDを取得
        $defaultLessonId = $lessons->first()['value'] ?? null;
        // 最初のコースカテゴリーのIDを取得
        $defaultCourseCategoryId = $courseCategories->first()['value'] ?? null;

        return Inertia::render('Admin/Classes/Courses/Create', [
            'lessons' => $lessons,
            'defaultLessonId' => $defaultLessonId,
            'courseCategories' => $courseCategories,
            'defaultCourseCategoryId' => $defaultCourseCategoryId,
        ]);
    }

    /**
     * コース新規登録処理
     * @param \App\Http\Requests\CourseRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable (テスト用)
     * @throws \Exception (本番用)
     */
    public function store(CourseRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('course_photo_path')) {
            $validatedData['course_photo_path'] = ImageService::uploadMiddleThumbnail($request->file('course_photo_path'), 'courses');
        }

        try {
            DB::transaction(function () use ($validatedData) {
                Course::create($validatedData);
            });

            return to_route('admin.course.index')->with([
                'message' => 'コースを登録しました。',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'コースの登録に失敗しました。',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * コース詳細画面
     * @param \App\Models\Course $course
     * @return \Inertia\Response
     */
    public function show(Course $course): Response
    {
        return Inertia::render('Admin/Classes/Courses/Show', [
            'course' => $course,
            'schedules' => $course->courseSchedules,
        ]);
    }

    /**
     * コース編集画面
     * @param \App\Models\Course $course
     * @return \Inertia\Response
     */
    public function edit(Course $course): Response
    {
        $lessons = Lesson::select('id', 'name', 'start_date')->get()->map(function ($lesson) {
            return [
                'value' => $lesson->id,
                'label' => $lesson->name,
                'start_date' => $lesson->start_date,
            ];
        });

        $courseCategories = CourseCategory::select('id', 'name')->get()->map(function ($courseCategory) {
            return [
                'value' => $courseCategory->id,
                'label' => $courseCategory->name,
            ];
        });

        return Inertia::render('Admin/Classes/Courses/Edit', [
            'course' => $course,
            'lessons' => $lessons,
            'courseCategories' => $courseCategories,
        ]);
    }

    /**
     * コース編集処理
     * @param \App\Http\Requests\CourseRequest $request
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable (テスト用)
     * @throws \Exception (本番用)
     */
    public function update(CourseRequest $request, Course $course): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('course_photo_path')) {
            $validatedData['course_photo_path'] = ImageService::uploadMiddleThumbnail($request->file('course_photo_path'), 'courses');
        }

        try {
            DB::transaction(function () use ($validatedData, $course) {
                $course->update($validatedData);
            });

            return to_route('admin.course.index')->with([
                'message' => 'コースを更新しました。',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'コースの更新に失敗しました。',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * コース削除処理
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable (テスト用)
     * @throws \Exception (本番用)
     */
    public function destroy(Course $course): RedirectResponse
    {
        try {
            DB::transaction(function () use ($course) {
                $course->delete();
            });

            return to_route('admin.course.index')->with([
                'message' => 'コースを削除しました。',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'コースの削除に失敗しました。',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * コース復元処理
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable (テスト用)
     * @throws \Exception (本番用)
     */
    public function restore(Course $course): RedirectResponse
    {
        try {
            DB::transaction(function () use ($course) {
                $course->restore();
            });

            return to_route('admin.course.index')->with([
                'message' => 'コースを復元しました。',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'コースの復元に失敗しました。',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * コース完全削除処理
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable (テスト用)
     * @throws \Exception (本番用)
     */
    public function forceDelete(Course $course): RedirectResponse
    {
        try {
            DB::transaction(function () use ($course) {
                $course->forceDelete();
            });

            return to_route('admin.course.index')->with([
                'message' => 'コースを完全に削除しました。',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'コースの完全削除に失敗しました。',
                'status' => 'danger',
            ]);
        }
    }
}
