<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class TwitterParse extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'twitterParse';
    }
}