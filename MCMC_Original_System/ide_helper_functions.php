<?php

/**
 * Laravel Helper Functions for IDE Support
 * This file provides function stubs for IDE autocomplete
 */

if (!function_exists('session')) {
    /**
     * Get / set the specified session value.
     * @param string|array|null $key
     * @param mixed $default
     * @return mixed|\Illuminate\Session\SessionManager|\Illuminate\Session\Store
     */
    function session($key = null, $default = null) {}
}

if (!function_exists('redirect')) {
    /**
     * Get an instance of the redirector.
     * @param string|null $to
     * @param int $status
     * @param array $headers
     * @param bool|null $secure
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function redirect($to = null, $status = 302, $headers = [], $secure = null) {}
}

if (!function_exists('view')) {
    /**
     * Get the evaluated view contents for the given view.
     * @param string|null $view
     * @param array $data
     * @param array $mergeData
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    function view($view = null, $data = [], $mergeData = []) {}
}

if (!function_exists('auth')) {
    /**
     * Get the available auth instance.
     * @param string|null $guard
     * @return \Illuminate\Contracts\Auth\Factory|\Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    function auth($guard = null) {}
}

if (!function_exists('request')) {
    /**
     * Get an instance of the current request or an input item from the request.
     * @param array|string|null $key
     * @param mixed $default
     * @return \Illuminate\Http\Request|string|array|null
     */
    function request($key = null, $default = null) {}
}

if (!function_exists('response')) {
    /**
     * Return a new response from the application.
     * @param \Illuminate\View\View|string|array|null $content
     * @param int $status
     * @param array $headers
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    function response($content = '', $status = 200, array $headers = []) {}
}

if (!function_exists('now')) {
    /**
     * Create a new Carbon instance for the current time.
     * @param \DateTimeZone|string|null $tz
     * @return \Illuminate\Support\Carbon
     */
    function now($tz = null) {}
}

if (!function_exists('compact')) {
    /**
     * Create an array containing variables and their values.
     * @param mixed ...$varname
     * @return array
     */
    function compact(...$varname) {}
}
