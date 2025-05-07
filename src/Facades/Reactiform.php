<?php

namespace Incodiy\Reactiform\Facades;

use Illuminate\Support\Facades\Facade;

class Reactiform extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'reactiform';
    }
}