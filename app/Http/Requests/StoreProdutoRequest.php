<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdutoRequest extends FormRequest
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
            'name' => 'bail|string|required',
            'price' => 'bail|numeric|min:50|required',
            'shipping' => 'bail|numeric|min:50|required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'O campo nome deve conter letras',
            'price.required' => 'O campo preço deve ser um número.'
        ];
    }
}
