<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UpdateMatchResult as Updater;

class UpdateMatchResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update match result if finished';

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
        // $this->info("Updating match results from bookmaker: betika");
        // (new Updater("betika", now()->utc()->startOfDay()))->handle();
        $this->info("Updating matches from bookmaker: sportpesa");
        (new Updater("sportpesa", now()->utc()->startOfDay()))->handle();
        return 0;
    }
}
