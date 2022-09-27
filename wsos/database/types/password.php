<?php
    /**
     * This file contains help functions for work with database IDs
     */

    namespace wsos\database\types;
    
    class password extends base {
        
        public string $sqlType = "TEXT";

        public  $value;

        function __construct(string $value, $raw = false) {
            $this->value = $value;

            if ($raw) {
                $this->value = password_hash($value, PASSWORD_ARGON2ID);
            }
        }

        public function verify($password) {
            return password_verify($password, $this->value);
        }
    }