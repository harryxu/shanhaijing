<?php

class MailNotifyHandler {

    function onAggregateNotification()
    {
        $lastID = Variable::get('notification_email_cron', 0);
        $results = DB::select('SELECT id, msg, user_id FROM notifications WHERE id > ? AND type = "post" AND readed = 0 ORDER BY id ASC LIMIT ?', array($lastID, Variable::get('notification_email_limit', 20)));
        if (!empty($results)) {
            $len = count($results);
            Variable::set('notification_email_cron', $results[$len-1]->id);
            // TODO Add all theses notifications to the queue.
        }
    }

}
