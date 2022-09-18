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

        public function pop() {
            return array_pop($this->values);
        }

        public function first() {
            return $this->values[0];
        }

        public function last() {
            return $this->values[$this->len() - 1];
        }

        private function len() {
            return count($this->values);
        }
    }
?>