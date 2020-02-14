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
}