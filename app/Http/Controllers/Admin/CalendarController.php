<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseSchedule;
use Illuminate\Http\Request;
use App\Models\Store;
use Inertia\Inertia;
use Inertia\Response;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    public function search(Request $request): Response
    {
        // 検索結果のデータを取得
        return Inertia::render('Admin/Calendar/Search');
    }

    public function yearly(Request $request): Response
    {
        // 年間スケジュールのデータを取得
        return Inertia::render('Admin/Calendar/Yearly');
    }

    public function monthly(Request $request): Response
    {
        $year = $request->query('year', now()->year);
        $month = $request->query('month', now()->month);

        $schedules = CourseSchedule::whereYear('start_time', $year)
            ->whereMonth('start_time', $month)
            ->get();

        return Inertia::render('Admin/Calendar/Monthly', [
            'schedules' => $schedules,
            'year' => $year,
            'month' => $month,
        ]);
    }

    public function weekly(Request $request): Response
    {
        // 週間スケジュールのデータを取得
        return Inertia::render('Admin/Calendar/Weekly');
    }

    public function daily(Request $request): Response
    {
        $date = $request->query('date', now()->toDateString());

        $schedules = CourseSchedule::whereDate('start_time', $date)->get();

        return Inertia::render('Admin/Calendar/Daily', [
            'schedules' => $schedules,
            'date' => $date,
        ]);
    }

    // 各店舗の年間カレンダー
    public function storeYearly(Request $request, Store $store): Response
    {
        $year = $request->query('year', now()->year);

        $schedules = CourseSchedule::where('store_id', $store->id)
            ->whereYear('start_time', $year)
            ->get();

        return Inertia::render('Admin/Calendar/StoreYearly', [
            'schedules' => $schedules,
            'store' => $store,
            'year' => $year,
        ]);
    }

    // 各店舗の月間カレンダー
    public function storeMonthly(Request $request, Store $store): Response
    {
        $year = $request->query('year', now()->year);
        $month = $request->query('month', now()->month);

        $schedules = CourseSchedule::where('store_id', $store->id)
            ->whereYear('start_time', $year)
            ->whereMonth('start_time', $month)
            ->get();

        return Inertia::render('Admin/Calendar/StoreMonthly', [
            'schedules' => $schedules,
            'store' => $store,
            'year' => $year,
            'month' => $month,
        ]);
    }

    // 各店舗の週間カレンダー
    public function storeWeekly(Request $request, Store $store): Response
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $schedules = CourseSchedule::where('store_id', $store->id)
            ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
            ->get();

        return Inertia::render('Admin/Calendar/StoreWeekly', [
            'schedules' => $schedules,
            'store' => $store,
        ]);
    }

    // 各店舗の1日のカレンダー
    public function storeDaily(Request $request, Store $store): Response
    {
        $date = $request->query('date', now()->toDateString());

        $schedules = CourseSchedule::where('store_id', $store->id)
            ->whereDate('start_time', $date)
            ->get();

        return Inertia::render('Admin/Calendar/StoreDaily', [
            'schedules' => $schedules,
            'store' => $store,
            'date' => $date,
        ]);
    }
}
