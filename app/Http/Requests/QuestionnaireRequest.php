<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionnaireRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:200'],
            'main_description' => ['required', 'max:800'],
            'sub_description' => ['nullable', 'max:800'],
            'annotation' => ['nullable', 'max:600'],
            'questionnaire_photo_path' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'status' => ['required', 'boolean', 'in:0,1'],
            'start_date' => ['required', 'date', 'date_format:Y-m-d'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_date' => ['required', 'date', 'date_format:Y-m-d'],
            'end_time' => ['required', 'date_format:H:i'],
        ];
    }

    /**
     * カスタム属性名を定義
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'アンケート設問名',
            'main_description' => 'アンケート設問内容',
            'sub_description' => 'アンケート設問の補足説明',
            'annotation' => 'アンケート設問の注釈',
        ];
    }

    /**
     * カスタムエラーメッセージを定義
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'questionnaire_photo_path.mimes' => 'アンケート設問の画像はjpg、jpeg、png形式の画像ファイルで指定してください。',
        ];
    }
}
