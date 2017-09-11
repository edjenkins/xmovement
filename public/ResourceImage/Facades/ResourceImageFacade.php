<?php
namespace ResourceImage\Facades;


use Illuminate\Support\Facades\Facade;

class ResourceImage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ResourceImage';
    }
}
