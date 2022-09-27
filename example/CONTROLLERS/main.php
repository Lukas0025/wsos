<?php
    $container = new \wsos\structs\container();
    $templates = $container->get("templateLoader");

    $templates->load("main.html");    
    $templates->render();
    $templates->show();
?>