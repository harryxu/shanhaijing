<?php

Route::get('/', 'TopicController@topicList');

Route::controller('account', 'AccountController');

// Topic
Route::get('t/{id}', 'TopicController@getView');
Route::controller('topic', 'TopicController');
