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
    <link rel="stylesheet" href="<?php echo $css ?>backend.css"/>

 
</head>
<body onload="updateVariables()" id="status"> 