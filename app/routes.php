<?php

// Model bindings.
Route::model('user', 'Shanhaijing\SentryExt\Users\Eloquent\User');
Route::model('group', 'Cartalyst\Sentry\Groups\Eloquent\Group');
Route::model('topic', 'Topic');
Route::model('post', 'Post');
Route::model('notification', 'Notification');
Route::model('category', 'Category');

// All post form need csrf protection.
Route::when('*', 'csrf', array('post', 'put'));

// Site home page.
Route::get('/', 'TopicController@index');

// Account
Route::controller('account', 'AccountController');

// Topic
Route::get('t/{topic}', 'TopicController@show');
Route::resource('topic', 'TopicController');
Route::get('topic/{topic}/delete', 'TopicController@delete');
Route::any('topic/{topic}/watch', array('uses' =>  'TopicController@watch', 
                                        'before' => array('csrf', 'login_required')));
Route::any('topic/{topic}/star', array('uses' => 'TopicController@star', 
                                       'before' => array('csrf', 'login_required')));

// Post
Route::resource('post', 'PostController');
Route::get('post/{post}/delete', 'PostController@delete');

// Notification
Route::post('notification/updates', 'NotificationController@updates');
Route::any('notification/markallasread', array('uses' => 'NotificationController@markAllAsRead',
    'before' => 'csrf'));
Route::resource('notification', 'NotificationController', array('before' => 'login_required'));

// User
Route::get('user/{username}', 'UserController@show');
Route::get('user/{username}/starred', 'UserController@starred');

// Account settings
Route::controller('user/{username}/settings', 'AccountSettingsController');


/**
 * Route hack: remove some cpanel routes, so we can use our routes 
 * and do not need change cpanel views.
 * see:
 *  http://api.symfony.com/2.3/Symfony/Component/Routing/RouteCollection.html#method_remove
 */
if (Route::getRoutes()->get('admin.groups.permissions') != null) {
    Route::getRoutes()->remove('admin.groups.permissions');
}

// remove route that do not have a `as` name.
// see http://laravel.com/api/source-class-Illuminate.Routing.Router.html#_getName
if (route::getroutes()->get('put admin/groups/{groups}/permissions') != null) {
    route::getroutes()->remove('put admin/groups/{groups}/permissions');
}

if (Route::getRoutes()->get('admin.users.permissions') != null) {
    Route::getRoutes()->remove('admin.users.permissions');
}
if (route::getroutes()->get('put admin/users/{users}/permissions') != null) {
    route::getroutes()->remove('put admin/users/{users}/permissions');
}

// Admin
Route::group(array('prefix' => 'admin', 'before' => 'login_required'), function()
{
    // site settings
    Route::controller('settings', 'SiteSettingsController', array(
        'getIndex' => 'admin.settings.index',
    ));

    Route::resource('category', 'CategoryAdminController');

    // Cpanel Groups Permissions Routes
    Route::get('groups/{group}/permissions', array(
        'as'     => 'admin.groups.permissions',
        'uses'   => 'GroupsPermissionsController@index',
        'before' => 'auth.cpanel:groups.update'
    ));
    Route::put('groups/{group}/permissions', array(
        'uses'   => 'GroupsPermissionsController@update',
        'before' => 'auth.cpanel:groups.update'
    ));

    // Cpanel Users Permissions Routes
    Route::get('users/{user}/permissions', array(
        'as'     => 'admin.users.permissions',
        'uses'   => 'UsersPermissionsController@index',
        'before' => 'auth.cpanel:users.update'
    ));
    Route::put('users/{user}/permissions', array(
        'uses'   => 'UsersPermissionsController@update',
        'before' => 'auth.cpanel:users.update'
    ));

});


// static pages
Route::get('opensource', function() {
    return View::make('static/opensource');
});
