<?php
    /**
     * This file contains help functions for work with database IDs
     */

    namespace wsos\database\types;
    
    class enum extends base {
        
        public string $sqlType = "INT";

        public  $value;
        private $dict;

        function __construct($value, $dict, $default = null) {
            $this->dict  = $dict;
            $this->set($value);
        }

        public function get() {
            return $this->dict[$this->value];
        }

        public function set($value) {
            if (!in_array($value, $dict)) {
                if (is_null($default)) throw new Exception("Try set value {$value} to dict {$dict} without default");

                $value = $default;
            }

            $this->value = array_search($value, $dict);
        }
    }