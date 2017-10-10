<template>
    <div class="inSchoolProve">
      <h3>在读证明</h3>
      <el-row :gutter="20" class="inSchoolProve_row">
        <el-col :span="7">
          <el-row class="treeList">
            <el-row class="treeList_title">
              <el-row>
                <h5>选择学生：</h5>
              </el-row>
              <el-row class="treeInput">
                <el-input
                  placeholder="输入关键字进行过滤"
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
          <el-row type="flex" align="middle" class="prove_header">
            <el-col :span="12">在读证明</el-col>
            <el-col :span="12" class="preview">
              <el-button type="primary" icon="search">预览</el-button>
            </el-col>
          </el-row>
          <el-row class="d_line"></el-row>
          <el-row type="flex" justify="center" class="prove_body">
            <el-col :span="16">
              <h6>在读证明</h6>
              <el-row class="prove_text">
                <el-row>
                  <el-row>
                    <input type="text" placeholder="姓名" class="centry" />，<input type="text" placeholder="女" class="centry" />，出身于<input type="text" placeholder="yyyy-mm-dd" class="centry" />，
                    是我校<input type="text" placeholder="年级" class="centry" /> <input type="text" placeholder="班级" class="centry" />的学生。
                  </el-row>
                  <el-row>
                    特此证明。
                  </el-row>
                </el-row>
                <el-row class="signed">
                  <el-row>
                    <input type="text" placeholder="学校名称" class="right" />
                  </el-row>
                  <el-row>
                    <input type="text" placeholder="2017年9月11日" class="right" />
                  </el-row>
                </el-row>
              </el-row>
              <h6>Current Study Certificate</h6>
              <el-row class="prove_text">
                <el-row>
                  This is to certify that <input type="text" placeholder="name" class="centry" />，<input type="text" placeholder="Female" class="centry" />，born on <input type="text" placeholder="yyyy-mm-dd" class="centry" />，
                  is a student in Class<input type="text" placeholder="class" class="centry" />，Grade <input type="text" placeholder="grade" class="centry" /> in our school .
                </el-row>
                <el-row class="signed">
                  <el-row>
                    <input type="text" placeholder="School name" class="right" />
                  </el-row>
                  <el-row>
                    <input type="text" placeholder="9/11/2017" class="right" />
                  </el-row>
                </el-row>
              </el-row>
            </el-col>
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
              filterText: '',
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
          chooseStudent(node,state,child){
            console.log(node);
          }
        }
    }
</script>
<style>
  .inSchoolProve {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .inSchoolProve h3 {
    font-size: 1.25rem;
  }
  .inSchoolProve .inSchoolProve_row{
    margin:2rem 0;
  }
  .inSchoolProve .treeList{
    border: 1px solid #d2d2d2;
    border-radius: 5px;
    height:52.25rem;
    -webkit-box-shadow: 0 0 1px 1px #d2d2d2 inset;
    -moz-box-shadow: 0 0 1px 1px #d2d2d2 inset;
    box-shadow: 0 0 1px 1px #d2d2d2 inset;
  }
  .inSchoolProve .treeList_body{
    padding:.875rem;
  }
  .inSchoolProve .treeList_title{
    padding:.875rem .875rem 1.5rem;
  }
  .inSchoolProve .treeList_title h5{
    font-size:1rem;
  }
  .inSchoolProve .treeList .treeInput{
    margin:.875rem 0 0;
  }
  .inSchoolProve .treeList .el-tree{
    border:none;
  }
  .inSchoolProve .el-input-group--prepend .el-input__inner{
    border-radius: 20px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }
  .inSchoolProve .el-input-group__prepend{
    border-radius: 20px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }
  .inSchoolProve .prove_header{
    padding:0 2.5rem;
    margin-bottom: 1rem;
  }
  .inSchoolProve .preview{
    text-align: right;
  }
  .inSchoolProve .preview .el-button{
    padding:10px 25px;
    border-radius: 20px;
  }
  .inSchoolProve .prove_body h6{
    font-size:1.125rem;
    text-align: center;
    margin:3.5rem 0;
  }
  .inSchoolProve .prove_text{
    line-height:2.5;
  }
  .inSchoolProve .prove_text input{
    border-left:0;
    border-right:0;
    border-top:0;
    border-bottom:1px solid #4da1ff;
    font-size:1rem;
  }
  .inSchoolProve .prove_text input.centry{
     text-align: center;
   }
  .inSchoolProve .prove_text input.right,.inSchoolProve .signed{
    text-align: right;
  }
  .inSchoolProve .signed{
    margin-top:2rem;
  }
</style>
