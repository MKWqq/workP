/*控制页面显示主体内容是哪一部分
* htmlIndex为显示内容在所有板块的下标*/
//$(window).load(productload);
$(function(){
    $(".translateButton").click(function(){//http://localhost:63342/E/project4/website/project1_English/client/
        window.location.href="http://www.moceanview.com/cn/product.html"
    });
});
$(window).resize(function(){
    plAddThing();//屏幕大小变化触发事件
    plWCTwoNav();//横屏竖屏转换的时候内容“记忆”
});//
//alert($(window).width());
var plPageTotal= 3,plPageNum= 1,plPcFlog=true,plMobileFlog=true;
var EventUtil={
    addHandler:function(element,type,handler){
        if(element.addEventListener){
            element.addEventListener(type,handler,false);
        }else if(element.attachEvent){
            element.attachEvent("on"+type,handler);
        }else{
            element["on"+type]=null;
        }
    },
    removeHandler:function(element,type,handler){
        if(element.removeEventListener){
            element.removeEventListener(type,handler,false);
        }else if(element.detachEvent){
            element.detachEvent("on"+type,handler);
        }else{
            element["on"+type]=null;
        }
    }
};
function pl_height(obj){
    var thisObjHeight=+($(obj).css("height").replace(/px/,""));
    return thisObjHeight;
}
function pl_width(obj){
    var thisObjHeight=+($(obj).css("width").replace(/px/,""));
    return thisObjHeight;
}
function pl_marginTop(obj){
    var thisObjHeight=+($(obj).css("margin-top").replace(/px/,""));
    return thisObjHeight;
}
function pl_marginBottom(obj){
    var thisObjHeight=+($(obj).css("margin-bottom").replace(/px/,""));
    return thisObjHeight;
}
/*初始化页面css*/
function productload(){
    var winWidth=$(window).width();

    /*设置初始化button区内容*/
    if(winWidth<767){
        plPageTotal=3;
    }else{
        plPageTotal=2;
    }
    /*button区*/
    $(".ps_PageCenter .ps_PageNTotal").val(plPageTotal);
    setTimeout(function(){
        /*主菜单line-height设置*/
        if($("#nav li")[0]!=""&&$("#nav li")[0]!=undefined&&$("#nav li")[0]!=null){
            var NavLiH=+($("#nav li").css("height").replace(/px/,""));
            //$("#nav li").css("line-height",NavLiH*1.57+"px");//一级导航line-height
            $("#nav li").css("line-height","normal");
            var myLineHeight=parseFloat($("#nav li a").css("fontSize"));
            /*三级导航line-height*/
            $(".psc_left .ps_nav li[class*='ps_threeNav']").css("line-height",$(".psc_left .ps_nav li[class*='ps_threeNav']").css("height"));
        }
        $(".psnav_goto").css("left",(+$(".psNav_topCon span").css("width").replace(/px/,"")+15)+"px");
        $(".psnav_goto").css("top",((+$(".psNav_topCon span").css("height").replace(/px/,""))/2-(+$(".psnav_goto").css("height").replace(/px/,""))/2)+"px");
        $(".ps_back").css("top",((+$(".ps_navTop").css("height").replace(/px/,""))/2-(+$(".ps_back").css("height").replace(/px/,""))/2)+"px");
        $(".psNav_topCon span").css("line-height",$(".psNav_topCon").css("height"));
        if(winWidth<=992){

            $(".ps_navTactive").css("color","#fff");
            $(".psc_functionTwo section.psc_functionTwoC").css("height",(pl_width(".psc_functionTwo section.psc_functionTwoC")*1.04)+"px");

            for(var psRowHIndex=0;psRowHIndex<$(".psc_functionFourCRTextRow").length;psRowHIndex++){
                $($(".psc_functionFourCRTextRow")[psRowHIndex]).css("height",$($(".psc_functionFourCRTextRow")[psRowHIndex]).find(".psc_functionFourCRText").css("height"));
            }
            for(var psFivRowHIndex=0;psFivRowHIndex<$(".psc_functionFiveCRTextRow").length;psFivRowHIndex++){
                $($(".psc_functionFiveCRTextRow")[psFivRowHIndex]).css("height",$($(".psc_functionFiveCRTextRow")[psFivRowHIndex]).find(".psc_functionFiveCRText").css("height"));
            }


            /*psc_architectureOne图片替换*/
            $(".psc_architectureOneCT img").attr("src","./img/product/qietu.png");

            /*平板横屏布局*/
            if(winWidth>=767){
/*                /!*overview页面第一页排版*!/
                var plImgTMarTop=(pl_height(".psc-overOnetr")-pl_height(".psc-overOnetl img"))/2;
                $(".psc-overOnetl img").css("margin-top",plImgTMarTop+"px");
                var plImgBMarTop=(pl_height(".psc-overOnetbr")-pl_height(".psc-overOnetbl img"))/2;
                if(plImgBMarTop>=0){
                    $(".psc-overOnetbl img").css("margin-top",plImgBMarTop+"px");
                }else{
                    $(".psc-overOnetbl img").css("margin-top","0px");
                }*/

                $("#nav li").css("line-height","normal");
                /*button区域排版*/
                var plBtnTop=pl_height(".psc_rightTotal div.productShow")+
                    pl_marginBottom(".psc_rightTotal div.productShow")+pl_height(".psc_overOnetb header")+
                    pl_height(".psc-overOnetbl img");
                var plCenterTop=(pl_height(".ps_center")-(plBtnTop+pl_height(".ps_PageCenter")))/2;
                //$('.ps_PageCenter').css("top",(plBtnTop+plCenterTop)+"px");
            }
            else if(winWidth<767){
/*                /!*overview页面第一页排版*!/
                var plImgTMarTop=0;
                $(".psc-overOnetl img").css("margin-top",plImgTMarTop+"px");
                var plImgBMarTop=0;
                $(".psc-overOnetbl img").css("margin-top",plImgBMarTop+"px");*/

                /*移动端button区排版*/
                $(".ps_navH").css("line-height",NavLiH*1.27+"px");//二级导航line-height
                var plBtnTop=pl_height(".psc_overOnet header")+
                    pl_height(".psc-overOnetl")+pl_height(".psc-overOnetr")+
                    pl_marginTop(".psc_overOnet header")+pl_marginBottom(".psc_overOnet header")+
                    pl_marginBottom(".psc-overOnetl");
                var plCenterTop=(pl_height(".ps_center")-(plBtnTop+pl_height(".ps_PageCenter")))/2;
                if($("#nav li")[0]!=""&&$("#nav li")[0]!=undefined&&$("#nav li")[0]!=null){
                    var NavLiH=+($("#nav li").css("height").replace(/px/,""));
                    $("#nav li").css("line-height",NavLiH*1.57+"px")
                }
                //$('.ps_PageCenter').css("top",(plBtnTop+plCenterTop)+"px");
            }
        }
        else{
/*            /!*overview页面第一页排版*!/
            var plImgTMarTop=(pl_height(".psc-overOnetr")-pl_height(".psc-overOnetl img"))/2;
            $(".psc-overOnetl img").css("margin-top",plImgTMarTop+"px");
            var plImgBMarTop=(pl_height(".psc-overOnetbr")-pl_height(".psc-overOnetbl img"))/2;
            if(plImgBMarTop>=0){
                $(".psc-overOnetbl img").css("margin-top",plImgBMarTop+"px");
            }else{
                $(".psc-overOnetbl img").css("margin-top","0px");
            }*/
            //$(".psc-overOnetbl img").css("margin-top",plImgBMarTop+"px");

            $(".psc_functionTwo section.psc_functionTwoC").css("height",(pl_height(".psc_functionTwo")*0.89)+"px");

            for(var psRowHIndex=0;psRowHIndex<$(".psc_functionFourCRTextRow").length;psRowHIndex++){
                $($(".psc_functionFourCRTextRow")[psRowHIndex]).css("height",$($(".psc_functionFourCRTextRow")[psRowHIndex]).find(".psc_functionFourCRText").css("height"));
            }
            for(var psFivRowHIndex=0;psFivRowHIndex<$(".psc_functionFiveCRTextRow").length;psFivRowHIndex++){
                $($(".psc_functionFiveCRTextRow")[psFivRowHIndex]).css("height",$($(".psc_functionFiveCRTextRow")[psFivRowHIndex]).find(".psc_functionFiveCRText").css("height"));
            }
        }
    },350);

}
/*点击当前显示页面内容,pc端*/
function productShow(htmlIndex){
    for(var pdShowIndex=0;pdShowIndex<$(".psc_rightTotal>div").length;pdShowIndex++){
        if(pdShowIndex===htmlIndex){
            /*改变architecture中图片——pc*/
            $($(".psc_rightTotal>div")[pdShowIndex]).find("img[src*='./img/product/qietu.png']").attr("src","./img/product/jiagou2.png");
            $($(".psc_rightTotal>div")[pdShowIndex]).addClass("productShow");
            continue;
        }
        $($(".psc_rightTotal>div")[pdShowIndex]).removeClass("productShow");
    }
}

