<template>
  <div class="newDcoument">
    <h3>新建用车申请</h3>
    <el-row class="newDoc-top" type="flex" align="middle">
      <el-col :span="24">
        <el-col :span="11">
          <el-col :span="4" class="newDoc-top-title"><span style="color:red">*</span> 标题：</el-col>
          <el-col :span="20">
            <el-input v-model="param.title"></el-input>
          </el-col>
        </el-col>
        <el-col :span="11" :offset="2">
          <el-col :span="4" class="newDoc-top-title"><span style="color:red">*</span>类型：</el-col>
          <el-col :span="20">
            <el-select style="width: 100%" v-model="param.name" placeholder="请选择">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-col>
        </el-col>
      </el-col>
    </el-row>
    <el-row class="newDoc-top" type="flex" align="middle">
      <el-col :span="24">
        <el-col :span="11">
          <el-col :span="4" class="newDoc-top-title"><span style="color:red">*</span>车辆类型：</el-col>
          <el-col :span="20">
            <el-select style="width: 100%" v-model="param.name" placeholder="请选择">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-col>
        </el-col>
        <el-col :span="11" :offset="2">
          <el-col :span="4" class="newDoc-top-title"><span style="color:red">*</span> 用车人数：</el-col>
          <el-col :span="20">
            <el-input v-model="param.title" placeholder="请输入用车人数"></el-input>
          </el-col>
        </el-col>

      </el-col>
    </el-row>
    <el-row class="newDoc-top" type="flex" align="middle">
      <el-col :span="24">
        <el-col :span="11">
          <el-col :span="4" class="newDoc-top-title"><span style="color:red">*</span> 目的地：</el-col>
          <el-col :span="20">
            <el-input v-model="param.title" placeholder="请输入目的地"></el-input>
          </el-col>
        </el-col>
        <el-col :span="11" :offset="2">
          <el-col :span="4" class="newDoc-top-title"><span style="color:red">*</span> 用车联系人：</el-col>
          <el-col :span="20">
            <el-input v-model="param.title" placeholder="请输入真实姓名"></el-input>
          </el-col>
        </el-col>
      </el-col>
    </el-row>
    <el-row class="newDoc-top" type="flex" align="middle">
      <el-col :span="24">
        <el-col :span="11">
          <el-col :span="4" class="newDoc-top-title"><span style="color:red">*</span> 联系电话：</el-col>
          <el-col :span="20">
            <el-input v-model="param.title" placeholder="请输入用车人联系电话"></el-input>
          </el-col>
        </el-col>
        <el-col :span="11" :offset="2">
          <el-col :span="4" class="newDoc-top-title"><span style="color:red">*</span> 开始时间：</el-col>
          <el-col :span="20">
            <el-date-picker
              style="width: 100%;"
              v-model="StartTime"
              type="datetime">
            </el-date-picker>
          </el-col>
        </el-col>
      </el-col>
    </el-row>
    <el-row class="newDoc-top" type="flex" align="middle">
      <el-col :span="24">
        <el-col :span="11">
          <el-col :span="4" class="newDoc-top-title"><span style="color:red">*</span> 结束时间：</el-col>
          <el-col :span="20">
            <el-date-picker
              style="width: 100%;"
              v-model="EndTime"
              type="datetime">
            </el-date-picker>
          </el-col>
       </el-col>
        <el-col :span="11" :offset="2">
          <el-col :span="4" class="newDoc-top-title">申请时长：</el-col>
          <el-col :span="20">
            <el-input v-model="param.title"></el-input>
          </el-col>
        </el-col>
      </el-col>
    </el-row>
    <el-row class="newDoc-top" type="flex" align="middle">
      <el-col :span="24">
        <el-col :span="2" class="newDoc-top-title" style="margin-left: -.8rem"><span style="color:red">*</span> 申请原因：</el-col>
        <el-col :span="22" class="newDoc-vueditor">
          <Vueditor ref="vueditor"></Vueditor>
        </el-col>
      </el-col>
    </el-row>
    <el-row class="newDoc-top" style="margin:4rem 0 .8rem 0;"  type="flex" align="middle">
      <el-col :span="24">
        <el-col :span="22" class="Car-footer">
         <el-col>公差派车填表说明：</el-col>
          <el-col>1.“用车联系人”需填写真实姓名。</el-col>
          <el-col>2.提交表单前请核实“出发时间”和“返回时间”是否正确。</el-col>
          <el-col>3.请在“事由”一栏填写详细事由，否则可能被拒！</el-col>
          <el-col>4.标红色号*栏目不可留空，否则无法提交。</el-col>
        </el-col>
        <el-col :span="2">
          <el-button type="primary" class="Car-btn">发布</el-button>
        </el-col>
      </el-col>
    </el-row>
  </div>
</template>
<script>
  import Vue from 'vue'
  import Vueditor from 'vueditor'
  import 'vueditor/dist/style/vueditor.min.css'
  import config from '../../../../../components/vueditor/config'
  import req from '../../../../../assets/js/common'
  import ElCol from "element-ui/packages/col/src/col";
  Vue.use(Vueditor, config);
  export default{
    data(){
      return {
        options: [{
          value: '',
        }],
        EndTime:new Date(),
        StartTime:new Date(),
        fileList: [],
        param: {
          title: '',
          name:'',
          type: 'create',
          content: '',
        }
      }
    },
    created(){
      let param={
        kind:4
      };
      req.ajaxSend('/school/WorkDemand/getName','post',param,(res)=>{
        this.options = res.map(val=>({value:val.name}))
      });
    },
    methods: {
      PublishnewDoc(){

      },
    }
  }
</script>
<style lang="less">
  .newDcoument{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .newDoc-top{
    margin: 2rem 0 -1rem 0;
  }
  .newDoc-top-title{
    margin-top: 0.5rem;
    text-align: right;
  }
  .newDoc-text-title{
    font-weight: bold;
    padding-bottom: .8rem;
  }
  .newDoc-vueditor{
    height:20rem;
    border: 1px solid #c0c0c0;
    border-radius: 6px;
    width:92.38%;
  }
  @media (max-width: 1600px) {
    .noticeUeditor {
      height: 38.5rem;
    }
  }
  @media (max-width: 1420px) {
    .noticeUeditor {
      height: 37.7rem;
    }
  }
  .Car-footer{
    font-size:14/16rem ;
    color: #999999;
    letter-spacing:.1rem;
  }
  .Car-btn{
    width: 90%;
    margin-top:4rem;
  }
</style>
