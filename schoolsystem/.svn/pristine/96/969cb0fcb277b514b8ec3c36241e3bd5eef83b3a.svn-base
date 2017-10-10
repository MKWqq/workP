<template>
  <el-row class="pList" :class="{'is-justify-space-between el-row--flex childrenNode':!isChild}">
    <el-col :class="{'node_column':!isChild,'node_column_block':isChild}" v-for="permission in data"
            :key="permission.modelId">
      <el-row :class="{'node_offset':!isChild}">
        <el-row class="node_column_first">
        <span class="p_btn" :class="{'firstNode':!isChild,'secNode':isChild}">
         <span class="node_circle" @click='permission.ifHave=!permission.ifHave'
               v-if="permission.child"><img
           src="../../../../assets/img/schManagementSystem/baseSettings/permissionsManager/icon_open.png"
           alt="" v-show="!permission.ifHave">
              <img
                src="../../../../assets/img/schManagementSystem/baseSettings/permissionsManager/icon_close.png"
                alt="" v-show="permission.ifHave">
            </span>
          <span class="node_nocircle" v-if="!permission.child"></span>
          <el-button
            :class="{'level2':(permission.level==2||permission.level==3)&&permission.statu==1,'level4':permission.level==4&&permission.statu!=1,'level5':permission.level==5&&permission.statu!=1,'level5_active':(permission.level==5||permission.level==4)&&permission.statu==1}"
            @click="setPermissions(permission)">
            {{permission.modelName}}
          </el-button>
        </span>
        </el-row>
        <el-row class="node_column_second" v-if="permission.child">
          <permissionsTree :data="permission.child" :isChild="true" @setPermission="setPermissions"
                           v-if='permission.ifHave'/>
        </el-row>
      </el-row>
    </el-col>
  </el-row>
</template>
<script>
  export default{
    name: 'permissionsTree',
    props: ['data', 'isChild'],
    data(){
      return {}
    },
    methods: {
      setPermissions(val){
        this.$emit('setPermission', val);
      }
    }
  }
</script>
<style>
  .childrenNode .node_offset{
    margin-left: -44px;
  }
  .childrenNode .node_column_block {
    float: none;
    margin-left: 0;
  }

  .childrenNode .node_column_first .p_btn {
    position: relative;
    margin-top: 32px;
    display: inline-block;
  }

  .childrenNode .node_column_second {
    border-left: 1px solid #d2d2d2;
    margin-left: 40px;
  }

  .childrenNode .node_column_block .node_column_second {
    margin-left: 70px;
    /*margin-top:18px;*/
  }

  .childrenNode .secNode {
    margin-left: 32px;
    /*top:18px;*/
  }

  .childrenNode .firstNode .node_circle, .childrenNode .secNode .node_circle {
    position: absolute;
    display: block;
    cursor: pointer;
  }

  .childrenNode .firstNode .node_circle {
    left: 50%;
    -webkit-transform: translateX(-50%);
    -moz-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    -o-transform: translateX(-50%);
    transform: translateX(-50%);
    top: -18px;
  }

  .childrenNode .secNode .node_circle {
    left: -17px;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    top: 50%;
  }

  .childrenNode .secNode .node_nocircle {
    position: absolute;
    display: block;
    top: 50%;
    left: -33px;
    border-bottom: 1px solid #d2d2d2;
    width: 33px;
  }
  .firstNode .node_nocircle{
    position: absolute;
    display: block;
    top: -33px;
    height:33px;
    left: 50%;
    border-left: 1px solid #d2d2d2;
  }

  .childrenNode .firstNode .node_circle:before, .childrenNode .secNode .node_circle:before {
    content: '';
    position: absolute;
    display: block;
  }

  .childrenNode .firstNode .node_circle:before {
    border-right: 1px solid #d2d2d2;
    height: 16px;
    left: 50%;
    top: -15px;
  }

  .childrenNode .secNode .node_circle:before {
    border-bottom: 1px solid #d2d2d2;
    width: 16px;
    top: 50%;
    left: -16px;
  }

  .pList .el-button:focus, .pList .el-button:hover {
    color: #1f2d3d;
    border-color: #c4c4c4;
  }

  .pList .level2 {
    border-color: #ff5b5b;
    color: #ff5b5b;
  }

  .pList .level2:focus, .pList .level2:hover {
    border-color: #ff5b5b;
    color: #ff5b5b;
  }

  .pList .level4 {
    background-color: #8a8a8a;
    border-color: #8a8a8a;
    color: #fff;
  }

  .pList .level4:focus, .pList .level4:hover {
    border-color: #8a8a8a;
    color: #fff;
  }

  .pList .level5 {
    background-color: #979797;
    border-color: #979797;
    color: #fff;
  }

  .pList .level5:focus, .pList .level5:hover {
    border-color: #979797;
    color: #fff;
  }

  .pList .level5_active {
    background-color: #ff5b5b;
    border-color: #ff5b5b;
    color: #fff;
  }

  .pList .level5_active:focus, .pList .level5_active:hover {
    border-color: #ff5b5b;
    color: #fff;
  }
</style>
