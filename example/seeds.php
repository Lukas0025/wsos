<?php
    $row        = new DAL\text();
    $row->name  = new \wsos\database\types\text("h1");
    $row->value = new \wsos\database\types\text("hello");
    $row->commit();

    $row        = new DAL\user();
    $row->name  = new \wsos\database\types\text("lukas");
    $row->age   = new \wsos\database\types\integer(22);
    $row->pass  = new \wsos\database\types\password("hello", true);
    $row->commit();
?>