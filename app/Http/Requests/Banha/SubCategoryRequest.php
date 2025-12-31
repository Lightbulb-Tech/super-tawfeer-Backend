<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;

class SubCategoryRequest extends MainRequest
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
            "ar.title" => [
                'required',
                'string',
            ],
            "en.title" => [
                'nullable',
                'string',
            ],
            "image" => [
                'required',
                'file',
                'image',
            ],
            "made_in_egypt" => [
                'required',
            ],
            "main_category_id" => [
                'required',
                'exists:categories,id',
            ],
        ];
    }

    protected function update(): array
    {
        return [
            "ar.title" => [
                'required',
                'string',
            ],
            "en.title" => [
                'required',
                'string',
            ],
            "image" => [
                'nullable',
                'file',
                'image',
            ],
            "made_in_egypt" => [
                'required',
            ],
            "main_category_id" => [
                'required',
                'exists:categories,id',
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

    public function messages()
    {
        return [
            'ar.title.required' => __('banha.title_required_ar'),
            'ar.title.string' => __('banha.title_string_ar'),

            'en.title.required' => __('banha.title_required_en'),
            'en.title.string' => __('banha.title_string_en'),

            'image.required' => __('banha.image_required'),
            'image.file' => __('banha.image_file'),
            'image.image' => __('banha.image_image'),
            'main_category_id.required' => __('banha.main_category_required'),
            'main_category_id.exists'   => __('banha.main_category_exists'),
        ];
    }


}
