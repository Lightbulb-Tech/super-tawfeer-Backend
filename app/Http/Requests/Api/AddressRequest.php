<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\MainRequest;
use Illuminate\Validation\Rule;

class AddressRequest extends MainRequest
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
            "area_id" => [
                'required',
                'exists:areas,id',
            ],
            'lat' => [
                'required',
                'numeric',
            ],
            'lon' => [
                'required',
                'numeric',
            ],
            'address' => [
                'required',
                'string',
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
            'phone' => [
                'nullable',
                'string',
                Rule::unique('users', 'phone')->ignore($this->route('user')),
            ],
            'email' => [
                'nullable',
                'string',
                Rule::unique('users', 'email')->ignore($this->route('user')),
            ],
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
            'area_id.required' => __('api.area_id_required'),
            'area_id.exists'   => __('api.area_id_exists'),

            'lat.required'     => __('api.lat_required'),
            'lat.numeric'      => __('api.lat_numeric'),

            'lon.required'     => __('api.lon_required'),
            'lon.numeric'      => __('api.lon_numeric'),

            'address.required' => __('api.address_required'),
            'address.string'   => __('api.address_string'),
        ];
    }



}
