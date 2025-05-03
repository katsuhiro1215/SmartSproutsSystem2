<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
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
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'postalcode' => $this->postalcode,
            'full_address' => "{$this->prefecture} {$this->city} {$this->address1} {$this->address2}",
            'phone_number' => $this->phone_number,
            'is_default' => $this->is_default,
        ];
    }
}
