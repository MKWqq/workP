<template>
  <div class="generationLeave">
    <el-row type="flex" align="middle" class="subClassDivision_title">
      <h3>代学生请假</h3>
    </el-row>
    <el-row :gutter="70" class="generationLeave_body">
      <el-col :span="7">
        <el-row class="treeList">
          <el-row class="treeList_title">
            <el-row>
              <h5>待选学生</h5>
            </el-row>
            <el-row class="treeInput">
              <el-input
                placeholder="请输入查询班级或姓名"
                v-model="filterText">
                <template slot="prepend">
                  <i class="el-icon-search"></i>
                </template>
              </el-input>
            </el-row>
          </el-row>
          <el-row class="d_line"></el-row>
          <el-row class="treeList_body">
            <el-tree
              :data="treeData"
              node-key="id"
              ref="tree"
              :filter-node-method="filterNode"
              @node-click="chooseStudent"
              :props="defaultProps">
            </el-tree>
          </el-row>
        </el-row>
      </el-col>
      <el-col :span="17">
        <el-form ref="form" :model="form" label-width="120px">
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
            <el-row>
              <el-col :span="8">
                <el-date-picker type="date" placeholder="选择时间" v-model="form.startTime"
                                style="width: 100%;"></el-date-picker>
              </el-col>
              <el-col class="line" :span="1">-</el-col>
              <el-col :span="8">
                <el-time-picker type="fixed-time" placeholder="选择时间" v-model="form.endTime"
                                style="width: 100%;"></el-time-picker>
              </el-col>
            </el-row>
          </el-form-item>
          <el-form-item label="结束时间：">
            <el-row>
              <el-col :span="8">
                <el-date-picker type="date" placeholder="选择时间" v-model="form.startTime"
                                style="width: 100%;"></el-date-picker>
              </el-col>
              <el-col class="line" :span="1">-</el-col>
              <el-col :span="8">
                <el-time-picker type="fixed-time" placeholder="选择时间" v-model="form.endTime"
                                style="width: 100%;"></el-time-picker>
              </el-col>
            </el-row>
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
            <el-button type="primary" @click="save">提交</el-button>
            <el-button>重置</el-button>
          </el-form-item>
        </el-form>
      </el-col>
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
        leaveReasonActiveList:[],
        treeData: [{
          id: 1,
          label: '一级 1',
          children: [{
            id: 4,
            label: '二级 1-1',
            children: [{
              id: 9,
              label: '三级 1-1-1'
            }, {
              id: 10,
              label: '三级 1-1-2'
            }]
          }]
        }, {
          id: 2,
          label: '一级 2',
          children: [{
            id: 5,
            label: '二级 2-1'
          }, {
            id: 6,
            label: '二级 2-2'
          }]
        }, {
          id: 3,
          label: '一级 3',
          children: [{
            id: 7,
            label: '二级 3-1'
          }, {
            id: 8,
            label: '二级 3-2'
          }]
        }],
        defaultProps: {
          children: 'children',
          label: 'label'
        },
        filterText: ''
      }
    },
    watch:{
      filterText(val) {
        this.$refs.tree.filter(val);
      }
    },
    methods: {
      filterNode(value, data) {
        if (!value) return true;
        return data.label.indexOf(value) !== -1;
      },
      chooseStudent(data, node, child){
        if(!data.children){
          console.log(data);
        }
      },
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
  .generationLeave {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .generationLeave h3 {
    font-size: 1.25rem;
  }

  .generationLeave .generationLeave_body {
    margin-top: 3.75rem;
  }
  .generationLeave .treeList{
    border: 1px solid #d2d2d2;
    border-radius: 5px;
    height:52.25rem;
    -webkit-box-shadow: 0 0 1px 1px #d2d2d2 inset;
    -moz-box-shadow: 0 0 1px 1px #d2d2d2 inset;
    box-shadow: 0 0 1px 1px #d2d2d2 inset;
  }
  .generationLeave .treeList_body{
    padding:.875rem;
  }
  .generationLeave .treeList_title{
    padding:.875rem .875rem 1.5rem;
  }
  .generationLeave .treeList_title h5{
    font-size:1rem;
  }
  .generationLeave .treeList .treeInput{
    margin:.875rem 0 0;
  }
  .generationLeave .treeList .el-tree{
    border:none;
  }
  .generationLeave .alertsBtn{
    margin:0 0 1.25rem 0;
  }
  .generationLeave .el-input-group--prepend .el-input__inner{
    border-radius: 20px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }
  .generationLeave .el-input-group__prepend{
    border-radius: 20px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }

  .generationLeave .line {
    text-align: center;
  }

  .generationLeave .submitBtn {
    text-align: right;
  }

  .generationLeave .submitBtn .el-button {
    width: 7.5rem;
    padding: 10px 0;
    border-radius: 20px;
    border: 1px solid #4da1ff;
    color: #4da1ff;
  }

  .generationLeave .submitBtn .el-button--primary {
    color: #fff;
  }
  .generationLeave .leaveReason {
    display: inline-block;
    padding: 8px 16px;
    color: #f08bc5;
    border: 1px solid #f08bc5;
    border-radius: 4px;
    cursor: pointer;
    margin-bottom:1rem;
    line-height:1;
  }

  .generationLeave .leaveReason + .leaveReason {
    margin-left: 1.25rem;
  }
  .generationLeave .leaveReasonContent{
    border:1px solid #bfcbd9;
    border-radius: 4px;
    padding:.5rem 1rem;
  }
  .generationLeave .el-textarea__inner{
    font-family:inherit;
    height:10rem;
    margin-top:.5rem;
    border: none;
  }
  .generationLeave .leaveReasonContent .el-tag{
    background-color: #f08bc5;
    padding:0px 10px;
  }
  .generationLeave .leaveReasonContent .el-tag+.el-tag{
    margin-left:1rem;
  }
</style>
