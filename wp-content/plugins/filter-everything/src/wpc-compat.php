<?php

if ( ! defined('WPINC') ) {
    wp_die();
}

if( ! function_exists('mb_strpos') ){
    function mb_strpos( $haystack, $needle, $offset = 0, $encoding = null )
    {
        return strpos( $haystack, $needle, $offset = 0 );
    }
}

if( ! function_exists('mb_strcut') ){
    function mb_strcut( $string, $start, $length = null, $encoding = null )
    {
        return substr( $string, $start, $length = null  );
    }
}

if( ! function_exists('mb_strlen') ){
    function mb_strlen( $string, $encoding = null )
    {
        return strlen( $string );
    }
}

if( ! function_exists('mb_strtolower') ){
    function mb_strtolower( $string, $encoding = null  )
    {
        return strtolower( $string );
    }
}

if( ! function_exists('mb_strtoupper') ){
    function mb_strtoupper( $string )
    {
        return strtoupper( $string );
    }
}

if( ! function_exists('mb_substr') ){
    function mb_substr( $string , $start, $length = null, $encoding = null )
    {
        return substr( $string, $start, $length = null );
    }
}

if (!function_exists('array_key_first')) {
    function array_key_first(array $arr) {
        foreach($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}

if( ! function_exists( 'intdiv' ) ){
    function intdiv( $a, $b ){
        return ($a - $a % $b) / $b;
    }
}

if( !function_exists('array_key_last') ) {
    function array_key_last(array $array) {
        if( !empty($array) ) return key(array_slice($array, -1, 1, true));
    }
}