<template>
  <div class="quicklySplitclass">
    <el-row type="flex" align="middle" class="subClassDivision_title">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <h3>快速分班</h3>
    </el-row>
    <el-row class="subClassDivision_row">
      <el-form :inline="true" class="formInline">
        <el-form-item label="分班方式：">
          <el-select v-model="grade" placeholder="请选择" class="splitClassType">
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="班级序号：">
          <el-select v-model="grade" placeholder="请选择" class="classNumber">
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="性别：">
          <el-select v-model="grade" placeholder="请选择" class="sex">
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="增加班级人数：">
          <el-select v-model="grade" placeholder="请选择" class="personNumber">
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" class="scoreQuery_btn">
            <img
              src="../../../../../assets/img/schManagementSystem/teachingAdministration/studentScores/icon_search.png"
              alt="">
            <span>生成分班</span>
          </el-button>
        </el-form-item>
      </el-form>
    </el-row>
    <el-row class="subClassDivision_row">
      <el-form :inline="true" class="formInline">
        <el-form-item label="成绩优先级(数字越小,优先级越高)">
        </el-form-item>
        <el-form-item label="平行班：">
          <el-select v-model="grade" placeholder="请选择" class="personNumber">
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
        @sort-change="sort"
      >
        <el-table-column
          type="index"
          width="100"
          label="序号">
        </el-table-column>
        <el-table-column
          prop="sex"
          label="姓名" sortable>
        </el-table-column>
        <el-table-column
          prop="sex"
          label="性别" sortable>
        </el-table-column>
        <el-table-column
          prop="sex"
          label="当前年级">
        </el-table-column>
        <el-table-column
          prop="account"
          label="当前班级" sortable>
        </el-table-column>
        <el-table-column
          prop="politicalFace"
          label="当前班级序号" sortable>
        </el-table-column>
        <el-table-column
          prop="tel"
          label="拟分年级" sortable>
        </el-table-column>
        <el-table-column
          prop="tel"
          label="拟分班级" sortable>
        </el-table-column>
        <el-table-column
          prop="tel"
          label="拟分班级序号" sortable>
        </el-table-column>
        <el-table-column
          prop="tel"
          label="指定到班" sortable>
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
  .quicklySplitclass .el-button.scoreQuery_btn {
    padding: 0 15px;
    height: 30px;
    border-radius: 15px;
    font-size: .875rem;
  }

  .quicklySplitclass .splitClassType {
    width: 6.25rem;
  }

  .quicklySplitclass .classNumber, .quicklySplitclass .sex, .quicklySplitclass .personNumber {
    width: 9.375rem;
  }

  .quicklySplitclass .alertsBtn {
    margin: 1.5rem 0;
  }

  .quicklySplitclass .formInline .el-form-item {
    margin-right: 2.5rem;
    margin-bottom: 0;
  }
</style>
