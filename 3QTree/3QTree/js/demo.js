/**
 * Created by wqq on 2017/4/26.
 */
$(function(){
    $(".Header_nav a").click(function(event){
        var target_elem=$(event.target||event.srcElement);
        changeCss(target_elem);
        for(var i=0;i<$(".Header_nav a").length;i++){
            if(target_elem[0]==$(".Header_nav a")[i]){
                switch(i){
                    case 0:
                        window.scrollTo(0,620);
                        break;
                    case 1:
                        window.scrollTo(0,893);
                        break;
                    case 2:
                        window.scrollTo(0,1449);
                        break;
                }
            }
        }
    });
    $(window).scroll(function(){
        checkActiveNav();
    });
    function changeCss(element){
        if(element==""||element==undefined||element==null){
            $(".Header_nav a").css({color:'',borderBottom:'none'})
        }else{
            for(var i=0;i<$(".Header_nav a").length;i++){
                if(element[0]==$(".Header_nav a")[i]){
                    $($(".Header_nav a")[i]).css({color:'#30ac9d',borderBottom:'2px solid #30ac9d'});
                }else{
                    $($(".Header_nav a")[i]).css({color:'',borderBottom:'none'});
                }
            }
        }
    }
    function checkActiveNav(){
        var windowScroll=$(window).scrollTop();
        if(windowScroll>=620&&windowScroll<893){
            changeCss($($(".Header_nav a")[0]))
        }else if(windowScroll>=893&&windowScroll<1080){
            changeCss($($(".Header_nav a")[1]))
        }else if(windowScroll>=1080){
            changeCss($($(".Header_nav a")[2]))
        }else{
            changeCss()
        }
    }
});


