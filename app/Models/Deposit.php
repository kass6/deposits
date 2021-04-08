<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property int $user_id
 * @property int $wallet_id
 * @property double $invested
 * @property double $percent
 * @property boolean $active
 * @property int $duration
 * @property int $accrue_times
 * @property string $created_at
 * @property string $updated_at
 */
class Deposit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'wallet_id',
        'invested',
        'percent',
        'active',
        'duration',
        'accrue_times',
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
     * Need to check balance before use!
     */
    public static function create($amount, $wallet)
    {
        DB::transaction(function () use ($amount, $wallet) {
            $wallet->balance -= $amount;
            if ($wallet->balance < 0) {
                return;
            }
            $wallet->saveOrFail();

            $deposit = new Deposit();
            $deposit->setRawAttributes([
                'user_id' => $wallet->user_id,
                'wallet_id' => $wallet->id,
                'invested' => $amount,
                'percent' => 20,
                'active' => true,
                'duration' => 10,
                'accrue_times' => 0
            ]);
            $deposit->saveOrFail();

            Transaction::createCreateDeposit($amount, $wallet->id, $wallet->user_id, $deposit->id);
        });
    }
}
