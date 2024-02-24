<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Retweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'tweet_id', 'original_tweet_id'
    ];

    /**
     * Get the user that owns the retweet.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tweet that owns the retweet.
     */
    public function tweet(): BelongsTo
    {
        return $this->belongsTo(Tweet::class);
    }

    /**
     * Get the original tweet that was retweeted.
     */
    public function originalTweet(): BelongsTo
    {
        return $this->belongsTo(Tweet::class, 'original_tweet_id');
    }
}
