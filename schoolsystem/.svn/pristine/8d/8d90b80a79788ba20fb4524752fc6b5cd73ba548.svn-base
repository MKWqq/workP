<template>
  <div class="reviseSubClassPlan">
    <el-row type="flex" align="middle" class="subClassDivision_title">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <h3>修改分班方案</h3>
    </el-row>
    <el-row class="reviseSubClassPlan_body">
      <el-form ref="form" :model="form" label-width="180px" class="subMsg">
        <el-form-item label="分班方案名称：">
          <el-input v-model="form.name"></el-input>
        </el-form-item>
        <el-form-item label="学生填报志愿时间：">
          <el-col :span="8">
            <el-date-picker type="datetime" placeholder="选择时间" v-model="form.startTime" style="width: 100%;"></el-date-picker>
          </el-col>
          <el-col class="line" :span="1">-</el-col>
          <el-col :span="8">
            <el-date-picker type="datetime" placeholder="选择时间" v-model="form.endTime" style="width: 100%;"></el-date-picker>
          </el-col>
        </el-form-item>
        <el-form-item label="调整志愿时间：">
          <el-col :span="8">
            <el-date-picker type="datetime" placeholder="选择时间" v-model="form.startTime" style="width: 100%;"></el-date-picker>
          </el-col>
          <el-col class="line" :span="1">-</el-col>
          <el-col :span="8">
            <el-date-picker type="datetime" placeholder="选择时间" v-model="form.endTime" style="width: 100%;"></el-date-picker>
          </el-col>
        </el-form-item>
        <el-form-item label="允许学生查询成绩：">
          <el-switch on-text="是" off-text="否" on-color="#09baa7"
                     off-color="#ff8686" v-model="form.score"></el-switch>
        </el-form-item>
        <el-form-item label="允许学生反复修改志愿：">
          <el-switch on-text="是" off-text="否" on-color="#09baa7"
                     off-color="#ff8686" v-model="form.score"></el-switch>
        </el-form-item>
        <el-form-item label="允许班主任调整学生志愿：">
          <el-switch on-text="是" off-text="否" on-color="#09baa7"
                     off-color="#ff8686" v-model="form.score"></el-switch>
        </el-form-item>
        <el-form-item label="分科分班公告：" class="vuEditor">
          <el-row class="noticeUeditor">
            <Vueditor ref="vueditor"></Vueditor>
          </el-row>
        </el-form-item>
        <el-form-item class="submitBtn">
          <el-button type="primary" @click="save">保存</el-button>
          <el-button>重置</el-button>
        </el-form-item>
      </el-form>
    </el-row>
  </div>
</template>
<script>
  //vueditor编辑器
  import Vue from 'vue'
  import Vuex from 'vuex'
  import Vueditor from 'vueditor'
  import 'vueditor/dist/style/vueditor.min.css'
  import config from '@/components/vueditor/config'
  import req from '@/assets/js/common'

  Vue.use(Vuex);
  Vue.use(Vueditor, config);
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
      save(){
          var self=this;
        let inst = self.$refs.vueditor.getContent();
        self.form.content = inst;
        console.log(self.form);
      }
    }
  }
</script>
<style>
  .reviseSubClassPlan .reviseSubClassPlan_body{
    margin-top:3.43rem;
  }
  .reviseSubClassPlan .subMsg{
    width:75%;
    margin:auto;
  }
  .reviseSubClassPlan .line{
    text-align: center;
  }
  .reviseSubClassPlan .noticeUeditor {
    height: 25rem;
    border: 1px solid #c0c0c0;
    border-radius: 6px;
  }
  .reviseSubClassPlan .submitBtn{
    text-align: right;
  }
  .reviseSubClassPlan .submitBtn .el-button{
    width:7.5rem;
    padding:10px 0;
    border-radius: 20px;
    border: 1px solid #4da1ff;
    color: #4da1ff;
  }
  .reviseSubClassPlan .submitBtn .el-button--primary{
    color: #fff;
  }
  .reviseSubClassPlan .vuEditor .el-form-item__content{
    line-height:1;
  }
</style>
