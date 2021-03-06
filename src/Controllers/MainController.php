<?php

namespace JorarMarfin\LaravelDspace\Controllers;


use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JorarMarfin\LaravelDspace\Models\Resources;

class MainController extends Controller
{
    public function index($data)
    {
        $url = config('dspace.url');
        $url .='oai/';
        $url .='request?';
        foreach ($data as $key => $item) {
            $url .= $key.'='.$item.'&';
        }
        $url = substr($url,0,-1);
        //https://infohub.practicalaction.org/oai/request?verb=ListRecords&resumptionToken=oai_dc///com_11283_320273/0
        return $url;
    }
    public function getData($data)
    {
        $url = config('dspace.url');
        $url .='oai/';
        $url .='request?';
        foreach ($data as $key => $item) {
            $url .= $key.'='.$item.'&';
        }
        $url = substr($url,0,-1);
        $xml = simplexml_load_file($url);

        return $xml;
    }
    public function Harvest($data)
    {
        $dspace = $this->ProcessingData($data);
        if (array_key_exists('message',$dspace)) {
            return $urls['message'];
        }else{
            $data = $dspace['data'];
            $this->InsertData($data);
            return 'Registros cosechados';
        }
    }
    public function ProcessingData($data)
    {
        $url = config('dspace.url');
        $url .='oai/';
        $url .='request?';
        $url .='verb=ListRecords';
        if (array_key_exists('resumptionToken',$data)) {
            $url .='&resumptionToken='.$data['resumptionToken'];
        }else{
            $url .='&resumptionToken=etdms';
        }
        if (array_key_exists('Today',$data)) {
            $hoy = date('Y-m-d');
            $data['from']=$hoy;
            $data['until']=$hoy;
        }

        $from = (array_key_exists('from',$data)) ? $data['from'].'T00:00:00Z' : '' ;
        $until = (array_key_exists('until',$data)) ? $data['until'].'T00:00:00Z' : '' ;
        $url .='/'.$from.'/'.$until.'/';

        if (array_key_exists('set',$data)) {
            $url .=$data['set'].'/';
        }

        $cnt = 0;
        $xml = simplexml_load_file($url.$cnt);
        $total = 0;
        $data = [];
        if ((string)$xml->error=="No matches for the query") {
            $urls['message']='No hay registros que cosechar';
        } else {
            $registros = 100;
            $urls = [];
            while ($registros > 0) {
                $xml = simplexml_load_file($url.$cnt);
                if ((string)$xml->error=="No matches for the query") {
                    $registros = 0;
                }else{
                    array_push($urls,$url.$cnt);
                    array_push($data,$xml->ListRecords);
                    $registros = $xml->ListRecords->record->count();
                    $total +=$registros;
                    $cnt += 100;
                }
            }
        }
        return [
            'urls'=>$urls,
            'total'=>$total,
            'data'=> $data
        ];
    }
    public function InsertData($data)
    {
        DB::table('resources')->truncate();
        foreach ($data as $key => $xml) {
            foreach ($xml->record as $key => $record) {
                Resources::create([
                    'header' => $record->header,
                    'metadata' => $record->metadata,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]);
            }
        }
    }
}