/*移动端触屏事件*/
$(function(){
    var winWidth=$(window).width();


});

/*x向左滑动事件*/
function psPrev(){
    var winWidth=$(window).width();
    plPageNum--;
    if(plPageNum<1){
        plPageNum=1;
    }
    else{
        /*初始化*/
        /*去除所有含有productShow的class名*/
        $(".psc_rightTotal div").removeClass("productShow");
        /*改变button区显示信息*/
        $(".ps_PageCenter .ps_PageN").val(plPageNum);
        /*显示相应的内容*/
        var psActiveTwoNTxt=$(".psNav_topCon span").html();
        switch (psActiveTwoNTxt){
            case "Overview":
                switch(true){
                    case winWidth<767:
                        switch (plPageNum) {
                            case 1:$(".psc_overOnet").addClass("productShow");break;
                            case 2:$(".psc_overOnetb").addClass("productShow");break;
                            case 3:$(".psc_overviewTwo").addClass("productShow");break;
                        }
                        break;
                    default:
                        switch (plPageNum) {
                            case 1:$(".psc_overviewOne").addClass("productShow");break;
                            case 2:$(".psc_overviewTwo").addClass("productShow");break;
                            //case 3:$(".psc_overviewTwo").addClass("productShow");break;
                        }
                        break;
                }
                break;
            case "Function":
                switch (plPageNum) {
                    case 1:$(".psc_functionOne").addClass("productShow");break;
                    case 2:$(".psc_functionTwo").addClass("productShow");break;
                    case 3:$(".psc_functionThree").addClass("productShow");break;
                    case 4:$(".psc_functionFour").addClass("productShow");break;
                    case 5:$(".psc_functionFive").addClass("productShow");break;
                }
                break;
            case "Architecture":
                switch (plPageNum) {
                    case 1:$(".psc_architectureOne").addClass("productShow");break;
                    case 2:$(".psc_architectureTwo").addClass("productShow");break;
                }
                break;
            case "Performance":
                switch (plPageNum) {
                    case 1:$(".psc_performanceOne").addClass("productShow");break;
                    case 2:$(".psc_performanceTwoCBL").addClass("productShow");break;
                    case 3:$(".psc_performanceTwoCBR").addClass("productShow");break;
                }
                break;
        }
    }
}

