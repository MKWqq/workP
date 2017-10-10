<template>
  <div class="createLeave">
    <el-row type="flex" align="middle" class="subClassDivision_title">
      <h3>新建请假</h3>
    </el-row>
    <el-row class="createLeave_body">
      <el-form ref="form" :model="form" label-width="120px" class="subMsg">
        <el-form-item label="请假标题：">
          <el-input v-model="form.name" placeholder="--的请假单"></el-input>
        </el-form-item>
        <el-form-item label="请假类型：">
          <el-select v-model="form.type" placeholder="请选择" style="width:100%;">
            <el-option
              v-for="item in leaveTypeList"
              :key="item.id"
              :label="item.name"
              :value="item.id">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="起始时间：">
          <el-col :span="8">
            <el-date-picker type="date" placeholder="选择时间" v-model="form.startTime"
                            style="width: 100%;"></el-date-picker>
          </el-col>
          <el-col class="line" :span="1">-</el-col>
          <el-col :span="8">
            <el-time-picker type="fixed-time" placeholder="选择时间" v-model="form.endTime"
                            style="width: 100%;"></el-time-picker>
          </el-col>
        </el-form-item>
        <el-form-item label="结束时间：">
          <el-col :span="8">
            <el-date-picker type="date" placeholder="选择时间" v-model="form.startTime"
                            style="width: 100%;"></el-date-picker>
          </el-col>
          <el-col class="line" :span="1">-</el-col>
          <el-col :span="8">
            <el-time-picker type="fixed-time" placeholder="选择时间" v-model="form.endTime"
                            style="width: 100%;"></el-time-picker>
          </el-col>
        </el-form-item>
        <el-form-item label="请假原因：">
          <el-row class="leaveReasonList">
            <span class="leaveReason" v-for="(leaveReason,index) in leaveReasonList"
                  :key="leaveReason.id" @click="chooseLeaveReason(index)">{{leaveReason.name}}</span>
          </el-row>
          <el-row class="leaveReasonContent">
            <el-row>
              <el-tag
                :key="leaveReason.id"
                v-for="(leaveReason,index) in leaveReasonActiveList"
                :closable="true"
                :close-transition="false"
                @close="handleClose(index)"
              >
                {{leaveReason.name}}
              </el-tag>
            </el-row>
            <el-input resize="none" type="textarea" v-model="form.desc" placeholder="请输入请假原因"></el-input>
          </el-row>
        </el-form-item>
        <el-form-item class="submitBtn">
          <el-button type="primary" @click="save">创建</el-button>
          <el-button>重置</el-button>
        </el-form-item>
      </el-form>
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
          startTime: '',
          endTime: '',
          content: '',
          type: ''
        },
        leaveTypeList:[
          {
            name: '病假',
            id: 0
          }, {
            name: '时间',
            id: 1
          }
        ],
        leaveReasonList: [
          {
            name: '病假',
            id: 0
          }, {
            name: '时间',
            id: 1
          }
        ],
        leaveReasonActiveList:[]
      }
    },
    methods: {
      chooseLeaveReason(idx){
          this.leaveReasonActiveList.push(this.leaveReasonList[idx]);
      },
      handleClose(idx) {
        this.leaveReasonActiveList.splice(idx, 1);
      },
      save(){
        console.log(self.form);
      }
    }
  }
</script>
<style>
  .createLeave {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .createLeave h3 {
    font-size: 1.25rem;
  }

  .createLeave .createLeave_body {
    margin: 3.43rem 0 10rem;
  }

  .createLeave .subMsg {
    width: 65%;
    margin: auto;
  }

  .createLeave .line {
    text-align: center;
  }

  .createLeave .submitBtn {
    text-align: right;
  }

  .createLeave .submitBtn .el-button {
    width: 7.5rem;
    padding: 10px 0;
    border-radius: 20px;
    border: 1px solid #4da1ff;
    color: #4da1ff;
  }

  .createLeave .submitBtn .el-button--primary {
    color: #fff;
  }
  .createLeave .leaveReason {
    display: inline-block;
    padding: 8px 16px;
    color: #f08bc5;
    border: 1px solid #f08bc5;
    border-radius: 4px;
    cursor: pointer;
    margin-bottom:1rem;
    line-height:1;
  }

  .createLeave .leaveReason + .leaveReason {
    margin-left: 1.25rem;
  }
  .createLeave .leaveReasonContent{
    border:1px solid #bfcbd9;
    border-radius: 4px;
    padding:.5rem 1rem;
  }
  .createLeave .el-textarea__inner{
    font-family:inherit;
    height:10rem;
    margin-top:.5rem;
    border: none;
  }
  .createLeave .leaveReasonContent .el-tag{
    background-color: #f08bc5;
    padding:0px 10px;
  }
  .createLeave .leaveReasonContent .el-tag+.el-tag{
    margin-left:1rem;
  }
</style>
