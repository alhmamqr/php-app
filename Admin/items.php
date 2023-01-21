<?php


ob_start();


session_start();
$pageTitle ="categories";

if(isset($_SESSION["Username"])){
    include "init.php";
    $do= isset($_GET["do"]) ? $_GET["do"]:"Manger";
    if($do == "Manger"){
        $query = "";
        if(isset($_GET["page"]) && $_GET["page"] == 'Approve'){
            $query = "AND Approve =0";
        }
        $sort="ASC";
        $sort_array=array("ASC","DESC");
        if(isset($_GET["sort"]) && in_array($_GET["sort"],$sort_array)){
            $sort =$_GET["sort"];
        }

        $stmt = $con->prepare("SELECT items.*,categories.Name As Cat_Name,users.Username FROM items
        INNER JOIN categories ON categories.ID = items.Cat_ID
        INNER JOIN users ON users.UserID = items.Member_ID $query order by  Item_ID desc");
        $stmt->execute();
        $rows = $stmt->fetchAll();

         ?>
        <div class="container categories">
            <h1 class='text-center'>Welcom ot Mange Items</h1><br> 
            <a href='?do=Add' class="btn btn-success">+ Add Items</a>
            <div class="mytable">
                <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">name</th>
                                <th scope="col">description</th>
                                <th scope="col">price</th>
                                <th scope="col">User</th>
                                <th scope="col">Categories</th>
                                <th scope="col">ADD Date</th>
                                <th scope="col">control</th>
                                </tr>
                            </thead>
                            <tbody>
                    <?php      
                        foreach($rows as $row){
                            ?>

                                <tr>
                                    <th scope="row"><?= $row["Item_ID"] ?></th>
                                    <td><?= $row["Name"] ?></td>
                                    <td><?= substr($row["Description"],0,30) ?></td>
                                    <td><?= $row["Price"] ?></td>
                                    <td><?= $row["Username"] ?></td>
                                    <td><?= $row["Cat_Name"] ?></td>
                                    <td><?= $row["Add_Date"] ?></td>
                                    <td><a href='?do=Delete&Itemid=<?= $row["Item_ID"] ?>' class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
                                    <a href='?do=Edit&Itemid=<?= $row["Item_ID"] ?>' class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                    <?php 
                                         if($row["Approve"] == 0){
                                            ?>
                                            <a href='?do=Approve&Itemid=<?= $row["Item_ID"] ?>' class="btn btn-info"> is Approve</a>
                                     <?php   }  ?>
                                    </td> 
                                </tr> 

                       <?php } ?>
                            </tbody>
                </table>
            </div>
 
<?php
    }elseif($do == 'Edit'|| $do =="Add" ){
        $countR=0;
        if($do=="Edit"){
            $itemid = isset($_GET["Itemid"]) && is_numeric($_GET["Itemid"])? intval($_GET["Itemid"]):  0;
            $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID =? " );
              $stmt->execute(array($itemid));
              $row= $stmt->fetch();
              $countR = $stmt->rowCount();
        }

        if($countR > 0 || $do =="Add"){
            ?>           
            
            <h1 class="text-center"><?= $do=='Add'?"Add New Items":"Edit the Items"; ?></h1>
            <div class="container">
                <form class="form-horizontal" action="<?=$do=="Edit"?"?do=Update":"?do=insert";?>" method="POST" enctype="multipart/form-data"> 
                    <div class="row">
                        <div class="col-md-6">
                            <?php if($do =="Edit"){?>
            
                                <input type="hidden" name="itemid" id="" value="<?=$itemid ?>">
                           <?php }?>
                            <!-- start edit user name -->
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10 col-md-10">
                                    <input type="text"
                                    placeholder="name of items"
                                     class="form-control" name="name" value="<?php if($do == 'Edit'){echo $row["Name"];} ?>" required="required"/>
                                </div>
                            </div>
                            <!-- end edit user name -->
                            <!-- start edit user Password -->
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label" >Description</label>
                                <div class="col-sm-10 col-md-10">
                                    <div class="form-controll">
                                        <textarea  class="Description form-control"
                                        placeholder="description of item"
                                         name="description" ><?php if($do == 'Edit'){echo $row["Description"];} ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label" >image profile</label>
                                <div class="col-sm-10 col-md-10">
                                    <div class="form-controll">
                                        <input type="file" class="avatar form-control" 
                                         name="avatar" />
                                    </div>
                                </div>
                            </div>
                            <!-- end edit user Password -->
                            <!-- start edit user Email -->
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Price</label>
                                <div class="col-sm-10 col-md-10">
                                    <input type="number" class="form-control" placeholder="ordering" name="price" value="<?php if($do == 'Edit'){echo $row["Price"];} ?>">
                                </div>
                            </div>
                            <!-- end edit user Email -->
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Country Made</label>
                                <div class="col-sm-10 col-md-10"> 
                                    <input type="text" name="country" id="" class="form-control" value="<?php if($do == 'Edit'){echo $row["Country_Made"];} ?>">
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-6">
                            <!-- start edit user Email -->
                            <!-- end edit user Email -->
                            <!-- start edit user Email -->
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-10 col-md-10">
                                    <select name="status"   id="">
                                        <option value="0" <?php if($do == 'Edit'){ if($row["Status"] == "0")echo "selected";}  ?>>...</option>
                                        <option value="1" <?php if($do == 'Edit'){ if($row["Status"] == "1")echo "selected";}  ?> >New</option>
                                        <option value="2" <?php if($do == 'Edit'){ if($row["Status"] == "2")echo "selected";}  ?>>old</option>
                                        <option value="3" <?php if($do == 'Edit'){ if($row["Status"] == "3")echo "selected";}  ?>>very old</option>
                                    </select>
                                </div>
                            </div>
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
                                <label for="" class="col-sm-2 control-label">Categories</label>
                                <div class="col-sm-10 col-md-10">
                                    <select name="categories"   id="">
                                        <option value="0">...</option>
                                        <?php 
                                            $stmt2 = $con->prepare("SELECT * FROM categories");
                                            $stmt2->execute();
                                            $cats = $stmt2->fetchAll();
                                        foreach($cats as $cat1){
                                            ?>
                                            <option value="<?=$cat1['ID'] ?>" <?php if($do == 'Edit'){ if($row["Member_ID"] == $cat1['ID'])echo "selected";}  ?>><?= $cat1["Name"] ?></option>

                                            <?php
                                        }

                                    ?>
                                    </select>
                                </div>
                            </div>
                            <!-- end edit user Email --> 
                            <div class="form-group"> 
                                <div class="col-sm-offset-2 col-sm-10 mt-2" >
                                    <input type="submit" class="btn btn-primary" name="save" value="<?=$do=="Edit"?"save":"Add item"; ?>" />
                                </div>
                            </div>
    
                        </div>
                    </div>
                    <!-- end edit user submit -->
                </form>
                <!-- start mange comment -->
                <?php
                if($do=="Edit"){
                        $query = "";
                if(isset($_GET["page"]) && $_GET["page"] == 'Approve'){
                    $query = "AND Status =0";
                }
                $stmt = $con->prepare("SELECT comments.*,users.Username as Member ,items.Name as Item_Name FROM comments
                                        INNER JOIN users ON users.UserID=comments.Member_ID
                                        INNER JOIN items ON items.Item_ID=comments.Item_ID WHERE items.Item_ID=?
                ");
                $stmt->execute(array($itemid));
                $rows = $stmt->fetchAll();
                    if(!empty($rows)){

                    
                ?>
                 
                    <h1 class='text-center'>the Mange comments table</h1><br> 
                    <!-- <a href='?do=Add' class="btn btn-success">+ Add members</a> -->
                    <div class="mytable">
                        <table class="table">
                                    <thead>
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">comment</th> 
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
                                            <td><?= $row["Comment"] ?></td> 
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
                  
                        <!-- start mange comment -->

<?php }} ?>
 
            </div>


<?php

        }else{
            echo "<h1 class='text-center'>soory no such ID</h1>";
        }
        
        //end edit page 
 
    }elseif($do == "Update" || $do=='insert' ){//start update
        if($do == 'Update'){
            echo "<h1 class='text-center'>Update categories</h1>";
        echo "<div class='container'>";
        }else{
            echo "<h1 class='text-center'>Add categories</h1>";
            echo "<div class='container'>";
        }

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $fromErorr = array();
           
           $name       = $_POST["name"];
           $desciption = $_POST["description"];
           $country    = $_POST["country"];
           $price      = $_POST["price"];
           $status     = $_POST["status"]; 
           $member     = $_POST["member"];
           $member     =intval($member);
           $cat        = $_POST["categories"]; 
           $cat        =intval($cat); 

        //update the database with the info
        if(empty($name)){
            $fromErorr[]= '<div class="alert alert-danger">the name can not be empty </div>';
        }
        if(empty($country)){
            $fromErorr[]= '<div class="alert alert-danger">the country can not be empty </div>';
        }
        if(empty($price)){
            $fromErorr[]= '<div class="alert alert-danger">the price can not be empty </div>';
        }
        if($status=="0"){
            $fromErorr[]= '<div class="alert alert-danger">the status can not be empty </div>';
        }
        if($member==0){
            $fromErorr[]= '<div class="alert alert-danger">the member can not be empty </div>';
        }
        if($cat==0){
            $fromErorr[]= '<div class="alert alert-danger">the cat can not be empty </div>';
        }
        if(!empty($fromErorr)){
            foreach($fromErorr as $erorr){
                echo $erorr;
            }
            RedirectHome( "",'back');
        }
        if($do =="Update"){
            $id =$_POST["itemid"];
            if(empty($fromErorr)){
                $stmt=$con->prepare("UPDATE items SET Name=?,Description=?,Price=?,Country_Made=? , Status=?,Cat_ID=?,Member_ID=? WHERE Item_ID=?");
                $stmt->execute(array($name,$desciption,$price,$country,$status,$cat,$member,$id));
                $countR=$stmt->rowCount();
                if($countR>0){
                    // $_SESSION["Username"] = $user;
                    RedirectHome( "<div class='alert alert-success'> success . $countR .Recoreder </div>",'back');
                    
                }else{
                    
                    RedirectHome( "<div class='alert alert-success'>". $stmt->rowCount() .' Recoreder</div>','back');
                }
            }
        }elseif($do == "insert"){
            echo "<br>";
            echo "<pre>";
            print_r($_FILES["avatar"]);
            echo "</pre>";
            $array_image =$_FILES["avatar"];
            $uploads_dir = 'uploads'.DIRECTORY_SEPARATOR;
                $names = $_FILES['avatar']['name'];
                if (is_uploaded_file($_FILES['avatar']['tmp_name']))
                {       
                    //in case you want to move  the file in uploads directory
                    move_uploaded_file($_FILES['avatar']['tmp_name'], $uploads_dir.$names);
                    echo 'moved file to destination directory';
                    exit;
                }
            // if(empty($fromErorr)){
            //         $stmt=$con->prepare("INSERT INTO items SET Name=?,Description=?,Price=?,Country_Made=?,Add_Date=now() , Status=?,Cat_ID=?,Member_ID=? ");
            //         try{
            //             $stmt->execute(array($name,$desciption,$price,$country,$status,$cat,$member));
            //         }catch(PDOException $e){
            //             echo $e->getMessage(); 
            //             RedirectHome("<div class='alert alert-danger'>' pleas inter the name  else this name is exists</div>'",'back');
            //         }
                    
                    
            //         if($stmt->rowCount()>0){
            //             RedirectHome("<div class='alert alert-success'>' success add</div>'",'back');RedirectHome("<div class='alert alert-success'>' success add</div>'",'back');
                    
            //         }
                 
            // }

        }

        echo "</div>";  

        }else{ 
            RedirectHome("sorry you canot dirctoly access to this page");
        }

        //end update and insert
    }elseif($do == "Delete"){

        echo "<h1 class='text-center'>Delete you categories</h1>";
        $itemid = isset($_GET["Itemid"]) && is_numeric($_GET["Itemid"])? intval($_GET["Itemid"]):  0;
        $checkd = checkitem('Item_ID','items',$itemid);
        $count=0;
        if($checkd ==1){
            $stmt =$con->prepare("DELETE FROM items WHERE Item_ID =:ID");
            $stmt->bindParam(":ID",$itemid);
            $stmt->execute();
            $count =$stmt->rowCount();
        }else{
            echo "<div class='container'>"; 
            RedirectHome( '<div class="alert alert-danger">no such ID </div>','back');
            echo "</div>";
        }

        if($count >0){
            echo "<div class='container'>"; 
            RedirectHome( '<div class="alert alert-success">you are delete this items </div>','back');
            echo "</div>";
        }else{
            echo "<div class='container'>";
            RedirectHome( '<div class="alert alert-danger">you are not delete this items  maybe this id not  exists</div>','back');
            echo "</div>";
        }

    }elseif($do == 'Approve'){
        echo "<h1 class='text-center'>Approve your item</h1>";
        $itemid = isset($_GET["Itemid"]) && is_numeric($_GET["Itemid"])? intval($_GET["Itemid"]):  0;
        $checkd = checkitem('Item_ID','items',$itemid);
        $count=0;
        if($checkd ==1){
            $stmt =$con->prepare("UPDATE items SET Approve=1 WHERE Item_ID =?"); 
            $stmt->execute(array($itemid));
            $count =$stmt->rowCount();
        }

        if($count >0){
            echo "<div class='container'>"; 
            RedirectHome( '<div class="alert alert-success">you are Approve this item </div>','back');
            echo "</div>";
        }else{
            echo "<div class='container'>";
            RedirectHome( '<div class="alert alert-danger">you are not Approve this item  maybe this id not  exists</div>','back');
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


ob_end_flush();
?>






















