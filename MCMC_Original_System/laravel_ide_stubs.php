<?php

/**
 * Laravel IDE Helper - Comprehensive Class Definitions
 * This file provides class definitions for VS Code to recognize Laravel types
 */

// Fake implementations for IDE recognition
namespace Illuminate\Http {
    class Request {
        public function input($key = null, $default = null) { return $default; }
        public function has($key) { return true; }
        public function all() { return []; }
        public function except($keys) { return []; }
        public function only($keys) { return []; }
        public function file($key = null) { return new \Illuminate\Http\UploadedFile('', ''); }
        public function hasFile($key) { return true; }
        public function url() { return ''; }
        public function method() { return 'GET'; }
        public function ajax() { return false; }
        public function expectsJson() { return false; }
        public function validate($rules, $messages = [], $customAttributes = []) { return []; }
        
        // Magic property access for form fields
        public function __get($key) { return null; }
        public function __isset($key) { return true; }
    }

    class RedirectResponse {
        public function with($key, $value = null) { return $this; }
        public function withErrors($provider, $key = 'default') { return $this; }
        public function withInput($input = null) { return $this; }
        public function route($name, $parameters = [], $absolute = true) { return $this; }
    }

    class Response {
        public function json($data = [], $status = 200, $headers = []) { return $this; }
    }

    class UploadedFile {
        public function __construct($path, $originalName) {}
        public function store($path, $disk = null) { return 'path/to/file'; }
        public function getClientOriginalName() { return 'filename.ext'; }
        public function getSize() { return 1024; }
        public function getMimeType() { return 'image/jpeg'; }
    }
}

namespace Illuminate\Support\Facades {
    class Auth {
        public static function check() { return true; }
        public static function user() { return null; }
        public static function id() { return null; }
        public static function login($user) { }
        public static function logout() { }
    }

    class Hash {
        public static function make($value, $options = []) { return ''; }
        public static function check($value, $hashedValue, $options = []) { return true; }
    }

    class Log {
        public static function info($message, $context = []) { }
        public static function error($message, $context = []) { }
        public static function debug($message, $context = []) { }
        public static function warning($message, $context = []) { }
    }

    class Storage {
        public static function disk($name) { return new class {
            public function put($path, $contents, $options = []) { return true; }
            public function delete($path) { return true; }
        }; }
        public static function put($path, $contents, $options = []) { return true; }
    }    class DB {
        public static function table($table) { 
            return new class {
                public function where($column, $operator = null, $value = null) { return $this; }
                public function whereNull($column, $boolean = 'and') { return $this; }
                public function orWhere($column, $operator = null, $value = null) { return $this; }
                public function orWhereNull($column) { return $this; }
                public function get() { return []; }
                public function first() { return null; }
                public function insert($values) { return true; }
                public function update($values) { return 1; }
                public function delete() { return 1; }
                public function count() { return 0; }
                public function select($columns = ['*']) { return $this; }
                public function join($table, $first, $operator = null, $second = null, $type = 'inner') { return $this; }
                public function orderBy($column, $direction = 'asc') { return $this; }
                public function groupBy(...$groups) { return $this; }
                public function having($column, $operator = null, $value = null, $boolean = 'and') { return $this; }
                public function limit($value) { return $this; }
                public function offset($value) { return $this; }
                public function truncate() { return true; }
                public function insertOrIgnore($values) { return true; }
                public function updateOrInsert($attributes, $values = []) { return true; }
                public function upsert($values, $uniqueBy, $update = null) { return 1; }
            }; 
        }
        public static function raw($value) { return $value; }
        public static function select($query, $bindings = []) { return []; }
        public static function insert($query, $bindings = []) { return true; }
        public static function update($query, $bindings = []) { return 1; }
        public static function delete($query, $bindings = []) { return 1; }
        public static function statement($query, $bindings = []) { return true; }
        public static function transaction($callback, $attempts = 1) { return $callback(); }
        public static function beginTransaction() { }
        public static function commit() { }
        public static function rollback() { }
    }
}

namespace Illuminate\Validation {
    class ValidationException extends \Exception {
        public function errors() { return []; }
    }
}

namespace Illuminate\Database {
    class QueryException extends \Exception {
        // Don't override final methods from Exception
        public function __construct($message = '', $code = 0, \Throwable $previous = null) {
            parent::__construct($message, $code, $previous);
        }
    }
}

