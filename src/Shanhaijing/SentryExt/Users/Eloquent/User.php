<?php namespace Shanhaijing\SentryExt\Users\Eloquent;

use Cartalyst\Sentry\Users\Eloquent\User as SentryUser;
use Illuminate\Support\Facades\Config;

class User extends SentryUser
{
    public function getAvatar($style = 't')
    {
        if ($this->avatar == 'gravatar') {
            static $styles;
            if (!isset($styles)) {
                $styles = Config::get('shj.avatar_styles');
            }
            return $this->getGravatar($this->email, $styles[$style]);
        }
        else {
            return url('files/avatar/' . $this->id . '_' . $style . '.png');
        }
    }

    public function getGravatar($email, $s = 80, $d = 'mm', $r = 'g')
    {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        return $url;
    }
}

