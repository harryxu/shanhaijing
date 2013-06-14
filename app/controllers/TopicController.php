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
            'getCreate', 'postCreate', 'postReply')));
    }

    public function topicList()
    {
        $topics = Topic::orderBy('updated_at', 'DESC')->get();
        return View::make('topic/list', array(
            'topics' => $topics,
        ));
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

    /**
     * Topic view page.
     */
    public function getView($id)
    {
        $topic = Topic::find($id);
        return View::make('topic/view', array(
            'topic' => $topic,
        ));
    }

    /**
     * Post a new reply to a topic.
     */
    public function postReply()
    {
        $topic = Topic::find(Input::get('topic_id'));

        $post = Post::create(array(
            'body' => Input::get('body'),
        ));
        $post->user_id = Sentry::getUser()->id;
        $post->topic_id = $topic->id;
        $post->save();
        $topic->touch();

        return Redirect::to('t/' . $topic->id . '#post-' . $post->id);
    }
}

