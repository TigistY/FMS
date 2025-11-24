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
        // 'status', // እነዚህን በኋላ ላይ ለመጨመር ይችላሉ
        // 'response',
    ];

    /**
     * The attributes that should be cast to native types.
     * * is_anonymousን እንደ boolean ለማስኬድ አስፈላጊ ነው።
     * @var array
     */
    protected $casts = [
        'is_anonymous' => 'boolean',
    ];


    // ሪሌሽንሺፕ (Relationships)

    /**
     * Get the registered user who submitted the feedback.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the unit that the feedback belongs to.
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Get the responses for the feedback.
     * * አሁን ወደ ትክክለኛው Response ሞዴል ይጠቁማል።
     */
    public function responses(): HasMany
    {
        // Response ሞዴል ለሁለቱም ለቅሬታ እና ለግብረመልስ የሚውል ከሆነ
        return $this->hasMany(Response::class);
    }
}