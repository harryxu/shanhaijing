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
        return View::make('admin/category/form');
    }

    public function store()
    {
        $validator = $this->validator();
        if ($validator->fails()) {
            return Redirect::to('admin/category/create')
                ->withErrors($validator)->withInput();
        }
        $categroy = new Category();
        $categroy->name = trim(Input::get('name'));
        $categroy->slug = trim(Input::get('slug'));
        $categroy->description = Input::get('description');
        $categroy->save();

        Event::fire('category.create', array($categroy));

        return Redirect::to('admin/category')
            ->with('success', Lang::get('misc.category_create_success'));
    }

    protected function validator()
    {
        $validator = Validator::make(Input::all(), array(
            'name' => 'required',
            'slug' => 'required|slug|unique:categories',
        ));

        return $validator;
    }
}
