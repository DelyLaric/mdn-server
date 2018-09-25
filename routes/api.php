<?php

Route::post('common/validate', 'ValidationController@validation');

Route::post('plants/search', 'PlantController@search');
Route::post('plants/create', 'PlantController@create');
Route::post('plants/destroy', 'PlantController@destroy');
Route::post('plants/name/update', 'PlantController@updateName');
Route::post('plants/comment/update', 'PlantController@updateComment');

Route::post('columns/search', 'ColumnController@search');
Route::post('columns/create', 'ColumnController@create');
Route::post('columns/destroy', 'ColumnController@destroy');
Route::post('columns/name/update', 'ColumnController@updateName');
Route::post('columns/text/update', 'ColumnController@updateText');
Route::post('columns/comment/update', 'ColumnController@updateComment');

Route::post('data/search', 'DataController@search');
Route::post('data/upload', 'DataController@upload');
Route::post('data/create', 'DataController@create');
Route::post('data/update', 'DataController@update');
Route::post('data/destroy', 'DataController@destroy');

Route::post('areas/search', 'AreaController@search');
Route::post('areas/create', 'AreaController@create');
Route::post('areas/destroy', 'AreaController@destroy');
Route::post('areas/name/update', 'AreaController@updateName');
Route::post('areas/text/update', 'AreaController@updateText');
Route::post('areas/comment/update', 'AreaController@updateComment');
Route::post('areas/columns/update', 'AreaController@updateColumns');

Route::post('projects/create', 'ProjectController@create');
Route::post('projects/search', 'ProjectController@search');
Route::post('projects/file', 'ProjectController@file');
Route::post('projects/reopen', 'ProjectController@reopen');
Route::post('projects/destroy', 'ProjectController@destroy');
Route::post('projects/name/update', 'ProjectController@updateName');
Route::post('projects/text/update', 'ProjectController@updateText');
Route::post('projects/comment/update', 'ProjectController@updateComment');

Route::post('tasks/search', 'TaskController@search');
Route::post('tasks/create', 'TaskController@create');
Route::post('tasks/destroy', 'TaskController@destroy');
Route::post('tasks/status/update', 'TaskController@updateStatus');
Route::post('tasks/comment/update', 'TaskController@updateComment');
Route::post('tasks/duetime/update', 'TaskController@updateDuetime');
Route::post('tasks/part/update', 'TaskController@updatePart');
Route::post('tasks/areas/add', 'TaskController@addArea');
Route::post('tasks/areas/remove', 'TaskController@removeArea');
Route::post('tasks/areas/location/update', 'TaskController@updateAreaData');
