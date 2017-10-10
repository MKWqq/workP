<template>
  <div class="g-statisticalAnalysis">
    <header>
      <div class="defineSelect g-sa_header_left">
        <span>问卷名称:</span>
        <el-select v-model="evaluationName">
          <el-option label="123" value="1"></el-option>
        </el-select>
      </div>
      <div class="g-fuzzyContainer g-flexEndRow">
        <div class="gs-refresh g-fuzzyInput">
          <el-input type="text" v-model="fuzzyInput" icon="search" placeholder="班级/姓名" :on-icon-click="fuzzyClick"></el-input>
        </div>
      </div>
    </header>
    <section class="alertsList centerTable">
      <el-table :data="classesTimeSetTable" @sort-change="sortChange" @selection-change="handleSelectionChange">
        <el-table-column label="序号" width="100px" type="index"></el-table-column>
        <el-table-column label="姓名" prop="name"></el-table-column>
        <el-table-column label="部门"></el-table-column>
        <el-table-column label="是否填写"></el-table-column>
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
        classesTimeSetTable:[{name:1}],
      }
    },
    methods:{
      /*模糊查询*/
      fuzzyClick(){
        /*模糊查询执行回调*/
      },
      /*table*/
      handleSelectionChange(choose){
        console.log(choose);
      },
      sortChange(value){
        console.log(value);
      },
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../../style/style';
  @import '../../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.css';
  @import '../../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.less';
  .g-sa_header_search{.marginTop(32);.marginBottom(20);}
  .g-fuzzyContainer{width:100%;.marginBottom(20);}
  .g-sa_header_left{margin:20/16rem 0;}
</style>


