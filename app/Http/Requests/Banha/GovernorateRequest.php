<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;

class GovernorateRequest extends MainRequest
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
            "ar.title" => [
                'required',
                'string',
            ],
            "en.title" => [
                'nullable',
                'string',
            ],
            "country_id" => [
                'required',
                'exists:countries,id',
            ],
            "shipping_price" => [
                'required',
                'string',
            ],
        ];
    }

    protected function update(): array
    {
        return [
            "ar.title" => [
                'required',
                'string',
            ],
            "en.title" => [
                'nullable',
                'string',
            ],
            "country_id" => [
                'required',
                'exists:countries,id',
            ],
            "shipping_price" => [
                'required',
                'string',
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
            // العنوان بالعربية
            'ar.title.required' => __('banha.title_required_ar'),
            'ar.title.string'   => __('banha.title_string_ar'),

            // العنوان بالإنجليزية
            'en.title.required' => __('banha.title_required_en'),
            'en.title.string'   => __('banha.title_string_en'),

            // الدولة
            'country_id.required' => __('banha.country_required'),
            'country_id.exists'   => __('banha.country_exists'),

            // سعر الشحن
            'shipping_price.required' => __('banha.shipping_price_required'),
            'shipping_price.string'   => __('banha.shipping_price_string'),
        ];
    }



}
