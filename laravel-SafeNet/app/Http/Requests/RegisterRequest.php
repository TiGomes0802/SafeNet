<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'nome' => 'required|string|min:3',
            'email' => 'required|email|unique:App\Models\User,email',
            'username' => 'required|string|min:3|unique:App\Models\User,username',
            'password' => 'required|string|min:3',
        ];
    }

    public function messages(): array
    {
        return [
            'username.unique' => 'Já existe um utilizador com estes dados.',
            'email.unique' => 'Já existe um utilizador com estes dados.',
        ];
    }
}
