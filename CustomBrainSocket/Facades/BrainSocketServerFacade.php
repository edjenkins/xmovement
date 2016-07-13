<?php
namespace CustomBrainSocket\Facades;


use Illuminate\Support\Facades\Facade;

class CustomBrainSocket extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CustomBrainSocket';
    }
}
