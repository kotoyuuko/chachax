<?php

define('CHACHAX_VERSION', '0.1.0');

if ( ! function_exists('route_class')) {
    function route_class()
    {
        return str_replace('.', '-', Route::currentRouteName());
    }
}
