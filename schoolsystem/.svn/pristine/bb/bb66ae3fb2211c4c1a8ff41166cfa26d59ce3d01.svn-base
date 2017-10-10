<template>
  <div class="previousExam">
    <h3>历次考试</h3>
    <el-row type="flex" align="middle" class="grade">
      <span>年级：</span>
      <el-select v-model="form.gradeid" placeholder="请选择" @visible-change="setState" @change="changeData">
        <el-option
          v-for="item in gradeList"
          :key="item.gradeid"
          :label="item.name"
          :value="item.gradeid">
        </el-option>
      </el-select>
    </el-row>
    <el-row class="d_line"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
      <el-button class="delete" title="删除" @click="deleteAlerts">
        <img class="delete_unactive"
             src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete.png"
             alt="">
        <img class="delete_active"
             src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete_highlight.png"
             alt="">
      </el-button>
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        style="width: 100%"
        @selection-change="handleSelectionChange"
      >
        <el-table-column
          type="selection"
          width="55">
        </el-table-column>
        <el-table-column
          prop="examination"
          label="考试名称">
        </el-table-column>
        <el-table-column
          prop="date"
          label="考试日期">
        </el-table-column>
        <el-table-column
          label="成绩是否公布">
          <template scope="scope">
            <span v-if="scope.row.release=='1'">是</span>
            <span v-if="scope.row.release=='0'">否</span>
          </template>
        </el-table-column>
        <el-table-column
          label="操作">
          <template scope="scope">
            <span class="edit" @click="editExam(scope.$index)">编辑</span>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
    <el-dialog
      title="修改信息"
      :visible.sync="dialogVisible"
      :modal="false">
      <el-row class="examName_input">
        <span>考试名称：</span>
        <el-input v-model="activeExam.examination"></el-input>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg">保存</el-button>
        <el-button @click="dialogVisible = false">取消</el-button>
      </span>
    </el-dialog>
  </div>
</template>
<script>
  import req from '@/assets/js/common'
  export default{
    data(){
      return {
        gradeList: [],
        form: {
          gradeid: ''
        },
        state: false,
        tableData: [],
        multipleSelection: [],
        activeExam: {
          examination: '',
          examinationid: ''
        },
        dialogVisible: false
      }
    },
    created: function () {
      var self = this;
      req.ajaxSend('/school/Examination/previousexam/type/exam/typename/findgrade', 'post', '', function (res) {
        self.form.gradeid = res[0].gradeid;
        self.gradeList = res;
        req.ajaxSend('/school/Examination/previousexam/type/exam/typename/findexam', 'post', self.form, function (data) {
          self.tableData = data;
        })
      })
    },
    methods: {
      handleSelectionChange(val) {
        this.multipleSelection = val;
      },
      editExam(idx){
        this.activeExam.examination = this.tableData[idx].examination;
        this.activeExam.examinationid = this.tableData[idx].examinationid;
        this.dialogVisible = true;
      },
      setState(state){   //防止下拉框的change事件在第一次加载是触发
        this.state = state;
      },
      changeData(){
        var self = this;
        if (!self.state) {
          return false;
        }
        req.ajaxSend('/school/Examination/previousexam/type/exam/typename/findexam', 'post', self.form, function (data) {
          self.tableData = data;
        })
      },
      saveMsg(){
        var self = this;
        req.ajaxSend('/school/Examination/previousexam/type/exam/typename/examup', 'post', self.activeExam, function (res) {
          if (res.return) {
            self.$message({
              type: 'success',
              message: '修改成功!',
              showClose: true
            });
            req.ajaxSend('/school/Examination/previousexam/type/exam/typename/findexam', 'post', self.form, function (data) {
              self.tableData = data;
            })
          } else {
            self.$message({
              type: 'error',
              message: '修改失败!',
              showClose: true
            });
          }
        });
        this.dialogVisible = false;
      },
      deleteAlerts(){
        var self = this;
        if (self.multipleSelection.length == 0) {
          self.$message({
            message: '请选择记录！',
            showClose: true
          });
          return false;
        }
        self.$confirm('确定删除?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          var param = {
            examinationid: []
          };
          for (let obj of self.multipleSelection) {
            param.examinationid.push(obj.examinationid)
          }
          param.examinationid = param.examinationid.join(',');
          req.ajaxSend('/school/Examination/previousexam/type/exam/typename/examdel', 'post', param, function (res) {
            if (res.return) {
              self.$message({
                type: 'success',
                message: '删除成功!',
                showClose: true
              });
              req.ajaxSend('/school/Examination/previousexam/type/exam/typename/findexam', 'post', self.form, function (data) {
                self.tableData = data;
              })
            } else {
              self.$message({
                type: 'error',
                message: '删除失败!',
                showClose: true
              });
            }
          })
        }).catch(() => {
        });
      }
    }
  }
</script>
<style>
  .previousExam {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
    font-size: 14px;
  }

  .previousExam h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
  }

  .previousExam .grade {
    margin-top: 2rem;
  }

  .previousExam .d_line {
    margin-top: 1rem;
  }

  .previousExam .el-table td, .previousExam .el-table th {
    text-align: center;
  }

  .previousExam .alertsBtn {
    margin: 1rem 0;
  }

  .previousExam .el-dialog--small {
    width: 600px;
  }

  .previousExam .el-select {
    margin-left: 14px;
  }

  .previousExam .examName_input {
    text-align: center;
  }

  .previousExam .examName_input .el-input {
    width: 300px;
    margin-left: 14px;
  }

  .previousExam .edit {
    color: #ff5b5a;
    cursor: pointer;
  }
</style>
