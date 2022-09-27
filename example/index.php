<?php
    include __DIR__ . "/../wsos/autoload.php";
    include "DAL/text.php";
    include "DAL/user.php";

    $container = new \wsos\structs\container();
    $db        = new \wsos\database\drivers\inAppArray();

    $container->register("DBDriver", $db);
    $container->register("templateLoader", new wsos\templates\loader(__DIR__ . "/VIEWS"));

    include "seeds.php";

    $user = new DAL\user();
    $user->find("name=lukas");
    echo $user->pass->verify("hello");

    if (true) {
        include "CONTROLLERS/main.php";
    }

?>