<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PricelistResource;

class CategoryResource extends JsonResource
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
            'pricelist_id' => $this->pricelist_id,
            'pricelist' => new PricelistResource($this->whenLoaded('pricelist')),
            'parent_id' => $this->parent_id,
            'parent' => $this->whenLoaded('parent'),
            'products' => $this->whenLoaded('products'),
            'subcategories' => $this->whenLoaded('subcategories'),
        ];
    }
}
