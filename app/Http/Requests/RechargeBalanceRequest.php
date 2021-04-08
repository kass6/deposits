<?php

namespace App\Http\Requests;

use App\Rules\UserBalanceMaxAmount;
use Illuminate\Foundation\Http\FormRequest;

class RechargeBalanceRequest extends FormRequest
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
            'recharge-balance' => [
                'required',
                'numeric',
                'min:0',
                new UserBalanceMaxAmount(),
            ]
        ];
    }
}
