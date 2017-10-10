<template>
  <div class="into">
    <el-row>
      <el-row class="into_row">
        <span class="into_subTitle">学生信息</span>
      </el-row>
      <el-row :gutter="100" type="flex" justify="center">
        <el-col :span="8">
          <el-form ref="studentMsgOne" :rules="studentMsgRules" :model="studentMsg" label-width="100px">
            <el-form-item label="姓名：" prop="name">
              <el-input placeholder="请输入姓名" v-model="studentMsg.name"></el-input>
            </el-form-item>
            <el-form-item label="性别：" prop="sex">
              <el-radio-group v-model="studentMsg.sex">
                <el-radio label="0">女</el-radio>
                <el-radio label="1">男</el-radio>
              </el-radio-group>
            </el-form-item>
            <el-form-item label="学籍号：">
              <el-input placeholder="请输入学籍号" v-model="studentMsg.sNumber"></el-input>
            </el-form-item>
            <el-form-item label="原地址：">
              <el-input placeholder="请输入原地址" v-model="studentMsg.oldAddress"></el-input>
            </el-form-item>
          </el-form>
        </el-col>
        <el-col :span="8">
          <el-form ref="studentMsgTwo" :model="studentMsg" label-width="120px">
            <el-form-item label="身份证件类型：">
              <el-select v-model="studentMsg.type" placeholder="请选择身份证件类型" style="width:100%;">
                <el-option label="区域一" value="shanghai"></el-option>
                <el-option label="区域二" value="beijing"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="身份证号：">
              <el-input placeholder="请输入18位身份证号" v-model="studentMsg.number"></el-input>
            </el-form-item>
            <el-form-item label="户籍所在地：">
              <el-select v-model="studentMsg.household" placeholder="请选择省/市/县、区" style="width:100%;">
                <el-option label="区域一" value="shanghai"></el-option>
                <el-option label="区域二" value="beijing"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="现地址：">
              <el-input placeholder="请输入现地址" v-model="studentMsg.newAddress"></el-input>
            </el-form-item>
          </el-form>
        </el-col>
      </el-row>
    </el-row>
    <el-row>
      <el-row class="into_row">
        <span class="into_subTitle">转入本校信息</span>
      </el-row>
      <el-row :gutter="100" type="flex" justify="center">
        <el-col :span="8">
          <el-form ref="intoMsgOne" :rules="intoMsgRules" :model="intoMsg" label-width="120px">
            <el-form-item label="拟读年级：" prop="grade">
              <el-select v-model="intoMsg.grade" placeholder="请选择拟读年级" style="width:100%;">
                <el-option label="区域一" value="shanghai"></el-option>
                <el-option label="区域二" value="beijing"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="拟读班级：" prop="class">
              <el-select v-model="intoMsg.class" placeholder="请选择拟读班级" style="width:100%;">
                <el-option label="区域一" value="shanghai"></el-option>
                <el-option label="区域二" value="beijing"></el-option>
              </el-select>
            </el-form-item>
          </el-form>
        </el-col>
        <el-col :span="8">
          <el-form ref="intoMsgTwo" :model="intoMsg" label-width="120px">
            <el-form-item label="报道日期：">
              <el-date-picker
                v-model="intoMsg.date"
                type="datetime"
                placeholder="选择日期时间" style="width: 100%">
              </el-date-picker>
            </el-form-item>
          </el-form>
        </el-col>
      </el-row>
    </el-row>
    <el-row>
      <el-row class="into_row">
        <span class="into_subTitle">转出学校信息</span>
      </el-row>
      <el-row :gutter="100" type="flex" justify="center">
        <el-col :span="8">
          <el-form ref="outMsgOne" :model="outMsg" label-width="120px">
            <el-form-item label="学校名称：">
              <el-input placeholder="请输入学校名称" v-model="outMsg.name"></el-input>
            </el-form-item>
            <el-form-item label="学校标识编码：">
              <el-input placeholder="请输入学校标识编码" v-model="outMsg.number"></el-input>
            </el-form-item>
            <el-form-item label="转出日期：">
              <el-date-picker
                v-model="outMsg.date"
                type="datetime"
                placeholder="选择日期时间" style="width: 100%">
              </el-date-picker>
            </el-form-item>
          </el-form>
        </el-col>
        <el-col :span="8">
          <el-form ref="outMsgTwo" :model="outMsg" label-width="120px">
            <el-form-item label="限读年级：">
              <el-select v-model="outMsg.grade" placeholder="请选择限读年级" style="width:100%;">
                <el-option label="区域一" value="shanghai"></el-option>
                <el-option label="区域二" value="beijing"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="限读班级：">
              <el-select v-model="outMsg.class" placeholder="请选择限读班级" style="width:100%;">
                <el-option label="区域一" value="shanghai"></el-option>
                <el-option label="区域二" value="beijing"></el-option>
              </el-select>
            </el-form-item>
          </el-form>
        </el-col>
      </el-row>
      <el-row :gutter="100" type="flex" justify="center">
        <el-col :span="16">
          <el-form ref="outMsgOne" :model="outMsg" label-width="120px">
            <el-form-item label="申请理由：">
              <el-input type="textarea" resize="none" placeholder="请输入申请理由" v-model="outMsg.name"></el-input>
            </el-form-item>
          </el-form>
        </el-col>
      </el-row>
    </el-row>
    <el-row class="into_row into_btn">
      <el-button type="primary" @click="save">提交</el-button>
      <el-button>重置</el-button>
    </el-row>
  </div>
</template>
<script>
  export default{
    data(){
      return {
        studentMsg:{
            name:'',
          sex:'0',
          sNumber:'',
          oldAddress:'',
          type:'',
          number:'',
          household:'',
          newAddress:''
        },
        intoMsg:{
          grade:'',
          class:'',
          date:''
        },
        outMsg:{
            name:'',
            number:'',
            date:'',
            grade:'',
            class:'',
            reason:''
        },
        studentMsgRules: {
          name: [
            { required: true, message: '请输入姓名', trigger: 'blur' },
//            { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
          ],
          sex:[
            { required: true, message: '请选择性别', trigger: 'change' }
          ]
        },
        intoMsgRules:{
          grade: [
            { required: true, message: '请选择年级', trigger: 'change' },
          ],
          class:[
            { required: true, message: '请选择班级', trigger: 'change' }
          ]
        }
      }
    },
    methods: {
        save(){
          this.$refs['studentMsgOne'].validate((valid) => {
            if (valid) {
            } else {
              return false;
            }
          });
          this.$refs['intoMsgOne'].validate((valid) => {
            if (valid) {
            } else {
              return false;
            }
          });
        }
    }
  }
</script>
<style>
  .into .into_row{
    margin:3.125rem 0 2rem;
  }
  .into .into_subTitle {
    display: inline-block;
    width: 7.5rem;
    height: 2rem;
    line-height: 2rem;
    padding: 0;
    border-radius: 0 15px 15px 0;
    -webkit-box-shadow: 0 5px 5px 0 #ddd;
    -moz-box-shadow: 0 5px 5px 0 #ddd;
    box-shadow: 0 5px 5px 0 #ddd;
    background-color: #89bcf5;
    border-color: #89bcf5;
    color: #fff;
    text-align: center;
  }
  .into .el-textarea__inner{
    height: 9.375rem;
  }
  .into .into_btn{
    text-align: center;
  }
  .into .into_btn .el-button{
    padding:.5rem 2.1rem;
    border-radius: 20px;
  }
</style>
