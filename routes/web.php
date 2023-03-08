<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [\App\Http\Controllers\TemplateController::class, 'showTemplates'])->name('home');
Route::get('/new_template', [\App\Http\Controllers\TemplateController::class, 'showAddTemplateForm'])->name('new_template');
Route::post('/new_template', [\App\Http\Controllers\TemplateController::class, 'addTemplate']);
Route::get('/template/{id}', [\App\Http\Controllers\TemplateController::class, 'showTemplatePage'])->name('template');

Route::get('/preview_meme/{id}', [\App\Http\Controllers\MemeController::class, 'previewMeme'])->name('preview_meme');
Route::post('/make_meme/{id}', [\App\Http\Controllers\MemeController::class, 'makeMeme'])->name('make_meme');
Route::get('/meme/{id}', [\App\Http\Controllers\MemeController::class, 'showMemePage'])->name('meme');

Route::middleware("auth:web")->group(function () {
    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::get('/my_templates', [\App\Http\Controllers\TemplateController::class, 'showUserTemplates'])->name('my_templates');
    Route::get('/my_memes', [\App\Http\Controllers\MemeController::class, 'showUserMemes'])->name('my_memes');
});

Route::middleware("guest:web")->group(function (){
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login_process', [\App\Http\Controllers\AuthController::class, 'login'])->name('login_process');

    Route::get('/register', [\App\Http\Controllers\AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register_process', [\App\Http\Controllers\AuthController::class, 'register'])->name('register_process');
});


