<?php namespace Shanhaijing\Providers;

use Illuminate\Support\Facades\Cache;

class CategoryProvider
{
    public function findAll()
    {
        if (Cache::has('all_categories')) {
            return Cache::get('all_categories');
        } 

        $model = $this->createModel();
        $collection = $model->newQuery()->orderBy('weight')->get();

        // Add a none category option.
        $noneCate = array( 'id' => 0, 'name' => 'No category');
        $collection->push((object)$noneCate);

        // Create a key(id) => value(Category object) array 
        // to hole all categories.
        $categories = array();
        $collection->each(function($cate) use (&$categories) { 
            $categories[$cate->id] = $cate;
        });

        Cache::forever('all_categories', $categories);

        return $categories;
    }

    public function createModel()
    {
        return new \Category();
    }
}
