<template>
  <section class="g-classesTimeSetSection">
    <div class="g-sectionL">
      <header class="gL-header">
        <h2>待选老师</h2>
        <el-input @input="fuzzyClick" v-model="fuzzyInput" class="fuzzyInput" placeholder="请输入教师姓名" icon="search"></el-input>
      </header>
      <section class="gL-section">
        <el-tree :highlight-current="true" default-expand-all :data="treeData" :props="defaultProps" ref="allMsg" :filter-node-method="filterNode" @node-click="handleNodeClick"></el-tree>
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
            <span v-if="props.row[n-1]==2 || props.row[n-1]==3" class="NotCourse">不排课</span>
            <span v-if="props.row[n-1]==4" class="SetNotCourse">不排课</span>
          </template>
        </el-table-column>
      </el-table>
    </div>
  </section>
</template>
<script>
  import {mapState} from 'vuex'
  import {teacherTimeSettingTeacherLoad,//得到教师
    teacherTimeSettingTabelLoad,/*table默认数据*/
    teacherTimeSettingSaved,//保存时间限制
  } from '@/api/http'
  import {fuzzyQuery} from '@/assets/js/fuzzyQuery'
  export default{
    data(){
      return{
        /*教师模糊查询*/
        fuzzyInput:'',
        /*tree*/
        treeData:[],
        defaultProps: {
          children: 'data',
          label:'techerName',
        },
        /*table数据请求所需参数*/
        techerId:'',
        techerName:'',
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
      /*教师信息模糊查询*/
      fuzzyClick(){
        /*input框输入值改变触发的函数*/
        this.$refs['allMsg'].filter(this.fuzzyInput);
      },
      filterNode(value, data) {
        /*筛选节点*/
        if (!value) return true;
        return data.techerName.indexOf(value) !== -1;
      },
      /*tree点击事件*/
      handleNodeClick(data,node){
        /*点击节点回调*/
        /*点击名字发送请求，返回数据绑定在右边部分*/
        /*给每一级赋值一个唯一的id即可辨认点击的是几级*/
        if('data' in data){
          return;
        }else{
          this.techerId=data.techerId;
          this.techerName=data.techerName;
          this.getTableData();
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
          else if(row[columnNum]==2 || row[columnNum]==3){
            this.$alert('已设置不排课，不能限制!','提示',{
              confirmButtonText:'确定',
              type:'error',
              callback:action=>{}
            });
            return;
          }
          else{
            if(row[columnNum]==4){
              this.$set(row,columnNum,1);
            }else{
              this.$set(row,columnNum,4);
            }
          }
        }
      },
      /*send ajax*/
      /*得到教师ajax*/
      getTeacherAjax(){
        teacherTimeSettingTeacherLoad({pkListId:this.pkListId}).then(data=>{
          this.treeData=this.handlerData(data);
          /*headerText*/
          if(this.treeData.length>0){
            this.techerId=this.treeData[0].data[0].techerId;
            this.techerName=this.treeData[0].data[0].techerName;
            this.getTableData();
          }
        })
      },
      /*得到表格默认信息*/
      getTableData(){
        teacherTimeSettingTabelLoad({pkListId:this.pkListId,teacherId:this.techerId}).then(data=>{
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
      this.getTeacherAjax();
      this.fuzzySearchArr=this.fuzzySearchData;
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../../style/arrangeClasses/classSchedule';
  @import '../../../../../style/arrangeClasses/classSchedule/teacherSchedule';
  @import '../../../../../style/arrangeClasses/arrangeClasses.css';
</style>




