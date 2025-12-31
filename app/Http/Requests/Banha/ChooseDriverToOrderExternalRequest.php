<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;

class ChooseDriverToOrderExternalRequest extends MainRequest
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
            "driver_id" => [
                'required',
                'exists:drivers,id',
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
            'driver_id.required' => __('banha.driver_id_required'),
            'driver_id.exists' => __('banha.driver_id_exists'),
            'external_order_id.required' => __('banha.order_id_required'),
            'external_order_id.exists' => __('banha.order_id_exists'),
        ];
    }


}
