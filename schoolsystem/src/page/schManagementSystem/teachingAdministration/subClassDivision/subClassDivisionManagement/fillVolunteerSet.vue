<template>
  <div class="fillVolunteerSet">
    <el-row type="flex" align="middle" class="subClassDivision_title">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <h3>填报志愿设置</h3>
    </el-row>
    <el-row class="alertsBtn">
      <el-button class="delete" title="导出" @click="exportFile">
        <img class="delete_unactive"
             src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
             alt="">
        <img class="delete_active"
             src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
             alt="">
      </el-button>
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        style="width: 100%"
      >
        <el-table-column type="expand">
          <template scope="props">
            <el-table
              :data="props.row.tags"
              border
              style="width: 100%"
              class="childTable"
            >
              <el-table-column
                prop="name"
                label="专业名称">
              </el-table-column>
              <el-table-column
                label="操作">
                <template scope="scope">
                  <span class="deleteMajor" @click="deleteData(scope.row.id)"><i class="el-icon-close"></i></span>
                </template>
              </el-table-column>
            </el-table>
          </template>
        </el-table-column>
        <el-table-column
          prop="type"
          label="名称">
        </el-table-column>
        <el-table-column
          label="操作">
          <template scope="scope">
            <span class="invokeMajor" @click="addSubject('invokeMajor')">调用专业</span>
            <span class="device_line">|</span>
            <span class="edit_primary" @click="addSubject('major')">添加新专业</span>
            <span class="device_line">|</span>
            <span class="edit" @click="deleteData(scope.$index)">删除</span>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
    <el-row class="operationBtns">
      <el-button type="primary" icon="plus" @click="addSubject('subject')">添加科类</el-button>
      <el-button type="primary" @click="addSubject('invokeSubject')">调用科类</el-button>
    </el-row>
    <el-dialog
      title="新增专业"
      :visible.sync="dialogVisible"
      :before-close="handleCloseDialog"
      :modal="false">
      <el-row class="formMsg">
        <el-form ref="form" :model="form" label-width="120px">
          <el-form-item label="专业名字：">
            <el-input placeholder="请输入专业名字" v-model="form.major"></el-input>
          </el-form-item>
        </el-form>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg('subjectName')">确定</el-button>
        <el-button @click="dialogVisible = false">取消</el-button>
      </span>
    </el-dialog>
    <el-dialog
      title="添加新科类"
      :visible.sync="testDialogVisible"
      :before-close="handleCloseDialog"
      :modal="false">
      <el-row class="formMsg">
        <el-form ref="form" :model="testForm" label-width="120px">
          <el-form-item label="科类名称：">
            <el-input placeholder="请输入科类名称" v-model="testForm.subject"></el-input>
          </el-form-item>
        </el-form>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg('subject')">创建</el-button>
        <el-button @click="testDialogVisible = false">取消</el-button>
      </span>
    </el-dialog>
    <el-dialog
      :title="dialogParam.title"
      :visible.sync="invokeDialogVisible"
      :before-close="handleCloseDialog"
      :modal="false" class="invokeMsg">
      <el-row>
        <el-row class="tips">{{dialogParam.tip}}</el-row>
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
              :label="dialogParam.column" sortable>
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
              id:1,
            name: '语文'
          }, {
              id:2,
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
        selectParam: {
          value: ''
        },
        currentPage: 1,
        pageALl: 100,
        dialogVisible: false,
        form: {
          major: ''
        },
        testDialogVisible: false,
        testForm: {
          subject: ''
        },
        invokeDialogVisible: false,
        multipleSelection: [],
        dialogParam:{
            title:'',
          tip:'',
          column:''
        }
      }
    },
    methods: {
      returnFlowchart(){
        this.$router.push('/subClassDivisionHome');
      },
      exportFile(){

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
      addSubject(type){   //打开弹框
        if (type == 'major') {  //添加专业
          this.form.subjectName = '';
          this.dialogVisible = true;
        } else if (type == 'subject') {   //添加科类
          this.testForm.subject = '';
          this.testDialogVisible = true;
        }else if(type=='invokeSubject'){  //调用科类
          this.dialogParam={
            title:'调用科类',
            tip:'请选择科类（可多选）',
            column:'科类名称'
          };
          this.invokeDialogVisible = true;
        }else{   //调用专业
          this.dialogParam={
            title:'调用专业',
            tip:'请选择专业（可多选）',
            column:'专业名称'
          };
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
  .fillVolunteerSet .invokeMajor{
    color: #09baa6;
    cursor: pointer;
  }
  .fillVolunteerSet .el-table__expanded-cell{
    padding:0;
  }
  .fillVolunteerSet .el-table.childTable{

  }
  .fillVolunteerSet .alertsList .el-table.childTable th{
    background-color: #deeefe;
    height:2.5rem;
  }
  .fillVolunteerSet .alertsList .el-table.childTable td{
    height:2.5rem;
    font-size: .875rem;
  }
  .fillVolunteerSet .childTable .el-table__footer-wrapper thead div, .fillVolunteerSet .childTable .el-table__header-wrapper thead div{
    background-color: #deeefe;
    color: #666666;
  }
  .fillVolunteerSet .el-table.childTable td{
    background-color: #f0f0f0;
  }
  .fillVolunteerSet .subjectName + .subjectName {
    margin-left: 1%;
  }

  .fillVolunteerSet .invokeMsg .alertsList {
    min-height: 0;
  }
  .fillVolunteerSet .deleteMajor{
    display: inline-block;
    color: #d2d2d2;
    width:1.5rem;
    height:1.5rem;
    font-size:12px;
    text-align: center;
    line-height:1.5rem;
    border: 2px solid #d2d2d2;
    border-radius: 100%;
    cursor: pointer;
  }
  .fillVolunteerSet .invokeMsg .el-dialog__footer{
    -webkit-box-shadow: 0 -5px 20px -5px #d2d2d2;
    -moz-box-shadow: 0 -5px 20px -5px #d2d2d2;
    box-shadow: 0 -5px 20px -5px #d2d2d2;
  }
  .fillVolunteerSet .invokeMsg .tips{
    color: #999999;
    margin-bottom:1rem;
  }
</style>
