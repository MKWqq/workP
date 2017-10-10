<template>
  <div class="Content">
    <div class="ContentTop">
      <div class="channelType">
        <div class="VODChannel" @click="VODClick">
          <img v-show="IsVODChecked" src='../../assets/img/program_highlight.png' />
          <img v-show="!IsVODChecked" src='../../assets/img/program_normal.png' />
          <span>VOD</span>
        </div>
        <div class="IPTVChannel" @click="IPTVClick">
          <img v-show="!IsVODChecked" src='../../assets/img/program_highlight.png' />
          <img v-show="IsVODChecked" src='../../assets/img/program_normal.png' />
          <span>IPTV</span>
        </div>
      </div>
      <ul class="distributeType">
        <li @click="DistributeClick" data-msg='all'>总排行榜</li>
        <li @click="DistributeClick" data-msg='month'>月排行榜</li>
        <li @click="DistributeClick" data-msg='day'>日排行榜</li>
        <li @click="DistributeClick" data-msg='week'>周排行榜</li>
        <li @click="ScanClick" style="color:#448aca;font-weight:bold;">分类查看</li>
      </ul>
      <headerButton v-show="isExportShow" class="exportButton" :BtnArray="HeaderBtnArray" v-on:exportExcel="showExportContainer"></headerButton>
      <div class="searchBlock" v-show="!isExportShow" v-if="isSearchYear">
        <span class="demonstration">选择年份</span>
        <el-date-picker class="chooseYear" @change="sendAjax" v-model="searchYear" align="right" type="year" placeholder="选择年"></el-date-picker>
      </div>
    </div>
    <div class="ContentBottom" v-show="isHaveData">
      <table v-show="!isScanData" cellpadding='0' cellspacing='0'>
        <tr>
          <th>Top</th>
          <th>Category</th>
          <th>Pid</th>
          <th>Name</th>
          <th>Play Times</th>
          <th>Trend</th>
        </tr>
        <tr v-for="content in data_one">
          <td v-text='content.top'></td>
          <td v-text='content.category'></td>
          <td v-text='content.pid'></td>
          <td v-text='content.name'></td>
          <td v-text='content.play_times'></td>
          <td>
            <img v-show='content.trend==0' src='../../assets/img/icon_down.png' />
            <img v-show='content.trend==1' src='../../assets/img/icon_up.png' />
          </td>
        </tr>
      </table>
      <table v-show="!isScanData" cellpadding='0' cellspacing='0'>
        <tr>
          <th>Top</th>
          <th>Category</th>
          <th>Pid</th>
          <th>Name</th>
          <th>Play Times</th>
          <th>Trend</th>
        </tr>
        <tr v-for="content in data_two">
          <td v-text='content.top'></td>
          <td v-text='content.category'></td>
          <td v-text='content.pid'></td>
          <td v-text='content.name'></td>
          <td v-text='content.play_times'></td>
          <td>
            <img v-show='content.trend==0' src='../../assets/img/icon_down.png' />
            <img v-show='content.trend==1' src='../../assets/img/icon_up.png' />
          </td>
        </tr>
      </table>
      <table v-show="isScanData" cellpadding="0" cellspacing="0" class="scanPart">
        <tr>
          <th>分类</th>
          <th @click="sortArray">节目总数</th>
          <th @click="sortArray">年总访问量</th>
          <th>1月</th>
          <th>2月</th>
          <th>3月</th>
          <th>4月</th>
          <th>5月</th>
          <th>6月</th>
          <th>7月</th>
          <th>8月</th>
          <th>9月</th>
          <th>10月</th>
          <th>11月</th>
          <th>12月</th>
          <th @click="sortArray">月均量</th>
          <th @click="sortArray">日均量</th>
          <th @click="sortArray">月最高</th>
        </tr>
        <tr v-for="content in data_scan">
          <td><button @click="showDetails" v-text="content.language"></button></td>
          <td v-text="content.all_pro"></td>
          <td v-text="content.all_count"></td>
          <td v-text="content['0'].views"></td>
          <td v-text="content['1'].views"></td>
          <td v-text="content['2'].views"></td>
          <td v-text="content['3'].views"></td>
          <td v-text="content['4'].views"></td>
          <td v-text="content['5'].views"></td>
          <td v-text="content['6'].views"></td>
          <td v-text="content['7'].views"></td>
          <td v-text="content['8'].views"></td>
          <td v-text="content['9'].views"></td>
          <td v-text="content['10'].views"></td>
          <td v-text="content['11'].views"></td>
          <td v-text="content.month_avg"></td>
          <td v-text="content.day_avg"></td>
          <td v-text="content.max_month"></td>
        </tr>
      </table>
    </div>
    <SNButton v-show="isHaveData" :activePage="page" class="ContentButton" :maxPage="pageAll" v-on:sendNewAjax="changePage"></SNButton>
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
          <el-button @click="isDataExport=false" class="CancelButton">取消</el-button>
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
import {LoginHTTP,ScanHTTP,RankingDataHTTP} from '../../api/http'
export default{
  data(){
    return {
      sessionid:'',
      detailName:'',
      searchYear:'',
      data_one:[],
      data_two:[],
      data_scan:[],
      isExportShow:false,
      isHaveData:false,
      isDataExport:false,//显示导出Excel页面
      IsVODChecked:true,
      isDataExport:false,
      isScanData:true,
      isSearchYear:true,
      countSort:1,
      dateStart:'',
      dateEnd:'',
      exportExcelHref:'javascript:void(0);',
      channelType:'vod',
      period:'all',
      columnArray:'',
      pageAll:1,
      page:1,
      HeaderBtnArray:{HeaderBtnMsg:['导出Excel'],HeaderBtnClick:['exportExcel']},
      pickerOptions0: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        }
      }
    }
  },
  components:{'SNButton':SNButton,'headerButton':headerButton},
  methods:{
    searchClick(){},
    sortArray(event){
        const e=$(event.srcElement || event.target);
        this.countSort=this.countSort*-1;
        if(e.text()=='节目总数'){
            this.columnArray='program';
        }
        else if(e.text()=='年总访问量'){
            this.columnArray='views';
        }
        else if(e.text()=='月均量'){
            this.columnArray='views';
        }
        else if(e.text()=='日均量'){
            this.columnArray='views';
        }
        this.sendAjax();
    },
    sortFunc(sortColumn){
        const order=this.countSort||1;
        this.data_scan.sort(function(data1,data2){
            if(Number(data1[sortColumn])-Number(data2[sortColumn])<0){
                return -1*order;
            }else if(Number(data1[sortColumn])-Number(data2[sortColumn])>0){
                return 1*order;
            }else{
                return 0*order;
            }
        });
    },
    changePage(Page){
      this.page=Page;
      this.sendAjax();
    },
    VODClick(){
      this.channelType='vod';
      this.IsVODChecked=true;
      this.sendAjax();
    },
    IPTVClick(){
      this.channelType='iptv';
      this.IsVODChecked=false;
      this.sendAjax();
    },
    DistributeClick(event){
      let e=event.target||event.srcElement;
      this.isExportShow=true;
      this.isSearchYear=false;
      this.page=1;
      this.isScanData=false;
      this.checkdCss(e);
      this.period=$(e).attr('data-msg');
      this.sendAjax();
    },
    ScanClick(event){
      let e=event.target||event.srcElement;
      this.isExportShow=false;
      this.isScanData=true;
      this.isSearchYear=true;
      this.page=1;
      this.sendAjax();
      this.checkdCss(e);
    },
    sendSearchAjax(){},
    showDetails(event){
      const e=event.target||event.srcElement;
      this.detailName=$(e).text();
      this.$router.push({name:'details',params:{detail:this.detailName+'_'+(this.channelType=='iptv'?'LIVE':'VOD')+'_'+this.searchYear.getFullYear()}});
    },
    showExportContainer(){
      this.dateStart='';
      this.dateEnd='';
      this.isDataExport=true;
    },
    exportClick(){
      if(this.dateStart==''||this.dateStart==undefined||this.dateStart==null||this.dateEnd==''||this.dateEnd==undefined||this.dateEnd==null){
        alert('请选择时间');
      }else{
        this.exportExcelHref='http://171.221.202.190:11111/phpexcel/export.php?type='+this.channelType+'&start='+this.ExportDateFormat(this.dateStart)+'&end='+this.ExportDateFormat(this.dateEnd)+'&sessionid='+this.sessionid;
        this.isDataExport=false;
      }
    },
    ExportDateFormat(ExportDate){
      return ExportDate.getFullYear()+'-'+(ExportDate.getMonth()+1)+'-'+ExportDate.getDate();
    },
    checkdCss(targetObj){
      $(targetObj).css({'color':'#448aca','font-weight':'bold'});
      $(targetObj).siblings().css({'color':'','font-weight':''});
/*      let LiArr=$('.distributeType li');
      for(let i=0,len=LiArr.length;i<len;i++){
        if(targetObj==LiArr[i]){
          $(LiArr[i]).css({'color':'#448aca','font-weight':'bold'});
        }else{
          $(LiArr[i]).css({'color':'','font-weight':''});
        }
      }*/
    },
    sendAjax(){
        if(!this.isScanData){
          RankingDataHTTP({sessionid:this.sessionid,page:this.page,period:this.period,type:this.channelType}).then(data=>{
            if('loginCheck' in data){
              window.location.href='http://113.106.250.156:8000/zabbix/index.php';
            }else{
              this.data_one=[];
              this.data_two=[];
              data.rows.forEach((value,index)=>{
                if(index<=11){
                  this.data_one.push(value);
                }else{
                  this.data_two.push(value);
                }
              });
              this.pageAll=data.total;
              this.isHaveData=true;
            }
          });
        }else{
            if(this.columnArray){
              ScanHTTP({sessionid:this.sessionid,sort:this.columnArray,order:this.countSort>0?'asc':'desc',year:this.searchYear.getFullYear(),page:this.page,type:(this.channelType=='iptv'?'LIVE':'VOD')}).then((data)=>{
                if(data.data.length!=0){
                  this.isHaveData=true;
                  this.data_scan=data.data;
                  this.pageAll=data.maxpage;
                }else{
                  this.isHaveData=false;
                  alert('此年份无数据！')
                }
              });
            }
            else{
              ScanHTTP({sessionid:this.sessionid,year:this.searchYear.getFullYear(),page:this.page,type:(this.channelType=='iptv'?'LIVE':'VOD')}).then((data)=>{
                if(data.data.length!=0){
                  this.isHaveData=true;
                  this.data_scan=data.data;
                  this.pageAll=data.maxpage;
                }else{
                  this.isHaveData=false;
                  alert('此年份无数据！')
                }
              });
            }
        }
    }
  },
  created(){
    LoginHTTP().then(data=>{
      if(data.return==false){
        window.location.href='http://113.106.250.156:8000/zabbix/index.php';
      }else{
        this.sessionid=data.return;
        if(this.searchYear==''||this.searchYear==null||this.searchYear!=undefined){
            this.searchYear=new Date();
        }
        this.sendAjax();
      }
    });
  }/*,
  beforeRouteUpdate(to,from,next){
      console.log(from.path);
      console.log(1)
  }*/
}
</script>
<style lang="less" scoped>
  @import '../../style/charts/program_ranking.less';
</style>











