<?php

use App\Http\Controllers\Web\AboutController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\DestinyController;
use App\Http\Controllers\Web\LandingController;
use App\Http\Controllers\Web\LocaleController;
use App\Http\Controllers\Web\QuotationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/sobre', [AboutController::class, 'index'])->name('about');
Route::get('/contato', [ContactController::class, 'index'])->name('contact');

Route::get('/destinos', [DestinyController::class, 'index'])->name('destinies.index');
Route::post('/orcamento', [QuotationController::class, 'store'])->name('quotation.store');

Route::get('/locale/{locale}', [LocaleController::class, 'update'])->name('locale.switch');
