<template>
  <router-view></router-view>
</template>
<script>
import $ from "jquery"
  export default{
    name:"app",
    components:{},
    data(){
      return {
        //AppHeight:$(window).height()
      }
    },
    watch:{
      '$route'(to,from){
      }
    },
    created(){
      //this.AppHeight=$(window).height();
      //<div id="app" v-bind:style="{height:AppHeight+'px'}"></div>
    }
  }
</script>
<style>
  *{margin:0;padding:0;}
  body{overflow:hidden;margin:0;position:relative;}
  #app{width:100%;}
</style>

