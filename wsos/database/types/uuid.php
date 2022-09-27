<?php
    /**
     * This file contains help functions for work with database IDs
     */

    namespace wsos\database\types;
    
    class uuid extends base {
        
        public string $sqlType = "CHAR(16)";

        public  $value;

        function __construct($id = null) {

            if (is_null($id)) {
                $this->value = $this->generate();
            } else if (strlen($id) > 16) {
                $this->loadFormated($id);
            } else {
                $this->value = $id;
            }
            
        }

        private function generate() {
            $data = random_bytes(16);

            // Set version to 0100
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
            // Set bits 6-7 to 10
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

            return $data;
        }

        public function getFormated() {
            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($this->value), 4));
        }

        public function loadFormated($data) {
            $this->value = hex2bin(str_replace('-', '', $data));
        }
    }