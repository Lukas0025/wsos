<?php
    $container = new \wsos\structs\container();

    $templates = $container->get("templateLoader");
    $context   = $container->get("context");

    // access to DB table
    $context['users'] = new wsos\database\core\table(DAL\user::class);

    $templates->load("users.html");    
    $templates->render($context);
    $templates->show();
?>