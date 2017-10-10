<template>
  <div class="g-container">
    <header class="g-header">
      <div class="gh-section clear_fix">
        <el-form ref="totalScheduleForm" lable-position="left" :model="dataHeader" label-width="85px">
          <el-form-item label="显示教师:">
            <el-switch on-text="是" off-text="否" on-color="#13b5b1" off-color="#999" v-model="dataHeader.showTeacher"></el-switch>
          </el-form-item>
          <el-form-item label="科目单字:">
            <el-switch on-text="是" off-text="否" on-color="#13b5b1" off-color="#999" v-model="dataHeader.subjectOneWord"></el-switch>
          </el-form-item>
        </el-form>
      </div>
    </header>
    <section class="g-section">
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
      <div class="gs-table alertsList">
        <el-table :data="testTable" @cell-click="tableCellClick" border class="NotTdPadding g-timeSettingTable">
          <el-table-column label="年级" prop="name"></el-table-column>
          <el-table-column v-for="n in 2" :key="n" label="节/周">
            <template scope="props">
              <div class="table-cell" v-for="(content,index) in props.row.value" v-text="'第'+(index+1)+'节'"></div>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </section>
  </div>
</template>
<script>
  import {mapState} from 'vuex'
  import {classesTimeSettingGrade,//得到班级年级
    classesTimeSettingTable,/*table默认数据*/
    classesTimeSettingSaved,//保存时间限制
  } from '@/api/http'
  export default{
    data(){
      let _self=this;
      return{
        /*form表单双向绑定数据*/
        dataHeader:{
          /*显示div中文件信息值*/
          showTeacher:'',
          subjectOneWord:'',
        },
        /*table数据请求所需参数*/
        gradeId:'',
        gradeName:'',
        classId:'',
        className:'',
        /*table框绑定数据*/
        classesTimeSetTable:[],
        testTable:[{name:'1',value:[1,2,3]},{name:'2',value:_self.classesTimeSetTable}],
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
          console.log(data);
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
  @import '../../../../../style/arrangeClasses/classSchedule/totalSchedule';
  @import '../../../../../style/arrangeClasses/arrangeClasses.css';
</style>


