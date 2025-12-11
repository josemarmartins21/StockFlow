<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEstoqueRequest extends FormRequest
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
            "current_quantity" => 'bail|required|integer|max:250|min:0', 
            "minimum_quantity" => 'bail|required|integer|min:5|max:10', 
            "maximum_quantity" => 'bail|required|max:260|integer|min:5',
            "unit_cost_price" => 'bail|numeric|required|min:50|max:5000|min:50',
            "total_stock_value" => 'bail|numeric|required',
            "stock_date" => 'bail|required|date',
        ];
    }
}
