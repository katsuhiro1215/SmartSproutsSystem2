<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'organization' => [
                'id' => $this->organization->id,
                'name' => $this->organization->name,
            ],
            'name' => $this->name,
            'type' => $this->type,
            'code' => $this->code,
            'theme_color' => $this->theme_color,
            'description' => $this->description,
            'email' => $this->email,
            'store_photo_path' => $this->store_photo_path,
            'store_logo_path' => $this->store_logo_path,
            'postalcode' => $this->postalcode,
            'full_address' => "{$this->prefecture} {$this->city} {$this->address1} {$this->address2}",
            'phone_number' => $this->phone_number,
            'fax_number' => $this->fax_number,
            'status' => $this->status,
            'established_date' => $this->established_date,
            'website' => $this->website,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'youtube' => $this->youtube,
            'line' => $this->line,
        ];
    }
}
