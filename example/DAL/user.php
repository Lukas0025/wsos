<?php
    namespace DAL;

    class user extends \wsos\database\core\row {
        public \wsos\database\types\text      $name;
        public \wsos\database\types\password  $pass;
        public \wsos\database\types\integer   $age;

        function __construct($id = null, $name = "", $password = "", $age = 0) {
            parent::__construct($id);
            $this->name     = new \wsos\database\types\text($name);
            $this->pass     = new \wsos\database\types\password($password);
            $this->age      = new \wsos\database\types\integer($age);
        }
    }
?>
