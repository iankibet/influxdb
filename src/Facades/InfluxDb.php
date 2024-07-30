<?php

namespace Iankibet\InfluxDb\Facades;
use Illuminate\Support\Facades\Facade;

class InfluxDb extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'influx-db';
    }
}
