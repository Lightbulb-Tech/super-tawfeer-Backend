<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;

class ImportProductRequest extends MainRequest
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
            "file" => [
                'required',
                'file',
                'mimes:xlsx'
            ],
            "main_category_id" => [
                'required',
                'exists:categories,id',
            ],
            "sub_category_id" => [
                'required',
                'exists:categories,id',
            ],
            "brand_id" => [
                'nullable',
                'exists:brands,id',
            ],
        ];
    }

    protected function update(): array
    {
        return [
            "ar.question" => [
                'required',
                'string',
            ],
            "en.question" => [
                'required',
                'string',
            ],
            "ar.answer" => [
                'required',
                'string',
            ],
            "en.answer" => [
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
            'file.required' => __('banha.file_required'),
            'file.file' => __('banha.file_must_be_file'),
            'file.mimes' => __('banha.file_must_be_xlsx'),
            'main_category_id.required' => __('banha.main_category_id_required'),
            'main_category_id.exists' => __('banha.main_category_id_exists'),
            'sub_category_id.required' => __('banha.sub_category_id_required'),
            'sub_category_id.exists' => __('banha.sub_category_id_exists'),
        ];
    }



}
