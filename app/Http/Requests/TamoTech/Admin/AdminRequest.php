<?php

namespace App\Http\Requests\TamoTech\Admin;

use App\Http\Requests\MainRequest;

class AdminRequest extends MainRequest
{
    public function rules(): array
    {
        return match ($this->method()) {
            'POST' => $this->store(),
            'PUT', 'PATCH' => $this->update(),
            'DELETE' => $this->destroy(),
            'GET' => $this->view(),
            default => [],
        };
    }

    protected function store(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|unique:admins,email',
            'phone' => 'required|unique:admins,phone',
            'role_id' => 'required|exists:roles,id',
            'image' => 'required|file',
            'password' => 'required|min:4',
        ];
    }

    protected function update(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|unique:admins,email,' . $this->route('admin') . ',id',
            'phone' => 'required|unique:admins,phone,' . $this->route('admin') . ',id',
            'role_id' => 'required|exists:roles,id',
            'image' => 'nullable|file',
        ];
    }


    protected function destroy(): array
    {
        return [
            // Add your validation rules for deleting resources here
        ];
    }

    protected function view(): array
    {
        return [
            // Add your validation rules for viewing resources here
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('admin.name_required'),
            'name.string' => __('admin.name_string'),

            'email.required' => __('admin.email_required'),
            'email.unique' => __('admin.email_unique'),

            'phone.required' => __('admin.phone_required'),
            'phone.unique' => __('admin.phone_unique'),

            'image.required' => __('admin.image_required'),
            'image.file' => __('admin.image_file'),

            'password.required' => __('admin.password_required'),
            'password.min' => __('admin.password_min'),
        ];
    }

}
