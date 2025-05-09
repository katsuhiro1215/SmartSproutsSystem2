<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreScheduleResource extends JsonResource
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
            'store' => [
                'id' => $this->store->id,
                'name' => $this->store->name,
            ],
            'business_date' => Carbon::parse($this->start_date)->format('Y-m-d'),
            'day_of_week' => $this->day_of_week,
            'start_time' => Carbon::parse($this->start_date)->format('H:i'),
            'end_time' => Carbon::parse($this->end_date)->format('H:i'),            
            'status' => $this->status,
        ];
    }
}