/*向右滑动事件*/
function psNext(){
    var winWidth=$(window).width();
    plPageNum++;
    if(plPageNum>$(".ps_PageCenter .ps_PageNTotal").val()){
        plPageNum=$(".ps_PageCenter .ps_PageNTotal").val();
    }
    else{
        /*初始化*/
        /*去除所有含有productShow的class名*/
        $(".psc_rightTotal div").removeClass("productShow");
        /*改变button区显示信息*/
        $(".ps_PageCenter .ps_PageN").val(plPageNum);
        /*显示相应的内容*/
        var psActiveTwoNTxt=$(".psNav_topCon span").html();
        switch (psActiveTwoNTxt){
            case "Overview":
                switch(true){
                    case winWidth<767:
                        switch (plPageNum) {
                            case 1:$(".psc_overOnet").addClass("productShow");break;
                            case 2:$(".psc_overOnetb").addClass("productShow");break;
                            case 3:$(".psc_overviewTwo").addClass("productShow");break;
                        }
                        break;
                    default:
                        switch (plPageNum) {
                            case 1:$(".psc_overviewOne").addClass("productShow");break;
                            case 2:$(".psc_overviewTwo").addClass("productShow");break;
                            //case 3:$(".psc_overviewTwo").addClass("productShow");break;
                        }
                        break;
                }
                break;
            case "Function":
                switch (plPageNum) {
                    case 1:$(".psc_functionOne").addClass("productShow");break;
                    case 2:$(".psc_functionTwo").addClass("productShow");break;
                    case 3:$(".psc_functionThree").addClass("productShow");break;
                    case 4:$(".psc_functionFour").addClass("productShow");break;
                    case 5:$(".psc_functionFive").addClass("productShow");break;
                }
                break;
            case "Architecture":
                switch (plPageNum) {
                    case 1:$(".psc_architectureOne").addClass("productShow");break;
                    case 2:$(".psc_architectureTwo").addClass("productShow");break;
                }
                break;
            case "Performance":
                switch (plPageNum) {
                    case 1:$(".psc_performanceOne").addClass("productShow");break;
                    case 2:$(".psc_performanceTwoCBL").addClass("productShow");break;
                    case 3:$(".psc_performanceTwoCBR").addClass("productShow");break;
                }
                break;
        }
    }
}

