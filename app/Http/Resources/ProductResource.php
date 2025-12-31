<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        $price_after_offer = $this->price;
        if (isset($this->offer)) {
            $price_after_offer = calculatePriceAfterOffer($this->price, $this->offer);
        }
        return [
            'id' => (integer)$this->id,
            'title' => (string)$this->title,
            'description' => (string)$this->description,
            'main_category' => MainCategoryResource::make($this->mainCategory),
            'sub_category' => MainCategoryResource::make($this->subCategory),
            'price' => (double)$this->price,
            'price_after_offer' => (double)$price_after_offer,
            'image' => show_file($this->image),
            'points' => (double)$this->points,
            'amount' => (integer)$this->amount,
            'reserved_amount' => (integer)$this->reserved_amount,
            'available_amount_for_order' => (integer)($this->amount - $this->reserved_amount),
            'status' => $this->amount > 0 ? __("api.available") : __("api.not_available"),
            'is_favourite' => isset($this->favourite),
            'images' => ProductImagesResource::collection($this->images),
            'offer' => OfferResource::make($this->offer),
            'productAttributes' => ProductAttributesResource::collection($this->productAttributes),
        ];
    }
}
