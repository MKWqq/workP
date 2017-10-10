<template>
  <div class="g-container">
    <header class="g-textHeader">
      <div class="g-flexStartRow">
        <el-button class="g-gobackChart g-imgContainer RedButton" @click="goBackChart">
          <img src="../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
          返回上一步
        </el-button>
        <h2 class="selfCenter">导入成绩</h2>
      </div>
    </header>
    <section class="g-section">
      <div class="g-examEntry g-liOneSpaceRow">
        <el-progress class="g-examChart" :width="100" type="circle" :percentage="25" :stroke-width="10"></el-progress>
        <div class="g-examTextContainer">
          <h4>语文</h4>
          <div class="g-examTextRow">
            <span>总数:</span><span v-text="">1286</span>
          </div>
          <div class="g-examTextRow">
            <span>已录:</span><span v-text="">469</span>
          </div>
          <div class="g-examTextRow">
            <span>未录:</span><span v-text="">817</span>
          </div>
        </div>
        <el-button @click="examEntryClick" type="primary" class="radiusButton examRadiusButton">成绩录入</el-button>
      </div>
    </section>
  </div>
</template>
<script>
  import {} from '@/api/http'
  export default{
    data(){
      return{
      }
    },
    computed: {},
    methods:{
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'organizeResults'});
      },
      /*成绩录入*/
      examEntryClick(){
        this.$router.push('/scoreEntry');
      },
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../style/style';
  .g-textHeader{
    .marginBottom(30);
    h2{.marginLeft(40,1582);}
  }
</style>