/*next或last点击事件，触发控制页面显示主体内容是哪一部分函数，
需传显示内容的下标*/
/*pc端----------------*/
function pdLNClick(){
    for(var pdLNIndex=0;pdLNIndex<$(".psc_rightTotal>div").length;pdLNIndex++){
        if($($(".psc_rightTotal>div")[pdLNIndex]).attr("class")===$(this).parent().parent().attr("class")){
            if($(this).find("span").html()==="NEXT"){
                productShow(pdLNIndex+1);
            }else if($(this).find("span").html()==="LAST"){
                productShow(pdLNIndex-1);
            }
        }
    }
}
/*移动端---------------------*/
/*li点击事件，显示三级导航*/
function pdNavClick(){
    var winWidth=$(window).width();
    if(winWidth>992){
        for(var pdNavIndex=0;pdNavIndex<$(".ps_nav .ps_navH").length;pdNavIndex++){
            if($($(".ps_nav .ps_navH")[pdNavIndex]).html()===$(this).html()){
                /*显示该板块第一块内容，li下面span中内容和每一板块class名联系*/
                var pdShowClass="psc_"+($($(".ps_nav .ps_navH")[pdNavIndex]).find("span").html()).toLowerCase()+"One";
                for(var pdShowIndex=0;pdShowIndex<$(".psc_rightTotal>div").length;pdShowIndex++){
                    if(pdShowClass===$($(".psc_rightTotal>div")[pdShowIndex]).attr("class")){
                        productShow(pdShowIndex);
                    }}
                $($(".ps_nav .ps_navH")[pdNavIndex]).find("span").css("color","#5690cf");
                $($(".ps_nav .ps_navH")[pdNavIndex]).find("img").attr("src","./img/product/highlight.png");
                continue;
            }
            $($(".ps_nav .ps_navH")[pdNavIndex]).find("span").css("color","#7f7f7f");
            $($(".ps_nav .ps_navH")[pdNavIndex]).find("img").attr("src","./img/product/normal.png");
        }
    }
    else if(winWidth<=992){
        for(var threeNavIndex=0;threeNavIndex<$(".ps_navH").length;threeNavIndex++){
            if($(this).html()==$($(".ps_navH")[threeNavIndex]).html()){
                switch (threeNavIndex){
                    case 0:
                        $(".ps_threeNavO").toggleClass("ps_threeNavBefore");
                        $(".ps_threeNavO").toggleClass("ps_threeNavActive");
                        $(".ps_threeNavTwo").addClass("ps_threeNavBefore");
                        $(".ps_threeNavTwo").removeClass("ps_threeNavActive");
                        $(".ps_threeNavTH").addClass("ps_threeNavBefore");
                        $(".ps_threeNavTH").removeClass("ps_threeNavActive");
                        $(".ps_threeNavFO").addClass("ps_threeNavBefore");
                        $(".ps_threeNavFO").removeClass("ps_threeNavActive");
                        break;
                    case 1:
                        $(".ps_threeNavO").addClass("ps_threeNavBefore");
                        $(".ps_threeNavO").removeClass("ps_threeNavActive");
                        $(".ps_threeNavTwo").toggleClass("ps_threeNavBefore");
                        $(".ps_threeNavTwo").toggleClass("ps_threeNavActive");
                        $(".ps_threeNavTH").addClass("ps_threeNavBefore");
                        $(".ps_threeNavTH").removeClass("ps_threeNavActive");
                        $(".ps_threeNavFO").addClass("ps_threeNavBefore");
                        $(".ps_threeNavFO").removeClass("ps_threeNavActive");
                        break;
                    case 2:
                        $(".ps_threeNavO").addClass("ps_threeNavBefore");
                        $(".ps_threeNavO").removeClass("ps_threeNavActive");
                        $(".ps_threeNavTwo").addClass("ps_threeNavBefore");
                        $(".ps_threeNavTwo").removeClass("ps_threeNavActive");
                        $(".ps_threeNavTH").toggleClass("ps_threeNavBefore");
                        $(".ps_threeNavTH").toggleClass("ps_threeNavActive");
                        $(".ps_threeNavFO").addClass("ps_threeNavBefore");
                        $(".ps_threeNavFO").removeClass("ps_threeNavActive");
                        break;
                    default:
                        $(".ps_threeNavO").addClass("ps_threeNavBefore");
                        $(".ps_threeNavO").removeClass("ps_threeNavActive");
                        $(".ps_threeNavTwo").addClass("ps_threeNavBefore");
                        $(".ps_threeNavTwo").removeClass("ps_threeNavActive");
                        $(".ps_threeNavTH").addClass("ps_threeNavBefore");
                        $(".ps_threeNavTH").removeClass("ps_threeNavActive");
                        $(".ps_threeNavFO").toggleClass("ps_threeNavBefore");
                        $(".ps_threeNavFO").toggleClass("ps_threeNavActive");
                        break;
                }
                $($(".ps_navH")[threeNavIndex]).find(".nav_godown").toggleClass("nav_goupActive");
                $($(".ps_navH")[threeNavIndex]).find(".nav_godown").toggleClass("nav_goupBefore");
                $($(".ps_navH")[threeNavIndex]).find(".nav_goup").toggleClass("nav_goupActive");
                $($(".ps_navH")[threeNavIndex]).find(".nav_goup").toggleClass("nav_goupBefore");
                /*$(".nav_godown").toggleClass("nav_goupActive");
                $(".nav_godown").toggleClass("nav_goupBefore");
                $(".nav_goup").toggleClass("nav_goupActive");
                $(".nav_goup").toggleClass("nav_goupBefore");*/
            }
            else{
                $($(".ps_navH")[threeNavIndex]).find(".nav_godown").addClass("nav_goupActive");
                $($(".ps_navH")[threeNavIndex]).find(".nav_godown").removeClass("nav_goupBefore");
                $($(".ps_navH")[threeNavIndex]).find(".nav_goup").removeClass("nav_goupActive");
                $($(".ps_navH")[threeNavIndex]).find(".nav_goup").addClass("nav_goupBefore");
            }
        }
     }
    //$(this).find("span").color("#5690cf");
}

