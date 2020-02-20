<?php

namespace JorarMarfin\LaravelDspace\Commands;

use LaravelDspace;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use JorarMarfin\LaravelDspace\Models\Resources;

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
        $this->procesar($data);
    }
    public function procesar($data)
    {
        $factory = LaravelDspace::FactoryRoute($data);
        if (array_key_exists('message',$factory)) {
            return $urls['message'];
        }else{
            $urls = $factory['urls'];
            $total = $factory['total'];
            $bar = $this->output->createProgressBar($total);
            $bar->start();
            foreach ($urls as $key => $url) {
                if ($key==0)DB::table('resources')->truncate();
                $xml = simplexml_load_file($url);
                foreach ($xml->ListRecords->record as $key => $record) {
                    Resources::create([
                        'header' => $record->header,
                        'metadata' => $record->metadata,
                        'created_at'=>now(),
                        'updated_at'=>now()
                    ]);
                    $bar->advance();
                }
            }
            $bar->finish();
        }
    }
}
