<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\MainRequest;

class CartRequest extends MainRequest
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
            "product_id" => [
                'required',
                'exists:products,id',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],

        ];
    }

    protected function update(): array
    {
        return [
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
            'type' => [
                'required',
                'in:increase,decrease',
            ],
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
            'product_id.required' => __('api.product_id_required'),
            'product_id.exists' => __('api.product_id_exists'),

            'cart_id.required' => __('api.cart_id_required'),
            'cart_id.exists' => __('api.cart_id_exists'),

            'quantity.required' => __('api.quantity_required'),
            'quantity.integer' => __('api.quantity_must_be_number'),
            'quantity.min' => __('api.quantity_min'),
            'type.required' => __('api.type_required'),
            'type.in'       => __('api.type_invalid'),
        ];
    }


}
