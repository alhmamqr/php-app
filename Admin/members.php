<?php
ob_start();


session_start();
$pageTitle ="Members";
if(isset($_SESSION["Username"])){
    include "init.php";
    $do= isset($_GET["do"]) ? $_GET["do"]:"Manger";
    if($do == "Manger"){
        $query = "";
        if(isset($_GET["page"]) && $_GET["page"] == 'pending'){
            $query = "AND RegStatues =0";
        }
        $stmt = $con->prepare("SELECT * FROM users  WHERE UserID !=1 $query order by  UserID desc");
        $stmt->execute();
        $rows = $stmt->fetchAll();

         ?>
        <div class="container">
            <h1 class='text-center'>Welcom ot Mange page</h1><br> 
            <a href='?do=Add' class="btn btn-success">+ Add members</a>
            <div class="mytable">
                <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Register Date</th>
                                <th scope="col">control</th>
                                </tr>
                            </thead>
                            <tbody>
                    <?php      
                        foreach($rows as $row){
                            ?>

                                <tr>
                                    <th scope="row"><?= $row["UserID"] ?></th>
                                    <td><?= $row["Username"] ?></td>
                                    <td><?= $row["Email"] ?></td>
                                    <td><?= $row["FullName"] ?></td>
                                    <td><?= $row["RegDate"] ?></td>
                                    <td><a href='?do=Delete&userid=<?= $row["UserID"] ?>' class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
                                    <a href='?do=Edit&userid=<?= $row["UserID"] ?>' class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                    <?php 
                                         if($row["RegStatues"] == 0){
                                            ?>
                                            <a href='?do=Activate&userid=<?= $row["UserID"] ?>' class="btn btn-info"> isActivate</a>
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
            $userid = isset($_GET["userid"]) && is_numeric($_GET["userid"])? intval($_GET["userid"]):  0;
            $stmt = $con->prepare("SELECT * FROM users WHERE UserID =?" );
              $stmt->execute(array($userid));
              $row= $stmt->fetch();
              $countR = $stmt->rowCount();
        }

        if($countR > 0 || $do =="Add"){
            ?>           
            
            <h1 class="text-center"><?= $do=='Add'?"Add New members":"Edit the members"; ?></h1>
            <div class="container">
                <form class="form-horizontal" action="<?=$do=="Edit"?"?do=Update":"?do=insert";?>" method="POST">
                    <?php if($do =="Edit"){?>

                        <input type="hidden" name="userid" id="" value="<?=$userid ?>">
                   <?php }?>
                    <!-- start edit user name -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" class="form-control" name="username" value="<?php if($do == 'Edit'){echo $row["Username"];} ?>" required="required"/>
                        </div>
                    </div>
                    <!-- end edit user name -->
                    <!-- start edit user Password -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label" autocomplete="new-password">Password</label>
                        <div class="col-sm-10 col-md-4">
                            <?php if($do == 'Edit'){?>

                                <input type="hidden" class="form-control" name="oldpassword" value="<?=$row["Password"] ?>" />
                            <?php }?> 
                            <div class="form-controll">
                                <input type="password" class="password form-control" name="newpassword"  />
                                <i class="fa fa-eye fa-2x show-password"></i>

                            </div>
                        </div>
                    </div>
                    <!-- end edit user Password -->
                    <!-- start edit user Email -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" class="form-control" name="email" value="<?php if($do == 'Edit'){echo $row["Email"];} ?>" required="required"/>
                        </div>
                    </div>
                    <!-- end edit user Email -->
                    <!-- start edit user Full Name -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" class="form-control" name="full" value="<?php if($do == 'Edit'){echo $row["FullName"];} ?>" required="required"/>
                        </div>
                    </div>
                    <!-- end edit user Full Name -->
                    <!-- start edit user submit -->
                    <div class="form-group"> 
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" class="btn btn-primary" name="save" value="<?=$do=="Edit"?"save":"Add"; ?>" />
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
            echo "<h1 class='text-center'>Update members</h1>";
        echo "<div class='container'>";
        }else{
            echo "<h1 class='text-center'>Add members</h1>";
            echo "<div class='container'>";
        }

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $fromErorr = array();
           $user = $_POST["username"];
           $email = $_POST["email"];
           $fullName = $_POST["full"];
           if($do == "Update"){
            $id = $_POST["userid"];
            $pass = "";
            $pass= empty($_POST["newpassword"])? $_POST["oldpassword"]:sha1($_POST["newpassword"]); 
           }elseif($do == 'insert'){
            if($_POST["newpassword"]!==""){
                $pass =sha1($_POST["newpassword"]); 
            }else{ 
                $fromErorr[]= '<div class="alert alert-danger">the pass can not be empty </div>';
            }
           }
           
        //    echo $id.$user.$Password.$email.$fullName;
        //update the database with the info
        if(empty($user)){
            $fromErorr[]= '<div class="alert alert-danger">the username can not be empty </div>';
        }
        if(empty($fullName)){
            $fromErorr[]= '<div class="alert alert-danger">the FullName can not be empty </div>';
        }
        if(empty($email)){
            $fromErorr[]= '<div class="alert alert-danger">the email can not be empty </div>';
        }
        if(strlen($user) < 4){
            $fromErorr[]= '<div class="alert alert-danger">the username can not be less than 4 character </div>';
        }
        if(strlen($user) > 20){
            $fromErorr[]= '<div class="alert alert-danger">the username can not be more than 20 </div>';
        }
        if(!empty($fromErorr)){
            foreach($fromErorr as $erorr){
                echo $erorr;
            }
            RedirectHome( "",'back');
        }
        if($do =="Update"){
            if(empty($fromErorr)){
                $stmt1=$con->prepare("SELECT * FROM users WHERE Username=? And UserID!=?");
                $stmt1->execute(array($user,$id));
                $stmt1->fetch();
                $chekIfEx =$stmt1->rowCount();
                if($chekIfEx>0){
                    RedirectHome( "<div class='alert alert-danger'> there exists name </div>",'back');
                }else{
                    $stmt=$con->prepare("UPDATE users SET Username=?,Email=?,FullName=?,Password=? WHERE UserID=?");
                    $stmt->execute(array($user,$email,$fullName,$pass,$id));
                    $countR=$stmt->rowCount();
                    if($countR>0){
                        // $_SESSION["Username"] = $user;
                        RedirectHome( "<div class='alert alert-success'> success . $countR .Recoreder </div>",'back');
                        
                    }else{
                        
                        RedirectHome( "<div class='alert alert-success'>". $stmt->rowCount() .' Recoreder</div>','back');
                    }

                }
            }
        }elseif($do == "insert"){
            if(empty($fromErorr)){
                $check =checkitem("Username","users",$user);
                if($check == 1){
                    
                    RedirectHome( "<div class='alert alert-danger'>sorry that insert name is exists</div>'",'back');RedirectHome( "<div class='alert alert-danger'>sorry that insert name is exists</div>'",'back');
                }else{
                    $stmt=$con->prepare("INSERT INTO users SET Username=?,Email=?,FullName=?,Password=?,RegStatues=?,RegDate=now() ");
                    try{
                        $stmt->execute(array($user,$email,$fullName,$pass,1,));
                    }catch(PDOException $e){
                        echo $e->getMessage(); 
                        RedirectHome("<div class='alert alert-danger'>' pleas inter the name  else this name is exists</div>'",'back');
                    }
                    
                    
                    if($stmt->rowCount()>0){
                        RedirectHome("<div class='alert alert-success'>' success add</div>'",'back');RedirectHome("<div class='alert alert-success'>' success add</div>'",'back');
                    
                    }
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
        $userid = isset($_GET["userid"]) && is_numeric($_GET["userid"])? intval($_GET["userid"]):  0;
        $checkd = checkitem('UserId','users',$userid);
        $count=0;
        if($checkd ==1){
            $stmt =$con->prepare("DELETE FROM users WHERE UserID =:userid");
            $stmt->bindParam(":userid",$userid);
            $stmt->execute();
            $count =$stmt->rowCount();
        }

        if($count >0){
            echo "<div class='container'>"; 
            RedirectHome( '<div class="alert alert-success">you are delete this members </div>','back');
            echo "</div>";
        }else{
            echo "<div class='container'>";
            RedirectHome( '<div class="alert alert-danger">you are not delete this members  maybe this id not  exists</div>','back');
            echo "</div>";
        }

    }elseif($do == 'Activate'){
        echo "<h1 class='text-center'>Activate you members</h1>";
        $userid = isset($_GET["userid"]) && is_numeric($_GET["userid"])? intval($_GET["userid"]):  0;
        $checkd = checkitem('UserId','users',$userid);
        $count=0;
        if($checkd ==1){
            $stmt =$con->prepare("UPDATE users SET RegStatues=1 WHERE UserID =:userid");
            $stmt->bindParam(":userid",$userid);
            $stmt->execute();
            $count =$stmt->rowCount();
        }

        if($count >0){
            echo "<div class='container'>"; 
            RedirectHome( '<div class="alert alert-success">you are Activate this members </div>','back');
            echo "</div>";
        }else{
            echo "<div class='container'>";
            RedirectHome( '<div class="alert alert-danger">you are not Activate this members  maybe this id not  exists</div>','back');
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

