<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'event_photo_path' => $this->event_photo_path,
            'postalcode' => $this->postalcode,
            'full_address' => "{$this->prefecture} {$this->city} {$this->address1} {$this->address2}",
            'phone_number' => $this->phone_number,
            'status' => $this->status,
            'event_start_date' => $this->event_start_date,
            'event_end_date' => $this->event_end_date,
            'application_start_date' => $this->application_start_date,
            'application_start_time' => $this->application_start_time,
            'application_end_date' => $this->application_end_date,
            'application_end_time' => $this->application_end_time,
        ];
    }
}
