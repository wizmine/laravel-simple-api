<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiRequest;

class StoreUserRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            "name" => ['required', 'string', 'min:2', 'max:60'],
            'email' => ['required', 'email'],
            'password' => ['required'],
            'phone' => ['required', 'regex:/^\+380\d{9}$/'],
            'position_id' => ['required', 'integer', 'exists:positions,id'],
            'photo' => ['required', 'image', 'mimes:jpeg,jpg', 'max:5120'],
        ];
    }
}
