<?php

class Notification extends Eloquent
{
    protected $table = 'notifications';

    public function user()
    {
        return $this->belongsTo('Shanhaijing\SentryExt\Users\Eloquent\User');
    }
}
