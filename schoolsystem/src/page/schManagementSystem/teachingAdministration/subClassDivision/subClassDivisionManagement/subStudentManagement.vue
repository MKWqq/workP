<template>
  <div class="subStudentManagement">
    <el-row type="flex" align="middle" class="subClassDivision_title">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <h3>分班学生管理</h3>
    </el-row>
    <el-row :gutter="20" class="subClassDivision_row">
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
              show-checkbox
              node-key="id"
              ref="tree"
              :filter-node-method="filterNode"
              @check-change="chooseStudent"
              :props="defaultProps">
            </el-tree>
          </el-row>
        </el-row>
      </el-col>
      <el-col :span="17">
        <el-row type="flex" align="middle" class="alertsBtn">
          <el-col :span="14">
            <el-button class="delete" title="导出" @click="exportFile">
              <img class="delete_unactive"
                   src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
                   alt="">
              <img class="delete_active"
                   src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
                   alt="">
            </el-button>
            <el-button-group class="secBtn-group">
              <el-button class="filt" title="复制">
                <img class="filt_unactive"
                     src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png"
                     alt="">
                <img class="filt_active"
                     src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png"
                     alt="">
              </el-button>
              <el-button class="delete" title="打印">
                <img class="delete_unactive"
                     src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png"
                     alt="">
                <img class="delete_active"
                     src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png"
                     alt="">
              </el-button>
            </el-button-group>
          </el-col>
          <el-col :span="10">
            <div class="g-fuzzyInput">
              <el-input
                placeholder="请选择日期"
                icon="search"
                v-model="searchValue"
                :on-icon-click="goSearch">
              </el-input>
            </div>
          </el-col>
        </el-row>
        <el-row class="alertsList">
          <el-table
            :data="tableData"
            style="width: 100%"
            @sort-change="sort"
          >
            <el-table-column
              type="index"
              width="100"
              label="序号">
            </el-table-column>
            <el-table-column
              prop="type"
              label="年级" sortable>
            </el-table-column>
            <el-table-column
              prop="publisher"
              label="班级" sortable>
            </el-table-column>
            <el-table-column
              prop="publisher"
              label="姓名" sortable>
            </el-table-column>
            <el-table-column
              prop="publisher"
              label="性别" sortable>
            </el-table-column>
            <el-table-column
              label="操作">
              <template scope="scope">
                <span class="edit" @click="deleteData(scope.$index)">删除</span>
              </template>
            </el-table-column>
          </el-table>
        </el-row>
        <el-row class="operationBtn">
          <el-button @click="save('clear')">清空</el-button>
          <el-button type="primary" @click="save">保存</el-button>
        </el-row>
        <el-row class="pageAlerts" v-if="tableData.length!=0">
          <el-pagination
            @current-change="handleCurrentChange"
            :current-page.sync="currentPage"
            :page-size="pageALl"
            layout="prev, pager, next, jumper"
            :total="1000">
          </el-pagination>
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
          checked: false
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
      returnFlowchart(){
        this.$router.push('/subClassDivisionHome');
      },
      filterNode(value, data) {
        if (!value) return true;
        return data.label.indexOf(value) !== -1;
      },
      exportFile(){
//            req.downloadFile('.messageManagement', '/school/user/exportTeacherOrZg?type=teacher', 'post');
      },
      goSearch(ev) {  //查询
        console.log(ev);
      },
      sort(column){
        console.log(column);
      },
      handleCurrentChange(val) {
        this.currentPage = val;
        console.log(`当前页: ${this.currentPage}`);
      },
      deleteData(idx){
        this.tableData.splice(idx, 1);
      },
      chooseStudent(node, state, child){
        console.log(state);
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
  .subStudentManagement .treeList {
    border: 1px solid #d2d2d2;
    border-radius: 5px;
    height: 52.25rem;
    -webkit-box-shadow: 0 0 1px 1px #d2d2d2 inset;
    -moz-box-shadow: 0 0 1px 1px #d2d2d2 inset;
    box-shadow: 0 0 1px 1px #d2d2d2 inset;
  }

  .subStudentManagement .treeList_body {
    padding: .875rem;
  }

  .subStudentManagement .treeList_title {
    padding: .875rem .875rem 1.5rem;
  }

  .subStudentManagement .treeList_title h5 {
    font-size: 1rem;
  }

  .subStudentManagement .treeList .treeInput {
    margin: .875rem 0 0;
  }

  .subStudentManagement .treeList .el-tree {
    border: none;
  }

  .subStudentManagement .alertsBtn {
    margin: 0 0 1.25rem 0;
  }

  .subStudentManagement .el-input-group--prepend .el-input__inner {
    border-radius: 20px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }

  .subStudentManagement .el-input-group__prepend {
    border-radius: 20px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }
</style>
