<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;

class FaqRequest extends MainRequest
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
            'ar.question.required' => __('banha.ar_question_required'),
            'ar.question.string'   => __('banha.ar_question_string'),

            'en.question.required' => __('banha.en_question_required'),
            'en.question.string'   => __('banha.en_question_string'),

            'ar.answer.required'   => __('banha.ar_answer_required'),
            'ar.answer.string'     => __('banha.ar_answer_string'),

            'en.answer.required'   => __('banha.en_answer_required'),
            'en.answer.string'     => __('banha.en_answer_string'),
        ];
    }



}
