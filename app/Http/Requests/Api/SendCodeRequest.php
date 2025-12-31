<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\MainRequest;

class SendCodeRequest extends MainRequest
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
            "phone_code" => [
                'required',
                'numeric',
                'regex:/^\+?[0-9]+$/',
            ],
            'phone' => [
                'required',
                'regex:/^[0-9]+$/',
                'digits_between:8,11'
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
            'phone_code.required' => __('api.phone_code_required'),
            'phone_code.numeric' => __('api.phone_code_numeric'),
            'phone_code.regex' => __('api.phone_code_digits_only'),

            'phone.required' => __('api.phone_required'),
            'phone.regex' => __('api.phone_digits_only'),
            'phone.digits_between' => __('api.phone_digits_between'),
        ];
    }



}
