<template>
  <div>
    <div id="Header">
      <h2>THE BOX ONLINE DATA</h2>
    </div>
    <div id="Main">
      <div id="boxData">
        <div class="boxDataHeader">
          <div>盒子在线情况</div>
        </div>
        <div class="boxDataMain">
          <div class="boxContentHeader">
            <p>激活数量</p>
          </div>
          <div class="dateChooseContainer">
            <div class="chooseType">
              <div class="showTypeMenu">
                <div>时间选择:</div>
                <div @click="showChildMenu">
                  <span v-text="chooseDateType"></span>
                  <img src="../assets/img/zabbix_arrow.png" v-show="!isShowChild" />
                  <img src="../assets/img/zabbix_arrow_normal.png" v-show="isShowChild" />
                </div>
              </div>
              <ul class="childTypeMenu" v-show="isShowChild">
                <li @click="confirmDateType" data-type="month">按年统计</li>
                <li @click="confirmDateType" data-type="day">按月统计</li>
                <li @click="confirmDateType" data-type="week">按周统计</li>
              </ul>
            </div>
            <template>
              <div class="dateChooseInput" v-show="isDateTypeYear">
                <el-date-picker class="dateInput" v-model="chooseYear" align="right" type="year" placeholder="选择年">
                </el-date-picker>
                <div class="search" @click="searchClick"></div>
              </div>
            </template>
            <template>
              <div class="dateChooseInput" v-show="!isDateTypeYear">
                <el-date-picker class="dateInput" v-model="chooseMonth" type="month" placeholder="选择月">
                </el-date-picker>
                <div class="search" @click="searchClick"></div>
              </div>
            </template>
          </div>
          <div class="boxContentMain">
            <div class="boxEcharts" id="boxEcharts"></div>
            <div class="boxContentR">
              <ul class="boxConHeader">
                <li>时间</li>
                <li>增长率(%)</li>
                <li>具体值</li>
              </ul>
              <div class="msgTableContainer">
                <table class="msgTable">
                  <tr v-for="detail in data">
                    <td v-text="detail.time"></td>
                    <td v-text="detail.growth"></td>
                    <td v-text="detail.activeCount"></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {LoginHTTP,boxDataHTTP} from '../api/http'
