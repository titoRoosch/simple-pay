<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class WalletRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'value' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    public function messages()
    {
        return [
            'value.required' => 'The field value is required.',
            'value.string' => 'The field value must be a string.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $message = $validator->errors()->first();
        throw new HttpResponseException(response()->json(['message' => $message]
        , 422));
    }
}
