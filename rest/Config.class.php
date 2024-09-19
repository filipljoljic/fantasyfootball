<?php

class Config {
    public static function DB_HOST(){
        return Config::get_env("DB_HOST", 'fantasyfootball-do-user-14289897-0.e.db.ondigitalocean.com');
    }

    public static function DB_USERNAME(){
        return Config::get_env("DB_USERNAME", 'doadmin');
    }

    public static function DB_PASSWORD(){
        return Config::get_env("DB_PASSWORD", 'AVNS_Z5eprPZcvtmA5_AafjB');
    }

    public static function DB_SCHEMA(){
        return Config::get_env("DB_SCHEMA", 'fantasyfootball');
    }

    public static function JWT_SECRET(){
        return Config::get_env('JWT_SECRET', "web");
    }

    public static function get_env($name, $default){
        return isset($_ENV[$name]) && trim($_ENV[$name]) != '' ? $_ENV[$name] : $default;
    }

}

?>