<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.home');
});

Route::get('testy/{year}/{subject}', function ($year, $subject) {
    if (!Storage::disk('questions')->exists($year . '/' . $subject)) {
        abort(404, 'No questions found for test ' . $year . '/' . $subject);
    }

    return view('pages.test', [
        'year' => $year,
        'subject' => $subject,
    ]);
});
