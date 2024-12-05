<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// web.php
Route::get('/{any}', function () {
    return view('welcome'); // Asegúrate de que 'app' sea el nombre de tu vista principal
})->where('any', '.*');
