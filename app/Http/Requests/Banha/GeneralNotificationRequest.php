<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;

class GeneralNotificationRequest extends MainRequest
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
            'title' => 'required|string|regex:/^[\p{Arabic}a-zA-Z\s]+$/u|max:70',
            'message' => 'required|string|max:1000',
            'recipient_type' => 'required|string|in:specific_users,all_users',
            'user_id' => 'nullable|array',
            'user_id.*' => 'exists:users,id',
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
            'title.required' => __('banha.title_required'),
            'title.string' => __('banha.title_string'),
            'title.regex' => __('banha.title_letters_only'),
            'title.max' => __('banha.title_max'),
            'message.required' => __('banha.message_required'),
            'message.string' => __('banha.message_string'),
            'message.max' => __('banha.message_max'),
        ];
    }


}
