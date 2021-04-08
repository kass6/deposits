<?php

namespace App\Console\Commands;

use App\Services\Accrue as AccrueService;
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
        (new AccrueService())->process();

        return 0;
    }
}
