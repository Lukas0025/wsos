<?php
    /**
     * This file contains help functions for work with database IDs
     */

    namespace wsos\database\drivers;
    
    class inAppArray {
        
        public $array;

        function __construct() {
            $this->array = [];
        }

        public function table($name) {
            return new table($name, $this);
        }
    }

    class table {
        private $name;
        private $driver;

        function __construct($name, $driver) {
            $this->name   = $name;
            $this->driver = $driver;
        }

        public function createUpdate($obj) {
            $array = [];

            foreach ($obj as $name => $values) {
                $array[$name] = $values['value'];
            }

            $this->driver->array[$obj['id']['value']] = $array;
        }

        public function find($col, $value) {

            foreach ($this->driver->array as $row) {
                if ($row[$col] == $value) {
                    return $row;
                }
            }

            return null;

        }

        public function get($id) {
            return $this->driver->array[$id];
        }
    }