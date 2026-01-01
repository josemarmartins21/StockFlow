<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendaRequest extends FormRequest
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
            "quanto_sobrou" => "bail|required|integer|min:0|max:200",
            "note" => "bail|nullable|string",
            'stock_date' => 'after_or_equal:date',
            'produto_id' =>'required'
        ];
    }

    public function messages()
    {
        return [
            'produto_id.required' => 'O campo venda é obrigatório',
            'quanto_sobrou.required' => 'É obrigatório informar a quantidade que sobrou do produto',
        ];
    }
}
