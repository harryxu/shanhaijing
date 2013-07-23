<?php

use Illuminate\Support\Facades\Cache;

class CategoryHandler
{
    public function clearCache($category)
    {
        Cache::forget('all_categories');
    }
}

