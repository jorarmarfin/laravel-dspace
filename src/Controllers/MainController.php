<?php

namespace JorarMarfin\LaravelDspace\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $url = config('dspace.url');
        $url .='oai/';
        $url .='request?';
        $url .='verb=ListRecords';
        if (array_key_exists('resumptionToken',$data)) {
            $url .='&resumptionToken='.$data['resumptionToken'];
        }else{
            $url .='&resumptionToken=etdms';
        }
        $from = (array_key_exists('from',$data)) ? $data['from'].'T00:00:00Z' : '' ;
        $until = (array_key_exists('until',$data)) ? $data['until'].'T00:00:00Z' : '' ;
        $url .='/'.$from.'/'.$until.'/';
        $cnt = 0;
        if (array_key_exists('set',$data)) {
            $url .=$data['set'].'/';
        }
        $xml = simplexml_load_file($url.$cnt);
        $registros = $xml->ListRecords->record->count();
        $urls = [];
        while ($registros > 0) {
            $xml = simplexml_load_file($url.$cnt);
            if ((string)$xml->error=="No matches for the query") {
                $registros = 0;
            }else{
                array_push($urls,$url.$cnt);
                $registros = $xml->ListRecords->record->count();
                $cnt += 100;
            }
        }
        dd($urls);
        // dd($xml->ListRecords->record->count());
        #https://infohub.practicalaction.org/oai/request?verb=ListRecords&resumptionToken=etdms///set=com_11283_320273/0
        #https://infohub.practicalaction.org/oai/request?verb=ListRecords&resumptionToken=oai_dc///com_11283_320273/0
        return $url;
    }
}