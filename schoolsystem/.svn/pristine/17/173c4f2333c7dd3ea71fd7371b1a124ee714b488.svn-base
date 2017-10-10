<template>
  <div class="g-container">
    <header>
      <div class="g-textHeader g-liOneRow">
        <h2>签约生管理</h2>
      </div>
      <div class="g-selection">
        <el-form ref="studentMessge" lable-position="left" :model="dataHeader" label-width="45px">
          <el-form-item label="年级">
            <el-select v-model="dataHeader.gradeId" placeholder="请选择年级">
              <el-option label="六年级" value="6"></el-option>
            </el-select>
          </el-form-item>
        </el-form>
      </div>
    </header>
    <section class="g-section">
      <div class="gs-header g-liOneRow">
        <div class="gs-button alertsBtn">
          <el-button-group>
            <el-button @click="addClick" data-msg="add" class="filt" title="添加">
              <img class="filt_unactive" src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add.png" />
              <img class="filt_active" src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add_highlight.png" />
            </el-button>
            <el-button @click="" data-msg="delete" class="filt" title="删除">
              <img class="filt_unactive" src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_delete.png" />
              <img class="filt_active" src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_delete_highlight.png" />
            </el-button>
            <el-button @click="importNewStudent" data-msg="delete" class="filt" title="批量导入">
              <img class="filt_unactive" src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_leading-in_n.png" />
              <img class="filt_active" src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_leading-in_highlight.png" />
            </el-button>
            <el-button @click="" data-msg="delete" class="filt" title="匹配">
              <img class="filt_unactive" src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/ic_matching_n.png" />
              <img class="filt_active" src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/ic_matching_hignlight.png" />
            </el-button>
          </el-button-group>
        </div>
        <div class="g-fuzzyInput selfCenter">
          <el-input type="text" v-model="fuzzyInput" icon="search" :on-icon-click="fuzzyClick"></el-input>
        </div>
      </div>
      <div class="centerTable alertsList">
        <el-table class="g-NotHover" ref="studentMsgTable" :data="headerButtonData.studentBasicMsg" style="width:100%" @sort-change="sortChange" @selection-change="handleStudentTable">
          <!--show-overflow-tooltip 超出部分省略号显示-->
          <el-table-column type="selection" width="55"></el-table-column>
          <el-table-column label="序号" type="index" width="110"></el-table-column>
          <el-table-column label="准考证号*" prop="name"></el-table-column>
          <el-table-column label="姓名*"></el-table-column>
          <el-table-column label="性别"></el-table-column>
          <el-table-column label="出生日期"></el-table-column>
          <el-table-column label="填报志愿所在区"></el-table-column>
          <el-table-column label="户口所在地"></el-table-column>
          <el-table-column label="民族"></el-table-column>
          <el-table-column label="政治面貌"></el-table-column>
          <el-table-column label="操作" fixed="right">
            <template scope="props">
              <el-button type="text" @click="changeMsg(props.$index)">编辑</el-button>
            </template>
          </el-table-column>
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
    <el-dialog class="headerNotBackground" title="新增年级" :modal="false" :visible.sync="isDialog" size="tiny" :before-close="handlerClose">
      <el-form :model="gradeDialogForm" label-width="140px" label-position="right">
        <el-form-item label="年级代码:">
          <el-input v-model="gradeDialogForm.gradeCode" placeholder="请输入年级代码,如:C2016"></el-input>
        </el-form-item>
        <el-form-item label="年级名称:">
          <el-input v-model="gradeDialogForm.gradeName" placeholder="请输入年级名称,如:高一"></el-input>
        </el-form-item>
        <el-form-item label="所有年级自动升级:">
          <el-switch v-model="gradeDialogForm.update" on-text="是" off-text="否" on-color="#13b5b1"></el-switch>
        </el-form-item>
        <el-form-item label="毕业最高年级">
          <el-switch v-model="gradeDialogForm.maxGrade" on-text="是" off-text="否" on-color="#13b5b1"></el-switch>
        </el-form-item>
      </el-form>
      <div class="g-prompt">
        提示:年级代码高中以<span>G</span>开头,初中以<span>C</span>开头,小学以<span>X</span>开头。
      </div>
      <div class="g-button">
        <el-button type="primary">保存</el-button>
        <el-button @click="cancelCreateGrade">取消</el-button>
      </div>
    </el-dialog>
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
        /*footer*/
        pageALl:1,
        currentPage:1,
        /*弹框*/
        isDialog:false,
        gradeDialogForm:{
          gradeCode:'',
          gradeName:'',
          update:'false',
          maxGrade:'false'
        },
      }
    },
    computed: {},
    methods:{
      /*footer*/
      handleCurrentChange(val) {
        this.currentPage = val;
        console.log(`当前页: ${this.currentPage}`);
      },
      /*弹框*/
      handlerClose(done){
        done();
      },
      /*创建年级按钮*/
      createGrade(){
        this.isDialog=true;
      },
      cancelCreateGrade(){
        this.isDialog=false;
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
      changeMsg(index){
        console.log(index);
        this.$router.push({name:'AddSignUpStudent',params:{id:1}});
      },
      /*添加*/
      addClick(){
        /*编辑1，添加0*/
        this.$router.push({name:'AddSignUpStudent',params:{id:0}});
      },
      /*批量导入*/
      importNewStudent(){
        this.$router.push('/SignUpStudentImport');
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
  @import '../../../style/style';
</style>


