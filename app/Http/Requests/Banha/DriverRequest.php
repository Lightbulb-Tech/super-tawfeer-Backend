<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;
use Illuminate\Validation\Rule;

class DriverRequest extends MainRequest
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
            "image" => [
                'required',
                'image',
                'file',
            ],
            "name" => [
                'required',
                'string',
            ],
            "phone" => [
                'required',
                'string',
                'unique:drivers,phone|unique:users,phone',
            ],

        ];
    }

    protected function update(): array
    {
        return [
            "image" => [
                'nullable',
                'image',
                'file',
            ],
            "name" => [
                'required',
                'string',
            ],
            "phone" => [
                'required',
                'string',
                Rule::unique('drivers', 'phone')->ignore($this->driver),
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
            'image.required' => __('banha.image_required'),
            'image.image' => __('banha.image_must_be_image'),
            'image.file' => __('banha.image_must_be_file'),

            'name.required' => __('banha.name_required'),
            'name.string' => __('banha.name_string'),

            'phone.required' => __('banha.phone_required'),
            'phone.string' => __('banha.phone_string'),
            'phone.unique'   => __('banha.phone_unique'),

        ];
    }


}
