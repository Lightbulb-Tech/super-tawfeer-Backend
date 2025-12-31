<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;

class CountryRequest extends MainRequest
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

    public function messages()
    {
        return [
            'ar.title.required' => __('banha.title_required_ar'),
            'ar.title.string'   => __('banha.title_string_ar'),

            'en.title.required' => __('banha.title_required_en'),
            'en.title.string'   => __('banha.title_string_en'),
        ];
    }


}
