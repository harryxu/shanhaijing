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
