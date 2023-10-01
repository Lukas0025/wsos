<?php
/**
 * Base databse table
 */

namespace wsos\database\core;

class table {
    function __construct($entity = null) {
        $this->entity = $entity;
    }

    public function getAll() {
        return $this->query("", []);
    }

    public function count($cmd, $bindings, $order = null, $limit = null) {
        $container = new \wsos\structs\container();
        $db        = $container->get("DBDriver");
        
        return $db->table($this->entity)->count($cmd, $bindings, $this->entity, $order, $limit);
    }

    public function query($cmd, $bindings, $order = null, $limit = null, $prefetch = true) {
        $container = new \wsos\structs\container();
        $db        = $container->get("DBDriver");
            
        $res = $db->table($this->entity)->query($cmd, $bindings, $this->entity, $order, $limit);

        $objs = new \wsos\structs\vector();

        foreach ($res as $id) {
            $item = new $this->entity(new \wsos\database\types\uuid($id));
            if ($prefetch) $item->fetch();

            $objs->append($item);
        }

        return $objs;
    }
}