<?php    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);    
    echo  "Hello World" ; 
    $host = "host=localhost";
    $dbname = "dbname=dbAppln";
    $credentials = "user=admin password=db";
    $conn = pg_connect("$host $dbname $credentials");
    echo "hello";
    if (!$conn) {
      echo "An error occurred.\n";
      exit;
    }
    echo "hi";
    $result = pg_query($conn, "SELECT * from users");
    if (!$result) {
      echo "An error occurred.\n";
      exit;
    }

    while ($row = pg_fetch_row($result)) {
      echo "$row[0]";
      echo "<br />\n";
    }
    
?>
