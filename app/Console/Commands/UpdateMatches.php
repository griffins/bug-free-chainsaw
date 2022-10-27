<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UpdateMatches as Updater;


class UpdateMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update matches from bookmakers';

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
        $this->info("Updating matches from bookmaker: betika");
        (new Updater("betika"))->handle();
        $this->info("Updating matches from bookmaker:betika");
        (new Updater("sportpesa"))->handle();
        return 0;
    }
}
