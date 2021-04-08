<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @property Wallet $wallet
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

    public function close(?bool $save = false, ?bool $saveOrFail = false): ?bool
    {
        $this->active = false;

        Transaction::createCloseDeposit('0', $this->wallet_id, $this->user_id, $this->id);

        if ($save) {
            return $this->save();
        }

        if ($saveOrFail) {
            return $this->saveOrFail();
        }

        return null;
    }

    /**
     * Need to check balance before use!
     */
    public function accrue(): void
    {
        DB::transaction(function () {
            if ($this->accrue_times < $this->duration) {
                $this->wallet->accrue($this->invested / 100 * $this->percent, $this->id);
                ++$this->accrue_times;
            }

            if ($this->accrue_times >= $this->duration) {
                $this->close();
            }

            $this->saveOrFail();
        });
    }

    /**
     * Need to check balance before use!
     */
    public static function create($amount, $wallet): void
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
