<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewTemplateRequest extends FormRequest
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
            'template' => ['required','file','max:10240','image','mimes:jpg,png,gif,bmp,webp','dimensions:min_width=300,min_height=300,max_width=2500,max_width=2500']
        ];
    }

    public function messages()
    {
    return [
        'template.required' => 'Выберите изображение.',
        'template.file' => 'Выберите изображение.',
        'template.image'  => 'Выберите изображение.',
        'template.mimes' => 'Поддерживаются только следующие типы файлов: jpg, png, gif, bmp, webp.',
        'template.max' => 'Изображение не подходит по размерам.',
        'template.dimensions' => 'Изображение не подходит по размерам.',
    ];
    }
}
