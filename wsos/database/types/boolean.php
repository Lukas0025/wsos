<?php
    /**
     * This file contains help functions for work with database IDs
     */

    namespace wsos\database\types;
    
    class boolean extends base {
        
        public string $sqlType = "BIT(1)";

        public  $value;

        function __construct($value) {
            $this->set($value);
        }

        public function get() {
            if ($this->value == 0) return false;
            else                   return true;
        }

        public function set($value) {
            if ($value) $this->value = 1;
            else        $this->value = 0;
        }
    }