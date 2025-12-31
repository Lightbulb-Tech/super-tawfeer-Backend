<?php

namespace App\Http\Requests\Banha;

use App\Http\Requests\MainRequest;

class PointsTransferRequestRequest extends MainRequest
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

        ];
    }

    protected function update(): array
    {
        return [
            'status' => "required|in:accepted,refused"

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
