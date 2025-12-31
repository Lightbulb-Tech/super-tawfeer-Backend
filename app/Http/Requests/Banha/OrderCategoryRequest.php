<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;

class OrderCategoryRequest extends MainRequest
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
            "title" => [
                'required',
                'string',
            ],
        ];
    }

    protected function update(): array
    {
        return [
            "title" => [
                'required',
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
            'title.required' => __('banha.title_required'),
            'title.string' => __('banha.title_string'),
        ];
    }


}
