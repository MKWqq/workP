<template>
  <div class="g-container">
    <header class="g-header">
      <div class="gh-header">排课管理</div>
    </header>
    <section class="g-section">
      <div class="gs-header">
        <div class="gs-button alertsBtn">
          <el-button @click="buttonClick" data-msg="add" class="filt" title="新增排课方案">
            <img class="filt_unactive" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add.png" />
            <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add_highlight.png" />
          </el-button>
        </div>
      </div>
      <div class="gs-table alertsList">
        <el-table class="g-NotHover" ref="studentMsgTable" :data="headerButtonData.LoadBasicMsg" style="width:100%" @sort-change="sortChange" @selection-change="handleTable">
          <!--show-overflow-tooltip 超出部分省略号显示-->
          <el-table-column type="selection" width="55"></el-table-column>
          <el-table-column label="序号" type="index" width="150"></el-table-column>
          <el-table-column label="方案名称" sortable>
            <template scope="props">
              <a href="javascript:void(0);" :data-msg="props.row.id" @click="changeExamChart" v-text="props.row.pkPlanName"></a>
            </template>
          </el-table-column>
          <el-table-column label="排课范围">
            <template scope="props">
              <span v-for="range in props.row.name.split(',')" v-text="gradeData[range-1]"></span>
            </template>
          </el-table-column>
          <el-table-column label="创建时间" prop="createTime" sortable></el-table-column>
          <el-table-column label="是否启用">
            <template scope="props">
              <div v-if="props.row.ifStartUp==1">初始完成</div>
              <el-switch v-else on-text="是" off-text="否" off-color="#ff8686" on-color="#4da1ff" v-model="switchData"></el-switch>
            </template>
          </el-table-column>
          <el-table-column label="操作">
            <template scope="scope">
              <el-button type="text" @click="copeCreate(scope.$index)">复制</el-button>
              <el-button type="text" @click="deleteClick(scope.$index)">删除</el-button>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </section>
    <el-dialog class="addDialog" :title="dialogTitle" :modal="false" :visible.sync="isDialog" size="tiny" :before-close="handlerClose">
      <el-form ref="addDataForm" :rules="addRule" :model="addForm" label-width="90px">
        <el-form-item label="排课名称:" prop="pkPlanName">
          <el-input v-model="addForm.pkPlanName"></el-input>
        </el-form-item>
        <el-form-item label="排课范围:" prop="pkRange">
          <el-select multiple placeholder="请选择排课范围" v-model="addForm.pkRange">
            <el-option v-for="(gradeMsg,i) in  headerButtonData.gradeAjaxData" :key="i" :label="gradeData[gradeMsg.name-1]" :value="gradeMsg.gradeid"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="起始日期:" prop="startTime">
          <el-date-picker type="date" :picker-options="pickerOptionsStart" placeholder="选择起始日期" v-model="addForm.startTime" style="width:100%"></el-date-picker>
        </el-form-item>
        <el-form-item label="结束日期:" prop="endTime">
          <el-date-picker type="date" :picker-options="pickerOptionsEnd" placeholder="选择结束日期" v-model="addForm.endTime" style="width:100%"></el-date-picker>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button type="primary" @click="addCourseClick">保存</el-button>
      </div>
    </el-dialog>
    <el-dialog class="copyDialog" title="复制排课方案" :modal="false" :visible.sync="isCopyDialog" size="tiny" :before-close="handlerClose">
      <el-form ref="copyForm" :model="copyForm" label-width="90px">
        <el-form-item label="排课名称:">
          <el-input v-model="copyForm.pkPlanName"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button type="primary" @click="copyCourseSave">保存</el-button>
      </div>
    </el-dialog>
    <!--提示框-->
  </div>
