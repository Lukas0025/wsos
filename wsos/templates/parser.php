<?php
    namespace wsos\templates;
    
    class parser {
        public $loader;
        public $binding;

        function __construct($loader = null) {
            $this->loader  = $loader; 
            $this->binding = [];
        }

        public function addBinding($binding) {
            $this->binding = $binding;
        }

        public function getBinding($name) {
            // check if is keyword
            if     ($name == "null")  return null;
            elseif ($name == "true")  return true;
            elseif ($name == "false") return false;

            // parse as object
            $pieces  = explode(".", $name);
            $context = $this->binding;

            foreach ($pieces as $piece) {
                if (is_null($context)) break;

                if ($context instanceof \wsos\database\core\row) {
                    /* get vars from row */
                    $tmp     = get_object_vars($context);
                    $context = [];

                    foreach ($tmp as $key => $value) {
                        $context[$key] = $tmp[$key]->get();
                    }

                } else if (is_object($context)) {
                    $context = get_object_vars($context);
                }

                if (!array_key_exists($piece, $context)) {
                    return $name;
                }

                $context = $context[$piece];
            }

            return $context;
        }

        public function exec($command) {

            $command = substr($command, 3, strlen($command) - 6); //remove {%  %}
            $command = preg_replace('/\s+/', ' ', $command . " "); // remove duplicated spaces
            
            $parts      = new \wsos\structs\vector();
            $tmp        = "";
            $str        = "";
            $stringOpen = false;
            for ($i = 0; $i < strlen($command); $i++) {
                if ($command[$i] == " " && !$stringOpen) {
                    $parts->append($tmp);
                    $tmp = "";
                } else if ($command[$i] == "'") {
                    $stringOpen = !$stringOpen;

                    if (!$stringOpen) {
                        $tmp .= str_replace(["(\\", "\\)"], ["{%", "%}"], $str);
                    }

                } else if (!$stringOpen) {
                    $tmp .= $command[$i];
                } else {
                    $str .= $command[$i];
                }
            }

            $parts = $parts->values;

            for ($i = count($parts) - 1; $i >= 0 ; $i--) {
                if (array_key_exists(strtolower($parts[$i]), functions::list())) {

                    $function = functions::list()[strtolower($parts[$i])];
                    $params   = new \wsos\structs\vector();

                    for ($param = 1; $param <= $function['params']; $param++) {
                        $params->append($parts[$i + $param]);
                        unset($parts[$i + $param]);
                    }

                    //reindex
                    $parts = array_values($parts);

                    $parts[$i] =  $function['fnc']($params->values, $this);
                }
            }

            return $parts[0];
        }
    }
?>