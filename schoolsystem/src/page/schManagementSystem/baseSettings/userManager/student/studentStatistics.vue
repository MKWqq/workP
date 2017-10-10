<template>
  <div class="g-container">
    <header class="g-header">
      <div class="gh-header">信息管理</div>
      <div class="gh-section clear_fix">
        <el-form ref="studentMessge" lable-position="left" :model="dataHeader" label-width="75px">
          <el-form-item label="年级">
            <el-select class="g-select" value="6" placeholder="请选择年级">
              <el-option label="六年级" value="6"></el-option>
            </el-select>
          </el-form-item>
        </el-form>
      </div>
      <div class="gh-buttonGroup clear_fix">
        <el-button icon="reset">重置</el-button>
        <el-button type="primary">查询</el-button>
      </div>
    </header>
    <section class="g-section">
      <div class="gs-header">
        <div class="gs-button">
          <el-button-group>
            <el-button @click="buttonClick" data-msg="filter" class="buttonChild" title="筛选">
              <img src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_flit.png" />
              <img v-show="false" src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_flit_highlight.png" />
            </el-button>
            <el-button @click="buttonClick" data-msg="export" class="buttonChild" title="导出">
              <img src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png" />
              <img v-show="false" src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png" />
            </el-button>
          </el-button-group>
          <el-button-group class="elGroupButton_two">
            <el-button @click="buttonClick" data-msg="copy" class="buttonChild" title="复制">
              <img src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png" />
              <img v-show="false" src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png" />
            </el-button>
            <el-button @click="buttonClick" data-msg="print" class="buttonChild" title="打印预览">
              <img src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png" />
              <img v-show="false" src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png" />
            </el-button>
          </el-button-group>
        </div>
        <div class="gs-refresh g-fuzzyInput">
          <el-input type="text" v-model="fuzzyInput" icon="search" :on-icon-click="fuzzyClick"></el-input>
        </div>
      </div>
      <div class="gs-table alertsList">
        <el-table ref="studentMsgTable" :data="headerButtonData.studentBasicMsg" style="width:100%" @sort-change="sortChange" @selection-change="handleStudentTable">
          <!--show-overflow-tooltip 超出部分省略号显示-->
          <el-table-column label="班级"></el-table-column>
          <el-table-column label="在读" sortable></el-table-column>
          <el-table-column label="借读" sortable></el-table-column>
          <el-table-column label="休学" sortable></el-table-column>
          <el-table-column label="挂靠" sortable></el-table-column>
          <el-table-column label="男生在校" sortable></el-table-column>
          <el-table-column label="女生在校" sortable></el-table-column>
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
        /*form表单双向绑定数据*/
        dataHeader:{},
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
        /*footer*/
        pageALl:1,
        currentPage:1,
      }
    },
    computed: {},
    methods:{
      /*footer*/
      handleCurrentChange(val) {
        this.currentPage = val;
        console.log(`当前页: ${this.currentPage}`);
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
      /*mine*/
      buttonClick(event){
        const e=$(event.currentTarget),targetMsg=e.data('msg');
        if(targetMsg=='add'){
          this.isDialog=true;
        }else if(targetMsg=='filter'){
          this.isFilter=!this.isFilter;
        }
        this.changeButtonCss(e);
      },
      changeButtonCss(target){
        const index=$('.buttonChild').index(target);
        for(let i=0,len=$('.buttonChild').length;i<len;i++){
          if(i==index){
            /*修改css*/
            if(index % 2==0){
              /*even*/
              target.css({background:'#4da1ff',borderColor:'#4da1ff'});
            }else{
              target.css({background:'#ff5b5b',borderColor:'#ff5b5b'});
            }
            /*修改img*/
            target.find('img').eq(0).css({display:'none'});
            target.find('img').eq(1).css({display:'inline-block'});
          }else{
            /*修改img*/
            $('.buttonChild').eq(i).find('img').eq(0).css({display:'inline-block'});
            $('.buttonChild').eq(i).find('img').eq(1).css({display:'none'});
            /*修改css*/
            $('.buttonChild').eq(i).css({background:'',borderColor:''});
          }
        }
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
  @import '../../../../../style/userManager/student/studentMessage.less';
  @import '../../../../../style/userManager/student/studentManager.css';
</style>


