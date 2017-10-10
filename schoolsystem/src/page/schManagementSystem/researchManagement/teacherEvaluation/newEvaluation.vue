<template>
  <div class="g-newEvaluation g-container">
    <header class="g-textHeader">
      <h2>新建考评方案</h2>
    </header>
    <section class="g-content">
      <el-form ref="newEvaluationForm" :model="newEvaluationForm" :rules="formRule" label-position="left" label-width="85px">
        <el-form-item label="考评名称:" prop="name">
          <el-input v-model="newEvaluationForm.name" placeholder="请输入考评名称"></el-input>
        </el-form-item>
        <el-form-item label="考评时间:" required>
          <el-col :span="11">
            <el-form-item prop="startTime">
              <el-date-picker type="datetime" :picker-options="startPickerOption" placeholder="选择开始日期" v-model="newEvaluationForm.startTime" style="width: 100%;"></el-date-picker>
            </el-form-item>
          </el-col>
          <el-col class="el-icon-minus" :span="2"></el-col>
          <el-col :span="11">
            <el-form-item prop="endTime">
              <el-date-picker type="datetime" :picker-options="endPickerOption" placeholder="选择结束时间" v-model="newEvaluationForm.endTime" style="width: 100%;"></el-date-picker>
            </el-form-item>
          </el-col>
        </el-form-item>
      </el-form>
      <div class="g-footer">
        <el-button @click="createAjax" class="largeButton" type="primary">提交</el-button>
      </div>
    </section>
  </div>
</template>
<script>
  import {TeacherEvaluationCreate} from '@/api/http'
  import moment from 'moment'
  export default{
    data(){
      let _self=this;
      return{
        newEvaluationForm:{
          name:'',
          startTime:'',
          endTime:''
        },
        startPickerOption:{
          disabledDate(time){
            if(_self.newEvaluationForm.endTime){
              return time.getTime()<Date.now()-8.64e7 || time.getTime()>Date.parse(_self.newEvaluationForm.endTime);
            }else{
              return time.getTime()<Date.now()-8.64e7;
            }
          }
        },
        endPickerOption:{
          disabledDate(time){
            if(_self.newEvaluationForm.startTime){
              return time.getTime()<Date.parse(_self.newEvaluationForm.startTime)-8.64e7;
            }else{
              return time.getTime()<Date.now()-8.64e7;
            }
          }
        },
        formRule:{
          name:[{required:true,message:'请填写考评名称'}],
          startTime:[{required:true,message:'请填写考评日期'}],
          endTime:[{required:true,message:'请填写考评时间'}],
        },
      }
    },
    methods:{
      createAjax(){
        this.$refs['newEvaluationForm'].validate((valid)=>{
          if(valid){
            TeacherEvaluationCreate({type:'create',name:this.newEvaluationForm.name,startTime:moment(this.newEvaluationForm.startTime).format('YYYY-MM-DD HH:mm:ss'),endTime:moment(this.newEvaluationForm.endTime).format('YYYY-MM-DD HH:mm:ss')}).then(data=>{
              this.createHandler('创建考评方案',data);
            });
          }else{
            this.alertPrompt('请填写完整相关信息!');
          }
        });
      },
      /*创建等的数据处理*/
      createHandler(msg,data){
        if(data.status){
          this.$message({
            message:msg+'成功！',
            type:'success'
          });
          this.handlerCallBack();
        }else{
          this.$message({
            message:msg+'失败，请重试！',
            type:'error'
          });
        }
      },
      /*错误提示*/
      alertPrompt(msg){
        this.$alert(msg,'提示',{
          confirmButtonText:'确定',
          type:'error',
          callback:action=>{}
        });
      },
      /*数据处理成功回调*/
      handlerCallBack(){
        /*需根据页面不同进行修改*/
        this.$refs['newEvaluationForm'].resetFields();
      },
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/style';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.css';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.less';
  .g-content{/*848*/
    .width(848,1582);margin:170/16rem auto;
    /*时间选择中间横线*/
    .el-icon-minus{color:@elementBorder;text-align:center;.height(36);}
    button{.marginTop(100);}
  }
</style>




