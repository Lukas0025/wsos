<?php
    /**
     * Base databse table row, only with ID
     */

    namespace wsos\database\core;
    
    class row {
        
        public \wsos\database\types\uuid $id;

        function __construct($id = null) {
            if (is_null($id)) {
                $id = new \wsos\database\types\uuid();
            }

            $this->id = $id;
        }

        public function fetch() {
            $container = new \wsos\structs\container();
            $db        = $container->get("DBDriver");
            
            $res = $db->table(get_class($this))->get($this->id->value);

            $vars = get_object_vars($this);
            
            foreach ($res as $key => $value) {
                $this->$key->value = $value;
            }
        }

        public function find($col, $val) {
            $container = new \wsos\structs\container();
            $db        = $container->get("DBDriver");

            $res = $db->table(get_class($this))->find($col, $val);

            var_dump($res);

            if (is_null($res)) return false;

            $this->id->value = $res['id'];
            $this->fetch();

            return true;
        }

        public function commit() {
            $vars = get_object_vars($this);
            
            $data = [];
            foreach ($vars as $name => $value) {
                $data[$name] = [
                    "value" => $value->value,
                    "type"  => $value->sqlType
                ];
            }

            $container = new \wsos\structs\container();
            $db        = $container->get("DBDriver");

            $db->table(get_class($this))->createUpdate($data);
        }
    }