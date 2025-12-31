<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;

class SliderRequest extends MainRequest
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
            "image" => [
                'required',
                'image',
                'file',
            ],
            "type" => [
                'required',
                'string',
            ],
            "module_name" => [
                'required_if:type,module',
            ],
            "module_id" => [
                'required_if:type,module',
            ],

        ];
    }

    protected function update(): array
    {
        return [
            "image" => [
                'nullable',
                'image',
                'file',
            ],
            "type" => [
                'required',
                'string',
            ],
            "module_name" => [
                'required_if:type,module',
            ],
            "module_id" => [
                'required_if:type,module',
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
            'image.required' => __('banha.image_required'),
            'image.image' => __('banha.image_must_be_image'),
            'image.file' => __('banha.image_must_be_file'),

            'type.required' => __('banha.type_required'),
            'type.string' => __('banha.type_string'),

            'module_name.required_if' => __('banha.module_name_required_if'),
            'module_name.string' => __('banha.module_name_string'),

            'module_id.required_if' => __('banha.module_id_required_if'),
            'module_id.string' => __('banha.module_id_string'),

            'module_link.required_if' => __('banha.module_link_required_if'),
            'module_link.string' => __('banha.module_link_string'),
        ];
    }



}
