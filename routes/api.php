<?php

Route::post('common/upload', 'CommonController@upload');
Route::post('common/validate', 'ValidationController@validation');

Route::get('areas/columns', 'ColumnController@search');
Route::post('areas/columns', 'ColumnController@create');
Route::delete('areas/columns/{column}', 'ColumnController@delete');
Route::put('areas/columns/{column}/name', 'ColumnController@updateName');
Route::put('areas/columns/{column}/text', 'ColumnController@updateText');
Route::put('areas/columns/{column}/comment', 'ColumnController@updateComment');

// Route::get('areas', 'AreaController@search');
// Route::post('areas', 'AreaController@create');
// Route::delete('areas/{id}', 'AreaController@delete');
// Route::put('areas/{id}/name', 'AreaController@updateName');
// Route::put('areas/{id}/text', 'AreaController@updateText');
// Route::put('areas/{id}/comment', 'AreaController@updateComment');
// Route::put('areas/{id}/columns', 'AreaController@updateColumns');

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

Route::post('areas/search', 'AreaController@search');
Route::post('areas/create', 'AreaController@create');
Route::post('areas/destroy', 'AreaController@destroy');
Route::post('areas/name/update', 'AreaController@updateName');
Route::post('areas/text/update', 'AreaController@updateText');
Route::post('areas/comment/update', 'AreaController@updateComment');
Route::post('areas/columns/update', 'AreaController@updateColumns');

Route::post('locations/search', 'LocationController@search');
Route::post('locations/update', 'LocationController@update');
Route::post('locations/create', 'LocationController@create');
Route::post('locations/destroy', 'LocationController@destroy');

Route::post('projects/create', 'ProjectController@create');
Route::post('projects/search', 'ProjectController@search');
Route::post('projects/file', 'ProjectController@file');
Route::post('projects/reopen', 'ProjectController@reopen');
Route::post('projects/destroy', 'ProjectController@destroy');
Route::post('projects/update/name', 'ProjectController@updateName');
Route::post('projects/update/text', 'ProjectController@updateText');
Route::post('projects/update/comment', 'ProjectController@updateComment');

Route::post('tasks/search', 'TaskController@search');
Route::post('tasks/create', 'TaskController@create');
Route::post('tasks/destroy', 'TaskController@destroy');
Route::post('tasks/comment/update', 'TaskController@updateComment');
