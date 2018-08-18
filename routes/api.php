<?php

Route::get('plants', 'PlantController@search');
Route::post('plants', 'PlantController@create');
Route::delete('plants', 'PlantController@delete');
Route::put('plants/{name}/name', 'PlantController@updateName');

Route::get('areas/columns', 'AreaController@getColumns');
Route::post('areas/columns', 'AreaController@createColumn');
Route::delete('areas/columns/{column}', 'AreaController@deleteColumn');

Route::get('plants/{plant}/areas', 'AreaController@getAreas');
Route::post('plants/{plant}/areas', 'AreaController@createArea');
Route::delete('plants/{plant}/areas/{area}', 'AreaController@deleteArea');

Route::put('plants/{plant}/areas/{area}/columns', 'AreaController@updateAreaColumns');
