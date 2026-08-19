<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [

        'uuid',
        'position_id',
        'full_name',
        'email',
        'password',
        'phone',
        'avatar',
        'is_active'

    ];

    protected $hidden = [

        'password',
        'remember_token',

    ];

    protected function casts(): array
    {
        return [

            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',

        ];
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function adminlte_image()
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name);
    }

    public function adminlte_desc()
    {
        return $this->getRoleNames()->first() ?? '-';
    }

    public function adminlte_profile_url()
    {
        return '#';
    }

    
    public function createdDispositions(): HasMany
    {
        return $this->hasMany(
            Disposition::class,
            'created_by'
        );
    }

    public function dispositionRecipients(): HasMany
    {
        return $this->hasMany(
            DispositionRecipient::class,
            'user_id'
        );
    }

    
}