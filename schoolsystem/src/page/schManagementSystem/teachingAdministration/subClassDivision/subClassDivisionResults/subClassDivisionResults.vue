<template>
  <div class="subClassDivisionResults">
    <el-row type="flex" align="middle">
      <h3>分班分科结果</h3>
    </el-row>
    <el-row class="subClassDivisionResults_title">分班分科结果</el-row>
    <el-row>
      <div class="results_box">
        <el-row type="flex" align="middle" class="results_row">
          <el-col :span="8" class="results_boxL">新年级：</el-col>
          <el-col :span="12" class="results_boxR">六年级</el-col>
        </el-row>
        <el-row type="flex" align="middle"  class="results_row">
          <el-col :span="8" class="results_boxL">新班级：</el-col>
          <el-col :span="12" class="results_boxR">2班</el-col>
        </el-row>
        <el-row type="flex" align="middle"  class="results_row">
          <el-col :span="8" class="results_boxL">新班级序号：</el-col>
          <el-col :span="12" class="results_boxR">10</el-col>
        </el-row>
        <div class="smTip">
          <el-row type="flex" align="middle" class="smTip_row">
            <el-col :span="12" class="smTip_l">原年级：</el-col>
            <el-col :span="12">六年级</el-col>
          </el-row>
          <el-row type="flex" align="middle"  class="smTip_row">
            <el-col :span="12" class="smTip_l">原班级：</el-col>
            <el-col :span="12">2班</el-col>
          </el-row>
          <el-row type="flex" align="middle"  class="smTip_row">
            <el-col :span="12" class="smTip_l">原班级序号：</el-col>
            <el-col :span="12">10</el-col>
          </el-row>
        </div>
      </div>
    </el-row>
  </div>
</template>
<script>
  import req from '@/assets/js/common'
  export default{
    data(){
      return {

      }
    },
    methods: {

    }
  }
</script>
<style>
  .subClassDivisionResults {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .subClassDivisionResults h3 {
    font-size: 1.25rem;
  }
  .subClassDivisionResults .subClassDivisionResults_title{
    font-size:1.875rem;
    text-align: center;
    margin:3.75rem 0;
  }
  .subClassDivisionResults .results_box{
    width:45rem;
    border:5px solid #4da1ff;
    border-radius: 10px;
    padding:8.75rem 0;
    margin:0 auto 5rem;
    position: relative;
  }
  .subClassDivisionResults .results_row+.results_row{
    margin-top:4.5rem;
  }
  .subClassDivisionResults .results_boxL{
    text-align: right;
    font-size:1.5rem;
  }
  .subClassDivisionResults .results_boxR{
    color: #4da1ff;
    font-size:2.25rem;
    text-align: center;
  }
  .subClassDivisionResults .smTip{
    width:17.5rem;
    position: absolute;
    top:0;
    left:-17.5rem;
    border-radius: 8px;
    background-color: #4da1ff;
    color: #fff;
    font-size:1.25rem;
    padding:2rem 0;
  }
  .subClassDivisionResults .smTip_row+.smTip_row{
    margin-top:2rem;
  }
  .subClassDivisionResults .smTip_l{
    text-align: right;
  }
</style>
