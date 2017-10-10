<template>
  <div id="loginTotal" :style="{height:AppHeight+'px'}">
    <div id="loginHeader">
      <div v-bind:class="['lgnHdrMain',{'HeaderMain_line':userMsgShow}]">
        <div class="loginDate" v-text="loginDate"></div>
        <div class="loginTime" v-text="loginTime"></div>
        <template v-if="userMsgShow">
          <div class="userMsg">
            <img src="../../assets/img/sign_in/home_hand.png" />
            <span v-text='userName'>yangcheng</span>
          </div>
          <ul class="loginRgt">
            <div @click='LoginOutClick' class="backLogin">Log out</div>
            <router-link to="loginModifyPwd" class="ChangePwd">Modify password</router-link>
          </ul>
        </template>
      </div>
    </div>
    <div id="loginMain">
      <template v-if="logoShow">
        <div class="loginContent"><img src="../../assets/img/sign_in/Content--.png" /></div>
        <div class="loginMsg">MANAGEMENT SYSTEM</div>
      </template>
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
  import {LoginOutHTTP,CheckedLoginHTTP} from '../../api/http'
  import {mapState,mapActions} from 'vuex'
  import $ from "jquery"
  export default{
     data(){
       return{
        loginDate:"",
        loginTime:"",
        logoShow:true,
        userMsgShow:false
      }
     },
     computed:mapState(['userName','AppHeight']),
     methods:{
       ...mapActions(['CheckLoginState']),
       LoginOutClick(){
         LoginOutHTTP();
         this.$router.push({name:'loginStart'});
       },
       getDate(){
         let date=new Date();
         if(date.getSeconds()<10 || date.getMinutes()<10){
           if(date.getSeconds()<10 && date.getMinutes()>10){
              this.loginTime=date.getHours()+":"+date.getMinutes()+":0"+date.getSeconds();
           }else if(date.getSeconds()<10 && date.getMinutes()<10){
              this.loginTime=date.getHours()+":0"+date.getMinutes()+":0"+date.getSeconds();
           }else if(date.getSeconds()>10 && date.getMinutes()<10){
              this.loginTime=date.getHours()+":0"+date.getMinutes()+":"+date.getSeconds();
           }
         }else{
            this.loginTime=date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
         }
         this.loginDate=date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
       }
     },
     watch:{
        "$route"(to,from){
          if(to.path=="/login/loginSuccess"){
            $("#loginHeader").animate({"height":$("#loginTotal").css("height")},500);
            this.logoShow=true;
            this.userMsgShow=true;
          }else if(to.path=="/login/loginStart"){
            this.logoShow=true;
            this.userMsgShow=false;
            $("#loginHeader").stop().css({"height":$(".lgnHdrMain").css("height")});
          }else if(to.path=="/login/loginModifyPwd"){
            this.logoShow=false;
          }else{
            this.logoShow=true;
          }
        }
     },
    created(){
      this.CheckLoginState();
      this.getDate();
      setInterval(this.getDate,1000);
    },
    mounted(){
      if(this.$route.path=='/login/loginSuccess'){
        $("#loginHeader").css({"height":$("#loginTotal").css("height")});
        this.logoShow=true;
        this.userMsgShow=true;
      }
    },
    beforeCreate(){
      //console.log(this.$route.path);
    }
  }
</script>
<style lang="less" scoped>
  @import "../../style/login/login.less";
</style>



