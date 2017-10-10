<template>
  <div class="personnelManager">
    <el-row type="flex" align="middle">
      <h3>住宿人员管理</h3>
      <span class="breadNav">
          <span :class="{'active':index==0}" @click="toNext(0)">住宿人员管理</span>
          <span :class="{'active':index==1}" @click="toNext(1)">住宿人员明细</span>
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
        if (idx == 0) {
          this.$router.push({name: 'personnelManagement', params: {}});
        } else {
          this.$router.push({name: 'personnelDetail', params: {idx: idx}});
        }
      }
    }
  }
</script>
<style>
  .personnelManager {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .personnelManager h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
    display: inline-block;
  }

  .personnelManager .personnelManagement_row {
    margin: 2rem 0;
  }

  .personnelManager .breadNav {
    display: inline-block;
  }

  .personnelManager .breadNav > span {
    padding: 0 2rem;
    font-size: 1.125rem;
    cursor: pointer;
  }

  .personnelManager .breadNav > span + span {
    border-left: 2px solid #d2d2d2;
  }

  .personnelManager .breadNav > span.active {
    color: #4da1ff;
  }
</style>
