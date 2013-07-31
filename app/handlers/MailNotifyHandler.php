<?php

class MailNotifyHandler {

    function onAggregateNotification()
    {
        $lastID = Variable::get('notification_email_cron', 0);
        $results = DB::select('SELECT id, msg, user_id, type FROM notifications WHERE id > ? AND type = "post" AND readed = 0 ORDER BY id ASC LIMIT ?', array($lastID, Variable::get('notification_email_limit', 20)));
        if (!empty($results)) {
            $len = count($results);

            $uids = array();
            $messages = array();

            foreach ($results as $value) {
                $uids[] = $value->user_id;
                $messages[$value->user_id] = $value->msg;
            }

            $users = DB::table('users')->whereIn('id', $uids)->get();
            $site_name = Variable::get('sitename', 'shanhaijing');

            foreach ($users as $u) {
                $data['user'] = $u;
                $data['msg'] = $messages[$u->id];
                $data['site_name'] = $site_name;
                Mail::queue('email/notification', $data, function($message) use ($u, $site_name) {
                    $message->to($u->email, $u->username)->subject('Message from '.$site_name);
                });
            }

            Variable::set('notification_email_cron', $results[$len-1]->id);
            Log::info('Sent email notifications.');
        } else {
            Log::info('No email notification needs to be sent.');
        }
    }

}
