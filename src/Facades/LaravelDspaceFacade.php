<?php

namespace JorarMarfin\LaravelDspace\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelDspaceFacade extends Facade 
{
    protected static function getFacadeAccessor()
    {
        return 'LaravelDspace';
    }
}
