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
            $this->uuid = \wsos\database\types\uuid($value);
            
            // set sqlType
            $this->sqlType = $this->uuid->sqlType;
            $this->value   = $this->uuid->value;

            $this->entity = $entity;

        }

        public function get() {
            $entity = $this->entity($this->uuid);
            $entity->fetch();

            return $entity;
        }

        public function set($value) {
            if ($context instanceof \wsos\database\core\row) {
                $this->uuid = $value->id;
            } else {
                $this->uuid = \wsos\database\types\uuid($value);
            }
            
            $this->value   = $this->uuid->value;
        }
    }