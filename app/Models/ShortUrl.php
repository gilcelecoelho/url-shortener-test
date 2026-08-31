<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ShortUrl extends Model
{
    protected $fillable = ['original_url', 'code'];

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public static function generateUniqueCode(int $length = 7): string
    {
        do {
            $code = Str::random($length);
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
