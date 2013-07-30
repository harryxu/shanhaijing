<?php

class Cron
{
    public static function run()
    {
        $now = time();
        $lastCheckTime = Variable::get('system_cron_last', 0);
        Log::info('Checking for cron job');
        if ($lastCheckTime == 0 || $now - $lastCheckTime > Variable::get('system_cron_threshold', 3600)) {
            @ignore_user_abort(TRUE);
            if (Lock::acquire('cron', 240.0)) {
                Log::info('Starting cron job');

                // Notice: To avoid php execution timeout, all callback functions listen to this event should not
                // include time consuming procedures something like http/socket connections etc..
                Event::fire('system.cron');

                Variable::set('system_cron_last', $now);
                Lock::release('cron');
                Log::info('Cron job finished');
            } else {
                Log::warning('Attempting to re-run cron while it is already running.');
            }
        }
    }
}
