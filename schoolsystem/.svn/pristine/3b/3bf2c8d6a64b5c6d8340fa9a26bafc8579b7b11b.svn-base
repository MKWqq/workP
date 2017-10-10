<template>
  <div class="invigilatorTask">
    <el-row>
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
    </el-row>
    <el-row class="examManager_row">
      <span>应排总监考次数：0</span>
      <span>已排总监考次数：0</span>
      <span>巡考次数：0</span>
      <span>总巡考次数：0</span>
      <span>总安排次数：0</span>
      <span>总人均次数：0</span>
    </el-row>
    <el-row class="d_line"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
      <el-col :span="18">
        <el-button-group>
          <el-button class="filt" title="添加" @click="addMsg(0)">
            <img class="filt_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add.png"
                 alt="">
            <img class="filt_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add_highlight.png"
                 alt="">
          </el-button>
          <el-button class="delete" title="删除" @click="deleteAlerts">
            <img class="delete_unactive"
                 src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete.png"
                 alt="">
            <img class="delete_active"
                 src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete_highlight.png"
                 alt="">
          </el-button>
        </el-button-group>
        <el-button-group class="secBtn-group">
          <el-button class="filt" title="复制">
            <img class="filt_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png"
                 alt="">
            <img class="filt_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png"
                 alt="">
          </el-button>
          <el-button class="delete" title="打印">
            <img class="delete_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png"
                 alt="">
            <img class="delete_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png"
                 alt="">
          </el-button>
        </el-button-group>
      </el-col>
      <el-col :span="6">
        <div class="g-fuzzyInput">
          <el-input
            placeholder="请选择日期"
            icon="search"
            v-model="searchValue"
            :on-icon-click="goSearch">
          </el-input>
        </div>
      </el-col>
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        style="width: 100%"
        @sort-change="sort"
        @selection-change="handleSelectionChange"
      >
        <el-table-column
          type="selection"
          width="55">
        </el-table-column>
        <el-table-column
          prop="title"
          label="序号" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="姓名" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="任教科类" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="任教学科" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="监考次数" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="巡考次数" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="总巡考次数" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="安排次数" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="班主任" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="工作人员" sortable>
        </el-table-column>
        <el-table-column
          label="操作">
          <template scope="scope">
            <span class="delete" @click="addMsg(1)">编辑</span>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
    <el-row class="pageAlerts">
      <el-pagination
        @current-change="handleCurrentChange"
        :current-page.sync="currentPage"
        :page-size="pageALl"
        layout="prev, pager, next, jumper"
        :total="1000">
      </el-pagination>
    </el-row>
    <el-dialog
      title="教师名单"
      size="large"
      :visible.sync="dialogVisible"
      :before-close="handleClose"
      :modal="false"
      class="seatLayout">
      <el-row class="search">
        <div class="g-fuzzyInput">
          <el-input
            placeholder="请选择日期"
            icon="search"
            v-model="searchValue"
            :on-icon-click="goSearch">
          </el-input>
        </div>
      </el-row>
      <el-row class="alertsList">
        <el-table
          :data="tableData"
          style="width: 100%"
          @sort-change="sort"
          @selection-change="handleSelectionChange"
        >
          <el-table-column
            type="selection"
            width="55">
          </el-table-column>
          <el-table-column
            prop="type"
            label="姓名" sortable>
          </el-table-column>
          <el-table-column
            prop="type"
            label="年级" sortable>
          </el-table-column>
          <el-table-column
            prop="type"
            label="科类" sortable>
          </el-table-column>
          <el-table-column
            prop="type"
            label="科目" sortable>
          </el-table-column>
        </el-table>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg">选择</el-button>
        <el-button @click="dialogVisible = false">取消</el-button>
      </span>
    </el-dialog>
    <el-dialog
      title="修改信息"
      :visible.sync="editDialogVisible"
      :before-close="handleClose"
      :modal="false">
      <el-row class="testNumber_dialog_body">
        <el-form ref="form" :model="message" label-width="120px">
          <el-form-item label="监考次数：">
            <el-input v-model="message.invigilatorNum"></el-input>
          </el-form-item>
          <el-form-item label="巡考次数：">
            <el-input v-model="message.patrolNum"></el-input>
          </el-form-item>
          <el-form-item label="总巡考次数：">
            <el-input v-model="message.patrolAllNum"></el-input>
          </el-form-item>
        </el-form>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg">保存</el-button>
        <el-button @click="editDialogVisible = false">取消</el-button>
      </span>
    </el-dialog>
  </div>
</template>
<script>
  export default{
    data(){
      return {
        tableData: [{
          id: 1,
          title: '今天天气不错啊',
          type: '通知',
          publisher: 2,
          publishPart: 'hjshf',
          date: '2016-05-03 16:16:55',
          vState: '已查阅',
          invigilator:true,
          patrolNum: true,
          allPatrolNum: true
        }, {
          id: 2,
          title: '下雨了',
          type: '通知',
          publisher: 1,
          publishPart: 'hjshf',
          date: '2016-05-03 16:16:55',
          vState: '未查阅',
          invigilator:true,
          patrolNum: true,
          allPatrolNum: true
        }, {
          id: 3,
          title: '那是',
          type: '通知',
          publisher: 2,
          publishPart: 'hjshf',
          date: '2016-05-03 16:16:55',
          vState: '已查阅',
          invigilator:true,
          patrolNum: true,
          allPatrolNum: true
        }],
        searchValue: '',
        multipleSelection: [],
        currentPage: 1,
        pageALl: 100,
        dialogVisible: false,
        editDialogVisible:false,
        message:{
          invigilatorNum: '',
          patrolNum: '',
          patrolAllNum: ''
        }
      }
    },
    methods: {
      goSearch(ev) {  //查询
        console.log(ev);
      },
      sort(column){
        console.log(column);
      },
      handleSelectionChange(val) {
        this.multipleSelection = val;
      },
      handleCurrentChange(val) {
        this.currentPage = val;
        console.log(`当前页: ${this.currentPage}`);
      },
      returnFlowchart(){
        this.$router.push('/examManagerHome');
      },
      handleClose(done) {   //关闭弹框
        done();
      },
      addMsg(val){
          if(val==0){
            this.dialogVisible = true;
          }else{
              this.editDialogVisible=true;
          }
      },
      saveMsg(){
        this.dialogVisible = false;
        this.editDialogVisible = false;
      },
      deleteAlerts(){
        if (this.multipleSelection.length == 0) {
          this.$message({
            message: '请选择记录！',
            showClose: true
          });
          return false;
        }
        this.$confirm('此操作将永久删除该文件, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          console.log(this.multipleSelection);
          this.$message({
            type: 'success',
            message: '删除成功!'
          });
        }).catch(() => {
        });
      }
    }
  }
</script>
<style>
  .invigilatorTask .el-dialog--large {
    width: 1000px;
  }

  .invigilatorTask .seatLayout .el-dialog__footer {
    -webkit-box-shadow: 0 -8px 30px -10px #d2d2d2;
    -moz-box-shadow: 0 -8px 30px -10px #d2d2d2;
    box-shadow: 0 -8px 30px -10px #d2d2d2;
    text-align: right;
  }
  .invigilatorTask .delete{
    color: #ff5b5a;
    cursor: pointer;
  }
  .invigilatorTask .search{
    margin-bottom:30px;
  }
  .invigilatorTask .testNumber_dialog_body{
    padding:0 60px;
  }
</style>
