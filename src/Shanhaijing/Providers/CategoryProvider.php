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
        $noneCate = array( 'id' => 0, 'name' => 'No category', 'slug' => 'none');
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

    public function findBySlug($slug)
    {
        if ($slug == 'none') {
            return $this->noneCategory();
        }
        $model = $this->createModel();
        $category = $model->newQuery()->where('slug', $slug)->first();
        return $category;
    }

    public function noneCategory()
    {
        return (object)array(
            'id' => 0,
            'name' => 'None',
            'slug' => 'none',
        );
    }

    public function createModel()
    {
        return new \Category();
    }
}
