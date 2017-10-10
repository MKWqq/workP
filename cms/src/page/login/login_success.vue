<template>
  <div id="loginSucess">
    <div class="systemImg">
      <img src="../../assets/img/sign_in/home_system.png" />
    </div>
    <div class="UserProductImg">
      <img src="../../assets/img/sign_in/home_userproduct.png" />
    </div>
    <div class="contentImg">
      <img src="../../assets/img/sign_in/home_content.png" />
    </div>
    <div class="operationImg">
      <img src="../../assets/img/sign_in/home_operation.png" @click='changeRouter' />
    </div>
  </div>
</template>
<script>
import {CheckedLoginHTTP} from '../../api/http'
import {mapActions} from 'vuex'
import {mapState} from 'vuex'
import $ from 'jquery'
  export default {
    data(){
      return {}
    },
    methods:{
      ...mapActions(['CheckLoginState']),
      changeRouter(){
        this.$router.push({name:'content'});
      }
    },
    created(){
      this.CheckLoginState();
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
  @import "../../style/login/loginSuccess.less";
</style>












