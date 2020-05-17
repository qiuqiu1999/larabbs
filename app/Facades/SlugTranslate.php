<?php


namespace App\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * @method static string translate(string $text)
 *
 * Class SlugTranslate
 * @package App\Facades
 */
class SlugTranslate extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Lib\SlugTranslate::class;
    }
}