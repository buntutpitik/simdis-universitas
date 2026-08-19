<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Models\User;

class IncomingLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'agenda_number',
        'letter_number',
        'letter_date',
        'received_date',
        'sender',
        'regarding',
        'priority',
        'attachment',
        'file',
        'description',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'letter_date' => 'date',
            'received_date' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($letter) {

            $letter->uuid = Str::uuid();

        });
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function dispositions(): HasMany
    {
        return $this->hasMany(
            Disposition::class,
            'incoming_letter_id'
        );
    }
}