import echarts from 'echarts'
import $ from 'jquery'
export default{
  data(){
    return {
        sessionid:'',
        data:[],
        isDateTypeYear:true,
        isShowChild:false,
        chooseMonth:"",
        chooseYear:"",
        YearFormat:"",
        chooseDateType:"",
        sendType:"",
        xAixsData:[],
        increaseData:[],
        valueData:[]
      }
    },
    methods:{
      showChildMenu(){
        this.isShowChild=!this.isShowChild;
      },
      confirmDateType(event){
        this.chooseDateType=$(event.target || event.srcElement).text();
        this.sendType=$(event.target || event.srcElement).attr("data-type");
        if(this.sendType=="day"){
          this.isDateTypeYear=false;
        }else if(this.sendType=="month"){
          this.isDateTypeYear=true;
        }else{
          this.isDateTypeYear=true;
        }
      },
      searchClick(){
        this.YearFormat=this.chooseYear;
        if(this.sendType=="day"){
          if(this.chooseMonth==""){this.chooseMonth=new Date();}
          this.dateFormat(this.chooseMonth);
          this.sendAjax({year:this.chooseMonth,mode:this.sendType});
        }else if(this.sendType=="month"){
          if(this.YearFormat==""){this.chooseYear=new Date();this.YearFormat=new Date();}
          this.dateFormat(this.YearFormat);
          this.sendAjax({year:this.YearFormat,mode:this.sendType});
        }else{
          if(this.YearFormat==""){this.chooseYear=new Date();this.YearFormat=new Date();}
          this.dateFormat(this.YearFormat);
          this.sendAjax({year:this.YearFormat,mode:this.sendType});
        }
      },
      sendAjax(params){
        params.sessionid=this.sessionid;
        boxDataHTTP(params).then(data => {
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            this.xAixsData=[];
            this.increaseData=[];
            this.valueData=[];
            this.data=data;
            $.each(data,(index,value)=>{
              this.xAixsData.push(value.time);
              this.increaseData.push(value.growth);
              this.valueData.push(value.activeCount);
            });
            this.$nextTick(function() {
              this.drawLine('boxEcharts')
            });
          }
        });
      },
      dateFormat(date){
        if(typeof date=='object' && this.sendType=="day"){
          this.chooseMonth=date.getFullYear()+"-0"+(date.getMonth()+1);
        }else if(typeof date=='object' && (this.sendType=="month" || this.sendType=="week")){
          this.YearFormat=date.getFullYear();
        }else{
          return
        }
      },
      drawLine (id) {
        this.chart = echarts.init(document.getElementById(id));
        let drawxAixsData=this.xAixsData;
        let drawincreaseData=this.increaseData;
        let drawvalueData=this.valueData;
        let colors=['#40a5f3','#f76f79'];
        this.chart.setOption(
          {
              grid: {
                  bottom: 80
              },
              tooltip: {
                  trigger: 'axis',
                  axisPointer: {
                      animation: false
                  },
                  formatter: function(params) {
                      var res = params[1].name;
                      for (var i = 0,
                      l = params.length; i < l; i++) {
                          if (i == 1) {
                              res += '<br/>' +'<span style="display:inline-block;margin-right:5px;border-radius:10px;width:9px;height:9px;background-color:#f76f79;"></span>'+ params[i].seriesName + ' : ' + params[i].value + "%";
                          } else {
                              res += '<br/>' +'<span style="display:inline-block;margin-right:5px;border-radius:10px;width:9px;height:9px;background-color:#40a5f3;"></span>'+ params[i].seriesName + ' : ' + params[i].value;
                          }
                      }

                      return res;
                  }
              },
              legend: {
                  data: ['增长率', '具体值'],
                  x: '900px'
              },
              color:colors,
              xAxis: [{
                  type: 'category',
                  boundaryGap: false,
                  axisLine: {
                      onZero: false
                  },
                  data:drawxAixsData
              }],
              yAxis: [
              {
                  name: '具体值',
                  nameLocation: 'start',
                  nameGap:30,
                  type: 'value',
                  inverse: false
              },
              {
                  name: '增长率',
                  nameLocation:"start",
                  nameGap:30,
                  type: 'value',
                  max: 100,
                  axisLabel: {
                      show: true,
                      interval: 'auto',
                      formatter: '{value} %'
                  }
              }],
              series: [
              {
                  name: '具体值',
                  type: 'line',
                  hoverAnimation: false,
                  areaStyle: {
                      normal: {}
                  },
                  lineStyle: {
                      normal: {
                          width: 2,
                          color:colors[0]
                      }
                  },
                  areaStyle:{
                    normal:{
                      color:new echarts.graphic.LinearGradient(0, 0, 0,1, [{
                              offset: 0, color: colors[0]
                            }, {
                              offset: 1, color: '#fff'
                            }], false),
                      opacity:0.4
                    }
                  },
                  data:drawvalueData
              },
              {
                  name: '增长率',
                  type: 'line',
                  hoverAnimation: false,
                  yAxisIndex: 1,
                  markLine:{
                    silent:true,
                    label:{
                      normal:{
                        position:'start',
                        formatter:'{c} %',
                        show:false
                      }
                    },
                    lineStyle:{
                      normal:{
                      type:'dashed',
                      width:1
                      }
                    },
                    data:[{
                      yAxis:0
                    }]
                  },
                  itemStyle: {
                      normal: {
                          label: {
                              show: false,
                              position: 'top',
                              formatter: '{c} %'
                          }
                      }
                  },
                  areaStyle: {
                      normal: {
                        color:new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                offset: 0, color: colors[1]
                              }, {
                                offset: 1, color: '#fff'
                              }], false),
                        opacity:0.8
                      }
                  },
                  lineStyle: {
                      normal: {
                          width: 2,
                          color:colors[1]
                      }
                  },
                  data: drawincreaseData
              }
              ]
          }
        )
      }
    },
    beforeCreate(){
    },
    created(){
      LoginHTTP().then(data=>{
        if(data.return==false){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          this.sessionid=data.return;
          this.sendAjax({year:this.chooseYear,mode:this.sendType});
        }
      });
      this.chooseDateType="按年统计";
      this.chooseYear="2017";
      this.sendType="month";
    },
    mounted(){}
}
</script>
<style lang="less" scoped>
  @import "../style/boxData.less";
</style>



