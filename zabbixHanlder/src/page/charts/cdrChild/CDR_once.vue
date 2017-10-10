<template>
  <div class="contentBContent">
    <div class="CDRContentHeader">
      <div class="CDRContentRow">
        <span>CID</span>
        <input type="text" v-model="OnceForm.CID" />
      </div>
      <div class="CDRContentRow">
        <span>PID</span>
        <input type="text" v-model="OnceForm.PID" />
      </div>
      <div class="CDRContentRow">
        <span>MID</span>
        <input type="text" v-model="OnceForm.MID" />
      </div>
      <div class="CDRContentRow">
        <span>YEAR</span>
        <input type="text" v-model="OnceForm.YEAR" />
      </div>
      <div class="CDRContentRow">
        <span>MONTH</span>
        <input type="text" v-model="OnceForm.MONTH" />
      </div>
      <div class="CDRContentRow">
        <span>TYPE</span>
        <input type="text" v-model="OnceForm.TYPE" />
      </div>
      <div class="CDRContentButton">
        <button :loading="isLoading" @click="searchClick">查询</button>
      </div>
    </div>
    <div class="CDRContentContent" v-show="isHaveData">
      <div class="DataHeader">
        <h1>查询结果</h1>
      </div>
      <div class="DataContent">
        <ul>
          <li>CID</li>
          <li>PID</li>
          <li>MID</li>
          <li>YEAR</li>
          <li>MONTH</li>
          <li>TYPE</li>
          <li>visit_time</li>
        </ul>
        <div class='tableContainer'>
          <table cellpadding="0" cellspacing="0">
            <tr v-for='content in data'>
              <td v-text='content.cid'></td>
              <td v-text='content.pid'></td>
              <td v-text='content.mid'></td>
              <td v-text='content.year'></td>
              <td v-text='content.month'></td>
              <td v-text='content.type'></td>
              <td v-text='content.visit_time'></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import $ from 'jquery'
import {LoginHTTP,cdrDataHTTP} from '../../../api/http'
export default{
  data(){
    return{
      data:[],
      isLoading:false,
      isHaveData:false,
      OnceForm:{
        CID:'',
        PID:'',
        MID:'',
        YEAR:'',
        MONTH:'',
        TYPE:'LIVE'
      },
      OnceFormHTTP:{
        name:'cdr',
        cid:'',
        pid:'',
        mid:'',
        year:'',
        month:'',
        type:'LIVE',
        sessionid:''
      }
    }
  },
  methods:{
    searchClick(){
      if(this.OnceForm.TYPE==''){
        alert("请填写TYPE信息！");
      }else{
        this.isLoading=true;
        this.checkParamsFormat(this.OnceForm);
        cdrDataHTTP(this.OnceFormHTTP).then(data=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            if(data!=null){
              this.isHaveData=true;
              this.data=[data];
            }
          }
        });
      }
    },
    checkParamsFormat(obj){
      for(let key in obj){
        this.OnceFormHTTP[key.toLowerCase()]=obj[key]
      }
    }
  },
  created(){
    LoginHTTP().then(data=>{
      if(data.return==false){
        window.location.href='http://113.106.250.156:8000/zabbix/index.php';
      }else{
        this.OnceFormHTTP.sessionid=data.return;
        this.OnceForm.YEAR=(new Date().getFullYear());
      }
    });
  }
}
</script>
<style lang="less" scoped>
  @import '../../../style/charts/cdrChild/CDR.less';
</style>





















