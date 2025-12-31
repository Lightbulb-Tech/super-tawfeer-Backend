<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\MainRequest;
use Illuminate\Support\Facades\Auth;

class ReservationRequest extends MainRequest
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
            'code' => [
                'nullable',
                'string',
            ],
            'vehicle_id' => [
                'required',
                'exists:vehicles,id',
            ],
            'from_address' => [
                'required',
                'string',
            ],
            'to_address' => [
                'required',
                'string',
            ],
            'first_lat' => [
                'required',
                'numeric',
            ],
            'first_lon' => [
                'required',
                'numeric',
            ],
            'second_lat' => [
                'required',
                'numeric',
            ],
            'second_lon' => [
                'required',
                'numeric',
            ],
            'date' => [
                'nullable',
                'date',
            ],
            'time' => [
                'nullable',
                'date_format:H:i',
            ],
            'details' => [
                'nullable',
                'string',
            ],
            'coupon_id ' => [
                'nullable',
                'exists:coupons,id',
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
            'vehicle_id.required' => __('api.vehicle_id_required'),
            'vehicle_id.exists' => __('api.vehicle_id_exists'),

            'from_address.required' => __('api.from_address_required'),
            'from_address.string' => __('api.from_address_string'),

            'to_address.required' => __('api.to_address_required'),
            'to_address.string' => __('api.to_address_string'),

            'first_lat.required' => __('api.first_lat_required'),
            'first_lat.numeric' => __('api.first_lat_numeric'),

            'first_lon.required' => __('api.first_lon_required'),
            'first_lon.numeric' => __('api.first_lon_numeric'),

            'second_lat.required' => __('api.second_lat_required'),
            'second_lat.numeric' => __('api.second_lat_numeric'),

            'second_lon.required' => __('api.second_lon_required'),
            'second_lon.numeric' => __('api.second_lon_numeric'),

            'date.numeric' => __('api.date_numeric'),
            'time.numeric' => __('api.time_numeric'),
            'details.numeric' => __('api.details_numeric'),

            'coupon_id.exists' => __('api.coupon_id_exists'),

            'user_id.required' => __('api.user_id_required'),
            'user_id.exists' => __('api.user_id_exists'),

            'phone.required' => __('api.phone_required'),
            'phone.string' => __('api.phone_string'),

            'name.required' => __('api.name_required'),
            'name.string' => __('api.name_string'),
        ];
    }


}
