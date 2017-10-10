$(function(){
    loadCss();
    $(window).resize(loadCss);
    $("#search_button").click(searchClick);//click search img
    $(document).keyup(function(event){
        if(event.keyCode==13){
            searchClick();
        }
    });


    /*function*/
    function loadCss(){
        var centerWidth=+($("#content_bodyText").css("width").replace(/px/,""));
        var winWidth=$(window).width();
        if(winWidth>=centerWidth){
            $("#content_bodyText").css("margin-left",(winWidth-centerWidth)/2+"px");
        }
        $("#keyboardInput").focus();
    }
    function searchClick(){
        //get text
        var searchContent=$("#keyboardInput").val();
        /*open new net*/
        if(searchContent!=""){
            window.open("https://www.google.com/search?q="+searchContent+"&sourceid=chrome&ie=UTF-8");

        }
    }//search


    /*weather canvas*/
    (function(){
        sendAjax();
        var timer1=setInterval(sendAjax,3600000);


        function drawWeather(canvas,data){
            var myCanvas=document.getElementById(canvas).getContext("2d");
            var weatherData=data,weatherIcon="",weatherStand;
            myCanvas.clearRect(0,0,+($("#mycanvas").attr("width").replace(/px/,"")),+($("#mycanvas").attr("height").replace(/px/,"")));
            /*temperature's text now*/
            myFillText(myCanvas,"45px 黑体","#434343","right","top",weatherData.xianzai.Temperature,53,10);//weatherData.xianzai.Temperature
            myFillText(myCanvas,"16px 黑体","#434343","left","top",'℃',53,17);

            /*address text*/
            myFillText(myCanvas,"13px 微软雅黑","#434343","right","top",weatherData.position.LocalizedName,173,23);//weatherData.position.LocalizedName
            /*address img*/
            myDrawImage(myCanvas,"./img/location.png",178,24,10,14.4);

            /*weather Icon*/
            /*switch(weatherData.xianzai.IconPhrase.toLowerCase()){
                case "sunny":
                case "mostly sunny":
                case "partly sunny":
                case "hazy sunshine":
                case "hot":
                    weatherIcon="./img/tianqi_icon/tianqi_sunlight.png";break;
                case "intermittent clouds":
                    if(judgeTime(weatherData.xianzai.time)=="daytime"){
                        weatherIcon="./img/tianqi_icon/tianqi_cloud_2.png";break;
                    }else{
                        weatherIcon="./img/tianqi_icon/tianqi_cloud_3.png";break;
                    }
                case "mostly cloudy":
                    if(judgeTime(weatherData.xianzai.time)=="daytime"){
                        weatherIcon="./img/tianqi_icon/tianqi_cloud_2.png";break;
                    }else{
                        weatherIcon="./img/tianqi_icon/tianqi_cloud_1.png";break;
                    }
                case "mostly cloudy w/ showers":
                    if(judgeTime(weatherData.xianzai.time)=="daytime"){
                        weatherIcon="./img/tianqi_icon/tianqi_rain_2.png";break;
                    }else{
                        weatherIcon="./img/tianqi_icon/tianqi_rain_3.png";break;
                    }
                case "mostly cloudy w/ t-storms":
                    if(judgeTime(weatherData.xianzai.time)=="daytime"){
                        weatherIcon="./img/tianqi_icon/tianqi_thunder_2.png";break;
                    }else{
                        weatherIcon="./img/tianqi_icon/tianqi_thunder_3.png";break;
                    }
                case  "mostly cloudy w/ flurries":
                case "partly sunny w/ flurries":
                    if(judgeTime(weatherData.xianzai.time)=="daytime"){
                        weatherIcon="./img/tianqi_icon/tianqi_snow_2.png";break;
                    }else{
                        weatherIcon="./img/tianqi_icon/tianqi_snow_3.png";break;
                    }
                case "cloudy":
                case "dreary (overcast)":
                case "fog":
                    weatherIcon="./img/tianqi_icon/tianqi_cloud_1.png";break;
                case "clear":
                case "mostly clear":
                case "partly cloudy":
                case "hazy moonlight":
                    weatherIcon="./img/tianqi_icon/tianqi_cloud_3.png";break;
                case "showers":
                case "rain":
                    weatherIcon="./img/tianqi_icon/tianqi_rain_1.png";break;
                case "partly sunny w/ showers":
                    weatherIcon="./img/tianqi_icon/tianqi_rain_2.png";break;
                case "partly cloudy w/ showers":
                    weatherIcon="./img/tianqi_icon/tianqi_rain_3.png";break;
                case "t-storms":
                    weatherIcon="./img/tianqi_icon/tianqi_thunder_1.png";break;
                case "partly sunny w/ t-storms":
                    weatherIcon="./img/tianqi_icon/tianqi_thunder_2.png";break;
                case "partly cloudy w/ t-shorms":
                    weatherIcon="./img/tianqi_icon/tianqi_thunder_3.png";break;
                case "flurries":
                case "snow":
                case "ice":
                case "freezing rain":
                    weatherIcon="./img/tianqi_icon/tianqi_snow_1.png";break;
                case "mostly cloudy w/ snow":
                    weatherIcon="./img/tianqi_icon/tianqi_snow_2.png";break;
                case "sleet":
                case "rain and snow":
                    weatherIcon="./img/tianqi_icon/tianqi_yujiaxue.png";break;
                case "cold":
                case "windy":
                    weatherIcon="./img/tianqi_icon/tianqi_wind.png";break;
            }*/
            //console.log(weatherData.xianzai.IconPhrase);
            weatherIcon="./img/tianqi_icon/"+weatherData.xianzai.IconPhrase+".png";
            myDrawImage(myCanvas,weatherIcon,76,50,46,46);

            /*weather Line*/
            weatherStand=getWeatherStand(weatherData);//get standard temperature
            myDrawLine(myCanvas,1,"#13b5b1",weatherData,weatherStand);
            /*weather Line-circle*/
            myDrawCircle(myCanvas,weatherData,weatherStand);
            /*weather max temperature*/
            myFillText(myCanvas,"12px 微软雅黑","#434343","center","bottom",weatherData.day5[0].max+"°",27+36*4,transTemperature(weatherData.day5[0].max,weatherStand)-10);
            myFillText(myCanvas,"12px 微软雅黑","#434343","center","top","("+weatherData.day5[0].min+"°)",27+36*4,transTemperature(weatherData.day5[0].max,weatherStand)+5);


            /*weather date text*/
            $.each(weatherData.day5,function(index,value){
                if(index===0){
                    myDrawLineCommon(myCanvas,20,"#666666","round",27+36*4-10,181,180,181);//27+36*4,183,190,183
                    myFillText(myCanvas,"14px 微软雅黑","#fff","center","bottom",value.wek,(27+36*4)-36*index,190);
                }else{
                    myFillText(myCanvas,"14px 微软雅黑","#434343","center","bottom",value.wek,(27+36*4)-36*index,190);
                }
            });
        }
        /*canvas draw*/
        /*draw text*/
        function myFillText(canvas,font,fillstyle,textalign,textbaseline,text,x,y){
            canvas.beginPath();
            canvas.fillStyle=fillstyle;
            canvas.font=font;
            canvas.textAlign=textalign;
            canvas.textBaseline=textbaseline;
            canvas.fillText(text,x,y);
            canvas.closePath();
        }
        /*draw img*/
        function myDrawImage(canvas,src,x,y,w,h){
            var myImage=new Image();
            myImage.src=src;
            myImage.onload=function(){
                canvas.beginPath();
                canvas.drawImage(myImage,x,y,w,h);
                canvas.closePath();
            }
        }
        /*draw line data relation*/
        function myDrawLine(canvas,strokewidth,strokestyle,weatherData,weatherStand){
            for(var indexDay5=1;indexDay5<weatherData.day5.length;indexDay5++){
                canvas.beginPath();
                canvas.moveTo((27+36*4)-36*(indexDay5-1),transTemperature(weatherData.day5[indexDay5-1].max,weatherStand));
                canvas.lineTo((27+36*4)-36*indexDay5,transTemperature(weatherData.day5[indexDay5].max,weatherStand));
                canvas.strokeStyle=strokestyle;
                canvas.lineWidth=strokewidth;
                canvas.stroke();
                canvas.closePath();
            }
        }
        /*draw line common*/
        function myDrawLineCommon(canvas,linewidth,strokestyle,linecap,x1,y1,x2,y2){
            canvas.beginPath();
            canvas.moveTo(x1,y1);
            canvas.lineTo(x2,y2);
            canvas.lineWidth=linewidth;
            canvas.strokeStyle=strokestyle;
            canvas.lineCap=linecap;
            canvas.stroke();
            canvas.closePath();
        }
        /*draw circle*/
        function myDrawCircle(canvas,weatherData,weatherStand){
            $.each(weatherData.day5,function(index,value){
                canvas.beginPath();
                canvas.arc((27+36*4)-36*index,transTemperature(value.max,weatherStand),3,0,Math.PI*2,false);
                canvas.strokeStyle="#13b5b1";
                canvas.strokeWidth="2px";
                canvas.fillStyle="#fff";
                canvas.fill();
                canvas.stroke();
                canvas.closePath();
            });
        }

        /*day or night*/
        function judgeTime(time){
            if(new Date("2000/1/1 "+time)<= new Date("2000/1/1 18:00")){
                return "daytime";
            }else{
                return "nighttime";
            }
        }
        function getWeatherStand(weatherData){
            var temperatureArr=[];
            $.each(weatherData.day5,function(index,valueObj){
                temperatureArr.push(valueObj.max);
            });
            temperatureArr.sort(temperatureCompare());
            return temperatureArr[2];
        }//standard temperature
        function transTemperature(value,weatherStand){
            return 120+(value-weatherStand)*10
        }//temperature translate y value
        /*function*/
        function temperatureCompare(){
            return function(value1,value2){
                if(value1<value2){
                    return -1;
                }else if(value1>value2){
                    return 1;
                }else{
                    return 0;
                }
            }
        }//sort function
        function sendAjax(){
            $.ajax({
                url:"http://171.221.202.190:11111/getWeather.php",
                type:"get",
                dataType:"jsonp",
                jsonp:"callback",
                success:function(data){
                    //$("#weatherHref").attr("href",decodeURIComponent(data.xianzai.Link));
                    drawWeather("mycanvas",data);
                }
            });
        }
    })();

});
/*bottom_rightT content*/
var vue_one=new Vue({
    el:"#bottom_rightTC",
    data:{
        bottom_rightTCContent:[
            {
                bottom_rightTCImg:[
                    "img/icon/icon_1.png","img/icon/icon_25.png","img/icon/icon_26.png",/*"img/icon/icon_2.png",*/"img/icon/icon_3.png",
                    "img/icon/icon_4.png","img/icon/icon_5.png",/*"img/icon/icon_6.png",*/
                    "img/icon/icon_7.png","img/icon/icon_8.png"
            ],
                bottom_rightTCText:[
                    'Google','Wikipedia ','ARABSEED',/*'Microsoft Offers',*/'jumia','سوق.كوم','صفقة اليوم ',
                   /* 'السوق المفتوح',*/'Twitter','Facebook'],
                bottom_rightTCHref:[
                    "https://www.google.com.eg/",
                    "https://www.wikipedia.org/",
                    "http://www.arabseed.com/",
                    /*"https://clk.tradedoubler.com/click?p=274395&a=2886302&g=23505890",*/
                    "https://www.jumia.com.eg/ar/?utm_source=cake&utm_medium=affiliation&utm_campaign=32&utm_term=icon%2cicon%3futm_source%3dcake",
                    "http://deals.souq.com/eg-ar/?utm_source=hao123&utm_medium=flat&utm_content=media&u_type=icon&utm_campaign=eg-hao123-dod",
                    "http://deals.souq.com/eg-ar/?country=eg&lang=ar&u_c=300x250&phgid=1101l4tu&pubref=Eg_Icon||||&utm_source=affiliate_hub&utm_medium=cpt&utm_content=affiliate&utm_campaign=100l2&u_fmt=banner&u_type=2&u_a=1011l698&u_as",
                    /*"https://eg.opensooq.com/ar?utm_source=hao123&utm_medium=cpc&utm_campaign=EG_Apr15",*/
                    "http://twitter.com/",
                    "https://www.facebook.com/"
                ]
            },
            {
                bottom_rightTCImg:[
                    "img/icon/icon_9.png","img/icon/icon_10.png","img/icon/icon_27.png",
                    "img/icon/icon_30.png",/*"img/icon/icon_11.png",*/
                    /*"img/icon/icon_12.png",*/"img/icon/icon_13.png","img/icon/icon_14.png",
                    "img/icon/icon_15.png","img/icon/icon_16.png"
                ],
                bottom_rightTCText:['يالاكورة','Korabia','Youtube', 'الألعاب ',/*'Legends of Honor','خصم خاص- Booking',*/'احجز_صح',
                    'Big Farm ','Empire','Yahoo '],
                bottom_rightTCHref:[
                    "http://www.yallakora.com/#hao123",
                    "https://www.korabia.com/",
                    "http://www.youtube.com/",
                    "http://www.1001games.com/?p=baidu_portal",
                    /*"http://legendsofhonor.com/game/?w=179498",
                    "http://www.booking.com/?aid=803422",*/
                    "https://www.biyi.cn/",
                    "http://bigfarm.goodgamestudios.com/?w=177306",
                    "http://empire.goodgamestudios.com/?w=177306",
                    "https://www.yahoo.com/"
                ]
            },
            {
                bottom_rightTCImg:[
                    "img/icon/icon_17.png","img/icon/icon_29.png",/*"img/icon/icon_18.png",*/"img/icon/icon_19.png",
                    "img/icon/icon_20.png","img/icon/icon_21.png","img/icon/icon_22.png",
                    "img/icon/icon_23.png","img/icon/icon_24.png"
                ],
                bottom_rightTCText:[ 'كورة x كورة','FRIV',/*'أخبار Hao123',*/' صدى البلد ','الوطن ','مصراوي',
                    'VideoYoum7 ',' أخبارك','نغم العرب '],
                bottom_rightTCHref:[
                    "https://ar.hao123.com/sports",
                    "http://friv.com/",
                    /*"https://ar.hao123.com/arnews/?activeIndex=0",*/
                    "http://www.elbalad.news/",
                    "http://www.elwatannews.com/",
                    "http://www.masrawy.com/",
                    "http://www.videoyoum7.com/",
                    "http://www.akhbarak.net/",
                    "http://www.melody4arab.com/"
                ]
            }
/*            {
                bottom_rightTCImg:[

                    /!*"img/icon/icon_31.png",*!/"img/icon/icon_32.png"
                ],
                bottom_rightTCText:[
                   /!*'سبواي سيرفرس ',*!/'ساحة الألعاب'],
                bottom_rightTCHref:[


                    /!*"https://ar.hao123.com/games/pcgames/detail?id=1&from=hao123_icon_game_sa",*!/
                    "http://www.karhoot.com/?tn=hao123_icon_home_ar"
                ]
            }*/
        ]
    }
});
var vue_two=new Vue({
    el:"#bottom_rightB",
    data:{
        bottomRightBRow:[
            {
                headerText:"الأخبار",
                contentText:["صدى البلد","البوابة نيوز ","المصريون","جريدة الدستور","دوت مصر",
                    "الفجر ","الشروق","الوفد","مصر العربية","الوطن",
                    "موقع التحرير"," مصراوي","اعرف كورة","يهمك.كوم","بطولات"
                ],
                TextHref:[
                    'http://www.el-balad.com/','http://www.albawabhnews.com/','https://almesryoon.com/',
                    'http://www.dostor.org/','http://www.dotmsr.com/','http://new.elfagr.org/',
                    'http://www.shorouknews.com/','http://alwafd.org/','http://www.masralarabia.com/',
                    'http://www.elwatannews.com/','http://www.tahrirnews.com/','http://masrawy.com/slides/news',
                    'http://www.e3rfkora.com/','http://www.yehemak.com/','http://btolat.com/'
                ],
                GameFlog:false
            },
            {
                headerText:"إتفرج أون لاين",
                contentText:["أفلام نيكولاس كيدج","2015 أفلام","سلسلة Spider-Man ",
                    "أفلام الأبطال الخارقين","أفلام الأوسكار","أجمد أفلام الأكشن",
                    "أفلام بوليوود","مهرجان كان","أفلام الخيال العلمى","مباريات كرة القدم"
                ],
                TextHref:[
                    'https://ar.hao123.com/movie/seriesDetail?from=hao123_flat_album_ar&type=0#tag=79',
                    'https://ar.hao123.com/movie/mlist?year=2014&vt=0&from=hao123_flat_list_ar',
                    'https://ar.hao123.com/movie/seriesDetail?from=hao123_flat_album_ar&type=0#tag=88',
                    'https://ar.hao123.com/movie/seriesDetail?from=hao123_flat_album_ar&type=0#tag=20',
                    'https://ar.hao123.com/movie/seriesDetail?from=hao123_flat_album_ar&type=0#tag=76',
                    'https://ar.hao123.com/movie/seriesDetail?from=hao123_flat_album_ar&type=0#tag=18',
                    'https://ar.hao123.com/movie/seriesDetail?from=hao123_flat_album_ar&type=0#tag=23',
                    'https://ar.hao123.com/movie/seriesDetail?from=hao123_flat_album_ar&type=0#tag=30',
                    'https://ar.hao123.com/movie/seriesDetail?from=hao123_flat_album_ar&type=0#tag=108',
                    'https://ar.hao123.com/movie/mlist?vt=4&from=hao123_flat_list_ar'
                ],
                GameFlog:false
            },
            {
                headerText:"الألعاب",
                contentText:['العاب بنات ','Metin2 ','Axeso ','قهر أونلاين   ','بمومب مان',
                    'ترافيان  ',' العاب تلبيس','العاب الرياضة','Plants vs Zombies',
                    'بوكر بويا '
                ],
                TextHref:[
                    'https://ar.hao123.com/games/listpage?catalog=9&from=hao123_text_list_ar',
                    'http://a2g-secure.com/?E=nsxTTlOTKwIR0q6vCDvwlQwUzfnVGPGN&s1=',
                    'http://www.axeso5.com/','https://7esab.99.com/common/Co_homepage_201411.html?url=https://7esab.91.com/common/signup.aspx&BillID=2963&from=pc',
                    'http://www.oasgames.com/lp/bmar/lp.php?sp_promote=ar;ddtank_ar;ar;hao123;text',
                    'http://goo.gl/cEY9z','https://ar.hao123.com/games/listpage?catalog=241000&from=hao123_icontext_list_ar',
                    'https://ar.hao123.com/games/listpage?catalog=6',
                    'https://ar.hao123.com/games/theme?tid=22&from=hao123_text_newplantsvs_br',
                    'https://apps.facebook.com/artexas/?fb_source=ad&ad=90000496'
                ],
                GameFlog:true,
                GameMessage:{
                    headerMessage:' HTML5العب ألعاب ',
                    GameImg:["img/game_1.png","img/game_2.png","img/game_3.png","img/game_4.png",
                        "img/game_5.png","img/game_6.png","img/game_7.png","img/game_8.png",
                        "img/game_9.png","img/game_10.png","img/game_11.png","img/game_12.png",
                        "img/game_13.png","img/game_14.png","img/game_15.png","img/game_16.png",
                        "img/game_17.png","img/game_18.png","img/game_19.png","img/game_20.png"
                    ],
                    GameText:["Kim's Shoe Designer","Fly with Rope 2",'Crazy Colors','Down The Hill',
                        'Annas Pedicure','Jewels Blitz','Jelly Survival','Touch and Catch Being Santa',
                        'Flappy Multiplayer ','Stack Tower ','Championship 2016','Fugitive Sparrow',
                        'Crossy Path','Bubble Shooter Saga','Candy Rain 2','2020','Basketball','Tetra',
                        'Annas Nail Salon','Octopus Hugs'
                    ],
                    GameHref:[
                        "http://www.1001games.com/games/kims-shoe-designer?p=baidu_portal",
                        'http://www.karhoot.com/play/Skill/Fly-with-Rope-2.html',
                        'http://www.karhoot.com/play/Skill/Crazy-Colors.html',
                        'http://www.karhoot.com/play/Skill/Down-The-Hill.html',
                        'http://www.karhoot.com/play/Games-for-Girls/Annas-Pedicure.html',
                        'http://www.karhoot.com/play/Classic-Games/Jewels-Blitz.html',
                        'http://www.karhoot.com/play/Skill/Jelly-Survival.html',
                        'http://www.karhoot.com/play/Skill/Touch-and-Catch-Being-Santa.html',
                        'http://www.karhoot.com/play/Classic-Games/Flappy-Multiplayer.html',
                        'http://www.karhoot.com/play/Classic-Games/Stack-Tower.html',
                        'http://www.karhoot.com/play/Skill/Championship-2016.html',
                        'http://www.karhoot.com/play/Classic-Games/Fugitive-Sparrow.html',
                        'http://www.karhoot.com/play/Skill/Crossy-Path.html',
                        'http://www.karhoot.com/play/Arcade-Games/Bubble-Shooter-Saga.html',
                        'http://www.karhoot.com/play/Classic-Games/Candy-Rain-2.html',
                        'http://www.karhoot.com/play/Puzzle-Games/2020.html',
                        'http://www.karhoot.com/play/Skill/Basketball.html',
                        'http://www.karhoot.com/play/Puzzle-Games/Tetra.html',
                        'http://www.karhoot.com/play/Games-for-Girls/Annas-Nail-Salon.html',
                        'http://www.karhoot.com/play/Puzzle-Games/Octopus-Hugs.html'
                    ]
                }
            },
            {
                headerText:"التحميل",
                contentText:["البرامج صح ",'عرب هاردوير','مزيكا تو داى ','السينما للجميع','عرب سيد',
                    'فيلمى',' تحميل العاب','فبركة','مركز تحميل البرامج','تطبيقات ',
                    'تحميل برامج كمبيوتر','سينما ليك','اتفرج اونلاين'
                ],
                TextHref:[
                    'http://www.bramjsh.com/','http://arabhardware.net/','http://mazika2day.com/',
                    'http://cima4u.tv/','http://www.arabseed.com/ar/home.html','http://filmey.tv/',
                    'https://ar.hao123.com/games/pcgames/listpage','http://www.fbrka.com/',
                    'http://soft.sptechs.com/','http://www.ttopsoft.com/','http://www.traidsoft.net/',
                    'http://cinemalek.com/','http://tvgate.tv/'
                ],
                GameFlog:false
            },
            {
                headerText:'الرياضة',
                contentText:['موقع جماهير الأهلي ','يالاكورة ','Filgoal.com ','كورة اون لاين ',
                    'كووورة ','إسماعيلى اون لاين ',' جول.كوم ','دليل كورة','WWE','Maktoobالمصارعة ',
                    'TVالاسماعيلى','كورة جول ','رايه و صفاره','Btolat.com'
                ],
                TextHref:[
                    'http://new.el-ahly.com/','http://www.yallakora.com/#hao123',
                    'http://www.filgoal.com/','http://kora-online.tv/','http://www.kooora.com/default.aspx',
                    'http://ismailyonline.com/','http://goal.baidu.com/','http://www.korh.cc/',
                    'https://ar.hao123.com/movie/mlist?vt=2&from=hao123_flat_list_ar',
                    'https://en-maktoob.yahoo.com/?p=xa','http://www.elismaily.tv/','http://www.koooragoal.com/',
                    'https://rayawsofara.com/','http://btolat.com/'
                ],
                GameFlog:false
            },
            {
                headerText:'الأغاني',
                contentText:['Free Musicup',' دندنها',' سمـعـنا ',' موالي','listenarabicأغاني',
                    'نجومي ','أغاني العرب',' نغمات ','نغم العرب'
                ],
                TextHref:[
                    'http://musicup.me/','http://www.dndnha.com/','http://www.sm3na.com/',
                    'http://www.mawaly.com/','http://www.listenarabic.com/ar/Music/',
                    'http://www.nogomistars.com/ar/index.asp','http://mp31.alarab.net/',
                    'http://songs.nghmat.com/','http://www.melody4arab.com/'
                ],
                GameFlog:false
            },
            {
                headerText:'مواقع دينية',
                contentText:['استماع قرآن اون لاين',' صوت المسيحى الحر',' الطريق إلى الل',
                    'طريق الإسلام','إسلام ويب','  الإسلام اليوم ','نداء الإيمان','موقع مسيحي شامل',
                    'مفكرة الإسلام','قصة الإسلام',' الذاكر'
                ],
                TextHref:[
                    'https://ar.hao123.com/religion?appid=2027495133#lv2_app_canvas',
                    'http://www.light-dark.net/','http://way2allah.com/','http://ar.islamway.net/',
                    'http://islamweb.net/mainpage/index.php','http://www.islamtoday.net/',
                    'http://www.al-eman.com/index.htm','http://www.linga.org/','http://islammemo.cc/',
                    'http://islamstory.com/'
                ],
                GameFlog:false
            },
            {
                headerText:' تطبيقات أندرويد',
                contentText:['Facebook','WhatsApp Messenger','Viber','Instagram','Retrica',
                    'Subway Surfers','Candy Crush Saga','أوقات الصلاة','DU Speed Booster',
                    'DU Battery Saver','Baidu Browser','Super-Bright LED','Truecaller',
                    'Laserbreak Pro','SoundCloud'
                ],
                TextHref:[
                    'https://play.google.com/store/apps/details?id=com.facebook.katana',
                    'https://play.google.com/store/apps/details?id=com.whatsapp',
                    'https://play.google.com/store/apps/details?id=com.viber.voip',
                    'https://play.google.com/store/apps/details?id=com.instagram.android',
                    'https://play.google.com/store/apps/details?id=com.venticake.retrica',
                    'https://play.google.com/store/apps/details?id=com.kiloo.subwaysurf',
                    'https://play.google.com/store/apps/details?id=com.king.candycrushsaga',
                    'https://play.google.com/store/apps/details?id=com.hao123.global.prayer',
                    'https://play.google.com/store/apps/details?id=com.dianxinos.optimizer.duplay',
                    'https://play.google.com/store/apps/details?id=com.dianxinos.dxbs',
                    'https://play.google.com/store/apps/details?id=com.baidu.browserhd.inter&hl=zh-CN',
                    'https://play.google.com/store/apps/details?id=com.surpax.ledflashlight.panel',
                    'https://play.google.com/store/apps/details?id=com.truecaller',
                    'https://play.google.com/store/apps/details?id=com.errorsevendev.games.laserBreakPaid',
                    'https://play.google.com/store/apps/details?id=com.soundcloud.android'
                ],
                GameFlog:false
            },
            {
                headerText:'البرامج',
                contentText:['PC Faster','قاموس المورد ','برامج ','MoboMarket',
                    'Youtube Downloader','Avira','Google Chrome','Download Manager',
                    'Skype','أخبار التقنية'
                ],
                TextHref:[
                    'http://goo.gl/LeQMa','https://play.google.com/store/apps/details?id=com.baidu.dict.arabic',
                    'http://www.jsoftj.com/','http://www.mobomarket.net/','http://soft.sptechs.com/113184-YouTube-Downloader.html',
                    'http://soft.sptechs.com/31095-Avira-AntiVir-PersonalEdition-FREE.html',
                    'http://soft.sptechs.com/76811-Google-Chrome.html',
                    'http://soft.sptechs.com/14705-Internet-Download-Manager-511.html',
                    'http://skype.gmw.cn/','http://www.vip4soft.com/news/'
                ],
                GameFlog:false
            },
            {
                headerText:'عالم المرأة',
                contentText:['هاى ماما','عالم حواء  ','حسابات الحمل',' سيدتي ',
                    'صبايا كافيه ','شملولة','عالم المرأة ','فتكات ','مجلة ليالينا'
                ],
                TextHref:[
                    'http://www.hi-mama.com/new/','https://www.hawaaworld.com/',
                    'https://ar.hao123.com/lady?appid=2024635632#lv2_app_canvas',
                    'https://www.sedty.com/','http://www.sabayacafe.com/',
                    'http://www.shamlola.com/','http://almraah.net/',
                    'http://fatakat.com/','http://www.layalina.com/'
                ],
                GameFlog:false
            },
            {
                headerText:'الوظائف الخالية',
                contentText:['Wuzzuf','حلول التوظيف ','Jobrp','جوبزيلا','وظايف',
                    'شغلانتى','شبكة خلية','تنقيب ','أعمال الخليج ','عرب ريك ','Icareer',
                    'بريميير للتوظيف','حجرة التجارة الامريكية ',' وظائف مصرية',
                    'ميرج',' فرصنا','ار بى للموارد المهنية','سنايا',' أخطبوط ',
                    'Gigajob','Bayt','Indeed','LinkedIn'
                ],
                TextHref:[
                    'http://wuzzuf.net/','http://jobmastergroup.com/recruitment',
                    'http://www.jobrp.com/home','https://www.jobzella.com/',
                    'http://www.wzayef.com/','http://www.shoghlanty.com/','http://www.khalya.net/',
                    'http://egypt.tanqeeb.com/ar','http://www.thegulfbiz.com/vb/','http://www.arabrec.com/',
                    'http://www.icareeregypt.com/','http://www.premieregypt.com/',
                    'http://www.amcham.org.eg/online_services/recruitment/','http://www.jobs-eg.com/',
                    'http://www.mergecareer.com/','http://forasna.com/jobs/egypt',
                    'http://www.rp-jobs.com/','http://www.sanaya.net/','https://www.akhtaboot.com/',
                    'https://www.gigajob.com/','https://www.bayt.com/','https://cn.indeed.com/?r=us',
                    'https://www.linkedin.com/'
                ],
                GameFlog:false
            },
            {
                headerText:'التربية والتعليم',
                contentText:['وزارة التربية والتعليم ','الثانوية ','نفهم ',
                    'جامعة القاهرة ','بوابة الثانوية العامة ','جامعة عين شمس',
                    'التعليم','الأزهر ','اتعلم و '
                ],
                TextHref:[
                    'http://portal.moe.gov.eg/Pages/default.aspx',
                    'http://thanwya.com/','https://www.nafham.com/','http://cu.edu.eg/ar/Home',
                    'http://www.thanwya.com/vb/','http://www.asu.edu.eg/',
                    'http://egyedu.com/','http://www.azhar.edu.eg/','http://tahriracademy.org/?utm_source=hao123&utm_medium=hp-link'
                ],
                GameFlog:false
            },
            {
                headerText:'البنوك',
                contentText:['البنك الأهلي المصري','بنك مصر','بنك الاسكندرية',
                    'البنك الوطني المصري ','مجلة البورصة والاقتصاد ','AAIB',
                    'البنك المركزي المصري',' بنك بي ان بي','بنك أبو ظبي الوطني',
                    ' البنك التجاري الدولي'
                ],
                TextHref:[
                    'http://www.nbe.com.eg/Main.aspx','http://www.banquemisr.com/ar',
                    'https://www.alexbank.com/','http://www.nbk.com.eg/',
                    'http://borsamag.com/','http://www.aaib.com/ar/personal',
                    'http://www.cbe.org.eg/ar/Pages/default.aspx',
                    'https://group.bnpparibas/','https://www.nbad.com/ar-eg/personal-banking.html',
                    'http://www.cibeg.com/arabic/Pages/default.aspx'
                ],
                GameFlog:false
            },
            {
                headerText:'المواقع المميزة',
                contentText:['معاني الأسماء','رائج','wuzzuf','Contact Cars',
                    'مجلة كل الناس',' مجلة موبايل ترند ','موقع القيادي',
                    'تيربو العرب','الوسيط','Menu Egypt','مصراوي','البال تل ','فرصنا - وظائف مصر'
                ],
                TextHref:[
                    'http://www.almaany.com/names.php?language=arabic&lang_name=%D8%B9%D8%B1%D8%A8%D9%8A#',
                    'http://www.ra2ej.com/','https://wuzzuf.net/jobs/egypt?ref=hao123_Featured',
                    'http://www.contactcars.com/','http://kolelnasmag.com/','http://mobiletrendmag.com/',
                    'http://www.alqiyady.com/','http://www.arabsturbo.com/','http://eg.waseet.net/ar/site/cairo/index',
                    'http://menuegypt.com/menu','http://www.masrawy.com/','http://www.paltale.com/',
                    'http://forasna.com/jobs/egypt'
                ],
                GameFlog:false
            }
        ]
    },
    computed:{
        bottom_rightBCContentHgt:function(){
            var bottom_rBCContentRowNumArr=[];
            $.each(this.bottomRightBRow,function(n,value){
                 bottom_rBCContentRowNumArr.push(27*Math.ceil(value.contentText.length/5));
            });
            return bottom_rBCContentRowNumArr;
        }
    }
});
/*news part*/
$(function(){
    var newsData={};
    var vue_news=new Vue({
        el:"#newsPart",
        data:{
            newsTopData:[],
            newsTopImg:"",
            newsTopArticleData:[],
            newsBottomData:[],
            newsBottomImg:"",
            newsBottomArticleData:[]
        },
        methods:{
            textLengthChange:function(text){
                /*delete more text*/
                var textArr=text.split(" "),textLength= 0,isTextArr=[];
                for(var textIndex=0;textIndex<textArr.length;textIndex++){
                    //console.log((textArr[textIndex]).length)
                    if((textArr[textIndex].length)+textLength+3<=27){
                        textLength+=textArr[textIndex].length+1;//+1是加的空格字符
                        isTextArr.push(textArr[textIndex]);
                    }else{
                        isTextArr.push("...");
                        break;
                    }
                }
                return isTextArr.join(' ');
            },
            newsTopDataChange:function(activeIndex){
                    /*delete having article*/
                   /*clear child article*/
                if(this.newsTopArticleData!=""&&this.newsTopArticleData!=[]&&this.newsTopArticleData!=undefined&&this.newsTopArticleData!=null){
                    $.each(newsData[activeIndex].articles,function(articleIndex,articlevalue){
                        vue_news.newsTopArticleData.splice(articleIndex,1,articlevalue);
                    });
                }
                else{
                    $.each(newsData[activeIndex].articles,function(articleIndex,articlevalue){
                        vue_news.newsTopArticleData.$set(articleIndex,articlevalue);
                    })
                }

                /*active class*/
                $.each(this.newsTopData,function(index,value){
                    if(index===activeIndex){
                        value.activeFlog=true;
                    }else{
                        value.activeFlog=false;
                    }
                });

                /*has img article title*/
                this.newsTopImg=newsData[activeIndex].articles[0];
                /*$.each(newsData,function(index,value){
                    if(activeIndex===index && index<=2){
                        vue_news.newsTopData.$set(index,{newsClassify:value.source,activeFlog:true});
                    }else if(index<=2){
                        vue_news.newsTopData.$set(index,{newsClassify:value.source,activeFlog:false});
                    }
                });*/
/*                $.each(this.newsTopData,function(beforeIndex,beforevalue){
                    if(beforeIndex===activeIndex){
                        /!*each activeIndex articles arr,this.newsTopData.article.push(newData[activeIndex].articles[everyIndex])*!/
                        $.each(newsData[activeIndex].articles,function(articleIndex,articlevalue){
                            beforevalue.article.push(articlevalue);
                        });
                    }else{
                        if(beforevalue.article!=""&&beforevalue.article!=[]&&beforevalue.article!=undefined&&beforevalue.article!=null){
                            beforevalue.article=[];
                        }
                    }
                });*/
            },
            newsBottomDataChange:function(activeIndex){
                /*create child article*/
                this.newsBottomImg=newsData[activeIndex+3].articles[0];
                if(this.newsBottomArticleData!=""&&this.newsBottomArticleData!=[]&&this.newsBottomArticleData!=undefined&&this.newsBottomArticleData!=null){
                    $.each(newsData[activeIndex+3].articles,function(index,value){
                        vue_news.newsBottomArticleData.splice(index,1,value);
                    });
                }else{
                    $.each(newsData[activeIndex+3].articles,function(index,value){
                        vue_news.newsBottomArticleData.push(value);
                    });
                }
                /*change active css*/
                $.each(this.newsBottomData,function(index,value){
                    if(activeIndex===index){
                        value.activeFlog=true;
                    }else{
                        value.activeFlog=false;
                    }
                });
            }
        }
    });
    $.ajax({
        type:"get",
        url:"http://171.221.202.190:11111/news.php",
        dataType:"jsonp",
        jsonp:"callback",
        success:function(data){
            if(data!=undefined&&data!=""&&data!={}&&data!=null){
                newsData=data;
                $.each(newsData,function(index,value){
                    var childNewsObj={newsClassify:value.source,activeFlog:false};
                    if(index<=2){
                        vue_news.newsTopData.push(childNewsObj);
                    }else{
                        vue_news.newsBottomData.push(childNewsObj);
                    }
                    $.each(value.articles,function(childIndex,childValue){
                        childValue.title=vue_news.textLengthChange(childValue.title);
                    })
                });
                vue_news.newsTopDataChange(0);
                vue_news.newsBottomDataChange(0);
            }
        }
    });
});





