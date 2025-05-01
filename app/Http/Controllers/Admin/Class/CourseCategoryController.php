<?php

namespace App\Http\Controllers\Admin\Class;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseCategoryRequest;
use App\Models\CourseCategory;
use App\Models\Lesson;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class CourseCategoryController extends Controller
{
    /**
     * コースカテゴリー一覧画面
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        // 1ページあたりの表示件数 (デフォルトは20件) 
        $perPage = request()->input('per_page', 20);
        // 全コースカテゴリー一覧
        $allCourseCategories = CourseCategory::allCourseCategories()
            ->searchKeyword(request()->keyword)
            ->paginate($perPage);
        // 削除されていないコースカテゴリー一覧
        $courseCategories = CourseCategory::withoutTrashed()
            ->searchKeyword(request()->keyword)
            ->paginate($perPage);
        // 削除済みコースカテゴリー一覧
        $deletedCourseCategories = CourseCategory::onlyTrashed()
            ->searchKeyword(request()->keyword)
            ->paginate($perPage);

        return Inertia::render('Admin/Classes/Courses/Categories/Index', [
            'allCourseCategories' => $allCourseCategories,
            'courseCategories' => $courseCategories,
            'deletedCourseCategories' => $deletedCourseCategories,
        ]);
    }

    /**
     * コースカテゴリー新規登録画面
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        $lessons = Lesson::select('id', 'name', 'start_date')->get()->map(function ($lesson) {
            return [
                'value' => $lesson->id,
                'label' => $lesson->name,
                'start_date' => $lesson->start_date,
            ];
        });
        // 最初のレッスンのIDを取得
        $defaultLessonId = $lessons->first()['value'] ?? null;

        return Inertia::render('Admin/Classes/Courses/Categories/Create', [
            'lessons' => $lessons,
            'defaultLessonId' => $defaultLessonId,
        ]);
    }

    /**
     * コースカテゴリー新規登録処理
     * @param \App\Http\Requests\CourseCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable (テスト用)
     * @throws \Exception (本番用)
     */
    public function store(CourseCategoryRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('course_category_photo_path')) {
            $validatedData['course_category_photo_path'] = ImageService::uploadMiddleThumbnail($request->file('course_category_photo_path'), 'courseCategories');
        }

        try {
            DB::transaction(function () use ($validatedData) {
                CourseCategory::create($validatedData);
            });

            return to_route('admin.courseCategory.index')->with([
                'message' => 'コースカテゴリーを登録しました。',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'コースカテゴリーの登録に失敗しました。',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * コースカテゴリー詳細画面
     * @param \App\Models\CourseCategory $courseCategory
     * @return \Inertia\Response
     */
    public function show(CourseCategory $courseCategory): Response
    {
        return Inertia::render('Admin/Classes/Courses/Categories/Show', [
            'courseCategory' => $courseCategory,
        ]);
    }

    /**
     * コースカテゴリー編集画面
     * @param \App\Models\CourseCategory $courseCategory
     * @return \Inertia\Response
     */
    public function edit(CourseCategory $courseCategory): Response
    {
        $lessons = Lesson::select('id', 'name', 'start_date')->get()->map(function ($lesson) {
            return [
                'value' => $lesson->id,
                'label' => $lesson->name,
                'start_date' => $lesson->start_date,
            ];
        });

        return Inertia::render('Admin/Classes/Courses/Categories/Edit', [
            'courseCategory' => $courseCategory,
            'lessons' => $lessons,
        ]);
    }

    /**
     * コースカテゴリー編集処理
     * @param \App\Http\Requests\CourseCategoryRequest $request
     * @param \App\Models\CourseCategory $courseCategory
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable (テスト用)
     * @throws \Exception (本番用)
     */
    public function update(CourseCategoryRequest $request, CourseCategory $courseCategory): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('course_category_photo_path')) {
            $validatedData['course_category_photo_path'] = ImageService::uploadMiddleThumbnail($request->file('course_category_photo_path'), 'courseCategories');
        }

        try {
            DB::transaction(function () use ($validatedData, $courseCategory) {
                $courseCategory->update($validatedData);
            });

            return to_route('admin.courseCategory.index')->with([
                'message' => 'コースカテゴリーを更新しました。',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'コースカテゴリーの更新に失敗しました。',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * コースカテゴリー削除処理
     * @param \App\Models\CourseCategory $courseCategory
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable (テスト用)
     * @throws \Exception (本番用)
     */
    public function destroy(CourseCategory $courseCategory): RedirectResponse
    {
        try {
            DB::transaction(function () use ($courseCategory) {
                $courseCategory->delete();
            });

            return to_route('admin.courseCategory.index')->with([
                'message' => 'コースカテゴリーを削除しました。',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'コースカテゴリーの削除に失敗しました。',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * コースカテゴリー復元処理
     * @param \App\Models\CourseCategory $courseCategory
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable (テスト用)
     * @throws \Exception (本番用)
     */
    public function restore(CourseCategory $courseCategory): RedirectResponse
    {
        try {
            DB::transaction(function () use ($courseCategory) {
                $courseCategory->restore();
            });

            return to_route('admin.courseCategory.index')->with([
                'message' => 'コースカテゴリーを復元しました。',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'コースカテゴリーの復元に失敗しました。',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * コースカテゴリー完全削除処理
     * @param \App\Models\CourseCategory $courseCategory
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable (テスト用)
     * @throws \Exception (本番用)
     */
    public function forceDelete(CourseCategory $courseCategory): RedirectResponse
    {
        try {
            DB::transaction(function () use ($courseCategory) {
                $courseCategory->forceDelete();
            });

            return to_route('admin.courseCategory.index')->with([
                'message' => 'コースカテゴリーを完全に削除しました。',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'コースカテゴリーの完全削除に失敗しました。',
                'status' => 'danger',
            ]);
        }
    }
}
