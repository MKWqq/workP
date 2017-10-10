<template>
  <div class="totalCount">
    <h3>均分总表</h3>
    <el-row class="scoreRow scoreRowOne">
      <el-form :inline="true" class="formInline">
        <el-form-item label="年级：">
          <el-select v-model="grade" placeholder="请选择" class="grade">
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="科类：">
          <el-select v-model="grade" placeholder="请选择" class="l_class">
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="考试：">
          <el-select v-model="grade" placeholder="请选择" class="test">
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="显示均分名次：">
          <el-switch
            v-model="showSingleRank"
            on-text="是"
            off-text="否"
            on-color="#13ce66"
            off-color="#ff4949">
          </el-switch>
        </el-form-item>
      </el-form>
    </el-row>
    <el-row class="scoreRow scoreQuery_btn">
      <el-button type="primary">
        <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/studentScores/icon_search.png" alt="">
        <span>查询</span>
      </el-button>
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
          prop="sex"
          label="班级" sortable>
        </el-table-column>
        <el-table-column
          prop="sex"
          label="总分" sortable>
        </el-table-column>
        <el-table-column
          prop="sex"
          label="语文">
        </el-table-column>
        <el-table-column
          prop="account"
          label="数学" sortable>
        </el-table-column>
        <el-table-column
          prop="politicalFace"
          label="英语" sortable>
        </el-table-column>
        <el-table-column
          prop="tel"
          label="物理" sortable>
        </el-table-column>
        <el-table-column
          prop="tel"
          label="化学" sortable>
        </el-table-column>
        <el-table-column
          prop="tel"
          label="生物" sortable>
        </el-table-column>
        <el-table-column
          prop="tel"
          label="班主任" sortable>
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
        showSingleRank:true,
        filterCriteria:{
          topSeveral:'',
          lastSeveral:'',
        },
        searchValue:'',
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
  .totalCount {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
    font-size: 14px;
  }

  .totalCount h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
  }
  .totalCount .scoreRow{
    margin:1.125rem 0;
  }
  .totalCount .scoreRowOne{
    margin:2rem 0 1.125rem;
  }
  .totalCount .el-table td, .totalCount .el-table th {
    text-align: center;
  }
  .totalCount .g-fuzzyInput{
    float: right;
  }
  .totalCount .d_line {
    margin-top: 1.125rem;
  }
  .totalCount .alertsBtn {
    margin: 1.125rem 0;
  }
  .totalCount .scoreQuery_btn{
    text-align: right;
    margin:1.25rem 0;
  }
  .totalCount .scoreQuery_btn .el-button{
    padding: 0;
    height:30px;
    border-radius: 15px;
    width: 100px;
    font-size:.875rem;
  }
  .totalCount .grade{
    width:8.75rem;
  }
  .totalCount .l_class{
    width:9.375rem;
  }
  .totalCount .test{
    width:15.625rem;
  }
  .totalCount .formInline .el-form-item{
    margin-right:2.5rem;
    margin-bottom:0;
  }
</style>
