<template>
    <div class="subClassDivisionHome">
      <router-view></router-view>
    </div>
</template>
<script>
    export default{
        data(){
            return {}
        },
        methods: {}
    }
</script>
<style>
  .subClassDivisionHome{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .subClassDivisionHome h3{
    font-size:1.25rem;
  }
  .subClassDivisionHome .subClassDivision_title{
    margin-bottom:2rem;
  }
  .subClassDivisionHome .alertsBtn{
    margin:2rem 0 1.25rem;
  }
  .subClassDivisionHome .subClassDivision_row{
    margin:2rem 0;
  }
  .subClassDivisionHome .el-table td, .subClassDivisionHome .el-table th {
    text-align: center;
  }
  .subClassDivisionHome .return_btn.el-button--primary{
    background-color: #ff8686;
    border-color: #ff8686;
    border-radius: 20px;
  }
  .subClassDivisionHome .breadcrumb{
    font-size:18px;
  }
  .subClassDivisionHome .breadcrumb>span{
    margin-left:2rem;
    color: #999999;
  }
  .subClassDivisionHome .breadcrumb .breadcrumb_active{
    color: #4da1ff;
  }
  .subClassDivisionHome .operationBtn,.subClassDivisionHome .operationBtns{
    text-align: right;
  }
  .subClassDivisionHome .operationBtn .el-button{
    border-radius: 20px;
    width:7.5rem;
    padding:10px 0;
  }
  .subClassDivisionHome .operationBtns .el-button{
    border-radius: 20px;
    width:8.875rem;
    padding:10px 0;
  }
  .subClassDivisionHome .return_btn.el-button--primary .returnTxt{
    margin-left:10px;
  }
  .subClassDivisionHome .return_btn+h3 {
    margin-left: 2.625rem;
    display: inline-block;
  }
  .subClassDivisionHome .g-fuzzyInput {
    float: right;
  }
  .subClassDivisionHome .edit {
    color: #ff5b5a;
    cursor: pointer;
  }
  .subClassDivisionHome .edit_primary{
    color: #4da1ff;
    cursor: pointer;
  }
  .subClassDivisionHome .device_line{
    color: #d2d2d2;
    margin:0 1rem;
  }
  .subClassDivisionHome .warmHint{
    color: #999999;
  }
  .subClassDivisionHome .el-dialog--small{
    width:600px;
  }
  .subClassDivisionHome .el-dialog--small .formMsg{
    width:67%;
    margin:auto;
  }
  .subClassDivisionHome .formMsg .el-select{
    width:100%;
  }
  .subClassDivisionHome .el-dialog--large{
    width:1000px;
  }
</style>
