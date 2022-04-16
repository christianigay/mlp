<?php

use Illuminate\Support\Facades\Route;

Route::get('public/difficulty/data', 'DifficultyController@getDifficultyData');
Route::get('public/difficulty/assets', 'DifficultyController@getPdfExtractAssets');
// Route::get('public/difficulty/move-files', 'DifficultyController@moveFiles');

// Route::get('public/difficulty/generate-data', 'DifficultyController@difficultyData');
// Route::get('public/difficulty/generate-assets', 'DifficultyController@pdfExtractAssets');
