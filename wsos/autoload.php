<?php
    class Autoloader {
        public static function register() {
            spl_autoload_register(function ($class) {
                $file = __DIR__ . str_replace(['\\', 'wsos'], [DIRECTORY_SEPARATOR, ''], $class) . '.php';
                
                if (file_exists($file)) {
                    require $file;
                    return true;
                }

                return false;
            });
        }
    }

    Autoloader::register();
?>