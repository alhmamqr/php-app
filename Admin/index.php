<?php
session_start();
$pageTitle ="login";
$nonavbar = "";
// print_r($_SESSION);
if(isset($_SESSION["Username"])){
    header("location:dashboard.php");
        
}

include "init.php";
include $tpl . 'header.php';

// CHECK FOR POST REQUEST HTTP
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = $_POST["user"];
    $password = $_POST["pass"];
    $hashpass = sha1($password);
    // echo $username ." " . $password; 

    // check if this user in database
    // prepare  =  function for check in data base before the function chek
    $stmt = $con->prepare("SELECT
                            UserID,Username , Password 
                            FROM
                             users 
                            WHERE Username = ? 
                            AND Password = ?
                            And GroupID =1
                            LIMIT 1");
    $stmt->execute(array($username,$hashpass));
    $row= $stmt->fetch();
    $countR = $stmt->rowCount();
    // echo $countR;
    if($countR >0){
        print_r($row);
        $_SESSION["Username"] =$username ;
        $_SESSION["userid"] = $row["UserID"];
        header("location:dashboard.php");
        exit();
    }

} 

?>

<form class="login" method="POST"  action='<?php echo $_SERVER['PHP_SELF'];?>'>
    <h4 class="text-center">Admin login</h4>
    <input class="form-control" type="text" name="user" id="" placeholder="Username" autocomplete="off"/>
    <input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password"/>
    <input class="btn btn-primary btn-block" type="submit" value="login">



</form> 
<div class="test"></div>
<?php

include "includes".DIRECTORY_SEPARATOR."temblate".DIRECTORY_SEPARATOR."footer.php";
?>


