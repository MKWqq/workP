<template>
    <div id="app" :style="{height:windowHeight+'px'}">
      <router-view></router-view>
    </div>
</template>
<script>
  import $ from "jquery"
  export default {
    data(){
      return {
        windowHeight:""
      }
    },
    created(){
      this.windowHeight=$(window).height();
    }
  }
</script>
<style lang="less">
  *{margin:0;padding:0;font-size:14px;color:#4b4b4b;font-family:"微软雅黑";list-style:none;}
  body{overflow:hidden;}
  a{text-decoration:none;}
  @HeaderHeight:167px;@HeaderWidth:1920px;
  .box-sizing(@value){-moz-box-sizing:@value;-ms-box-sizing:@value;-o-box-sizing:@value;-webkit-box-sizing:@value;box-sizing:@value;}
  .box-shadow(@value){-moz-box-shadow:@value;-o-box-shadow:@value;-ms-box-shadow:@value;-webkit-box-shadow:@value;box-shadow:@value;}
  #app{width:@HeaderWidth;}
  #Header{height:@HeaderHeight;width:100%;background:#03a0aa;.box-shadow(0 3px 8px 0 rgba(0,0,0,.4));position:relative;
    h2{font-size:30px;font-weight:bold;width:(1920px-40px);margin-left:40px;height:102px;padding:34px 0;.box-sizing(border-box);color:#fff;}
  }
  #Main{width:(@HeaderWidth)-100;height:(955px-102);position:fixed;top:102px;left:50px;}
</style>







