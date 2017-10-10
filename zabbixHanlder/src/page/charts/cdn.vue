<template>
  <div class="Content">
    <div class="ContentTop">
      <div class="ContentInputRow">
        <span class="demonstration">选择日期：</span>
        <el-date-picker v-model="DateHTTP" class="dateInput" type="date" placeholder="选择日期" :picker-options="pickerOptions0">
        </el-date-picker>
      </div>
      <div class="searchButton">
        <el-button :loading="isLoading" @click="searchClick" class="searchButton">搜索</el-button>
      </div>
      <headerButton :BtnArray="HeaderBtnArray" v-on:today="todayClick" v-on:exportExcel="isDataExport=true"></headerButton>
    </div>
    <div class="ContentBottom">
      <div id="chartsContainer" style="width:1215;height:731px;"></div>
      <div class="chartsDescription">
        <div class="DescriptionT">
          <table>
            <tr>
              <th>Index</th>
              <th>CDN</th>
              <th>IP</th>
              <th>Record Time</th>
            </tr>
            <tr v-for="(description,index) in descriptionData">
              <td v-text="index"></td>
              <td v-text="description.cdn"></td>
              <td v-text="description.ip"></td>
              <td v-if="description.time!=''" :class="{'NoUpdate':!description.state}" v-text="description.time"></td>
              <td v-else v-text="无数据" class="NoData"></td>
            </tr>
          </table>
        </div>
        <div class="DescriptionB">
          <div class="DescriptionBL">表示数据无更新</div>
          <div class="DescriptionBR">表示无数据</div>
        </div>
      </div>
    </div>
    <div class="dataExport" v-show="isDataExport">
      <div class="dataExportContainer">
        <div class="dataExportHeader">
          <h1>数据导出</h1>
          <img src="../../assets/img/icon_guanbi.png" @click="isDataExport=false" />
        </div>
        <div class="dataExportContent">
          <div class="block">
            <span class="demonstration">请选择开始日期:</span>
            <el-date-picker class="dateInput" v-model="dateStart" type="date" placeholder="选择日期" :picker-options="pickerOptions1"></el-date-picker>
          </div>
          <div class="block">
            <span class="demonstration">请选择结束日期:</span>
            <el-date-picker class="dateInput" v-model="dateEnd" type="date" placeholder="选择日期" :picker-options="pickerOptions1"></el-date-picker>
          </div>
        </div>
        <div class="dataExportFooter">
          <a @click="exportClick" :href="exportExcelHref" class="ExportExcelButton">导出Excel</a>
          <el-button :loading="isScanLoading" @click="ScanChartClick" class="ScanChartButton">查看图形</el-button>
        </div>
      </div>
    </div>
    <div class="ScanChart" v-show="isScanChart">
      <div class="ScanChartContainer">
        <div class="ScanChartHeader">
          <h1>CDN访问总曲线图</h1>
          <a @click="exportClick" :href="exportExcelHref" class="ScanExportButton">导出Excel</a>
          <img src="../../assets/img/icon_guanbi.png" @click="isScanChart=false" />
        </div>
        <div id="ScanCharts" style="width:968px;height:536px;"></div>
      </div>
    </div>
  </div>
