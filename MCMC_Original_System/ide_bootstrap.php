<?php

// This file should be included in composer.json autoload files section
// It provides stub classes for Laravel to help IDEs recognize types

if (!class_exists('Illuminate\Http\Request')) {
    require_once __DIR__ . '/laravel_ide_stubs.php';
}

if (!function_exists('_ide_helper_model_methods')) {
    function _ide_helper_model_methods() {
        // Eloquent Model factory methods
        \App\Models\Agency::create([]);
        \App\Models\Agency::where('column', 'value');
        \App\Models\Agency::find(1);
        \App\Models\Agency::with(['relation']);
        
        \App\Models\Inquiry::create([]);
        \App\Models\Inquiry::where('column', 'value');
        \App\Models\Inquiry::find(1);
        \App\Models\Inquiry::with(['user', 'agency']);
        
        \App\Models\PublicUser::create([]);
        \App\Models\PublicUser::where('column', 'value');
        \App\Models\PublicUser::find(1);
        
        // Helper functions
        auth()->check();
        auth()->user();
        auth()->id();
        
        session(['key' => 'value']);
        session('key');
        
        request()->input('key');
        request()->has('key');
        
        back()->with('message', 'value');
        back()->withErrors(['field' => 'error']);
        
        redirect()->route('name');
        url()->previous();
    }
}
