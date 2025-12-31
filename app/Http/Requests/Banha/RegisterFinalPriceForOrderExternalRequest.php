<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;

class RegisterFinalPriceForOrderExternalRequest extends MainRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */


    public function rules(): array
    {
        return match ($this->method()) {
            'POST' => $this->store(),
            'PUT', 'PATCH' => $this->update(),
            'DELETE' => $this->destroy(),
            default => $this->view()
        };

    }

    protected function store(): array
    {
        return [
            "prices" => [
                'required',
                'array',
            ],
            "prices.*" => [
                'required',
                'numeric',
                'min:1',
            ],
            "orders_price" => [
                'required',
                'numeric',
                'min:1',
            ],
            "orderDetailsIds" => [
                'required',
                'array',
            ],
            "orderDetailsIds.*" => [
                'required',
                'exists:external_order_details,id',
            ],
            "order_id" => [
                'required',
                'exists:external_orders,id',
            ],
        ];
    }

    protected function update(): array
    {
        return [

        ];
    }

    protected function destroy(): array
    {
        return [];
    }

    protected function view(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [
            // prices array
            'prices.required' => __('api.prices_required'),
            'prices.array' => __('api.prices_array'),

            // each price
            'prices.*.required' => __('api.price_required'),
            'prices.*.numeric' => __('api.price_numeric'),
            'prices.*.min' => __('api.price_min'),

            'orders_price.required' => __('api.orders_price_required'),
            'orders_price.numeric' => __('api.orders_price_numeric'),
            'orders_price.min' => __('api.orders_price_min'),

            // orderDetailsIds array
            'orderDetailsIds.required' => __('api.order_details_ids_required'),
            'orderDetailsIds.array' => __('api.order_details_ids_array'),

            // each order detail id
            'orderDetailsIds.*.required' => __('api.order_detail_id_required'),
            'orderDetailsIds.*.exists' => __('api.order_detail_id_exists'),

            // order_id
            'order_id.required' => __('api.order_id_required'),
            'order_id.exists' => __('api.order_id_exists'),
        ];
    }



}
