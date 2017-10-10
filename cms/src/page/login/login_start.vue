<template>
  <div id="userSign">
    <el-form :model="SignIn" ref="signIn" :rules="SignInRules">
      <el-form-item prop="userName" class="SignInItem">
        <el-input type="text" v-model="SignIn.userName" placeholder="User name"></el-input>
      </el-form-item>
      <el-form-item prop="userPwd" class="SignInItem">
        <el-input type="password" v-show="inputType" v-model="SignIn.userPwd" placeholder="Password"></el-input>
        <el-input type="text" v-show="!inputType" v-model="SignIn.userPwd" placeholder="Password"></el-input>
        <img class="hidePwd" src="../../assets/img/sign_in/home_login_eye.png" @click="changSee" v-show="NotSeePwd" />
        <img class="showPwd" src="../../assets/img/sign_in/home_login_eye_highlight.png" @click="changSee" v-show="!NotSeePwd" />
      </el-form-item>
      <el-form-item class="SignInItem">
        <el-checkbox v-model='SignIn.checked' @click='rememberPsw' label="Remember the login status" name="type"></el-checkbox>
      </el-form-item>
      <el-form-item class="SignInItem">
        <el-button class="submitSignIn" type="primary" @click="submitPwd('signIn')">SIGN IN</el-button>
      </el-form-item>
    </el-form>
    <div class="promptMsg" v-show="promptShow">
      <img src="../../assets/img/sign_in/mistake_remind.png" />
      <span v-text="promptMsg"></span>
    </div>
  </div>
</template>
<script>
  import $ from "jquery";
  import {LoginHTTP,CheckedLoginHTTP} from '../../api/http'
  import {mapActions} from "vuex"
  import {mapState} from "vuex"
   export default{
      computed:{
        //...mapState(["psw"])
      },
      data(){
         var userName=(rule,value,callback)=>{
          if(value==""){
            callback(new Error("Please enter your username"));
          }else if(!/^[\\u4e00-\\u9fa5_a-zA-Z0-9-]{1,16}$/.test(value)){
            if(/^[\\u4e00-\\u9fa5_a-zA-Z0-9-]{17,1000}$/.test(value)){
              callback(new Error("Please enter 1 to 16 characters in length of username"));
            }else{
              callback(new Error("Please enter a valid characters"));
            }
          }else{
            callback();
          }
         }
         var userPwd=(rule,value,callback)=>{
          if(value==""){
            callback(new Error("Please enter the password"));
          }else if(!/^[\w]{4,13}$/.test(value)){
            if(/^[\w]{14,1000}$/.test(value) || /^[\w]{0,3}$/.test(value)){
              callback(new Error("Please enter the password that was 4 to 13"));
            }else{
              callback("Please enter a valid characters");
            }
          }else{
            callback();
          }
         }
         return {
           CookieUtil:{},//handler cookie
           inputType:true,
           NotSeePwd:true,
           promptShow:false,
           promptMsg:"",
           SignIn:{
            userName:"",
            userPwd:"",
            checked:true
           },
           SignInRules:{
            userName:[{
              validator:userName,trigger:"blur,change"
            }],
            userPwd:[{
              validator:userPwd,trigger:"blur,change"
            }]
           }
         }
      },
      methods:{
         //...mapActions(['CheckLoginState']),
         rememberPsw(){
          if(this.SignIn.checked){
            this.CookieUtil.set('userName',this.SignIn.userName,new Date()+8.64e7*7);
            this.CookieUtil.set('password',this.SignIn.userPwd,new Date()+8.64e7*7);
          }else{
            this.CookieUtil.unset('userName');
            this.CookieUtil.unset('password');
          }
         },
         changSee(){
            this.NotSeePwd=!this.NotSeePwd;
            this.inputType=!this.inputType;
            window.setTimeout (function(){$(".userPwd input").focus();},0);
         },
         submitPwd(formName){
            this.$refs[formName].validate((valid) => {
              if(valid){
                this.rememberPsw();
                LoginHTTP({user:this.SignIn.userName,password:this.SignIn.userPwd}).then(data=>{
                  if(data.login){
                    this.promptShow=false;
                    this.$router.push("/login/loginSuccess");
                  }else{
                    this.promptMsg="Wrong password.Try again.";
                    this.promptShow=true;
                  }
                });
              }else{
                alert("Please complete the information!");
              }
            });
         },
         handlerCookie(){
          this.CookieUtil={
            get:function(name){
              var cookieName=encodeURIComponent(name)+'=',
              cookieStart=document.cookie.indexOf(cookieName),
              cookieValue=null;
              if(cookieStart>-1){
                var cookieEnd=document.cookie.indexOf(';',cookieStart);
                if(cookieEnd==-1){
                  cookieEnd=document.cookie.length;
                }
                cookieValue=document.cookie.substring(cookieStart+cookieName.length,cookieEnd)
              }
              return cookieValue;
            },
            set:function(name,value,expires,path,domain,secure){
              var cookieText=encodeURIComponent(name)+'='+encodeURIComponent(value);
              if(expires instanceof Date){
                cookieText+='; expires='+expires.toUTCString();
              }
              if(path){
                cookieText+='; path='+path
              }
              if(domain){
                cookieText+='; domain='+domain;
              }
              if(secure){
                cookieText+='; secure'
              }
              document.cookie=cookieText;
            },
            unset:function(name,path,domain,secure){
              this.set(name,'',new Date(0),path,domain,secure);
            }
          }
         }
      },
      beforeCreate(){
        CheckedLoginHTTP().then(data=>{
          if(data.logincheck){
            this.$router.push({name:'loginSuccess'});
          }else{
            this.$router.push({name:'loginStart'});
          }
        });
      },
      created(){
        //this.CheckLoginState();
        this.handlerCookie();
        this.SignIn.userName=this.CookieUtil.get('userName');
        this.SignIn.userPwd=this.CookieUtil.get('password');
      }
   }
</script>
<style lang="less" scoped>
  @import "../../style/login/loginStart.less";
</style>










