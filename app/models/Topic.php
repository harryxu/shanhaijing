<?php

use Shanhaijing\SentryExt\Users\Eloquent\User;

class Topic extends Eloquent
{
    protected $talbe = 'topics';

    public function user()
    {
        return $this->belongsTo('Shanhaijing\SentryExt\Users\Eloquent\User');
    }

    public function category()
    {
        return $this->belongsTo('Category');
    }

    public function postedUsers()
    {
        $cacheKey = 'topic' . $this->id . '.postedUsers';
        $topic_id = $this->id;

        return Cache::remember($cacheKey, 60*24*30, function() use ($topic_id)
        {
            $postModel = new Post();
            $user_ids = $postModel->newQuery()->where('topic_id', $topic_id)
                ->distinct()
                ->get(array('user_id'));
            $users = array();
            foreach ($user_ids as $item) {
                $users[$item->user_id] = User::find($item->user_id, array(
                    'id', 'username',
                ));
            }
            
            return $users;
        });
    }

    public function posts()
    {
        $posts = Post::where('topic_id', $this->id)
            ->where('type', Post::TYPE_TOPIC_REPLY)
            ->get();
        return $posts;
    }

}

