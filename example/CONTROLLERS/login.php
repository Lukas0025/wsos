<?php
    $container = new \wsos\structs\container();

    $templates = $container->get("templateLoader");
    $context   = $container->get("context");
    $auth      = $container->get("auth");

    //pass login
    if (isset($_POST["name"]) && isset($_POST["pass"])) {
        if ($auth->login($_POST["name"], $_POST["pass"])) {
            header("Location: /");
            die("logined");
        }

        $context["status"] = "fail to login";
    }
    // other cases
    else {
        $context["status"] = "";
    }

    $templates->load("login.html");    
    $templates->render($context);
    $templates->show();
?>