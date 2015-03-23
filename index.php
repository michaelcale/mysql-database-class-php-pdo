<?php
include_once("dbconfig.php");
require('database.class.php');

$db = new Database();
$sql = "SELECT field_name FROM table_name WHERE field_name = :field_name";

$db->query($sql);
$db->bind(':field_name', 'some-value');
$data = $db->result_set();

echo "<pre>";
var_dump($data);
echo "</pre>";
