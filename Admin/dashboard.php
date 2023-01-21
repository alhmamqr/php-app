<?php
ob_start();
session_start();
$pageTitle ="Dashboard";
if($_SESSION["Username"]){
    require_once 'init.php';
?>
<div class="container home-stat text-center">
<h1 class="text-center">dashboard</h1>
<div class="row">
    <div class="col-md-3">
        <div class="stat st-members">
            <i class="fa fa-users"></i>
            <div class="info">
                Total members
                <a href="members.php"> 
                    <span>
                    <?php echo countItems('UserID','users') ?> 
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat st-pending">
            <div class="info">
                <i class="fa fa-user-plus"></i>
                Pending members
                <a href="members.php?page=pending">
                    <span>
                    <?php echo checkitem('RegStatues','users',0); ?>    
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat  st-items">
            <i class="fa fa-tag"></i>
            <div class="info">

                Total items
                <a href="items.php">
                <span>
                    <?php echo countItems('Item_ID','items'); ?>
                </span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3 ">
        <div class="stat st-comments">
            <i class="fa fa-comments"></i>
            <div class="info">

                Total comments
                <a href="comments.php">
                <span>
                    <?php echo countItems('C_ID','comments'); ?>
                </span>
                </a>
            </div>
        </div>
    </div>
</div> 
</div>
<div class="container latest">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php $limit =4; ?>
                        <i class="fa fa-users"></i>
                        Latest <?=$limit ?> registerd users
                        <span class="toggle-info pull-right">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                </div>
                <div class="panel-body">
                    <?php
                    $rows =getlatestItems('*','users','UserID',$limit ,"WHERE UserID!=1");
                    if(empty($rows)){
                        echo "empty users";
                    }else{

                    ?><ul class="list-unstyled latest-users">
                        
                        <?php
                    foreach($rows as $row){
                        ?>
                        <li><?php echo $row["Username"] ?> 
                        <a href="members.php?do=Edit&userid=<?php echo $row['UserID']?>" class="btn btn-success pull-right">Edit</a>
                    </li>
                        
                        
                        <?php
                    }

?>
</ul>
<?php
                    }
                    ?>
                </div>
                
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                <?php $limit_items =4; ?>
                        <i class="fa fa-tag"></i>
                        Latest <?=$limit_items ?> items
                        <span class="toggle-info pull-right">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                </div>
                <div class="panel-body">
                <?php
                    $items =getlatestItems('*','items','Item_ID',$limit_items);
                    if(empty($items)){
                        echo "Empty Items";
                    }else{

                    ?><ul class="list-unstyled latest-users">
                        <?php
                    foreach($items as $item){
                        ?>
                        <li><?php echo $item["Name"] ?> 
                        <a href="items.php?do=Edit&Itemid=<?php echo $item['Item_ID']?>" class="btn btn-success pull-right">Edit</a>
                    </li>
                        
                        
                        <?php
                    }

?>
</ul>
<?php
                    }
                    ?>
                </div>
                
            </div>
        </div>
    </div>
    <div class="row"> 
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                <?php $limit_comments =4; ?>
                        <i class="fa fa-comments"></i>
                        Latest <?=$limit_comments ?> comments
                        <span class="toggle-info pull-right">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                </div>
                <div class="panel-body">
            
                <div class="comments-box">
                    <?php
                            $stmt = $con->prepare("SELECT comments.*,users.Username as Member ,items.Name as Item_Name FROM comments
                            INNER JOIN users ON users.UserID=comments.Member_ID
                            INNER JOIN items ON items.Item_ID=comments.Item_ID order by C_ID LIMIT $limit_comments
                            ");
                            $stmt->execute();
                            $comments = $stmt->fetchAll();
                    if(!empty($comments)){
                        foreach($comments as $comment){
                            ?>
                            <div class="comment-item">
                            <span class="com_n"> <?=$comment['Member'] ?></span>
                            <span class="com_c"><?=$comment['Comment'] ?></span>
                            <div class="control">
                            <a href="comments.php?do=Edit&comid=<?php echo $comment['C_ID']?>" class="btn btn-success pull-right">
                            <i class="fa fa-edit"></i>
                        </a>
                            </div>
                            </div>
<?php
                        }
                    }else{
                        echo "Empty Comments";
                    }
                    ?>
            </div>

 
                </div>
                
            </div>
        </div>
    </div>
</div>
<?php
include "includes".DIRECTORY_SEPARATOR."temblate".DIRECTORY_SEPARATOR."footer.php";
}else{
    echo "soory";
    header('location:index.php'); 
    exit();
}



ob_end_flush();






