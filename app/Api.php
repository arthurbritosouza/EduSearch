<?php

namespace App;

class Api
{
    public static function endpoint(): string
    {
        return env('API_ENDPOINT');
    }
}
