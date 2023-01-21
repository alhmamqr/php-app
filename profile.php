<?php

$pageTitle ="Profile";
include 'init.php';
if(isset($_SESSION['member'])){

    
    if(isset($_SESSION['member']) && isset($_SESSION['memberid'])){
    $username=$_SESSION['member'];
    $userid =$_SESSION['memberid'];
        $stmt=$con->prepare("SELECT * FROM users WHERE UserID =?");
        $stmt->execute(array($userid));
        $user=$stmt->fetch();
        $coutn = $stmt->rowCount();
    
        ?>
    
    
    <div class="container profile-page">
        <h1 class="text-center">Profile Page</h1>
        <div class="box-content">
    
            <div class="card">
                <div class="card-header">
                    My information
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
            foreach(getItems($userid ,'Member_ID','1') as $item){
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
            <div class="card">
                <div class="card-header">
                    Latest Comment
                </div>
                <div class="card-body">
                    <?php 
                    $comments = getComments($userid ,$where="Member_ID" );
                    if($comments !== false){
                        
                            foreach($comments as $comment){
                                ?>
                            
                            <p class="comment-profile"><?=$comment['Comment'] ?></p>
    <?php
                            }
                    }else{
                        echo "there\s no comments ";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    <?php
    }else{
        header("location:login.php");
        exit();
    }
    include $tpl."footer.php";
}
?>

