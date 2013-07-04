<?php

class TopicUser extends Eloquent
{
    protected $table = 'topic_users';

    public $timestamps = false;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        self::saving(function($record) {
            if ($record->starred) {
                $record->starred_at = $record->freshTimestamp();
            }
        });
    }
    
}
