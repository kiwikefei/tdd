<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed channel
 */
class Thread extends Model
{
    protected $fillable = ['title', 'body', 'channel_id', 'user_id'];
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
       return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
