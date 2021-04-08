<?php

namespace App\Services;


use App\Models\Deposit;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class CreateDeposit
{

    public function create($amount, $wallet)
    {
        DB::transaction(function () use ($amount, $wallet) {
            $wallet->balance -= $amount;

            if ($wallet->balance < 0) {
                return;
            }

            if (!$wallet->save()) {
                return;
            }

            $depositId = $this->createDeposit($amount, $wallet->user_id, $wallet->id);

            if (!$depositId || !Transaction::createCreateDeposit($amount, $wallet->id, $wallet->user_id, $depositId)) {
                return;
            }
        });
    }

    protected function createDeposit($amount, $userId, $walletId)
    {
        $deposit = new Deposit();
        $deposit->setRawAttributes([
            'user_id' => $userId,
            'wallet_id' => $walletId,
            'invested' => $amount,
            'percent' => 20,
            'active' => true,
            'duration' => 10,
            'accrue_times' => 0
        ]);

        if (!$deposit->save()) {
            return false;
        }
        return $deposit->id;
    }

}
