<?php
include "connect.php";
$tpl = 'includes'.DIRECTORY_SEPARATOR.'temblate'.DIRECTORY_SEPARATOR;
$fanc = 'includes'.DIRECTORY_SEPARATOR.'functions'.DIRECTORY_SEPARATOR;
$css = 'layout'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR;
$js = 'layout'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR;
$lang = 'includes'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR;


include $fanc.'functions.php';
// include the file 
include $lang.'english.php';
include $tpl.'header.php';


if(!isset($nonavbar)){
    include $tpl.'navbar.php';
}


