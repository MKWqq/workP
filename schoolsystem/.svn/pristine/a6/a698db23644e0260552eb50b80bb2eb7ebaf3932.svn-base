<template>
  <div :id="ids" style="width: 100%;height:400px;"></div>
</template>
<script>
  import echarts from 'echarts/lib/echarts'
  // 引入柱状图
  import 'echarts/lib/chart/pie'  //饼图
  import 'echarts/lib/chart/bar'  //柱状图
  // 引入提示框和标题组件
  import 'echarts/lib/component/tooltip'
  import 'echarts/lib/component/title'
  import 'echarts/lib/component/legendScroll'
    export default{
      props:['options','ids'],
        data(){
            return {}
        },
      mounted:function () {
        this.initChart(this.options,this.ids);
      },
        methods: {
            initChart(obj,id){
              var myChart = echarts.init(document.getElementById(id));
              myChart.setOption(obj);
            }
        }
    }
</script>
<style>

</style>
