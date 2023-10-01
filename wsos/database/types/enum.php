<?php
    /**
     * This file contains help functions for work with database IDs
     */

    namespace wsos\database\types;
    
    class enum extends base {
        
        public string $sqlType = "INT";

        public  $value;
        private $dict;
        private $default;

        function __construct($value, $dict, $default = null) {
            $this->dict    = $dict;
            $this->default = $default;
            $this->set($value);
        }

        public function get() {
            return $this->dict[$this->value];
        }

        public function getVal($value) {
            if (!in_array($value, $this->dict)) {
                if (is_null($this->default)) throw new Exception("Try set value {$value} to dict {$this->dict} without default");

                $value = $this->default;
            }
            
            return array_search($value, $this->dict);
        }

        public function set($value) {
            $this->value = $this->getVal($value);
        }
    }