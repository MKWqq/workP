<template>
  <div class="ArchivesStatistics">
    <h3>档案统计</h3>
    <!--时间段-->
    <el-col :span="24" style="margin-top: 2rem">
      <el-col :span="2" style="margin-top: .3rem;text-align: right">信息类别：</el-col>
      <el-col :span="5">
        <el-col :span="24">
          <el-input v-model="optionsvalue" @focus="Showcheckbox()"></el-input>
        </el-col>
        <!--多选框-->
        <el-col :span="5" v-if="showcheckbox" class="FilerecordPassed-checkbox">
          <el-checkbox :indeterminate="isIndeterminate" v-model="checkAll" @change="handleCheckAllChange">全选</el-checkbox>
          <div style="margin: 15px 0;"></div>
          <el-checkbox-group v-model="checkedCities" @change="handleCheckedCitiesChange">
            <el-checkbox v-for="city in cities" :label="city" :key="city">{{city}}</el-checkbox>
          </el-checkbox-group>
          <el-col :span="1" :offset="10">
            <el-button type="primary"  class="Hidecheckbox-btn" @click ="Hidecheckbox()">确定</el-button>
          </el-col>
        </el-col>
      </el-col>
      <el-col :span="2" :offset="1" style="margin-top: .3rem;text-align: right;margin-left: -.6rem;">档案时间： </el-col>
      <el-col :span="3">
        <el-date-picker
          v-model="startvalue" type="date" :picker-options="pickerOptions0" style="width: 100%">
        </el-date-picker>
      </el-col>
      <el-col :span="1"  style="text-align: center">_</el-col>
      <el-col :span="3">
        <el-date-picker
          v-model="endvalue" type="date" :picker-options="pickerOptions1" style="width: 100%">
        </el-date-picker>
      </el-col>
    </el-col>
    <el-col :span="24" style="margin-top: 1rem;">
      <el-col :span="2" style="margin-top: .3rem;text-align: right">维度：</el-col>
      <el-col :span="3">
        <el-select v-model="selectvalue" placeholder="请选择">
          <el-option
            v-for="item in options"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
      </el-col>
      <el-col :span="2" :offset="1" style="margin-top: .3rem;text-align: right;margin-left: -2.3rem;">维度：</el-col>
      <el-col :span="3">
        <el-select v-model="selectvalue" placeholder="请选择">
          <el-option
            v-for="item in options"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
      </el-col>
      <el-col :span="1" :offset="1">
        <el-button type="primary" icon="search" class="LeaveRecord-search">查询</el-button>
      </el-col>
    </el-col>
    <el-col :span="24" style="margin-top: 2rem">
      <el-row class="StaticsList">
        <el-table
          :data="tableData"
          style="width: 100%"
          border
          v-loading.body="isLoading"
          element-loading-text="拼命加载中...">
          <el-table-column
            prop="title"
            label="标签"
            align="center">
            <template scope="scope">
              <span>{{scope.row.title}}</span>
            </template>
          </el-table-column>
          <el-table-column
            prop="name"
            label="B01"
            align="center">
          </el-table-column>
          <el-table-column
            prop="name"
            label="B01"
            align="center">
          </el-table-column>
          <el-table-column
            prop="createTime"
            label="B01"
            align="center">
            <template scope="scope">

            </template>
          </el-table-column>
        </el-table>
      </el-row>
      <el-row style="margin-top: 2rem;">
        <div id="staticEchart"></div>
      </el-row>
    </el-col>
  </div>
</template>
<script>
  import echarts from 'echarts'
  const cityOptions = ['上海', '北京', '广州', '深圳'];
    export default{
        data(){
            return {
              pickerOptions0: {
                disabledDate(time) {
                  return time.getTime() > Date.now();
                }
              },
              pickerOptions1: {
                disabledDate(time) {
                  return time.getTime() > Date.now();
                }
              },
              startvalue: new Date(),
              endvalue: new Date(),
              optionsvalue: '',
              checkedCities: [],
              cities: cityOptions,
              isIndeterminate: true,
              showcheckbox: false,
              checkAll: true,
              selectvalue: '',
              options: [{
                value: '选项1',
                label: '黄金糕'
              }],
              tableData:[{title:'1111'},{title:'1111'}],
              isLoading:false,
            }
        },
      created(){
        this.$nextTick(()=>{
          this.drawChart('staticEchart');
        });
      },
      methods:{
        drawChart(id){
          let chart=echarts.init(document.getElementById(id));
          let colors=['#89BCF5','#f08bc5','#4da1ff'];
          chart.setOption(
            {
              tooltip : {
                trigger: 'axis',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                  type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
              },
              legend: {
                data:['B01','B02','B03']
              },
              color:colors,
              grid: {
                left: '6%',
                right: '6%',
                bottom: '16%',
                containLabel: true,
                show: true,
                borderWidth:'30px'
              },
              xAxis : [
                {
                  type : 'category',
                  data : ['语文','数学','英语']
                }
              ],
              yAxis : [
                {
                  type : 'value'
                }
              ],
              series : [
                {
                  name:'B01',
                  type:'bar',
                  stack:'1',
                  data:[1,1,2],
                  barWidth:'40px'
                },
                {
                  name:'B02',
                  type:'bar',
                  stack:'1',
                  data:[2,0,2],
                  barWidth:'40px'
                },
                {
                  name:'B03',
                  type:'bar',
                  stack:'1',
                  data:[0,0,0],
                  barWidth:'40px'
                },
              ]
            }
          )
        },
        Showcheckbox(){
          this.showcheckbox=true;
        },
        Hidecheckbox(){
          this.showcheckbox=false;
        },
        handleCheckAllChange(event) {
          this.checkedCities = event.target.checked ? cityOptions : [];
          this.isIndeterminate = false;
        },
        handleCheckedCitiesChange(value) {
//          this.optionsvalue=value;
          let checkedCount = value.length;
          this.checkAll = checkedCount === this.cities.length;
          this.isIndeterminate = checkedCount > 0 && checkedCount < this.cities.length;
        },
      }
    }
</script>
<style lang="less">
  #staticEchart{
    width:100%;
    min-height:35rem;
  }
  .ArchivesStatistics{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .ArchivesStatistics .FilerecordPassed-checkbox{
    border: 1px solid #d1dbe5;
    border-radius: 3px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,.12), 0 0 6px rgba(0,0,0,.04);
    box-sizing: border-box;
    margin:48px 0;
    z-index:1001;
    position: absolute;
    padding: 1rem;
  }
  .ArchivesStatistics  .el-checkbox-group .el-checkbox{
    margin-left: 0;
    margin-top: .6rem;
    margin-right: .6rem;
  }
  .ArchivesStatistics .LeaveRecord-search{
    border-radius: 1.1rem;
    padding-left: 1.6rem;
    padding-right:1.6rem;
  }
 .ArchivesStatistics .StaticsList .el-table th{
    background-color: #89bcf5;
    height:3.5rem;
  }
  .ArchivesStatistics .StaticsList .el-table td{
    height:3rem;
    font-size: .875rem;
  }
  .ArchivesStatistics .StaticsList .el-table__footer-wrapper thead div, .alertsList .el-table__header-wrapper thead div{
    background-color: #89bcf5;
    color: #fff;
  }
  .ArchivesStatistics .StaticsList .el-table th>.cell{
    background-color: #89bcf5;
    color: #fff;
  }
  .ArchivesStatistics .Hidecheckbox-btn{
    margin-top: 1.6rem;
    padding: .35rem 1rem;
  }
</style>
