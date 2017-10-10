<template>
  <div class="g-container">
    <header class="g-importCourseHeader">
      <div class="g-textHeader g-flexStartRow">
        <el-button class="g-gobackChart g-imgContainer RedButton" @click="goBackChart">
          <img src="../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
          返回流程图
        </el-button>
        <h2 class="selfCenter">分班合成成绩情况</h2>
      </div>
    </header>
    <div class="g-container g-containerNoPadding">
      <section class="g-section">
        <div class="gs-header g-liOneRow">
          <div class="gs-button alertsBtn">
            <el-button-group>
              <el-button @click="" data-msg="export" class="filt buttonChild" title="导出">
                <img class="filt_unactive"  src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png" />
                <img class="filt_active" src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png" />
              </el-button>
            </el-button-group>
            <el-button-group class="elGroupButton_two">
              <el-button @click="" data-msg="copy" class="filt buttonChild" title="复制">
                <img class="filt_unactive"  src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png" />
                <img class="filt_active" src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png" />
              </el-button>
            </el-button-group>
          </div>
          <div class="gs-refresh g-fuzzyInput">
            <el-input type="text" v-model="fuzzyInput" icon="search" :on-icon-click="fuzzyClick"></el-input>
          </div>
        </div>
        <div class="gs-table centerTable alertsList">
          <el-table class="g-NotHover" border ref="studentMsgTable" :data="headerButtonData.studentBasicMsg" style="width:100%" @sort-change="sortChange" @selection-change="handleStudentTable">
            <!--show-overflow-tooltip 超出部分省略号显示-->
            <el-table-column label="姓名"></el-table-column>
            <el-table-column label="性别" sortable></el-table-column>
            <el-table-column label="总分" sortable></el-table-column>
            <el-table-column label="八年级期末考试">
              <el-table-column label="语文"></el-table-column>
              <el-table-column label="数学"></el-table-column>
            </el-table-column>
          </el-table>
        </div>
      </section>
    </div>
  </div>
</template>
<script>
  import {} from '@/api/http'
  export default{
    data(){
      return{
        /*ajax data*/
        headerButtonData:{
          studentBasicMsg:[1],
        },
        /*fuzzyFilter*/
        fuzzyInput:'',
      }
    },
    computed: {},
    methods:{
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'newStudentClass'});
      },
      /*table*/
      handleStudentTable(section){
        /*section为选择项行信息组成的数组*/
        console.log(section);
      },
      sortChange(column){
        /*table排序回调*/
        console.log(column)
      },
      /*编辑*/
      changeClick(index){
        this.isDialog=true;
        this.dialogTitle='编辑信息';
        console.log(index);
      },
      /*header的button群*/
      /*模糊查询*/
      fuzzyClick(){
        /*点击search按钮*/
        console.log('模糊查询');
      },
      /*弹框*/
      /*关闭按钮点击*/
      handlerClose(done){
        done();
      },
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../style/style';
  .g-importCourse .g-container .g-section{margin:1.25rem 0;width:100%;}
  /*弹框*/
  .headerNotBackground{
    .dialogHeader{position:absolute;right:20px;top:0.625rem;
      button{.border-radius(1rem);}
    }
    .dialogSection{
      .NotAllWidth{width:auto;}
      .defineInputWidth{.widthRem(60);}
    }
  }
  .g-textHeader{
    h2{.marginLeft(40,1582);}
  }
</style>








