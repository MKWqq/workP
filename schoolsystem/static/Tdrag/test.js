define("YS-frame/jquery/gridly/mygridly", ["jquery"], function(require, exports, module) {

  var drgHTML = function(json){
    var iMinindex=2;
    //json.oUl.innerHTML=json.HTML;
    buJuZH(json.obs,json.aLi);                  //运行布局转换

    for(var i=0;i<json.aLi.length;i++){
      drg(json.aLi[i],json.aLi,json.obs);          //运行拖拽函数
    }

    //布局转换
    function buJuZH(json,array){
      for(var i=0;i<array.length;i++){
        json[i]={left:array[i].offsetLeft,top:array[i].offsetTop};
      }
      for(var i=0;i<array.length;i++){
        array[i].style.position="absolute";
        array[i].style.left=json[i].left+'px';
        array[i].style.top=json[i].top+'px';
        array[i].style.margin="0px";
        array[i].index=i;
      }
    }
    //拖拽
    function drg(obj,array,json){
      obj.onmousedown=function(ev){
        var beforeLeft=obj.offsetLeft;
        var beforeTop=obj.offsetTop;
        var oEvent=ev||event;
        obj.style.zIndex=iMinindex++;
        var drgL=oEvent.clientX-beforeLeft;
        var drgT=oEvent.clientY-beforeTop;
        document.onmousemove=function(ev){
          var oEvent=ev||event;
          obj.style.left=oEvent.clientX-drgL+'px';
          obj.style.top=oEvent.clientY-drgT+'px';
          for(var i=0;i<array.length;i++){
            array[i].className='';
          }
          var near=nearest(obj,array);
          if(near){
            near.className='active';
          }
        }
        document.onmouseup=function(){
          document.onmousemove=null;
          document.onmouseup=null;
          for(var i=0;i<array.length;i++){
            if(array[i]==obj)continue;
            var near=nearest(obj,array);
            if(penZhu(obj,array[i])){
              near.className='';
              near.style.zIndex=iMinindex++;
              obj.style.zIndex=iMinindex++;
              startMove(obj, json[near.index]);
              startMove(near, json[obj.index]);
              var indexC=obj.index;
              obj.index=near.index;
              near.index=indexC;
            }else {
              startMove(obj, json[obj.index])
            }
          }
        }
        clearInterval(obj.timer);
        return false;
      }
    }
    //碰撞检测
    function penZhu(obj1,obj2){
      var l1=obj1.offsetLeft;
      var r1=obj1.offsetLeft+obj1.offsetWidth;
      var t1=obj1.offsetTop;
      var b1=obj1.offsetTop+obj1.offsetHeight;
      var l2=obj2.offsetLeft;
      var r2=obj2.offsetLeft+obj2.offsetWidth;
      var t2=obj2.offsetTop;
      var b2=obj2.offsetTop+obj2.offsetHeight;
      if(r1<l2 || l1>r2 || t1>b2 || b1<t2) {
        return false; //没有碰到
      }else {
        return true; //碰到了
      }
    }
    /*距离计算*/
    function getDis(obj1,obj2){
      var a=obj1.offsetLeft-obj2.offsetLeft;
      var b=obj1.offsetTop-obj2.offsetTop;
      return Math.sqrt(a*a+b*b);
    }
    /*寻找最近的块*/
    function nearest(obj,array){
      var begNum=999999999;
      var begIndex=-1;
      for(var i=0;i<array.length;i++){
        if(obj==array[i])continue;
        if(penZhu(obj,array[i])){
          var dis=getDis(obj,array[i]);
          if(dis<begNum){
            begNum=dis;
            begIndex=i;
          }
        }
      }
      if(begIndex==-1){
        return null;
      }else {
        return array[begIndex];
      }
    }
    //运动框架
    function getStyle(obj, attr){
      if(obj.currentStyle){
        return obj.currentStyle[attr];
      }else{
        return getComputedStyle(obj, false)[attr];
      }
    }
    function startMove(obj, json, fn){
      clearInterval(obj.timer);
      obj.timer=setInterval(function (){
        var bStop=true;//这一次运动就结束了——所有的值都到达了
        for(var attr in json){
          //1.取当前的值
          var iCur=0;
          if(attr=='opacity'){
            iCur=parseInt(parseFloat(getStyle(obj, attr))*100);
          }
          else{
            iCur=parseInt(getStyle(obj, attr));
          }
          //2.算速度
          var iSpeed=(json[attr]-iCur)/8;
          iSpeed=iSpeed>0?Math.ceil(iSpeed):Math.floor(iSpeed);
          //3.检测停止
          if(iCur!=json[attr]){
            bStop=false;
          }
          if(attr=='opacity'){
            obj.style.filter='alpha(opacity:'+(iCur+iSpeed)+')';
            obj.style.opacity=(iCur+iSpeed)/100;
          }
          else{
            obj.style[attr]=iCur+iSpeed+'px';
          }
        }
        if(bStop){
          clearInterval(obj.timer);
          if(fn){
            fn();
          }
        }
      }, 30)
    }
  }


//对外输出接口
  module.exports = drgHTML;
  //return drgHTML;
});
