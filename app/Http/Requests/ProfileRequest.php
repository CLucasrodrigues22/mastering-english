<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->method() === 'PUT')
        {
            return [
                'id' => 'required|integer|exists:users,id',
                'current_password' => 'required|string|current_password',
                'password' => 'required|string|confirmed',
            ];
        }

        if($this->method() === 'DELETE')
        {
            return [
                'id' => 'required|integer|exists:users,id',
                'password' => 'required|string',
            ];
        }

        $rules = [
            'id' => 'integer|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'unique:users'],
        ];

        if($this->method() === 'PATCH') {
            $rules['email'] = [
                'required',
                'string',
                'email',
                Rule::unique('users')->ignore($this->request->get('id')), // ignore the current email
            ];
        }

        return $rules;
    }
}
