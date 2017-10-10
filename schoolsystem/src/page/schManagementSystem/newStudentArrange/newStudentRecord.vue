<template>
  <div class="g-container g-studentRecord">
    <header class="g-textHeader g-importCourseHeader">
      <div class="g-flexStartRow">
        <el-button class="g-gobackChart g-imgContainer RedButton" @click="goBackChart">
          <img src="../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
          返回流程图
        </el-button>
        <h2 class="selfCenter">学生补录</h2>
      </div>
    </header>
    <section class="g-section">
      <el-form class="scheduleDialog g-form" :model="studentMsgForm" label-position="right" label-width="75px">
        <el-form-item label="年级:">
          <el-select v-model="studentMsgForm.grade" placeholder="请选择年级">
            <el-option value="6" label="六年级"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="姓名:" class="g-floatLeft">
          <el-input v-model="studentMsgForm.userName"></el-input>
        </el-form-item>
        <el-form-item label="性别:" class="g-floatLeft">
          <el-radio-group v-model="studentMsgForm.sex">
            <el-radio label="女" value="0"></el-radio>
            <el-radio label="男" value="1"></el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="是否借读:" class="g-floatLeft">
          <el-switch on-text="是" off-text="否" v-model="studentMsgForm.address"></el-switch>
        </el-form-item>
        <el-form-item label="指定到班:">
          <el-select v-model="studentMsgForm.classes" placeholder="请选择班级">
            <el-option value="1" label="1班"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="手机号码:" class="g-floatLeft">
          <el-input v-model="studentMsgForm.tel"></el-input>
        </el-form-item>
      </el-form>
      <div class="g-footer">
        <el-button class="largeButton" type="primary">提交</el-button>
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
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'newStudentClass'});
      },
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../style/style';
  .g-textHeader{
    h2{.marginLeft(40,1582);}
  }
  .g-section{padding-top:50/16rem;
    .g-form{/*852*/
      .width(852,1582);margin:0 365/1582*100%;
    }
    .g-footer{
      .width(852,1582);margin:0 365/1582*100% 95/16rem;
    }
  }
</style>


