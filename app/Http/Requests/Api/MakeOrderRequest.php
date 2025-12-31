<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\MainRequest;

class MakeOrderRequest extends MainRequest
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
            "coupon_id" => [
                'nullable',
                'exists:coupons,id',
            ],
            "notes" => [
                'nullable',
                'string',
            ],
            "payment_type" => [
                'required',
                'in:cash,wallet',
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
            'coupon_id.exists'     => __('api.coupon_id_exists'),
            'notes.string'         => __('api.notes_string'),
            'payment_type.required'=> __('api.payment_type_required'),
            'payment_type.in'      => __('api.payment_type_in'),
        ];
    }


}
