<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
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
            'type' => $this->type,
            'name' => $this->name,
            'description' => $this->description,
            'email' => $this->email,
            'organization_photo_path' => $this->organization_photo_path,
            'organization_logo_path' => $this->organization_logo_path,
            'zipcode' => $this->zipcode,
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
