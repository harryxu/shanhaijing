<?php

use Cartalyst\Sentry\Users\UserNotFoundException;

class PostHandler
{

    public $mentionRegex = '/(^|\s|\>)(@)(\w+)/';

    public function onCreate($post)
    {
        $topic = $post->topic;
        $this->sendWatcherNotification($post, $topic);
        $this->sendMentionNotification($post, $topic);
        $this->clearCache($post, $topic);
    }

    /**
     * Send notification to topic watchers
     */
    protected function sendWatcherNotification($post, $topic)
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

    /**
     * Send notification to users who has been mentioned at reply.
     */
    protected function sendMentionNotification($post, $topic)
    {
        preg_match_all($this->mentionRegex, $post->body, $matches);
        $usernames = array_unique($matches[3]);
        foreach ($usernames as $username) {
            // Do not notify self.
            if ($username == $post->user->username) {
                continue;
            }

            try {
                $user = Sentry::getUserProvider()->findByUsername($username);

                $noti = new Notification();
                $noti->user_id = $user->id;
                $noti->type = 'post';
                $noti->item_id = $post->id;
                $noti->msg = $post->user->username . ' mention you at topic ' . $topic->title;
                $noti->save();
            }
            catch (UserNotFoundException $e) {
                // The mention is not a exist user, no matter.
                continue;
            }
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
            '$1<a href="' . url('user/$3') . '">$2$3</a>', $text);
        $post->renderedBody = $text;
    }
}

