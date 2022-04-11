<?php

use Illuminate\Support\Facades\Route;

Route::get('public/difficulty/data', 'DifficultyController@difficultyData');
Route::get('public/difficulty/assets', 'DifficultyController@pdfExtractAssets');
// Route::get('public/difficulty/move-files', 'DifficultyController@moveFiles');
