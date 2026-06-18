<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/hakkimda', [PageController::class, 'about'])->name('about');
Route::get('/hizmetler', [PageController::class, 'services'])->name('services');
Route::get('/hizmetler/{slug}', [PageController::class, 'serviceDetail'])->name('services.detail');
Route::get('/sertifikalar', [PageController::class, 'certificates'])->name('certificates');
Route::get('/galeri', [PageController::class, 'gallery'])->name('gallery');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [PageController::class, 'blogDetail'])->name('blog.detail');
Route::get('/iletisim', [PageController::class, 'contact'])->name('contact');
Route::post('/iletisim', [PageController::class, 'contactSubmit'])->name('contact.submit');
