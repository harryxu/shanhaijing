<?php

use Shanhaijing\Support\Facades\Notification;

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

        // TODO Make notification type detect more flexible.
        switch ($notifincation->type) {
        case 'post':
            $post = Post::find($notifincation->item_id);
            return Redirect::to('t/' . $post->topic->id . '#post-' . $post->id);
        }
    }

    public function markAllAsRead()
    {
        Notification::markAllAsRead($this->user->id);
        return Redirect::back();
    }

    /**
     * Check for new notifications.
     */
    public function updates()
    {
        $time = time();
        $data = array('ts' => $time, 'notifications' => array());
        if (Input::has('ts')) {
            $timestamp = (int)Input::get('ts');
            $notifications = Notification::userNotifications(
                $this->user->id, $timestamp);

            if (!$notifications->isEmpty()) {
                $data['notifications'] = $notifications->toArray();
            }
        }

        return Response::json($data);
    }
}