</template>
<script>
  import {mapMutations} from 'vuex'
  import {arrangeManageLoad,//页面加载数据
    arrangeManageAdd,//添加排课方案
    arrangeManageDelete,//删除排课方案
    arrangeManageGradeRange,//得到年级范围
  } from '@/api/http'
  export default{
    data(){
      let _self=this;
      return{
        /*ajax data*/
        headerButtonData:{
          gradeloadData:[],
          classesLoadData:[],
          msgTypeLoadData:[],
          LoadBasicMsg:[],//加载页面的table数据
          gradeAjaxData:[],//添加弹框排课范围
        },
        /*年级显示转换*/
        gradeData:['一年级','二年级','三年级','四年级','五年级','六年级','初一','初二',
          '初三','高一','高二','高三'
        ],
        /*switch数据双向绑定,当发送请求时需要转换值，switch为true时，headerButtonData.LoadBasicMsg.ifStartUp=3；false为2*/
        switchData:false,
        /*弹框*/
        dialogTitle:'新增排课方案',
        isDialog:false,
        addForm:{
          pkPlanName:'',
          pkRange:[],
          startTime:'',
          endTime:'',
        },
        /*复制弹框*/
        isCopyDialog:false,
        copyIndex:'',
        copyForm:{
          pkPlanName:'',
        },
        /*rule*/
        addRule:{
          pkPlanName:[{required:true,message:'请填写排课名称'}],
          pkRange:[{required:true,message:'请填写排课范围'}],
          startTime:[{required:true,message:'请选择起始日期'}],
          endTime:[{required:true,message:'请选择结束日期'}],
        },
        /*时间选择限制*/
        pickerOptionsStart:{
          disabledDate(time){
            if(_self.addForm.endTime){
              return time.getTime()<Date.now()-8.64e7 || time.getTime()>Date.parse(_self.addForm.endTime);
            }
            else{
              return time.getTime()<Date.now()-8.64e7;
            }
          }
        },
        pickerOptionsEnd:{
          disabledDate(time){
            if(_self.addForm.startTime){
              return time.getTime()<Date.parse(_self.addForm.startTime);
            }
            else{
              return time.getTime()<Date.now()-8.64e7;
            }
          }
        },
      }
    },
    computed:{},
    methods:{
      /*修改教学方案页面信息*/
      ...mapMutations(['changeArrangeClasses']),
      changeExamChart(event){
        const e=$(event.currentTarget);
        this.changeArrangeClasses({name:e.text(),id:e.data('msg')});
        this.$router.push({name:'examinationChart'});
      },
      /*复制*/
      copeCreate(index){
        this.isCopyDialog=true;
        this.copyIndex=index;
      },
      /*删除*/
      deleteClick(index){
        this.$confirm('确定删除此条排课方案','提示',{
          confirmButtonText:'确定',
          cancelButtonText:'取消',
          type:'warning'
        }).then((action)=>{
          arrangeManageDelete({id:this.headerButtonData.LoadBasicMsg[index].id}).then(data=>{
            this.sendAjaxPrompt(data,'删除');
            this.sendLoadAjax();
          });
        }).catch(()=>{});
      },
      /*table*/
      handleTable(section){
        /*section为选择项行信息组成的数组*/
        console.log(section);
      },
      sortChange(column){
        /*table sortType排序回调*/
        console.log(column);
      },
      /*点击header处的button*/
      buttonClick(event){
        const e=$(event.currentTarget),targetMsg=e.data('msg');
        if(targetMsg=='add'){
          this.isDialog=true;
          this.dialogTitle='新增排课方案';
          if(this.$refs['addDataForm']){
            this.$refs['addDataForm'].resetFields();
          }
          this.getGradeRangeAjax();
        }
      },
      changeButtonCss(target){
        const index=$('.buttonChild').index(target);
        for(let i=0,len=$('.buttonChild').length;i<len;i++){
          if(i==index){
            /*修改css*/
            if(index % 2==0){
              /*even*/
              target.css({background:'#4da1ff',borderColor:'#4da1ff'});
            }
            else{
              target.css({background:'#ff5b5b',borderColor:'#ff5b5b'});
            }
            /*修改img*/
            target.find('img').eq(0).css({display:'none'});
            target.find('img').eq(1).css({display:'inline-block'});
          }
          else{
            /*修改img*/
            $('.buttonChild').eq(i).find('img').eq(0).css({display:'inline-block'});
            $('.buttonChild').eq(i).find('img').eq(1).css({display:'none'});
            /*修改css*/
            $('.buttonChild').eq(i).css({background:'',borderColor:''});
          }
        }
      },
      /*弹框*/
      handlerClose(done){
        /*this.$confirm('确认关闭？').then(()=>{done();}).catch();*/
        done();
      },
      /*新增排课方案*/
      addCourseClick(){
        this.$refs['addDataForm'].validate((valid)=>{
          if(valid){
            this.isDialog=false;
            arrangeManageAdd({pkPlanName:this.addForm.pkPlanName,pkRange:this.addForm.pkRange.join(','),startTime:this.addForm.startTime,endTime:this.addForm.endTime}).then(data=>{
              this.sendAjaxPrompt(data,'添加');
            });
          }else{
            this.$alert('请添完整相关信息!','提示',{
              confirmButtonText:'确定',
              type:'error',
              callback:actions=>{}
            });
          }
        });
      },
      /*send ajax*/
      /*复制信息保存*/
      copyCourseSave(){
        if(this.copyForm.pkPlanName){
          /*判断是否重名*/
          for(let i=0;i<this.headerButtonData.LoadBasicMsg.length;i++){
            if(this.headerButtonData.LoadBasicMsg[i].pkPlanName==this.copyForm.pkPlanName){
              this.alertError('已存在该方案名，请重新输入!');
              return;
            }
          }
          this.isCopyDialog=false;
          arrangeManageAdd({pkPlanName:this.copyForm.pkPlanName,pkRange:this.headerButtonData.LoadBasicMsg[this.copyIndex].pkRange,startTime:this.headerButtonData.LoadBasicMsg[this.copyIndex].startTime,endTime:this.headerButtonData.LoadBasicMsg[this.copyIndex].endTime}).then(data=>{
            this.sendAjaxPrompt(data,'复制');
          });
        }
        else{
          this.alertError('请输入方案名!');
        }
      },
      /*得到排课方案*/
      sendLoadAjax(){
        arrangeManageLoad().then(data=>{
          console.log(data);
          this.headerButtonData.LoadBasicMsg=this.handlerData(data);
          if(this.headerButtonData.LoadBasicMsg.ifStartUp==1){
            return;
          }
          else{
            if(this.headerButtonData.LoadBasicMsg.ifStartUp==2){
              this.switchData=false;
            }else{
              this.switchData=true;
            }
          }
        });
      },
      /*得到年级范围*/
      getGradeRangeAjax(){
        arrangeManageGradeRange().then(data=>{
          this.headerButtonData.gradeAjaxData=data;
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
      /*发送ajax提示框*/
      sendAjaxPrompt(data,msg){
        if(data.statu){
          this.$message({
            message:msg+'成功!',
            type:'success'
          });
          this.sendLoadAjax();
        }else{
          this.$message.error(msg+'失败,请重试!');
        }
      },
      /*错误提示弹框*/
      alertError(msg){
        this.$alert(msg,'提示',{
          confirmButtonText:'确定',
          type:'error',
          callback:action=>{}
        });
      },
    },
    created(){
      this.sendLoadAjax();
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/arrangeClasses/arrageClasses.less';
  @import '../../../../style/arrangeClasses/arrangeClasses.css';
</style>















