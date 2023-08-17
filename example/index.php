<?php
    include __DIR__ . "/../wsos/autoload.php";
    include "DAL/text.php";
    include "DAL/user.php";

    $container = new \wsos\structs\container();
    $db        = new \wsos\database\drivers\inAppArray();
    $auth      = new \wsos\auth\basic\manager(DAL\user::class, "name", "pass", "/example/login");

    //get current url
    $url = $_SERVER['REQUEST_URI'];

    // create Basic context
    $context = [
        "url" => $url,
        "menu_items" => [
            ["url" => "/example/info",  "name" => "home"],
            ["url" => "/example/users", "name" => "users"],
            ["url" => "/example/login", "name" => "login"]
        ],

        "logined" => $auth->getActive()
    ];

    // register containers
    $container->register("DBDriver", $db);
    $container->register("templateLoader", new wsos\templates\loader(__DIR__ . "/VIEWS"));
    $container->register("context", $context);
    $container->register("auth", $auth);

    // seeds DB
    include "seeds.php";

    if ($url == "/example/users") {
        include "CONTROLLERS/users.php";
    } else if ($url == "/example/info") {
        include "CONTROLLERS/info.php";
    } else if ($url == "/example/login") {
        include "CONTROLLERS/login.php";
    } else {
        include "CONTROLLERS/info.php";
    }


?>