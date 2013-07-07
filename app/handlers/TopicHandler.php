<?php

/**
 * Class TopicHandler 
 * @author 
 */
class TopicHandler
{
    public function onCreate($topic)
    {
        // Topic creator will auto watching the topic.
        $topicUser = new TopicUser();
        $topicUser->topic_id = $topic->id;
        $topicUser->user_id = $topic->user->id;
        $topicUser->watching = true;
        $topicUser->save();
    }
}

