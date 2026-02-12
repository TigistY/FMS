<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id',
        'guest_id',
        'recipient_id',
        'recipient_type',
        'subject',
        'body',
        'is_anonymous',
        'forwarded_from_user_id',
         'forward_note', 
         'status',
         'feedback_type',

    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    
    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
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