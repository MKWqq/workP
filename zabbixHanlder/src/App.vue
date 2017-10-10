<template>
  <div id="app" v-bind:style="{height:AppHeight+'px'}">
    <div id='Header'>
      <div class="HeaderText">
        <p>ZABBIX--操作</p>
        <p v-text="navText" class="NavText" v-show="navText!=''"></p>
      </div>
    </div>
    <div id='Main'>
      <div id='MainHeader'>
        <div class="searchContainer" @mouseover="searchNavShow" @mouseout="searchNavHidden">
          <div class="ChildNavShow">查询类</div>
          <ul class="ChildNav" v-show="isSearchNav">
            <li @click="chooseChildNav" v-for="navMsg in navData.searchNav" v-text="navMsg"></li>
          </ul>
        </div>
        <div class="gslbContainer" @mouseover="gslbNavShow" @mouseout="gslbNavHidden">
         <div class="ChildNavShow">gslb</div>
         <ul class="ChildNav" v-show="isGslbNav">
           <a href="http://171.221.202.190:11111/world/Applications/web/index.php?ddreset=1" target='_Blank'>gslb1</a>
           <a href="http://171.221.202.190:11111/world/Applications/web/index1.php?ddreset=1" target='_Blank'>gslb2</a>
         </ul>
        </div>
        <div class="chartsContainer" @mouseover="chartsNavShow" @mouseout="chartsNavHidden">
         <div class="ChildNavShow">图表类</div>
         <ul class="ChildNav" v-show="isChartsNav">
           <li @click="chooseChildNav" v-for="navMsg in navData.chartsNav" v-text="navMsg"></li>
           <a href="http://171.221.202.190:11111/worldmap/getworldgo.php?ddreset=1" target='_Blank'>gcms</a>
         </ul>
        </div>
        <div class="reportContainer" v-show='false' @mouseover="reportNavShow" @mouseout="reportNavHidden">
         <div class="ChildNavShow">The report</div>
         <ul class="ChildNav" v-show="isReportNav">
           <a href="http://171.221.202.190:11111/zabbix/box/?ddreset=1#/boxData" target='_Blank'>The box online data</a>
           <a href="http://171.221.202.190:11111/zabbix/program/?ddreset=1#/program" target='_Blank'>Report form</a>
           <a href="http://171.221.202.190:11111/zabbix/report/index.html?ddreset=1#/report" target='_Blank'>Program report</a>
         </ul>
        </div>
        <router-link to="/serverPath" class="serverContainer">服务器记录</router-link>
      </div>
      <div id='Content'>
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>
<script>
import $ from "jquery"
import {LoginHTTP} from './api/http'
  export default{
    data(){
      return {
        isSearchNav:false,
        isGslbNav:false,
        isChartsNav:false,
        isReportNav:false,
        AppHeight:"",
        navText:'',
        navData:{
          searchNav:["SN","ippool","gslb-agent"],
          chartsNav:["cdn",'program_ranking','export','Acquisition program',
          'cdr','channel'
          ]
        }
      }
    },
    methods:{
      searchNavShow(){
        this.isSearchNav=true;
      },
      searchNavHidden(){
        this.isSearchNav=false;
      },
      gslbNavShow(){
        this.isGslbNav=true;
      },
      gslbNavHidden(){
        this.isGslbNav=false;
      },
      chartsNavShow(){
        this.isChartsNav=true;
      },
      chartsNavHidden(){
        this.isChartsNav=false;
      },
      reportNavShow(){
        this.isReportNav=true;
      },
      reportNavHidden(){
        this.isReportNav=false;
      },
      chooseChildNav(event){
        let e=event.target || event.srcElement;
        this.navText=$(e).text();
        this.$router.push('/'+this.navText);
        //if(this.navText=='The box online data'){
          //window.open('http://171.221.202.190:11111/zabbix/box/?ddreset=1#/boxData');
        //}
      }
    },
    created(){
      this.AppHeight=$(window).height();
      LoginHTTP().then(data=>{
        if(data.return==false){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }
      });
    }
}
</script>
<style lang="less">
  @import './style/App.less';
</style>

