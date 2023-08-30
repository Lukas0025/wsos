<?php
    /**
     * This file contains help functions for work with database IDs
     */

    namespace wsos\database\types;
    
    class json extends base {
        
        public string $sqlType = "TEXT";

        public  $value;

        function __construct($value) {
            $this->set($value);
        }

        public function get() {
            return json_decode($this->value, true);
        }

        public function set($value) {
            $this->value = json_encode($value);
        }
    }