<template>
  <div class="classGradeManagement">
    <h3>班/年级管理</h3>
    <el-row class="classGradeManagement_row">
      <el-form :inline="true">
        <el-form-item label="年级：">
          <el-select v-model="testNumber" placeholder="请选择" class="grade">
            <el-option
              v-for="item in testNumbers"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" icon="search" class="search">查询</el-button>
        </el-form-item>
      </el-form>
    </el-row>
    <el-row class="d_line classGradeManagement_row"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
      <el-button-group>
        <el-button class="filt" title="添加" @click="operationClass('add')">
          <img class="filt_unactive"
               src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add.png"
               alt="">
          <img class="filt_active"
               src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add_highlight.png"
               alt="">
        </el-button>
        <el-button class="delete" title="导出">
          <img class="delete_unactive"
               src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
               alt="">
          <img class="delete_active"
               src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
               alt="">
        </el-button>
        <el-button class="delete" title="删除" @click="deleteData">
          <img class="delete_unactive"
               src="../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete.png"
               alt="">
          <img class="delete_active"
               src="../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete_highlight.png"
               alt="">
        </el-button>
      </el-button-group>
      <el-button-group class="secBtn-group">
        <el-button class="filt" title="复制">
          <img class="filt_unactive"
               src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png"
               alt="">
          <img class="filt_active"
               src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png"
               alt="">
        </el-button>
        <el-button class="delete" title="打印">
          <img class="delete_unactive"
               src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png"
               alt="">
          <img class="delete_active"
               src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png"
               alt="">
        </el-button>
      </el-button-group>
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        style="width: 100%"
        @selection-change="handleSelectionChange"
        @sort-change="sort"
      >
        <el-table-column
          type="selection"
          width="55">
        </el-table-column>
        <el-table-column
          prop="title"
          label="班级名称" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="班级人数" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="科类" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="班级专业">
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="班级级别" sortable>
        </el-table-column>
        <el-table-column
          label="操作">
          <template scope="scope">
            <span class="edit" @click="operationClass('edit',scope.$index)">编辑</span>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
    <el-row class="createBtn">
      <el-button type="primary" icon="plus" @click="createGrade">创建年级</el-button>
    </el-row>
    <!-- <el-row class="pageAlerts">
       <el-pagination
         @current-change="handleCurrentChange"
         :current-page.sync="currentPage"
         :page-size="pageALl"
         layout="prev, pager, next, jumper"
         :total="1000">
       </el-pagination>
     </el-row>-->
    <el-dialog
      title="新增年级"
      :visible.sync="dialogVisible"
      :modal="false"
      :before-close="handleClose">
      <el-row type="flex" justify="center">
        <el-col :span="20" class="gradeForm">
          <el-form ref="form" :model="gradeForm" label-width="150px">
            <el-form-item label="年级代码：">
              <el-input placeholder="请输入班级代码，如：C2016" v-model="gradeForm.gradeNum"></el-input>
            </el-form-item>
            <el-form-item label="年级名称：">
              <el-input placeholder="请输入年级名称，如：高一" v-model="gradeForm.gradeName"></el-input>
            </el-form-item>
            <el-form-item label="所有年级自动升级：">
              <el-switch on-text="是" off-text="否" on-color="#09baa7" off-color="#ff4949"
                         v-model="gradeForm.autoUpgrade"></el-switch>
            </el-form-item>
            <el-form-item label="毕业最高年级：">
              <el-switch on-text="是" off-text="否" on-color="#09baa7" off-color="#ff4949"
                         v-model="gradeForm.maxGrade"></el-switch>
            </el-form-item>
          </el-form>
          <el-row class="tip">
            提示：年级代码高中以 <span class="spec">G</span> 开头，初中以 <span class="spec">C</span> 开头，小学以 <span class="spec">X</span>
            开头。
          </el-row>
        </el-col>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="save('grade')">保存</el-button>
        <el-button @click="dialogVisible = false">取消</el-button>
      </span>
    </el-dialog>
    <el-dialog
      :title="classFormTitle"
      :visible.sync="classDialogVisible"
      :modal="false"
      :before-close="handleClose">
      <el-row type="flex" justify="center">
        <el-col :span="18" class="classForm">
          <el-form ref="classForm" :model="classForm" label-width="100px">
            <el-form-item label="班级名称：">
              <el-input placeholder="请输入班级名称，如：1班" v-model="classForm.className"></el-input>
            </el-form-item>
            <el-form-item label="班级人数：">
              <el-input placeholder="请输入年级名称，如：高一" v-model="classForm.classNum"></el-input>
            </el-form-item>
            <el-form-item label="班级科类：">
              <el-select v-model="classForm.subject" placeholder="请选择">
                <el-option label="区域一" value="shanghai"></el-option>
                <el-option label="区域二" value="beijing"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="班级专业：">
              <el-select v-model="classForm.major" placeholder="请选择">
                <el-option label="区域一" value="shanghai"></el-option>
                <el-option label="区域二" value="beijing"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="班级级别：">
              <el-select v-model="classForm.level" placeholder="请选择">
                <el-option label="区域一" value="shanghai"></el-option>
                <el-option label="区域二" value="beijing"></el-option>
              </el-select>
            </el-form-item>
          </el-form>
        </el-col>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="save('class')">保存</el-button>
        <el-button @click="classDialogVisible = false">取消</el-button>
      </span>
    </el-dialog>
  </div>
