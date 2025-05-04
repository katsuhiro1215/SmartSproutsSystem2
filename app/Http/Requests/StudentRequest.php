<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'lastname' => ['required', 'string', 'max:40'],
            'firstname' => ['required', 'string', 'max:40'],
            'lastname_kana' => ['required', 'string', 'max:50'],
            'firstname_kana' => ['required', 'string', 'max:50'],
            'student_photo_path' => ['nullable', 'string', 'max:255'],
            'birth' => ['required', 'date'],
            'gender' => ['required', 'string', 'in:男性,女性,その他'],
            'blood' => ['required', 'string', 'in:A型,B型,O型,AB型,不明,未回答'],
            'mobile_number' => ['required', 'string', 'max:15'],
            'mobile_number_relationship' => ['required', 'string', 'max:20'],
            'personal_history' => ['required', 'string'],
            'member_no' => ['nullable', 'string', 'max:255'],
            'membership_status' => ['required', 'string', 'in:会員,非会員'],
            'serial_no' => ['nullable', 'string', 'max:255'],
            'permission_photo' => ['required', 'boolean'],
            'permission_dm' => ['required', 'boolean'],
            'remarks' => ['nullable', 'string'],
        ];
    }
}
