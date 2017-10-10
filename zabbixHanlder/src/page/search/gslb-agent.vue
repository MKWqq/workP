<template>
  <div class="Content">
    <div class="ContentTop">
      <div class="ContentInputRow">
        <span class="demonstration">选择日期：</span>
        <el-date-picker v-model="DateHTTP" type="date" placeholder="选择日期" :picker-options="pickerOptions0">
        </el-date-picker>
      </div>
      <div class="searchButton">
        <el-form>
          <el-form-item>
            <el-button :loading="isLoading" @click="searchClick" class="searchButton">搜索</el-button>
          </el-form-item>
        </el-form>
      </div>
      <headerButton :BtnArray="HeaderBtnArray" buttonClass='oneButton' v-on:exportExcel="isDataExport=true"></headerButton>
    </div>
    <div class="ContentBottom" v-show="isHaveData">
      <table>
        <tr>
          <th>id</th>
          <th>client_sn</th>
          <th>client_ip</th>
          <th>channel_name</th>
          <th>token</th>
          <th>user_agent</th>
          <th>login_time</th>
          <th>hls_ip</th>
          <th>hlc_ip</th>
        </tr>
        <tr v-for="(content,index) in data">
          <td v-text="content.id"></td>
          <td v-text="content.client_sn"></td>
          <td v-text="content.client_ip"></td>
          <td v-text='content.channel_name'></td>
          <td>
            <span v-text='content.token' :data-id="content.id" @mouseover="tokenDetailOver" @mouseout="tokenDetailOut" @click="tokenDetailClick" class="token"></span>
          </td>
          <td v-text='content.user_agent'></td>
          <td v-text='content.login_time'></td>
          <td v-text='content.hls_ip'></td>
          <td v-text='content.hlc_ip'></td>
        </tr>
      </table>
      <div :style="{top:tokenDetailTop+'px'}" v-show="isTokenDetail" class="tokenDetailContainer">
        <div v-text="detailMsg" class="tokenDetail"></div>
        <img src="../../assets/img/icon_guanbi.png" @click="closeTokenDetailImg" />
      </div>
    </div>
    <SNButton v-show="isHaveData" class="ContentButton" :maxPage="pageAll" v-on:sendNewAjax="changePage"></SNButton>
    <div class="dataExport" v-show="isDataExport">
      <div class="dataExportContainer">
        <div class="dataExportHeader">
          <h1>数据导出</h1>
        </div>
        <div class="dataExportContent">
          <div class="block">
            <span class="demonstration">请选择开始日期:</span>
            <el-date-picker class="dateInput" v-model="dateStart" type="date" placeholder="选择日期" :picker-options="pickerOptions0"></el-date-picker>
          </div>
          <div class="block">
            <span class="demonstration">请选择结束日期:</span>
            <el-date-picker class="dateInput" v-model="dateEnd" type="date" placeholder="选择日期" :picker-options="pickerOptions0"></el-date-picker>
          </div>
        </div>
        <div class="dataExportFooter">
          <el-button @click="isDataExport=false" class="ScanChartButton">取消</el-button>
          <a @click="exportClick" :href="exportExcelHref" class="ExportExcelButton">确定</a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import $ from 'jquery'
import SNButton from '../../components/button/button'
import headerButton from '../../components/featureButton'
import {GslbAgentHTTP,LoginHTTP,GslbLoginCheckHTTP} from '../../api/http'
export default{
  data(){
    return{
      sessionid:'',
      data:[],
      detailMsg:'',
      isTokenDetail:false,
      isTokenDetailClick:false,
      tokenDetailTop:0,
      isLoading:false,
      isHaveData:false,
      isDataExport:false,
      dateStart:'',
      dateEnd:'',
      exportExcelHref:'javascript:void(0);',
      DateHTTP:'',
      HeaderBtnArray:{HeaderBtnMsg:['导出Excel'],HeaderBtnClick:['exportExcel']},
      page:1,
      pageAll:1,
      pickerOptions0: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        }
      }
    }
  },
  components:{'SNButton':SNButton,'headerButton':headerButton},
  methods:{
    exportClick(){
      if(this.dateStart==''||this.dateStart==undefined||this.dateStart==null||this.dateEnd==''||this.dateEnd==undefined||this.dateEnd==null){
        alert('请选择时间');
      }else{
        this.exportExcelHref='http://171.221.202.190:11111/yunwei/index.php/gslbagent/export/timestar/'+this.DateFormat(this.dateStart)+'/timeend/'+this.DateFormat(this.dateEnd)+'/sessionid/'+this.sessionid;
        this.isDataExport=false;
      }
    },
    changePage(page){
      this.page=page;
      this.sendAjax();
    },
    tokenDetailOver(event){
      if(this.isTokenDetailClick){
        return;
      }
      this.isTokenDetail=true;
      const e=$(event.target || event.srcElement);
      this.showTokenDetailMsg(e,event);
    },
    tokenDetailOut(){
      if(this.isTokenDetailClick){
        return;
      }
      this.isTokenDetail=false;
    },
    tokenDetailClick(event){
      const e=$(event.target||event.srcElement);
      this.isTokenDetailClick=true;
      this.isTokenDetail=true;
      this.closeTokenDetail();
      this.showTokenDetailMsg(e,event);
    },
    showTokenDetailMsg(e,eventToken){
      this.data.forEach((value,index)=>{
        if(value.id==e.attr("data-id")){
          this.detailMsg=value.token;
        }
      });
      if(eventToken.clientY>=700){
        this.tokenDetailTop=eventToken.clientY-188-50-8;
      }else{
        this.tokenDetailTop=eventToken.clientY-188+10;
      }
    },
    closeTokenDetailImg(){
      this.isTokenDetail=false;
      this.isTokenDetailClick=false;
    },
    searchClick(){
      if(this.DateHTTP==''||this.DateHTTP==undefined||this.DateHTTP==null){
        alert('请选择日期');
      }else{
        this.page=1;
        this.isLoading=true;
        this.sendAjax();
      }
    },
    sendAjax(){
      GslbAgentHTTP({time:this.DateFormat(this.DateHTTP),page:this.page,sessionid:this.sessionid}).then(data=>{
        if('loginCheck' in data){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          this.isLoading=false;
          if(data.value.length==0){
            this.isHaveData=false;
            alert("无数据");
          }else{
            this.pageAll=data.limit.pageall;
            this.isHaveData=true;
            this.data=data.value;
          }
        }
      })
    },
    DateFormat(date){
      return date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();
    },
    closeTokenDetail(){
      $(document).click((event)=>{
        const e=event.srcElement||event.target;
        const checkedEle1=$($('.tokenDetailContainer')[0]);
        const checkedEle2=$('.token');
        if(!checkedEle1.is(e.className?'.'+e.className:e) && (checkedEle1.has(e).length===0) && !checkedEle2.is(e.className?'.'+e.className:e)){
          this.closeTokenDetailImg();
        }
      });
    }
  },
  created(){
    LoginHTTP().then(data=>{
      if(data.return==false){
        window.location.href='http://113.106.250.156:8000/zabbix/index.php';
      }else{
        this.sessionid=data.return;
        GslbLoginCheckHTTP({sessionid:this.sessionid}).then(data=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            if(data.result==false){
              this.$router.push('/gslb-agent');
            }
          }
        });
      }
    });
  }
}
</script>
<style lang='less' scoped>
  @import '../../style/search/gslb-agent.less';
</style>









