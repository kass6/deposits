<?php

namespace App\Console\Commands;

use App\Models\Deposit;
use Illuminate\Console\Command;

class Accrue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accrue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Accrue';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Deposit::query()->with('wallet')->where('active', '=', true)
            ->chunk(50, function ($deposits) {
                /** @var Deposit $deposit */
                foreach ($deposits as $deposit) {
                    $deposit->accrue();
                }
            });

        return 0;
    }
}
