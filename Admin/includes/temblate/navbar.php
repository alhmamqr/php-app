<nav class="navbar navbar-dark navbar-expand-lg bg-black">
  <div class="container">
    <a class="navbar-brand" href="index.php"><?php echo lang("home") ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="categories.php"><?php echo lang("categories") ?></a>
          <a class="nav-link " aria-current="page" href="items.php"><?php echo lang("items") ?></a>
          <a class="nav-link " aria-current="page" href="members.php"><?php echo lang("members") ?></a>
          <a class="nav-link " aria-current="page" href="comments.php"><?php echo lang("comments") ?></a> 
        </li> 
        <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $_SESSION["Username"] ?>
          </a>
          <ul class="dropdown-menu navbar-right">
            <li><a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION["userid"];?>"><?php echo lang("edit_profile") ?></a></li>
            <li><a class="dropdown-item" href="#"><?php echo lang("setting") ?></a></li>
            <li><a class="dropdown-item" href="../index.php">View Site</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php"><?php echo lang("logout") ?></a></li>
          </ul>
        </li> 
      </ul> 
    </div>
  </div>
</nav>