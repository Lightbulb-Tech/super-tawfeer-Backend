<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;

class ProductRequest extends MainRequest
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
                'required',
                'string',
            ],
            "ar.description" => [
                'required',
                'string',
            ],
            "en.description" => [
                'required',
                'string',
            ],
            "price" => [
                'required',
                'numeric',
            ],
            "amount" => [
                'required',
                'numeric',
            ],
            "max_quantity_for_order" => [
                'nullable',
                'numeric',
                'min:1',
            ],
            "points" => [
                'required',
                'numeric',
                'min:0.1',
            ],
            "image" => [
                'required',
                'file',
                'image',
            ],
            "main_category_id" => [
                'required',
                'exists:categories,id',
            ],
            "sub_category_id" => [
                'required',
                'exists:categories,id',
            ],
            "brand_id" => [
                'nullable',
                'exists:brands,id',
            ],
            "made_in_egypt" => [
                'required',
            ],
            "our_products" => [
                'required',
            ],
            "has_offer" => [
                'required',
            ],
            'type' => [
                'required_if:has_offer,yes',
            ],
            'value' => [
                'required_if:has_offer,yes',
            ],
            'from_date' => [
                'required_if:has_offer,yes',
            ],
            'to_date' => [
                'required_if:has_offer,yes',
                function ($attribute, $value, $fail) {
                    if (request('has_offer') === 'yes' && $value <= request('from_date')) {
                        $fail(__('banha.to_date_after'));
                    }
                },
            ],
            "images" => [
                'nullable',
                'array',
            ],
            "images.*" => [
                'nullable',
                'file',
                'image',
            ],
            "productAttributes" => [
                'nullable',
                'array',
            ],
            'productAttributes.*.ar.attribute_name' => [
                'nullable',
                'string',
                'max:500',
            ],
            'productAttributes.*.en.attribute_name' => [
                'nullable',
                'string',
                'max:500',
            ],
            'productAttributes.*.attribute_value' => [
                'nullable',
                'string',
                'max:500',
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
                'required',
                'string',
            ],
            "ar.description" => [
                'required',
                'string',
            ],
            "en.description" => [
                'required',
                'string',
            ],
            "price" => [
                'required',
                'numeric',
                'min:1',
            ],
            "brand_id" => [
                'nullable',
                'exists:brands,id',
            ],
            "amount" => [
                'required',
                'numeric',
                'min:1',
            ],
            "max_quantity_for_order" => [
                'nullable',
                'numeric',
                'min:1',
            ],
            "points" => [
                'required',
                'numeric',
                'min:0.1',
            ],
            "image" => [
                'nullable',
                'file',
                'image',
            ],
            "main_category_id" => [
                'required',
                'exists:categories,id',
            ],
            "sub_category_id" => [
                'required',
                'exists:categories,id',
            ],
            "made_in_egypt" => [
                'required',
            ],
            "our_products" => [
                'required',
            ],
            "has_offer" => [
                'required',
            ],
            'type' => [
                'required_if:has_offer,yes',
            ],
            'value' => [
                'required_if:has_offer,yes',
            ],
            'from_date' => [
                'required_if:has_offer,yes',
            ],
            'to_date' => [
                'required_if:has_offer,yes',
                function ($attribute, $value, $fail) {
                    if (request('has_offer') === 'yes' && $value <= request('from_date')) {
                        $fail(__('banha.to_date_after'));
                    }
                },
            ],
            "images" => [
                'nullable',
                'array',
            ],
            "images.*" => [
                'nullable',
                'image',
            ],
            "productAttributes" => [
                'nullable',
                'array',
            ],
            'productAttributes.*.ar.attribute_name' => [
                'nullable',
                'string',
                'max:500',
            ],
            'productAttributes.*.en.attribute_name' => [
                'nullable',
                'string',
                'max:500',
            ],
            'productAttributes.*.attribute_value' => [
                'nullable',
                'string',
                'max:500',
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
            'ar.title.required' => __('banha.ar_title_required'),
            'en.title.required' => __('banha.en_title_required'),
            'ar.main_description.required' => __('banha.ar_main_description_required'),
            'en.main_description.required' => __('banha.en_main_description_required'),
            'ar.description.required' => __('banha.ar_description_required'),
            'en.description.required' => __('banha.en_description_required'),

            'price.required' => __('banha.price_required'),
            'price.numeric' => __('banha.price_numeric'),
            'price.min' => __('banha.price_min'),

            'amount.required' => __('banha.amount_required'),
            'amount.numeric' => __('banha.amount_numeric'),
            'amount.min' => __('banha.amount_min'),

            'max_quantity_for_order.numeric' => __('banha.max_quantity_for_order_numeric'),
            'max_quantity_for_order.min' => __('banha.max_quantity_for_order_min'),

            'points.required' => __('banha.points_required'),
            'points.numeric' => __('banha.points_numeric'),
            'points.min' => __('banha.points_min'),
            'image.required' => __('banha.image_required'),
            'image.file' => __('banha.image_file'),
            'image.image' => __('banha.image_image'),

            'main_category_id.required' => __('banha.main_category_id_required'),
            'main_category_id.exists' => __('banha.main_category_id_exists'),

            'sub_category_id.required' => __('banha.sub_category_id_required'),
            'sub_category_id.exists' => __('banha.sub_category_id_exists'),

            'made_in_egypt.required' => __('banha.made_in_egypt_required'),
            'our_products.required' => __('banha.our_products_required'),
            'has_offer.required' => __('banha.has_offer_required'),
            'type.required_if'   => __('banha.type_required_if'),

            // value
            'value.required_if'  => __('banha.value_required_if'),

            // from_date
            'from_date.required_if' => __('banha.from_date_required_if'),

            // to_date
            'to_date.required_if'   => __('banha.to_date_required_if'),
            'to_date.after'         => __('banha.to_date_after'),
        ];
    }


}
