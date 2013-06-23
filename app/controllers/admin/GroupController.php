<?php

use Cartalyst\Sentry\Groups\Eloquent\Group;

/**
 * Class GroupController 
 * @author harryxu
 */
class GroupController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->beforeFilter('can:admin.group.manage');
    }

    public function index()
    {
        $groups = Group::all();
        return View::make('admin/group/index', array(
            'groups' => $groups,
        ));
    }

    public function create()
    {
        return View::make('admin/group/form');
    }

    public function store()
    {
        $validator = $this->validator();
        if ($validator->fails()) {
            return Redirect::to('admin/group/create')->withErrors($validator);
        }

        $group = Sentry::getGroupProvider()->create(array(
            'name' => Input::get('name'),
        ));

        return Redirect::to('admin/group');
    }

    public function edit($group)
    {
        return View::make('admin/group/form', array(
            'group' => $group,
        ));

    }

    public function update($group)
    {
        $validator = $this->validator();

        $redirector = Redirect::to('admin/group/' . $group->id . '/edit');
        if ($validator->fails()) {
            return $redirector->withErrors($validator);
        }

        $group->name = Input::get('name');
        $group->save();

        return $redirector;
    }

    protected function validator() 
    {
        $validator = Validator::make(Input::all(), array(
            'name' => 'required',
        ));
        $validator->setAttributeNames(array(
            'name' => 'Group name',
        ));

        return $validator;
    }
}
