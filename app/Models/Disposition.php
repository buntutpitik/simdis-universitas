<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Disposition extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
        'uuid',
        'incoming_letter_id',
        'instruction',
        'note',
        'priority',
        'deadline',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
        ];
    }

    public function incomingLetter(): BelongsTo
    {
        return $this->belongsTo(
            IncomingLetter::class,
            'incoming_letter_id'
        );
    }

    
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(
            DispositionRecipient::class,
            'disposition_id'
        );
    }
}