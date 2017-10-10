<template>
  <div class="messageManagement">
    <h3>信息管理</h3>
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
          <el-button class="delete" title="导出" @click="exportFile">
            <img class="delete_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
                 alt="">
            <img class="delete_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
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
            placeholder="请输入岗位/姓名"
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
          label="姓名"
          sortable>
        </el-table-column>
        <el-table-column
          prop="sex"
          label="性别"
          sortable>
        </el-table-column>
        <el-table-column
          prop="post"
          label="岗位"
          sortable>
        </el-table-column>
        <el-table-column
          prop="politics"
          label="政治面貌"
          sortable>
        </el-table-column>
        <el-table-column
          prop="phone"
          label="手机号码"
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
      <el-row>
        <el-form ref="form" :model="form" label-width="90px">
          <el-form-item label="职工姓名：">
            <el-input v-model="form.name"></el-input>
          </el-form-item>
          <el-form-item label="职工性别：">
            <el-radio-group v-model="form.sex">
              <el-radio label="女">女</el-radio>
              <el-radio label="男">男</el-radio>
            </el-radio-group>
          </el-form-item>
          <el-form-item label="部门：">
            <el-select v-model="form.departmentId" placeholder="请选择">
              <el-option label="研发部" value="shanghai"></el-option>
              <el-option label="火星" value="beijing"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="岗位：">
            <el-select v-model="form.post" placeholder="请选择" @change="setId">
              <el-option :label="post.roleName" :value="post.roleName" :key="post.roleId" v-for="post in postLists"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="工号：">
            <el-input v-model="form.jobNumber"></el-input>
          </el-form-item>
          <el-form-item label="政治面貌：">
            <el-select v-model="form.politics" placeholder="请选择">
              <el-option label="团员" value="团员"></el-option>
              <el-option label="党员" value="党员"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="联系方式：">
            <el-input v-model="form.phone"></el-input>
          </el-form-item>
        </el-form>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg">提交</el-button>
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
        tableData: [],
        totalNum: 0,
        multipleSelection: [],
        dialogVisible: false,
        form: {
          post: '',
          name: '',
          jobNumber: '',
          phone: '',
          sex: '',
          politics: '',
          department: '',
          departmentId: ''
        },
        selectParam: {
          page: 1,
          pageSize: 10,
          sort: '',
          sortType: '',
          value: ''
        },
        formTitle: '',
        currentPage: 1,
        postLists:[]
      }
    },
    computed: {},
    created: function () {
      var self=this;
      //查询表格数据
      self.loadDataList(self.selectParam);
      //查询岗位
      req.ajaxSend('/school/user/getRoleListUser?type=list','get','',function (res) {
        self.postLists=res.data;
      })
    },
    methods: {
      exportFile(){
        req.downloadFile('.messageManagement', '/school/user/exportTeacherOrZg?type=worker', 'post');
      },
      goSearch() {  //查询
        this.selectParam.page = 1;
        this.selectParam.sortType = '';
        this.selectParam.sort = '';
        this.loadDataList(this.selectParam);
      },
      handleSelectionChange(val) {
        this.multipleSelection = val;
      },
      sort(column){
        this.selectParam.sortType = column.prop || '';
        this.selectParam.sort = column.order || '';
        this.loadDataList(this.selectParam);
      },
      handleCurrentChange(val) {
        this.selectParam.page = val;
        this.loadDataList(this.selectParam);
      },
      handleClose(done) {   //关闭弹框
        done();
      },
      addMsg(type, val){
        this.dialogVisible = true;
        if (type == 0) {
          this.formTitle = '职工补录';
          for (let ob in this.form) {
            this.form[ob] = '';
          }
        } else {
          this.formTitle = '修改信息';
          $.extend(this.form, val);
        }
      },
      setId(val){
        for(let obj of this.postLists){
          if (val == obj.roleName) {
            this.form.roleId=obj.roleId;
          }
        }
      },
      saveMsg(){
        var self = this;
        if (self.formTitle == '职工补录') {
          if(!self.form.roleId){
            self.$message({
              message: '岗位必选!',
              showClose: true
            });
            return false;
          }
          req.ajaxSend('/school/user/userGl?type=addStaff', 'post', self.form, function (res) {
            if (res.statu == 1) {
              self.$message({
                type: 'success',
                message: '新增成功!',
                showClose: true
              });
              self.selectParam.page = 1;
              self.loadDataList(self.selectParam);
            } else {
              self.$message({
                type: 'error',
                message: '新增失败!',
                showClose: true
              });
            }
          })
        } else {
          req.ajaxSend('/school/user/userGl?type=updataZg', 'post', {userData: self.form}, function (res) {
            if (res.statu == 1) {
              self.$message({
                type: 'success',
                message: '更新成功!',
                showClose: true
              });
              self.loadDataList(self.selectParam);
            } else {
              self.$message({
                type: 'error',
                message: '更新失败!',
                showClose: true
              });
            }
          })
        }
        this.dialogVisible = false;
      },
      deleteAlerts(){
          var self=this;
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
          var ary = [], userId;
          for (let obj of self.multipleSelection) {
            ary.push(obj.id);
          }
          userId = {
            userId: ary
          };
          req.ajaxSend('/school/user/userGl?type=deleteStaff', 'post', userId, function (res) {
            if (res.statu == 1) {
              self.$message({
                type: 'success',
                message: '删除成功!',
                showClose: true
              });
              self.selectParam.page = 1;
              self.loadDataList(self.selectParam);
            } else {
              self.$message({
                type: 'error',
                message: '删除失败!',
                showClose: true
              });
            }
          });
        }).catch(() => {
        });
      },
      loadDataList(data){
        var self = this;
        req.ajaxSend('/school/user/userGl?type=workerList', 'get', data, function (res) {
          self.tableData = res.data;
          self.totalNum = res.count;
        })
      }
    }
  }
</script>
<style>
  .messageManagement {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .messageManagement h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
  }

  .messageManagement .g-fuzzyInput {
    float: right;
  }

  .messageManagement .el-form {
    width: 80%;
    margin: auto;
  }

  .messageManagement .el-select {
    width: 100%;
  }

  .messageManagement .el-dialog__footer {
    padding: 0 20px 30px;
  }

  .messageManagement .el-dialog--small {
    width: 600px;
  }

  .messageManagement .edit {
    color: #ff5b5a;
    cursor: pointer;
  }
</style>
