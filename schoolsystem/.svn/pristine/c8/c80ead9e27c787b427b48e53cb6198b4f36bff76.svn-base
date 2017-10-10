<template>
  <div class="subScoreBasis">
    <el-row type="flex" align="middle" class="subClassDivision_title">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <h3>分班成绩依据</h3>
    </el-row>
    <el-row class="subClassDivision_row warmHint">
      温馨提示：学生分班成绩可以在'成绩管理'中的数据基础上进行修改，而不影响其他原来的成绩数据
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        style="width: 100%"
        @sort-change="sort"
      >
        <el-table-column
          type="index"
          width="100"
          label="序号">
        </el-table-column>
        <el-table-column
          prop="type"
          label="考试名称" sortable>
        </el-table-column>
        <el-table-column
          label="依据科目">
          <template scope="scope">
            <el-row class="l_name">
              <el-tag
                color="#f08bc5"
                v-for="tag in scope.row.tags"
                :key="tag.name"
                :closable="true" class="subjectName"
                @close="handleClose(tag,scope.$index)"
                close-transition
              >
                {{tag.name}}
              </el-tag>
              <span class="addSubject" @click="addSubject('subjectName')"><i class="el-icon-plus"></i></span>
            </el-row>
          </template>
        </el-table-column>
        <el-table-column
          label="操作">
          <template scope="scope">
            <span class="edit_primary" @click="toNext">成绩管理</span>
            <span class="device_line">|</span>
            <span class="edit" @click="addSubject('edit',scope.$index)">编辑</span>
            <span class="device_line">|</span>
            <span class="edit" @click="deleteData(scope.$index)">删除</span>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
    <el-row class="operationBtns">
      <el-button type="primary" icon="plus" @click="addSubject('subject')">添加依据</el-button>
      <el-button type="primary" @click="addSubject('invoke')">调用考试</el-button>
    </el-row>
    <!--<el-row class="pageAlerts" v-if="tableData.length!=0">
      <el-pagination
        @current-change="handleCurrentChange"
        :current-page.sync="currentPage"
        :page-size="pageALl"
        layout="prev, pager, next, jumper"
        :total="1000">
      </el-pagination>
    </el-row>-->
    <el-dialog
      title="添加依据科目"
      :visible.sync="dialogVisible"
      :before-close="handleCloseDialog"
      :modal="false">
      <el-row class="formMsg">
        <el-form ref="form" :model="form" label-width="120px">
          <el-form-item label="科目名称：">
            <el-input v-model="form.subjectName"></el-input>
          </el-form-item>
        </el-form>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg('subjectName')">保存</el-button>
        <el-button @click="dialogVisible = false">取消</el-button>
      </span>
    </el-dialog>
    <el-dialog
      :title="testTitle"
      :visible.sync="testDialogVisible"
      :before-close="handleCloseDialog"
      :modal="false">
      <el-row class="formMsg">
        <el-form ref="form" :model="testForm" label-width="120px">
          <el-form-item label="考试名称：">
            <el-input v-model="testForm.subject"></el-input>
          </el-form-item>
        </el-form>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg('subject')">保存</el-button>
        <el-button @click="testDialogVisible = false">取消</el-button>
      </span>
    </el-dialog>
    <el-dialog
      title="调用考试"
      size="large"
      :visible.sync="invokeDialogVisible"
      :before-close="handleCloseDialog"
      :modal="false" class="invokeMsg">
      <el-row>
        <el-row class="search">
          <div class="g-fuzzyInput">
            <el-input
              placeholder="请输入任教科目/姓名"
              icon="search"
              v-model="selectParam.value"
              :on-icon-click="goSearch">
            </el-input>
          </div>
        </el-row>
        <el-row class="alertsList">
          <el-table
            :data="tableData"
            max-height="400"
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
              label="年级" sortable>
            </el-table-column>
            <el-table-column
              prop="type"
              label="考试名称" sortable>
            </el-table-column>
          </el-table>
        </el-row>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg('invoke')">选择</el-button>
        <el-button @click="invokeDialogVisible = false">取消</el-button>
      </span>
    </el-dialog>
  </div>
</template>
<script>
  import req from '@/assets/js/common'
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
          checked: false,
          tags: [{
            name: '语文'
          }, {
            name: '数学'
          }]
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
        selectParam: {
          value: ''
        },
        currentPage: 1,
        pageALl: 100,
        dialogVisible: false,
        form: {
          subjectName: ''
        },
        testTitle: '',
        testDialogVisible: false,
        testForm: {
          subject: ''
        },
        invokeDialogVisible: false,
        multipleSelection: []
      }
    },
    methods: {
      returnFlowchart(){
        this.$router.push('/subClassDivisionHome');
      },
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
      addSubject(type, idx){   //打开弹框
        if (type == 'subjectName') {  //添加依据科目
          this.form.subjectName = '';
          this.dialogVisible = true;
        } else if (type == 'subject') {
          this.testForm.subject = '';
          this.testTitle = '添加依据考试';
          this.testDialogVisible = true;
        } else if (type == 'edit') {
          this.testTitle = '修改依据考试';
          this.testForm.subject = this.tableData[idx].publisher;
          this.testDialogVisible = true;
        } else {  //调用考试
          this.invokeDialogVisible = true;
        }
      },
      handleSelectionChange(val) {  //调用考试选择
        this.multipleSelection = val;
      },
      handleCloseDialog(done){   //关闭弹框
        done();
      },
      handleClose(tag, idx) {  //删除依据科目
//            this.tableData[idx].tags.splice(this.tableData[idx].tags.indexOf(tag), 1);
        this.$confirm('此操作将永久删除该文件, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          console.log(this.tableData[idx].tags.indexOf(tag));
          this.$message({
            type: 'success',
            message: '删除成功!',
            showClose: true
          });
        }).catch(() => {
        });
      },
      deleteData(idx){    //删除考试
        this.tableData.splice(idx, 1);
      },
      toNext(){  //进入成绩管理
        this.$router.push('/subClassDivisionHome/scoresManagement');
      },
      saveMsg(type){   //保存信息
        if (type == 'subjectName') {   //依据字段
          this.dialogVisible = false;
        } else if (type == 'subject') {   //依据考试
          this.testDialogVisible = false;
        } else {    //调用考试
          this.invokeDialogVisible = false;
          console.log(this.multipleSelection);
        }
      }
    }
  }
</script>
<style>
  .subScoreBasis .subjectName + .subjectName {
    margin-left: 1%;
  }

  .subScoreBasis .addSubject {
    width: 1.25rem;
    height: 1.25rem;
    border-radius: 5px;
    border: 1px solid #f08bc5;
    font-size: .75rem;
    color: #f08bc5;
    display: inline-block;
    line-height: 1.25rem;
    cursor: pointer;
    text-align: center;
  }

  .subScoreBasis .l_name {
    text-align: left;
  }

  .subScoreBasis .invokeMsg .search {
    margin-bottom: 1.5rem;
  }

  .subScoreBasis .invokeMsg .el-dialog__footer {
    text-align: right;
  }

  .subScoreBasis .invokeMsg .alertsList {
    min-height: 0;
  }
</style>
