<?php
$dsn = 'mysql:host=localhost;dbname=shop';
$user = 'root';
$pass = 'Adams222@';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',

);

try {
    $con = new PDO($dsn,$user,$pass,$option);
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    
    echo ' <br>';
    // echo "you are conntected with database";
    echo ' <br>';
}catch(PDOException $e){
    echo ' <br>';
    echo "fiedld to conntetct to database" . $e->getMessage();
    echo ' <br>';
}