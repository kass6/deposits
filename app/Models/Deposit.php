<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

}
