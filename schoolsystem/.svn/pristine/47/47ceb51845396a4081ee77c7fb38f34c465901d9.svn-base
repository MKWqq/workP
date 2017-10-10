<template>
    <div class="dormitoryMsgManagement">
      <h3>宿舍信息管理</h3>
      <el-row class="d_line dormitoryMsgManagement_row"></el-row>
      <el-row type="flex" align="middle" class="alertsBtn">
        <el-col :span="18">
          <el-button-group>
            <el-button class="filt" @click="addMsg(0)" title="添加">
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
          <el-button class="secBtn-group filt" title="导入" @click="toNext">
            <img class="filt_unactive"
                 src="../../../../../assets/img/schManagementSystem/studentsManagement/dormitoryManagement/icon_import.png"
                 alt="">
            <img class="filt_active"
                 src="../../../../../assets/img/schManagementSystem/studentsManagement/dormitoryManagement/icon_import_linght.png"
                 alt="">
          </el-button>
        </el-col>
        <el-col :span="6">
          <div class="g-fuzzyInput">
            <el-input
              placeholder="请输入任教科目/姓名"
              icon="search"
              v-model="selectParam.value"
              :on-icon-click="goSearch">
            </el-input>
          </div>
        </el-col>
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
            prop="name"
            label="栋号"
            sortable>
          </el-table-column>
          <el-table-column
            prop="sex"
            label="宿舍楼名称"
            sortable>
          </el-table-column>
          <el-table-column
            prop="teachingSubjects"
            label="楼层"
            sortable>
          </el-table-column>
          <el-table-column
            prop="politics"
            label="宿舍号"
            sortable>
          </el-table-column>
          <el-table-column
            prop="phone"
            label="宿舍名称"
            sortable>
          </el-table-column>
          <el-table-column
            prop="phone"
            label="宿舍类型"
            sortable>
          </el-table-column>
          <el-table-column
            prop="phone"
            label="容纳人数"
            sortable>
          </el-table-column>
          <el-table-column
            label="操作">
            <template scope="scope">
              <span class="edit" @click="addMsg(1,scope.row)">编辑</span>
            </template>
          </el-table-column>
        </el-table>
      </el-row>
      <el-row class="pageAlerts" v-if="tableData.length!=0">
        <el-pagination
          @current-change="handleCurrentChange"
          :current-page.sync="selectParam.page"
          layout="prev, pager, next, jumper"
          :total="totalNum">
        </el-pagination>
      </el-row>
      <el-dialog
        :title="formTitle"
        :visible.sync="dialogVisible"
        :before-close="handleClose"
        :modal="false">
        <el-row type="flex" justify="center">
          <el-col :span="16">
            <el-form ref="form" :model="form" label-width="110px">
              <el-form-item label="栋号：">
                <el-input v-model="form.name" placeholder="请输入栋号"></el-input>
              </el-form-item>
              <el-form-item label="宿舍楼名称：">
                <el-input v-model="form.name" placeholder="请输入宿舍楼名称"></el-input>
              </el-form-item>
              <el-form-item label="楼层：">
                <el-input v-model="form.name" placeholder="请输入楼层"></el-input>
              </el-form-item>
              <el-form-item label="宿舍号：">
                <el-input v-model="form.name" placeholder="请输入宿舍号"></el-input>
              </el-form-item>
              <el-form-item label="宿舍名称：">
                <el-input v-model="form.name" placeholder="请输入宿舍名称"></el-input>
              </el-form-item>
              <el-form-item label="宿舍类型：">
                <el-select v-model="form.teachingSubjects" placeholder="请选择" style="width:100%;">
                  <el-option :label="subject.subjectname" :value="subject.subjectname" :key="subject.subjectid"
                             v-for="subject in subjectLists"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item label="容纳人数：">
                <el-input v-model="form.phone" placeholder="请输入容纳人数"></el-input>
              </el-form-item>
            </el-form>
          </el-col>
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
              tableData: [{
                  name:'sdf'
              }],
              totalNum: 0,
              multipleSelection: [],
              dialogVisible: false,
              form: {
                name: '',
                sex: '',
                teachingSubjects: '',
                department: '',
                jobNumber: '',
                politics: '',
                phone: ''
              },
              formTitle: '',
              selectParam: {
                page: 1,
                pageSize: 10,
                sort: '',
                sortType: '',
                value: ''
              }
            }
        },
        methods: {
          goSearch() {  //查询
            this.selectParam.page = 1;
            this.selectParam.sortType = '';
            this.selectParam.sort = '';
          },
          handleSelectionChange(val) {
            this.multipleSelection = val;
          },
          sort(column){
            this.selectParam.sortType = column.prop || '';
            this.selectParam.sort = column.order || '';
          },
          handleCurrentChange(val) {
            this.selectParam.page = val;
          },
          handleClose(done) {   //关闭弹框
            done();
          },
          addMsg(type, val){
            this.dialogVisible = true;
            if (type == 0) {
              this.formTitle = '添加';
              for (let ob in this.form) {
                this.form[ob] = '';
              }
            } else {
              this.formTitle = '信息编辑';
              $.extend(this.form, val);
            }
          },
          saveMsg(){
            var self = this;
            if (self.formTitle == '添加') {
            } else {
            }
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
            }).catch(() => {
            });
          },
          toNext(){
              this.$router.push({name:'dormitoryImport'})
          }
        }
    }
</script>
<style>
  .dormitoryMsgManagement {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .dormitoryMsgManagement h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
    display: inline-block;
  }
  .dormitoryMsgManagement .dormitoryMsgManagement_row{
    margin-top:2rem;
  }
  .dormitoryMsgManagement .alertsList .el-table th,.dormitoryMsgManagement .alertsList .el-table td{
    text-align: center;
  }
  .dormitoryMsgManagement .alertsBtn{
    margin:1.25rem 0;
  }
  .dormitoryMsgManagement .edit{
    color: #4da1ff;
    cursor: pointer;
  }
  .dormitoryMsgManagement .el-dialog--small{
    width:600px;
  }
</style>