namespace Illuminate\Database\Eloquent {    class Builder {
        public function where($column, $operator = null, $value = null, $boolean = 'and') { return $this; }
        public function orWhere($column, $operator = null, $value = null) { return $this; }
        public function whereNull($column, $boolean = 'and') { return $this; }
        public function orWhereNull($column) { return $this; }
        public function whereNotNull($column, $boolean = 'and') { return $this; }
        public function orWhereNotNull($column) { return $this; }
        public function whereIn($column, $values, $boolean = 'and', $not = false) { return $this; }
        public function orWhereIn($column, $values) { return $this; }
        public function whereNotIn($column, $values, $boolean = 'and') { return $this; }
        public function orWhereNotIn($column, $values) { return $this; }
        public function whereBetween($column, array $values, $boolean = 'and', $not = false) { return $this; }
        public function orWhereBetween($column, array $values) { return $this; }
        public function whereNotBetween($column, array $values, $boolean = 'and') { return $this; }
        public function orWhereNotBetween($column, array $values) { return $this; }
        public function with($relations) { return $this; }
        public function orderBy($column, $direction = 'asc') { return $this; }
        public function orderByDesc($column) { return $this; }
        public function orderByRaw($sql, $bindings = []) { return $this; }
        public function groupBy(...$groups) { return $this; }
        public function having($column, $operator = null, $value = null, $boolean = 'and') { return $this; }
        public function limit($value) { return $this; }
        public function offset($value) { return $this; }
        public function take($value) { return $this; }
        public function skip($value) { return $this; }
        public function get($columns = ['*']) { return new Collection(); }
        public function first($columns = ['*']) { return null; }
        public function findOrFail($id, $columns = ['*']) { return null; }
        public function count($columns = '*') { return 0; }
        public function sum($column) { return 0; }
        public function avg($column) { return 0; }
        public function min($column) { return null; }
        public function max($column) { return null; }
        public function exists() { return true; }
        public function doesntExist() { return false; }
        public function pluck($column, $key = null) { return new Collection(); }
        public function select($columns = ['*']) { return $this; }
        public function addSelect($column) { return $this; }
        public function distinct() { return $this; }
        public function join($table, $first, $operator = null, $second = null, $type = 'inner') { return $this; }
        public function leftJoin($table, $first, $operator = null, $second = null) { return $this; }
        public function rightJoin($table, $first, $operator = null, $second = null) { return $this; }
        public function crossJoin($table, $first = null, $operator = null, $second = null) { return $this; }
        public function update($values) { return 1; }
        public function delete() { return 1; }
    }    class Collection implements \ArrayAccess, \Iterator, \Countable {
        public function offsetExists(mixed $offset): bool { return true; }
        public function offsetGet(mixed $offset): mixed { return null; }
        public function offsetSet(mixed $offset, mixed $value): void { }
        public function offsetUnset(mixed $offset): void { }
        public function current(): mixed { return null; }
        public function next(): void { }
        public function key(): mixed { return 0; }
        public function valid(): bool { return true; }
        public function rewind(): void { }
        public function count(): int { return 0; }
    }    abstract class Model {
        public static function create(array $attributes = []) { return new static(); }
        public static function find($id, $columns = ['*']) { return new static(); }
        public static function findOrFail($id, $columns = ['*']) { return new static(); }
        public static function where($column, $operator = null, $value = null, $boolean = 'and') { 
            return new class extends Builder {
                public function __construct() {}
            }; 
        }
        public static function orWhere($column, $operator = null, $value = null) { 
            return new class extends Builder {
                public function __construct() {}
            }; 
        }
        public static function whereNull($column, $boolean = 'and') { 
            return new class extends Builder {
                public function __construct() {}
            }; 
        }
        public static function orWhereNull($column) { 
            return new class extends Builder {
                public function __construct() {}
            }; 
        }
        public static function with($relations) { 
            return new class extends Builder {
                public function __construct() {}
            }; 
        }
        public static function orderBy($column, $direction = 'asc') { 
            return new class extends Builder {
                public function __construct() {}
            }; 
        }
        public static function orderByDesc($column) { 
            return new class extends Builder {
                public function __construct() {}
            }; 
        }
        public static function orderByRaw($sql, $bindings = []) { 
            return new class extends Builder {
                public function __construct() {}
            }; 
        }
        public static function get($columns = ['*']) { return new Collection(); }
        public static function first($columns = ['*']) { return new static(); }
        public static function count($columns = '*') { return 0; }
        public function save(array $options = []) { return true; }
        public function update(array $attributes = [], array $options = []) { return true; }
        public function delete() { return true; }
    }
}
