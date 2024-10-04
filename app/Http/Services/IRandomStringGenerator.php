<?php

namespace App\Http\Services;

use Illuminate\Support\Str;

interface IRandomStringGenerator
{
    public function generateRandomString($length): string;
}
