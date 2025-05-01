<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseCategoryRequest extends FormRequest
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
            'lesson_id' => ['required', 'integer', 'exists:lessons,id'],
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'max:1000'],
            'course_category_photo_path' => ['nullable', 'image', 'mimes: jpg,jpeg,png', 'max:2048'],
            'status' => ['required', 'boolean', 'in:0,1'],
            'start_date' => ['date', 'date_format:Y-m-d'],
            'end_date' => ['date', 'date_format:Y-m-d'],
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
            'name' => 'コースカテゴリー名',
            'description' => 'コースカテゴリー内容',
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
            'course_category_photo_path.mimes' => 'コースカテゴリーの画像はjpg、jpeg、png形式の画像ファイルで指定してください。',
        ];
    }
}
