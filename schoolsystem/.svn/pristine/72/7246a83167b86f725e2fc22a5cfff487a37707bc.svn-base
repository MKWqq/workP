<template>
  <div class="likeSubClassSet">
    <el-row type="flex" align="middle" class="subClassDivision_title">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <h3>拟分班级设置</h3>
    </el-row>
    <el-row>
      <el-form :inline="true" :model="formGrade" class="formGrade">
        <el-form-item label="年级：">
          <el-select v-model="formGrade.grade" placeholder="请选择">
            <el-option label="区域一" value="shanghai"></el-option>
            <el-option label="区域二" value="beijing"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="温馨提示：分班完成后，新班级将覆盖所选年级的现有班级。">
        </el-form-item>
      </el-form>
    </el-row>
    <el-row class="subClassDivision_row d_line"></el-row>
    <el-row class="alertsBtn">
      <el-button-group>
        <el-button class="filt" title="添加" @click="addSubject('add')">
          <img class="filt_unactive"
               src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add.png"
               alt="">
          <img class="filt_active"
               src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add_highlight.png"
               alt="">
        </el-button>
        <el-button class="delete" title="删除" @click="deleteData">
          <img class="delete_unactive"
               src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete.png"
               alt="">
          <img class="delete_active"
               src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete_highlight.png"
               alt="">
        </el-button>
      </el-button-group>
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        @selection-change="handleSelectionChange"
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
                label="容纳人数">
                <template scope="scope">
                  <el-input-number v-model="scope.row.num" :min="1" :max="10"></el-input-number>
                </template>
              </el-table-column>
              <el-table-column
                label="操作">
                <template scope="scope">
                  <span class="edit"  @click="deleteData('major',scope.row.id)">删除</span>
                </template>
              </el-table-column>
            </el-table>
          </template>
        </el-table-column>
        <el-table-column
          type="selection"
          width="55">
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="班级名称">
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="科类志愿">
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="班级级别">
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="总容纳人数">
        </el-table-column>
        <el-table-column
          label="操作">
          <template scope="scope">
            <span class="edit_primary" @click="addSubject('edit',scope.$index)">编辑</span>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
    <el-row class="operationBtns">
      <el-button type="primary" @click="addSubject('quicklySet')">快速设置</el-button>
      <el-button type="primary" @click="saveMsg">保存</el-button>
    </el-row>
    <el-dialog
      :title="formTitle"
      :visible.sync="dialogVisible"
      :before-close="handleCloseDialog"
      :modal="false">
      <el-row class="formMsg">
        <el-form ref="form" :model="form" label-width="120px">
          <el-form-item label="班级名称：">
            <el-input placeholder="请输入班级名称，如1班" v-model="form.className"></el-input>
          </el-form-item>
          <el-form-item label="科类志愿：">
            <el-select v-model="form.volunteer" placeholder="请选择">
              <el-option label="区域一" value="shanghai"></el-option>
              <el-option label="区域二" value="beijing"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="班级级别：">
            <el-select v-model="form.classLevel" placeholder="请选择">
              <el-option label="区域一" value="shanghai"></el-option>
              <el-option label="区域二" value="beijing"></el-option>
            </el-select>
          </el-form-item>
        </el-form>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg('add')">保存</el-button>
        <el-button @click="dialogVisible = false">取消</el-button>
      </span>
    </el-dialog>
    <el-dialog
      title="快速设置"
      :visible.sync="testDialogVisible"
      :before-close="handleCloseDialog"
      :modal="false">
      <el-row class="formMsg">
        <el-form ref="form" :model="testForm" label-width="120px">
          <el-form-item label="班级人数：">
            <el-input placeholder="请输入班级容纳人数" v-model="testForm.subject"></el-input>
          </el-form-item>
        </el-form>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg('set')">确定</el-button>
        <el-button @click="testDialogVisible = false">取消</el-button>
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
            id: 1,
            name: '语文',
            num:1
          }, {
            id: 2,
            name: '数学',
            num:2
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
        currentPage: 1,
        pageALl: 100,
        multipleSelection: [],
        dialogVisible: false,
        form: {
          className:'',
          volunteer:'',
          classLevel:''
        },
        testDialogVisible: false,
        testForm: {
          subject: ''
        },
        formGrade:{
            grade:''
        },
        formTitle:''
      }
    },
    methods: {
      returnFlowchart(){
        this.$router.push('/subClassDivisionHome');
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
      addSubject(type,idx){   //打开弹框
        if (type == 'add') {  //添加
          this.formTitle='添加信息';
          this.dialogVisible = true;
        } else if (type == 'quicklySet') {   //快速设置
          this.testForm.subject = '';
          this.testDialogVisible = true;
        } else if (type == 'edit') {  //编辑
          this.formTitle='编辑信息';
          console.log(this.tableData[idx]);
          this.dialogVisible = true;
        }
      },
      handleCloseDialog(done){   //关闭弹框
        done();
      },
      deleteData(type,idx){    //删除
        if(type=='major'){  //删除专业
          this.tableData.splice(idx, 1);
        }else{   //删除班级
          if(this.multipleSelection.length==0){
            this.$message({
              message: '请选择记录!',
              showClose: true
            });
            return false;
          }
          this.$confirm('确定删除?', '提示', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning'
          }).then(() => {
            console.log(this.multipleSelection);
            this.$message({
              type: 'success',
              message: '删除成功!',
              showClose: true
            });
          }).catch(() => {
          });
        }
      },
      saveMsg(type){   //保存信息
        if (type == 'add') {   //添加或者编辑
          this.dialogVisible = false;
        } else if (type == 'set') {   //设置
          this.testDialogVisible = false;
        } else {    //批量保存
        }
      }
    }
  }
</script>
<style>
  .likeSubClassSet .el-table__expanded-cell {
    padding: 0;
  }

  .likeSubClassSet .el-table.childTable {

  }

  .likeSubClassSet .alertsList .el-table.childTable th {
    background-color: #deeefe;
    height: 3rem;
  }

  .likeSubClassSet .alertsList .el-table.childTable td {
    height: 3.5rem;
    font-size: .875rem;
  }

  .likeSubClassSet .childTable .el-table__footer-wrapper thead div, .likeSubClassSet .childTable .el-table__header-wrapper thead div {
    background-color: #deeefe;
    color: #666666;
  }

  .likeSubClassSet .el-table.childTable td {
    background-color: #f0f0f0;
  }
  .likeSubClassSet .invokeMsg .alertsList {
    min-height: 0;
  }

  .likeSubClassSet .invokeMsg .el-dialog__footer {
    -webkit-box-shadow: 0 -5px 20px -5px #d2d2d2;
    -moz-box-shadow: 0 -5px 20px -5px #d2d2d2;
    box-shadow: 0 -5px 20px -5px #d2d2d2;
  }

  .likeSubClassSet .invokeMsg .tips {
    color: #999999;
    margin-bottom: 1rem;
  }
  .likeSubClassSet .formGrade .el-form-item{
    margin-bottom:0;
    margin-right:2rem;
  }
  .likeSubClassSet .el-input-number{
    height:30px;
  }
  .likeSubClassSet .el-input-number__decrease,.likeSubClassSet .el-input-number__increase{
    line-height:30px;
  }
  .likeSubClassSet .el-input-number .el-input__inner{
    height:30px;
    text-align: center;
  }
</style>
