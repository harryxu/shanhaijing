<?php

class NotificationController extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->beforeFilter('login_required');
    }

    public function show($notifincation)
    {
        if ($notifincation->user_id != $this->user->id) {
            App::abort(403);
        }

        // Make notification as readed.
        $notifincation->readed = true;
        $notifincation->save();

        // TODO Make notification type detect more flex.
        switch ($notifincation->type) {
        case 'post':
            $post = Post::find($notifincation->item_id);
            return Redirect::to('t/' . $post->topic->id . '#post-' . $post->id);
        }
    }
}
