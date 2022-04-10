
<?php

use Illuminate\Support\Facades\Route;

Route::get('public/difficulty/data', [ 'as' => 'frontoffice.difficulty.data', 'uses' => 'DifficultyController@difficultyData' ]);
