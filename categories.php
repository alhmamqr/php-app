<?php
include "init.php";
// echo $_GET["catid"];
// echo str_Replace("-"," ",$_GET["pagename"]);

echo "<br>";  
?>
<div class="container">
    <h1 class="text-center">
        <?= str_Replace("-"," ",$_GET["pagename"]) ?>

    </h1>
    <div class="row">
        <?php
        foreach(getItems($_GET["catid"],'Cat_ID') as $item){
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

include $tpl."footer.php";









