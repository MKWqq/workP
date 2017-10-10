<template>
  <div class="familyReport">
    <el-row type="flex" align="middle">
      <el-col :span="14">
        <h3>学生成长记录</h3>
      </el-col>
      <el-col :span="10">
        <el-row type="flex" justify="end" class="reportOperation">
          <el-button @click="preview('data')">预览</el-button>
          <el-button type="primary" @click="save">保存</el-button>
        </el-row>
      </el-col>
    </el-row>
    <el-row :gutter="20" class="familyReport_row">
      <el-col :span="4">
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
              :props="defaultProps"
              @node-click="choosePerson">
            </el-tree>
          </el-row>
        </el-row>
      </el-col>
      <el-col :span="20">
        <el-row class="treeList">
          <el-row type="flex" align="middle" class="secHeader">
            <h5>家庭报告书模板</h5>
          </el-row>
          <el-row class="familyReport_content">
            <el-form ref="familyReportForm" :model="form" label-width="90px">
              <el-form-item label="固定内容：" class="editorContent">
                <Vueditor ref="vueditor"></Vueditor>
              </el-form-item>
              <el-form-item label="成绩：">
                <el-select v-model="form.scores" placeholder="请选择考试成绩" style="width: 31.25rem">
                  <el-option label="区域一" value="shanghai"></el-option>
                  <el-option label="区域二" value="beijing"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item>
                <el-checkbox-group v-model="form.checkList">
                  <el-checkbox label="1">加入最后一次期末评语</el-checkbox>
                  <el-checkbox label="2">显示家长栏意见</el-checkbox>
                </el-checkbox-group>
              </el-form-item>
            </el-form>
          </el-row>
        </el-row>
      </el-col>
    </el-row>
    <el-dialog
      title="家庭报考书-预览数据"
      :modal="false"
      size="large"
      :visible.sync="dialogVisible"
      :before-close="handleClose">
      <el-row class="reportTemplate">
        <el-table
          :data="tableData"
          style="width: 100%">
          <el-table-column
            label="班级">
            <template scope="scope">
              <input type="text" v-model="scope.row.date" />
            </template>
          </el-table-column>
          <el-table-column
            label="姓名">
            <template scope="scope">
              <input type="text" v-model="scope.row.name" />
            </template>
          </el-table-column>
          <el-table-column
            label="语文">
            <template scope="scope">
              <input type="text" v-model="scope.row.address" />
            </template>
          </el-table-column>
          <el-table-column
            label="评语">
            <template scope="scope">
              <textarea name="" v-model="scope.row.address"></textarea>
            </template>
          </el-table-column>
        </el-table>
      </el-row>
      <span slot="footer" class="dialog-footer">
    <el-button type="primary" @click="preview('report')">预览</el-button>
    <el-button @click="dialogVisible = false">关闭</el-button>
  </span>
    </el-dialog>
  </div>
</template>
<script>
  //vueditor编辑器
  import Vue from 'vue'
  import Vuex from 'vuex'
  import Vueditor from 'vueditor'
  import 'vueditor/dist/style/vueditor.min.css'
  import config from '@/components/vueditor/config'
  //导出word
  import '../../../../../static/jQueryExportWord/FileSaver'
  import '../../../../../static/jQueryExportWord/jquery.wordexport'

  import req from '@/assets/js/common'

  Vue.use(Vuex);
  Vue.use(Vueditor, config);
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
        treeActiveData: {},
        defaultProps: {
          children: 'children',
          label: 'label'
        },
        filterText: '',
        form:{
            scores:'',
          content:'',
          checkList:[]
        },
        dialogVisible: false,
        tableData: [{
          date: '2016-05-02',
          name: '王小虎',
          address: '上海市普陀区金沙江路 1518 弄'
        }, {
          date: '2016-05-04',
          name: '王小虎',
          address: '上海市普陀区金沙江路 1517 弄'
        }, {
          date: '2016-05-01',
          name: '王小虎',
          address: '上海市普陀区金沙江路 1519 弄'
        }, {
          date: '2016-05-03',
          name: '王小虎',
          address: '上海市普陀区金沙江路 1516 弄'
        }]
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
      choosePerson(data){
        console.log(data);
        if (!data.children) {
          this.treeActiveData = data;
        }
      },
      save(){
        var inst=this.$refs.vueditor.getContent();
        this.form.content=inst;
        console.log(this.form);
      },
      preview(type){
          if(type=='data'){   //预览数据
            this.dialogVisible=true;
          }else{   //预览报告
            this.dialogVisible=false;
          }
      },
      handleClose(done) {
        done();
      }
    }
  }
</script>
<style>
  .familyReport {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .familyReport h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
  }

  .familyReport .familyReport_row {
    margin-top: 3rem;
  }

  .familyReport .treeList {
    border: 1px solid #d2d2d2;
    border-radius: 5px;
    height: 52.25rem;
  }

  .familyReport .treeList_body {
    padding: .875rem;
  }

  .familyReport .treeList_title {
    padding: .875rem .875rem 1.5rem;
  }
  .familyReport .reportOperation .el-button{
    padding:.625rem 2rem;
  }
  .familyReport h5 {
    font-size: 1rem;
  }

  .familyReport .treeList .treeInput {
    margin: .875rem 0 0;
  }

  .familyReport .treeList .el-tree {
    border: none;
  }

  .familyReport .el-input-group--prepend .el-input__inner {
    border-radius: 20px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }

  .familyReport .el-input-group__prepend {
    border-radius: 20px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }

  .familyReport .secHeader {
    height: 3.125rem;
    padding: 0 1rem;
    border-bottom: 1px solid #d2d2d2;
  }
  .familyReport .familyReport_content{
    padding:3rem 3rem 1rem 1rem;
  }
  .familyReport .editorContent .el-form-item__content{
    line-height:1;
    height:20rem;
    border-radius: 5px;
    border: 1px solid #d2d2d2;
  }
  .familyReport .reportTemplate input,.familyReport .reportTemplate textarea{
    width:100%;
    border:none;
    text-align: center;
    font-family:inherit;
    font-size:.875rem;
  }
  .familyReport .reportTemplate textarea{
    resize: none;
  }
  .familyReport .el-table th{
    text-align: center;
  }
</style>
