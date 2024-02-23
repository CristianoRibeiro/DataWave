<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'content', 'media', 'type'
    ];


     /**
     * Get the hashtags associated with the tweet.
     */
    public function hashtags(): BelongsToMany
    {
        return $this->belongsToMany(Hashtag::class);
    }

    /**
     * Get the user that owns the tweet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
