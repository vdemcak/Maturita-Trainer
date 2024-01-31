<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\MarkdownConverter;

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
    return view('question');
});

Route::get('otazky/{question}', function ($question) {
    $location = explode('-', $question);

    $file = Storage::disk('questions')->get($location[0] . '/' . $location[1] . '.md');

    $config = [];
    $environment = new Environment($config);
    $environment->addExtension(new CommonMarkCoreExtension());
    $environment->addExtension(new FrontMatterExtension());
    $converter = new MarkdownConverter($environment);

    $result = $converter->convert($file);

    return view('question', [
        'id' => $result->getFrontMatter()['id'],
        'question' => $result->getContent(),
        'answer_type' => $result->getFrontMatter()['answer_type'],
        'choices' => $result->getFrontMatter()['choices'] ?? null,
        'attachment' => $result->getFrontMatter()['attachment'] ?? null,
        'files' => Storage::disk('questions')->allFiles('2023/')
    ]);
});


Route::get('create', function () {
    // Create a new markdown file using the storage driver
    Storage::disk('questions')->put('file.md', '# Hello World');
});
