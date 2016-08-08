<?php
namespace TranslateMate\Facades;


use Illuminate\Support\Facades\Facade;

class TranslateMate extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'TranslateMate';
    }
}
