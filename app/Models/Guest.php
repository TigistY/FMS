<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    /**
     *
     * @var string
     */
    protected $table = 'guests'; 

    /**
     *
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'guest_type',
    ];

    /**
     * The attributes that should be cast.
     * * @var array
     */
    protected $casts = [
       
    ];


    
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'guest_email_id');
    }
}