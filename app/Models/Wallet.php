<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property int $user_id
 * @property double $balance
 */
class Wallet extends Model
{

    public const MAX_AMOUNT = 9999999999;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'balance',
    ];

    public function rechargeBalance($amount)
    {
        DB::transaction(function () use ($amount) {
            $this->balance += $amount;
            if (!$this->save()) {
                return;
            }

            if (!Transaction::createEnter($amount, $this->id, $this->user_id)) {
                return;
            }
        });
    }

    public function accrue($amount, $depositId): bool
    {
        $this->balance += $amount;

        if (!$this->save()) {
            return false;
        }

        return Transaction::createAccrue($amount, $this->id, $this->user_id, $depositId);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function deposits(): BelongsToMany
    {
        return $this->belongsToMany(Deposit::class);
    }
}
