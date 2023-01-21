<?php
 
function lang($phase){
    static $lang = array(
        //home page
        "welcom" => "welcom",
        "Admin" => "admin",
        // nav
        "home"               =>"Home",
        "categories"         =>"categories",
        "edit_profile"       =>"Edit Profile",
        "setting"            =>"setting",
        "logout"             =>"logout",
        "body_test"          =>"body test",
        "items"              =>"items",
        "members"            =>"members",
        "statistics"         =>"statistics",
        "logs"               =>"logs",
        "comments"               =>"comments",
    );
    return $lang[$phase];

} 
?>