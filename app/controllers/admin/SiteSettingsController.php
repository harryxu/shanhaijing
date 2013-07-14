<?php


class SiteSettingsController extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->beforeFilter('can:admin.site_settings');
    }

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
