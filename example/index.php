<?php
    include __DIR__ . "/../wsos/autoload.php";
    include "DAL/text.php";
    include "DAL/user.php";

    $container = new \wsos\structs\container();
    $db        = new \wsos\database\drivers\inAppArray();
    $auth      = new \wsos\auth\basic\manager(DAL\user::class, "name", "pass", "/login");

    //get current url
    $url = $_SERVER['REQUEST_URI'];

    // create Basic context
    $context = [
        "url" => $url,
        "menu_items" => [
            ["url" => "/info",  "name" => "home"],
            ["url" => "/users", "name" => "users"],
            ["url" => "/login", "name" => "login"]
        ],

        "logined" => $auth->getActive()
    ];

    // register containers
    $container->register("DBDriver", $db);
    $container->register("templateLoader", new wsos\templates\loader(__DIR__ . "/VIEWS"));
    $container->register("context", $context);
    $container->register("auth", $auth);

    // seeds DB
    // do not do this in release!!
    include "seeds.php";

    if ($url == "/users") {
        include "CONTROLLERS/users.php";
    } else if ($url == "/info") {
        include "CONTROLLERS/info.php";
    } else if ($url == "/login") {
        include "CONTROLLERS/login.php";
    } else if ($url == "/logout") {
        $auth->logout();
        header("Location: /login");
    } else {
        include "CONTROLLERS/info.php";
    }


?>