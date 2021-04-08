<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * @return HasOne
     */
    public function deposit(): HasOne
    {
        return $this->hasOne(Deposit::class);
    }

    public static function createEnter($amount, $walletId, $userId): bool
    {
        $transaction = new self();
        $transaction->setRawAttributes([
            'type' => 'enter',
            'user_id' => $userId,
            'wallet_id' => $walletId,
            'deposit_id' => null,
            'amount' => $amount
        ]);
        return $transaction->save();
    }

    public static function createCreateDeposit($amount, $walletId, $userId, $depositId): bool
    {
        $transaction = new self();
        $transaction->setRawAttributes([
            'type' => 'create_deposit',
            'user_id' => $userId,
            'wallet_id' => $walletId,
            'deposit_id' => $depositId,
            'amount' => $amount
        ]);
        return $transaction->save();
    }

    public static function createAccrue($amount, $walletId, $userId, $depositId): bool
    {
        $transaction = new self();
        $transaction->setRawAttributes([
            'type' => 'accrue',
            'user_id' => $userId,
            'wallet_id' => $walletId,
            'deposit_id' => $depositId,
            'amount' => $amount
        ]);
        return $transaction->save();
    }

    public static function createCloseDeposit($amount, $walletId, $userId, $depositId): bool
    {
        $transaction = new self();
        $transaction->setRawAttributes([
            'type' => 'close_deposit',
            'user_id' => $userId,
            'wallet_id' => $walletId,
            'deposit_id' => $depositId,
            'amount' => $amount
        ]);
        return $transaction->save();
    }
}
