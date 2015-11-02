<?php

namespace Helper;


class Common
{
    static function show($str)
    {
        echo $str . ' => ' .__FILE__;
    }

    static function redirect($uri = '', $method = 'location', $http_response_code = 302)
    {
        if ( ! preg_match('#^https?://#i', $uri))
        {
            $uri = self::site_url($uri);
        }

        switch($method)
        {
            case 'refresh'	: header("Refresh:0;url=".$uri);
                break;
            default			: header("Location: ".$uri, TRUE, $http_response_code);
                break;
        }
        exit;
    }

    static function current_site_url($uri = '')
    {
        $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"];
        }
        return $pageURL . site_url($uri);
    }

    static function site_url($uri = '')
    {
        static $z_base_url = NULL;
        if(is_null($z_base_url))
        {
//            $z_base_url = str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
            // -- Remove to 'public' folder --
            $z_base_url = dirname(dirname($_SERVER['SCRIPT_NAME'])).'/';
        }

        return $z_base_url.$uri;
    }

    // Check varible existed or not
    static function df(&$value, $default = "", $allowZero = false)
    {
        if ($allowZero)
            return !isset($value) ? $default : $value;

        return empty($value) ? $default : $value;
    }

    static function h(&$str)
    {
        return isset($str) ? htmlspecialchars($str) : '';
    }



}