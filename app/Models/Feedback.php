<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feedback extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'feedbacks';

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'unit_id',
        'guest_id',
        'subject',
        'body',
        'is_anonymous',
       
    ];

    /**
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = [
        'is_anonymous' => 'boolean',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function responses()
    {
        return $this->morphMany(Response::class, 'respondable');
    }
}