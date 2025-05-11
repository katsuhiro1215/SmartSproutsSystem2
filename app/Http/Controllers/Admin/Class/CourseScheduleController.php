<?php

namespace App\Http\Controllers\Admin\Class;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseScheduleRequest;
use App\Http\Requests\UpdateCourseScheduleRequest;
use App\Http\Resources\CourseScheduleResource;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSchedule;
use App\Models\Lesson;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class CourseScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }
    /**
     * コーススケジュール一覧画面
     * 
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        // 1ページあたりの表示件数 (デフォルトは20件)
        $perPage = $request->input('per_page', 20);
        // 全コーススケジュール一覧
        $allCourseSchedules = CourseScheduleResource::collection(
            CourseSchedule::with('course')->allCourseSchedules()->paginate($perPage)
        );
        // 削除されていないコーススケジュール一覧
        $courseSchedules = CourseScheduleResource::collection(
            CourseSchedule::with('course')->withoutTrashed()->paginate($perPage)
        );
        // 削除済みコーススケジュール一覧
        $deletedCourseSchedules = CourseScheduleResource::collection(
            CourseSchedule::with('course')->onlyTrashed()->paginate()
        );

        return Inertia::render('Admin/Classes/Courses/Schedules/Index', [
            'allCourseSchedules' => $allCourseSchedules,
            'courseSchedules' => $courseSchedules,
            'deletedCourseSchedules' => $deletedCourseSchedules,
        ]);
    }

    /**
     * コーススケジュール作成画面
     * 
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        $stores = Store::select('id', 'name')->get();

        $lessons = Lesson::select('id', 'name', 'store_id')->get();

        $courseCategories = CourseCategory::select('id', 'name', 'lesson_id')->get();

        $courses = Course::select('id', 'name', 'lesson_id', 'course_category_id')->get();


        return Inertia::render('Admin/Classes/Courses/Schedules/Create', [
            'stores' => $stores,
            'lessons' => $lessons,
            'courseCategories' => $courseCategories,
            'courses' => $courses,
        ]);
    }

    /**
     * コーススケジュール登録処理 (複数登録)
     * 
     * @param StoreCourseScheduleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function store(StoreCourseScheduleRequest $request)
    {
        dd($request);
        $validatedData = $request->validated();

        $courseId = $validatedData['course_id'];
        $schedules = $validatedData['schedules'];

        $successfulSchedules = [];
        $skippedSchedules = [];

        foreach ($schedules as $schedule) {
            // Carbonでdatetime型に変換
            $startDateTime = Carbon::parse($schedule['course_date'] . ' ' . $schedule['start_time']);
            $endDateTime = Carbon::parse($schedule['course_date'] . ' ' . $schedule['end_time']);

            // 重複するスケジュールのチェック
            $existingSchedules = CourseSchedule::where('course_id', $courseId)
                ->where(function ($query) use ($startDateTime, $endDateTime) {
                    $query->where('start_date', '<', $endDateTime)
                        ->where('end_date', '>', $startDateTime);
                })
                ->exists();

            if ($existingSchedules) {
                $skippedSchedules[] = $schedule['course_date']; // 重複している場合はスキップ
                continue;
            }

            // スケジュールを作成
            CourseSchedule::create([
                'course_id' => $courseId,
                'start_date' => $startDateTime,
                'end_date' => $endDateTime,
                'day_of_week' => $schedule['day_of_week'],
                'status' => $schedule['status'],
            ]);

            $successfulSchedules[] = $schedule['course_date'];
        }

        // メッセージの設定
        if (!empty($skippedSchedules)) {
            $message = '一部のスケジュールは重複していたためスキップされました。';
            $status = 'warning';
        } else {
            $message = '登録に成功しました。';
            $status = 'success';
        }

        $notification = [
            'message' => $message,
            'status' => $status,
            'skipped_schedules' => $skippedSchedules,
            'successful_schedules' => $successfulSchedules,
        ];

        return redirect()->route('admin.courseSchedule.index')->with($notification);
    }

    /**
     * コーススケジュール詳細画面
     * 
     * @param CourseSchedule $courseSchedule
     * @return \Inertia\Response
     */
    public function show(CourseSchedule $courseSchedule): Response
    {
        return Inertia::render('Admin/Classes/Courses/Schedules/Show', [
            'courseSchedule' => new CourseScheduleResource($courseSchedule),
        ]);
    }

    /**
     * コーススケジュール編集画面
     * 
     * @param CourseSchedule $courseSchedule
     * @return \Inertia\Response
     */
    public function edit(CourseSchedule $courseSchedule): Response
    {
        return Inertia::render('Admin/Classes/Courses/Schedules/Edit', [
            'courseSchedule' => new CourseScheduleResource($courseSchedule),
        ]);
    }

    /**
     * 店舗スケジュールの更新処理(単体更新)
     * 
     * @param UpdateCourseScheduleRequest $request
     * @param CourseSchedule $courseSchedule
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function update(UpdateCourseScheduleRequest $request, CourseSchedule $courseSchedule)
    {
        $validatedData = $request->validated();

        try {
            DB::transaction(function () use ($validatedData, $courseSchedule) {
                $courseSchedule->update($validatedData);
            });

            return to_route('admin.courseSchedule.index')->with([
                'message' => 'コーススケジュールの更新に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.courseSchedule.edit', $courseSchedule)->with([
                'message' => 'コーススケジュールの更新に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * コーススケジュールの削除処理
     * 
     * @param CourseSchedule $courseSchedule
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function destroy(CourseSchedule $courseSchedule)
    {
        try {
            DB::transaction(function () use ($courseSchedule) {
                $courseSchedule->delete();
            });

            return to_route('admin.courseSchedule.index')->with([
                'message' => 'コーススケジュールの削除に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.courseSchedule.index')->with([
                'message' => 'コーススケジュールの削除に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * コーススケジュールの一括登録画面
     * 
     * @param Request $request
     * @return \Inertia\Response
     */
    public function bulkCreate(): Response
    {
        return Inertia::render('Admin/Stores/Schedules/BulkCreate');
    }
}
