<template>
  <div class="classTeacher">
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
  .classTeacher {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .classTeacher h3 {
    font-size: 1.25rem;
  }

  .classTeacher .classTeacher_row {
    margin: 1.25rem 0;
  }

  .classTeacher .el-form--inline .el-form-item {
    margin-bottom: 0;
  }

  .classTeacher .el-table td, .classTeacher .el-table th {
    text-align: center;
  }

  .classTeacher .grade {
    width: 6rem;
  }

  .classTeacher .createBtn {
    text-align: right;
  }
  .classTeacher .search{
    padding: 10px 1.5rem;
    border-radius: 20px;
  }
  .classTeacher .createBtn .el-button {
    padding: 10px 30px;
    border-radius: 20px;
  }

  .classTeacher .el-form--inline .el-form-item {
    margin-right: 1rem;
  }

  .classTeacher .el-dialog--small {
    width: 1000px;
  }

  .classTeacher .teacherList {
    min-height: 35rem;
  }
  .classTeacher .teacherList thead th {
    background-color: #deeefe;
    height: 3rem;
  }

  .classTeacher .teacherList .el-table td {
    height: 3rem;
    font-size: .875rem;
  }
  .classTeacher .teacherList .el-table__footer-wrapper thead div, .classTeacher .teacherList .el-table__header-wrapper thead div {
    background-color: #deeefe;
  }

  .classTeacher .teacherTip {
    height: 36px;
    font-size:.875rem;
  }

  .classTeacher .teacherHeader {
    height: 3.5rem;
    background-color: #89bcf5;
    padding: 0 1.25rem;
  }

  .classTeacher .el-button.teacherTitle {
    background-color: #ff8686;
    color: #fff;
    border: 1px solid #fff;
    border-radius: 30px;
    padding: .5rem 1.5rem;
    font-size: .875rem;
  }

  .classTeacher .g-fuzzyInput {
    float: right;
  }

  .classTeacher .alertsBtn {
    margin:0 0 1.25rem 0;
  }
  .classTeacher .edit {
    color: #4da1ff;
    border: 1px solid #4da1ff;
  }

  .classTeacher .setName {
    cursor: pointer;
  }
  .classTeacher .dialogGradeBox{
    text-align: right;
  }
  .classTeacher .dialogGrade{
    width:140px;
  }
</style>
