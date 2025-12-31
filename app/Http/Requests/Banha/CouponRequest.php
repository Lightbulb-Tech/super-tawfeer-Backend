<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends MainRequest
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
            "code" => [
                'required',
                'string',
                'unique:coupons,code',
            ],
            "usage_times" => [
                'required',
                'string',
            ],
            "from_date" => [
                'required',
                'date',
            ],
            "to_date" => [
                'required',
                'date',
                'after_or_equal:from_date'
            ],
            "type" => [
                'required',
                'string',
            ],
            "value" => [
                'required',
                'string',
                'min:1',
            ],
        ];
    }

    protected function update(): array
    {
        return [
            'code' => [
                'required',
                'string',
                Rule::unique('coupons', 'code')->ignore($this->route('coupon')),
            ],
            "usage_times" => [
                'required',
                'string',
            ],
            "from_date" => [
                'required',
                'date',
            ],
            "to_date" => [
                'required',
                'date',
                'after_or_equal:from_date'
            ],
            "type" => [
                'required',
                'string',
            ],
            "value" => [
                'required',
                'string',
                'min:1',
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
            'code.required' => __('banha.code_required'),
            'code.string' => __('banha.code_string'),
            'code.unique' => __('banha.code_unique'),

            'usage_times.required' => __('banha.usage_times_required'),
            'usage_times.string' => __('banha.usage_times_string'),

            'from_date.required' => __('banha.from_date_required'),
            'from_date.date' => __('banha.from_date_date'),

            'to_date.required' => __('banha.to_date_required'),
            'to_date.date' => __('banha.to_date_date'),
            'to_date.after_or_equal' => __('banha.to_date_after_or_equal'),

            'type.required' => __('banha.type_required'),
            'type.string' => __('banha.type_string'),

            'value.required'      => __('banha.value_required'),
            'value.string'        => __('banha.value_string'),
            'value.min'           => __('banha.value_min'),

            'min_purchase.required' => __('banha.min_purchase_required'),
            'min_purchase.string'   => __('banha.min_purchase_string'),
            'min_purchase.min'      => __('banha.min_purchase_min'),
        ];
    }


}
