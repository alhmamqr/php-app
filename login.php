<?php 
$pageTitle ="login";  
include "init.php";
if(isset($_SESSION["member"])){
    header("location:index.php");
    exit();
        
}else{

}

if($_SERVER["REQUEST_METHOD"]=="POST"){
  if(isset($_POST['login'])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $hashpass = sha1($password);
    $fromErorr = array();
    // if(strlen($username)<4){
    //   $fromErorr[]='write more than 4';
    // }
    if(empty($fromErorr)){
    // echo $username ." " . $password; 

    // check if this user in database
    // prepare  =  function for check in data base before the function chek
    $stmt = $con->prepare("SELECT
                            UserID,Username , Password ,RegStatues
                            FROM
                             users 
                            WHERE Username = ? 
                            AND Password = ? ");
    $stmt->execute(array($username,$hashpass));
    $row= $stmt->fetch();
    $countR = $stmt->rowCount();
    // echo $countR;
    if($countR >0){
        print_r($row);
        $_SESSION["member"] =$username ;
        $_SESSION["memberid"] = $row["UserID"];
        $_SESSION["memberActive"] = $row["RegStatues"];
        header("location:index.php");
        exit();
    }}

  }else{
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $email = $_POST["email"];
    $fromErorr = array(); 
    // $username =filter_input(INPUT_POST,$username,FILTER_SANITIZE_STRING);
    $username =filter_var($username,FILTER_SANITIZE_STRING);
    if(strlen($username) < 4){
      $fromErorr[]='You have name more then 4 character';
    } 
    if(!empty($password) && !empty($password2)){
      if($password === $password2){
        $password = sha1($password);
      }else{
        $fromErorr[]="Your password not confirem";
      }
    }else{
      $fromErorr[]="You shoud be write password and password confirm";
    }
    $email= filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
    if(filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL) !=true){
      $fromErorr[]='Yot shoud be write email validate';
    }
    if(empty($email)){
      $fromErorr[]='Yot shoud be write email  and validate';
    }
 
    // echo "<br>";
    // echo  'usernem: '.$email . "<br>" ;
    // echo "<br>";
    //strt chek on database


      if(empty($fromErorr)){
        $check =checkitem("Username","users",$username);
        if($check == 1){
            $fromErorr[]='sorry that insert name is exists';
        }else{
            $stmt=$con->prepare("INSERT INTO users SET Username=?,Email=?,Password=?,RegStatues=?,RegDate=now() ");
            try{
                $stmt->execute(array($username,$email,$password,0));
            }catch(PDOException $e){ 
              echo $e->getMessage(); 
                 $fromErorr[]='Soory we have some problem';
            }
            
            
            if($stmt->rowCount()>0){
              $success ="<div class='alert alert-success'>' success add</div>";
            
            }
        }
    }


      //end chek on database


  }// end singup


} //get date for database






?>

<div class="container page-login">
    <h1 class="text-center"> <span class="selected" data-class="from-login">Singin</span>  | <span data-class="from-singup">Singup</span></h1>
    <form class="from from-login" method="POST"  action='<?php echo $_SERVER['PHP_SELF'];?>'>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address / Username</label>
        <input  type="text" class="form-control" id="exampleInputEmail1"   autocomplete="off"  name="username" required>
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary" name="login">Login</button>
    </form>


    <!-- sinup form -->
    <form class="form from-singup " method="POST" action='<?php echo $_SERVER['PHP_SELF'];?>' >
      <div class="mb-3">
        <label for="exampleInputuser1" class="form-label">Username</label>
        <input pattern=".{4,}" title="write useranme more thab 4 char" type="text" class="form-control" id="exampleInputuser1"  name="username" autocomplete="off" required> 
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off" name="email" required>
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" minlength="4" class="form-control"  name="password" required>
      </div> 
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
        <input type="password" class="form-control"  name="password2">
      </div>  
      <button type="submit" class="btn btn-primary" name="singup">Singup</button>
    </form>.
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
</div>




<?php 

include $tpl.'footer.php';
?>
