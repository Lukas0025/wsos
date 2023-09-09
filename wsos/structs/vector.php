<?php
    namespace wsos\structs;

    class vector {
        public $values = [];
        
        public function append($data) {
            array_push($this->values, $data);
        }

        public function push($data) {
            $this->append($data);
        }

        public function concat($array) {
            $this->values = array_merge($this->values, $array->values);
        }

        public function pop() {
            return array_pop($this->values);
        }

        public function first() {
            return $this->values[0];
        }

        public function last() {
            return $this->values[$this->len() - 1];
        }

        public function len() {
            return count($this->values);
        }
    }
?>