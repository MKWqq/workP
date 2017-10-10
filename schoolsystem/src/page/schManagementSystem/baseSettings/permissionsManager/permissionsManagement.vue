<template>
  <div class="permissionsManagement">
    <h3>权限管理</h3>
    <el-row type="flex" align="middle" class="role">
      <el-col :span="16">
        <span>选择角色：</span>
        <el-select v-model="roleValue" placeholder="请选择" @change="setRole">
          <el-option
            v-for="item in roleLists"
            :key="item.roleId"
            :label="item.roleName"
            :value="item.roleName">
          </el-option>
        </el-select>
      </el-col>
      <el-col :span="8" class="newRole_btn">
        <el-button @click="dialogVisible = true">创建角色</el-button>
      </el-col>
    </el-row>
    <el-row class="d_line"></el-row>
    <el-row class="permissionsBars">
      <el-row>
        <span>选择一级导航：</span>
        <el-select v-model="activeBar" placeholder="请选择" @change="selectPermissions">
          <el-option
            v-for="item in navBars"
            :key="item.modelId"
            :label="item.modelName"
            :value="item.modelName">
          </el-option>
        </el-select>
      </el-row>
      <el-row class="permissionsBars_list">
        <div class="rootNode" v-if="activeBar">
          <el-button>{{activeBar}}</el-button>
        </div>
        <permissions-List :data.sync="permissionsList" :isChild="false" @setPermission="setPermissions"/>
      </el-row>
    </el-row>
    <el-dialog
      title="创建角色"
      :visible.sync="dialogVisible"
      size="tiny"
      :modal="false"
      :before-close="handleClose">
      <el-row type="flex" align="middle" class="roleName">
        <el-col :span="6">输入角色名：</el-col>
        <el-col :span="18">
          <el-input v-model="roleName" placeholder="请输入内容"></el-input>
        </el-col>
      </el-row>
      <span slot="footer" class="dialog-footer">
    <el-button type="primary" @click="saveMsg">提 交</el-button>
  </span>
    </el-dialog>
  </div>
</template>
<script>
  import perList from './permissionsLists'
  import req from '@/assets/js/common'
  export default{
    data(){
      return {
        roleLists: [],
        navBars: [],
        activeBar: '',
        permissionsList: [],
        roleValue: '',
        roleName: '',
        dialogVisible: false,
        param: {
          roleId: '',
          modelId: ''
        }
      }
    },
    components: {
      'permissions-List': perList
    },
    created(){
      var self = this;
      //角色列表
      req.ajaxSend('/school/User/getRoleList', 'post', {}, function (res) {
        self.roleLists = res;
      });
      //一级导航列表
      req.ajaxSend('/school/user/getOneNav', 'post', {}, function (res) {
        for (let [idx, obj] of res.entries()) {
          if (obj.modelName == '首页') {
            res.splice(idx, 1);
            break;
          }
        }
        self.navBars = res;
      });
    },
    methods: {
      setPermissions(val){
        var self = this,
          toData = {
            roleId: self.param.roleId,
            modelId: val.modelId
          };
        req.ajaxSend('/school/User/createRoleModelGo', 'post', toData, function (res) {
          if (res.statu == 1) {
            self.$message({
              message: '该权限设置成功',
              showClose: true
            });
            req.ajaxSend('/school/User/getModelListGo', 'get', self.param, function (res) {
              self.permissionsList = res[0].child;
            });
          } else {
            self.$message({
              message: '该权限设置失败',
              showClose: true
            });
          }
        })
      },
      setRole(val){
        for (let obj of this.roleLists) {
          if (obj.roleName == val) {
            this.param.roleId = obj.roleId;
            break;
          }
        }
        /*this.permissionsList=[];
        this.navBars=[];
        this.activeBar='';*/
      },
      selectPermissions(val){
        var self = this;
        for (let obj of this.navBars) {
          if (obj.modelName == val) {
            self.param.modelId = obj.modelId;
            break;
          }
        }
        req.ajaxSend('/school/User/getModelListGo', 'get', self.param, function (res) {
          self.permissionsList = res[0].child;
        });
      },
      saveMsg(){
        var self = this;
        var param = {
          roleName: self.roleName
        };
        req.ajaxSend('/school/user/createRole', 'post', param, function (res) {
          if (res.statu == 1) {
            self.$message({
              message: '创建角色成功',
              showClose: true
            });
            req.ajaxSend('/school/User/getRoleList', 'post', {}, function (res) {
              self.roleLists = res;
            });
            self.dialogVisible = false;
          } else {
            self.$message({
              message: '创建角色失败',
              showClose: true
            });
          }
        });
      },
      handleClose(done) {
        this.roleName = '';
        done();
      }
    }
  }
</script>
<style>
  .permissionsBars_list {
    margin-top: 2.25rem;
    min-height: 50rem;
    padding: 0 100px;
  }

  .permissionsBars_list .rootNode {
    text-align: center;
    padding-bottom: 2rem;
    border-bottom: 1px solid #d2d2d2;
  }

  .permissionsBars_list .rootNode .el-button {
    position: relative;
  }

  .permissionsBars_list .rootNode .el-button:before {
    position: absolute;
    content: '';
    display: block;
    height: 2rem;
    border-right: 1px solid #d2d2d2;
    bottom: -2rem;
    left: 50%;
  }

  .permissionsManagement {
    padding: 1.25rem 2rem 3rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
    font-size: 14px;
  }

  .permissionsManagement h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
  }

  .role {
    margin-top: 2rem;
  }

  .role .newRole_btn {
    text-align: right;
    padding-right: 2.25rem;
  }

  .newRole_btn .el-button {
    width: 7.5rem;
  }

  .permissionsManagement .d_line {
    margin: 1rem 0;
  }

  .permissionsManagement .el-dialog--tiny {
    width: 600px;
  }

  .permissionsManagement .roleName {
    padding: 0 80px;
  }
</style>
