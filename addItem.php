<?php
$pageTitle ="Add Item";
include 'init.php';
if(isset($_SESSION['member'])){ 
    if( $_SESSION['memberActive'] ==0){
        echo 'you are not activate';
    }
    if(isset($_SERVER["REQUEST_METHOD"])){
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            
            
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $member = $_SESSION["memberid"];
                $memberAvtivate = $_SESSION['memberActive'];
                $fromErorr = array();
                if( $_SESSION['memberActive'] ==0){
                    $fromErorr[]= 'you are not activate';
                }
        
        $name       =filter_var(  $_POST["name"],FILTER_SANITIZE_STRING);
        $desciption =filter_var( $_POST["description"],FILTER_SANITIZE_STRING);
        $country    =filter_var( $_POST["country"],FILTER_SANITIZE_STRING);
       $price      = filter_var($_POST["price"],FILTER_SANITIZE_NUMBER_INT);
       $status     = filter_var($_POST["status"],FILTER_SANITIZE_NUMBER_INT);
       $cat        = filter_var($_POST["categories"],FILTER_SANITIZE_NUMBER_INT); 
    

    //update the database with the info
    if($memberAvtivate ==0){
        $fromErorr[]= 'the name can not be empty';
    }
    if(empty($name)){
        $fromErorr[]= 'the name can not be empty';
    }
    if(empty($country)){
        $fromErorr[]= 'the country can not be empty';
    }
    if(empty($price)){
        $fromErorr[]= 'the price can not be empty';
    }
    if($status=="0"){
        $fromErorr[]= 'the status can not be empty';
    } 
    if($cat==0){
        $fromErorr[]= 'the cat can not be empty';
    } 
    
        if(empty($fromErorr)){
                $stmt=$con->prepare("INSERT INTO items SET Name=?,Description=?,Price=?,Country_Made=?,Add_Date=now() , Status=?,Cat_ID=?,Member_ID=? ");
                try{
                    $stmt->execute(array($name,$desciption,$price,$country,$status,$cat,$member));
                }catch(PDOException $e){
                    echo $e->getMessage(); 
                    $fromErorr[]= "some proplem";
                }
                
                
                if($stmt->rowCount()>0){
                  $success= " success add ";
                
                }
             
        }

  
    }else{ 
        RedirectHome("sorry you canot dirctoly access to this page");
    } 

    } 

}








?>


<div class="container additem">
        <h1 class="text-center">Add new Item</h1>
  
<div class="card main">
    <div class="card-header">
    Add Ads
    </div>
        <div class="card-body main"> 
            <div class="row"> 
                    <div class="col-sm-6 col-md-4">
                        <div class="card" style="width: 18rem;">
                        <img src="img.jpg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title cartview-name"> name</h5>
                                <p class="card-text cartview-desc">description</p>
                                <span class="card-price cartview-price"></span><span>$</span>
                            </div>
                        </div>
                    </div>


        <div class="col-sm-6 col-md-8">
        <form class="form-horizontal" method="POST"  action='<?php echo $_SERVER['PHP_SELF'];?>'>
        <div class="row">
            <div class="col-md-6">
                

                    <input type="hidden" name="itemid" id="" <?php if($_SESSION['memberActive'] ==0){ echo"disabled";}?>>
            
                <!-- start edit user name -->
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label">Name</label>
                    <div class="col-sm-10 col-md-10">
                        <input type="text"
                        placeholder="name of items"
                        class="form-control input-item" <?php if($_SESSION['memberActive'] ==0){ echo"disabled";}?> data-class='cartview-name' name="name"  required="required"/>
                    </div>
                </div>
                <!-- end edit user name -->
                <!-- start edit user Password -->
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label" >Description</label>
                    <div class="col-sm-10 col-md-10">
                        <div class="form-controll">
                            <textarea  class="Description form-control input-item " data-class='cartview-desc' <?php if($_SESSION['memberActive'] ==0){ echo"disabled";}?>
                            placeholder="description of item"
                            name="description" > </textarea>
                        </div>
                    </div>
                </div>
                <!-- end edit user Password -->
                <!-- start edit user Email -->
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label">Price</label>
                    <div class="col-sm-10 col-md-10">
                        <input type="number" class="form-control input-item" data-class='cartview-price' placeholder="ordering" name="price" <?php if($_SESSION['memberActive'] ==0){ echo"disabled";}?> >
                    </div>
                </div>
                <!-- end edit user Email -->
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label">Country Made</label>
                    <div class="col-sm-10 col-md-10"> 
                        <input type="text" name="country" id="" class="form-control" <?php if($_SESSION['memberActive'] ==0){ echo"disabled";}?> >
                    </div>
                </div>
                
            </div>
            <div class="col-md-6">
                <!-- start edit user Email -->
                <!-- end edit user Email -->
                <!-- start edit user Email -->
                <div class="form-group">
                    <label for="" class="col-sm-5  control-label">Status</label>
                    <div class="col-sm-10 col-md-10">
                        <select name="status"   id="" <?php if($_SESSION['memberActive'] ==0){ echo"disabled";}?>>
                            <option value="0" >...</option>
                            <option value="1"  >New</option>
                            <option value="2"  >old</option>
                            <option value="3" >very old</option>
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label">Categories</label>
                    <div class="col-sm-10 col-md-10">
                        <select name="categories"   id=""  <?php if($_SESSION['memberActive'] ==0){ echo"disabled";}?>>
                            <option value="0">...</option>
                            <?php 
                                $stmt2 = $con->prepare("SELECT * FROM categories");
                                $stmt2->execute();
                                $cats = $stmt2->fetchAll();
                            foreach($cats as $cat1){
                                ?>
                                <option value="<?=$cat1['ID'] ?>"  ><?= $cat1["Name"] ?></option>

                                <?php
                            }

                        ?>
                        </select>
                    </div>
                </div>
                <!-- end edit user Email --> 
                
            </div>
        </div>
        <div class="form-group"> 

            <div class=" " >
                <?php
                if($_SESSION['memberActive'] ==0){
                    ?>
                    <input type="submit" class="btn btn-primary btn-additem" name="save" value="Add item" disabled >
                    <div class="not-active alert alert-danger">You are not active soory</div>
                    <?php
                }else{
                    ?>

                        <input type="submit" class="btn btn-primary btn-additem" name="save" value="Add item" >

                    <?php
                }
                ?>
            </div>
        </div>
        <!-- end edit user submit -->
                </form>
                </div> 
              </div>
              <!--end row -->

              <!-- start error and success the action -->
              <?php
  if(!empty($fromErorr)){
?>
    <div class="error-box  mb-3 ">
      <?php
        foreach($fromErorr as $error){
          ?>
            <p class="errorcontent">
                <?= $error ?>
              </p>
          <?php
        }
      ?>
    </div>
<?php
  }
    if(isset($success)){
      ?>
      <div class="success-box">
        <?=$success ?>
      </div>

<?php
    }
?>
 <!-- end error and success the action -->
           </div>
           <!-- end card main -->
    </div>
        <!-- end main card -->
</div>
         
 



<?php
}else{
    header("location:index.php");
    exit();
}
include $tpl."footer.php";
?>