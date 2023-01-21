<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Expires" content="Tue, 01 Jan 1995 12:12:12 GMT">
    <meta http-equiv="Pragma" content="no-cache">
    <title><?php getTitle(); ?></title>
    <link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $css ?>font-awesome.min.css"/>
    <link rel="stylesheet" href="<?php echo $css ?>jquery-ui.css"/>
    <link rel="stylesheet" href="<?php echo $css ?>jquery.selectBoxIt.css"/>
    <link rel="stylesheet" href="<?php echo $css ?>frontend.css"/>

 
</head>
<body onload="updateVariables()" id="status"> 



<nav class="navbar navbar-dark navbar-expand-lg bg-black">
  <div class="container">
    <a class="navbar-brand" href="index.php"><?php echo lang("home") ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav  nav  navbar-right" >
        <li class="nav-item">
          <?php 
            $categories =getcat();
            if(!empty($categories)){
              foreach($categories as $categorie){
                ?>
            <a class="nav-link " aria-current="page" href="categories.php?catid=<?=$categorie['ID'] ?>&pagename=<?=str_replace(" ","-",$categorie['Name']) ?>"><?= $categorie['Name'] ?></a> 


            <?php
              }
            }
          ?>
        </li>  
        <?php
        if(!isset($_SESSION["member"]) && !isset($_SESSION["memberid"])){
          ?>

          <li class="nav-item">
          <a class="nav-link " href="login.php">loging/sinup</a>
          </li>
          <?php

        }else{
          ?>
          <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $_SESSION["member"] ?>
          </a>
          <ul class="dropdown-menu navbar-right">
            <li><a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION["memberid"];?>"><?php echo lang("edit_profile") ?></a></li>
            <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
            <li><a class="dropdown-item" href="additem.php">Add Ads</a></li>
            <li><a class="dropdown-item" href="index.php">View Site</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php"><?php echo lang("logout") ?></a></li>
          </ul>
        </li> 
          <?php
        }
        ?>
      </ul> 
    </div>
  </div>
</nav>