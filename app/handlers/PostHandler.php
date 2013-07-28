<?php

class PostHandler
{

    public $mentionRegex = '/(^|\s|\>)(@)(\w+)(?:\s|$)/';

    public function onCreate($post)
    {
        $topic = $post->topic;
        $this->sendNotification($post, $topic);
        $this->clearCache($post, $topic);
    }

    protected function sendNotification($post, $topic)
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
            $noti->msg = 'New post on ' . $topic->title;
            $noti->save();
        }
    }

    protected function clearCache($post, $topic)
    {
        $postedUsers = $topic->postedUsers();
        if (!isset($postedUsers[$post->user_id])) {
            // New user joined the topic, 
            // clear the postedUsers cache for the topic.
            Cache::forget('topic' . $topic->id . '.postedUsers');
        }
    }

    public function onRender($post)
    {
        $text = empty($post->renderedBody) ? $post->body : $post->renderedBody;
        $text = app('htmlpurifier')->purify($text);
        $text = app('markdown')->transformMarkdown($text);
        $text = preg_replace($this->mentionRegex, 
            '$1<a href="'.url('user/$3').'">$2$3</a>' , $text);
        $post->renderedBody = $text;
    }
}

