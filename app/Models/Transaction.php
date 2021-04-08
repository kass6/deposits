<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'user_id',
        'wallet_id',
        'deposit_id',
        'amount'
    ];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * @return HasOne
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * @return HasOne
     */
    public function deposit(): HasOne
    {
        return $this->hasOne(Deposit::class);
    }

    public static function createEnter($amount, $walletId, $userId): void
    {
        $transaction = new self();
        $transaction->setRawAttributes([
            'type' => 'enter',
            'user_id' => $userId,
            'wallet_id' => $walletId,
            'deposit_id' => null,
            'amount' => $amount
        ]);
        $transaction->saveOrFail();
    }

    public static function createCreateDeposit($amount, $walletId, $userId, $depositId): void
    {
        $transaction = new self();
        $transaction->setRawAttributes([
            'type' => 'create_deposit',
            'user_id' => $userId,
            'wallet_id' => $walletId,
            'deposit_id' => $depositId,
            'amount' => $amount
        ]);
        $transaction->saveOrFail();
    }
}
