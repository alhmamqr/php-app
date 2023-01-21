<?php
session_start();
include "init.php";

$do ="";

$do = isset($_GET["do"])?$_GET["do"]:"Manger";

if($do == "Manger"){
    echo "Welcom in the manger";
}elseif($do == "add"){
    echo " welcom in add page";
}else{
    echo "sorry no this pages <a href='?do=Manger'>go back</a>";

}


include "includes".DIRECTORY_SEPARATOR."temblate".DIRECTORY_SEPARATOR."footer.php";





