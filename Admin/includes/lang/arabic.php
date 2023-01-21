<?php
 
function lang($phase){
    static $lang = array(
        //home page
        "welcom" => "welcom",
        "Admin" => "admin",
        // nav
        "home"=>"الرئيسية",
        "categories"=>"الاقسام",
        "edit_profile"=>"تعديل الصفحة",
        "setting"=>"الاعدادات",
        "logout"=>"خروج",
        "body_test"=>"تجربة",
        ""=>"",
    );
    return $lang[$phase];

} 
?>