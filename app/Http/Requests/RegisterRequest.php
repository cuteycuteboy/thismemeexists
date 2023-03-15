<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => ["required", "string", "min:1","max:64"],
            "email" => ["required", "email", "string", "unique:users,email", "min:7","max:64"],
            "password" => ["required", "confirmed","min:8","max:64"]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Введите имя.',
            'name.min' => 'Имя слишком короткое.',
            'name.max' => 'Имя слишком длинное.',
            'email.required' => 'Введите email.',
            'email.email' => 'Введите корректный email.',
            'email.unique' => 'Этот email уже используется.',
            'password.required' => 'Введите пароль.',
            'password.confirmed' => 'Пароли не совпадают.',
            'password.min' => 'Пароль слишком короткий.',
            'password.max' => 'Пароль слишком длинный.',
        ];
    }
}
