<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'value' => ['required', 'numeric', 'min:0.01'],
            'payer' => ['required', 'integer', 'exists:users,id'],
            'payee' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    public function messages()
    {
        return [
            'value.required' => 'The field password is required.',
            'value.string' => 'The field password must be a string.',
            'payer.required' => 'The field payer is required.',
            'payer.integer' => 'The field payer must be a integer.',
            'payer.exists' => 'The informed payer is invalid.',
            'payee.required' => 'The field payee is required.',
            'payee.integer' => 'The field payee must be a integer.',
            'payee.exists' => 'The informed payee is invalid.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $message = $validator->errors()->first();
        throw new HttpResponseException(response()->json(['message' => $message]
        , 422));
    }
}
