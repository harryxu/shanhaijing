<?php

/**
 * Class Topiccontroller 
 * @author 
 */
class TopicController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->beforeFilter('login_required', array('only' => array(
            'create', 'store', 'edit', 'update', 'delete', 'destroy', 'postReply')));
    }

    public function index()
    {
        $topics = Topic::orderBy('last_post_at', 'DESC')->get();
        return View::make('topic/list', array(
            'topics' => $topics,
        ));
    }

    /**
     * Topic view page.
     */
    public function show($topic)
    {
        return View::make('topic/view', array(
            'topic' => $topic,
        ));
    }

    public function create()
    {
        return View::make('topic/topic_form');
    }

    public function store()
    {
        $validator = $this->validator();
        if ($validator->fails()) {
            return Redirect::to('topic/create')
                ->withErrors($validator)->withInput();
        }


        $user = Sentry::getUser();
        $topic = new Topic();
        $topic->user_id = $user->id;
        $topic->title = Input::get('title');
        $topic->last_post_at = $topic->freshTimestamp();
        $topic->posts_count = 1;
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


    public function edit($topic)
    {
        $user = Sentry::getUser();
        if ($user->id != $topic->user_id && !$user->hasAccess('topic.manage')) {
            App::abort(403);
        }
        return View::make('topic/topic_form', array(
            'topic' => $topic,
            'post' => Post::find($topic->first_post_id),
        ));
    }

    public function update($topic)
    {
        $user = Sentry::getUser();
        if ($user->id != $topic->user_id && !$user->hasAccess('topic.manage')) {
            App::abort(403);
        }

        DB::transaction(function() use($topic) {
            $topic->title = Input::get('title');
            $topic->save();

            $post = Post::find($topic->first_post_id);
            $post->body = Input::get('body');
            $post->save();
        });

        return Redirect::to('t/'.$topic->id);
    }

    public function delete($topic)
    {
        return 'Not implement yet.';
    }

    protected function validator()
    {
        $validator = Validator::make(Input::all(), array(
            'title' => 'required',
        ));
        return $validator;
    }
}

