<template>
  <div class="abnormalMotionOperation">
    <el-row type="flex" align="middle">
      <h3>异动操作</h3>
      <span class="abnormalMotionOperation_bread">
          <span :class="{'active':index==0}" @click="toNext(0)">转班</span>
          <span :class="{'active':index==1}" @click="toNext(1)">转入</span>
          <span :class="{'active':index==2}" @click="toNext(2)">转出</span>
          <span :class="{'active':index==3}" @click="toNext(3)">休学</span>
          <span :class="{'active':index==4}" @click="toNext(4)">复学</span>
          <span :class="{'active':index==5}" @click="toNext(5)">借读</span>
          <span :class="{'active':index==6}" @click="toNext(6)">挂读</span>
          <span :class="{'active':index==7}" @click="toNext(7)">退学</span>
        </span>
    </el-row>
    <router-view></router-view>
  </div>
</template>
<script>
  export default{
    data(){
      return {
        index: 0
      }
    },
    created: function () {
      this.index = this.$route.params.idx || 0;
    },
    methods: {
      toNext(idx){
        this.index = idx;
        switch (idx) {
          case 0:
            this.$router.push({name: 'shiftClass', params: {}});
            break;
          case 1:
            this.$router.push({name: 'into', params: {idx: idx}});
            break;
          case 2:
            this.$router.push({name: 'turnOut', params: {idx: idx}});
            break;
          case 3:
            this.$router.push({name: 'suspendedSchool', params: {idx: idx}});
            break;
          case 4:
            this.$router.push({name: 'recoverSchool', params: {idx: idx}});
            break;
          case 5:
            this.$router.push({name: 'transient', params: {idx: idx}});
            break;
          case 6:
            this.$router.push({name: 'hangRead', params: {idx: idx}});
            break;
          case 7:
            this.$router.push({name: 'dropout', params: {idx: idx}});
            break;
        }
      }
    }
  }
</script>
<style>
  .abnormalMotionOperation {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .abnormalMotionOperation h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
    display: inline-block;
  }

  .abnormalMotionOperation .abnormalMotionOperation_row {
    margin: 1.125rem 0;
  }

  .abnormalMotionOperation .abnormalMotionOperation_bread, .abnormalMotionOperation .abnormalMotionOperation_bread > span {
    display: inline-block;
  }

  .abnormalMotionOperation .abnormalMotionOperation_bread > span {
    font-size: 1.125rem;
    padding: 0 2rem;
    color: #999999;
  }

  .abnormalMotionOperation .abnormalMotionOperation_bread > span + span {
    border-left: 2px solid #d2d2d2;
  }

  .abnormalMotionOperation .abnormalMotionOperation_bread > span.active {
    color: #4da1ff;
  }

  .abnormalMotionOperation .alertsBtn {
    margin: 1.25rem 0;
  }

  .abnormalMotionOperation .alertsList .el-table th, .abnormalMotionOperation .alertsList .el-table td {
    text-align: center;
  }

  .abnormalMotionOperation .edit {
    color: #4da1ff;
    cursor: pointer;
  }

  .abnormalMotionOperation .el-dialog--small {
    width: 600px;
  }

  .abnormalMotionOperation .el-textarea__inner {
    font-family: inherit;
    height: 70px;
  }
</style>
