<?php

class PostController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->beforeFilter('login_required', array('only' => array(
            'store', 'edit', 'update', 'delete', 'destroy', 'postReply')));
    }

    public function store()
    {
        $topic_id = Input::get('topic_id');
        if (empty($topic_id)) {
            App::abort(404);
        }

        $validator = $this->validator();
        if ($validator->fails()) {
            return Redirect::to('t/' . $topic_id . '#reply')
                ->withErrors($validator)->withInput();
        }

        $topic = Topic::find(Input::get('topic_id'));
        if (!$topic) {
            App::abort(404);
        }

        $post = Post::create(array(
            'body' => Input::get('body'),
        ));
        $post->user_id = Sentry::getUser()->id;
        $post->topic_id = $topic->id;

        DB::transaction(function() use ($topic, $post) {
            $post->save();
            $topic->last_post_at = $topic->freshTimestamp();
            $topic->posts_count += 1; // TODO
            $topic->save();
        });

        return redirect::to('t/' . $topic->id . '#post-' . $post->id);
    }

    public function edit($post)
    {
        if ($this->user->id !== $post->user->id && !$this->user->hasAccess('post.update')) {
            App::abort(403);
        }

        return View::make('post/form', array('post' => $post));
    }

    public function update($post)
    {
        if ($this->user->id !== $post->user->id && !$this->user->hasAccess('post.update')) {
            App::abort(403);
        }

        $validator = $this->validator();
        if ($validator->fails()) {
            return Redirect::to('post/' . $post->id . '/edit')
                ->withErrors($validator)->withInput();
        }

        $post->body = Input::get('body');
        $post->save();

        return Redirect::to('t/' . $post->topic_id . '#post-' . $post->id);
    }

    public function delete($post)
    {
        return 'Not implement yet.';
    }

    protected function validator()
    {
        $validator = Validator::make(Input::all(), array(
            'body' => 'required',
        ));
        return $validator;
    }
}
