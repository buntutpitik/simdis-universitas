<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DispositionRecipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'disposition_id',
        'user_id',
        'status',
        'processed_at',
        'completed_at',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'processed_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function disposition(): BelongsTo
    {
        return $this->belongsTo(
            Disposition::class,
            'disposition_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}