<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Course Category
    Route::delete('course-categories/destroy', 'CourseCategoryController@massDestroy')->name('course-categories.massDestroy');
    Route::resource('course-categories', 'CourseCategoryController');

    // Course
    Route::delete('courses/destroy', 'CourseController@massDestroy')->name('courses.massDestroy');
    Route::post('courses/media', 'CourseController@storeMedia')->name('courses.storeMedia');
    Route::post('courses/ckmedia', 'CourseController@storeCKEditorImages')->name('courses.storeCKEditorImages');
    Route::resource('courses', 'CourseController');

    // Faculty
    Route::delete('faculties/destroy', 'FacultyController@massDestroy')->name('faculties.massDestroy');
    Route::post('faculties/media', 'FacultyController@storeMedia')->name('faculties.storeMedia');
    Route::resource('faculties', 'FacultyController');

    // Course Content
    Route::delete('course-contents/destroy', 'CourseContentController@massDestroy')->name('course-contents.massDestroy');
    Route::resource('course-contents', 'CourseContentController');

    // Test Series Category
    Route::delete('test-series-categories/destroy', 'TestSeriesCategoryController@massDestroy')->name('test-series-categories.massDestroy');
    Route::resource('test-series-categories', 'TestSeriesCategoryController');

    // Test Series
    Route::delete('test-seriess/destroy', 'TestSeriesController@massDestroy')->name('test-seriess.massDestroy');
    Route::post('test-seriess/media', 'TestSeriesController@storeMedia')->name('test-seriess.storeMedia');
    Route::post('test-seriess/ckmedia', 'TestSeriesController@storeCKEditorImages')->name('test-seriess.storeCKEditorImages');
    Route::resource('test-seriess', 'TestSeriesController');

    // Blog Category
    Route::delete('blog-categories/destroy', 'BlogCategoryController@massDestroy')->name('blog-categories.massDestroy');
    Route::resource('blog-categories', 'BlogCategoryController');

    // Blog
    Route::delete('blogs/destroy', 'BlogController@massDestroy')->name('blogs.massDestroy');
    Route::post('blogs/media', 'BlogController@storeMedia')->name('blogs.storeMedia');
    Route::post('blogs/ckmedia', 'BlogController@storeCKEditorImages')->name('blogs.storeCKEditorImages');
    Route::resource('blogs', 'BlogController');

    // Enquiry
    Route::delete('enquiries/destroy', 'EnquiryController@massDestroy')->name('enquiries.massDestroy');
    Route::resource('enquiries', 'EnquiryController');

    // Job Opening
    Route::delete('job-openings/destroy', 'JobOpeningController@massDestroy')->name('job-openings.massDestroy');
    Route::post('job-openings/media', 'JobOpeningController@storeMedia')->name('job-openings.storeMedia');
    Route::post('job-openings/ckmedia', 'JobOpeningController@storeCKEditorImages')->name('job-openings.storeCKEditorImages');
    Route::resource('job-openings', 'JobOpeningController');

    // Career Application
    Route::delete('career-applications/destroy', 'CareerApplicationController@massDestroy')->name('career-applications.massDestroy');
    Route::post('career-applications/media', 'CareerApplicationController@storeMedia')->name('career-applications.storeMedia');
    Route::post('career-applications/ckmedia', 'CareerApplicationController@storeCKEditorImages')->name('career-applications.storeCKEditorImages');
    Route::resource('career-applications', 'CareerApplicationController');

    // Pages
    Route::delete('pages/destroy', 'PagesController@massDestroy')->name('pages.massDestroy');
    Route::post('pages/media', 'PagesController@storeMedia')->name('pages.storeMedia');
    Route::post('pages/ckmedia', 'PagesController@storeCKEditorImages')->name('pages.storeCKEditorImages');
    Route::resource('pages', 'PagesController');

    // Testimonial
    Route::delete('testimonials/destroy', 'TestimonialController@massDestroy')->name('testimonials.massDestroy');
    Route::post('testimonials/media', 'TestimonialController@storeMedia')->name('testimonials.storeMedia');
    Route::post('testimonials/ckmedia', 'TestimonialController@storeCKEditorImages')->name('testimonials.storeCKEditorImages');
    Route::resource('testimonials', 'TestimonialController');

    // Faq
    Route::delete('faqs/destroy', 'FaqController@massDestroy')->name('faqs.massDestroy');
    Route::resource('faqs', 'FaqController');

    // Course Faq
    Route::delete('course-faqs/destroy', 'CourseFaqController@massDestroy')->name('course-faqs.massDestroy');
    Route::resource('course-faqs', 'CourseFaqController');

    // Company
    Route::post('companies/media', 'CompanyController@storeMedia')->name('companies.storeMedia');
    Route::post('companies/ckmedia', 'CompanyController@storeCKEditorImages')->name('companies.storeCKEditorImages');
    Route::resource('companies', 'CompanyController', ['except' => ['create', 'store', 'destroy']]);

    // Email
    Route::delete('emails/destroy', 'EmailController@massDestroy')->name('emails.massDestroy');
    Route::resource('emails', 'EmailController');

    // Phone
    Route::delete('phones/destroy', 'PhoneController@massDestroy')->name('phones.massDestroy');
    Route::resource('phones', 'PhoneController');

    // Address
    Route::delete('addresses/destroy', 'AddressController@massDestroy')->name('addresses.massDestroy');
    Route::resource('addresses', 'AddressController');

    // Social Media
    Route::resource('social-media', 'SocialMediaController', ['except' => ['create', 'store', 'destroy']]);

    // Order
    Route::delete('orders/destroy', 'OrderController@massDestroy')->name('orders.massDestroy');
    Route::resource('orders', 'OrderController');

    // Promo
    Route::delete('promos/destroy', 'PromoController@massDestroy')->name('promos.massDestroy');
    Route::resource('promos', 'PromoController');

    // Payment
    Route::delete('payments/destroy', 'PaymentController@massDestroy')->name('payments.massDestroy');
    Route::resource('payments', 'PaymentController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
