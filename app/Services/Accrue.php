<?php

namespace App\Services;

use App\Models\Deposit;
use Illuminate\Support\Facades\DB;

class Accrue
{

    public function process(): void
    {
        Deposit::query()
            ->with('wallet')
            ->where('active', '=', true)
            ->chunk(50, fn($deposits) => $this->processChunk($deposits));
    }

    protected function processChunk($deposits): void
    {
        /** @var Deposit $deposit */
        foreach ($deposits as $deposit) {
            $this->accrue($deposit);
        }
    }

    public function accrue($deposit): void
    {
        DB::transaction(function () use ($deposit) {
            if ($deposit->accrue_times < $deposit->duration) {
                $deposit->wallet->accrue($deposit->invested / 100 * $deposit->percent, $deposit->id);
                ++$deposit->accrue_times;
            }

            if ($deposit->accrue_times >= $deposit->duration) {
                $deposit->close();
            }

            if (!$deposit->save()) {
                return;
            }
        });
    }

}
