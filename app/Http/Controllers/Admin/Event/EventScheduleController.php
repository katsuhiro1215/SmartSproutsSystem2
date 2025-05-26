<?php

namespace App\Http\Controllers\Admin\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventScheduleRequest;
use App\Http\Requests\UpdateEventScheduleRequest;
use App\Http\Resources\EventScheduleResource;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventSchedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class EventScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    /**
     * イベントスケジュール作成画面
     * 
     * @param Event $event
     * @return \Inertia\Response
     */
    public function create(Event $event)
    {
        return Inertia::render('Admin/Events/Schedules/Create', [
            'event' => $event
        ]);
    }

    /**
     * イベントスケジュール登録処理 (複数登録)
     * 
     * @param StoreEventScheduleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function store(StoreEventScheduleRequest $request)
    {
        $validatedData = $request->validated();

        $eventId = $validatedData['event_id'];
        $schedules = $validatedData['schedules'];

        $successfulSchedules = [];
        $skippedSchedules = [];

        foreach ($schedules as $schedule) {
            // Carbonでdatetime型に変換（不要になったため削除）
            $startTime = $schedule['start_time'];
            $endTime = $schedule['end_time'];

            // 重複するスケジュールのチェック
            $existingSchedules = EventSchedule::where('event_id', $eventId)
                ->where('event_date', $schedule['event_date']) // 同じ日付で
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<', $endTime) // 開始時間が重複
                        ->where('end_time', '>', $startTime); // 終了時間が重複
                })
                ->exists();

            if ($existingSchedules) {
                $skippedSchedules[] = $schedule['event_date']; // 重複している場合はスキップ
                continue;
            }

            // スケジュールを作成
            EventSchedule::create([
                'event_id' => $eventId,
                'event_date' => $schedule['event_date'],
                'day_of_week' => $schedule['day_of_week'],
                'start_time' => $schedule['start_time'],
                'end_time' => $schedule['end_time'],
                'status' => $schedule['status'],
            ]);

            $successfulSchedules[] = $schedule['event_date'];
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

        return redirect()->route('admin.event.index')->with($notification);
    }

    /**
     * イベントスケジュール詳細画面
     * 
     * @param EventSchedule $eventSchedule
     * @return \Inertia\Response
     */
    public function show(EventSchedule $eventSchedule): Response
    {
        return Inertia::render('Admin/Events/Schedules/Show', [
            'eventSchedule' => new EventScheduleResource($eventSchedule),
        ]);
    }

    /**
     * イベントスケジュール編集画面
     * 
     * @param EventSchedule $eventSchedule
     * @return \Inertia\Response
     */
    public function edit(EventSchedule $eventSchedule): Response
    {
        return Inertia::render('Admin/Events/Schedules/Edit', [
            'eventSchedule' => new EventScheduleResource($eventSchedule),
        ]);
    }

    /**
     * イベントスケジュールの更新処理(単体更新)
     * 
     * @param UpdateEventScheduleRequest $request
     * @param EventSchedule $eventSchedule
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function update(UpdateEventScheduleRequest $request, EventSchedule $eventSchedule)
    {
        $validatedData = $request->validated();

        try {
            DB::transaction(function () use ($validatedData, $eventSchedule) {
                $eventSchedule->update($validatedData);
            });

            return to_route('admin.eventSchedule.index')->with([
                'message' => 'イベントケジュールの更新に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.eventSchedule.edit', $eventSchedule)->with([
                'message' => 'イベントスケジュールの更新に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * イベントスケジュールの削除処理
     * 
     * @param EventSchedule $eventSchedule
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function destroy(EventSchedule $eventSchedule)
    {
        try {
            DB::transaction(function () use ($eventSchedule) {
                $eventSchedule->delete();
            });

            return to_route('admin.eventSchedule.index')->with([
                'message' => 'イベントスケジュールの削除に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.eventSchedule.index')->with([
                'message' => 'イベントスケジュールの削除に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * イベントスケジュールの一括登録画面
     * 
     * @param Request $request
     * @return \Inertia\Response
     */
    public function bulkCreate(): Response
    {
        return Inertia::render('Admin/Events/Schedules/BulkCreate');
    }

    // API
    /**
     * イベントスケジュールの取得処理 API
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchByEvent(Event $event)
    {
        $eventId = $event->id;
        // 指定された店舗のスケジュールを取得
        $schedules = EventSchedule::where('event_id', $eventId)->get();

        return response()->json([
            'schedules' => $schedules,
        ]);
    }

    /**
     * イベントスケジュールのバリデーション
     * 入力されたスケジュールが店舗の営業時間内に収まっているか確認するAPI
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateSchedule(Request $request)
    {
        $validatedData = $request->validate([
            'event_id' => 'required|exists:events,id',
            'event_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // イベントスケジュールのバリデーション
        $event = Event::findOrFail($validatedData['event_id']);
        $store = $event->store;

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
