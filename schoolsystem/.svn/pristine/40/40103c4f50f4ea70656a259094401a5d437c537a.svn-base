<template>
  <div class="proctorArrangementArts">
    <el-row>
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <span class="breadcrumb"><span class="breadcrumb_active">文科</span><span>|</span><router-link to="/examManagerHome/proctorArrangementScience"
                                                                                                   tag="span">理科</router-link></span>
    </el-row>
    <el-row class="examManager_row">
      <el-form :inline="true" class="formInline">
        <el-form-item label="监考安排规则：">
          <el-select v-model="proctorRule" placeholder="请选择" class="proctor_rules">
            <el-option
              v-for="(item,index) in proctorRules"
              :key="item.value"
              :label="item.label"
              :value="index">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" icon="search" class="select" @click="select">查询</el-button>
        </el-form-item>
      </el-form>
    </el-row>
    <el-row class="d_line"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
      <el-col :span="18">
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
          prop="title"
          label="序号" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="考场" sortable>
        </el-table-column>
        <el-table-column
          label="2017-09-11（星期三）">
          <el-table-column
            prop="publisher"
            label="语文（08:00-10:00）">
          </el-table-column>
          <el-table-column
            prop="publisher"
            label="文综（08:00-10:00）">
          </el-table-column>
          <el-table-column
            prop="publisher"
            label="数学（08:00-10:00）">
          </el-table-column>
        </el-table-column>
        <el-table-column
          label="2017-09-11（星期三）">
          <el-table-column
            prop="publisher"
            label="语文（08:00-10:00）">
          </el-table-column>
          <el-table-column
            prop="publisher"
            label="文综（08:00-10:00）">
          </el-table-column>
          <el-table-column
            prop="publisher"
            label="数学（08:00-10:00）">
          </el-table-column>
        </el-table-column>
      </el-table>
    </el-row>
    <el-row class="pageAlerts">
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
  export default{
    data(){
      return {
        proctorRules: [{
          value: '选项1',
          label: '省考号'
        }, {
          value: '选项2',
          label: '市考号'
        }, {
          value: '选项2',
          label: '校考号'
        }],
        proctorRule: '',
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
        pageALl: 100
      }
    },
    methods: {
      returnFlowchart(){
        this.$router.push('/examManagerHome');
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
      select(){
        console.log(this.proctorRule);
      }
    }
  }
</script>
<style>
  .proctorArrangementArts .el-button.select{
    padding:10px 25px;
  }
  .proctorArrangementArts .proctor_rules{
    width:16rem;
  }
  .proctorArrangementArts .el-table--border td{
    border-right:none;
  }
</style>
