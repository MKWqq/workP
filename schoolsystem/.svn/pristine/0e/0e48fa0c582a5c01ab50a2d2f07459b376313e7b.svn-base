<template>
  <div class="g-workTogether">
    <header class="g-timeHeader">
      <el-button class="g-gobackChart RedButton" @click="goBackChart">
        <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
        返回流程图
      </el-button>
    </header>
    <section class="g-classesTimeSetSection">
      <div class="g-sectionL">
        <header class="gL-header">
          <h2>待选科目</h2>
        </header>
        <section class="gL-section">
          <ul>
            <li @click="chooseCourse" :class="[index==0?'activeLi':'']" :data-id="content.subjectid" v-for="(content,index) in courseData" v-text="content.subjectname"></li>
          </ul>
        </section>
      </div>
      <div class="g-sectionR clear_fix">
        <div class="gR-sectionL">
          <header class="gL-header">
            <h2>待选班级(教师)</h2>
          </header>
          <section class="gL-section">
            <ul id="classesTeacher">
              <li @click="classesTeacherClick" :data-id="index" v-for="(content,index) in teacherData" v-text="gradeData[content.gradeName-1]+content.className+'班('+content.techerName+')'"></li>
            </ul>
          </section>
        </div>
        <div class="gR-sectionC">
          <ul>
            <li class="el-icon-caret-right" @click="workTogetherAjax">合班教学</li>
            <li class="el-icon-caret-left" @click="workBySelfAjax">拆班教学</li>
          </ul>
        </div>
        <div class="gR-sectionR">
          <header class="gL-header">
            <h2>合班班级</h2>
          </header>
          <section class="gL-section">
            <ul>
              <li @click="workTogetherClick" :data-msg="content.id" v-for="(content,index) in workTogetherData">
                <div class="g-subjectShow" v-text="content.subjectName"></div>
                <div class="g-detailShow">
                  <span v-for="(classDetail,n) in content.classSet" v-text="gradeData[classDetail.gradeName-1]+classDetail.className+'班('+classDetail.techerName+')'"></span>
                </div>
              </li>
            </ul>
          </section>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
  import {mapState} from 'vuex'
  import {courseTimeSettingCourseLoad,//得到课程
    workTogetherTeacherLoad,//得到教师
    workTogetherSetting,//创建合班教学
    workTogetherGet,//得到合班教学
    workSelfSet,//拆班教学
  } from '@/api/http'
  export default{
    data(){
      return{
        /*课程数据*/
        subjectId:'',
        subjectName:'',
        courseData:[],
        /*得到教师数据*/
        teacherData:[],
        teacherAjaxData:[],
        /*合班教学数据*/
        workTogetherData:[],
        /*待选班级*/
        teacherId:'',
        teacherName:'',
        /*合班id*/
        workTogetherId:'',
        /*检测是否合班教学*/
        isWorkTogehter:true,
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
      /*待选班级点击事件*/
      classesTeacherClick(event){
        const e=$(event.currentTarget);
        e.toggleClass('activeLi');
      },
      /*初始化待选班级数据*/
      initClassesTeacher(){
        this.teacherAjaxData=[];
        $('#classesTeacher .activeLi').removeClass('activeLi');
      },
      /*合班班级点击事件*/
      workTogetherClick(event){
        const e=$(event.currentTarget);
        e.addClass('activeLi');
        e.siblings().removeClass('activeLi');
        this.workTogetherId=$(event.currentTarget).data('msg');
      },
      /*选择课程*/
      chooseCourse(event){
        this.changeOneCss(event);
        this.getTeacherAjax();
      },
      /*选中单个css修改*/
      changeOneCss(event){
        const e=$(event.currentTarget);
        e.addClass('activeLi');
        e.siblings().removeClass('activeLi');
        this.subjectId=e.data('id');
        this.subjectName=e.text();
      },
      /*send ajax-----------*/
      /*待选班级点击*/
      workTogetherAjax(){
        let dataIndex='';//点击元素的下标
        let tearcherTest='';//老师姓名比较
        let gradeTest='';//年级比较
        const objArr=$('#classesTeacher .activeLi');
        if(objArr.length>1){
          /*更新选中元素的数据*/
          for(let index=0;index<objArr.length;index++){
            dataIndex=objArr.eq(index).data('id');
            this.teacherAjaxData.push(this.teacherData[dataIndex]);
          }
          /*判断是否能合班排课*/
          for(let i=0;i<this.teacherAjaxData.length;i++){
            if(i==0){
              tearcherTest=this.teacherAjaxData[i].techerName;
              gradeTest=this.teacherAjaxData[i].gradeName;
              continue;
            }
            else{
              /*判断老师与年级是否一致*/
              if(this.teacherAjaxData[i].techerName!=tearcherTest || this.teacherAjaxData[i].gradeName!=gradeTest){
                this.errorAlert('请选择同年级同老师的班级！');
                this.isWorkTogehter=false;
                return;
              }
            }
          }
        }
        else{
          this.errorAlert('请选择至少2个班级！');
          return;
        }
        this.teacherId=this.teacherAjaxData[0].techerId;
        this.teacherName=this.teacherAjaxData[0].techerName;
        this.setWorkTogether();
      },
      /*拆班教学*/
      workBySelfAjax(){
        if(this.workTogetherId){
          workSelfSet({pkListId:this.pkListId,id:this.workTogetherId}).then(data=>{
            this.sendAjaxPrompt(data,'拆班');
          });
        }
        else{
          this.errorAlert('请先在右侧选择需要拆班的班级！');
        }
      },
      /*ajax=====*/
      /*合班教学*/
      setWorkTogether(){
        workTogetherSetting({pkListId:this.pkListId,teacherName:this.teacherName,teacherId:this.teacherId,subjectId:this.subjectId,subjectName:this.subjectName,data:this.teacherAjaxData}).then(data=>{
          if(data.statu){
            this.$message({
              message:'合班教学设置成功!',
              type:'success'
            });
            this.initClassesTeacher();//初始化待选班级数据
            this.getTeacherAjax();
            this.getWorkTogether();
          }
          else{
            this.$message.error('合班教学设置失败!');
          }
        })
      },
      getWorkTogether(){
        workTogetherGet({pkListId:this.pkListId}).then(data=>{
          this.workTogetherData=this.handlerData(data);
        });
      },
      /*得到教师ajax*/
      getTeacherAjax(){
        workTogetherTeacherLoad({pkListId:this.pkListId,subjectId:this.subjectId}).then(data=>{
          this.teacherData=this.handlerData(data);
        });
      },
      /*得到课程*/
      getCourse(){
        courseTimeSettingCourseLoad().then(data=>{
          this.courseData=this.handlerData(data);
          if(this.courseData.length>0){
            this.subjectId=this.courseData[0].subjectid;
            this.subjectName=this.courseData[0].subjectname;
            this.getTeacherAjax();
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
          callback:actions=>{},
        });
      },
      /*发送ajax提示框*/
      sendAjaxPrompt(data,msg){
        if(data.statu){
          this.$message({
            message:msg+'成功!',
            type:'success'
          });
          this.getTeacherAjax();
          this.getWorkTogether();
        }
        else{
          this.$message.error(msg+'失败,请重试!');
        }
      },
    },
    created(){
      this.getCourse();
      this.getWorkTogether();
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/arrangeClasses/workTogetherTimeSetting';
  @import '../../../../style/arrangeClasses/arrangeClasses.css';
</style>




