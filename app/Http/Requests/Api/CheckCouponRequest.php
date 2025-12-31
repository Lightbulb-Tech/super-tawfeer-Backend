<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\MainRequest;

class CheckCouponRequest extends MainRequest
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
            "code" => [
                'required',
                'exists:coupons,code',
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
            'code.required' => __('api.code_required'),
            'code.exists' => __('api.code_exists'),
        ];
    }


}
