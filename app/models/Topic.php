<?php

class Topic extends Eloquent
{
    protected $talbe = 'topics';

    public function user()
    {
        return $this->belongsTo('Shanhaijing\SentryExt\Users\Eloquent\User');
    }

    public function posts()
    {
        $posts = Post::where('topic_id', $this->id)
            ->where('type', Post::TYPE_TOPIC_REPLY)
            ->get();
        return $posts;
    }
}

