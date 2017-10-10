<template>
  <div class="classGradeDirector">
    <h3>班/年级主任</h3>
    <el-row :gutter="60">
      <el-col :span="10">
        <el-row class="classGradeDirector_row">
          <el-form :inline="true">
            <el-form-item label="年级：">
              <el-select v-model="testNumber" placeholder="请选择" class="grade">
                <el-option
                  v-for="item in testNumbers"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" icon="search" class="search">查询</el-button>
            </el-form-item>
          </el-form>
        </el-row>
        <el-row>
          <el-row class="alertsList">
            <el-table
              :data="tableData"
              style="width: 100%"
            >
              <el-table-column
                prop="title"
                label="年级/班级">
              </el-table-column>
              <el-table-column
                label="年级主任/班主任">
                <template scope="scope">
                  <div class="teacherName" :class="{'edit':scope.row.checked}" @click="edit(scope.$index)">
                    {{scope.row.type}}
                  </div>
                </template>
              </el-table-column>
            </el-table>
          </el-row>
        </el-row>
      </el-col>
      <el-col :span="14">
        <el-row type="flex" align="middle" class="classGradeDirector_row teacherTip">
          操作方式：先点击须填入班主任的单元格，再选择右侧表格中的教师姓名。
        </el-row>
        <el-row type="flex" align="middle" class="teacherHeader">
          <el-col :span="10">
            <el-button type="primary" class="teacherTitle" @click="openList">班主任、年级主任一览表</el-button>
          </el-col>
          <el-col :span="14">
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
        <el-row class="teacherList">
          <el-table
            :data="tableData"
            style="width: 100%"
            border
            @sort-change="sort"
          >
            <el-table-column
              type="index"
              width="120"
              label="序号">
            </el-table-column>
            <el-table-column
              prop="type"
              label="工号" sortable>
            </el-table-column>
            <el-table-column
              label="姓名" sortable>
              <template scope="scope">
                <span class="setName" @click="setTeacherName(scope.row.publisher)">{{scope.row.publisher}}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="publisher"
              label="联系电话" sortable>
            </el-table-column>
          </el-table>
        </el-row>
      </el-col>
    </el-row>
    <el-row class="createBtn">
      <el-button>清空</el-button>
      <el-button type="primary" @click="save">保存</el-button>
    </el-row>
    <el-dialog
      title="班级主任、年级主任一览表"
      :visible.sync="dialogVisible"
      :modal="false"
      :before-close="handleClose">
      <el-row>
        <el-row type="flex" align="middle" class="alertsBtn">
          <el-button class="delete" title="导出">
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
        </el-row>
        <el-row class="teacherList">
          <el-table
            :data="tableData"
            border
            style="width: 100%"
          >
            <el-table-column
              label="六年级">
              <el-table-column
                prop="title"
                label="名称">
              </el-table-column>
              <el-table-column
                prop="title"
                label="班主任">
              </el-table-column>
            </el-table-column>
            <el-table-column
              label="七年级">
              <el-table-column
                prop="type"
                label="名称">
              </el-table-column>
              <el-table-column
                prop="type"
                label="班主任">
              </el-table-column>
            </el-table-column>
            <el-table-column
              label="八年级">
              <el-table-column
                prop="title"
                label="名称">
              </el-table-column>
              <el-table-column
                prop="title"
                label="班主任">
              </el-table-column>
            </el-table-column>
            <el-table-column
              label="九年级">
              <el-table-column
                prop="type"
                label="名称">
              </el-table-column>
              <el-table-column
                prop="type"
                label="班主任">
              </el-table-column>
            </el-table-column>
          </el-table>
        </el-row>
      </el-row>
    </el-dialog>
  </div>
</template>
<script>
  export default{
    data(){
      return {
        testNumbers: [{
          value: '选项1',
          label: '本次考试'
        }, {
          value: '选项2',
          label: '省考号'
        }, {
          value: '选项2',
          label: '市考号'
        }, {
          value: '选项2',
          label: '校考号'
        }],
        testNumber: '',
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
        }],
        searchValue: '',
        actIdx: '',
        dialogVisible: false
      }
    },
    methods: {
      goSearch(ev) {  //查询
        console.log(ev);
      },
      sort(column){
        console.log(column);
      },
      openList(){
        this.dialogVisible = true;
      },
      handleClose(done) {
        done();
      },
      save(){
        this.dialogVisible = false;
      },
      edit(idx){
        for (let obj of this.tableData) {
          obj.checked = false;
        }
        this.tableData[idx].checked = true;
        this.actIdx = idx;
      },
      setTeacherName(name){
        if (typeof this.actIdx!='string') {
          this.tableData[this.actIdx].type = name;
        }
      }
    }
  }
</script>
<style>
  .classGradeDirector {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .classGradeDirector h3 {
    font-size: 1.25rem;
  }

  .classGradeDirector .classGradeDirector_row {
    margin: 1.25rem 0;
  }

  .classGradeDirector .el-form--inline .el-form-item {
    margin-bottom: 0;
  }

  .classGradeDirector .el-table td, .classGradeDirector .el-table th {
    text-align: center;
  }

  .classGradeDirector .grade {
    width: 8.75rem;
  }

  .classGradeDirector .createBtn {
    text-align: right;
  }

  .classGradeDirector .search {
    padding: 10px 25px;
    border-radius: 20px;
  }

  .classGradeDirector .createBtn .el-button {
    padding: 10px 30px;
    border-radius: 20px;
  }

  .classGradeDirector .el-form--inline .el-form-item {
    margin-right: 2rem;
  }

  .classGradeDirector .el-dialog--small {
    width: 1000px;
  }

  .classGradeDirector .teacherList {
    min-height: 35rem;
  }

  .classGradeDirector .teacherList thead th {
    background-color: #fff;
    height: 3rem;
  }

  .classGradeDirector .teacherList thead > tr:first-child th {
    background-color: #deeefe;
  }

  .classGradeDirector .teacherList .el-table td {
    height: 3rem;
    font-size: .875rem;
  }

  .classGradeDirector .teacherList .el-table__footer-wrapper thead div, .classGradeDirector .teacherList .el-table__header-wrapper thead div {
    background-color: #fff;
  }

  .classGradeDirector .teacherList .el-table__footer-wrapper thead > tr:first-child div, .classGradeDirector .teacherList .el-table__header-wrapper thead > tr:first-child div {
    background-color: #deeefe;
  }

  .classGradeDirector .teacherTip {
    height: 36px;
    font-size: .875rem;
  }

  .classGradeDirector .teacherHeader {
    height: 3.5rem;
    background-color: #89bcf5;
    padding: 0 1.25rem;
  }

  .classGradeDirector .el-button.teacherTitle {
    background-color: #ff8686;
    color: #fff;
    border: 1px solid #fff;
    border-radius: 30px;
    padding: .5rem 1.5rem;
    font-size: .875rem;
  }

  .classGradeDirector .g-fuzzyInput {
    float: right;
  }

  .classGradeDirector .alertsBtn {
    margin: 0 0 1.25rem 0;
  }

  .classGradeDirector .edit {
    color: #4da1ff;
    border: 1px solid #4da1ff;
  }

  .classGradeDirector .setName {
    cursor: pointer;
  }
</style>
