<?php

namespace App\Http\Requests\TamoTech\Settings;

use App\Http\Requests\MainRequest;

class SettingsRequest extends MainRequest
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
           "text_sidebar:ar" => 'required|string',
           'text_sidebar:en' => 'required|string',
           'text_login:ar' => 'required|string',
           'text_login:en' => 'required|string',
           'subText_login:en' => 'required|string',
           'subText_login:ar' => 'required|string',
           'footer_text:ar' => 'required|string',
           'footer_text:en' => 'required|string',
           'icon' => 'required|file',
           'image_login' => 'required|file',
        ];
    }

    protected function update(): array
    {
        return [
            "text_sidebar:ar" => 'required|string',
            'text_sidebar:en' => 'required|string',
            'text_login:ar' => 'required|string',
            'text_login:en' => 'required|string',
            'subText_login:en' => 'required|string',
            'subText_login:ar' => 'required|string',
            'footer_text:ar' => 'required|string',
            'footer_text:en' => 'required|string',
            'icon' => 'nullable|file',
            'image_login' => 'nullable|file',
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
}
