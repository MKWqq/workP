<template>
  <div class="studentVolunteerCount">
    <el-row type="flex" align="middle" class="subClassDivision_title">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <span class="breadcrumb"><span class="breadcrumb_active">志愿填报情况</span><span>|</span><router-link
        to="/subClassDivisionHome/volunteerDistributionStatus"
        tag="span">志愿分布情况</router-link></span>
    </el-row>
    <el-row class="subClassDivision_row">
      <el-col :span="8" class="chartsName">
        <span class="exam_subTitle">学生填报志愿进度图</span>
        <chart :options="progress" ids="progress"/>
      </el-col>
      <el-col :span="8" class="chartsName">
        <span class="exam_subTitle">各科类学生志愿分布图</span>
        <chart :options="distribution" ids="distribution"/>
      </el-col>
      <el-col :span="8" class="chartsName">
        <span class="exam_subTitle">各专业学生志愿分布图</span>
        <chart :options="volunteer" ids="volunteer"/>
      </el-col>
    </el-row>
    <el-row class="subClassDivision_row">
      <el-row class="chartsName">
        <span class="exam_subTitle">各班志愿填报进度统计图</span>
        <div style="width: 80%;margin: auto;">
          <chart :options="volunProgress" ids="volunProgress"/>
        </div>
      </el-row>
    </el-row>
    <el-row class="subClassDivision_row">
      <el-row class="chartsName">
        <span class="exam_subTitle">各班志愿分布图—科类</span>
        <div style="width: 80%;margin: auto;">
          <chart :options="volunSubject" ids="volunSubject"/>
        </div>
      </el-row>
    </el-row>
    <el-row class="subClassDivision_row">
      <el-row class="chartsName">
        <span class="exam_subTitle">各班志愿分布图—专业</span>
        <div style="width: 80%;margin: auto;">
          <chart :options="volunMajor" ids="volunMajor"/>
        </div>
      </el-row>
    </el-row>
  </div>
