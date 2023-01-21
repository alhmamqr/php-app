console.log("any2"); 
var idPost //define a global variable
function updateVariables(){
    idPost = document.getElementById("status").innerHTML; //update the global variable
}
$(function(){
    'use strict';
    $("select").selectBoxIt({
        autoWidth:false

    });


    // dashboard
        $(".toggle-info").click(function(){
            $(this).toggleClass("selected").parent().next(".panel-body").fadeToggle(100);
            if($(this).hasClass("selected")){
                console.log("has class");
                $(this).html("<i class='fa fa-minus fa-lg'></i>");
            }else{
                $(this).html('<i class="fa fa-plus fa-lg"></i>');
            }
        })
    //end dashboard
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
    let passeye = $(".password");
    $(".show-password").hover(function(){
        console.log("shwo pass");
    passeye.attr("type","text");
    },function(){
        passeye.attr("type","password");
    });
    $(".confirm").click(function(){
        return confirm("Are you shor");
    });
    $('.showtable').click(function(){
        $(".table-categories").slideToggle();
        if($(this).data("view")=="show"){
            $(this).data("view","hidden");
            $(this).text("Hidden Table <");
        }else{
            $(this).data("view","show");
            $(this).text("Show Table >");
        }
    });
    $('.name-categories').click(function(){
        $(this).next('.full-content').slideToggle(200);
    });
    $(".fade-full").click(function(){
        $(this).addClass("active").siblings("span").removeClass("active");

        console.log("classadd")
        if($(this).data("view")=== "full"){
            $('.full-content').fadeOut(200);
        }else{
            $('.full-content').fadeIn(200);
        }
    });

})
