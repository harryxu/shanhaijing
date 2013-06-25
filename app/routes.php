<?php

Route::model('user', 'Shanhaijing\Shjsentry\Users\Eloquent\User');
Route::model('group', 'Cartalyst\Sentry\Groups\Eloquent\Group');
Route::model('topic', 'Topic');
Route::model('post', 'Post');

Route::when('*', 'csrf', array('post', 'put'));

Route::get('/', 'TopicController@index');

Route::controller('account', 'AccountController');

// Topic
Route::get('t/{topic}', 'TopicController@show');
Route::resource('topic', 'TopicController');

/**
 * User
 */
Route::get('user/{username}', 'UserController@show');

/**
 * Admin
 */
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

