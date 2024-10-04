<?php

namespace App\Http\Services;

use Illuminate\Support\Str;

class RandomStringGenerator implements IRandomStringGenerator
{
    public function generateRandomString($length = 10): string {
        return Str::random(20);
    }
}
