<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Builder;

/**
 * Response Model
 * Represents a formal response to a respondable entity (Feedback, Complaint, etc.).
 */
class Response extends Model
{
    use HasFactory;

    protected $table = 'responses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'respondable_type',
        'respondable_id',
        'responder_id',
        'response_text',
        'is_public',
        'status_at_response',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_public' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the owning respondable model (e.g., Feedback, Complaint, BugReport).
     */
    public function respondable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who submitted the response (the staff/admin member).
     */
    public function responder(): BelongsTo
    {
        // Assuming your users table corresponds to the User model.
        return $this->belongsTo(User::class, 'responder_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include responses marked as public.
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }
}