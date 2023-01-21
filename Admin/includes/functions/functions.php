<?php


function getcat(){
    global $con;
    $stmt=$con->prepare("SELECT * FROM categories");
    $stmt->execute();
    $rows =$stmt->fetchAll();
    return $rows;
}
















// 

function getTitle(){
    global $pageTitle;
    if(isset($pageTitle)){
        echo $pageTitle;
    }else{
        echo "Default";
    }
}


//redirect to home page if warning  V2
function RedirectHome($msg,$url = null,$sec =3){
    if(isset($_SERVER["HTTP_REFERER"])&& $_SERVER["HTTP_REFERER"] !==""){
       $page='prev page'; 
    }else{
        $page='home page';
    }
    if($url === null){
        $url = 'index.php';
    }else{
        $url = isset($_SERVER["HTTP_REFERER"])&& $_SERVER["HTTP_REFERER"] !==""?$_SERVER["HTTP_REFERER"]:'index.php';
    }
    echo $msg;
    echo "<div class='alert alert-success'>you be dirct $page after $sec second</div>";
    header("refresh:$sec;url=$url");
    exit();
}



// check if the item exists 
function checkitem($select,$from,$value){
    global $con;
    $statment  = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statment->execute(array($value));
    $count = $statment->rowCount();
    return $count;
    
}


//count items
function countItems($item,$table){
    global $con;
    $stmt2 = $con->prepare("SELECT COUNT($item) from $table ");
    $stmt2->execute();
    return $stmt2->fetchColumn();
}

//get latest items
function getlatestItems($item,$table,$order,$limit ,$where=""){

    global $con;
    $stmt =$con->prepare("SELECT $item FROM $table  $where ORDER BY $order desc LIMIT $limit");
    $stmt->execute();
    $rows =$stmt->fetchAll();
    return $rows;
}
















?>