<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    /**
     * イベント一覧画面
     * 
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        // 全店舗一覧
        $allEvents = EventResource::collection(
            Event::allEvents()->get()
        );
        // 削除されていない店舗一覧
        $events = EventResource::collection(
            Event::withoutTrashed()->get()
        );
        // 削除済み店舗一覧
        $deletedEvents = EventResource::collection(
            Event::onlyTrashed()->get()
        );

        return Inertia::render('Admin/Events/Index', [
            'allEvents' => $allEvents,
            'events' => $events,
            'deletedEvents' => $deletedEvents,
        ]);
    }

    /**
     * イベント作成画面
     * 
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Events/Create');
    }

    /**
     * イベント登録処理
     * 
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function store(EventRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        // 郵便番号のハイフンを除去
        $validatedData['postalcode'] = str_replace('-', '', $validatedData['postalcode']);
        // 画像のアップロード
        if ($request->hasFile('event_photo_path')) {
            $validatedData['event_photo_path'] = ImageService::uploadMiddleThumbnail($request->file('event_photo_path'), 'events');
        }

        try {
            DB::transasaction(function () use ($validatedData) {
                Event::create($validatedData);
            });

            return to_route('admin.event.index')->with([
                'message' => 'イベントの作成に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.event.create')->with([
                'message' => 'イベントの作成に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * イベント詳細画面
     * 
     * @param Event $event
     * @return \Inertia\Response
     */
    public function show(Event $event): Response
    {
        // 住所の結合
        $event->full_address = $event->prefecture . ' ' .
            $event->city . ' ' .
            $event->address2 . ' ' .
            $event->address1;
        // 郵便番号のハイフンを追加
        $event->postalcode = substr($event->postalcode, 0, 3) . '-' . substr($event->postalcode, 3);

        return Inertia::render('Admin/Events/Show', [
            'event' => new EventResource($event),
        ]);
    }

    /**
     * イベント編集画面
     * 
     * @param Event $event
     * @return \Inertia\Response
     */
    public function edit(Event $event): Response
    {
        return Inertia::render('Admin/Events/Edit', [
            'event' => $event,
        ]);
    }

    /**
     * イベント更新処理
     * 
     * @param EventRequest $request
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Throwable
     */
    public function update(EventRequest $request, Event $event): RedirectResponse
    {
        $validatedData = $request->validated();
        // 郵便番号のハイフンを除去
        $validatedData['postalcode'] = str_replace('-', '', $validatedData['postalcode']);
        // 画像のアップロード
        if ($request->hasFile('event_photo_path')) {
            $validatedData['event_photo_path'] = ImageService::uploadMiddleThumbnail($request->file('event_photo_path'), 'events');
        }

        try {
            DB::transaction(function () use ($validatedData, $event) {
                $event->update($validatedData);
            });

            return to_route('admin.event.index')->with([
                'message' => 'イベントの更新に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.event.edit', $event)->with([
                'message' => 'イベントの更新に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * イベント削除処理
     * 
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Event $event): RedirectResponse
    {
        try {
            DB::transaction(function () use ($event) {
                $event->delete();
            });

            return to_route('admin.event.index')->with([
                'message' => 'イベントの削除に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.event.index')->with([
                'message' => 'イベントの削除に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * イベント復元処理
     * 
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Event $event)
    {
        try {
            DB::transaction(function () use ($event) {
                $event->restore();
            });

            return to_route('admin.event.index')->with([
                'message' => 'イベントの復元に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.event.index')->with([
                'message' => 'イベントの復元に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * イベント完全削除処理
     * 
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Event $event)
    {
        try {
            DB::transaction(function () use ($event) {
                $event->forceDelete();
            });

            return to_route('admin.event.index')->with([
                'message' => 'イベントの完全削除に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.event.index')->with([
                'message' => 'イベントの完全削除に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }
}
