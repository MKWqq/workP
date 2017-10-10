<template>
  <div class="g-courseTimeSetting">
    <header class="g-timeHeader">
      <el-button class="g-gobackChart RedButton" @click="goBackChart">
        <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
        返回流程图
      </el-button>
      <el-button class="blueButton" @click="saveSetting">保存</el-button>
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
      <div class="g-sectionC">
        <header class="gL-header">
          <h2>待选班级</h2>
        </header>
        <section class="gL-section g-tree">
          <!-- node-key="id" :default-expanded-keys="[1]"-->
          <el-tree :highlight-current="true" default-expand-all :data="treeData" :props="defaultProps" ref="allMsg" @node-click="handleNodeClick"></el-tree>
        </section>
      </div>
      <div class="g-sectionR alertsList">
        <header>
          <h2 v-text="headerText+'班课表'"></h2>
        </header>
        <el-table :data="classesTimeSetTable" @cell-click="tableCellClick" border class="g-timeSettingTable">
          <el-table-column label="节/周">
            <template scope="props">
              <span v-text="'第'+(props.$index+1)+'节'"></span>
            </template>
          </el-table-column>
          <el-table-column v-for="n in 7" :key="n" :label="weekData[n-1]">
            <template scope="props">
              <span v-if="props.row[n-1]==0" class="NotCourse">不上课</span>
              <span v-if="props.row[n-1]==2" class="NotCourse">不排课</span>
              <span v-if="props.row[n-1]==3" class="SetNotCourse">不排课</span>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </section>
  </div>
</template>
<script>
  import {mapState} from 'vuex'
  import {courseTimeSettingCourseLoad,//得到课程
    classesTimeSettingGrade,//得到班级年级
    courseTimeSettingTableLoad,/*table默认数据*/
    courseTimeSettingSaved,//保存时间限制
  } from '@/api/http'
  export default{
    data(){
      return{
        /*表格header文本*/
        headerText:'',
        /*tree*/
        treeData:[],
        defaultProps: {
          children: 'data',
          label:'name',
        },
        /*课程数据*/
        curriculumId:'',
        curriculumName:'',
        courseData:[],
        /*table数据请求所需参数*/
        gradeId:'',
        gradeName:'',
        classId:'',
        className:'',
        /*table框绑定数据*/
        classesTimeSetTable:[],
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
        courseTimeSettingSaved({pkListId:this.pkListId,gradeId:this.gradeId,classId:this.classId,className:this.className,gradeName:this.gradeName,data:this.classesTimeSetTable,curriculumId:this.curriculumId,curriculumName:this.curriculumName}).then(data=>{
          if(data.statu==1){
            this.$message({
              message:'保存成功!',
              type:'success'
            });
            this.getTableData();
          }else{
            this.$message.error('保存失败!');
          }
          console.log(data);
        })
      },
      /*选择课程*/
      chooseCourse(event){
        const e=$(event.currentTarget);
        e.addClass('activeLi');
        e.siblings().removeClass('activeLi');
        this.curriculumId=e.data('id');
        this.curriculumName=e.text();
        this.getTableData();
      },
      /*tree点击事件*/
      handleNodeClick(data,node){
        /*点击节点回调*/
        /*点击名字发送请求，返回数据绑定在右边部分*/
        /*给每一级赋值一个唯一的id即可辨认点击的是几级*/
        if('data' in data){
          this.gradeName=data.name;
          return;
        }else{
          this.classId=data.classid;
          this.gradeId=data.gradeId;
          this.getTableData();
          this.headerText=node.parent.data.name+data.name;
          this.className=data.name;
        }
      },
      /*table框点击单元格事件*/
      tableCellClick(row,column,cell,event){
        const columnNum=this.weekData.indexOf(column.label);
        if(columnNum>=0){
          if(row[columnNum]==0){
            this.$alert('已设置不上课，不能限制!','提示',{
              confirmButtonText:'确定',
              type:'error',
              callback:action=>{}
            });
            return;
          }
          else if(row[columnNum]==2){
            this.$alert('已设置不排课，不能限制!','提示',{
              confirmButtonText:'确定',
              type:'error',
              callback:action=>{}
            });
            return;
          }
          else{
            if(row[columnNum]==3){
              this.$set(row,columnNum,1);
            }else{
              this.$set(row,columnNum,3);
            }
          }
        }
      },
      /*send ajax*/
      /*得到课程*/
      getCourse(){
        courseTimeSettingCourseLoad().then(data=>{
          this.courseData=this.handlerData(data);
          if(this.courseData.length>0){
            this.curriculumId=this.courseData[0].subjectid;
            this.curriculumName=this.courseData[0].subjectname;
            this.getGradeAjax();
          }
        })
      },
      /*得到年级和班级ajax*/
      getGradeAjax(){
        classesTimeSettingGrade({pkListId:this.pkListId}).then(data=>{
          this.treeData=this.handlerData(data);
          /*headerText*/
          if(this.treeData.length>0){
            this.headerText=this.treeData[0].name+this.treeData[0].data[0].name;
            this.gradeId=this.treeData[0].gradeId;
            this.classId=this.treeData[0].data[0].classid;
            this.gradeName=this.treeData[0].name;
            this.className=this.treeData[0].data[0].name;
            this.getTableData();
          }
        })
      },
      /*得到表格默认信息*/
      getTableData(){
        courseTimeSettingTableLoad({pkListId:this.pkListId,gradeId:this.gradeId,classId:this.classId,curriculumId:this.curriculumId}).then(data=>{
          this.classesTimeSetTable=this.handlerData(data).classSet;
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
      /*修改table的header文本*/
      changeHeaderText(){
        /*headerText*/
        if(this.treeData.length>0){
          this.headerText=this.treeData[0].name+this.treeData[0].data[0].name;
        }
      },
      /*错误弹框*/
    },
    created(){
      this.getCourse();
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/arrangeClasses/courseTimeSetting';
  @import '../../../../style/arrangeClasses/arrangeClasses.css';
</style>




