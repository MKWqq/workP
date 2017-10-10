<template>
  <div class="g-ManualScheduce">
    <header class="g-timeHeader">
      <div class="g-buttonGroup">
        <el-button class="g-gobackChart RedButton" @click="goBackChart">
          <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
          返回流程图
        </el-button>
        <el-button class="blueButton" @click="saveSetting">保存</el-button>
      </div>
      <el-form ref="selectGroup" :model="selectGroupForm" label-position="left" label-width="40px" class="g-selectGroup">
        <el-form-item label="年级">
          <el-select v-model="selectGroupForm.gradeId">
            <el-option label="七年级" value="7"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="班级">
          <el-select v-model="selectGroupForm.classesId">
            <el-option label="1班" value="1"></el-option>
          </el-select>
        </el-form-item>
      </el-form>
    </header>
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
        <header>
          <h2 v-text="headerText+'课表'"></h2>
        </header>
        <el-table :data="classesTimeSetTable" @cell-click="tableCellClick" border class="g-timeSettingTable g-ManualScheduceTable">
          <el-table-column label="节/周">
            <template scope="props">
              <span v-text="'第'+(props.$index+1)+'节'"></span>
            </template>
          </el-table-column>
          <el-table-column v-for="n in 5" :key="n" :label="weekData[n-1]">
            <template scope="props">
              <span v-if="props.row[n-1]==0" class="NotCourse">不上课</span>
              <span v-if="props.row[n-1]==2 || props.row[n-1]==3" class="NotCourse">不排课</span>
              <span v-if="props.row[n-1]==4" class="SetNotCourse">不排课</span>
            </template>
          </el-table-column>
        </el-table>
      </div>
      <div class="g-sectionR alertsList">
        <header>
          <h2 v-text="headerText+'课表'"></h2>
        </header>
        <el-table :data="classesTimeSetTable" @cell-click="tableCellClick" border class="g-timeSettingTable g-ManualScheduceTable">
          <el-table-column label="节/周">
            <template scope="props">
              <span v-text="'第'+(props.$index+1)+'节'"></span>
            </template>
          </el-table-column>
          <el-table-column v-for="n in 5" :key="n" :label="weekData[n-1]">
            <template scope="props">
              <span v-if="props.row[n-1]==0" class="NotCourse">不上课</span>
              <span v-if="props.row[n-1]==2 || props.row[n-1]==3" class="NotCourse">不排课</span>
              <span v-if="props.row[n-1]==4" class="SetNotCourse">不排课</span>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </section>
  </div>
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
        /*表格header文本*/
        headerText:'',
        /*select选择年级数据双向绑定*/
        selectGroupForm:{
          gradeId:'',
          classesId:''
        },
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
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'examinationChart'});
      },
      /*保存*/
      saveSetting(){
        teacherTimeSettingSaved({pkListId:this.pkListId,teacherId:this.techerId,teacherName:this.techerName,data:this.classesTimeSetTable}).then(data=>{
          if(data.statu==1){
            this.$message({
              message:'保存成功!',
              type:'success'
            });
            this.getTableData();
          }else{
            this.$message.error('保存失败!');
          }
        })
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
          this.headerText=data.techerName+'('+node.parent.data.techerName+')';
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
            this.headerText=this.treeData[0].data[0].techerName+'('+this.treeData[0].techerName+')';
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
      /*修改table的header文本*/
      changeHeaderText(){
        /*headerText*/
        if(this.treeData.length>0){
          this.headerText=this.treeData[0].name+this.treeData[0].data[0].name;
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
  @import '../../../../style/arrangeClasses/ManualScheduce';
  @import '../../../../style/arrangeClasses/arrangeClasses.css';
</style>