/*三级导航点击事件*/
function plNav_three(){
    /*初始化*/
    /*pdThreeNavFlog——判断三级导航是否含有ps_threeNavBeforeSm（display:none）*/
    var plThreeNavIndex,winWidth=$(window).width(),pdThreeNavFlog=0;
    /*去除所有含有productShow的class名*/
    $(".psc_rightTotal div").removeClass("productShow");
    plNav_show();//点击隐藏二级导航
    /*三级导航点击事件,点击当前三级导航属于哪个二级导航，即二级导航下标
    * plThreeNavIndex,二级导航下标
    * plPageTotal，每部分的总页数
    * plPageNum,当前显示页面所在页数*/
    if($(this).hasClass("ps_threeNavO")){
        plThreeNavIndex=0;
        if(winWidth<767){
            $(".ps_nav li").removeClass("ps_threeNavBeforeSm");
            plPageTotal=3;
        }
        else{
            $($(".ps_threeNavO")[1]).addClass("ps_threeNavBeforeSm");
            plPageTotal=2;
        }
        /*当前显示页数*/
        for(var plPageNIndex=0;plPageNIndex<$(".ps_threeNavO").length;plPageNIndex++){
            if($($(".ps_threeNavO")[plPageNIndex]).hasClass("ps_threeNavBeforeSm")){
                pdThreeNavFlog++;
            }
            if($(this).html()==$($(".ps_threeNavO")[plPageNIndex]).html()){
                plPageNum=plPageNIndex-pdThreeNavFlog+1;
            }
        }
        switch(true){
            case winWidth<767:
                switch (plPageNum) {
                    case 1:$(".psc_overOnet").addClass("productShow");break;
                    case 2:$(".psc_overOnetb").addClass("productShow");break;
                    case 3:$(".psc_overviewTwo").addClass("productShow");break;
                }
                break;
            default:
                switch (plPageNum) {
                    case 1:$(".psc_overviewOne").addClass("productShow");break;
                    case 2:$(".psc_overviewTwo").addClass("productShow");break;
                    //case 3:$(".psc_overviewTwo").addClass("productShow");break;
                }
                break;
        }
    }
    else if($(this).hasClass("ps_threeNavTwo")){
        plThreeNavIndex=1;plPageTotal=5;
        /*当前显示页数*/
        for(var plPageNIndex=0;plPageNIndex<$(".ps_threeNavTwo").length;plPageNIndex++){
            if($(this).html()==$($(".ps_threeNavTwo")[plPageNIndex]).html()){
                plPageNum=plPageNIndex+1;
            }
        }
        switch (plPageNum) {
            case 1:$(".psc_functionOne").addClass("productShow");break;
            case 2:$(".psc_functionTwo").addClass("productShow");break;
            case 3:$(".psc_functionThree").addClass("productShow");break;
            case 4:$(".psc_functionFour").addClass("productShow");break;
            case 5:$(".psc_functionFive").addClass("productShow");break;
        }
    }
    else if($(this).hasClass("ps_threeNavTH")){
        plThreeNavIndex=2;plPageTotal=2;
        /*当前显示页数*/
        for(var plPageNIndex=0;plPageNIndex<$(".ps_threeNavTH").length;plPageNIndex++){
            if($(this).html()==$($(".ps_threeNavTH")[plPageNIndex]).html()){
                plPageNum=plPageNIndex+1;
            }
        }
        switch (plPageNum) {
            case 1:$(".psc_architectureOne").addClass("productShow");break;
            case 2:$(".psc_architectureTwo").addClass("productShow");break;
        }
    }
    else if($(this).hasClass("ps_threeNavFO")){
        plThreeNavIndex=3;plPageTotal=3;
        /*当前显示页数*/
        for(var plPageNIndex=0;plPageNIndex<$(".ps_threeNavFO").length;plPageNIndex++){
            if($(this).html()==$($(".ps_threeNavFO")[plPageNIndex]).html()){
                plPageNum=plPageNIndex+1;
            }
        }
        switch (plPageNum) {
            case 1:$(".psc_performanceOne").addClass("productShow");break;
            case 2:$(".psc_performanceTwoCBL").addClass("productShow");break;
            case 3:$(".psc_performanceTwoCBR").addClass("productShow");break;
        }
    }

    /*页面显示当前活动的二级导航文本信息*/
    var plNavTwoTxt=$($(".ps_navH")[plThreeNavIndex]).find("span").html();
    $(".psNav_topCon span").html(plNavTwoTxt);
    /*改变button区显示信息*/
    $(".ps_PageCenter .ps_PageN").val(plPageNum);
    $(".ps_PageCenter .ps_PageNTotal").val(plPageTotal);

    /*页面显示当前活动的二级导航文本信息css*/
    $(".psnav_goto").css("left",(+$(".psNav_topCon span").css("width").replace(/px/,"")+15)+"px");
    $(".psnav_goto").css("top",((+$(".psNav_topCon span").css("height").replace(/px/,""))/2-(+$(".psnav_goto").css("height").replace(/px/,""))/2)+"px");

}

