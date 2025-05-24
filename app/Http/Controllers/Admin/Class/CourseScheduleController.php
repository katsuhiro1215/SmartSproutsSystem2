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
     * コーススケジュール作成画面
     * 
     * @return \Inertia\Response
     */
    public function create(Course $course): Response
    {
        return Inertia::render('Admin/Classes/Courses/Schedules/Create', [
            'course' => $course
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
        $validatedData = $request->validated();

        $courseId = $validatedData['course_id'];
        $schedules = $validatedData['schedules'];

        $successfulSchedules = [];
        $skippedSchedules = [];

        foreach ($schedules as $schedule) {
            // Carbonでdatetime型に変換（不要になったため削除）
            $startTime = $schedule['start_time'];
            $endTime = $schedule['end_time'];

            // 重複するスケジュールのチェック
            $existingSchedules = CourseSchedule::where('course_id', $courseId)
                ->where('course_date', $schedule['course_date']) // 同じ日付で
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<', $endTime) // 開始時間が重複
                        ->where('end_time', '>', $startTime); // 終了時間が重複
                })
                ->exists();

            if ($existingSchedules) {
                $skippedSchedules[] = $schedule['course_date']; // 重複している場合はスキップ
                continue;
            }

            // スケジュールを作成
            CourseSchedule::create([
                'course_id' => $courseId,
                'course_date' => $schedule['course_date'],
                'day_of_week' => $schedule['day_of_week'],
                'start_time' => $schedule['start_time'],
                'end_time' => $schedule['end_time'],
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

        return redirect()->route('admin.course.index')->with($notification);
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

    // API
    /**
     * 店舗スケジュールの取得処理 API
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchByCourse(Course $course)
    {
        $courseId = $course->id;
        // 指定された店舗のスケジュールを取得
        $schedules = CourseSchedule::where('course_id', $courseId)->get();

        return response()->json([
            'schedules' => $schedules,
        ]);
    }

    /**
     * コーススケジュールのバリデーション
     * 入力されたスケジュールが店舗の営業時間内に収まっているか確認するAPI
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateSchedule(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'course_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // 店舗スケジュールのバリデーション
        $course = Course::with('lesson.store')->findOrFail($validatedData['course_id']);
        $store = $course->lesson->store;

        if (!$store) {
            return response()->json(['error' => '店舗が見つかりません。'], 404);
        }

        $storeSchedules = $store->schedules;

        $isValid = $storeSchedules->some(function ($storeSchedule) use ($validatedData) {
            return $storeSchedule->business_date === $validatedData['course_date'] &&
                $storeSchedule->start_time <= $validatedData['start_time'] &&
                $storeSchedule->end_time >= $validatedData['end_time'];
        });

        if (!$isValid) {
            return response()->json(['error' => 'このスケジュールは店舗の営業時間外です。'], 422);
        }

        return response()->json(['success' => true]);
    }
}
