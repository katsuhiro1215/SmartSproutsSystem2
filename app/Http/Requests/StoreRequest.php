<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Store;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
        $rules = [
            'organization_id' => ['required', 'exists:organizations,id'],
            'name' => ['required', 'string', 'max:50'],
            'type' => ['required', 'string', 'max:20'],
            'theme_color' => ['required', 'string', 'max:7'],
            'description' => ['required', 'string', 'max:1000'],
            'store_photo_path' => ['nullable', 'image', 'mimes: jpg,jpeg,png', 'max:2048'],
            'store_logo_path' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'postalcode' => ['required', 'regex:/^[0-9a-zA-Z\-]+$/', 'max:7'],
            'prefecture' => ['required', 'string', 'max:10'],
            'city' => ['required', 'string', 'max:30'],
            'address1' => ['required', 'string', 'max:50'],
            'address2' => ['required', 'string', 'max:100'],
            'phone_number' => ['required', 'string', 'regex:/^[0-9a-zA-Z\-]+$/', 'max:15'],
            'fax_number' => ['nullable', 'string', 'regex:/^[0-9a-zA-Z\-]+$/', 'max:15'],
            'status' => ['required', 'boolean'],
            'established_date' => ['required', 'date'],
            'website' => ['nullable', 'url', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'youtube' => ['nullable', 'url', 'max:255'],
            'line' => ['nullable', 'url', 'max:255'],
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['code'] = ['required', 'string', 'max:20', Rule::unique(Store::class)->ignore($this->store)];
            $rules['email'] = ['required', 'string', 'email', 'max:255', Rule::unique(Store::class)->ignore($this->store)];
        } else {
            $rules['code'] = ['required', 'string', 'max:20', 'unique:' . Store::class];
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:' . Store::class];
        }

        return $rules;
    }
}
