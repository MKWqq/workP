<template>
  <div class="testTime">
    <el-row>
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
    </el-row>
    <el-row class="examManager_row switch" type="flex" align="middle">
      <span>各科考试科目时间（相同科目的考试时间自动同步）：</span>
      <el-switch
        v-model="isPublic"
        on-color="#13b5b1"
        off-color="#ff4949"
        on-text="是"
        off-text="否">
      </el-switch>
    </el-row>
    <el-row class="d_line"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
        <el-button class="delete" title="导出">
          <img class="delete_unactive"
               src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
               alt="">
          <img class="delete_active"
               src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
               alt="">
        </el-button>
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
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        style="width: 100%"
        @sort-change="sort"
      >
        <el-table-column
          prop="type"
          label="科类" sortable>
        </el-table-column>
        <el-table-column
          prop="subject"
          label="科目" sortable>
        </el-table-column>
        <el-table-column
          prop="time"
          label="考试日期" sortable>
        </el-table-column>
        <el-table-column
          prop="startTime"
          label="开考时间">
        </el-table-column>
        <el-table-column
          prop="endTime"
          label="结束时间" sortable>
        </el-table-column>
        <el-table-column
          prop="minutes"
          label="考试时长（分钟）" sortable>
        </el-table-column>
        <el-table-column
          label="操作">
          <template scope="scope">
            <span class="edit" @click="editMsg(scope.$index)">编辑</span>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
    <el-row class="testOperation_btn">
      <el-button type="primary" @click="releaseResults">发布成绩</el-button>
    </el-row>
    <!--<el-row class="pageAlerts">
      <el-pagination
        @current-change="handleCurrentChange"
        :current-page.sync="currentPage"
        :page-size="pageALl"
        layout="prev, pager, next, jumper"
        :total="1000">
      </el-pagination>
    </el-row>-->
    <el-dialog
      title="修改信息"
      :visible.sync="dialogVisible"
      :before-close="handleClose"
      :modal="false">
      <el-row class="testNumber_dialog_body">
        <el-form ref="form" :model="form" label-width="90px" class="testNumber_form">
          <el-form-item label="考试时间：">
            <el-date-picker
              v-model="form.time"
              type="date"
              placeholder="请选择">
            </el-date-picker>
          </el-form-item>
          <el-form-item label="开考时间：">
            <el-time-picker
              v-model="form.startTime"
              placeholder="请选择">
            </el-time-picker>
          </el-form-item>
          <el-form-item label="结束时间：">
            <el-time-picker
              v-model="form.endTime"
              :picker-options="{minTime:form.startTime}"
              placeholder="请选择">
            </el-time-picker>
          </el-form-item>
        </el-form>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg">保存</el-button>
        <el-button @click="dialogVisible = false">取消</el-button>
      </span>
    </el-dialog>
  </div>
</template>
<script>
  export default{
    data(){
      return {
        isPublic: true,
        tableData: [{
          id: 1,
          type:'理科',
          subject:'语文',
          time:'2017-08-25',
          startTime:new Date(1503620795000),
          endTime:'',
          minutes:'150'
        }, {
          id: 2,
          type:'文科',
          subject:'语文',
          time:'2017-08-24',
          startTime:'',
          endTime:'',
          minutes:'150'
        }, {
          id: 3,
          type:'理科',
          subject:'语文',
          time:'2017-08-24',
          startTime:'',
          endTime:'',
          minutes:'150'
        }],
        form:{
            time:'',
          startTime:'',
            endTime:''
        },
        dialogVisible:false,
        currentPage: 1,
        pageALl: 100
      }
    },
    methods: {
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
      editMsg(idx){
        this.dialogVisible = true;
        $.extend(this.form, this.tableData[idx]);
      },
      handleClose(done) {   //关闭弹框
        for (let ob in this.form) {
          this.form[ob] = '';
        }
        done();
      },
      releaseResults(){

      },
      saveMsg(){
          this.dialogVisible=false;
        console.log(this.form);
      }
    }
  }
</script>
<style>
  .testTime .el-date-editor.el-input{
    /*width:100%;*/
  }
  .testTime .edit{
    color: #ff5b5a;
    cursor: pointer;
  }
</style>
