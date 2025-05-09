<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckGrantStatusJob;

class DispatchGrantStatusJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispatch:grantstatusjob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to dispatch Grant Status job';

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
        CheckGrantStatusJob::dispatch();
    }
}
