<?php

use Shanhaijing\Providers\CategoryProvider;

/**
 * Class Topiccontroller 
 * @author 
 */
class TopicController extends BaseController
{

    protected $categoryProvider;

    public function __construct(CategoryProvider $categoryProvider)
    {
        parent::__construct();

        $this->categoryProvider = $categoryProvider;

        $this->beforeFilter('login_required', array('only' => array(
            'create', 'store', 'edit', 'update', 'delete', 'destroy')));
    }

    public function index()
    {
        $topics = Topic::orderBy('last_post_at', 'DESC')->paginate(20);
        return View::make('topic/list', array(
            'topics' => $topics,
            'categories' => $this->categoryProvider->findAll(),
        ));
    }

    /**
     * List topics by category.
     */
    public function category($slug)
    {
        $category = $this->categoryProvider->findBySlug($slug);
        if (!$category) {
            App::abort(404);
        }
        $topics = Topic::where('category_id', $category->id)
            ->orderBy('last_post_at', 'DESC')->paginate(20);

        return View::make('topic/list', array(
            'topics' => $topics,
            'category' => $category,
            'categories' => $this->categoryProvider->findAll(),
        ));
    }

    /**
     * Topic view page.
     */
    public function show($topic)
    {
        if (Sentry::check()) {
            $topicUser = $this->getTopicUser($topic, $this->user);

            // Add posted users to javascript settings for mention in
            // reply editor.
            // TODO Make this as a ajax response.
            $postedUsers = array();
            foreach ($topic->postedUsers() as $user) {
                $postedUsers[] = $user->toArray();
            }
            shanhaijing_add_js(array(
                'topic' => array(
                    'id' => $topic->id,
                    'postedUsers' => $postedUsers,
                ),
            ));
        }

        return View::make('topic/view', array(
            'topic' => $topic,
            'topicUser' => isset($topicUser) ? $topicUser : new TopicUser(),
        ));
    }

    public function create()
    {
        return View::make('topic/topic_form', array(
            'categories' => $this->categoryProvider->findAll(),
        ));
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
        $topic->category_id = Input::get('category_id');
        $topic->posts_count = 1;
        $topic->save();

        $post = new Post();
        $post->user_id = $user->id;
        $post->topic_id = $topic->id;
        $post->body = Input::get('body');
        $post->save();

        $topic->first_post_id = $post->id;
        $topic->save();

        Event::fire('topic.create', array($topic));

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
            'categories' => $this->categoryProvider->findAll(),
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
            $topic->category_id = Input::get('category_id');
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
        $provider = $this->categoryProvider;
        Validator::extend('cateexist', function($attribute, $value, $parameters) use ($provider)
        {
            $categories = $provider->findAll();
            return array_key_exists($value, $categories);
        });

        $validator = Validator::make(Input::all(), array(
            'title' => 'required',
            'category_id' => 'cateexist',
        ));
        return $validator;
    }

    /**
     * Toggle topic starred for user.
     */
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

