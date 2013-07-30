<?php

class Category extends Eloquent 
{
    protected $table = 'categories';

    public function user()
    {
        return $this->belongsTo('Shanhaijing\SentryExt\Users\Eloquent\User');
    }

}
