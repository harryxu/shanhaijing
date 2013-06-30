<?php

if (!function_exists('markdown')) {
    function markdown($text)
    {
        return app('markdown')->transformMarkdown($text);
    }
}

if (!function_exists('filtertext')) {
    function filtertext($text, $mode=null)
    {
        $text = app('htmlpurifier')->purify($text);
        $text = markdown($text);
        return $text;
    }
}

if (!function_exists('time_passed')) {
    function time_passed($datetime)
    {
        return $datetime->diffForHumans();

        /*
        // http://www.devnetwork.net/viewtopic.php?f=50&t=113253&sid=67682b6719f7cd78d906cccc8e5ad09c#p595063
        $diff = time() - (int)$timestamp;

        if ($diff == 0) {
             return 'just now';
        }

        $intervals = array(
            1                   => array('year',    31556926),
            $diff < 31556926    => array('month',   2628000),
            $diff < 2629744     => array('week',    604800),
            $diff < 604800      => array('day',     86400),
            $diff < 86400       => array('hour',    3600),
            $diff < 3600        => array('minute',  60),
            $diff < 60          => array('second',  1)
        );

         $value = floor($diff/$intervals[1][1]);
         return $value.' '.$intervals[1][0].($value > 1 ? 's' : '').' ago';
        */
    }
}

/**
 * Add or get javascript.
 */
if (!function_exists('shanhaijing_add_js')) {
    function shanhaijing_add_js($data = null, $type = 'setting')
    {
        static $js = array('settings' => array());

        if (isset($data)) {
            switch ($type) {
            case 'setting':
                $js['settings'] = array_merge($js['settings'], $data);
                break;
            }
        }

        return $js;
    }
}
