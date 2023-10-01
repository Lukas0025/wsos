<?php
    /**
     * This file contains help functions for work with database IDs
     */

    namespace wsos\database\types;
    
    class timestamp extends base {
        
        public string $sqlType = "INT";
        public        $value;

        function __construct($value) {
            $this->set($value);
        }

        public function get($format = "Y-m-d H:i:s") {
            return date($format, $this->value);
        }

        public function set($time) {
            if (is_string($time)) {
                $this->value = strtotime($time);
            } else if (is_int($time)) {
                $this->value = $time;
            }
        }

        public function delta($time = null) {
            if (is_null($time)) $time = time();

            return abs($this->value - $time);
        }

        public function strDelta($time = null) {
            $delta = $this->delta($time);

            if ($delta < 60)    return "{$delta} seconds";
            if ($delta < 3600)  return floor($delta / 60) . " minutes";
            if ($delta < 86400) return floor($delta / 3600) . " hours";
            
            return floor($delta / 86400) . " days";
        }

        public function now() {
            $this->value = time();
        }
    }