<?php
    $container = new \wsos\structs\container();

    $templates = $container->get("templateLoader");
    $context   = $container->get("context");
    $auth      = $container->get("auth");

    // to show this page user must be logined
    $auth->requireLogin();

    // access to DB table
    $context['users'] = new wsos\database\core\table(DAL\user::class);

    $templates->load("users.html");    
    $templates->render($context);
    $templates->show();
?>