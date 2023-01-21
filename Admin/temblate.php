<?php


ob_start();


session_start();
$pageTitle ="categories";

if(isset($_SESSION["Username"])){
    include "init.php";
    $do= isset($_GET["do"]) ? $_GET["do"]:"Manger";
    if($do =='Manger'){

    }elseif($do =='Add'){

    }elseif($do =='Edit'){

    }elseif($do =='Update'){

    }elseif($do =='Delete'){

    }elseif($do=='Activate'){

    }elseif($do=='insert'){

    }else{
        RedirectHome("text-center'>sorry this action not found");
    }
    include $tpl."footer.php";
}else{
        header("location:index.php");
        exit();
}



























