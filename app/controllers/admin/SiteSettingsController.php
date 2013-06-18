<?php

class SiteSettingsController extends AdminController
{

    public function getIndex()
    {
        return View::make('admin/site_settings');
    }

    public function postIndex()
    {
        Variable::set('sitename', Input::get('sitename'));
        return Redirect::refresh();
    }

}
