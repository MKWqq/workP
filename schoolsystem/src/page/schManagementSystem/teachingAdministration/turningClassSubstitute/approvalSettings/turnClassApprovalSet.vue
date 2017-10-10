<template>
  <div class="turnClassApprovalSet">
    <h3>审批设置</h3>
    <el-row :gutter="20" class="turnClassApprovalSet_row">
      <el-col :span="17">
        <el-row class="treeList approvalPerson">
          <el-row>
            <h4>审批人</h4>
          </el-row>
          <el-row class="tagList">
            <el-tag
              :key="tag"
              v-for="tag in teacherLists"
              :closable="true"
              :close-transition="false"
              @close="handleClose(tag)"
            >
              {{tag}}
            </el-tag>
          </el-row>
          <el-row class="operationBtn">
            <el-button type="primary" class="clearBtn" @click="save('clear')">清空</el-button>
            <el-button type="primary" @click="save">保存</el-button>
          </el-row>
        </el-row>
      </el-col>
      <el-col :span="7">
        <el-row class="treeList">
          <el-row class="treeList_title">
            <el-row>
              <h5>待选教师</h5>
            </el-row>
            <el-row class="treeInput">
              <el-input
                placeholder="输入查询姓名"
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
              @node-click="chooseTeacher"
              :props="defaultProps">
            </el-tree>
          </el-row>
        </el-row>
      </el-col>
    </el-row>
  </div>
</template>
<script>
  import req from '@/assets/js/common'
  export default{
    data(){
      return {
        teacherLists: ['标签一', '标签二', '标签三'],
        searchValue: '',
        currentPage: 1,
        pageALl: 100,
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
    watch: {
      filterText(val) {
        this.$refs.tree.filter(val);
      }
    },
    methods: {
      filterNode(value, data) {
        if (!value) return true;
        return data.label.indexOf(value) !== -1;
      },
      handleClose(tag) {
        this.teacherLists.splice(this.teacherLists.indexOf(tag), 1);
      },
      chooseTeacher(data, node, event){
        if (!data.children){
          console.log(data);
        }
      },
      save(type){
        if (type == 'clear') {  //清空

        } else {   //保存

        }
      }
    }
  }
</script>
<style>
  .turnClassApprovalSet{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .turnClassApprovalSet h3{
    font-size:1.25rem;
  }
  .turnClassApprovalSet .turnClassApprovalSet_row{
    margin-top:2rem;
  }
  .turnClassApprovalSet h4{
    font-size:1.25rem;
    font-weight:normal;
    padding:.875rem 1rem;
    border-bottom:1px solid #d2d2d2;
  }
  .turnClassApprovalSet .tagList{
    padding:.75rem 1.25rem;
    height:43rem;
  }
  .turnClassApprovalSet .tagList .el-tag{
    background-color: #f08bc5;
    margin-right:1.25rem;
    margin-top:.5rem;
  }
  .turnClassApprovalSet .operationBtn{
    text-align: right;
    padding-right:2rem;
  }
  .turnClassApprovalSet .operationBtn .el-button{
    padding:10px 2.625rem;
    border-radius: 20px;
  }
  .turnClassApprovalSet .operationBtn .el-button.clearBtn{
    background: #ff8686;
    border-color: #ff8686;
  }
  .turnClassApprovalSet .treeList {
    border: 1px solid #d2d2d2;
    border-radius: 5px;
    height: 52.25rem;
  }

  .turnClassApprovalSet .treeList_body {
    padding: .875rem;
  }

  .turnClassApprovalSet .treeList_title {
    padding: .875rem;
  }

  .turnClassApprovalSet .treeList_title h5 {
    font-size: 1rem;
  }

  .turnClassApprovalSet .treeList .treeInput {
    margin: .875rem 0 0;
  }

  .turnClassApprovalSet .treeList .el-tree {
    border: none;
  }

  .turnClassApprovalSet .alertsBtn {
    margin: 0 0 1.25rem 0;
  }

  .turnClassApprovalSet .el-input-group--prepend .el-input__inner {
    border-radius: 20px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }

  .turnClassApprovalSet .el-input-group__prepend {
    border-radius: 20px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }
</style>
