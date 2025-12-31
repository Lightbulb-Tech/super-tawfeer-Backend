<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;

class AppSettingsRequest extends MainRequest
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
            "ar.address" => [
                'nullable',
                'string',
            ],
            "en.address" => [
                'nullable',
                'string',
            ],
            "ar.app_name" => [
                'nullable',
                'string',
            ],
            "en.app_name" => [
                'nullable',
                'string',
            ],
            "email" => [
                'nullable',
                'string',
            ],
            "phone" => [
                'nullable',
                'string',
            ],
            "app_commission" => [
                'nullable',
                'string',
            ],
            "point_price" => [
                'nullable',
                'string',
            ],
            "days" => [
                'nullable',
                'array',
            ],
            "logo" => [
                'nullable',
                'string',
            ],
        ];
    }

    protected function update(): array
    {
        return [
            "ar.address" => [
                'nullable',
                'string',
            ],
            "en.address" => [
                'nullable',
                'string',
            ],
            "ar.app_name" => [
                'nullable',
                'string',
            ],
            "en.app_name" => [
                'nullable',
                'string',
            ],
            "email" => [
                'nullable',
                'string',
            ],
            "phone" => [
                'nullable',
                'string',
            ],
            "app_commission" => [
                'nullable',
                'string',
            ],
            "point_price" => [
                'nullable',
                'string',
            ],
            "logo" => [
                'nullable',
                'file',
                'image',
            ],
            "days" => [
                'nullable',
                'array',
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
        ];
    }


}
