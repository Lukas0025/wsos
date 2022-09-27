<?php
    namespace wsos\templates;

    class functions {
        public static function list() {
            return [
                "year" => [
                    "fnc"    => '\wsos\templates\functions::year',
                    "params" => 0
                ],
                
                "include" => [
                    "fnc"    => '\wsos\templates\functions::includeF',
                    "params" => 1
                ],

                "bind" => [
                    "fnc"    => '\wsos\templates\functions::bind',
                    "params" => 1
                ],

                "round" => [
                    "fnc"    => '\wsos\templates\functions::round',
                    "params" => 2
                ],

                "add" => [
                    "fnc"    => '\wsos\templates\functions::add',
                    "params" => 2
                ],

                "sub" => [
                    "fnc"    => '\wsos\templates\functions::sub',
                    "params" => 2
                ],

                "mul" => [
                    "fnc"    => '\wsos\templates\functions::mul',
                    "params" => 2
                ],

                "div" => [
                    "fnc"    => '\wsos\templates\functions::div',
                    "params" => 2
                ],

                "abs" => [
                    "fnc"    => '\wsos\templates\functions::abs',
                    "params" => 1
                ],

                "db" => [
                    "fnc"    => '\wsos\templates\functions::db',
                    "params" => 2
                ]
            ];
        }

        public static function year($params, $context) {
            return date("Y");
        }

        public static function includeF($params, $context) {
            $loader = $context->loader->newInDir();

            $loader->load($params[0]);
            $loader->render($context->binding);
    
            return $loader->getHtml();
        }

        public static function bind($params, $context) {
            if (!array_key_exists($params[0], $context->binding)) {
                return "Fail to bind {$params[0]}";
            }
    
            return $context->binding[$params[0]];
        }

        public static function round($params, $context) {    
            return round($params[0], $params[1]);
        }

        public static function add($params, $context) {    
            return $params[0] + $params[1];
        }

        public static function sub($params, $context) {    
            return $params[0] - $params[1];
        }

        public static function mul($params, $context) {    
            return $params[0] * $params[1];
        }

        public static function div($params, $context) {    
            return $params[0] / $params[1];
        }

        public static function abs($params, $context) {    
            return abs($params[0]);
        }

        public static function db($params, $context) {
            // DB <table.col=value col>
            // extract
            $params[0] = explode(".", $params[0]);
            $table     = $params[0][0];

            $params[0][1] = explode("=", $params[0][1]);
            $colSel       = $params[0][1][0];
            $colSelVal    = $params[0][1][1];

            $colRead = $params[1];

            $container = new \wsos\structs\container();
            $db = $container->get("DBDriver");

            return $db->table($table)->find($colSel, $colSelVal)[$colRead];
        } 
    }
?>