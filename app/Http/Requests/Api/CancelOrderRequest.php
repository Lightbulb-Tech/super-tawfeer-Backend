<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\MainRequest;

class CancelOrderRequest extends MainRequest
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
            "order_id" => [
                'required',
                'exists:orders,id',
            ],
            "reason_id" => [
                'nullable',
                'exists:reason_cancellations,id',
                'required_without:reason',
            ],
            "reason" => [
                'nullable',
                'required_without:reason_id',
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
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->filled('reason_id') && $this->filled('reason')) {
                $validator->errors()->add('reason', __('api.reason_conflict'));
            }
        });
    }

    public function messages(): array
    {
        return [
            'order_id.required' => __('api.order_id_required'),
            'order_id.exists'   => __('api.order_id_exists'),

            'reason_id.exists'  => __('api.reason_id_exists'),

            'reason.nullable'   => __('api.reason_nullable'),
            'reason_id.required_without' => __('api.reason_or_reason_id_required'),

            'reason.required_without'    => __('api.reason_or_reason_id_required'),
            'reason.prohibited_if'  => __('api.both_reasons_prohibited'),

        ];
    }



}
