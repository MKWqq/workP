<template>
  <div class="g-container g-studentRecord">
    <header class="g-header">
      <div class="gh-header">学生补录</div>
    </header>
    <section class="g-section">
      <el-form class="g-form" :model="studentMsgForm" label-position="right" label-width="75px">
        <el-form-item label="年级:">
          <el-select v-model="studentMsgForm.grade" placeholder="请选择年级">
            <el-option value="6" label="六年级"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="班级:">
          <el-select v-model="studentMsgForm.classes" placeholder="请选择班级">
            <el-option value="1" label="1班"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="姓名:" class="g-floatLeft">
          <el-input v-model="studentMsgForm.userName"></el-input>
        </el-form-item>
        <el-form-item label="手机号:" class="g-floatLeft">
          <el-input v-model="studentMsgForm.tel"></el-input>
        </el-form-item>
        <el-form-item label="性别:" class="g-floatLeft">
          <el-radio-group v-model="studentMsgForm.sex">
            <el-radio label="女" value="0"></el-radio>
            <el-radio label="男" value="1"></el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="是否借读:" class="g-floatLeft">
          <el-switch on-text="" off-text="" v-model="studentMsgForm.address"></el-switch>
        </el-form-item>
      </el-form>
      <div class="g-footer">
        <el-button type="primary">提交</el-button>
      </div>
    </section>
  </div>
</template>
<script>
  import {fileTypeCheck} from '@/assets/js/common'
  export default{
    data(){
      return {
        /*form表单的双向绑定数据*/
        studentMsgForm:{
          grade:'',
          classes:'',
          userName:'',
          tel:'',
          sex:'',
          address:'',//借读,值为true/false
        },
      }
    },
    methods:{
      a(){},
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  /*@import '../../../../../style/userManager/student/studentMessage.less';*/
  @import '../../../../../style/userManager/student/studentManager.css';
  @import '../../../../../style/common';
  .g-header{.width(1646-64,1646);margin:20/16rem 32/1646*100% 0 32/1646*100%;
    .gh-header{width:100%;color:@HColor;font-weight:bold;margin-bottom:30/16rem;}
  }
  .g-section{/*1582*/
    .width(1646-64,1646);margin:140/16rem 32/1646*100% 0 32/1646*100%;
    .g-form{/*852*/
      .width(852,1582);margin:0 365/1582*100%;
      .g-floatLeft{float:left;}
      .g-floatLeft:nth-of-type(even){float:left;margin-left:14.3%;}
    }
    .g-footer{
      .width(852,1582);margin:0 365/1582*100% 95/16rem;
    }
  }
</style>


