<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'student_photo_path' => $this->student_photo_path,
            'birth' => $this->birth,
            'age' => $this->birth ? $this->calculateAge($this->birth) : '未登録', // 年齢を計算
            'gender' => $this->gender,
            'blood' => $this->blood,
            'mobile_number' => $this->mobile_number,
            'mobile_number_relationship' => $this->mobile_number_relationship,
            'personal_history' => $this->personal_history,
            'member_no' => $this->member_no,
            'membership_status' => $this->membership_status,
            'serial_no' => $this->serial_no,
            'permission_photo' => $this->permission_photo,
            'permission_dm' => $this->permission_dm,
            'remarks' => $this->remarks,
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
