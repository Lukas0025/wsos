<?php
    include __DIR__ . "/../wsos/autoload.php";

    $templates = new wsos\templates\loader(__DIR__ . "/template");

    $templates->load("test.html");
    
    $templates->render([
        'h3' => 'hello',
        'date' => 0
    ]);

    $templates->saveHtml("test.html");
    $templates->show();
    //$templates->getHtml();
?>