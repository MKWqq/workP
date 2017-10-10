<template>
  <div class="g-statisticalAnalysis g-container">
    <header class="g-estatisticalAnalysisHeader">
      <el-button class="g-gobackChart g-imgContainer RedButton" @click="goBackChart">
        <img src="../../../../assets/img/commonImg/icon_return.png" />
        返回流程图
      </el-button>
      <div class="g-liOneRow g-sa_header_search">
        <div class="defineSelect g-sa_header_left">
          <span>考评名称:</span>
          <el-select v-model="evaluationName">
            <el-option label="123" value="1"></el-option>
          </el-select>
        </div>
        <div class="gs-refresh g-fuzzyInput">
          <el-input type="text" v-model="fuzzyInput" icon="search" placeholder="班级/姓名" :on-icon-click="fuzzyClick"></el-input>
        </div>
      </div>
    </header>
    <section class="alertsList g-statisticalAnalysisSection">
      <el-table :data="classesTimeSetTable">
        <el-table-column label="序号" width="100px" type="index"></el-table-column>
        <el-table-column label="姓名" prop="name"></el-table-column>
        <el-table-column label="德（25分）"></el-table-column>
        <el-table-column label="能（25分）"></el-table-column>
        <el-table-column label="勤（25分）"></el-table-column>
        <el-table-column label="绩（25分）"></el-table-column>
      </el-table>
    </section>
  </div>
</template>
<script>
  import {} from '@/api/http'
  export default{
    data(){
      return{
        /*模糊查询*/
        fuzzyInput:'',
        evaluationName:'',
        /*table*/
        classesTimeSetTable:[],
      }
    },
    methods:{
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'evaluationManagement'});
      },
      /*模糊查询*/
      fuzzyClick(){
        /*模糊查询执行回调*/
      },
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/style';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.css';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.less';
  .g-sa_header_search{.marginTop(32);.marginBottom(20);}
</style>


