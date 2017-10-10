<template>
  <div class="studentTestAlone">
    <el-row>
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
    </el-row>
    <el-row class="d_line"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
      <el-col :span="18">
        <el-button-group>
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
      >
        <el-table-column
          prop="title"
          label="序号" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="年级" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="班级" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="座号">
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="姓名">
        </el-table-column>
        <el-table-column
          label="操作" sortable>
          <template scope="scope">
            <span class="joinTest" @click="addMsg">
              <i class="el-icon-plus"></i><span>参加考试</span>
            </span>
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
      title="学生单独参加考试"
      :visible.sync="dialogVisible"
      :before-close="handleClose"
      :modal="false"
      class="seatLayout">
      <el-form ref="form" :model="form" label-width="90px" class="testNumber_form">
        <el-form-item label="学生姓名：">
          <span>张三</span>
        </el-form-item>
        <el-form-item label="考号类型：">
          <el-select v-model="form.numberType" placeholder="请选择">
            <el-option label="前缀+流水号" value="1"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="学生考号：">
          <el-input v-model="form.number"></el-input>
        </el-form-item>
      </el-form>
      <el-row class="testNumber_tips">
        提示：单独参加考试的学生仅参与成绩录入，系统将不为该学生安排考场
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg">保存</el-button>
        <el-button @click="dialogVisible = false">关闭</el-button>
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
          publisher: '超级管理员',
          publishPart: 'hjshf',
          date: '2016-05-03 16:16:55',
          vState: '已查阅',
          checked: false
        }, {
          id: 2,
          title: '下雨了',
          type: '通知',
          publisher: 'wy',
          publishPart: 'hjshf',
          date: '2016-05-03 16:16:55',
          vState: '未查阅',
          checked: false
        }, {
          id: 3,
          title: '那是',
          type: '通知',
          publisher: '超级管理员',
          publishPart: 'hjshf',
          date: '2016-05-03 16:16:55',
          vState: '已查阅',
          checked: false
        }],
        searchValue: '',
        currentPage: 1,
        pageALl: 100,
        dialogVisible: false,
        form: {
          numberType: '',
          number: ''
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
      addMsg(){
        this.dialogVisible = true;
        for (let ob in this.form) {
          this.form[ob] = '';
        }
      },
      saveMsg(){
        this.dialogVisible = false;
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
  .studentTestAlone .joinTest {
    color: #20a0ff;
    cursor: pointer;
  }
  .studentTestAlone .joinTest i{
    vertical-align: middle;
    margin-right:.6rem;
  }
  .studentTestAlone .testNumber_tips{
    text-align: center;
  }
  .studentTestAlone .el-select{
    width:100%;
  }
</style>
