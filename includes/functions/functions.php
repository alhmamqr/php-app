<?php

// front
function getcat(){
    global $con;
    $stmt=$con->prepare("SELECT * FROM categories");
    $stmt->execute();
    $rows =$stmt->fetchAll();
    return $rows;
}
function getItems($itemid="" ,$where="Cat_ID",$Approve=null ){
    $sql = $Approve == null? 'AND Approve =1':"";
    global $con;
    $stmt=$con->prepare("SELECT * FROM items WHERE $where = $itemid $sql ORDER BY Item_ID desc");
    $stmt->execute();
    $rows =$stmt->fetchAll();
    return $rows;
}
function getComments($itemid="" ,$where="Item_ID" ){
    global $con;
    $stmt=$con->prepare("SELECT * FROM comments WHERE $where = $itemid ORDER BY C_ID desc");
    $stmt->execute();
    $rows =$stmt->fetchAll();
    return (isset($rows) && !empty($rows))?$rows:false;
}


// front

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
function getlatestItems($item,$table,$order,$limit){
    global $con;
    $stmt =$con->prepare("SELECT $item FROM $table ORDER BY $order desc LIMIT $limit");
    $stmt->execute();
    $rows =$stmt->fetchAll();
    return $rows;
}



// cheac for the statues fro user

function checkUserStatus($user){
    global $con;
    $stmt=$con->prepare("SELECT Username FROM users WHERE Username =? And RegStatues =0");
    $stmt->execute(array($user));
    $rows =$stmt->fetchAll();
    $count=$stmt->rowCount();
    return $count;
}












?>