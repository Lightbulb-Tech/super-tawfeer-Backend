<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\MainRequest;

class FavouriteRequest extends MainRequest
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
            "product_id" => [
                'required',
                'exists:products,id',
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
            'product_id.required' => __('api.product_id_required'),
            'product_id.exists' => __('api.product_id_exists'),
        ];
    }


}
