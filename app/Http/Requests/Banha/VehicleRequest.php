<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;

class VehicleRequest extends MainRequest
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
            "model" => [
                'required',
                'string',
            ],
            "image" => [
                'required',
                'file',
                'image',
            ],
            "price_of_km" => [
                'required',
                'numeric',
            ],
        ];
    }

    protected function update(): array
    {
        return [
            "model" => [
                'required',
                'string',
            ],
            "image" => [
                'nullable',
                'file',
                'image',
            ],
            "price_of_km" => [
                'required',
                'numeric',
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
            'model.required' => __('banha.model_required'),
            'model.string' => __('banha.model_string'),

            'image.required' => __('banha.image_required'),
            'image.file' => __('banha.image_file'),
            'image.image' => __('banha.image_image'),

            'price_of_km.required' => __('banha.price_of_km_required'),
            'price_of_km.numeric' => __('banha.price_of_km_numeric'),
        ];
    }


}
