<?php

class PostHander
{
    function onCreate($post)
    {
        $user_id = $post->topic->user_id;
        if ($user_id != $post->user_id) {
            $noti = new Notification();
            $noti->user_id = $user_id;
            $noti->type = 'post';
            $noti->item_id = $post->id;
            $noti->msg = 'New post on ' . $post->topic->title;
            $noti->save();
        }
    }
}

