<?php

Route::model('user', 'Shanhaijing\Shjsentry\Users\Eloquent\User');

Route::get('/', 'TopicController@topicList');

Route::controller('account', 'AccountController');

// Topic
Route::get('t/{id}', 'TopicController@getView');
Route::controller('topic', 'TopicController');

/**
 *  Admin
 */
Route::group(array('prefix' => 'admin'), function()
{
    // site settings
    Route::controller('settings', 'SiteSettingsController');

    // user admin
    Route::get('user', array('uses' => 'UserAdminController@index',
        'before' => 'can:admin.user.list'));
    Route::any('user/{user}/permissions', array('uses' => 'UserAdminController@permissions',
        'before' => 'can:admin.user.permission'));
});

