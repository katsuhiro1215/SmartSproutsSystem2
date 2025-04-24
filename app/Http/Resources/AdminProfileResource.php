<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => "{$this->lastname} {$this->firstname}",
            'full_name_kana' => "{$this->lastname_kana} {$this->firstname_kana}",
            'admin_photo_path' => $this->admin_photo_path,
            'birth' => $this->birth,
            'age' => $this->birth ? $this->calculateAge($this->birth) : '未登録', // 年齢を計算
            'gender' => $this->gender,
            'admin_no' => $this->admin_no,
            'serial_no' => $this->serial_no,
            'mobile_number' => $this->mobile_number,
            'website' => $this->website,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'yotuube' => $this->yotuube,
            'line' => $this->line,
        ];
    }

    /**
     * 年齢を計算するメソッド
     *
     * @param string $birth
     * @return int
     */
    private function calculateAge(string $birth): int
    {
        return date_diff(date_create($birth), date_create('today'))->y;
    }
}
