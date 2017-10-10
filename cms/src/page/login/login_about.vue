<template>
  <div id="loginAbout">
    <div class="loginSignMsg" v-for="data in signArr">
      <div class="signMsgName" v-text="data.msgName"></div>
      <div class="signMsgValue" v-text="data.msgValue"></div>
    </div>
    <router-link to="loginSuccess" class="returnSuccess">Return</router-link>
  </div>
</template>
<script>
import {CheckedLoginHTTP} from '../../api/http'
  export default{
    data(){
      return {
        signArr:[
          {msgName:"Current versions",msgValue:"704"},
          {msgName:"Update time",msgValue:"2016-11-28"},
          {msgName:"Deadline",msgValue:"2018-8-6"},
          {msgName:"User Count",msgValue:"1000"}
        ]
      }
    },
    beforeCreate(){
      CheckedLoginHTTP().then(data=>{
        if(!data.logincheck){
          this.$router.push({name:'loginStart'});
        }
      });
    }
  }
</script>
<style lang="less" scoped>
  @import "../../style/login/loginAbout.less";
</style>


















