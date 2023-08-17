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
    // pass logout
    else if (isset($_GET["logout"])) {
        $auth->logout();
        $context["status"] = "logouted";
    }
    // other cases
    else {
        $context["status"] = "";
    }

    $templates->load("login.html");    
    $templates->render($context);
    $templates->show();
?>