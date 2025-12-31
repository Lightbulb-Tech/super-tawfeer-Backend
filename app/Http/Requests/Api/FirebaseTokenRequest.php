<?php

namespace App\Http\Requests\Api;

use App\Enums\UserFirebaseTypesEnum;
use App\Http\Requests\MainRequest;
use Illuminate\Validation\Rule;

class FirebaseTokenRequest extends MainRequest
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
            'token' => 'required|string',
            'type' => ['required', Rule::enum(UserFirebaseTypesEnum::class)],
        ];
    }

    protected function update(): array
    {
        return [
            'token' => 'required|string',
            'type' => ['required', Rule::enum(UserFirebaseTypesEnum::class)],
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
