<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Define o relacionamento para os tweets que este usuário curtiu.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Define o relacionamento para os tweets que este usuário retweetou.
     */
    public function retweets()
    {
        return $this->hasMany(Retweet::class);
    }

    /**
     * Define o relacionamento para os comentários feitos por este usuário.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Permite que o usuário curta um tweet.
     */
    public function like(Tweet $tweet)
    {
        $this->likes()->create(['tweet_id' => $tweet->id]);
    }

    /**
     * Permite que o usuário descurta um tweet.
     */
    public function unlike(Tweet $tweet)
    {
        $this->likes()->where('tweet_id', $tweet->id)->delete();
    }

    /**
     * Permite que o usuário retweete um tweet.
     */
    public function retweet(Tweet $tweet)
    {
        $this->retweets()->create(['tweet_id' => $tweet->id]);
    }

    /**
     * Permite que o usuário comente um tweet.
     */
    public function comment(Tweet $tweet, $content)
    {
        $tweet->comments()->create(['user_id' => $this->id, 'content' => $content]);
    }
}
