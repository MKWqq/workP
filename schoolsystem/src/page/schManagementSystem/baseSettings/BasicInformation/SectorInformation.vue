<template>
  <div class="SectorInformation">
    <el-col :span="24">
      <el-col :span="22">
        <h3>部门信息</h3>
      </el-col>
      <el-col :span="2">
        <el-button type="primary" class="CreateProcess-top-btn">保存</el-button>
      </el-col>
    </el-col>
    <el-row class="SectorInformation-top">
      <el-col :span="24">
        <el-button>
          <img class="icon-unactive" src="./../../../../assets/img/schManagementSystem/baseSettings/BasicInformaton/icon_build.png" alt="">
          <img class="icon-active" src="./../../../../assets/img/schManagementSystem/baseSettings/BasicInformaton/icon_build_highlight.png" alt="">
          <span>创建部门</span>
        </el-button>
        <el-button>
          <img class="icon-unactive" src="./../../../../assets/img/schManagementSystem/baseSettings/BasicInformaton/icon_build_son.png" alt="">
          <img class="icon-active" src="./../../../../assets/img/schManagementSystem/baseSettings/BasicInformaton/icon_build_son_highlight.png" alt="">
          <span>创建子部门</span>
        </el-button>
        <el-button>
          <img class="icon-unactive" src="./../../../../assets/img/schManagementSystem/baseSettings/BasicInformaton/icon_bianji.png" alt="">
          <img class="icon-active" src="./../../../../assets/img/schManagementSystem/baseSettings/BasicInformaton/icon_bianji_highlight.png" alt="">
          <span>编辑</span>
        </el-button>
        <el-button>
          <img class="icon-unactive" src="./../../../../assets/img/schManagementSystem/baseSettings/BasicInformaton/icon_del.png" alt="">
          <img class="icon-active" src="./../../../../assets/img/schManagementSystem/baseSettings/BasicInformaton/icon_del_highlight.png" alt="">
          <span>删除</span>
        </el-button>
      </el-col>
    </el-row>
    <!--<el-row class="permissionsBars_list">-->
      <!--<div class="rootNode" v-if="activeBar">-->
        <!--<el-button>{{activeBar}}</el-button>-->
      <!--</div>-->
      <!--<permissions-List :data.sync="permissionsList" :isChild="false" @setPermission="setPermissions"/>-->
    <!--</el-row>-->
  </div>
</template>
<script>
  import perList from './SectorInformationList'
  import req from './../../../../assets/js/common'
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
        param: {},
      }
    },
    components: {
      'permissions-List': perList
    },
    created(){
        this.selectPermissions();
    },
    methods: {
//      setPermissions(val){
//        var self = this,
//          toData = {
//            roleId: self.param.roleId,
//            modelId: val.modelId
//          };
//        req.ajaxSend('/school/User/createRoleModelGo', 'post', toData, function (res) {
//          if (res.statu == 1) {
//            self.$message({
//              message: '该权限设置成功',
//              showClose: true
//            });
//            req.ajaxSend('/school/User/getModelListGo', 'get', self.param, function (res) {
//              self.permissionsList = res[0].child;
//            });
//          } else {
//            self.$message({
//              message: '该权限设置失败',
//              showClose: true
//            });
//          }
//        })
//      },

      selectPermissions(val){
        var self = this;
        req.ajaxSend('/school/User/getModelListGo', 'get', self.param, function (res) {
//          self.permissionsList = res[0].child;
          console.log(res)
        });
      },
    }
  }
</script>
<style lang="less">
  .SectorInformation{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
    min-height:50rem;
  }
  .SectorInformation  .CreateProcess-top-btn{
    padding:.5rem 2.8rem ;
    border-radius: 1.1rem;
  }
  .SectorInformation-top{
    margin-top:2.5rem;
  }
  .SectorInformation-top .el-button{
    display: inline-block;
    margin-left:.8rem;
    font-size: 0.875rem;
    border: none;
  }
  .SectorInformation-top .el-button:focus .icon-active, .SectorInformation-top .el-button:hover .icon-active{
    display:inline;
  }
  .SectorInformation-top .el-button:focus .icon-unactive,.SectorInformation-top .el-button:hover .icon-unactive{
    display:none;
  }
  .SectorInformation-top .el-button .icon-active{
    display: none;
  }
  .SectorInformation-top .el-button:hover >span{
    color: #89BCF5;
  }
</style>
