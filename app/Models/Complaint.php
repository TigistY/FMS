<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_id',
        'is_anonymous',
        'unit_id',
        'subject',
        'body',
        'status',    
        'priority',  
    ];
    
   

    
    protected $casts = [
        'is_anonymous' => 'boolean',
    ];

   
    //relationship

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
    public function guest()
    {
    
        return $this->belongsTo(Guest::class, 'guest_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
     public function responses()
    {
        return $this->morphMany(Response::class, 'respondable');
    }
}