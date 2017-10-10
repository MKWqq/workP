<template>
  <div class="publishSubClassResult">
    <el-row type="flex" align="middle" class="subClassDivision_title">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <h3>发布分班结果</h3>
    </el-row>
    <el-row class="publishSubClassResult_row">
      <el-form ref="form" :model="form" label-width="180px" class="subMsg">
        <el-form-item label="允许学生查看分班结果：">
          <el-switch on-text="是" off-text="否" on-color="#09baa7"
                     off-color="#ff8686" v-model="form.score"></el-switch>
        </el-form-item>
        <el-form-item label="分班结果展示起止时间：">
          <el-col :span="11">
            <el-date-picker type="datetime" placeholder="选择时间" v-model="form.startTime" style="width: 100%;"></el-date-picker>
          </el-col>
          <el-col class="line" :span="2">-</el-col>
          <el-col :span="11">
            <el-date-picker type="datetime" placeholder="选择时间" v-model="form.endTime" style="width: 100%;"></el-date-picker>
          </el-col>
        </el-form-item>
      </el-form>
      <el-row class="submitBtn">
        <el-button type="primary" @click="publish">发布</el-button>
      </el-row>
    </el-row>
  </div>
</template>
<script>
  import req from '@/assets/js/common'

  export default{
    data(){
      return {
        form: {
          name: '',
          score: true,
          startTime:'',
          endTime:'',
          content:''
        }
      }
    },
    methods: {
      returnFlowchart(){
        this.$router.push('/subClassDivisionHome');
      },
      publish(){
          var self=this;
        let inst = self.$refs.vueditor.getContent();
        self.form.content = inst;
        console.log(self.form);
      }
    }
  }
</script>
<style>
  .publishSubClassResult .publishSubClassResult_row{
    width:60%;
    margin:7.5rem auto 20rem;
  }
  .publishSubClassResult .line{
    text-align: center;
  }
  .publishSubClassResult .submitBtn{
    margin-top:6.25rem;
  }
  .publishSubClassResult .submitBtn .el-button{
  width:100%;
  }
</style>
