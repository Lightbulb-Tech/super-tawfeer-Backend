<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;

class ProductAttributeRequest extends MainRequest
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
            "ar.attribute_name" => [
                'required',
                'string',
            ],
            "en.attribute_name" => [
                'nullable',
                'string',
            ],
            "attribute_value" => [
                'required',
                'string',
            ],
            "product_id" => [
                'required',
                'exists:products,id',
            ],
        ];
    }

    protected function update(): array
    {
        return [
            "ar.attribute_name" => [
                'required',
                'string',
            ],
            "en.attribute_name" => [
                'required',
                'string',
            ],
            "attribute_value" => [
                'required',
                'string',
            ],
            "product_id" => [
                'required',
                'exists:products,id',
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
            'ar.attribute_name.required' => __('banha.attribute_name_ar_required'),
            'ar.attribute_name.string' => __('banha.attribute_name_ar_string'),

            'en.attribute_name.string' => __('banha.attribute_name_en_string'),

            'attribute_value.required' => __('banha.attribute_value_required'),
            'attribute_value.string' => __('banha.attribute_value_string'),
            'product_id.required' => __('banha.product_id_required'),
            'product_id.exists'   => __('banha.product_id_exists'),
        ];
    }


}
