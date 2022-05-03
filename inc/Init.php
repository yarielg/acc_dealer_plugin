<?php

namespace Dp\Inc;

final class Init{

    public static function get_services(){

        return [
            Base\Pages::class,
            Base\Settings::class,
            Base\Enqueue::class,
            Base\User::class,
            Base\Shortcodes::class,

        ] ;
    }

    public static function register_services(){

        foreach (self::get_services() as $class) {
            $service = self::instantiate($class);
            if(method_exists( $service , 'register')){
                $service->register();
            }
        }

    }

    private static function instantiate($class){

        $service = new $class();
        return $service;
    }

}
?>
