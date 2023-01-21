<?php

$pageTitle ="profile";
$nonavbar = "";



include "init.php"; 

if($_SERVER["REQUEST_METHOD"]=="GET"){

    $memberid =$_GET["memberid"];
    $stmt=$con->prepare("SELECT * FROM users WHERE UserID =?");
    $stmt->execute(array($memberid));
    $user=$stmt->fetch();
    $coutn = $stmt->rowCount();
    if($coutn){

?>

        <div class="container profile">
            <h1 class="text-center">
            <?= $user['Username'] ?>
            </h1>
            <div class="card">
                <div class="card-header">
                    Member information
                </div>
                <div class="card-body">
                    <p class="card-title"ُ> <strong>Username :            </strong> <?= $user['Username'] ?> </p>
                    <p class="card-text">  <strong>Email:                </strong> <?= $user['Email'] ?>    </p>
                    <p class="card-text">  <strong>Full Name :           </strong> <?= $user['FullName'] ?> </p>
                    <p class="card-text">  <strong>Register Date :       </strong> <?= $user['RegDate'] ?>  </p>
                    <p class="card-text">  <strong>Favorate categories : </strong> <?= $user['RegDate'] ?>  </p>
                </div>
            </div>
            <div class="card main">
                <div class="card-header">
                    My ADS
                </div>
                <div class="card-body main"> 
                <div class="row">
            <?php
            foreach(getItems($memberid ,'Member_ID') as $item){
                ?>
                    <div class="col-sm-6 col-md-4">
                    <div class="card" style="width: 18rem;">
                        <?php
                        if($item["Approve"]=="0"){
                            echo "<div class='pending'>pending</div>";
                        } 
                        ?>
                        <img src="img.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><a href="item.php?itemid=<?=$item['Item_ID'] ?>"><?=$item['Name'] ?></a></h5>
                            <p class="card-text"><?=$item['Description'] ?></p>
                            <p class="card-price"><?=$item['Price'] ?> $</p>
                            <p class="card-member"><?=$item['Rating'] ?> *</p>
                        </div>
                    </div>
                    </div>
                <?php
            }
            ?>
        </div>
                </div>
            </div>
        </div>



  <?php      
    }else{
        header("location:index.php");
        exit();
    }


}else{
    header("location:index.php");
        exit();
}






include "includes".DIRECTORY_SEPARATOR."temblate".DIRECTORY_SEPARATOR."footer.php";
?>



