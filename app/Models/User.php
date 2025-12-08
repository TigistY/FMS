<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


use Spatie\Permission\Traits\HasRoles; 

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles; 
=======
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
>>>>>>> 2519b2a0d4037301a2c385ffa0ddbf468b9ecfb9

    /**
     * The attributes that are mass assignable.
     *
<<<<<<< HEAD
     * @var array<int, string>
=======
     * @var list<string>
>>>>>>> 2519b2a0d4037301a2c385ffa0ddbf468b9ecfb9
     */
    protected $fillable = [
        'name',
        'email',
        'password',
<<<<<<< HEAD
        'unit_id', 
=======
>>>>>>> 2519b2a0d4037301a2c385ffa0ddbf468b9ecfb9
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
<<<<<<< HEAD
     * @var array<int, string>
=======
     * @var list<string>
>>>>>>> 2519b2a0d4037301a2c385ffa0ddbf468b9ecfb9
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
<<<<<<< HEAD
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    // (One-to-Many inverse).
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
    
    
}
=======
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
>>>>>>> 2519b2a0d4037301a2c385ffa0ddbf468b9ecfb9
