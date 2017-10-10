<template>
  <div class="g-container">
    <header>
      <div class="g-textHeader g-liOneRow">
        <h2>填写任务</h2>
      </div>
    </header>
    <section class="g-section">
      <div class="gs-header g-liOneRow">
        <div class="gs-button alertsBtn">
          <el-button-group>
            <el-button @click="" data-msg="export" class="filt" title="导出">
              <img class="filt_unactive" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png" />
              <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png" />
            </el-button>
          </el-button-group>
          <el-button-group class="elGroupButton_two">
            <el-button @click="" data-msg="copy" class="filt" title="复制">
              <img class="filt_unactive" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png" />
              <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png" />
            </el-button>
            <el-button @click="" data-msg="print" class="filt" title="打印">
              <img class="filt_unactive" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png" />
              <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png" />
            </el-button>
          </el-button-group>
        </div>
        <div class="g-fuzzyInput selfCenter">
          <el-input type="text" v-model="fuzzyInput" icon="search" :on-icon-click="fuzzyClick"></el-input>
        </div>
      </div>
      <div class="centerTable alertsList">
        <el-table class="g-NotHover" ref="studentMsgTable" :data="headerButtonData.studentBasicMsg" style="width:100%" @sort-change="sortChange" @selection-change="handleStudentTable">
          <el-table-column label="问卷名" prop="name"></el-table-column>
          <el-table-column label="发布者"></el-table-column>
          <el-table-column label="发布时间"></el-table-column>
          <el-table-column label="是否提交"></el-table-column>
          <el-table-column label="操作" fixed="right">
            <template scope="props">
              <el-button type="text" v-if="true" @click="handlerQuestionNaire">填写</el-button>
              <el-button type="text" v-else @click="scanQuestionNaire">查看</el-button>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </section>
  </div>
</template>
<script>
  import {} from '@/api/http'
  export default{
    data(){
      return{
        /*ajax data*/
        headerButtonData:{
          gradeloadData:[],
          classesLoadData:[],
          msgTypeLoadData:[],
          studentBasicMsg:[{name:1}],
        },
        /*form表单双向绑定数据*/
        dataHeader:{
          gradeId:'',
        },
        /*table*/
        isFilter: false,
        tableData: [
          {
            serialNum:'1',
            classes:'1',
            seatNum:'1',//座位号
            name: 'hhh',
            sex: '女',
            sexNum: 0,
            tel: '123565566',
            section:'文科'//科类
          }
        ],
        sortList: {   //排序按钮
          serialNum:{
            filterText:''
          },
          classes:{
            filterText:''
          },
          seatNum:{
            filterText:''
          },
          name: {
            filterText: ''
          },
          sex: {
            filterText: ''
          },
          tel: {
            filterText: ''
          },
          section:{
            filterText:''
          }
        },
        /*fuzzyFilter*/
        fuzzyInput:'',
      }
    },
    computed: {},
    methods:{
      /*table*/
      handleStudentTable(section){
        /*section为选择项行信息组成的数组*/
        console.log(section);
      },
      sortChange(column){
        /*table排序回调*/
        console.log(column)
      },
      /*查看*/
      scanQuestionNaire(){
        this.$router.push({name:'scanQuestionNaire',params:{id:2}});
      },
      /*填写问卷*/
      handlerQuestionNaire(){
        this.$router.push({name:'handlerQuestionNaire'});
      },
      /*模糊查询*/
      fuzzyClick(){
        /*点击search按钮*/
        console.log('模糊查询');
      },
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/style';
</style>


