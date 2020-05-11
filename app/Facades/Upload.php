<?php


namespace App\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * @method static void save()
 *
 * Class UploadFacade
 * @package App\Facades
 */
class Upload extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Lib\Upload::class;
    }
}