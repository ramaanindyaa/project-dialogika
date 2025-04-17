<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/pricing', [FrontController::class, 'pricing'])->name('front.pricing');

Route::match(['get', 'post'], '/booking/payment/midtrans/notification',
[FrontController::class, 'paymentMidtransNotification'])
    ->name('front.payment_midtrans_notification');

Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');

Route::get('/courses/{course}/certificate', [CertificateController::class, 'downloadCertificate'])
    ->name('courses.certificate')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware('role:student')->group(function () {
        Route::get('/dashboard/subscriptions/', [DashboardController::class, 'subscriptions'])
        ->name('dashboard.subscriptions');

        // model binding 1, 23, 412 ,2121
        Route::get('/dashboard/subscription/{transaction}', [DashboardController::class, 'subscription_details'])
        ->name('dashboard.subscription.details');

        Route::get('/dashboard/courses/', [CourseController::class, 'index'])
        ->name('dashboard');

        // slug web-design
        Route::get('/dashboard/course/{course:slug}', [CourseController::class, 'details'])
        ->name('dashboard.course.details');

        Route::get('/dashboard/search/courses', [CourseController::class, 'search_courses'])
        ->name('dashboard.search.courses');

        Route::get('/dashboard/courses/overview', [CourseController::class, 'overview'])
        ->name('dashboard.course.overview');

        Route::middleware(['check.subscription'])->group(function () {
            Route::get('/dashboard/join/{course:slug}', [CourseController::class, 'join'])
            ->name('dashboard.course.join');

            // web-design-hack/1/12
            Route::get('/dashboard/learning/{course:slug}/{courseSection}/{sectionContent}', [CourseController::class, 'learning'])
            ->name('dashboard.course.learning');

            Route::get('/dashboard/learning/{course:slug}/finished', [CourseController::class, 'learning_finished'])
            ->name('dashboard.course.learning.finished');

            Route::get('/dashboard/learning/{course:slug}/progress', [CourseController::class, 'learningProgress'])
            ->name('dashboard.course.learning.progress');
        });

        Route::get('/checkout/success', [FrontController::class, 'checkout_success'])
        ->name('front.checkout.success');

        Route::get('/checkout/{pricing}', [FrontController::class, 'checkout'])
        ->name('front.checkout');

        Route::post('/booking/payment/midtrans', [FrontController::class, 'paymentStoreMidtrans'])
        ->name('front.payment_store_midtrans');

        Route::get('/dashboard/quizzes', [QuizController::class, 'history'])
        ->name('dashboard.quizzes.history');
    });
});

require __DIR__.'/auth.php';
