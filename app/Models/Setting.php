<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get the specified setting value.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return cache()->rememberForever($key, function () use ($key, $default) {
            return static::where('key', $key)->value('value') ?? $default;
        });
    }

    /**
     * Perform any actions required after the model boots.
     */
    protected static function booted()
    {
        static::updated(function ($setting) {
            cache()->forget($setting->key);
        });
    }
}
