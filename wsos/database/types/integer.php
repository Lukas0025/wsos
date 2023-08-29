<?php
    /**
     * This file contains help functions for work with database IDs
     */

    namespace wsos\database\types;
    
    class integer extends base {
        
        public string $sqlType = "INT";
        public        $value;

        function __construct(int $value) {
            $this->set($value);
        }
    }