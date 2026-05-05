<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\Crypt;

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
       //'name' => 'encrypted',
    ];

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'guest_id');
    }
    public function complaints()
    {
    //return $this->hasMany(Complaint::class, 'guest_email_id');
        return $this->hasMany(Complaint::class, 'guest_id');
    }
}