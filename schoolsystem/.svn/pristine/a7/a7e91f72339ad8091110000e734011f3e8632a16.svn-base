<template>
  <div class="g-container">
    <header class="g-header">
      <div class="g-textHeader g-flexStartRow">
        <el-button @click="goBackParent" class="g-gobackChart g-imgContainer RedButton">
          <img src="../../../assets/img/commonImg/icon_return.png" />
          返回
        </el-button>
        <h2 class="selfCenter">批量导入新生</h2>
      </div>
      <div class="g-prompt">新生人数：  <span v-text="">645</span>    参与分班人数：  <span v-text="">645</span>        提示：本表自动同步新生名单，如需要修改，请到新生管理中修改！</div>
    </header>
    <section class="g-section">
      <div class="gs-table alertsList">
        <el-table ref="studentMsgTable" :data="headerButtonData.studentBasicMsg" style="width:100%" @sort-change="sortChange" @selection-change="handleStudentTable">
          <!--show-overflow-tooltip 超出部分省略号显示-->
          <el-table-column label="序号" sortable></el-table-column>
          <el-table-column label="班级"></el-table-column>
          <el-table-column label="座号" sortable></el-table-column>
          <el-table-column label="姓名" sortable></el-table-column>
          <el-table-column label="性别" sortable></el-table-column>
          <el-table-column label="手机号" sortable></el-table-column>
          <el-table-column label="科类" sortable></el-table-column>
        </el-table>
      </div>
    </section>
    <footer class="g-footer">
      <el-row class="pageAlerts">
        <el-pagination
          @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-size="pageALl"
          layout="prev, pager, next, jumper"
          :total="1000">
        </el-pagination>
      </el-row>
    </footer>
  </div>
</template>
<script>
  import {fileTypeCheck} from '@/assets/js/common'
  import {studentImportUpload} from '@/api/http'
  export default{
    data(){
      return{
        /*ajax data*/
        headerButtonData:{
          gradeloadData:[],
          classesLoadData:[],
          msgTypeLoadData:[],
          studentBasicMsg:[],
        },
        /*footer*/
        pageALl:1,
        currentPage:1,
        /*表单验证规则*/
        importFormRules:{
          fileName:[
            {required:true,message:'请选择文件!'}
          ],
        }
      }
    },
    computed: {},
    methods:{
      /*返回*/
      goBackParent(){
        this.$router.push('/newStudentClass');
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
      /*footer*/
      handleCurrentChange(val) {
        this.currentPage = val;
        console.log(`当前页: ${this.currentPage}`);
      },
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../style/style';
  .g-container{
    .g-textHeader{
      h2{.marginLeft(40,1582);}
    }
    .g-prompt{text-align:left;padding-top:20/16rem;}
  }
</style>


