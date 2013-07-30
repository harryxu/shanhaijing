<?php

class Post extends Eloquent
{
    const TYPE_TOPIC_REPLY = 1;
    const TYPE_POST_REPLY = 2;

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
        Event::fire('post.render', array($this));
        return $this;
    }
}

