<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StoreSchedule;
use Illuminate\Http\Request;

class StoreScheduleController extends Controller
{
    /**
     * 店舗スケジュール一覧取得 API
     * ブラウザを更新してスケジュールを再進化するためのAPI
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $storeId = $request->query('store_id');

        $schedules = StoreSchedule::where('store_id', $storeId)
            ->orderBy('business_date')
            ->get();

        return response()->json([
            'schedules' => $schedules,
        ]);
    }

    /**
     * 店舗スケジュール登録処理
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'business_date' => 'required|date',
            'day_of_week' => 'required|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'status' => 'required|boolean',
            'note ' => 'nullable|string|max:255',
        ]);

        $schedule = StoreSchedule::create($validated);

        return response()->json([
            'schedule' => $schedule,
            'message' => 'スケジュールが登録されました。',
            'status' => 'success',
        ], 201);
    }

    /**
     * 店舗スケジュール更新処理
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'business_date' => 'required|date',
            'day_of_week' => 'required|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'status' => 'required|boolean',
            'note' => 'nullable|string|max:255',
        ]);

        $schedule = StoreSchedule::findOrFail($id);
        $schedule->update($validated);

        return response()->json([
            'message' => 'スケジュールが更新されました。',
            'schedule' => $schedule,
        ]);
    }
}
