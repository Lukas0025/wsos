<?php
    namespace wsos\structs;

    class container {
        private $link;

        function __construct($name = "global") {
            $link = "container_$name";
            if (!isset($GLOBALS[$this->link])) {
                $GLOBALS[$this->link] = [];
            }
        }

        function register($name, $object) {
            $GLOBALS[$this->link][$name] = $object;
        }

        function get($class) {
            return $GLOBALS[$this->link][$class];
        }
    }
?>