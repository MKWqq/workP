<template>
    <div class="createDistribution">
      <el-row type="flex" align="middle">
        <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
          src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
          alt=""><span class="returnTxt">返回</span></el-button>
        <h3>创建宿舍分配方案</h3>
      </el-row>
      <el-row class="createDistribution_body">
        <el-form ref="form" :rules="rules" :model="form" label-width="150px" class="subMsg">
          <el-form-item label="宿舍分配方案名称：" prop="name">
            <el-input v-model="form.name" placeholder="请输入宿舍分配方案名称"></el-input>
          </el-form-item>
          <el-form-item label="宿舍分配年级：" prop="grade">
            <el-select v-model="form.grade" placeholder="请选择" style="width: 100%;">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="宿舍分配公告：" class="vuEditor">
            <el-row class="noticeUeditor">
              <Vueditor ref="vueditor"></Vueditor>
            </el-row>
          </el-form-item>
          <el-form-item class="submitBtn">
            <el-button type="primary" @click="save">创建</el-button>
            <el-button @click="save">重置</el-button>
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
                grade: ''
              },
              options: [{
                value: '选项1',
                label: '黄金糕'
              }, {
                value: '选项2',
                label: '双皮奶'
              }],
              rules: {
                name: [
                  {required: true, message: '请输入活动名称', trigger: 'blur'},
//              { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                ],
                grade: [
                  {required: true, message: '请选择活年级', trigger: 'change'}
                ]
              }
            }
        },
        methods: {
          returnFlowchart(){
            this.$router.go(-1);
          },
          save(){
            var self = this;
            let inst = self.$refs.vueditor.getContent();
            self.form.content = inst;
            this.$refs['form'].validate((valid) => {
              if (valid) {
                console.log(self.form);
              } else {
                return false;
              }
            });
          }
        }
    }
</script>
<style>
  .createDistribution .createDistribution_body {
    margin: 4.375rem 0;
  }

  .createDistribution .subMsg {
    width: 75%;
    margin: auto;
  }

  .createDistribution .line {
    text-align: center;
  }

  .createDistribution .noticeUeditor {
    height: 25rem;
    border: 1px solid #c0c0c0;
    border-radius: 6px;
  }

  .createDistribution .submitBtn {
    text-align: right;
    margin-top:2rem;
  }

  .createDistribution .submitBtn .el-button {
    width: 7.5rem;
    padding: 10px 0;
    border-radius: 20px;
    border: 1px solid #4da1ff;
    color: #4da1ff;
  }

  .createDistribution .submitBtn .el-button--primary {
    color: #fff;
  }

  .createDistribution .vuEditor .el-form-item__content {
    line-height: 1;
  }
</style>
