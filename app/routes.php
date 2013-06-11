<?php

Route::filter('login_required', function() {
    if (!Sentry::check()) {
        return Redirect::guest('account/login');
    }
});

Route::get('/', 'TopicController@topicList');

Route::controller('account', 'AccountController');

// Topic
Route::get('t/{id}', 'TopicController@getView');
Route::controller('topic', 'TopicController');
