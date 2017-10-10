<template>
  <div class="SchoolInformation">
    <h3>学校信息</h3>
    <el-row>
      <el-col :span="12" :offset="6" class="SchoolInformation-box">
        <el-col :span="24" class="SchoolInformation-top">
            <el-col :span="3">学校LOGO：</el-col>
            <el-col :span="6" class="UpLoad-head"></el-col>
            <el-col :span="10" :offset="1" class="SchoolInformation-upload">
              <el-col :span="24">尺寸：200*200</el-col>
              <el-col :span="24" class="SchoolInformation-upload-1">大小：< 2M</el-col>
              <el-col :span="24">
                <span  class="SchoolInformation-upload-2">上传图片</span>
              </el-col>
            </el-col>
          </el-col>
        <el-col :span="24" class="SchoolInformation-top">
          <el-col :span="3">学校名称：</el-col>
          <el-col :span="21">
            <el-input placeholder="请输入学校名称"></el-input>
          </el-col>
        </el-col>
        <el-col :span="24" class="SchoolInformation-top">
          <el-col :span="3">英文名：</el-col>
          <el-col :span="21">
            <el-input placeholder="请输入学校英文名称"></el-input>
          </el-col>
        </el-col>
        <el-col :span="24" class="SchoolInformation-top">
          <el-col :span="3">学校电话：</el-col>
          <el-col :span="21">
            <el-input placeholder="请输入学校电话"></el-input>
          </el-col>
        </el-col>
        <el-col :span="24" class="SchoolInformation-top">
          <el-col :span="3">学校邮箱：</el-col>
          <el-col :span="21">
            <el-input></el-input>
          </el-col>
        </el-col>
        <el-col :span="24" class="SchoolInformation-top">
          <el-col :span="6">上级主管部门所在地：</el-col>
          <el-col :span="5">
            <el-select v-model="value" placeholder="请选择">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-col>
          <el-col :span="5" :offset="1">
            <el-select v-model="value" placeholder="请选择">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-col>
          <el-col :span="5" :offset="1">
            <el-select v-model="value" placeholder="请选择">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-col>
        </el-col>
        <el-col :span="24" class="SchoolInformation-top">
          <el-col :span="4">上级主管部门：</el-col>
          <el-col :span="20">
            <el-input></el-input>
          </el-col>
        </el-col>
        <el-col :span="24" class="SchoolInformation-top">
          <el-col :span="3">学校类型：</el-col>
          <el-col :span="21">
            <el-radio class="radio" v-model="radio" label="1">公办</el-radio>
            <el-radio class="radio" v-model="radio" label="2">民办</el-radio>
          </el-col>
        </el-col>
        <el-col :span="24">
          <el-button type="primary" class="SchoolInformation-btn">提交</el-button>
        </el-col>
      </el-col>
    </el-row>
  </div>
</template>
<script>
    export default{
        data(){
            return{
              radio:'1',
              options: [{
                value: '1',
                label: '1'
              }],
              value: ''
            }
        },
      created(){

      },
      methods:{

      }
    }
</script>
<style lang="less">
  .SchoolInformation{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .SchoolInformation-box{
    margin-top:1rem;
  }
  .SchoolInformation-top{
    margin-top: 1.3rem;
  }
  .UpLoad-head{
    height: 200/16rem;
    width: 200/16rem;
    border: 1px solid #DFDFDF;
  }
  .SchoolInformation-upload{
    font-size: 0.875rem;
    color: #999999;
  }
  .SchoolInformation-upload-1{
    margin: 1rem 0 2rem 0;
  }
  .SchoolInformation-upload-2{
    color: #4DA1FF;
    cursor: pointer;
  }
  .SchoolInformation-btn{
    width: 100%;
    margin: 4rem 0 3rem 0;
  }
</style>