</template>
<script>
  export default{
    data(){
      return {
        testNumbers: [{
          value: '选项1',
          label: '本次考试'
        }, {
          value: '选项2',
          label: '省考号'
        }, {
          value: '选项2',
          label: '市考号'
        }, {
          value: '选项2',
          label: '校考号'
        }],
        testNumber: '',
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
        }],
        searchValue: '',
        currentPage: 1,
        pageALl: 100,
        multipleSelection: [],
        dialogVisible: false,
        gradeForm: {
          gradeNum: '',
          gradeName: '',
          autoUpgrade: true,
          maxGrade: true
        },
        classFormTitle:'',
        classDialogVisible:false,
        classForm:{
          className:'',
          classNum:'',
          subject:'',
          major:'',
          level:''
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
      handleSelectionChange(val) {
        this.multipleSelection = val;
      },
      createGrade(){
        this.dialogVisible = true;
      },
      operationClass(type,idx){
        this.classDialogVisible=true;
        if (type == 'edit') {
            this.classFormTitle='编辑信息';
            $.extend(this.classForm,this.tableData[idx]);
        }else{
          this.classFormTitle='添加班级';
          for(let obj in this.classForm){
            this.classForm[obj]='';
          }
        }
      },
      handleClose(done) {
        done();
      },
      deleteData(){
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
          console.log(self.multipleSelection);
        }).catch(() => {
        });
      },
      save(type){
        if (type=='grade') {
          this.dialogVisible = false;
        }else{
          this.classDialogVisible = false;
        }
      }
    }
  }
</script>
<style>
  .classGradeManagement {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .classGradeManagement h3 {
    font-size: 1.25rem;
  }

  .classGradeManagement .classGradeManagement_row {
    margin: 1.25rem 0;
  }

  .classGradeManagement .el-form--inline .el-form-item {
    margin-bottom: 0;
  }

  .classGradeManagement .alertsBtn {
    margin: 1.25rem 0;
  }

  .classGradeManagement .edit {
    color: #4da1ff;
    cursor: pointer;
  }

  .classGradeManagement .el-table td, .classGradeManagement .el-table th {
    text-align: center;
  }

  .classGradeManagement .grade {
    width: 8.75rem;
  }

  .classGradeManagement .createBtn {
    text-align: right;
  }

  .classGradeManagement .search, .classGradeManagement .createBtn .el-button {
    padding: 10px 25px;
    border-radius: 20px;
  }

  .classGradeManagement .el-form--inline .el-form-item {
    margin-right: 2rem;
  }

  .classGradeManagement .el-dialog--small {
    width: 600px;
  }

  .classGradeManagement .gradeForm .tip {
    text-align: center;
    color: #888888;
  }

  .classGradeManagement .gradeForm .spec {
    color: #4da1ff;
  }
  .classGradeManagement .classForm .el-select{
    width:100%;
  }
</style>
