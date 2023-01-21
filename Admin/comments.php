<?php
ob_start();


session_start();
$pageTitle ="Members";
if(isset($_SESSION["Username"])){
    include "init.php";
    $do= isset($_GET["do"]) ? $_GET["do"]:"Manger";
    if($do == "Manger"){
        $query = "";
        if(isset($_GET["page"]) && $_GET["page"] == 'Approve'){
            $query = "AND Status =0";
        }
        $stmt = $con->prepare("SELECT comments.*,users.Username as Member ,items.Name as Item_Name FROM comments
                                INNER JOIN users ON users.UserID=comments.Member_ID
                                INNER JOIN items ON items.Item_ID=comments.Item_ID order by  C_ID desc
        ");
        $stmt->execute();
        $rows = $stmt->fetchAll();

         ?>
        <div class="container">
            <h1 class='text-center'>Welcom ot Mange page</h1><br> 
            <!-- <a href='?do=Add' class="btn btn-success">+ Add members</a> -->
            <div class="mytable">
                <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">comment</th>
                                <th scope="col">item</th>
                                <th scope="col">Member</th>
                                <th scope="col">Comment Date</th>
                                <th scope="col">control</th>
                                </tr>
                            </thead>
                            <tbody>
                    <?php      
                        foreach($rows as $row){
                            ?>

                                <tr>
                                    <th scope="row"><?= $row["C_ID"] ?></th>
                                    <td><?= substr($row["Comment"],0,30).".." ?></td>
                                    <td><?= $row["Item_Name"] ?></td>
                                    <td><?= $row["Member"] ?></td>
                                    <td><?= $row["Com_Date"] ?></td>
                                    <td><a href='?do=Delete&comid=<?= $row["C_ID"] ?>' class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
                                    <a href='?do=Edit&comid=<?= $row["C_ID"] ?>' class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                    <?php 
                                         if($row["Status"] == 0){
                                            ?>
                                            <a href='?do=Approve&comid=<?= $row["C_ID"] ?>' class="btn btn-info"> isApprove</a>
                                     <?php   }  ?>
                                    </td> 
                                </tr> 

                       <?php } ?>
                            </tbody>
                </table>
            </div>
        </div>   
<?php
    }elseif($do == 'Edit'|| $do =="Add" ){
        $countR=0;
        if($do=="Edit"){
            $comid = isset($_GET["comid"]) && is_numeric($_GET["comid"])? intval($_GET["comid"]):  0;
            $stmt = $con->prepare("SELECT * FROM comments WHERE C_ID =?" );
              $stmt->execute(array($comid));
              $row= $stmt->fetch();
              $countR = $stmt->rowCount();
        }

        if($countR > 0 || $do =="Add"){
            ?>           
            
            <h1 class="text-center"><?= $do=='Add'?"Add New comments":"Edit the comment"; ?></h1>
            <div class="container">
                <form class="form-horizontal" action="<?=$do=="Edit"?"?do=Update":"?do=insert";?>" method="POST">
                    <?php if($do =="Edit"){?>

                        <input type="hidden" name="comid" id="" value="<?=$comid ?>">
                   <?php }?>
                    <!-- start edit user name -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">comment</label>
                        <div class="col-sm-10 col-md-4">
                            <textarea class="form-control" name="comment"  required="required"><?php if($do == 'Edit'){echo $row["Comment"];} ?></textarea>
                        </div>
                    </div>
                    <!-- end edit user name -->
                    <?php
                        if($do=='Add'){
                            ?>

                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Members</label>
                                <div class="col-sm-10 col-md-10">
                                    <select name="member"   id="">
                                        <option value="0">...</option>
                                        <?php 
                                            $stmt1 = $con->prepare("SELECT * FROM users");
                                            $stmt1->execute();
                                            $users1 = $stmt1->fetchAll();
                                        foreach($users1 as $user1){
                                            ?>
                                            <option value="<?=$user1['UserID'] ?>" <?php if($do == 'Edit'){ if($row["Member_ID"] == $user1['UserID'])echo "selected";}  ?>><?= $user1["Username"] ?></option>

                                            <?php
                                        }

                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Items</label>
                                <div class="col-sm-10 col-md-10">
                                    <select name="item"   id="">
                                        <option value="0">...</option>
                                        <?php 
                                            $stmt1 = $con->prepare("SELECT * FROM items");
                                            $stmt1->execute();
                                            $users1 = $stmt1->fetchAll();
                                        foreach($users1 as $user1){
                                            ?>
                                            <option value="<?=$user1['Item_ID'] ?>" <?php if($do == 'Edit'){ if($row["Item_ID"] == $user1['Item_ID'])echo "selected";}  ?>><?= $user1["Name"] ?></option>

                                            <?php
                                        }

                                    ?>
                                    </select>
                                </div>
                            </div>

<?php
                        }
                    ?>
                    <!-- start edit user submit -->
                    <div class="form-group"> 
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" class="btn btn-primary mt-1" name="save" value="<?=$do=="Edit"?"save":"Add"; ?>" />
                        </div>
                    </div>
                    <!-- end edit user submit -->
                </form>
            </div>


<?php

        }else{
            echo "<h1 class='text-center'>soory</h1>";
        }
        
        //end edit page 
 
    }elseif($do == "Update" || $do=='insert' ){//start update
        if($do == 'Update'){
            echo "<h1 class='text-center'>Update comment</h1>";
        echo "<div class='container'>";
        }else{
            echo "<h1 class='text-center'>Add comment</h1>";
            echo "<div class='container'>";
        }

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $fromErorr = array();
           if($do=='insert'){
                $item=$_POST['item'];
               $member = $_POST["member"];
            }
            $comment = $_POST["comment"];
           
           
        //    echo $id.$user.$Password.$email.$fullName;
        //update the database with the info
        if(empty($comment)){
            $fromErorr[]= '<div class="alert alert-danger">the comment can not be empty </div>';
        } 
        if(!empty($fromErorr)){
            foreach($fromErorr as $erorr){
                echo $erorr;
            }
            RedirectHome( "",'back');
        }
        if($do =="Update"){
            $comid = $_POST["comid"];
            if(empty($fromErorr)){
                $stmt=$con->prepare("UPDATE comments SET comment=? WHERE C_ID=?");
                $stmt->execute(array($comment,$comid));
                $countR=$stmt->rowCount();
                if($countR>0){
                    // $_SESSION["Username"] = $user;
                    RedirectHome( "<div class='alert alert-success'> success . $countR .Recoreder </div>",'back');
                    
                }else{
                    
                    RedirectHome( "<div class='alert alert-success'>". $stmt->rowCount() .' Recoreder</div>','back');
                }
            }
        }elseif($do == "insert"){
            if(empty($fromErorr)){
                $stmt=$con->prepare("INSERT INTO comments SET Comment=?,Member_ID=?,Item_ID=?,Com_Date=now() ");
                    try{ 
                         $stmt->execute(array($comment,$member,$item));
                    }catch(PDOException $e){
                        echo $e->getMessage(); 
                        RedirectHome("<div class='alert alert-danger'>' SOORY WE HAVE PROBLEM</div>'",'back');
                    }
                    
                    
                    if($stmt->rowCount()>0){
                        RedirectHome("<div class='alert alert-success'>' success add</div>'",'back');RedirectHome("<div class='alert alert-success'>' success add</div>'",'back');
                    
                    }
                 
            }

        }

        echo "</div>"; 

        //  $stmt=$con->prepare("UPDATE users SET Username=?,Email=?,FullName=?,Password=? WHERE UserID=?");
        //  $stmt->execute(array($user,$email,$fullName,$pass,$id));
         
        //  echo $stmt->rowCount() .' Recoreder';
        //  echo $_SESSION["Username"];
        //  if($stmt->rowCount()>0){
        //     $_SESSION["Username"] = $user;
        //     echo $_SESSION["Username"];
        //  }

        }else{ 
            RedirectHome("sorry you canot dirctoly access to this page");
        }

        //end update and insert
    }elseif($do == "Delete"){

        echo "<h1 class='text-center'>Delete you members</h1>";
        $comid = isset($_GET["comid"]) && is_numeric($_GET["comid"])? intval($_GET["comid"]):  0;
        $checkd = checkitem('C_ID','comments',$comid);
        $count=0;
        if($checkd ==1){
            $stmt =$con->prepare("DELETE FROM comments WHERE C_ID =:comid");
            $stmt->bindParam(":comid",$comid);
            $stmt->execute();
            $count =$stmt->rowCount();
        }

        if($count >0){
            echo "<div class='container'>"; 
            RedirectHome( '<div class="alert alert-success">you are delete this comments </div>','back');
            echo "</div>";
        }else{
            echo "<div class='container'>";
            RedirectHome( '<div class="alert alert-danger">you are not delete this comments  maybe this id not  exists</div>','back');
            echo "</div>";
        }

    }elseif($do == 'Approve'){
        echo "<h1 class='text-center'>Approve you comments</h1>";
        $comid = isset($_GET["comid"]) && is_numeric($_GET["comid"])? intval($_GET["comid"]):  0;
        $checkd = checkitem('C_ID','comments',$comid);
        $count=0;
        if($checkd ==1){
            $stmt =$con->prepare("UPDATE comments SET Status=1 WHERE C_ID =:comid");
            $stmt->bindParam(":comid",$comid);
            $stmt->execute();
            $count =$stmt->rowCount();
        }

        if($count >0){
            echo "<div class='container'>"; 
            RedirectHome( '<div class="alert alert-success">you are Activate this comments </div>','back');
            echo "</div>";
        }else{
            echo "<div class='container'>";
            RedirectHome( '<div class="alert alert-danger">you are not Activate this comments  maybe this id not  exists</div>','back');
            echo "</div>";
        }
    }else{
        // echo "<h1 class='text-center'>sorry this action not found</h1>";
        RedirectHome("text-center'>sorry this action not found");
    } 

    include $tpl."footer.php";
}else{
    header("location:index.php");
    exit();
}

