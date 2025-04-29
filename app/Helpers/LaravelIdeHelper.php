<?php

/**
 * Laravel IDE Helper
 * 
 * This file provides IDE autocomplete for Laravel's global functions and facades
 * It doesn't actually do anything at runtime - it's only for IDE static analysis
 */

if (!function_exists('view')) {
    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string|null  $view
     * @param  array  $data
     * @param  array  $mergeData
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    function view($view = null, $data = [], $mergeData = []) {
        return app('view')->make($view, $data, $mergeData);
    }
}

if (!function_exists('redirect')) {
    /**
     * Get a redirector instance.
     *
     * @param  string|null  $to
     * @param  int  $status
     * @param  array  $headers
     * @param  bool|null  $secure
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    function redirect($to = null, $status = 302, $headers = [], $secure = null) {
        return app('redirect')->to($to, $status, $headers, $secure);
    }
}

if (!function_exists('response')) {
    /**
     * Return a new response from the application.
     *
     * @param  mixed  $content
     * @param  int  $status
     * @param  array  $headers
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    function response($content = '', $status = 200, array $headers = []) {
        return app('response')->make($content, $status, $headers);
    }
}

if (!function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param  string|null  $abstract
     * @param  array  $parameters
     * @return mixed|\Illuminate\Contracts\Foundation\Application|\Illuminate\Container\Container
     */
    function app($abstract = null, array $parameters = []) {
        return \Illuminate\Container\Container::getInstance()->make($abstract, $parameters);
    }
} 