<?php
/**
 * Generate random ID for database use
 */

include __DIR__ . "/../wsos/autoload.php";

//crate new ID
$myid = new wsos\database\id();

//echo ID value
echo $myid->value . "\n";

//save to DB
$psedoDB = $myid->value;

//load from db
$dbid = new wsos\database\id($psedoDB);

//echo time of creation of id
echo date('m/d/Y H:i:s', $dbid->getTimestamp()) . "\n";

?>