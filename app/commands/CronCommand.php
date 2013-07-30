<?php

use Illuminate\Console\Command;

class CronCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executes a cron run';

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
     * @return void
     */
    public function fire()
    {
        $success = Cron::run(TRUE);
        if ($success) {
            $this->info('Cron run completed!');
        } else {
            $this->info('Attempting to re-run cron while it is already running.!');
        }
    }
}