/*点击显示二级导航部分*/
function plNav_show(){
    $(".psc_left").toggleClass("psc_leftBefore");
    $(".psc_left").toggleClass("psc_leftActive");
    $(".ps_navTop .ps_navTopPush").toggleClass("psc_leftBefore");
    $(".ps_navTop .ps_navTopPush").toggleClass("psc_leftActive");
    /*三级导航css*/
    $(".psc_left .ps_nav li[class*='ps_threeNav']").css("line-height",$(".psc_left .ps_nav li[class*='ps_threeNav']").css("height"));
    $(".ps_back").css("top",((+$(".ps_navTop").css("height").replace(/px/,""))/2-(+$(".ps_back").css("height").replace(/px/,""))/2)+"px");

    /*二级导航排版初始化（不显示三级导航）*/
    $(".ps_threeNavO").addClass("ps_threeNavBefore");
    $(".ps_threeNavO").removeClass("ps_threeNavActive");
    $(".ps_threeNavTwo").addClass("ps_threeNavBefore");
    $(".ps_threeNavTwo").removeClass("ps_threeNavActive");
    $(".ps_threeNavTH").addClass("ps_threeNavBefore");
    $(".ps_threeNavTH").removeClass("ps_threeNavActive");
    $(".ps_threeNavFO").addClass("ps_threeNavBefore");
    $(".ps_threeNavFO").removeClass("ps_threeNavActive");
    $(".ps_navH").find(".nav_goup").addClass("nav_goupBefore");
    $(".ps_navH").find(".nav_goup").removeClass("nav_goupActive");
    $(".ps_navH").find(".nav_godown").removeClass("nav_goupBefore");
    $(".ps_navH").find(".nav_godown").addClass("nav_goupActive");

}

