<?php

namespace JorarMarfin\LaravelDspace\Commands;

use Illuminate\Console\Command;

class DspaceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dspace:harvest';

    /**
     * The console Harvest register to dspace.
     *
     * @var string
     */
    protected $description = 'Harvest register to dspace';

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
     * @return mixed
     */
    public function handle()
    {
        echo 'harvest';
    }
}
