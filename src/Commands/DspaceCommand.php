<?php

namespace JorarMarfin\LaravelDspace\Commands;

use Illuminate\Console\Command;
use LaravelDspace;

class DspaceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dspace:harvest {--set=} {--from=} {--until=}';

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
        $data = [];
        if($this->option('set')) $data['set']=$this->option('set');
        if($this->option('from')) $data['from']=$this->option('from');
        if($this->option('until')) $data['until']=$this->option('until');
        $data1 = LaravelDspace::Harvest($data);
        dd($data1);
    }
}