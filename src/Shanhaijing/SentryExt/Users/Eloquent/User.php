<?php namespace Shanhaijing\SentryExt\Users\Eloquent;

use Cartalyst\Sentry\Users\Eloquent\User as SentryUser;

class User extends SentryUser
{
    public function getAvatar($size = 64)
    {
        return $this->getGravatar($this->email, $size);
    }

    public function getGravatar($email, $s = 80, $d = 'mm', $r = 'g')
    {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        return $url;
    }
}

