<template>
  <section class="g-classesTimeSetSection">
    <div class="g-sectionL">
      <header class="gL-header">
        <h2>待选班级</h2>
      </header>
      <section class="gL-section g-tree">
        <!-- node-key="id" :default-expanded-keys="[1]"-->
        <el-tree :highlight-current="true" default-expand-all :data="treeData" :props="defaultProps" ref="allMsg" @node-click="handleNodeClick"></el-tree>
      </section>
    </div>
    <div class="g-sectionR alertsList">
      <div class="gs-header">
        <div class="gs-button">
          <el-button-group>
            <el-button @click="buttonClick" data-msg="export" class="buttonChild" title="导出">
              <img src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png" />
              <img v-show="false" src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png" />
            </el-button>
          </el-button-group>
          <el-button-group class="elGroupButton_two">
            <el-button @click="buttonClick" data-msg="copy" class="buttonChild" title="复制">
              <img src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png" />
              <img v-show="false" src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png" />
            </el-button>
            <el-button @click="buttonClick" data-msg="print" class="buttonChild" title="打印预览">
              <img src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png" />
              <img v-show="false" src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png" />
            </el-button>
          </el-button-group>
        </div>
      </div>
      <el-table :data="classesTimeSetTable" @cell-click="tableCellClick" border class="g-timeSettingTable">
        <el-table-column label="节/周">
          <template scope="props">
            <span v-text="'第'+(props.$index+1)+'节'"></span>
          </template>
        </el-table-column>
        <el-table-column v-for="n in 7" :key="n" :label="weekData[n-1]">
          <template scope="props">
            <span v-if="props.row[n-1]==0" class="NotCourse">不上课</span>
            <span v-if="props.row[n-1]==2" class="SetNotCourse">不排课</span>
          </template>
        </el-table-column>
      </el-table>
    </div>
  </section>
</template>
<script>
  import {mapState} from 'vuex'
  import {classesTimeSettingGrade,//得到班级年级
    classesTimeSettingTable,/*table默认数据*/
    classesTimeSettingSaved,//保存时间限制
  } from '@/api/http'
  export default{
    data(){
      return{
        /*tree*/
        treeData:[],
        defaultProps: {
          children: 'data',
          label:'name',
        },
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
      /*header的button群*/
      buttonClick(event){
        const e=$(event.currentTarget),targetMsg=e.data('msg');
        if(targetMsg=='add'){
          this.isDialog=true;
        }
        this.changeButtonCss(e);
      },
      changeButtonCss(target){
        const index=$('.buttonChild').index(target);
        for(let i=0,len=$('.buttonChild').length;i<len;i++){
          if(i==index){
            /*修改css*/
            if(index % 2==0){
              /*even*/
              target.css({background:'#4da1ff',borderColor:'#4da1ff'});
            }else{
              target.css({background:'#ff5b5b',borderColor:'#ff5b5b'});
            }
            /*修改img*/
            target.find('img').eq(0).css({display:'none'});
            target.find('img').eq(1).css({display:'inline-block'});
          }else{
            /*修改img*/
            $('.buttonChild').eq(i).find('img').eq(0).css({display:'inline-block'});
            $('.buttonChild').eq(i).find('img').eq(1).css({display:'none'});
            /*修改css*/
            $('.buttonChild').eq(i).css({background:'',borderColor:''});
          }
        }
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
          else{
            if(row[columnNum]==2){
              this.$set(row,columnNum,1);
            }else{
              this.$set(row,columnNum,2);
            }
          }
        }
      },
      /*send ajax*/
      /*得到年级和班级ajax*/
      getGradeAjax(){
        classesTimeSettingGrade({pkListId:this.pkListId}).then(data=>{
          this.treeData=this.handlerData(data);
          /*headerText*/
          if(this.treeData.length>0){
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
        classesTimeSettingTable({pkListId:this.pkListId,gradeId:this.gradeId,classId:this.classId}).then(data=>{
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
    },
    created(){
      this.getGradeAjax();
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../../style/arrangeClasses/classSchedule';
  @import '../../../../../style/arrangeClasses/classSchedule/classesSchedule';
  @import '../../../../../style/arrangeClasses/arrangeClasses.css';
</style>




