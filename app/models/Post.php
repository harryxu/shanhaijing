<?php

class Post extends Eloquent
{
    const TYPE_TOPIC_REPLY = 1;
    const TYPE_POST_REPLY = 2;

    public static function boot()
    {
        parent::boot();

        static::updated(function($post) {
            Cache::forget('post' . $post->id);
        });
    }

    public $renderedBody = null;

    protected $talbe = 'posts';

    protected $fillable = array('body');
    
    public function user()
    {
        return $this->belongsTo('Shanhaijing\SentryExt\Users\Eloquent\User');
    }

    public function topic()
    {
        return $this->belongsTo('Topic');
    }

    /**
     * Get a renderd topic model, then this model has propery like
     * renderedBody that can output to the browser.
     */
    public function rendered()
    {
        $model = $this;
        return Cache::remember('post' . $this->id, 60*24*30, function() use ($model) {
            Event::fire('post.render', array($model));
            return $this;
        });
    }
}

