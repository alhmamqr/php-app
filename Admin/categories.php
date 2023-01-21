<?php


ob_start();


session_start();
$pageTitle ="categories";

if(isset($_SESSION["Username"])){
    include "init.php";
    $do= isset($_GET["do"]) ? $_GET["do"]:"Manger";
    if($do == "Manger"){
        $query = "";
        if(isset($_GET["page"]) && $_GET["page"] == 'pending'){
            $query = "AND RegStatues =0";
        }
        $sort="desc";
        $sort_array=array("ASC","DESC");
        if(isset($_GET["sort"]) && in_array($_GET["sort"],$sort_array)){
            $sort =$_GET["sort"];
        }
        $stmt = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
        $stmt->execute();
        $rows = $stmt->fetchAll();

         ?>
        <div class="container categories " style="height: 1000px;">
            <h1 class='text-center'>Welcom ot Mange page</h1><br> 
            <a href='?do=Add' class="btn btn-success">+ Add categories</a>

            <div class="panel panel-default">

                <div class="panel-heading"> <i class="fa fa-edit"></i> categories Manger

                    <div class="ordering pull-right">
                    <i class="fa fa-sort"></i> Order: <a href="?sort=ASC" class="<?php
                    if(isset($_GET["sort"])){
                        if($_GET["sort"]=="ASC"){
                            echo 'active';
                        }else{echo'';}
                    }
                      
                     ?>">ASC</a>  : 

                    <a href="?sort=DESC" class="<?php
                    if(isset($_GET["sort"])){
                        if($_GET["sort"]=="DESC"){
                            echo 'active';
                        }else{echo'';}
                    } 
                     ?>">DESC</a>
                     <i class="fa fa-eye"></i> View:[
                     <span class="fade-full" data-view="full">Full</span> :
                     <span class="fade-full" data-view="classic">Classic</span>]
                </div>

                </div>
                <div class="panel-body">
                    <?php  
                    ?><ul class="list-unstyled latest-users">

                        <?php
                    foreach($rows as $row){
                        ?>
                        <li>
                            <div class="btn-categories">
                            <a href='?do=Delete&catid=<?= $row["ID"] ?>' class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
                        <a href='?do=Edit&catid=<?= $row["ID"] ?>' class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                            </div>
                            <h3 class="name-categories">
                                <?php echo $row["Name"] ?>
                            </h3>
                            <div class="full-content">
                            <p>  <?php if($row["Description"]==""){echo 'Empty Description';}else{echo $row["Description"];} ?> </p>
                            <?php if($row["Visibility"]==0){
                                echo "<span class='categories-info cathidden'>is hidden</span>";
                            }elseif($row["Visibility"]==1){
                                echo "<span class='categories-info visibil'>is visibil</span>";
                            }
                            if($row["Alow_comments"]==0){
                                echo "<span class='categories-info notcomm'>Comments Disable</span>";
                            }else{
                                echo "<span class='categories-info comments'>Alow Comments</span>";
                            }
                            if($row["Ads_alow"]==0){
                                echo "<span class='categories-info Adsnot'>Ads Disable</span>";
                            }else{
                                echo "<span class='categories-info Adsalow'>Alow Ads</span>";
                            }
                            ?>
                    </div>
 
                        </li>
                        
                        
                        <?php
                    }

                        ?>
                        </ul>


<div class="">
    <div class="btn btn-info showtable show" data-view="show">show Table ></div>
</div>

            <div class="mytable table-categories" style="display: none;">
                <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Ordering</th>
                                <th scope="col">visibility</th>
                                <th scope="col">alow_comments</th>
                                <th scope="col">ADS_alow</th>
                                <th scope="col">Controller</th>
                                </tr>
                            </thead>
                            <tbody>
                    <?php      
                        foreach($rows as $row){
                            ?>

                                <tr>
                                    <th scope="row"><?= $row["ID"] ?></th>
                                    <td><?= $row["Name"] ?></td>
                                    <td><?= substr($row["Description"],0,10)."..."; ?></td>
                                    <td><?= $row["Ordering"] ?></td>
                                    <td><?= $row["Visibility"]==0?"NO":"YES" ?></td>
                                    <td><?= $row["Alow_comments"]==0?"NO":"YES" ?></td>
                                    <td><?= $row["Ads_alow"]==0?"NO":"YES" ?></td>
                                    <td><a href='?do=Delete&catid=<?= $row["ID"] ?>' class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
                                    <a href='?do=Edit&catid=<?= $row["ID"] ?>' class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
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
            $catid = isset($_GET["catid"]) && is_numeric($_GET["catid"])? intval($_GET["catid"]):  0;
            $stmt = $con->prepare("SELECT * FROM categories WHERE ID =?" );
              $stmt->execute(array($catid));
              $row= $stmt->fetch();
              $countR = $stmt->rowCount();
        }

        if($countR > 0 || $do =="Add"){
            ?>           
            
            <h1 class="text-center"><?= $do=='Add'?"Add New categories":"Edit the categories"; ?></h1>
            <div class="container">
                <form class="form-horizontal" action="<?=$do=="Edit"?"?do=Update":"?do=insert";?>" method="POST">
                    <?php if($do =="Edit"){?>

                        <input type="hidden" name="catid" id="" value="<?=$catid ?>">
                   <?php }?>
                    <!-- start edit user name -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" class="form-control" name="name" value="<?php if($do == 'Edit'){echo $row["Name"];} ?>" required="required"/>
                        </div>
                    </div>
                    <!-- end edit user name -->
                    <!-- start edit user Password -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label" >Description</label>
                        <div class="col-sm-10 col-md-4">
                            <div class="form-controll">
                                <textarea  class="Description form-control" name="description" ><?php if($do == 'Edit'){echo $row["Description"];} ?></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end edit user Password -->
                    <!-- start edit user Email -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Ordering</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="number" class="form-control" placeholder="ordering" name="O_check" value="<?php if($do == 'Edit'){echo $row["Ordering"];} ?>">
                        </div>
                    </div>
                    <!-- end edit user Email -->
                    <!-- start edit user Email -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Alow  comments</label>
                        <div class="col-sm-10 col-md-4">
                            <div class="chekbox">
                                <input type="radio" name="C_check"checked value="1" id="C_yes">
                                <label for="C_yes">yes</label>
                            </div>
                            <div class="chekbox">
                                <input type="radio" name="C_check" <?php
                                if( $do == 'Edit'){

                                    if($row["Alow_comments"] ==0){echo "checked";};
                                }
                                 ?> value="0" id="C_no">
                                <label for="C_no">no</label>
                            </div>
                        </div>
                    </div>
                    <!-- end edit user Email -->
                    <!-- start edit user Email -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Visblity</label>
                        <div class="col-sm-10 col-md-4">
                            <div class="chekbox">
                                <input type="radio" name="V_check"checked value="1" id="v_yes">
                                <label for="V_yes">yes</label>
                            </div>
                            <div class="chekbox">
                                <input type="radio" name="V_check" <?php
                                if( $do == 'Edit'){

                                    if($row["Visibility"] ==0){echo "checked";} 
                                }
                                 ?> value="0" id="V_no">
                                <label for="V_no">no</label>
                            </div>
                        </div>
                    </div>
                    <!-- end edit user Email -->
                    <!-- start edit user Email -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Ads_alow</label>
                        <div class="col-sm-10 col-md-4">
                            <div class="chekbox">
                                <input type="radio" name="AD_check" checked value="1" id="AD_yes">
                                <label for="AD_yes">yes</label>
                            </div>
                            <div class="chekbox">
                                <input type="radio" name="AD_check" <?php
                                if( $do == 'Edit'){
                                    if($row["Ads_alow"] ==0){
                                        echo "checked";
                                    } 

                                }
                                
                                ?> value="0" id="AD_no">
                                <label for="AD_no">no</label>
                            </div>
                        </div>
                    </div>
                    <!-- end edit user Email -->
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
           
           $name = $_POST["name"];
           $desciption = $_POST["description"];
           $ordering = $_POST["O_check"];
           $visibility = $_POST["V_check"];
           $alow_comments = $_POST["C_check"];
           $ads_allow = $_POST["AD_check"];  
        //update the database with the info
        if(empty($name)){
            $fromErorr[]= '<div class="alert alert-danger">the username can not be empty </div>';
        }
        if(!empty($fromErorr)){
            foreach($fromErorr as $erorr){
                echo $erorr;
            }
            RedirectHome( "",'back');
        }
        if($do =="Update"){
            $id =$_POST["catid"];
            if(empty($fromErorr)){
                $stmt=$con->prepare("UPDATE categories SET Name=?,Description=?,Ordering=?,Visibility=? , Alow_comments=?,Ads_alow=? WHERE ID=?");
                $stmt->execute(array($name,$desciption,$ordering,$visibility,$alow_comments,$ads_allow,$id));
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
                $check =checkitem("Name","categories",$name);
                if($check == 1){
                    
                    RedirectHome( "<div class='alert alert-danger'>sorry that insert name is exists</div>'",'back');RedirectHome( "<div class='alert alert-danger'>sorry that insert name is exists</div>'",'back');
                }else{
                    $stmt=$con->prepare("INSERT INTO categories SET Name=?,Description=?,Ordering=?,Visibility=? , Alow_comments=?,Ads_alow=? ");
                    try{
                        $stmt->execute(array($name,$desciption,$ordering,$visibility,$alow_comments,$ads_allow)); 
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

        echo "<h1 class='text-center'>Delete you categories</h1>";
        $catid = isset($_GET["catid"]) && is_numeric($_GET["catid"])? intval($_GET["catid"]):  0;
        $checkd = checkitem('ID','categories',$catid);
        $count=0;
        if($checkd ==1){
            $stmt =$con->prepare("DELETE FROM categories WHERE ID =:ID");
            $stmt->bindParam(":ID",$catid);
            $stmt->execute();
            $count =$stmt->rowCount();
        }else{
            echo "<div class='container'>"; 
            RedirectHome( '<div class="alert alert-danger">no such ID </div>','back');
            echo "</div>";
        }

        if($count >0){
            echo "<div class='container'>"; 
            RedirectHome( '<div class="alert alert-success">you are delete this categories </div>','back');
            echo "</div>";
        }else{
            echo "<div class='container'>";
            RedirectHome( '<div class="alert alert-danger">you are not delete this categories  maybe this id not  exists</div>','back');
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






















