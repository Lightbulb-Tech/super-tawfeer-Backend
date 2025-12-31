<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\MainRequest;
use Illuminate\Support\Facades\Auth;

class ExternalOrderRequest extends MainRequest
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
        $data = [
            'area_id' => [
                'required',
                'exists:areas,id',
            ],
            'address' => [
                'required',
                'string',
            ],
            'lat' => [
                'required',
                'string',
            ],
            'lon' => [
                'required',
                'numeric',
            ],
            'order_details' => ['required', 'array'],

            'order_details.*.order_category_id' => [
                'required',
                'exists:order_categories,id',
            ],
            'order_details.*.details' => [
                'required',
                'string',
            ],
            'order_details.*.image' => [
                'required',
                'file',
                'image',
            ],
        ];
        if (!Auth::guard('api')->check()) {
            $data['phone'] = [
                'required',
                'string',
            ];
            $data['name'] = [
                'required',
                'string',
            ];
        }

        return $data;
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

            // area
            'area_id.required' => __('api.area_id_required'),
            'area_id.exists'   => __('api.area_id_exists'),

            // address
            'address.required' => __('api.address_required'),
            'address.string'   => __('api.address_string'),

            // lat
            'lat.required' => __('api.lat_required'),
            'lat.string'   => __('api.lat_string'),

            // lon
            'lon.required' => __('api.lon_required'),
            'lon.numeric'  => __('api.lon_numeric'),

            // order details array
            'order_details.required' => __('api.order_details_required'),
            'order_details.array'    => __('api.order_details_array'),

            // order category
            'order_details.order_category_id.required' => __('api.order_category_id_required'),
            'order_details.order_category_id.exists'   => __('api.order_category_id_exists'),

            // details
            'order_details.details.required' => __('api.order_details_details_required'),
            'order_details.details.string'   => __('api.order_details_details_string'),

            // image
            'order_details.image.required' => __('api.order_details_image_required'),
            'order_details.image.file'     => __('api.order_details_image_file'),
            'order_details.image.image'    => __('api.order_details_image_image'),

            // guest user
            'phone.required' => __('api.phone_required'),
            'phone.string'   => __('api.phone_string'),

            'name.required' => __('api.name_required'),
            'name.string'   => __('api.name_string'),
        ];
    }



}
