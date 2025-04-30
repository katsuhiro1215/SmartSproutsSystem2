<?php

namespace App\Http\Controllers\Admin\Class;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonRequest;
use App\Models\Lesson;
use App\Models\Store;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1ページあたりの表示件数 (デフォルトは20件) 
        $perPage = request()->input('per_page', 20);
        // 全レッスン一覧
        $allLessons = Lesson::allLessons()
            ->searchKeyword(request()->keyword)
            ->paginate($perPage);
        // 削除されていないレッスン一覧
        $lessons = Lesson::withoutTrashed()
            ->searchKeyword(request()->keyword)
            ->paginate($perPage);
        // 削除済みレッスン一覧
        $deletedLessons = Lesson::onlyTrashed()
            ->searchKeyword(request()->keyword)
            ->paginate($perPage);

        return Inertia::render('Admin/Classes/Lessons/Index', [
            'allLessons' => $allLessons,
            'lessons' => $lessons,
            'deletedLessons' => $deletedLessons,
        ]);
    }

    /**
     * レッスン新規登録画面
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        $stores = Store::select('id', 'name', 'established_date')->get()->map(function ($store) {
            return [
                'value' => $store->id,
                'label' => $store->name,
                'established_date' => $store->established_date,
            ];
        });
        // 最初の店舗のIDを取得
        $defaultStoreId = $stores->first()['value'] ?? null;

        return Inertia::render('Admin/Classes/Lessons/Create', [
            'stores' => $stores,
            'defaultStoreId' => $defaultStoreId,
        ]);
    }

    /**
     * レッスン新規登録処理
     * @param \App\Http\Requests\LessonRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     * @throws \Exception
     */
    public function store(LessonRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('lesson_photo_path')) {
            $validatedData['lesson_photo_path'] = ImageService::uploadMiddleThumbnail($request->file('lesson_photo_path'), 'lessons');
        }

        try {
            DB::transaction(function () use ($validatedData) {
                Lesson::create($validatedData);
            });

            return to_route('admin.lesson.index')->with([
                'message' => 'レッスンを登録しました。',
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'レッスンの登録に失敗しました。',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * レッスン詳細画面
     * @param \App\Models\Lesson $lesson
     * @return \Inertia\Response
     */
    public function show(Lesson $lesson): Response
    {
        return Inertia::render('Admin/Classes/Lessons/Show', [
            'lesson' => $lesson,
        ]);
    }

    /**
     * レッスン編集画面
     * @param \App\Models\Lesson $lesson
     * @return \Inertia\Response
     */
    public function edit(Lesson $lesson): Response
    {
        $stores = Store::select('id', 'name', 'established_date')->get()->map(function ($store) {
            return [
                'value' => $store->id,
                'label' => $store->name,
                'established_date' => $store->established_date,
            ];
        });

        return Inertia::render('Admin/Classes/Lessons/Edit', [
            'lesson' => $lesson,
            'stores' => $stores,
        ]);
    }

    /**
     * レッスン更新処理
     * @param \App\Http\Requests\LessonRequest $request
     * @param \App\Models\Lesson $lesson
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function update(LessonRequest $request, Lesson $lesson): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('lesson_photo_path')) {
            $validatedData['lesson_photo_path'] = ImageService::uploadMiddleThumbnail($request->file('lesson_photo_path'), 'lessons');
        }

        try {
            DB::transaction(function () use ($validatedData, $lesson) {
                $lesson->update($validatedData);
            });

            return to_route('admin.lesson.index')->with([
                'message' => 'レッスンの更新に成功しました',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with([
                'message' => 'レッスンの更新に失敗しました',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * レッスン削除処理
     * @param \App\Models\Lesson $lesson
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function destroy(Lesson $lesson): RedirectResponse
    {

        try {
            DB::transaction(function () use ($lesson) {
                $lesson->delete();
            });

            return to_route('admin.lesson.index')->with([
                'message' => 'レッスンの削除に成功しました。',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.lesson.index')->with([
                'message' => 'レッスンの削除に失敗しました。',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Lesson $lesson)
    {
        try {
            DB::transaction(function () use ($lesson) {
                $lesson->restore();
            });

            return to_route('admin.lesson.index')->with([
                'message' => 'レッスンの復元に成功しました。',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.lesson.index')->with([
                'message' => 'レッスンの復元に失敗しました。',
                'status' => 'danger',
            ]);
        }
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(Lesson $lesson)
    {
        try {
            DB::transaction(function () use ($lesson) {
                $lesson->forceDelete();
            });

            return to_route('admin.lesson.index')->with([
                'message' => 'レッスンの完全削除に成功しました。',
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.lesson.index')->with([
                'message' => 'レッスンの完全削除に失敗しました。',
                'status' => 'danger',
            ]);
        }
    }
}
