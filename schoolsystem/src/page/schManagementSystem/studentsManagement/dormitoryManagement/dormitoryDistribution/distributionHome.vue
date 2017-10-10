<template>
  <div class="distributionHome">
    <router-view></router-view>
  </div>
</template>
<script>
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
  .distributionHome {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .distributionHome h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
    display: inline-block;
  }
  .distributionHome .alertsBtn {
    margin: 1.25rem 0;
  }

  .distributionHome .g-fuzzyInput {
    float: right;
  }

  .distributionHome .el-table th, .distributionHome .el-table td {
    text-align: center;
  }
  .distributionHome .return_btn.el-button--primary{
    background-color: #ff8686;
    border-color: #ff8686;
    border-radius: 20px;
  }
  .distributionHome .return_btn+h3 {
    margin-left: 2.625rem;
    display: inline-block;
  }
  .distributionHome .return_btn.el-button--primary .returnTxt{
    margin-left:10px;
  }
</style>
