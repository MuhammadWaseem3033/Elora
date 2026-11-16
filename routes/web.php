<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\StaticPageController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/category/{slug}', [CategoryController::class, 'show'])
    ->name('category.show');

// Journal - All Articles
Route::get('/journal', [JournalController::class, 'index'])
    ->name('journal.index');

// Journal - Articles by Category
Route::get('/journal/category/{slug}', [JournalController::class, 'category'])
    ->name('journal.category');
// Individual Journal Article
Route::get('/journal/{slug}', [JournalController::class, 'show'])
    ->name('journal.show');
// Static Pages
Route::get('/page/{slug}', [StaticPageController::class, 'show'])
    ->name('page.show');
// Contact Us
Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact.index');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

// Individual Fashion Design
Route::get('/design/{slug}', [DesignController::class, 'show'])
    ->name('design.show');
