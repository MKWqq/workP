<template>
    <div class="scoresProve">
      <h3>成绩证明</h3>
      <el-row :gutter="20" class="scoresProve_row">
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
            <span>考试：</span>
            <el-select v-model="value" placeholder="请选择" @change="changeData">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
            <el-button type="primary" icon="search" class="select">查询</el-button>
          </el-row>
          <el-row class="d_line"></el-row>
          <el-row class="prove_body">
            <el-row type="flex" align="middle" class="alertsBtn">
              <el-col :span="12">
                  <el-button class="delete" title="导出" @click="exportFile">
                    <img class="delete_unactive"
                         src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
                         alt="">
                    <img class="delete_active"
                         src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
                         alt="">
                  </el-button>
                <el-button-group class="secBtn-group">
                  <el-button class="filt" title="复制">
                    <img class="filt_unactive"
                         src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png"
                         alt="">
                    <img class="filt_active"
                         src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png"
                         alt="">
                  </el-button>
                  <el-button class="delete" title="打印">
                    <img class="delete_unactive"
                         src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png"
                         alt="">
                    <img class="delete_active"
                         src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png"
                         alt="">
                  </el-button>
                </el-button-group>
              </el-col>
              <el-col :span="12">
                <div class="g-fuzzyInput">
                  <el-input
                    placeholder="请输入任教科目/姓名"
                    icon="search"
                    v-model="selectParam.value"
                    :on-icon-click="goSearch">
                  </el-input>
                </div>
              </el-col>
            </el-row>
            <el-row class="alertsList">
              <el-table
                :data="tableData"
                style="width: 100%"
              >
                <el-table-column
                  prop="title"
                  width="100"
                  label="考试">
                </el-table-column>
                <el-table-column
                  prop="title"
                  width="300"
                  label="2016级高一下学期期末考试（监考）">
                </el-table-column>
                <el-table-column
                  prop="title"
                  width="300"
                  label="2016级高一下学期期末考试（成绩）">
                </el-table-column>
                <el-table-column
                  prop="title"
                  width="150"
                  label="生成排位">
                </el-table-column>
                <el-table-column
                  prop="title"
                  width="350"
                  label="七年级2016-2017第二学期期末考试（监考）">
                </el-table-column>
              </el-table>
            </el-row>
            <!--<el-row class="pageAlerts" v-if="tableData.length!=0">
              <el-pagination
                @current-change="handleCurrentChange"
                :current-page.sync="selectParam.page"
                layout="prev, pager, next, jumper"
                :total="totalNum">
              </el-pagination>
            </el-row>-->
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
              tableData: [{
                id: 1,
                title: '今天天气不错啊',
                type: '通知',
                publisher: '超级管理员',
                publishPart: 'hjshf',
                date: '2016-05-03 16:16:55',
                vState: '已查阅',
                checked: false,
                tags: [{
                  name: '语文'
                }, {
                  name: '数学'
                }]
              }, {
                id: 2,
                title: '下雨了',
                type: '通知',
                publisher: 'wy',
                publishPart: 'hjshf',
                date: '2016-05-03 16:16:55',
                vState: '未查阅',
                checked: false
              }, {
                id: 3,
                title: '那是',
                type: '通知',
                publisher: '超级管理员',
                publishPart: 'hjshf',
                date: '2016-05-03 16:16:55',
                vState: '已查阅',
                checked: false
              }],
              options: [{
                value: '选项1',
                label: '黄金糕'
              }, {
                value: '选项2',
                label: '双皮奶'
              }, {
                value: '选项3',
                label: '蚵仔煎'
              }, {
                value: '选项4',
                label: '龙须面'
              }, {
                value: '选项5',
                label: '北京烤鸭'
              }],
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
              options: [{
                value: '选项1',
                label: '黄金糕'
              }, {
                value: '选项2',
                label: '双皮奶'
              }, {
                value: '选项3',
                label: '蚵仔煎'
              }, {
                value: '选项4',
                label: '龙须面'
              }, {
                value: '选项5',
                label: '北京烤鸭'
              }],
              value: '',
              selectParam: {
                page: 1,
                pageSize: 10,
                sort: '',
                sortType: '',
                value: ''
              }
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
          },
          changeData(){
            console.log(this.value);
          },
          goSearch() {  //查询
            this.selectParam.page = 1;
            this.selectParam.sortType = '';
            this.selectParam.sort = '';
          },
          exportFile(){

          },
          handleCurrentChange(val) {
            this.selectParam.page = val;
          }
        }
    }
</script>
<style>
  .scoresProve {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .scoresProve h3 {
    font-size: 1.25rem;
  }
  .scoresProve .scoresProve_row{
    margin:2rem 0;
  }
  .scoresProve .treeList{
    border: 1px solid #d2d2d2;
    border-radius: 5px;
    height:52.25rem;
    -webkit-box-shadow: 0 0 1px 1px #d2d2d2 inset;
    -moz-box-shadow: 0 0 1px 1px #d2d2d2 inset;
    box-shadow: 0 0 1px 1px #d2d2d2 inset;
  }
  .scoresProve .treeList_body{
    padding:.875rem;
  }
  .scoresProve .treeList_title{
    padding:.875rem .875rem 1.5rem;
  }
  .scoresProve .treeList_title h5{
    font-size:1rem;
  }
  .scoresProve .treeList .treeInput{
    margin:.875rem 0 0;
  }
  .scoresProve .treeList .el-tree{
    border:none;
  }
  .scoresProve .el-input-group--prepend .el-input__inner{
    border-radius: 20px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }
  .scoresProve .el-input-group__prepend{
    border-radius: 20px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }
  .scoresProve .prove_header{
    margin-bottom: 1.25rem;
    font-size:14px;
  }
  .scoresProve .prove_header .el-select{
    width:21.25rem;
  }
  .scoresProve .el-button.select{
    padding:10px 25px;
    border-radius: 20px;
    margin-left:2rem;
  }
  .scoresProve .g-fuzzyInput{
    float: right;
  }
  .scoresProve .el-table td,.scoresProve .el-table th{
    text-align: center;
  }
  .scoresProve .alertsBtn{
    margin:1.25rem 0;
  }
</style>
