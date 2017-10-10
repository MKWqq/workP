/**
 * Created by Administrator on 2017/7/6.
 */
// 导航
function toTarget() {
    var index=$(this).index();
    var  scrollTop;
    if(index===0){
        scrollTop=679;
    }else if(index===1){
        scrollTop=2000;
    }else if(index===2){
        scrollTop=5360;
    }
    $("body,html").animate({scrollTop:scrollTop},500);
    $(this).addClass("in-header-span-active");
    $(this).siblings().removeClass("in-header-span-active");
}
$('.in-header-span').on('click',toTarget);
// 头部切换滚动条事件
$(function() {
    $(window).scroll(function () {
        if($(window).scrollTop()>=200&&$(window).scrollTop()<=1300){
            $(".in-section-1-content-1").css({
                "left":"136px",
                "opacity":1,
                "-webkit-transition": "all .6s linear",
                "-moz-transition":" all .6s linear"
            });
            $(".in-section-1-content-2").css({
                "right":"216px",
                "opacity":1,
                "-webkit-transition": "all .6s linear",
                "-moz-transition":" all .6s linear"
            });
        }else{
            $(".in-section-1-content-1").css({
                "left":"0px",
                "opacity":0
            });
            $(".in-section-1-content-2").css({
                "right":"0px",
                "opacity":0
            });
        }
        if($(document).scrollTop()>=580&&$(document).scrollTop()<1900){
            $(".in-header-span-1").addClass("in-header-span-active");
        }else {
            $(".in-header-span-1").removeClass("in-header-span-active");
        }
        if($(document).scrollTop()>=1900&&$(document).scrollTop()<4820){
            $(".in-header-span-2").addClass("in-header-span-active");
        }else {
            $(".in-header-span-2").removeClass("in-header-span-active");
        }
        if($(document).scrollTop()>=4820){
            $(".in-header-span-3").addClass("in-header-span-active");
        }else {
            $(".in-header-span-3").removeClass("in-header-span-active");
        }
    })
});
// 3Q泡泡应用宝下载事件
$(".in-loadbtn-yinyong").click(function () {
    window.open("http://sj.qq.com/myapp/detail.htm?apkName=com.excellence.mobile.appmarket");
});
// 3Q泡泡百度手机助手下载事件
$(".in-loadbtn-baidu").click(function () {
    window.open("http://shouji.baidu.com/software/11792560.html");
});
// 3Q泡泡安卓市场下载事件
$(".in-loadbtn-anzhuo").click(function () {
    window.open("http://apk.hiapk.com/appinfo/com.excellence.mobile.appmarket");
});
// 3Q泡泡pad下载事件
$(".in-section-1-2-load-1-load").click(function () {
    window.location.href="http://download.3qworld.cn:8081/upgrade/pad/paopao/android/apks/AppMarketEdu.apk"
});
//文字轮播事件
function scrollAnimate(){
    var top = $('#dl').position().top;
    if(top<=-560){
        top=0;
    }else{
        top--;
    }
    $('#dl').css('top',top)
}
var speed = 30; //滚动速度值，值越大速度越慢
var timer= setInterval(scrollAnimate,speed );
//鼠标移入时清除定时器
$("#drawLetters").mouseover(function(){
    clearInterval(timer);
});
// 鼠标移出继续滚动
$("#drawLetters").mouseout(function(){
    timer=setInterval(scrollAnimate,speed );
});
