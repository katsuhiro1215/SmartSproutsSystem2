<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseScheduleResource extends JsonResource
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
            'course' => [
                'id' => $this->course->id,
                'name' => $this->course->name,
            ],
            'course_date' => Carbon::parse($this->start_date)->format('Y-m-d'),
            'day_of_week' => $this->day_of_week,
            'start_time' => Carbon::parse($this->start_date)->format('H:i'),
            'end_time' => Carbon::parse($this->end_date)->format('H:i'),
            'status' => $this->status,
            'note' => $this->note,
        ];
    }
}
