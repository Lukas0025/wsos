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

                "bindinclude" => [
                    "fnc"    => '\wsos\templates\functions::bindinclude',
                    "params" => 2
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
                ],

                "foreach" => [
                    "fnc"    => '\wsos\templates\functions::foreachf',
                    "params" => 3
                ],

                "if" => [
                    "fnc"    => '\wsos\templates\functions::iff',
                    "params" => 3
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

        public static function bindinclude($params, $context) {
            $loader = $context->loader->newInDir();

            $binding         = $context->binding;
            $binding["item"] = $context->getBinding($params[0]);; 

            $loader->load($params[0]);
            $loader->render($binding);
    
            return $loader->getHtml();
        }

        public static function bind($params, $context) {
            return $context->getBinding($params[0]);
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

        public static function foreachf($params, $context) {
            $array  = $context->getBinding($params[0]);
            $loader = $context->loader->newInDir();
            $html   = "";

            if ($array instanceof \wsos\database\core\table) {
                $array = $array->getAll()->values;
            }

            foreach ($array as $item) {
                $binding         = $context->binding;
                $binding["item"] = $item; 

                if ($params[1] == "RENDER") {
                    $loader->load($params[2]);
                } else if ($params[1] == "USE") {
                    $loader->loadHtml($params[2]);
                }

                $loader->render($binding);
                $html .= $loader->getHtml();
            }

            return $html;
        }

        public static function iff($params, $context) {
            $condition = $params[0];
            $operands  = explode(" ", str_replace(['==', '!=', '<=', '>=', '<', '>'], " ", $condition));
            preg_match_all('/[=,<,>,!]+/i', $condition, $operators);

            $operators = $operators[0];

            $res = true;
            for ($i = 0; $i < count($operands) - 1; $i++) {
                if ($operators[$i] == '==')      $res = $res && ($context->getBinding($operands[$i]) == $context->getBinding($operands[$i + 1]));
                elseif ($operators[$i] == '!=')  $res = $res && ($context->getBinding($operands[$i]) != $context->getBinding($operands[$i + 1]));
                elseif ($operators[$i] == '<=')  $res = $res && ($context->getBinding($operands[$i]) <= $context->getBinding($operands[$i + 1]));
                elseif ($operators[$i] == '>=')  $res = $res && ($context->getBinding($operands[$i]) >= $context->getBinding($operands[$i + 1]));
                elseif ($operators[$i] == '<')   $res = $res && ($context->getBinding($operands[$i]) <  $context->getBinding($operands[$i + 1]));
                elseif ($operators[$i] == '>')   $res = $res && ($context->getBinding($operands[$i]) >  $context->getBinding($operands[$i + 1]));
                else $res = false;
            }

            if (!$res) return "";

            $loader = $context->loader->newInDir();
            $html   = "";

            if ($params[1] == "RENDER") {
                $loader->load($params[2]);
            } else if ($params[1] == "USE") {
                $loader->loadHtml($params[2]);
            }

            $loader->render($context->binding);

            return $loader->getHtml();
        }
    }
?>