/*窗口改变二级导航样式*/
function plWCTwoNav(){
    var winWidth=$(window).width();
    /*改变button区显示信息*/
    plPageNum=1;
    if(winWidth>992){
        //alert($(".psc_architectureOneCT img").css("height"))
        var thisText=$(".psNav_topCon span").html();
        /*初始化内容显示区域*/
        $(".psc_rightTotal").find(".productShow").removeClass("productShow");

        for(var thisIndex=0;thisIndex<$(".ps_navH").length;thisIndex++){
            /*初始化二级导航活动标志img*/
            $($(".ps_navH")[thisIndex]).find("img[src*='./img/product/highlight.png']").attr("src","./img/product/normal.png");
            if($($(".ps_navH")[thisIndex]).find("span").html()==thisText){
                /*改变活动二级导航img标志*/
                $($(".ps_navH")[thisIndex]).find("img[src*='./img/product/normal.png']").attr("src","./img/product/highlight.png");

                /*改变二级导航css*/
                $(".ps_navH").removeAttr("style");//二级导航line-height
                $($(".ps_navH")[thisIndex]).find("span").css("color","rgb(86,144,207)");
                /*改变内容显示部分*/
                switch (thisIndex){
                    case 0://.productShow
                        $(".psc_overviewOne").addClass("productShow");
                        break;
                    case 1:
                        $(".psc_functionOne").addClass("productShow");
                        break;
                    case 2:
                        $(".psc_architectureOne").addClass("productShow");
                        $(".psc_architectureOneCT img").attr("src","./img/product/jiagou2.png");
                        break;
                    default:
                        $(".psc_performanceOne").addClass("productShow");
                        break;
                }
                continue;
            }
            $($(".ps_navH")[thisIndex]).find("span").css("color","#7f7f7f");
        }
    }
    else if(winWidth<=992){
        /*初始化内容显示区域*/
        $(".psc_rightTotal").find(".productShow").removeClass("productShow");

        /*设置二级导航*/
        for(var thisIndex=0;thisIndex<$(".ps_navH").length;thisIndex++){
            if($($(".ps_navH")[thisIndex]).find("span").css("color")=="rgb(86, 144, 207)"){
                var thisText=$($(".ps_navH")[thisIndex]).find("span").html();
            }
            $($(".ps_navH")[thisIndex]).find("span").css("color","#fff");
        }
        $(".psNav_topCon span").html(thisText);

        /*设置当前显示内容*/
        for(var threeNavIndex=0;threeNavIndex<$(".ps_navH").length;threeNavIndex++){
            if($(".psNav_topCon span").html()==$($(".ps_navH")[threeNavIndex]).find("span").html()){
                switch (threeNavIndex){
                    case 0://.productShow
                        $(".psc_overOnet").addClass("productShow");
                        if(winWidth<767){
                            plPageTotal=3;
                        }else{
                            plPageTotal=2;
                        }
                        /*/!*button区*!/
                        $(".ps_PageCenter .ps_PageNTotal").val(plPageTotal);
                        plPageTotal=3;*/
                        break;
                    case 1:
                        $(".psc_functionOne").addClass("productShow");
                        plPageTotal=5;
                        break;
                    case 2:
                        $(".psc_architectureOne").addClass("productShow");
                        plPageTotal=2;
                        $(".psc_architectureOneCT img").attr("src","./img/product/qietu.png");
                        //alert($(".psc_architectureOneCT img").css("width"))
                        break;
                    default:
                        $(".psc_performanceOne").addClass("productShow");
                        plPageTotal=3;
                        break;
                }

                /*改变button区显示信息*/
                $(".ps_PageCenter .ps_PageN").val(plPageNum);
                $(".ps_PageCenter .ps_PageNTotal").val(plPageTotal);
                //console.log(threeNavIndex)
            }
        }
    }
}


