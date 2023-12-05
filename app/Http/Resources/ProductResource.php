<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "price" => [
                "unformated" => $this->price,
                "formated" => number_format($this->price, 2, ",", ".") . '-',
            ],
            "description" => $this->description,
            "created_at" => [
                "formated" => $this->created_at->format("Y-m-d H:i:s"),
                "unformated" => $this->created_at,
            ],
            "created_at" => [
                "formated" => $this->updated_at->format("Y-m-d H:i:s"),
                "unformated" => $this->updated_at,
            ],
            "product_owner" => [
                "id" => $this->user->id,
                "name" => $this->user->name,
                "email" => $this->user->email,
            ]
        ];
    }
}
