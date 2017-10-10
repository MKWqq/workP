<template>
  <div class="g-statisticalAnalysis g-container">
    <header class="g-textHeader">
      <h2>考评记录</h2>
      <div class="g-liOneRow g-sa_header_search">
        <div class="gs-button alertsBtn">
          <el-button-group>
            <el-button data-msg="export" class="filt buttonChild" title="导出">
              <img class="filt_unactive"  src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png" />
              <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png" />
            </el-button>
          </el-button-group>
          <el-button-group class="elGroupButton_two">
            <el-button data-msg="copy" class="filt buttonChild" title="复制">
              <img class="filt_unactive"  src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png" />
              <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png" />
            </el-button>
            <el-button  data-msg="print" class="filt buttonChild" title="打印预览">
              <img class="filt_unactive"  src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png" />
              <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png" />
            </el-button>
          </el-button-group>
        </div>
        <div class="gs-refresh g-fuzzyInput">
          <el-input type="text" v-model="fuzzyInput" icon="search" placeholder="班级/姓名" :on-icon-click="fuzzyClick"></el-input>
        </div>
      </div>
    </header>
    <section class="centerTable alertsList">
      <el-table class="g-NotHover" :data="classesTimeSetTable">
        <el-table-column label="考评名称"></el-table-column>
        <el-table-column label="创建时间" prop="name"></el-table-column>
        <el-table-column label="考评进度">
          <template scope="props">
            <el-progress :text-inside="true" :stroke-width="20" :percentage="70"></el-progress>
          </template>
        </el-table-column>
        <el-table-column label="开始时间"></el-table-column>
        <el-table-column label="截止时间"></el-table-column>
        <el-table-column label="操作" fixd="right">
          <template scope="props">
            <el-button type="text">发布成绩</el-button>
            <el-button class="deleteColor" type="text">删除</el-button>
          </template>
        </el-table-column>
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
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'evaluationManagement'});
      },
      /*模糊查询*/
      fuzzyClick(){
        /*模糊查询执行回调*/
      },
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/style';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.css';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.less';
  .g-sa_header_search{.marginTop(32);.marginBottom(20);}
</style>


