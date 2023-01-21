<?php 

$pageTitle ="Home";
$nonavbar = "";



include "init.php"; 
echo "<br>";
if((isset($_SESSION['member']) && isset($_SESSION['memberid']) || true)){
    if(isset($_SESSION['member']) && isset($_SESSION['memberid'])){

        $memberName =$_SESSION['member'];
        $statusUser = checkUserStatus($memberName);
        if($statusUser>0){
            echo "hello " . $memberName ." you have to activite from by Admin";
        }
    }
    $stmt = $con->prepare("SELECT items.*,categories.Name As Cat_Name,users.Username FROM items
    INNER JOIN categories ON categories.ID = items.Cat_ID
    INNER JOIN users ON users.UserID = items.Member_ID Where Approve!=0   order by  Item_ID desc");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    if($rows){
        ?>
    <div class="container">
    <h1 class="text-center">
        <?= $pageTitle ?>
    </h1>
    <div class="row">
        <?php
        foreach($rows as $item){
            ?>
                <div class="col-sm-6 col-md-4">
                <div class="card" style="width: 18rem;">
                    <img src="img.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><a href="item.php?itemid=<?=$item['Item_ID'] ?>"><?=$item['Name'] ?></a></h5>
                        <p class="card-text"><?=substr($item['Description'],0,50)."..." ?></p>
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
<?php
    }else{

    }

}
include "includes".DIRECTORY_SEPARATOR."temblate".DIRECTORY_SEPARATOR."footer.php";
?>


