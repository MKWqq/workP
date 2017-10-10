<template>
  <div class="ContentBottom">
    <div class="contentBHeader">
      <button @click="onceClick">单次查询</button>
      <button @click="ALLClick">批量查询</button>
    </div>
    <router-view></router-view>
  </div>
</template>
<script>
import $ from 'jquery'
import {LoginHTTP} from '../../../api/http'
export default{
  data(){
    return {
      sessionid:''
    }
  },
  methods:{
    clearCss(target){
      if(target==undefined){
        $('.contentBHeader button').css({'color':'','background':'','border':''})
      }else{
        for(let i=0,len=$('.contentBHeader button').length;i<len;i++){
          if(target==$('.contentBHeader button')[i]){
            $($('.contentBHeader button')[i]).css({'color':'#fff','background':'#448aca','border':'1px solid transparent'})
          }else{
            $($('.contentBHeader button')[i]).css({'color':'','background':'','border':''})
          }
        }
      }
    },
    onceClick(event){
      let e=event.target||event.srcElement;
      this.clearCss(e);
      this.$router.push({name:'once'});
    },
    ALLClick(event){
      let e=event.target||event.srcElement;
      this.clearCss(e);
      this.$router.push({name:'ALL'});
    }
  },
  created(){
    LoginHTTP().then(data=>{
      if(data.return==false){
        window.location.href='http://113.106.250.156:8000/zabbix/index.php';
      }else{
        this.sessionid=data.return;
      }
    });
  }
}
</script>
<style lang="less" scoped>
  @import '../../../style/charts/cdrChild/CDR.less';
</style>








