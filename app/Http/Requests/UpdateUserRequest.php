<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->user),
            ]
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'name.required' => 'Campo nome é obrigatório.',
    //         'email.required' => 'Campo e-mail é obrigatório.',
    //         'email.email' => 'Necessário enviar um e-mail válido.',
    //         'email.unique' => 'O e-mail já está cadastrado.',
    //     ];
    // }
}
