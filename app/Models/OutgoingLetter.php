<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingLetter extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
        'uuid',
        'agenda_number',
        'letter_number',
        'letter_date',
        'recipient',
        'regarding',
        'priority',
        'attachment',
        'description',
        'file',
        'created_by',
    ];

    protected $casts = [
        'letter_date' => 'date',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}