<?php

Route::get('plants', 'PlantController@search');
Route::post('plants', 'PlantController@create');
Route::delete('plants', 'PlantController@delete');
Route::patch('plants/{code}/code', 'PlantController@updateCode');
