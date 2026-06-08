<?php

namespace PHPSTORM_META {

    // Laravel Facade Support
    override(\Illuminate\Support\Facades\App::make(0), map([
        '' => '@',
    ]));

    override(\app(0), map([
        '' => '@',
    ]));

    // Helper functions
    registerArgumentsSet('laravel_helpers',
        'session', 'redirect', 'view', 'auth', 'request', 'response', 'now', 'compact', 'back', 'url'
    );

    // Laravel Helper Functions
    override(\auth(), type('\Illuminate\Auth\AuthManager'));
    override(\session(), type('\Illuminate\Session\Store'));
    override(\request(), type('\Illuminate\Http\Request'));
    override(\back(), type('\Illuminate\Http\RedirectResponse'));
    override(\redirect(), type('\Illuminate\Http\RedirectResponse'));
    override(\view(), type('\Illuminate\View\View'));
    override(\response(), type('\Illuminate\Http\Response'));
    override(\url(), type('\Illuminate\Routing\UrlGenerator'));

    // Model methods - Agency
    override(\App\Models\Agency::find(0), type('\App\Models\Agency'));
    override(\App\Models\Agency::where(0), type('\Illuminate\Database\Eloquent\Builder'));
    override(\App\Models\Agency::with(0), type('\Illuminate\Database\Eloquent\Builder'));
    override(\App\Models\Agency::create(0), type('\App\Models\Agency'));
    override(\App\Models\Agency::first(0), type('\App\Models\Agency'));

    // Model methods - Inquiry
    override(\App\Models\Inquiry::find(0), type('\App\Models\Inquiry'));
    override(\App\Models\Inquiry::where(0), type('\Illuminate\Database\Eloquent\Builder'));
    override(\App\Models\Inquiry::with(0), type('\Illuminate\Database\Eloquent\Builder'));
    override(\App\Models\Inquiry::create(0), type('\App\Models\Inquiry'));
    override(\App\Models\Inquiry::first(0), type('\App\Models\Inquiry'));

    // Model methods - PublicUser
    override(\App\Models\PublicUser::find(0), type('\App\Models\PublicUser'));
    override(\App\Models\PublicUser::where(0), type('\Illuminate\Database\Eloquent\Builder'));
    override(\App\Models\PublicUser::with(0), type('\Illuminate\Database\Eloquent\Builder'));
    override(\App\Models\PublicUser::create(0), type('\App\Models\PublicUser'));
    override(\App\Models\PublicUser::first(0), type('\App\Models\PublicUser'));

    // Model methods - Admin
    override(\App\Models\Admin::find(0), type('\App\Models\Admin'));
    override(\App\Models\Admin::where(0), type('\Illuminate\Database\Eloquent\Builder'));
    override(\App\Models\Admin::with(0), type('\Illuminate\Database\Eloquent\Builder'));
    override(\App\Models\Admin::create(0), type('\App\Models\Admin'));
    override(\App\Models\Admin::first(0), type('\App\Models\Admin'));
}
