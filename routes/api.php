<?php

Route::get('plants', 'PlantController@search');
Route::post('plants', 'PlantController@create');
Route::delete('plants', 'PlantController@delete');
Route::put('plants/{name}/name', 'PlantController@updateName');
