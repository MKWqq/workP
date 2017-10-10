<template>
  <div class="g-container">
    <header class="g-textHeader">
      <h2>报修统计</h2>
    </header>
    <div class="g-statisticalAnalysis">
      <header class="g-textHeader g-flexStartRow">
        <el-form :model="repairForm" label-width="75px" label-position="left">
          <el-form-item label="报修类别:">
            <el-select v-model="repairForm.type">
              <el-option value="0" label="设备"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="时间段:">
            <el-col :span="10">
              <el-date-picker type="date" :picker-options="pickerOptionStart" placeholder="选择日期" v-model="repairForm.startTime" style="width:100%"></el-date-picker>
            </el-col>
            <el-col :span="2" class="line" style="text-align:center;">--</el-col>
            <el-col :span="10">
              <el-date-picker type="date" :picker-options="pickerOptionEnd" placeholder="选择日期" v-model="repairForm.endTime" style="width:100%"></el-date-picker>
            </el-col>
          </el-form-item>
        </el-form>
        <el-button class="radiusButton selfCenter" type="primary" icon="search">查询</el-button>
      </header>
      <section class="centerTable alertsList">
        <div id="staticEchart"></div>
        <el-table class="g-NotHover" :data="classesTimeSetTable" @sort-change="sortChange" @selection-change="handleSelectionChange">
          <el-table-column :label="staticType" sortable>
            <template scope="props">
              <el-button type="text" v-text="props.row.name"></el-button>
            </template>
          </el-table-column>
          <el-table-column label="待维修" prop="name"></el-table-column>
          <el-table-column label="维修中"></el-table-column>
          <el-table-column label="已维修"></el-table-column>
          <el-table-column label="已验收"></el-table-column>
        </el-table>
      </section>
    </div>
  </div>
</template>
<script>
  import {} from '@/api/http'
  import echarts from 'echarts'
  export default{
    data(){
      let _self=this;
      return{
        /*模糊查询*/
        fuzzyInput:'',
        evaluationName:'',
        /*form表单*/
        repairForm:{
          type:'',
          startTime:'',
          endTime:''
        },
        /*table*/
        classesTimeSetTable:[{name:1}],
        staticType:'报修类别',
        pickerOptionStart:{
          disabledDate(time){
            if(_self.repairForm.endTime){
              return time.getTime()>Date.parse(_self.repairForm.endTime);
            }
          }
        },
        pickerOptionEnd:{
          disabledDate(time){
            if(_self.repairForm.startTime){
              return time.getTime()<Date.parse(_self.repairForm.startTime);
            }
          }
        },
      }
    },
    methods:{
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'evaluationManagement'});
      },
      /*table*/
      handleSelectionChange(choose){
        console.log(choose);
      },
      sortChange(value){
        console.log(value);
      },
      /*模糊查询*/
      fuzzyClick(){
        /*模糊查询执行回调*/
      },
      /*画图*/
      drawChart(id){
        let chart=echarts.init(document.getElementById(id));
        let colors=['#89bcf5','#f08bc5','#4da1ff','#fdd465'];
        chart.setOption(
          {
            tooltip : {
              trigger: 'axis',
              axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
              }
            },
            legend: {
              data:['待维修','维修中','已维修','已验收']
            },
            color:colors,
            grid: {
              left: '3%',
              right: '4%',
              bottom: '3%',
              containLabel: true
            },
            xAxis : [
              {
                type : 'category',
                data : ['办公室','维护','合计']
              }
            ],
            yAxis : [
              {
                type : 'value'
              }
            ],
            series : [
              {
                name:'待维修',
                type:'bar',
                stack:'维修',
                data:[320, 332]
              },
              {
                name:'维修中',
                type:'bar',
                stack:'维修',
                data:[120, 132]
              },
              {
                name:'已维修',
                type:'bar',
                stack:'维修',
                data:[220, 182]
              },
              {
                name:'已验收',
                type:'bar',
                data:[150, 232]
              }
            ]
          }
        )
      },
    },
    created(){
      this.$nextTick(()=>{
        this.drawChart('staticEchart');
      });
    }
  }
</script>
<style lang="less" scoped>
  /*@import '../../../../style/test';*/
  @import '../../../../style/style';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.css';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.less';
  .g-sa_header_search{.marginTop(32);.marginBottom(20);}
  .g-classSchedule .g-container{padding:0;}
  .g-statisticalAnalysis header.g-textHeader.g-flexStartRow{.marginTop(20);.marginBottom(20);}
  .g-textHeader .el-form{.width(825,1582);}
  .g-textHeader .el-form-item{float:left;margin-bottom:0;}
  .g-textHeader .el-form-item:nth-of-type(1){.width(222,825);}
  .g-textHeader .el-form-item:nth-of-type(2){.width(558,825);.marginLeft(40,825);}
  .g-liOneRow.g-sa_header_search{margin-top:0;}
  #staticEchart{width:100%;.NotLineheight(430);.marginBottom(30);}
</style>


