<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_am',
        'name_en', 
        'code',
        'email',
    ];

    public function responders(): HasMany
    {
    
        return $this->hasMany(User::class);
    }

    
    public function feedbacks(): HasMany
    {
        
        return $this->hasMany(Feedback::class); 
    }

    
    public function complaints(): HasMany
    {
       
        return $this->hasMany(Complaint::class); 
    }
}