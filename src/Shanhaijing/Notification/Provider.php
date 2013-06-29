<?php namespace Shanhaijing\Notification;

class Provider {

    protected $model = 'Notification';
    
    public function __construct($model = null)
    {
        if (isset($model)) {
            $this->model = $model;
        }
    }

    public function userNotifications($user_id, $readed = false)
    {
        $model = $this->createModel();
        $notifincations = $model->newQuery()->where('user_id', $user_id)
            ->where('readed', $readed)
            ->get();

        return $notifincations;
    }

    protected function createModel()
    {
        $class = '\\'.ltrim($this->model, '\\');

        return new $class;
    }
}
