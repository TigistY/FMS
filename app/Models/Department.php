<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
    	'college_id', 
        'name_en',  
    	'name_am',
    	'head_name', 
    	'description'
    ];

    // one-to-one r/ship
    public function college()
    {
        return $this->belongsTo(College::class);
    }
}
