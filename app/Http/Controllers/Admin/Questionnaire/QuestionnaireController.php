<?php

namespace App\Http\Controllers\Admin\Questionnaire;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionnaireRequest;
use App\Http\Resources\QuestionnaireResource;
use App\Models\Questionnaire;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class QuestionnaireController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    /**
     * アンケート一覧画面
     * 
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        // 1ページあたりの表示件数 (デフォルトは20件)
        $perPage = $request->input('per_page', 20);

        // 全アンケート一覧
        $allEvents = QuestionnaireResource::collection(
            Questionnaire::allQuestionnaires()->paginate($perPage)
        );
        // 削除されていないアンケート一覧
        $events = QuestionnaireResource::collection(
            Questionnaire::withoutTrashed()->paginate($perPage)
        );
        // 削除済みアンケート一覧
        $deletedQuestionnaires = QuestionnaireResource::collection(
            Questionnaire::onlyTrashed()->paginate($perPage)
        );

        return Inertia::render('Admin/Questionnaires/Index', [
            'allQuestionnaires' => $allEvents,
            'questionnaires' => $events,
            'deletedQuestionnaires' => $deletedQuestionnaires,
        ]);
    }

    /**
     * アンケート作成画面
     * 
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Questionnaires/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionnaireRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        // 画像のアップロード
        if ($request->hasFile('questionnaire_photo_path')) {
            $validatedData['questionnaire_photo_path'] = ImageService::uploadMiddleThumbnail($request->file('questionnaire_photo_path'), 'events');
        }

        try {
            DB::transasaction(function () use ($validatedData) {
                Questionnaire::create($validatedData);
            });

            return to_route('admin.questionnaire.index')->with([
                'message' => 'アンケートの作成に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.questionnaire.create')->with([
                'message' => 'アンケートの作成に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * アンケート詳細画面
     * 
     * @param Questionnaire $questionnaire
     * @return \Inertia\Response
     */
    public function show(Questionnaire $questionnaire): Response
    {
        return Inertia::render('Admin/Questionnaires/Show', [
            'questionnaire' => $questionnaire,
        ]);
    }

    /**
     * アンケート編集画面
     * 
     * @param Questionnaire $questionnaire
     * @return \Inertia\Response
     */
    public function edit(Questionnaire $questionnaire): Response
    {
        return Inertia::render('Admin/Questionnaires/Edit', [
            'questionnaire' => $questionnaire,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionnaireRequest $request, Questionnaire $questionnaire)
    {
        $validatedData = $request->validated();

        // 画像のアップロード
        if ($request->hasFile('questionnaire_photo_path')) {
            $validatedData['questionnaire_photo_path'] = ImageService::uploadMiddleThumbnail($request->file('questionnaire_photo_path'), 'events');
        }

        try {
            DB::transaction(function () use ($validatedData, $questionnaire) {
                $questionnaire->update($validatedData);
            });

            return to_route('admin.questionnaire.index')->with([
                'message' => 'アンケートの更新に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.questionnaire.edit', $questionnaire)->with([
                'message' => 'アンケートの更新に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * アンケート削除処理
     * 
     * @param Questionnaire $questionnaire
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Questionnaire $questionnaire): RedirectResponse
    {
        try {
            DB::transaction(function () use ($questionnaire) {
                $questionnaire->delete();
            });

            return to_route('admin.questionnaire.index')->with([
                'message' => 'アンケートの削除に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.questionnaire.index')->with([
                'message' => 'アンケートの削除に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * アンケート復元処理
     * 
     * @param Questionnaire $questionnaire
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Questionnaire $questionnaire): RedirectResponse
    {
        try {
            DB::transaction(function () use ($questionnaire) {
                $questionnaire->restore();
            });

            return to_route('admin.questionnaire.index')->with([
                'message' => 'アンケートの復元に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.questionnaire.index')->with([
                'message' => 'アンケートの復元に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }

    /**
     * アンケート完全削除処理
     * 
     * @param Questionnaire $questionnaire
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Questionnaire $questionnaire): RedirectResponse
    {
        try {
            DB::transaction(function () use ($questionnaire) {
                $questionnaire->forceDelete();
            });

            return to_route('admin.questionnaire.index')->with([
                'message' => 'アンケートの完全削除に成功しました。',
                'status' => 'success'
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return to_route('admin.questionnaire.index')->with([
                'message' => 'アンケートの完全削除に失敗しました。',
                'status' => 'danger'
            ]);
        }
    }
}
