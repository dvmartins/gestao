<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'xml_file' => 'required|file|mimes:xml',
        ];
    }

    public function messages()
    {
        return [
            'xml_file.required' => 'O arquivo XML é obrigatório.',
            'xml_file.file' => 'O arquivo deve ser um arquivo válido.',
            'xml_file.mimes' => 'O arquivo deve ser do tipo XML.',
        ];
    }
}
