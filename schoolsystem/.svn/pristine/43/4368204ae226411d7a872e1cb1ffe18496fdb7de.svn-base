<template>
  <div class="volunteerDistributionStatus">
    <el-row type="flex" align="middle" class="subClassDivision_title">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <span class="breadcrumb"><router-link
        to="/subClassDivisionHome/studentVolunteerCount"
        tag="span">志愿填报情况</router-link><span>|</span><span class="breadcrumb_active">志愿分布情况</span></span>
    </el-row>
    <el-row class="subClassDivision_row">
      <el-form :inline="true" class="formInline">
        <el-form-item label="统计类型：">
          <el-select v-model="grade" placeholder="请选择" class="countType">
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
      </el-form>
    </el-row>
    <el-row class="subClassDivision_row">
      <span>排名分段：</span>
      <span>前 <el-input class="rankData" v-model="rankData.rank"></el-input> 名</span>
      <span class="fillLeft">前 <el-input class="rankData" v-model="rankData.rank"></el-input> 名</span>
      <span class="fillLeft">前 <el-input class="rankData" v-model="rankData.rank"></el-input> 名</span>
      <span class="fillLeft">前 <el-input class="rankData" v-model="rankData.rank"></el-input> 名</span>
      <span class="fillLeft">前 <el-input class="rankData" v-model="rankData.rank"></el-input> 名</span>
      <span class="fillLeft">前 <el-input class="rankData" v-model="rankData.rank"></el-input> 名</span>
      <el-button type="primary" class="scoreQuery_btn fillLeft">
        <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/studentScores/icon_search.png"
             alt="">
        <span>查询</span>
      </el-button>
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
        @sort-change="sort"
      >
        <el-table-column
          prop="name"
          label="年级" sortable>
        </el-table-column>
        <el-table-column
          prop="sex"
          label="班级" sortable>
        </el-table-column>
        <el-table-column
          prop="sex"
          label="科目" sortable>
        </el-table-column>
        <el-table-column
          prop="sex"
          label="专业">
        </el-table-column>
        <el-table-column
          prop="account"
          label="前5名" sortable>
        </el-table-column>
        <el-table-column
          prop="politicalFace"
          label="前10名" sortable>
        </el-table-column>
        <el-table-column
          prop="tel"
          label="前20名" sortable>
        </el-table-column>
        <el-table-column
          prop="tel"
          label="前50名" sortable>
        </el-table-column>
        <el-table-column
          prop="tel"
          label="前100名" sortable>
        </el-table-column>
        <el-table-column
          prop="tel"
          label="前200名" sortable>
        </el-table-column>
        <el-table-column
          prop="tel"
          label="总计" sortable>
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
        grade: '',
        showSingleRank: true,
        filterCriteria: {
          topSeveral: '',
          lastSeveral: '',
        },
        searchValue: '',
        tableData: [{
          name: 'hhh',
          sex: '女',
          sexNum: 0,
          account: '都贵',
          part: '第三方',
          number: '发',
          politicalFace: '团员',
          tel: '1',
          checked: false
        }, {
          name: 'hhh',
          sex: '男',
          sexNum: 1,
          account: '都贵',
          part: '第三方',
          number: '发',
          politicalFace: '团员',
          tel: '1',
          checked: false
        }],
        rankData: {
          rank: ''
        },
        currentPage: 1,
        pageALl: 100
      }
    },
    methods: {
      returnFlowchart(){
        this.$router.push('/subClassDivisionHome');
      },
      goSearch(ev) {  //查询
        console.log(ev);
      },
      sort(val){
        console.log(val);
      },
      handleCurrentChange(val) {
        this.currentPage = val;
        console.log(`当前页: ${this.currentPage}`);
      }
    }
  }
</script>
<style>
  .volunteerDistributionStatus .el-button.scoreQuery_btn {
    padding: 0;
    height: 30px;
    border-radius: 15px;
    width: 100px;
    font-size: .875rem;
  }

  .volunteerDistributionStatus .countType {
    width: 16.875rem;
  }
  .volunteerDistributionStatus .alertsBtn {
    margin: 1.5rem 0;
  }
  .volunteerDistributionStatus .fillLeft {
    margin-left: 2.5rem;
  }

  .volunteerDistributionStatus .rankData {
    width: 3.75rem;
  }

  .volunteerDistributionStatus .rankData .el-input__inner {
    height: 30px;
  }

  .volunteerDistributionStatus .formInline .el-form-item {
    margin-right: 2.5rem;
    margin-bottom: 0;
  }
</style>
