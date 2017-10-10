<template>
  <div class="studyingWayApproval">
    <el-row type="flex" align="middle">
      <h3>就读方式审批</h3>
      <span class="bread">
        <span :class="{'active':index==0}" @click="toNext(0)">待审批</span>
        <span :class="{'active':index==1}" @click="toNext(1)">住校</span>
        <span :class="{'active':index==2}" @click="toNext(2)">走读</span>
      </span>
    </el-row>
    <router-view></router-view>
  </div>
</template>
<script>
  export default{
    data(){
      return {
          index:0
      }
    },
    created:function () {
      this.index=this.$route.params.index||0;
    },
    methods: {
      toNext(idx){
          this.index=idx;
          switch (idx){
            case 0:
                this.$router.push({name:'pendingApproval',params:{}});
                break;
            case 1:
              this.$router.push({name:'liveSchool',params:{index:idx}});
              break;
            case 2:
              this.$router.push({name:'unLiveSchool',params:{index:idx}});
              break;
          }
      }
    }
  }
</script>
<style>
  .studyingWayApproval {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .studyingWayApproval .bread>span{
    padding:0 2rem;
    font-size:1.125rem;
    cursor: pointer;
  }
  .studyingWayApproval .bread>span.active{
    color: #4da1ff;
  }
  .studyingWayApproval .bread>span+span{
    border-left:2px solid #d2d2d2;
  }
  .studyingWayApproval .studyingWayApproval_row {
    margin-top: 2rem;
  }

  .studyingWayApproval .alertsBtn {
    margin: 1.25rem 0;
  }
  .studyingWayApproval .uploadTemplate{
    padding:.6rem 2rem;
  }

  .studyingWayApproval .alertsList .el-table th, .studyingWayApproval .alertsList .el-table td {
    text-align: center;
  }

  .studyingWayApproval h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
    display: inline-block;
  }

  .studyingWayApproval .d_line {
    margin: 1.25rem 0;
  }

  .studyingWayApproval .g-fuzzyInput {
    float: right;
  }
</style>
