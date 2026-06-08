<?php

/**
 * Laravel IDE Helper Stubs
 * This file provides type hints for Laravel classes and global functions
 * to eliminate red underlines in IDE
 */

namespace {
    /**
     * Get / set the specified session value.
     */
    function session($key = null, $default = null) {}

    /**
     * Get an instance of the redirector.
     */
    function redirect($to = null, $status = 302, $headers = [], $secure = null) {}

    /**
     * Get the evaluated view contents for the given view.
     */
    function view($view = null, $data = [], $mergeData = []) {}

    /**
     * Get the available auth instance.
     */
    function auth($guard = null) {}

    /**
     * Get an instance of the current request or an input item from the request.
     */
    function request($key = null, $default = null) {}

    /**
     * Return a new response from the application.
     */
    function response($content = '', $status = 200, array $headers = []) {}

    /**
     * Create a new Carbon instance for the current time.
     */
    function now($tz = null) {}

    /**
     * Get an instance of the current request or return to previous request.
     */
    function back($status = 302, $headers = []) {}

    /**
     * Generate a URL for the application.
     */
    function url($path = null, $parameters = [], $secure = null) {}
}

namespace Illuminate\Database\Eloquent {
    class Model {
        /**
         * Create a new record in the database.
         */
        public static function create(array $attributes = []) {}

        /**
         * Find a model by its primary key.
         */
        public static function find($id, $columns = ['*']) {}

        /**
         * Begin querying the model.
         */
        public static function where($column, $operator = null, $value = null, $boolean = 'and') {}

        /**
         * Begin querying the model with eager loading.
         */
        public static function with($relations) {}
    }
}

namespace App\Models {
    use Illuminate\Database\Eloquent\Model;

    class Agency extends Model {
        /**
         * Find a model by its primary key.
         */
        public static function find($id, $columns = ['*']) {}

        /**
         * Begin querying the model.
         */
        public static function where($column, $operator = null, $value = null, $boolean = 'and') {}

        /**
         * Begin querying the model with eager loading.
         */
        public static function with($relations) {}
    }

    class Inquiry extends Model {
        /**
         * Create a new record in the database.
         */
        public static function create(array $attributes = []) {}

        /**
         * Find a model by its primary key.
         */
        public static function find($id, $columns = ['*']) {}

        /**
         * Begin querying the model.
         */
        public static function where($column, $operator = null, $value = null, $boolean = 'and') {}

        /**
         * Begin querying the model with eager loading.
         */
        public static function with($relations) {}
    }
}
