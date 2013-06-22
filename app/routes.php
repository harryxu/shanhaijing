<?php

Route::model('user', 'User');

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
    Route::controller('user', 'UserAdminController');

    Route::get('user/{user}/permissions', 'UserAdminController@permissions');
});

