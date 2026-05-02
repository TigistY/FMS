<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_id',
        'recipient_id',
        'recipient_type',
        'subject',
        'body',
        'status',
        'priority',
        'is_anonymous',
        'forwarded_from_user_id', 
        'forward_note',           
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

    
    
    public function recipient(): MorphTo
    {
        return $this->morphTo();
    }
    
     public function responses()
    {
        return $this->morphMany(Response::class, 'respondable');
    }
    public function forwarder()
{
    return $this->belongsTo(User::class, 'forwarded_from_user_id');
}
}