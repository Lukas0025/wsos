<?php
    /**
     * This file contains help functions for work with database IDs
     */

    namespace wsos\database\types;
    
    class text extends base {
        
        public string $sqlType = "TEXT";

        public  $value;

        function __construct(string $value) {
            $this->value = $value;
        }
    }