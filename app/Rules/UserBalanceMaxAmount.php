<?php

namespace App\Rules;

use App\Models\Wallet;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserBalanceMaxAmount implements Rule
{

    private $available;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->available = 0;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $balance = Auth::user()->wallet->balance;
        if ($balance + $value > Wallet::MAX_AMOUNT) {
            $this->available = Wallet::MAX_AMOUNT - $balance;
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'You reached the maximum balance of the wallet. You can only top up your wallet for ' . $this->available;
    }
}
