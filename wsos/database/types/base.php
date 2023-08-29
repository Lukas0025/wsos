<?php
    /**
     * This file contains help functions for work with database IDs
     */

    namespace wsos\database\types;
    
    class base {

        public string $sqlType = "TEXT";
        public $value;

        function __construct($value) {
            $this->value = $value;
        }

        public function get() {
            return $this->value;
        }

        public function set($value) {
            $this->value = $value;
        }
    }