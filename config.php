<?php
$host = "host=localhost";
$dbname = "dbname=dbAppln";
$credentials = "user=admin password=db";
$db = pg_connect("$host $dbname $credentials");
?>