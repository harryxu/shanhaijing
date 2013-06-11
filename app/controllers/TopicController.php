<?php

/**
 * Class Topiccontroller 
 * @author 
 */
class TopicController extends BaseController
{
    public function __construct()
    {
        $this->beforeFilter('login_required', array('only' => array(
            'getCreate', 'postCreate')));
    }

    public function topicList()
    {
        return View::make('topic/list');
    }

    public function getCreate()
    {
        return View::make('topic/topic_form');
    }

    public function postCreate()
    {
        $user = Sentry::getUser();
        $topic = new Topic();
        $topic->user_id = $user->id;
        $topic->title = Input::get('title');
        $topic->save();

        $post = new Post();
        $post->user_id = $user->id;
        $post->topic_id = $topic->id;
        $post->body = Input::get('body');
        $post->save();

        $topic->first_post_id = $post->id;
        $topic->save();

        return Redirect::to('t/'.$topic->id);
    }

    public function view()
    {
        
    }
}

