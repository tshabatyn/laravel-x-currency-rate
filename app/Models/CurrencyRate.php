<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    use HasFactory;

    protected static $ignoreTimestampsOn = [
        self::class
    ];

    protected $fillable = ['from', 'to', 'rate', 'date'];
}
