<template>
  <LoginComponent v-on:sendLogin="sendLoginAjax" :isSelect="SelectEle" :Loading='isLoading' :Prompt="missPrompt"></LoginComponent>
</template>
<script>
  import {ippoolLoginHTTP} from '../../api/http'
  import LoginComponent from '../../components/LoginComponent'
  export default{
    data(){
      return{
        missPrompt:false,
        isLoading:false,
        SelectEle:false
      }
    },
    components:{'LoginComponent':LoginComponent},
    methods:{
      sendLoginAjax(value){
        this.isLoading=true;
        ippoolLoginHTTP(value).then(data=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            this.isLoading=false;
            if(data.result){
              this.$router.push('/ippool/Content');
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















