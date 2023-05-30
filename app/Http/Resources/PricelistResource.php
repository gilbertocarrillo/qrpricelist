<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PricelistResource extends JsonResource
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
            'currency' => $this->currency,
            'url' => $this->url,
            'qrcode' => Storage::url($this->qrcode),
            'description' => $this->description,
            'address' => $this->address,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'logo' =>  Storage::url($this->logo),
            'cover' => Storage::url($this->cover),
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter' => $this->twitter,
        ];
    }
}
