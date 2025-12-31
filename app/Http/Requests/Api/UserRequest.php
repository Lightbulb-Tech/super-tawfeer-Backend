<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\MainRequest;
use Illuminate\Validation\Rule;

class UserRequest extends MainRequest
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
            "first_name" => [
                'nullable',
                'string',
            ],
            'last_name' => [
                'nullable',
                'string',
            ],
            'phone' => ['nullable', 'string','unique:users,phone,'.$this->route('player').',id'],

//            'email' => ['nullable', 'string','unique:users,email,'.$this->route('player').',id'],

            'image' => [
                'nullable',
                'file',
                'image',
            ],
            'lat' => [
                'nullable',
                'string',
            ],
            'lon' => [
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

    public function messages(): array
    {
        return [
            'first_name.string' => __('api.first_name_string'),
            'last_name.string' => __('api.last_name_string'),

            'phone.string' => __('api.phone_string'),
            'phone.unique' => __('api.phone_unique'),

            'email.string' => __('api.email_string'),
            'email.unique' => __('api.email_unique'),

            'image.file' => __('api.image_file'),
            'image.image' => __('api.image_image'),

            'lat.string' => __('api.lat_string'),
            'lon.string' => __('api.lon_string'),
        ];
    }



}
