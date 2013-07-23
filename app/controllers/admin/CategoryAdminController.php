<?php

class CategoryAdminController extends AdminController 
{
    public function index()
    {
        return View::make('admin/category/index', array(
            'categories' => Category::all(),
        ));
    }

    public function create()
    {
        return View::make('admin/category/form', array(
            'category' => new Category(),
        ));
    }

    public function store()
    {
        $validator = $this->validator();
        if ($validator->fails()) {
            return Redirect::to('admin/category/create')
                ->withErrors($validator)->withInput();
        }
        $category = new Category();
        $category->name = trim(Input::get('name'));
        $category->slug = trim(Input::get('slug'));
        $category->description = Input::get('description');
        $category->save();

        Event::fire('category.create', array($category));

        return Redirect::to('admin/category')
            ->with('success', Lang::get('misc.category_create_success'));
    }

    public function edit($category)
    {
        return View::make('admin/category/form', array(
            'category' => $category,
        ));
    }

    public function update($category)
    {
        $validator = $this->validator($category);

        if ($validator->fails()) {
            return Redirect::to('admin/category/' . $category->id . '/edit')
                ->withErrors($validator)->withInput();
        }
        $category->name = trim(Input::get('name'));
        $slug = trim(Input::get('slug'));
        if ($category->slug != $slug) {
            $category->slug = $slug;
        }
        $category->description = Input::get('description');
        $category->save();

        Event::fire('category.update', array($category));

        return Redirect::to('admin/category/' . $category->id . '/edit')
            ->with('success', Lang::get('misc.category_update_success'));
    }

    protected function validator($category = null)
    {
        $rules = array('name' => 'required');
        if ($category == null || Input::get('slug') != $category->slug) {
            $rules['slug'] = 'required|slug|unique:categories';
        }
        $validator = Validator::make(Input::all(), $rules);

        return $validator;
    }
}
