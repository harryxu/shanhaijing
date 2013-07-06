<?php

class PostHander
{
    function onCreate($post)
    {
        $users = TopicUser::where('topic_id', $post->topic_id)
            ->where('watching', true)
            ->get(array('user_id'));

        foreach ($users as $user) {
            if ($user->user_id == $post->user_id) {
                continue;
            }
            $noti = new Notification();
            $noti->user_id = $user->user_id;
            $noti->type = 'post';
            $noti->item_id = $post->id;
            $noti->msg = 'New post on ' . $post->topic->title;
            $noti->save();
        }
    }
}

