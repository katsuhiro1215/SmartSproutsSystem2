<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoreScheduleRequest;
use App\Http\Requests\UpdateStoreScheduleRequest;
use App\Http\Resources\StoreScheduleResource;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\StoreSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class StoreScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }
    /**
     * 店舗スケジュール一覧画面
     * 
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Stores/Schedules/Index', [
            'stores' => Store::select('id', 'name')->get(),
        ]);
    }

    /**
     * 店舗スケジュール作成画面
     * 
     * @return \Inertia\Response
     */
    public function create(Store $store): Response
    {
        return Inertia::render('Admin/Stores/Schedules/Create', [
            'store' => $store
        ]);
    }

    /**
     * 店舗スケジュール登録処理 (複数登録)
     * 
     * @param StoreStoreScheduleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function store(StoreStoreScheduleRequest $request)
    {
        $validatedData = $request->validated();

        $storeId = $validatedData['store_id'];
        $schedules = $validatedData['schedules'];

        $successfulSchedules = [];
        $skippedSchedules = [];

        foreach ($schedules as $schedule) {
            // Carbonでdatetime型に変換
            $startDateTime = Carbon::parse($schedule['business_date'] . ' ' . $schedule['start_time']);
            $endDateTime = Carbon::parse($schedule['business_date'] . ' ' . $schedule['end_time']);

            // 重複するスケジュールのチェック
            $existingSchedules = StoreSchedule::where('store_id', $storeId)
                ->where(function ($query) use ($startDateTime, $endDateTime) {
                    $query->where('start_date', '<', $endDateTime)
                        ->where('end_date', '>', $startDateTime);
                })
                ->exists();

            if ($existingSchedules) {
                $skippedSchedules[] = $schedule['business_date']; // 重複している場合はスキップ
                continue;
            }

            // スケジュールを作成
            StoreSchedule::create([
                'store_id' => $storeId,
                'start_date' => $startDateTime,
                'end_date' => $endDateTime,
                'day_of_week' => $schedule['day_of_week'],
                'status' => $schedule['status'],
            ]);

            $successfulSchedules[] = $schedule['business_date'];
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

        return redirect()->route('admin.storeSchedule.index')->with($notification);
    }

    /**
     * 店舗スケジュール詳細画面
     * 
     * @param StoreSchedule $storeSchedule
     * @return \Inertia\Response
     */
    public function show(StoreSchedule $storeSchedule): Response
    {
        return Inertia::render('Admin/Stores/Schedules/Show', [
            'storeSchedule' => new StoreScheduleResource($storeSchedule),
        ]);
    }

    /**
     * 店舗スケジュール編集画面
     * 
     * @param StoreSchedule $storeSchedule
     * @return \Inertia\Response
     */
    public function edit(StoreSchedule $storeSchedule): Response
    {
        return Inertia::render('Admin/Stores/Schedules/Edit', [
            'storeSchedule' => new StoreScheduleResource($storeSchedule),
        ]);
    }

    /**
     * 店舗スケジュールの更新処理(単体更新)
     * 
     * @param UpdateStoreScheduleRequest $request
     * @param StoreSchedule $storeSchedule
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function update(UpdateStoreScheduleRequest $request, StoreSchedule $storeSchedule)
    {
        $validatedData = $request->validated();

        try {
            DB::transaction(function () use ($validatedData, $storeSchedule) {
                $storeSchedule->update($validatedData);
            });

            return to_route('admin.storeSchedule.index')->with([
                'message' => '店舗スケジュールの更新に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.storeSchedule.edit', $storeSchedule)->with([
                'message' => '店舗スケジュールの更新に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * 店舗スケジュールの削除処理
     * 
     * @param StoreSchedule $storeSchedule
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function destroy(StoreSchedule $storeSchedule)
    {
        try {
            DB::transaction(function () use ($storeSchedule) {
                $storeSchedule->delete();
            });

            return to_route('admin.storeSchedule.index')->with([
                'message' => '店舗スケジュールの削除に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.storeSchedule.index')->with([
                'message' => '店舗スケジュールの削除に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * 店舗スケジュールの一括削除画面
     * 
     * @param Request $request
     * @return \Inertia\Response
     */
    public function bulkDelete(): Response
    {
        return Inertia::render('Admin/Stores/Schedules/BulkDelete');
    }
    
    /**
     * 店舗スケジュールの取得処理 API
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchByStore($storeId)
    {
        // 指定された店舗のスケジュールを取得
        $schedules = StoreSchedule::where('store_id', $storeId)->get();

        return response()->json([
            'schedules' => $schedules,
        ]);
    }

    /**
     * 店舗スケジュールの検索処理 API
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(Request $request)
    {
        $storeId = $request->input('store_id');
        $year = $request->input('year');
        $month = $request->input('month');

        if (!$storeId || !$year || !$month) {
            return response()->json(['error' => 'Invalid parameters'], 400);
        }

        $schedules = StoreSchedule::where('store_id', $storeId)
            ->whereYear('business_date', $year)
            ->whereMonth('business_date', $month)
            ->get();

        return response()->json(['schedules' => $schedules]);
    }

    /**
     * 店舗スケジュールの一括削除処理
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:store_schedules,id',
        ]);

        $ids = $validated['ids'];

        try {
            DB::transaction(function () use ($ids) {
                StoreSchedule::destroy($ids);
            });

            return response()->json([
                'message' => '店舗スケジュールの一括削除に成功しました。',
                'status' => 'success',
                'redirect' => route('admin.storeSchedule.index'),
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => '店舗スケジュールの一括削除に失敗しました。',
                'status' => 'danger',
            ], 500);
        }
    }
}
