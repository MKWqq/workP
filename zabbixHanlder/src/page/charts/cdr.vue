<template>
  <div class="Content">
    <div class="ContentTop">
      <div class="ContentInputRow">
        <div @click="CDNClick">CDR访问量</div>
      </div>
      <div class="ContentInputRow">
        <div @click="SNClick">SN查询</div>
      </div>
      <div class="ContentInputRow">
        <div @click="TVClick">TV|VOD查询</div>
      </div>
      <div class="ContentInputRow">
        <div @click="TokenClick">非法token查询</div>
      </div>
    </div>
    <router-view></router-view>
    <div class="promptError" v-show="isPromptError">请填写完整信息！</div>
  </div>
</template>
<script>
import $ from 'jquery'
import {LoginHTTP} from '../../api/http'
export default{
  data(){
    return {
      sessionid:'',
      isPromptError:false,
    }
  },
  methods:{
    clearCss(target){
      if(target==undefined){
        $('.ContentInputRow div').css({'color':''})
      }else{
        for(let i=0,len=$('.ContentInputRow div').length;i<len;i++){
          if(target[0]==$('.ContentInputRow div')[i]){
            $($('.ContentInputRow div')[i]).css({'color':'#448aca'})
          }else{
            $($('.ContentInputRow div')[i]).css({'color':''})
          }
        }
      }
    },
    CDNClick(event){
      let e=$(event.target||event.srcElement);
      this.clearCss(e);
      this.$router.push({name:'CDR'});
    },
    SNClick(event){
      let e=$(event.target||event.srcElement);
      this.clearCss(e);
      this.$router.push({name:'SN'});
    },
    TVClick(event){
      let e=$(event.target||event.srcElement);
      this.clearCss(e);
      this.$router.push({name:'TV'});
    },
    TokenClick(event){
      let e=$(event.target||event.srcElement);
      this.clearCss(e);
      this.$router.push({name:'TOKEN'});
    }
  },
  watch:{
    $route(newValue){
      if(newValue.path=='/cdr'){
        this.clearCss();
      }
    }
  },
  created(){
    LoginHTTP().then(data=>{
      if(data.return==false){
        window.location.href='http://113.106.250.156:8000/zabbix/index.php';
      }else{
        this.sessionid=data.return;
        this.clearCss();
      }
    });
  }
}
</script>
<style lang="less" scoped>
  @import '../../style/charts/cdr.less';
</style>



















