<template>
  <div class="g-container">
    <header>
      <el-button class="g-gobackChart g-imgContainer RedButton" @click="goBackChart">
        <img src="../../../../assets/img/commonImg/icon_return.png" />
        返回流程图
      </el-button>
    </header>
    <section class="g-ep_echarts" id="j-ep-echarts"></section>
    <el-dialog class="dialogNotPadding headerNotBackground" :title="dialogTitle" :modal="false" :visible.sync="isDialog" size="tiny" :before-close="handlerClose">
      <div class="g-sectionR alertsList centerTable">
        <el-table :data="classesTimeSetTable" class="g-timeSettingTable">
          <el-table-column label="序号" type="index" width="80"></el-table-column>
          <el-table-column label="姓名" prop="name"></el-table-column>
        </el-table>
      </div>
    </el-dialog>
  </div>
</template>
<script>
  import {} from '@/api/http'
  import echarts from 'echarts';
  export default{
    data(){
      return{
        /*弹框*/
        isDialog:false,
        dialogTitle:'',
        classesTimeSetTable:[{name:'123'}],
      }
    },
    methods:{
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'evaluationManagement'});
      },
      drawEcharts(id){
        let _self=this;
        let chart=echarts.init(document.getElementById(id));
        let colors=['#4da1ff','#fca1d5'];
        chart.setOption({
          tooltip: {
            /*{a}、{b}、{c}、{d}，分别表示系列名，数据名，数据值，百分比*/
            trigger: 'item',
            formatter: "{a} <br/>{b}: {c} ({d}%)"
          },
          legend: {
            orient: 'horizontal',
            x: 'center',
            data:['已考评评委','未考评评委']
          },
          color:colors,
          series: [
            {
              /*最外层说明*/
              name:'访问来源',
              type:'pie',
              radius: ['40%', '55%'],
              label: {
                normal: {
                  textStyle: {
                    fontSize: 18
                  }
                }
              },
              labelLine: {
                normal: {
                  lineStyle: {
                    /**/
                  }
                }
              },
              data:[
                {value:50, name:'已考评评委'},
                {value:310, name:'未考评评委'}
              ]
            }
          ]
        });
        chart.on('click',function(params){
          console.log(params);
          _self.dialogTitle=params.name;
          _self.isDialog=true;
        });
      },
      /*关闭按钮点击*/
      handlerClose(done){
        done();
      },
    },
    created(){
      /*画饼图*/
      this.$nextTick(()=>{
        this.drawEcharts('j-ep-echarts');
      });
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/style';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.css';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.less';
  .g-ep_echarts{width:100%;height:500px;.marginTop(32);.marginBottom(20);}
</style>


