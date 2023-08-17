<?php
    $row        = new DAL\text();
    $row->name  = new \wsos\database\types\text("appName");
    $row->value = new \wsos\database\types\text("Simple Login");
    $row->commit();

    $row        = new DAL\user();
    $row->name  = new \wsos\database\types\text("Lukas");
    $row->age   = new \wsos\database\types\integer(24);
    $row->pass  = new \wsos\database\types\password("hello", true);
    $row->commit();

    $row        = new DAL\user();
    $row->name  = new \wsos\database\types\text("Tomas");
    $row->age   = new \wsos\database\types\integer(17);
    $row->pass  = new \wsos\database\types\password("password", true);
    $row->commit();

    $row        = new DAL\user();
    $row->name  = new \wsos\database\types\text("Marie");
    $row->age   = new \wsos\database\types\integer(23);
    $row->pass  = new \wsos\database\types\password("password", true);
    $row->commit();
?>