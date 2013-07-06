<?php

// Model bindings.
Route::model('user', 'Shanhaijing\SentryExt\Users\Eloquent\User');
Route::model('group', 'Cartalyst\Sentry\Groups\Eloquent\Group');
Route::model('topic', 'Topic');
Route::model('post', 'Post');
Route::model('notification', 'Notification');

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

// Admin
Route::group(array('prefix' => 'admin', 'before' => 'login_required'), function()
{
    // site settings
    Route::controller('settings', 'SiteSettingsController');

    // user admin
    Route::get('user', array('uses' => 'UserAdminController@index',
        'before' => 'can:admin.user.list'));
    Route::any('user/{user}/permissions', array('uses' => 'UserAdminController@permissions',
        'before' => 'can:admin.user.permission'));

    Route::resource('group', 'GroupController');
});


// static pages
Route::get('opensource', function() {
    return View::make('static/opensource');
});
