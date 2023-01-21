<?php

$pageTitle ="products";
include 'init.php';

if($_SERVER["REQUEST_METHOD"]=="GET" || true){
        if(isset($_GET["itemid"])){
            $itemid=$_GET["itemid"];
             
            $stmt = $con->prepare("SELECT items.*,categories.Name As Cat_Name,users.Username FROM items
                INNER JOIN categories ON categories.ID = items.Cat_ID
                INNER JOIN users ON users.UserID = items.Member_ID WHERE Item_ID =?");
            $stmt->execute(array($itemid));
            $item = $stmt->fetch(); 

            if($item){ 

?>
    <div class="container show-item">
                <h1 class="text-center"><?= $item["Name"]?></h1>
                <div class="row">
                    <div class="col-md-3">
                        <img src="img.jpg" alt="img">
                    </div>
                    <div class="col-md-8">
                      <div class="itembox">
                      <?php
                        if($item["Approve"]=="0"){
                            echo "<div class='pending'>pending</div>";
                        } 
                        ?>
                        <div class="item item-name"><strong>name:</strong>                 <span>     <?= $item["Name"]?>   </span></div>
                        <div class="item item-description"><strong>description:</strong>   <span>     <?= $item["Description"]?>   </span></div>
                        <div class="item item-price"><strong>Price:</strong>               <span>     <?= $item["Price"]?> $ </span></div>
                        <div class="item item-date"><strong>Date:</strong>                 <span>     <?= $item["Add_Date"]?>   </span></div>
                        <div class="item item-Made"><strong>Made in:</strong>                 <span>  <?= $item["Country_Made"]?>  </span></div>
                        <div class="item item-member"><strong>With :</strong>                 <span><a href="member.php?memberid=<?= $item["Member_ID"]?>"> <?= $item["Username"]?></a>       </span></div>
                        <div class="item item-cat"><strong>Categories:</strong>            <span>   <?= $item["Cat_Name"]?> </span></div>
                      </div>
                    </div>
                </div><!-- end item -->
                <div class="item-comments"><!-- end item -->
                <h3 class="text-center">comments</h3>
                    
                        <?php
                        $stcom =$con->prepare("SELECT comments.*,users.Username FROM comments
                        INNER JOIN users ON users.UserID = comments.Member_ID WHERE Item_ID =? AND Status=1");
                        $stcom->execute(array($_GET["itemid"]));
                        $comments =$stcom->fetchAll();
                        if($comments){
                            foreach($comments as $com){
                        ?><div class="box-comment">
                                <div class="name">
                                    <img src="img.jpg" alt="">
                                    <span><a href="member.php?memberid=<?= $com["Member_ID"] ?>"><?= $com["Username"] ?></a></span>
                                </div>
                                <span class="content"><?= $com["Comment"] ?></span>
                         </div>
                         <hr>
                            <?php
                        }}else{
                            echo "<div class='box-comment'>There's no  comments</div>";
                        }
                        ?>
                        
                    
                    <?php
                    if(isset($_SESSION['member']) && $item["Approve"]=="1"){
?>
                        <div class="input-comment">
                            <form method="POST"  action='<?php echo $_SERVER['PHP_SELF'] . "?itemid=".$_GET["itemid"];?>'>
                                <textarea name="comment" id="" cols="30" rows="10"></textarea>
                                <input type="submit" value="add comment">
                            </form>
                        </div>

                        <?php
                        if($_SERVER["REQUEST_METHOD"]=="POST"){
                            $fromErorr=array();
                            $comment =filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                            $member= filter_var($_SESSION["memberid"],FILTER_SANITIZE_NUMBER_INT);
                            $item= filter_var($_GET["itemid"],FILTER_SANITIZE_NUMBER_INT); 
                            if($comment != true){
                                $fromErorr[]="please write comment";
                            }
                            if(empty($fromErorr)){
                                $stmt=$con->prepare("INSERT INTO comments SET Comment=?,Member_ID=?,Item_ID=?,Com_Date=now() ");
                                    try{ 
                                         $stmt->execute(array($comment,$member,$item));
                                    }catch(PDOException $e){
                                        echo $e->getMessage(); 
                                        echo "<div class='alert alert-danger'>' SOORY WE HAVE PROBLEM</div>'";
                                    }
                                    
                                    
                                    if($stmt->rowCount()>0){
                                       echo "<div class='alert alert-success'>' success add</div>'";
                                    
                                    }
                                 
                            }
                        }
                        if(!empty($fromErorr)){
                            foreach($fromErorr as $error){
                               echo "<div class='alert alert-danger'>' $error</div>'";
                            }
                        }
                        ?>

                        <?php
                        //if logine
                    }elseif($item["Approve"]=="0"){
                        echo "<div class='alert alert-danger'>' theres item not Approve yet for the comment </div>'";
                    }
                    else{
                        echo "<div class='alert alert-danger'>' if you want write comment pleas <a href='login.php'>login</a></div>'";
                    }

                        
?>                
                          
                </div><!-- end comment -->
    </div>
    <!-- end conteriner -->


<?php
            }else{
                echo "soory thers no item";
            }




        }
}






include $tpl."footer.php";