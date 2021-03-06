<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\AnswersController;
use App\Http\Controllers\AcceptAnswerController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\VoteQuestionController;
use App\Http\Controllers\VoteAnswerController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [QuestionsController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/question', QuestionsController::class)->except('show');
Route::get('/question/{slug}', [QuestionsController::class, 'show'])->name('question.show');
// Route::post('/question/{question}/answer','')->name('answer.store');
Route::resource('question.answers', AnswersController::class)->only(['store', 'edit', 'update', 'destroy', 'index']);
Route::post('/answers/{answer}/accept', AcceptAnswerController::class)->name('answers.accept');

Route::post('/question/{question}/favorites', [FavoritesController::class, 'store'])->name('question.favorite');
Route::delete('/question/{question}/favorites', [FavoritesController::class, 'destroy'])->name('question.unfavorite');

Route::post('/question/{question}/vote', VoteQuestionController::class);
Route::post('/answers/{answer}/vote', VoteAnswerController::class);