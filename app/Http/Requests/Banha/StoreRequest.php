<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;

class StoreRequest extends MainRequest
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
            "logo" => [
                'required',
                'file',
                'image',
            ],
            "cover_image" => [
                'required',
                'file',
                'image',
            ],
            "features" => [
                'required',
                'array',
            ],
            'features.*.ar.title' => [
                'required',
                'string',
                'max:500',
            ],
            'features.*.en.title' => [
                'nullable',
                'string',
                'max:500',
            ],
            'features.*.ar.description' => [
                'required',
                'string',
                'max:500',
            ],
            'features.*.en.description' => [
                'nullable',
                'string',
                'max:500',
            ],
            'features.*.icon' => [
                'required',
                'file',
                'image',
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
            "logo" => [
                'nullable',
                'file',
                'image',
            ],
            "cover_image" => [
                'nullable',
                'file',
                'image',
            ],
            "features" => [
                'nullable',
                'array',
            ],
            'features.*.ar.title' => [
                'nullable',
                'string',
                'max:500',
            ],
            'features.*.en.title' => [
                'nullable',
                'string',
                'max:500',
            ],
            'features.*.ar.description' => [
                'nullable',
                'string',
                'max:500',
            ],
            'features.*.en.description' => [
                'nullable',
                'string',
                'max:500',
            ],
            'features.*.icon' => [
                'nullable',
            ],
            'features.*.id' => [
                'nullable',
            ],
            'featuresIds' => [
                'nullable',
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
            // العنوان الرئيسي
            'title.required' => __('banha.title_required'),
            'title.string'   => __('banha.title_string'),

            // اللوجو
            'logo.required' => __('banha.logo_required'),
            'logo.file'     => __('banha.logo_file'),
            'logo.image'    => __('banha.logo_image'),

            // صورة الغلاف
            'cover_image.required' => __('banha.cover_required'),
            'cover_image.file'     => __('banha.cover_file'),
            'cover_image.image'    => __('banha.cover_image'),

            // المميزات (Features)
            'features.required' => __('banha.features_required'),
            'features.array'    => __('banha.features_array'),

            // العناوين داخل الـ features
            'features.*.ar.title.required' => __('banha.feature_title_required_ar'),
            'features.*.ar.title.string'   => __('banha.feature_title_string_ar'),
            'features.*.ar.title.max'      => __('banha.feature_title_max_ar'),

            'features.*.en.title.required' => __('banha.feature_title_required_en'),
            'features.*.en.title.string'   => __('banha.feature_title_string_en'),
            'features.*.en.title.max'      => __('banha.feature_title_max_en'),

            // الوصف داخل الـ features
            'features.*.ar.description.required' => __('banha.feature_desc_required_ar'),
            'features.*.ar.description.string'   => __('banha.feature_desc_string_ar'),
            'features.*.ar.description.max'      => __('banha.feature_desc_max_ar'),

            'features.*.en.description.required' => __('banha.feature_desc_required_en'),
            'features.*.en.description.string'   => __('banha.feature_desc_string_en'),
            'features.*.en.description.max'      => __('banha.feature_desc_max_en'),

            // الأيقونة داخل الـ features
            'features.*.icon.required' => __('banha.feature_icon_required'),
            'features.*.icon.file'     => __('banha.feature_icon_file'),
            'features.*.icon.image'    => __('banha.feature_icon_image'),
        ];
    }


}