/*添加事件*/
function plAddThing(){
    var winWidth=$(window).width();

    /*plFlag判断是否触屏移动——添加移动端事件*/
    var plFlag=false;
    function pl_touch(event) {
        winWidth=$(window).width();
        /*pc和平板横屏对触屏没效果*/
        if((event.touches.length==1 || event.touches.length==0) && winWidth<=992){
            if(event.type=="touchstart"){
                var touch=event.targetTouches[0];
                plStartX=touch.pageX;
                plStartY=touch.pageY;
            }
            else if(event.type=="touchmove"){
                plFlag=true;
                var touch=event.targetTouches[0];
                plEndX=touch.pageX;
                plEndY=touch.pageY;
            }
            else if(event.type=="touchend"){
                //var plFirstClass=$("#first").hasClass("active");
                /*plFlag && plFirstClass && !plFooterClass*/
                if(plFlag){
                    var plMobileLenX=plEndX-plStartX;
                    var plMobileLenY=plEndY-plStartY;
                    if(plMobileLenX>=15){
                        /*向左滑动*/
                        //$(".programnav_text li").html($(".programnav_text li").html()+(plEndX-plStartX))
                        psPrev();

                    }
                    else if(plMobileLenX<=-15 ){
                        //alert(1)
                        /*向右滑动*/
                        //$(".programnav_text li").html($(".programnav_text li").html()+(plEndX-plStartX))
                        psNext();

                    }
                }
                plFlag=false;
            }
        }
    }

    /*添加事件*/
    productload();
/*    console.log("plPcFlog:"+plPcFlog)
    console.log("plMobileFlog:"+plMobileFlog)*/
    /*换内容显示*/
    if(plPcFlog && plMobileFlog){
        $(".ps_nav .ps_navH").click(pdNavClick);//点击二级导航显示三级导航
        /*添加触屏事件*/
        /*EventUtil.addHandler(document,"touchstart",pl_touch);
        EventUtil.addHandler(document,"touchmove",pl_touch);
        EventUtil.addHandler(document,"touchend",pl_touch);*/
    }
    /*为移动端添加触屏事件*/
    if(winWidth<=992 && plMobileFlog){
        EventUtil.addHandler(document,"touchstart",pl_touch);
        EventUtil.addHandler(document,"touchmove",pl_touch);
        EventUtil.addHandler(document,"touchend",pl_touch);
    }

    if(winWidth<=992 && plMobileFlog){

        /*添加事件*/
        //$(".ps_nav .ps_navH").click(pdNavClick);//点击二级导航显示三级导航
        $(".psNav_topCon").click(plNav_show);//二级导航显示
        $(".ps_navTop .ps_navTopPush").click(plNav_show);//二级导航返回按钮
        /*三级导航添加单击事件*/
        $(".ps_threeNavO").click(plNav_three);
        $(".ps_threeNavTwo").click(plNav_three);
        $(".ps_threeNavTH").click(plNav_three);
        $(".ps_threeNavFO").click(plNav_three);

        plMobileFlog=false;
    }
    else if(winWidth>992 && plPcFlog){
        $(".psc_rightTotal>div>footer>div").click(pdLNClick);
        plPcFlog=false;
       /* EventUtil.addHandler(document,"touchstart",pl_touch);
        EventUtil.addHandler(document,"touchmove",pl_touch);
        EventUtil.addHandler(document,"touchend",pl_touch);*/
        /*EventUtil.removeHandler(document,"touchstart",pl_touch);
        EventUtil.removeHandler(document,"touchmove",pl_touch);
        EventUtil.removeHandler(document,"touchend",pl_touch);*/
    }
}

$(function(){
    plAddThing();
});