</template>
<script>
  import eChart from './eCharts.vue'
  import req from '@/assets/js/common'
  export default{
    components: {
      'chart': eChart
    },
    data(){
      return {
        progress: {
          tooltip: {
            trigger: 'item',
            formatter: "{b} : {d}%"  //{a} <br/>{b}: {c} ({d}%)
          },
          color: ['#4da1ff', '#fca1d5'],
          legend: {
            orient: 'vertical',
            x: 'left',
            data: [{
              name: '已填报',
              icon: 'circle'
            }, {
              name: '未填报',
              icon: 'circle'
            }]
          },
          series: [
            {
              name: '访问来源',
              type: 'pie',
              radius: ['32%', '50%'],
              avoidLabelOverlap: false,
              label: {
                normal: {
                  show: false,
                  position: 'center'
                },
                /*emphasis: {
                 show: true,
                 textStyle: {
                 fontSize: '30',
                 fontWeight: 'bold'
                 }
                 }*/
              },
              labelLine: {
                normal: {
                  show: false
                }
              },
              data: [
                {value: 335, name: '已填报'},
                {value: 310, name: '未填报'}
              ]
            }
          ]
        },
        distribution: {
          tooltip: {
            trigger: 'item',
            formatter: "{b} : {d}%"  //{a} <br/>{b}: {c} ({d}%)
          },
          color: ['#4da1ff', '#fca1d5'],
          legend: {
            orient: 'vertical',
            x: 'left',
            data: [{
              name: '理科',
              icon: 'circle'
            }, {
              name: '文科',
              icon: 'circle'
            }]
          },
          series: [
            {
              name: '访问来源',
              type: 'pie',
              radius: ['32%', '50%'],
              avoidLabelOverlap: false,
              label: {
                normal: {
                  show: false,
                  position: 'center'
                }
              },
              labelLine: {
                normal: {
                  show: false
                }
              },
              data: [
                {value: 30, name: '理科'},
                {value: 310, name: '文科'}
              ]
            }
          ]
        },
        volunteer: {
          tooltip: {
            trigger: 'item',
            formatter: "{b} : {d}%"  //{a} <br/>{b}: {c} ({d}%)
          },
          color: ['#4da1ff', '#fca1d5', '#fdd465'],
          legend: {
            orient: 'vertical',
            x: 'left',
            data: [{
              name: '体育',
              icon: 'circle'
            }, {
              name: '美术',
              icon: 'circle'
            }, {
              name: '音乐',
              icon: 'circle'
            }]
          },
          series: [
            {
              name: '访问来源',
              type: 'pie',
              radius: ['32%', '50%'],
              avoidLabelOverlap: false,
              label: {
                normal: {
                  show: false,
                  position: 'center'
                }
              },
              labelLine: {
                normal: {
                  show: false
                }
              },
              data: [
                {value: 30, name: '体育'},
                {value: 310, name: '美术'},
                {value: 200, name: '音乐'}
              ]
            }
          ]
        },
        volunProgress: {
          legend: {
            show: true,
            x: 'left',
            y: 'top',
            data: ['已填报','未填报']
          },
          color: ['#4da1ff', '#d2d2d2'],
          tooltip: {
            trigger: 'axis',
            axisPointer: {            // 坐标轴指示器，坐标轴触发有效
              type: 'line'        // 默认为直线，可选为：'line' | 'shadow'
            },
            formatter: "{b} <br/>{a0}: {c0}%<br/>{a1}: {c1}%"  //{a} <br/>{b}: {c} ({d}%)
          },
          grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
          },
          xAxis: [
            {
              type: 'category',
              data: ['八年级1', '八年级2', '八年级2'],
              axisTick: {
                alignWithLabel: true
              }
            }
          ],
          yAxis: [
            {
              type: 'value',
              axisLabel: {
                show: true,
                interval: 'auto',
                formatter: '{value}%'
              },
              max:'100',
              show: true
            }
          ],
          series: [
            {
              name: '已填报',
              type: 'bar',
              barWidth: '40',
              stack:'已填报',
              data: [10, 50, 31, 28, 33, 24, 88]
            },
            {
              name: '未填报',
              type: 'bar',
              barWidth: '40',
              stack:'已填报',
              data: [10, 20, 30, 22, 33, 24, 88]
            }
          ]
        },
        volunSubject: {
          legend: {
            show: true,
            x: 'left',
            y: 'top',
            data: ['文科','理科']
          },
          color: ['#fd72c1', '#4da1ff'],
          tooltip: {
            trigger: 'axis',
            axisPointer: {            // 坐标轴指示器，坐标轴触发有效
              type: 'line'        // 默认为直线，可选为：'line' | 'shadow'
            },
            formatter: "{b} <br/>{a0}: {c0}%<br/>{a1}: {c1}%"  //{a} <br/>{b}: {c} ({d}%)
          },
          grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
          },
          xAxis: [
            {
              type: 'category',
              data: ['八年级1', '八年级2', '八年级2'],
              axisTick: {
                alignWithLabel: true
              }
            }
          ],
          yAxis: [
            {
              type: 'value',
              axisLabel: {
                show: true,
                interval: 'auto',
                formatter: '{value}%'
              },
              max:'100',
              show: true
            }
          ],
          series: [
            {
              name: '文科',
              type: 'bar',
              barWidth: '40',
              stack:'文科',
              data: [10, 50, 31, 28, 33, 24, 88]
            },
            {
              name: '理科',
              type: 'bar',
              barWidth: '40',
              stack:'文科',
              data: [10, 20, 30, 22, 33, 24, 88]
            }
          ]
        },
        volunMajor: {
          legend: {
            show: true,
            x: 'left',
            y: 'top',
            data: ['音乐','体育','美术']
          },
          color: ['#fdc42a', '#4da1ff','#fca1d5'],
          tooltip: {
            trigger: 'axis',
            axisPointer: {            // 坐标轴指示器，坐标轴触发有效
              type: 'line'        // 默认为直线，可选为：'line' | 'shadow'
            },
            formatter: "{b} <br/>{a0}: {c0}%<br/>{a1}: {c1}%<br/>{a2}: {c2}%"  //{a} <br/>{b}: {c} ({d}%)
          },
          grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
          },
          xAxis: [
            {
              type: 'category',
              data: ['八年级1', '八年级2', '八年级2'],
              axisTick: {
                alignWithLabel: true
              }
            }
          ],
          yAxis: [
            {
              type: 'value',
              axisLabel: {
                show: true,
                interval: 'auto',
                formatter: '{value}%'
              },
              max:'100',
              show: true
            }
          ],
          series: [
            {
              name: '音乐',
              type: 'bar',
              barWidth: '40',
              stack:'音乐',
              data: [10, 50, 31, 28, 33, 24, 88]
            },
            {
              name: '体育',
              type: 'bar',
              barWidth: '40',
              stack:'音乐',
              data: [10, 20, 30, 22, 33, 24, 88]
            }
            ,
            {
              name: '美术',
              type: 'bar',
              barWidth: '40',
              stack:'音乐',
              data: [10, 20, 30, 22, 33, 24, 88]
            }
          ]
        }
      }
    },
    mounted: function () {
    },
    methods: {
      returnFlowchart(){
        this.$router.push('/subClassDivisionHome');
      }
    }
  }
</script>
<style>
  .studentVolunteerCount .chartsName .exam_subTitle {
    display: inline-block;
    width: 12.5rem;
    height: 2rem;
    line-height: 2rem;
    padding: 0;
    border-radius: 0 15px 15px 0;
    -webkit-box-shadow: 0 5px 5px 0 #ddd;
    -moz-box-shadow: 0 5px 5px 0 #ddd;
    box-shadow: 0 5px 5px 0 #ddd;
    background-color: #89bcf5;
    border-color: #89bcf5;
    color: #fff;
    text-align: center;
    font-size: .875rem;
  }

  .studentVolunteerCount #progress, .studentVolunteerCount #distribution, .studentVolunteerCount #volunteer,.studentVolunteerCount #volunProgress,.studentVolunteerCount #volunSubject,.studentVolunteerCount #volunMajor {
    margin-top: 1.8rem;
  }
</style>
