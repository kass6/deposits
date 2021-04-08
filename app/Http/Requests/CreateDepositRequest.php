<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateDepositRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'recharge-deposit' => [
                'required',
                'numeric',
                'min:10',
                'max:100',
                function ($attribute, $value, $fail) {
                    if ($value > Auth::user()->wallet->balance) {
                        $fail('Please charge your balance first.');
                    }
                },
            ]
        ];
    }
}
