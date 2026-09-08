<?php

use App\Http\Controllers\Admin\BlockedController;
use App\Http\Controllers\Admin\DestinyController;
use App\Http\Controllers\Admin\EmailVerificationController;
use App\Http\Controllers\Admin\InvitationController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\NewPasswordController;
use App\Http\Controllers\Admin\PasswordResetLinkController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('entrar', [LoginController::class, 'create'])->name('login');
    Route::post('entrar', [LoginController::class, 'store'])->name('login.store');

    Route::get('esqueci-a-senha', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('esqueci-a-senha', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('redefinir-senha/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('redefinir-senha', [NewPasswordController::class, 'store'])->name('password.update');

    Route::get('criar-senha/{token}', [InvitationController::class, 'create'])->name('invitation.create');
    Route::post('criar-senha', [InvitationController::class, 'store'])->name('invitation.store');
});

Route::middleware('auth')->group(function () {
    Route::get('acesso-bloqueado', [BlockedController::class, 'show'])->name('blocked');

    Route::post('sair', [LoginController::class, 'destroy'])->name('logout');

    Route::middleware('not-blocked')->group(function () {
        Route::get('verificar-email', [EmailVerificationController::class, 'notice'])->name('verification.notice');

        Route::get('verificar-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::post('verificar-email/reenviar', [EmailVerificationController::class, 'resend'])
            ->middleware('throttle:6,1')
            ->name('verification.send');

        Route::middleware('verified')->group(function () {
            Route::get('orcamentos', [QuotationController::class, 'index'])->name('quotations.index');
            Route::patch('orcamentos/{quotation}/responder', [QuotationController::class, 'answer'])->name('quotations.answer');

            Route::get('destinos', [DestinyController::class, 'index'])->name('destinies.index');
            Route::post('destinos', [DestinyController::class, 'store'])->name('destinies.store');
            Route::patch('destinos/{destiny}', [DestinyController::class, 'update'])->name('destinies.update');
            Route::patch('destinos/{destiny}/ativacao', [DestinyController::class, 'toggleActive'])->name('destinies.activation');
            Route::delete('destinos/{destiny}', [DestinyController::class, 'destroy'])->name('destinies.destroy');
            Route::get('usuarios', [UserController::class, 'index'])->name('users.index');
            Route::post('usuarios', [UserController::class, 'store'])->name('users.store');
            Route::patch('usuarios/{user}/bloqueio', [UserController::class, 'toggleBlock'])->name('users.block');
            Route::post('usuarios/{user}/convite', [UserController::class, 'resendInvitation'])
                ->middleware('throttle:6,1')
                ->name('users.invitation');
            Route::get('meu-perfil', [ProfileController::class, 'show'])->name('profile.show');
            Route::patch('meu-perfil', [ProfileController::class, 'update'])->name('profile.update');
            Route::patch('meu-perfil/senha', [ProfileController::class, 'updatePassword'])->name('profile.password');
        });
    });
});
