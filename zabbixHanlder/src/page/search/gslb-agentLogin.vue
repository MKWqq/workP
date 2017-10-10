<template>
  <LoginComponent v-on:sendLogin="sendLoginAjax" :isSelect="SelectEle" :Loading='isLoading' :Prompt="missPrompt"></LoginComponent>
</template>
<script>
  import {GslbAgentLoginHTTP} from '../../api/http'
  import LoginComponent from '../../components/LoginComponent'
  export default{
    data(){
      return{
        missPrompt:false,
        isLoading:false,
        SelectEle:true
      }
    },
    components:{'LoginComponent':LoginComponent},
    methods:{
      sendLoginAjax(value){
        this.isLoading=true;
        GslbAgentLoginHTTP(value).then(data=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            this.isLoading=false;
            if(data.result){
              this.$router.push('/gslb-agent/Content');
            }else{
              this.missPrompt=true;
            }
          }
        });
      }
    }
  }
</script>
<style lang="less" scoped></style>















