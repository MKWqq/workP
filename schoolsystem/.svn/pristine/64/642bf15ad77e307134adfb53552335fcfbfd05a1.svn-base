<template>
  <div class="g-PublishCourse">
    <header class="g-timeHeader">
      <el-button class="g-gobackChart RedButton" @click="goBackChart">
        <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
        返回流程图
      </el-button>
      <el-button class="blueButton" @click="saveSetting">发布</el-button>
    </header>
    <section class="g-classesTimeSetSection">
      <el-form class="g-form" :model="publishCourseForm" label-position="right" label-width="75px">
        <el-form-item label="发布类型:">
          <el-radio-group v-model="publishCourseForm.type">
            <el-radio label="不分单双周" value="0"></el-radio>
            <el-radio label="单周" value="1"></el-radio>
            <el-radio label="双周" value="2"></el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="学年学期:">
          <el-select v-model="publishCourseForm.range" placeholder="请选择学年学期">
            <el-option value="6" label="六年级"></el-option>
          </el-select>
        </el-form-item>
      </el-form>
    </section>
  </div>
</template>
<script>
  import {mapState} from 'vuex'
  import {
    classesTimeSettingSaved,//保存时间限制
  } from '@/api/http'
  export default{
    data(){
      return{
        /*form表单的双向绑定数据*/
        publishCourseForm:{
          type:'',
          range:''
        },
        /*年级显示转换*/
        gradeData:['一年级','二年级','三年级','四年级','五年级','六年级','初一','初二',
          '初三','高一','高二','高三'
        ],
        /*星期转换*/
        weekData:['星期一','星期二','星期三','星期四','星期五','星期六','星期日'],
      }
    },
    computed:{
      ...mapState(['pkListId']),
    },
    methods:{
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'examinationChart'});
      },
      /*保存*/
      saveSetting(){
        classesTimeSettingSaved({pkListId:this.pkListId,gradeId:this.gradeId,classId:this.classId,className:this.className,gradeName:this.gradeName,data:this.classesTimeSetTable}).then(data=>{
          if(data.statu==1){
            this.$message({
              message:'保存成功!',
              type:'success'
            });
          }else{
            this.$message.error('保存失败!');
          }
        })
      },
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/arrangeClasses/PublishCourse';
  @import '../../../../style/arrangeClasses/arrangeClasses.css';
</style>




