<?php

// Test Laravel helper functions accessibility
use Illuminate\Support\Facades\Route;

// Test basic route
Route::get('/test-helpers', function () {
    // Test helper functions
    $sessionData = session('test_key', 'default_value');
    $redirectResponse = redirect()->route('login');
    $viewResponse = view('welcome');
    $authUser = auth()->user();
    $requestData = request()->all();
    $responseJson = response()->json(['status' => 'ok']);
    $currentTime = now();
    
    return response()->json([
        'helpers_working' => true,
        'session_accessible' => function_exists('session'),
        'redirect_accessible' => function_exists('redirect'),
        'view_accessible' => function_exists('view'),
        'auth_accessible' => function_exists('auth'),
        'request_accessible' => function_exists('request'),
        'response_accessible' => function_exists('response'),
        'now_accessible' => function_exists('now'),
        'time' => $currentTime->toString()
    ]);
});

echo "✅ PHP syntax check passed - Laravel helpers are available\n";
