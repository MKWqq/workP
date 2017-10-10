<template>
  <div class="scoreDetails">
    <el-row type="flex" align="middle" class="subClassDivision_title">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <span class="breadcrumb"><router-link
        to="/subClassDivisionHome/aggregateScoreCount"
        tag="span">成绩汇总</router-link><span>|</span><span class="breadcrumb_active">成绩明细</span></span>
    </el-row>
    <el-row>
      <el-form :inline="true" :model="selectParam" class="searchConditions">
        <el-form-item label="科类：">
          <el-select v-model="selectParam.subject" placeholder="请选择" class="subject">
            <el-option label="文科" value="shanghai"></el-option>
            <el-option label="文科" value="beijing"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="专业：">
          <el-select v-model="selectParam.major" placeholder="请选择" class="major">
            <el-option label="全部专业" value="shanghai"></el-option>
            <el-option label="全部专业" value="beijing"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" icon="search" @click="onSubmit">查询</el-button>
        </el-form-item>
      </el-form>
    </el-row>
    <el-row class="d_line"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
      <el-col :span="18">
        <el-button-group>
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
      <el-col :span="6">
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
        border
        @sort-change="sort"
      >
        <el-table-column
          prop="type"
          label="年级" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="班级" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="姓名" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="总分" sortable>
        </el-table-column>
        <el-table-column label="八年级考试">
          <el-table-column
            prop="name"
            label="语文" sortable>
          </el-table-column>
          <el-table-column
            prop="name"
            label="数学" sortable>
          </el-table-column>
          <el-table-column
            prop="name"
            label="数学" sortable>
          </el-table-column>
          <el-table-column
            prop="name"
            label="数学" sortable>
          </el-table-column>
          <el-table-column
            prop="name"
            label="数学" sortable>
          </el-table-column>
          <el-table-column
            prop="name"
            label="数学" sortable>
          </el-table-column>
        </el-table-column>
      </el-table>
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
        searchValue: '',
        currentPage: 1,
        pageALl: 100,
        selectParam: {
          subject: '',
          maior: ''
        }
      }
    },
    methods: {
      returnFlowchart(){
        this.$router.push('/subClassDivisionHome');
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
      onSubmit() {
        console.log('submit!');
      }
    }
  }
</script>
<style>
  .scoreDetails .el-table--border td {
    border-right: 0;
  }
  .scoreDetails .el-select.subject{
    width:8.25rem;
  }
  .scoreDetails .el-select.major{
    width:10.75rem;
  }
  .scoreDetails .searchConditions .el-button{
    border-radius: 20px;
    padding:10px 30px;
  }
  .scoreDetails .el-form--inline .el-form-item{
    margin-right:2rem;
  }
</style>
