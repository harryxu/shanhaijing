<?php namespace Shanhaijing\Notification;

class Provider {

    protected $model = 'Notification';
    
    public function __construct($model = null)
    {
        if (isset($model)) {
            $this->model = $model;
        }
    }

    /**
     * Get unread notifications for user.
     */
    public function userNotifications($user_id, $startTime = null)
    {
        $model = $this->createModel();
        $query = $model->newQuery()->where('user_id', $user_id)
            ->where('readed', false);
        if (isset($startTime)) {
            $dt = new \DateTime();
            $dt->setTimestamp($startTime);
            $query->where('created_at' , '>=', $dt);
        }

        return $query->get();
    }

    protected function createModel()
    {
        $class = '\\'.ltrim($this->model, '\\');

        return new $class;
    }
}
