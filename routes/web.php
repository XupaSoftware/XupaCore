<?php

use App\Http\Controllers\Core\UserAssetController;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\TestController;

// Core
use App\Http\Controllers\Core\ProfileController;
use App\Http\Controllers\Core\NotificationController;

// Authentication
use App\Http\Controllers\Core\Authentication\LoginController;
use App\Http\Controllers\Core\Authentication\RegisterController;
use App\Http\Controllers\Core\Authentication\ForgotPasswordController;
use App\Http\Controllers\Core\Authentication\ConfirmPasswordController;
use App\Http\Controllers\Core\Authentication\ResetPasswordController;
use App\Http\Controllers\Core\Authentication\EmailController;

Route::get('/', [TestController::class, 'index'])->name('home')->middleware('auth');

// Routes of Profile core
Route::group(['as' => 'profile.', 'middleware' => 'auth'], function() {
    // Render Pages
    Route::group(['as' => 'render.'], function() {
        Route::get('/profile/general', [ProfileController::class, 'renderProfileGeneral'])->name('general'); // General Profile Page
        Route::get('/profile/security', [ProfileController::class, 'renderProfileSecurity'])->name('security'); // Security Profile Page
        Route::get('/profile/notifications', [ProfileController::class, 'renderProfileNotifications'])->name('notifications'); // Security Profile Page
    });

    // Requests
    Route::group(['as' => 'requests.'], function() {
        Route::post('/profile/general', [ProfileController::class, 'updateProfile'])->name('general'); // Update general user information
        Route::post('/profile/security', [ProfileController::class, 'changePassword'])->name('password.change'); // Change users password
        Route::post('/profile/notifications', [ProfileController::class, 'updatePreferences'])->name('preferences.change'); // Change users password
        Route::post('/profile/banner', [ProfileController::class, 'updateBanner'])->name('banner.update'); // Change users banner
        Route::post('/profile/profile_image', [ProfileController::class, 'updateProfileImage'])->name('profile_image.update'); // Change users profile image
    });
});

// Routes of User core
Route::group(['as' => 'user.', 'middleware' => 'auth'], function() {
    Route::get('/user/{user}/banner', [UserAssetController::class, 'getProfileBanner'])->name('banner');
    Route::get('/user/{user}/profile_image', [UserAssetController::class, 'getProfileImage'])->name('profile_image');
});

// Routes of Notifications
Route::group(['as' => 'notifications.', 'prefix' => 'notifications', 'middleware' => 'auth'], function() {
    // Render
    Route::group(['as' => 'render.'], function() {
       Route::get('/', [NotificationController::class, 'renderNotificationCenter'])->name('notifications');
    });

    // Requests
    Route::group(['as' => 'requests.'], function() {
        Route::post('/read/single', [NotificationController::class, 'markAsReadSingle'])->name('read.single');
        Route::post('/read/array', [NotificationController::class, 'markAsReadArray'])->name('read.array');

        Route::post('/dismiss/single', [NotificationController::class, 'deleteNotificationsSingle'])->name('dismiss.single');
        Route::post('/dismiss/array', [NotificationController::class, 'deleteNotificationsArray'])->name('dismiss.array');
    });
});

// Routes of authentication core
Route::group(['as' => 'auth.', 'middleware' => 'guest'], function() {
    // Render Pages
    Route::group(['as' => 'render.'], function() {
        Route::get('/login', [LoginController::class, 'renderLogin'])->name('login');
        Route::get('/register', [RegisterController::class, 'renderRegister'])->name('register');

        Route::get('/password/forgot', [ForgotPasswordController::class, 'renderPasswordForgot'])->name('password.forgot');
        Route::get('/password/reset', [ResetPasswordController::class, 'renderPasswordReset'])->name('password.reset');
        Route::get('/password/confirm', [ConfirmPasswordController::class, 'renderPasswordConfirm'])->name('password.confirm')->withoutMiddleware('guest');

        Route::get('/email/verify', [EmailController::class, 'renderEmailVerify'])->name('email.verify')->withoutMiddleware('guest');
    });

    // Third-Party-Login
    Route::group(['as' => 'socialite.'], function() {
        Route::get('/external/facebook', [LoginController::class, 'loginFacebook'])->name('facebook');
        Route::get('/external/facebook/callback', [LoginController::class, 'callbackFacebook'])->name('facebook.callback');

        Route::get('/external/github', [LoginController::class, 'loginGithub'])->name('github');
        Route::get('/external/github/callback', [LoginController::class, 'callbackGithub'])->name('github.callback');
    });

    // Requests
    Route::group(['as' => 'requests.'], function() {
        Route::post('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/register', [RegisterController::class, 'register'])->name('register');

        Route::post('/password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.forgot');
        Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');
        Route::post('/password/confirm', [ConfirmPasswordController::class, 'confirm'])->name('password.confirm')->withoutMiddleware('guest');

        Route::post('/email/verify', [EmailController::class, 'verify'])->name('email.verify')->withoutMiddleware('guest');
    });
});
