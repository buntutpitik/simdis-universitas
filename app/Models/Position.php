<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Position extends Model
{
    protected $fillable = [
        'uuid',
        'code',
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($position) {

            if (empty($position->uuid)) {
                $position->uuid = (string) Str::uuid();
            }

        });
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}