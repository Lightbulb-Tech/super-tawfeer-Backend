<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\MainRequest;
use Illuminate\Validation\Rule;

class ChangeAddressRequest extends MainRequest
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
            "address_id" => [
                'required',
                'exists:addresses,id',
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
            'address_id.required' => __('api.address_id_required'),
            'address_id.exists'   => __('api.address_id_exists'),
        ];
    }



}
