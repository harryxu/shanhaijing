<?php

if (!function_exists('markdown')) {
    function markdown($text)
    {
        return app('markdown')->transformMarkdown($text);
    }
}
