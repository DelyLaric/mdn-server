<?php

Route::post('validate', 'ValidationController@validation');

Route::get('plants', 'PlantController@search');
Route::post('plants', 'PlantController@create');
Route::delete('plants/{plant}', 'PlantController@delete');
Route::put('plants/{plant}/name', 'PlantController@updateName');
Route::put('plants/{plant}/comment', 'PlantController@updateComment');

Route::get('areas/columns', 'ColumnController@search');
Route::post('areas/columns', 'ColumnController@create');
Route::delete('areas/columns/{column}', 'ColumnController@delete');
Route::put('areas/columns/{column}/name', 'ColumnController@updateName');
Route::put('areas/columns/{column}/text', 'ColumnController@updateText');
Route::put('areas/columns/{column}/comment', 'ColumnController@updateComment');

Route::get('areas', 'AreaController@search');
Route::post('areas', 'AreaController@create');
Route::delete('areas/{id}', 'AreaController@delete');
Route::put('areas/{id}/name', 'AreaController@updateName');
Route::put('areas/{id}/text', 'AreaController@updateText');
Route::put('areas/{id}/comment', 'AreaController@updateComment');
Route::put('areas/{id}/columns', 'AreaController@updateColumns');

Route::post('locations/search', 'LocationController@search');
Route::post('locations/update', 'LocationController@update');
Route::post('locations/delete', 'LocationController@delete');

Route::post('plants/{plant}/areas', 'AreaController@createArea');
Route::delete('plants/{plant}/areas/{area}', 'AreaController@deleteArea');

Route::put('plants/{plant}/areas/{area}/columns', 'AreaController@updateAreaColumns');
