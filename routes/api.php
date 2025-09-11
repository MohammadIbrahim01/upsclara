<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EnquiryController;
use App\Http\Controllers\Api\FacultyController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\TestSeriesController;
use App\Http\Controllers\Api\PromoController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\OrderController;

use App\Http\Controllers\Api\AuthController; // 👈 Add this


/*
|--------------------------------------------------------------------------
| Public Auth APIs (no API key, no Sanctum required)
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    Route::post('auth/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');

      // Forgot / Reset password
    Route::post('auth/password/forgot', [AuthController::class, 'forgotPassword'])->name('auth.password.forgot');
    Route::post('auth/password/reset', [AuthController::class, 'resetPassword'])->name('auth.password.reset');
});

// Protected APIs (require API key)
Route::group(['prefix' => 'v1', 'as' => 'api.', 'middleware' => 'api.key'], function () {
    // Company API
    Route::get('company', [CompanyController::class, 'show'])->name('company');

    // Course Category APIs
    Route::get('course-categories', [CourseController::class, 'categories'])->name('course-categories.index');
    Route::get('course-categories/{slug}', [CourseController::class, 'categoryBySlug'])->name('course-categories.show');

    // Course APIs
    Route::get('courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('courses/{slug}', [CourseController::class, 'show'])->name('courses.show');

    // Blog Category APIs
    Route::get('blog-categories', [BlogController::class, 'categories'])->name('blog-categories.index');
    Route::get('blog-categories/{slug}', [BlogController::class, 'categoryBySlug'])->name('blog-categories.show');

    // Blog APIs
    Route::get('blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');

    // Faculty APIs
    Route::get('faculties', [FacultyController::class, 'index'])->name('faculties.index');
    Route::get('faculties/{slug}', [FacultyController::class, 'show'])->name('faculties.show');

    // Testimonial APIs
    Route::get('testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');

    // Test Series Category APIs
    Route::get('test-series-categories', [TestSeriesController::class, 'categories'])->name('test-series-categories.index');
    Route::get('test-series-categories/{slug}', [TestSeriesController::class, 'categoryBySlug'])->name('test-series-categories.show');

    // Test Series APIs
    Route::get('test-series', [TestSeriesController::class, 'index'])->name('test-series.index');
    Route::get('test-series/{slug}', [TestSeriesController::class, 'show'])->name('test-series.show');

    // FAQ APIs
    Route::get('faqs', [FaqController::class, 'index'])->name('faqs.index');
    Route::get('faqs/courses', [FaqController::class, 'courseFaqs'])->name('faqs.courses');
    Route::get('faqs/courses/{slug}', [FaqController::class, 'courseBySlug'])->name('faqs.courses.show');

    // Page APIs
    Route::get('pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('pages/groups', [PageController::class, 'groups'])->name('pages.groups');
    Route::get('pages/available-groups', [PageController::class, 'availableGroups'])->name('pages.available-groups');
    Route::get('pages/{slug}', [PageController::class, 'show'])->name('pages.show');

    // Promo APIs
    Route::get('promos/{code}', [PromoController::class, 'show'])->name('promos.show');
    Route::post('promos/validate', [PromoController::class, 'validateCode'])->name('promos.validate');

    // Job Opening APIs
    Route::get('job-openings', [JobController::class, 'index'])->name('job-openings.index');

    // Order APIs
    Route::post('orders', [OrderController::class, 'createOrder'])->name('orders.store');
    Route::post('orders/{orderNumber}/payment', [OrderController::class, 'updatePayment'])->name('orders.update-payment');

    // Form Submission APIs
    Route::post('enquiries', [EnquiryController::class, 'store'])->name('enquiries.store');
    Route::post('career-applications', [JobController::class, 'storeApplication'])->name('career-applications.store');
});

// Authenticated APIs
// Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Add your authenticated API routes here
// });


/*
|--------------------------------------------------------------------------
| User Private APIs (require API key + Sanctum token)
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'v1', 'middleware' => ['api.key', 'auth:sanctum']], function () {
    Route::get('auth/profile', [AuthController::class, 'profile'])->name('auth.profile');
    Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('auth/check-status', [AuthController::class, 'checkStatus'])->name('auth.check-status');
 
  
});