</template>
<script>
import $ from 'jquery'
import echarts from 'echarts'
import headerButton from '../../components/featureButton'
import {LoginHTTP,CDNDataHTTP,CDNExportExcelHTTP,CDNScanChartHTTP} from '../../api/http'
export default {
  data(){
    return{
      sessionid:'',
      isLoading:false,
      isExportLoading:false,
      isScanLoading:false,
      isDataExport:false,
      isScanChart:false,
      dateStart:'',
      dateEnd:'',
      exportExcelHref:'javascript:void(0);',
      DateHTTP:"",
      DateFormat:'',
      DateName:'',
      descriptionData:[],
      exportChartData:{},
      chartData:{http连接数量:[],http客户端数量:[],http中继数量:[],rudp连接数量:[],
                 rudp客户端数量:[],rudp中继数量:[],ALL:[] },
      timer1:null,
      timer2:null,
      HeaderBtnArray:{HeaderBtnMsg:['当天记录','导出数据'],HeaderBtnClick:['today','exportExcel']},
      pickerOptions0: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        }
      },
      pickerOptions1: {
        disabledDate(time) {
          return time.getTime() > Date.now()- 8.64e7;
        }
      }
    }
  },
  components:{'headerButton':headerButton},
  methods:{
    searchClick(){
      this.initChartDataArray();
      const todayDate=new Date().getFullYear()+'-'+(new Date().getMonth()+1)+'-'+new Date().getDate();
      clearInterval(this.timer1);
      if(this.DateHTTP!=''&&this.DateHTTP!=undefined&&this.DateHTTP!=null){
        this.changeDateFormat();
      }else{
        this.DateHTTP=new Date();
        this.changeDateFormat();
      }
      this.DateName='1';
      this.isLoading=true;
      this.sendMsgAjax();
      if(todayDate==this.DateFormat){
        this.timer1=setInterval(this.updateChartData,60000);
      }
    },
    updateChartData(){
      const NowMinutes=new Date().getMinutes();
      this.changeDateFormat();
      if(NowMinutes % 20==0){
        this.DateName='2';
        this.DateFormat=this.DateFormat+' '+new Date().getHours()+':'+NowMinutes;
        this.sendMsgAjax();
      }
    },
    todayClick(){
      this.DateHTTP=new Date();
      this.searchClick();
    },
    exportClick(){
      if(this.dateStart==''||this.dateStart==undefined||this.dateStart==null||this.dateEnd==''||this.dateEnd==undefined||this.dateEnd==null){
        alert('请选择时间');
      }else{
        this.exportExcelHref='http://171.221.202.190:11111/yunwei/index.php/cdn/export/timestar/'+this.ExportDateFormat(this.dateStart)+'/timeend/'+this.ExportDateFormat(this.dateEnd)+'/sessionid/'+this.sessionid;
        this.isDataExport=false;
        this.isScanChart=false;
      }
    },
    ScanChartClick(){
      if(this.dateStart==''||this.dateStart==undefined||this.dateStart==null||this.dateEnd==''||this.dateEnd==undefined||this.dateEnd==null){
        alert('请选择时间');
      }else{
        clearTimeout(this.timer2);
        this.isScanLoading=true;
        CDNScanChartHTTP({sessionid:this.sessionid,timestar:this.ExportDateFormat(this.dateStart),timeend:this.ExportDateFormat(this.dateEnd)}).then(data=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            this.isScanChart=true;
            this.timer2=setTimeout(()=>{
              this.exportChartData=data;
              this.isScanChart=true;
              this.isDataExport=false;
              this.drawExportLine('ScanCharts');
            },100);
            this.isScanLoading=false;
          }
        });
      }
    },
    ExportDateFormat(ExportDate){
      return ExportDate.getFullYear()+'-'+(ExportDate.getMonth()+1)+'-'+ExportDate.getDate();
    },
    changeDateFormat(){
      if(this.DateHTTP!=''&&this.DateHTTP!=undefined&&this.DateHTTP!=null){
        this.DateFormat=this.DateHTTP.getFullYear()+'-'+(this.DateHTTP.getMonth()+1)+'-'+this.DateHTTP.getDate();
      }
    },
    chartDataArray(dataObj){
      if(this.DateName=='2'){
        for(let keys in dataObj){
          if(this.chartData[keys].indexOf('-')>-1){
            this.chartData[keys].splice(this.chartData[keys].indexOf('-'),1,dataObj[keys]);
          }
        }
        this.drawLine('chartsContainer');
      }else{
        for(let keys in dataObj){
          for(let i=0;i<dataObj[keys].length;i++){
            this.chartData[keys].splice(i,1,dataObj[keys][i]);
          }
        }
        this.drawLine('chartsContainer');
      }
    },
    initChartDataArray(){
      this.chartData.http连接数量=[];
      this.chartData.http客户端数量=[];
      this.chartData.http中继数量=[];
      this.chartData.rudp连接数量=[];
      this.chartData.rudp客户端数量=[];
      this.chartData.rudp中继数量=[];
      this.chartData.ALL=[];
      for(let i=0;i<72;i++){
        this.chartData.http连接数量.push('-');
        this.chartData.http客户端数量.push('-');
        this.chartData.http中继数量.push('-');
        this.chartData.rudp连接数量.push('-');
        this.chartData.rudp客户端数量.push('-');
        this.chartData.rudp中继数量.push('-');
        this.chartData.ALL.push('-');
      }
    },
    sendMsgAjax(){
        CDNDataHTTP({sessionid:this.sessionid,time:encodeURIComponent(this.DateFormat),name:this.DateName}).then(data=>{
        if('loginCheck' in data){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          this.isLoading=false;
          this.descriptionData=data.date;
          this.chartDataArray(data.value);
        }
      });
    },
    drawExportLine(id){
      let ExportChart=echarts.init(document.getElementById(id));
      let colors=['#5695cf','#13b5b1','#ffad70'];
      let date=this.exportChartData.time;
      let Http=this.exportChartData.http;
      let Rudp=this.exportChartData.rudp;
      let TotalMax=this.exportChartData.totalmax;
      ExportChart.setOption({
        title: {},
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data:['Http','Rudp','TotalMax']
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        toolbox: {
            feature: {
                saveAsImage: {}
            }
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: date
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                name:'Http',
                type:'line',
                data:Http,
                 itemStyle:{
                     normal:{
                         color: colors[0] //图标颜色#FF0
                     }
                 },
                 lineStyle:{
                     normal:{
                         color: colors[0]  //连线颜色
                     }
                 }
            },
            {
                name:'Rudp',
                type:'line',
                data:Rudp,
                 itemStyle:{
                     normal:{
                         color: colors[1] //图标颜色#FF0
                     }
                 },
                 lineStyle:{
                     normal:{
                         color: colors[1]  //连线颜色
                     }
                 }
            },
            {
                name:'TotalMax',
                type:'line',
                data:TotalMax,
                 itemStyle:{
                     normal:{
                         color: colors[2] //图标颜色#FF0
                     }
                 },
                 lineStyle:{
                     normal:{
                         color: colors[2]  //连线颜色
                     }
                 }
            },
        ]
      });
    },
    drawLine(id){
      let chart=echarts.init(document.getElementById(id));
      let arrCurTime=['00:00:00','00:20:00','00:40:00','01:00:00','01:20:00','01:40:00','02:00:00','02:20:00','02:40:00','03:00:00','03:20:00','03:40:00','04:00:00','04:20:00','04:40:00','05:00:00','05:20:00','05:40:00','06:00:00','06:20:00','06:40:00','07:00:00','07:20:00','07:40:00','08:00:00','08:20:00','08:40:00','09:00:00','09:20:00','09:40:00','10:00:00','10:20:00','10:40:00','11:00:00','11:20:00','11:40:00','12:00:00','12:20:00','12:40:00','13:00:00','13:20:00','13:40:00','14:00:00','14:20:00','14:40:00','15:00:00','15:20:00','15:40:00','16:00:00','16:20:00','16:40:00','17:00:00','17:20:00','17:40:00','18:00:00','18:20:00','18:40:00','19:00:00','19:20:00','19:40:00','20:00:00','20:20:00','20:40:00','21:00:00','21:20:00','21:40:00','22:00:00','22:20:00','22:40:00','23:00:00','23:20:00','23:40:00','00:00:00'];
      let line_data1=this.chartData.http连接数量;
      let line_data2=this.chartData.http客户端数量;
      let line_data3=this.chartData.http中继数量;
      let line_data4=this.chartData.rudp连接数量;
      let line_data5=this.chartData.rudp客户端数量;
      let line_data6=this.chartData.rudp中继数量;
      let line_data7=this.chartData.ALL;
      let colors=['#5695cf','#13b5b1','#ffad70','#eb6877','#8957a1','#a37a46','#ec6941','#434343'];
      chart.setOption({
         legend: {
             data: ['httpSessionNum', 'httpClientNum', 'httpRelayNum', 'rudpSessionNum', 'rudpClientNum', 'rudpRelayNum','ALL']
         },
         title : {
         },
         tooltip : {
             trigger : 'axis',
             axisPointer : {
                 type : 'line'
             },
             position : 'top'
         },
         grid : {
             top : '2%',
             left : '4%',
             right : '4%',
             bottom : '8%'
         },
         xAxis : {
             boundaryGap : false,
             type : 'category',
             splitLine : {
                 show : true,
                 interval :5
             },
             data: arrCurTime,
             scale: true,
             axisTick : {
                 show : true,
                 interval : 5
             },
             axisLabel : {
                 rotate: 45,
                 show : true,
                 interval :5

             }
         },
         yAxis : [ {
             scale : true,
             splitArea : {
                 show : true
             }
         }],
         dataZoom: [
             {
                 type: 'slider',
                 start: 0,
                 end: 50,
                 orient:"horizontal",
                 show: true
             },
             {
                 type: 'inside',
                 xAxisIndex: [0],
                 start: 1,
                 end: 35
             },

         ],
         series : [ {
           name : 'httpSessionNum',
           type:'line',
           data : line_data1,
           itemStyle:{
               normal:{
                   color: colors[0] //图标颜色#FF0
               }
           },
           lineStyle:{
               normal:{
                   color: colors[0]  //连线颜色
               }
           }
       },
           {
               name : 'httpClientNum',
               type:'line',
               data : line_data2,
               itemStyle:{
                   normal:{
                       color: colors[1] //图标颜色#FF0
                   }
               },
               lineStyle:{
                   normal:{
                       color: colors[1]  //连线颜色
                   }
               }
           },
           {
               name : 'httpRelayNum',
               type:'line',
               data : line_data3,
               itemStyle:{
                   normal:{
                       color: colors[2] //图标颜色#FF0
                   }
               },
               lineStyle:{
                   normal:{
                       color: colors[2]  //连线颜色
                   }
               }
           },
           {
               name : 'rudpSessionNum',
               type:'line',
               data : line_data4,
               itemStyle:{
                   normal:{
                       color: colors[3] //图标颜色#FF0
                   }
               },
               lineStyle:{
                   normal:{
                       color: colors[3]  //连线颜色
                   }
               }
           },{
               name : 'rudpClientNum',
               type:'line',
               data : line_data5,
               itemStyle:{
                   normal:{
                       color: colors[4] //图标颜色#FF0
                   }
               },
               lineStyle:{
                   normal:{
                       color: colors[4]  //连线颜色
                   }
               }
           },{
               name : 'rudpRelayNum',
               type:'line',
               data : line_data6,
               itemStyle:{
                   normal:{
                       color: colors[5] //图标颜色#FF0
                   }
               },
               lineStyle:{
                   normal:{
                       color: colors[5]  //连线颜色
                   }
               }
           },{
               name : 'ALL',
               type:'line',
               data : line_data7,
               itemStyle:{
                   normal:{
                       color: colors[7] //图标颜色#FF0
                   }
               },
               lineStyle:{
                   normal:{
                       color: colors[7]  //连线颜色
                   }
               }
           }]
     })
    }
  },
  created(){
    LoginHTTP().then(data=>{
      if(data.return==false){
        window.location.href='http://113.106.250.156:8000/zabbix/index.php';
      }else{
        this.sessionid=data.return;
        this.initChartDataArray();
        this.DateHTTP=new Date();
        this.changeDateFormat();
        this.DateName='1';
        this.sendMsgAjax();
        this.timer1=setInterval(this.updateChartData,60000);
      }
    });
  }
}
</script>
<style lang="less" scoped>
  @import '../../style/charts/cdn.less';
</style>








