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
            'create', 'store', 'edit', 'update', 'delete', 'destroy')));
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
        if (Sentry::check()) {
            $topicUser = $this->getTopicUser($topic, $this->user);
        }

        return View::make('topic/view', array(
            'topic' => $topic,
            'topicUser' => isset($topicUser) ? $topicUser : new TopicUser(),
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
        if ($user->id != $topic->user_id && !$user->hasAccess('topic.update')) {
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
        if ($user->id != $topic->user_id && !$user->hasAccess('topic.update')) {
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

    public function star($topic)
    {
        $topicUser = $this->getTopicUser($topic, $this->user);
        if (empty($topicUser)) {
            $topicUser = new TopicUser();
            $topicUser->topic_id = $topic->id;
            $topicUser->user_id = $this->user->id;
        }

        $topicUser->starred = !$topicUser->starred;
        $topicUser->save();

        return Redirect::back();
    }

    /**
     * Toggle topic watching for user.
     */
    public function watch($topic)
    {
        $topicUser = $this->getTopicUser($topic, $this->user);
        if (empty($topicUser)) {
            $topicUser = new TopicUser();
            $topicUser->topic_id = $topic->id;
            $topicUser->user_id = $this->user->id;
        }

        $topicUser->watching = !$topicUser->watching;
        $topicUser->save();

        return Redirect::back();
    }

    protected function getTopicUser($topic, $user)
    {
        $topicUser = TopicUser::where('topic_id', $topic->id)
            ->where('user_id', $this->user->id)
            ->first();

        return $topicUser;
    }
}

