<?php

class Post extends Eloquent
{
    const TYPE_TOPIC_REPLY = 1;
    const TYPE_POST_REPLY = 2;

    protected $talbe = 'posts';
}

