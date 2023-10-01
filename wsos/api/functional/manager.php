<?php
/**
 * Base databse table
 */

namespace wsos\api\functional;

class manager {
    private $apiClass;

    function __construct($apiClass) {
        $this->apiClass = $apiClass;
    }

    public function serve($params) {
        $function = "\\{$this->apiClass}\\" . implode("\\", $params);
        $args     = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST')     $args = $_POST;
        else if ($_SERVER['REQUEST_METHOD'] === 'GET') $args = $_GET;

        if (!function_exists($function)) die("Function {$function} not exists");

        echo json_encode($function($args));
    }
}
