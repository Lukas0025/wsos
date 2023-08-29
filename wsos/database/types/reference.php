<?php
    /**
     * This file contains help functions for work with database IDs
     */

    namespace wsos\database\types;
    
    class reference extends base {
        
        public string $sqlType;
        public        $uuid;
        public        $value;

        function __construct($value, $entity) {
            $this->set($value);
            
            // set sqlType
            $this->sqlType = $this->uuid->sqlType;
            $this->value   = $this->uuid->value;

            $this->entity = $entity;

        }

        public function get() {
            $entity = new $this->entity();

            if ($entity->find("id", $this->value)) return $entity;

            return false;
        }

        public function set($value) {
            if ($value instanceof \wsos\database\core\row) {
                $this->uuid = $value->id;
            } else {
                $this->uuid = new \wsos\database\types\uuid($value);
            }
            
            $this->value   = $this->uuid->value;
        }
    }