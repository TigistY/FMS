<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Builder;

class Response extends Model
{
    use HasFactory;

    protected $table = 'responses';

    protected $fillable = [
        'respondable_type',
        'respondable_id',
        'responder_id',
        'response_text',
        'is_public',
        'status_at_response',
        'is_seen', 
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_seen' => 'boolean', 
    ];

public function getUnitNameAttribute()
{
    $user = $this->responder;

    if (!$user) {
        return 'System';
    }

    if ($user->department_id && $user->department) {
        return $user->department->name_en;
    }

    if ($user->college_id && $user->college) {
        return $user->college->name_en;
    }

    if ($user->directory_id && $user->directory) {
        return $user->directory->name_en;
    }
    
    return 'University Administration';
}

    public function respondable(): MorphTo
    {
        return $this->morphTo();
    }

    public function responder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responder_id');
    }

    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }
}