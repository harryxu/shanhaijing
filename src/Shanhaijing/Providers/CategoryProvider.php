<?php namespace Shanhaijing\Providers;

use Illuminate\Support\Facades\Cache;

class CategoryProvider
{
    public function findAll()
    {
        if (Cache::has('all_categories')) {
            return Cache::get('all_categories');
        } 
        else {
            $model = $this->createModel();
            $categories = $model->newQuery()->orderBy('weight')
                ->get()->all();
            $noneCate = array(
                'id' => 0,
                'name' => 'No category',
            );
            array_unshift($categories, (object)$noneCate);
            Cache::forever('all_categories', $categories);
            return $categories;
        }
    }

    public function createModel()
    {
        return new \Category();
    }
}
