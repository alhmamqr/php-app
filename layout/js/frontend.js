 
$(function(){
    'use strict';
    $("select").selectBoxIt({
        autoWidth:false

    });
    //singup//singin
    $(".container h1 span").click(function(){
        $(this).addClass('selected').siblings("span").removeClass("selected");
        $(".page-login form").hide();
        $("."+ $(this).attr("data-class")).fadeIn(100);
        // $(".from-login").fadeIn();
    });
 
    //hide place holder onclick
    $('[placeholder]').focus(function(){
        $(this).attr('data-text',$(this).attr('placeholder'));
        $(this).attr('placeholder',"");
    }).blur(function(){
        $(this).attr("placeholder",$(this).attr("data-text"));
    });
    $("input").each(function(){
        // console.log("*");
        
        if($(this).attr('required') === 'required'){
            $(this).after(("<span class='astrecs'>*</span>"));
        }
    }); 
    $(".confirm").click(function(){
        return confirm("Are you shor");
    }); 
    // add item
    $('.cartview-name');
    $('.input-item').on('input',function(){
        $('.'+$(this).attr('data-class')).text($(this).val());
    });

})
