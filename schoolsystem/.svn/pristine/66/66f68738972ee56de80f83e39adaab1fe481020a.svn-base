<template>
  <div class="g-teachingPlan">
    <header class="g-teachingPlanHeader">
      <el-button class="g-gobackChart RedButton" @click="goBackChart">
        <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
        返回流程图
      </el-button>
      <el-button class="blueButton" @click="saveSetting">保存</el-button>
    </header>
    <section class="g-teachingPlanSection g-headerButtonCss">
      <div class="g-teachingHeaderH">
        <h2>教学计划表</h2>
        <span>* 教师姓名不可修改，可在教学管理->任课教师模块下添加</span>
      </div>
      <div class="gs-button alertsBtn">
        <el-button-group class="elGroupButton_two">
          <el-button @click="buttonClick" data-msg="copy" class="filt" title="复制">
            <img class="filt_unactive" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png" />
            <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png" />
          </el-button>
          <el-button @click="buttonClick" data-msg="print" class="filt buttonChild" title="打印预览">
            <img class="filt_unactive" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png" />
            <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png" />
          </el-button>
        </el-button-group>
      </div>
      <section class="g-teachingPlanContent alertsList">
        <el-table class="g-hasBorder" :data="teachingPlanTable">
          <el-table-column width="200px" label="班级">
            <template scope="props">
              <span v-text="gradeData[props.row.gradeName]+props.row.className+'班'"></span>
            </template>
          </el-table-column>
          <el-table-column width="230px" v-for="(content,n) in teachingPlanColumn" :label="content.subjectname" :key="n">
            <template scope="props">
              <span class="g-teacherName" v-text="props.row.data[n].techerName" :data-index="props.row.data[n].techerId"></span>
              <el-input-number class="g-courseNum" v-model="props.row.data[n].count" :min="0" :max="100"></el-input-number>
            </template>
          </el-table-column>
        </el-table>
      </section>
    </section>
  </div>
</template>
<script>
  import {mapState} from 'vuex'
  import {teachingPlanLoad,
    teachingPlanCreate,//保存
  } from '@/api/http'
  export default{
    data(){
      return {
        /*table数据绑定*/
        /*行数据*/
        teachingPlanTable:[],
        /*列数据*/
        teachingPlanColumn:[],
        /*年级显示转换*/
        gradeData:['一年级','二年级','三年级','四年级','五年级','六年级','初一','初二',
          '初三','高一','高二','高三'
        ],
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
        teachingPlanCreate({pkListId:this.pkListId,data:this.teachingPlanTable}).then(data=>{
          this.sendAjaxPrompt(data,'保存');
        })
      },
      /*header的button群*/
      buttonClick(event){
        const e=$(event.currentTarget),targetMsg=e.data('msg');
        if(targetMsg=='copy'){
//          this.isDialog=true;
        }
      },
      /*sendAjax*/
      loadingAjax(){
        teachingPlanLoad({pkListId:this.pkListId}).then(data=>{
          console.log(data);
          if(data.statu){
            this.teachingPlanTable=data.data;
            this.teachingPlanColumn=data.subject;
          }
          else{
            this.teachingPlanTable=[];
            this.teachingPlanColumn=[];
            this.errorAlert('数据加载失败!');
          }
        })
      },
      /*处理数据*/
      handlerData(data){
        if(data.statu){
          return data.data;
        }else{
          this.$alert('加载失败,请重新加载页面!','提示',{
            confirmButtonText:'确定',
            type:'error',
            callback:action=>{}
          });
        }
      },
      /*错误弹框*/
      errorAlert(msg){
        this.$alert(msg,'提示',{
          confirmButtonText:'确定',
          type:'error',
          callback:action=>{}
        });
      },
      /*发送ajax提示框*/
      sendAjaxPrompt(data,msg){
        if(data.statu){
          this.$message({
            message:msg+'成功!',
            type:'success'
          });
          this.loadingAjax();
        }else{
          this.$message.error(msg+'失败,请重试!');
        }
      },
    },
    created(){
      this.loadingAjax();
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/arrangeClasses/arrangeClasses.css';
  @import '../../../../style/arrangeClasses/teachingPlan.less';
</style>



