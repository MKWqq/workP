<template>
  <div class="classTeacherSet">
    <h3>任课教师设置</h3>
    <el-row :gutter="60">
      <el-col :span="10">
        <el-row class="classTeacher_row">
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
            <el-form-item label="班级：">
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
                label="科目">
              </el-table-column>
              <el-table-column
                label="任课教师">
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
        <el-row type="flex" align="middle" class="classTeacher_row teacherTip">
          操作方式：先点击须填入任课教师的单元格，再选择右侧表格中的教师姓名。
        </el-row>
        <el-row type="flex" align="middle" class="teacherHeader">
          <el-col :span="10">
            <el-button type="primary" class="teacherTitle" @click="openList">任课教师一览表</el-button>
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
              label="科目" sortable>
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
      title="任课教师一览表"
      :visible.sync="dialogVisible"
      :modal="false"
      :before-close="handleClose">
      <el-row>
        <el-row type="flex" align="middle" class="alertsBtn">
          <el-col :span="16">
            <el-button class="delete" title="导出">
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
          <el-col :span="8" class="dialogGradeBox">
            <span>年级：</span>
            <el-select v-model="value" placeholder="请选择" class="dialogGrade">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-col>
        </el-row>
        <el-row class="teacherList">
          <el-table
            :data="tableData"
            border
            style="width: 100%"
          >
            <el-table-column
              prop="title"
              label="名称">
            </el-table-column>
            <el-table-column
              prop="type"
              label="班主任">
            </el-table-column>
            <el-table-column
              prop="title"
              label="语文">
            </el-table-column>
            <el-table-column
              prop="type"
              label="数学">
            </el-table-column>
            <el-table-column
              prop="type"
              label="英语">
            </el-table-column>
            <el-table-column
              prop="type"
              label="科学">
            </el-table-column>
            <el-table-column
              prop="type"
              label="思品">
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
        dialogVisible: false,
        actIdx: '',
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
        value: ''
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
        if (typeof this.actIdx != 'string') {
          this.tableData[this.actIdx].type = name;
        }
      }
    }
  }
</script>
<style>
</style>
