<?php

namespace JorarMarfin\MiPaquete\Facades;

use Illuminate\Support\Facades\Facade;

class MiPaqueteFacade extends Facade 
{
    protected static function getFacadeAccessor()
    {
        return 'MiPaquete';
    }
}
