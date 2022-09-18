<?php
    /**
     * This file contains help functions for work with database IDs
     */

    namespace wsos\database;
    
    class id {
        
        public  $value;
        private $randomSize;

        function __construct($id = null, $randomSize = 13) {
            if ($id == null) {
                $date = new \DateTimeImmutable();
                $id = $this->generate($date, $randomSize);
            }

            $this->randomSize = $randomSize;
            $this->value = $id;
        }

        public static function generate($date, $randomSize) {
            return \bin2hex($date->getTimestamp()) . \bin2hex(\random_bytes($randomSize));
        }

        public function getTimestamp() {
            $timestampLen = \strlen($this->value) - $this->randomSize * 2;

            return \hex2bin(\substr($this->value, 0, $timestampLen));
        }
    }