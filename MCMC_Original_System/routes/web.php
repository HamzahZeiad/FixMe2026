<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\Module1\UserController as Module1UserController;
use App\Http\Controllers\Module1\AdminController as Module1AdminController;
use App\Http\Controllers\Module1\AgencyController as Module1AgencyController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\InquiryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AgencyReviewAndNotificationController;


// Home page
Route::get('/', function () {
    return view('home.home');
})->name('home');

// Registration
Route::get('register', [Module1UserController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [Module1UserController::class, 'register']);

// Login
Route::get('login', [Module1UserController::class, 'showLoginForm'])->name('login');
Route::post('login', [Module1UserController::class, 'login']);

// Logout
Route::post('logout', [Module1UserController::class, 'logout'])->name('logout');

// Password recovery routes
Route::get('/password/recovery', [Module1UserController::class, 'showRecoveryForm'])->name('password.recovery');
Route::post('/password/email', [Module1UserController::class, 'sendResetLink'])->name('password.email');
Route::post('/password/reset', [Module1UserController::class, 'resetPassword'])->name('password.reset');
Route::get('/password/recovery/cancel', [Module1UserController::class, 'cancelPasswordReset'])->name('password.recovery.cancel');


// Manage Profile (protected)
Route::get('/manage-profile', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return view('Module1.publicUser.manageProfilePage');
})->name('manage.profile');

// Public User Home (protected)
Route::get('/public-user-home', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return view('publicUser.publicUserHome');
})->name('public.user.home');

Route::put('/profile/update', [Module1UserController::class, 'updateProfile'])->name('profile.update');

Route::post('/profile/password/verify', [Module1UserController::class, 'verifyPassword'])->name('password.verify');
Route::put('/profile/password/update', [Module1UserController::class, 'updatePassword'])->name('password.update');
Route::get('/profile/password/edit', function () {
    return view('Module1.publicUser.editPasswordPage');
})->name('password.edit');

Route::get('/password/edit/reset', function () {
    session()->forget('password_verified');
    return redirect()->route('password.edit');
})->name('password.edit.reset');

Route::get('/profile', [Module1UserController::class, 'showProfile'])->name('profile.show');

Route::get('/profile/manage', function () {
    return view('Module1.publicUser.manageProfilePage');
})->name('profile.manage');
// Submit Inquiry page
Route::get('/submit-inquiry', function () {
    return view('publicUser.submitInquiryForm');
})->middleware('auth')->name('submit.inquiry');

Route::post('/inquiries', [InquiryController::class, 'store'])
    ->middleware(['web', 'auth'])
    ->name('inquiries.store');

// Inquiry list and details routes
Route::get('/inquiries', [InquiryController::class, 'index'])
    ->middleware(['web', 'auth'])
    ->name('inquiries.index');

Route::get('/inquiries/{id}', [InquiryController::class, 'show'])
    ->middleware(['web', 'auth'])
    ->name('inquiries.show');

// Test route for login validation
Route::get('/test/login', function () {
    return view('publicUser.test_loginPage');
})->name('test.login');

// Admin routes - protected by admin.auth middleware
Route::middleware('admin.auth')->prefix('admin')->group(function () {
    // Admin: home dashboard
    Route::get('/home', [Module1AdminController::class, 'showHome'])->name('admin.home');

    // Admin: show all public users and agencies with search functionality
    Route::get('/users', [Module1AdminController::class, 'showUsers'])->name('admin.users');
    Route::get('/users/{id}', [Module1AdminController::class, 'viewUser'])->name('admin.user.view');
    Route::get('/users/{id}/edit', [Module1AdminController::class, 'editUser'])->name('admin.user.edit');
    Route::put('/users/{id}', [Module1AdminController::class, 'updateUser'])->name('admin.user.update');

    // Admin: agency management
    Route::get('/agencies/{id}', [Module1AdminController::class, 'viewAgency'])->name('admin.agency.view');
    Route::get('/agencies/{id}/edit', [Module1AdminController::class, 'editAgency'])->name('admin.agency.edit');
    Route::put('/agencies/{id}', [Module1AdminController::class, 'updateAgency'])->name('admin.agency.update');
    Route::get('/agency/register', [Module1AdminController::class, 'showAgencyRegistrationForm'])->name('admin.agency.register');
    Route::post('/agency/store', [Module1AdminController::class, 'storeAgency'])->name('admin.agency.store');

    // Admin: inquiry management
    Route::get('/inquiries', [Module1AdminController::class, 'showInquiries'])->name('admin.inquiries');
    Route::get('/inquiries/{id}', [Module1AdminController::class, 'showInquiryDetails'])->name('admin.inquiry.details');
    Route::put('/inquiries/{id}/status', [Module1AdminController::class, 'updateInquiryStatus'])->name('admin.inquiry.update.status');

    // Admin: assign inquiry management
    Route::get('/assign-inquiry', [Module1AdminController::class, 'showAssignInquiry'])->name('admin.assign.inquiry');
    Route::post('/assign-inquiry', [Module1AdminController::class, 'assignInquiries'])->name('admin.assign.inquiries');
    Route::post('/assign-inquiry-with-notes', [Module1AdminController::class, 'assignInquiriesWithNotes'])->name('admin.assign.inquiries.with.notes');

    // Admin: generate reports
    Route::get('/reports', [Module1AdminController::class, 'showReports'])->name('admin.reports');
    Route::post('/reports', [Module1AdminController::class, 'generateReports'])->name('admin.reports.generate');
});

// Agency routes
Route::get('/agency/home', [Module1AgencyController::class, 'showHome'])->name('agency.home');
Route::get('/agency/profile', [Module1AgencyController::class, 'showProfile'])->name('agency.profile');

// Agency profile updates
Route::put('/agency/profile', [Module1AgencyController::class, 'updateProfile'])->name('agency.profile.update');

// Agency security and password routes
Route::get('/agency/security', [Module1AgencyController::class, 'showSecurity'])->name('agency.security');

Route::post('/agency/password/verify', [Module1AgencyController::class, 'verifyPassword'])->name('agency.password.verify');

Route::put('/agency/password/update', [Module1AgencyController::class, 'updatePassword'])->name('agency.password.update');

Route::get('/agency/password/edit/reset', [Module1AgencyController::class, 'resetPasswordVerification'])->name('agency.password.edit.reset');

// Agency phone verification route
Route::post('/agency/phone/update', [Module1UserController::class, 'updateAgencyPhoneAndPassword'])->name('agency.phone.update');

// Agency assigned inquiries route
Route::get('/agency/assigned-inquiries', [Module1AgencyController::class, 'showAssignedInquiries'])->name('agency.assigned.inquiries');

// Agency view and display inquiry main page
Route::get('/agency/view-display-inquiry', [AgencyReviewAndNotificationController::class, 'showViewAndDisplayInquiry'])->name('agency.view.display.inquiry');

// Agency inquiry details route
Route::get('/agency/inquiry/{id}', [AgencyReviewAndNotificationController::class, 'showInquiryDetails'])->name('agency.inquiry.details');

// Agency inquiry reject route
Route::post('/agency/inquiry/{id}/reject', [AgencyReviewAndNotificationController::class, 'rejectInquiry'])->name('agency.inquiry.reject');
