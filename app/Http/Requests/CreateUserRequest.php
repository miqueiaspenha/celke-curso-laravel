<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
        $user = $this->route('user');

        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6'],
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'name.required' => 'Campo nome é obrigatório.',
    //         'email.required' => 'Campo e-mail é obrigatório.',
    //         'email.email' => 'Necessário enviar um e-mail válido.',
    //         'email.unique' => 'O e-mail já está cadastrado.',
    //         'password.required' => 'Campo senha é obrigatório.',
    //         'password.min' => 'O campo de senha deve ter pelo menos :min caracteres.'
    //     ];
    // }

    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'email' => 'e-mail',
            'password' => 'senha',
        ];
    }
}
