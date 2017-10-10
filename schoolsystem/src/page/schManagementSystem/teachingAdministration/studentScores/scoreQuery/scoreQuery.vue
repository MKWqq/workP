<template>
    <div class="scoreQuery">
      <h3>成绩查询</h3>
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
          <el-form-item label="班级：">
            <el-select multiple v-model="grades" placeholder="请选择" class="l_class">
              <el-option value="all">全选</el-option>
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="科类：">
            <el-select v-model="grade" placeholder="请选择" class="subject">
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
          <el-form-item label="显示单科排名：">
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
      <el-row class="scoreRow">
        <el-form :inline="true" class="formInline">
          <el-form-item label="专业：">
            <el-select v-model="grade" placeholder="请选择" class="grade">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="总分统计科目：">
            <el-checkbox-group v-model="checkList">
              <el-checkbox label="语文"></el-checkbox>
              <el-checkbox label="数学"></el-checkbox>
              <el-checkbox label="英语"></el-checkbox>
              <el-checkbox label="物理"></el-checkbox>
              <el-checkbox label="化学"></el-checkbox>
            </el-checkbox-group>
          </el-form-item>
        </el-form>
      </el-row>
      <el-row type="flex" align="middle" class="scoreRow">
        <el-col :span="18">
          <el-button-group class="rank_btn">
            <el-button><span>全部</span></el-button>
            <el-button><span>前</span> <input type="text" v-model="filterCriteria.topSeveral" class="topSeveral"> <span>名</span></el-button>
            <el-button><span>后</span> <input type="text" v-model="filterCriteria.lastSeveral" class="topSeveral"> <span>名</span></el-button>
          </el-button-group>
          <el-checkbox-group v-model="checkList" class="fillLeft">
            <el-checkbox label="除去总分0分"></el-checkbox>
            <el-checkbox label="除去单科缺考"></el-checkbox>
          </el-checkbox-group>
        </el-col>
        <el-col :span="6" class="scoreQuery_btn">
          <el-button type="primary">
            <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/studentScores/icon_search.png" alt="">
            <span>查询</span>
          </el-button>
        </el-col>
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
            prop="name"
            label="姓名" sortable>
          </el-table-column>
          <el-table-column
            prop="sex"
            label="班级" sortable>
          </el-table-column>
          <el-table-column
            prop="sex"
            label="座号" sortable>
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
            prop="politicalFace"
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
            label="总分" sortable>
          </el-table-column>
          <el-table-column
            prop="tel"
            label="班名次" sortable>
          </el-table-column>
          <el-table-column
            prop="tel"
            label="级名次" sortable>
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
                label: '1'
              }, {
                value: '选项2',
                label: '2'
              }, {
                value: '选项3',
                label: '3'
              }, {
                value: '选项4',
                label: '4'
              }, {
                value: '选项5',
                label: '5'
              }],
              grade: '',
              grades:[],
              showSingleRank:true,
              filterCriteria:{
                  topSeveral:'',
                  lastSeveral:'',
              },
              checkList:[],
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
  .scoreQuery {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
    font-size: 14px;
  }

  .scoreQuery h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
  }
  .scoreQuery .scoreRow{
    margin:1.125rem 0;
  }
  .scoreQuery .scoreRowOne{
    margin:2rem 0 1.125rem;
  }
  .scoreQuery .el-table td, .scoreQuery .el-table th {
    text-align: center;
  }
  .scoreQuery .g-fuzzyInput{
    float: right;
  }
  .scoreQuery .d_line {
    margin-top: 1.125rem;
  }
  .scoreQuery .alertsBtn {
    margin: 1.125rem 0;
  }
  .scoreQuery .scoreQuery_btn{
    text-align: right;
    margin:1.25rem 0;
  }
  .scoreQuery .scoreQuery_btn .el-button{
    padding: 0;
    height:30px;
    border-radius: 15px;
    width: 100px;
    font-size:.875rem;
  }
  .scoreQuery .grade{
    width:8.75rem;
  }
  .scoreQuery .l_class{
    width:9.375rem;
  }
  .scoreQuery .subject{
    width:6.25rem;
  }
  .scoreQuery .test{
    width:15.625rem;
  }
  .scoreQuery .fillLeft{
    margin-left:2.5rem;
  }
  .scoreQuery .formInline .el-form-item{
    margin-right:2.5rem;
    margin-bottom:0;
  }
  .scoreQuery .el-checkbox-group{
    display: inline-block;
  }
  .scoreQuery .scoreRow .el-button-group .el-button:first-child{
    background-color: #09baa7;
    color: #fff;
    border:1px solid #09baa7;
  }
  .scoreQuery .rank_btn .el-button{
    padding:0;
    height:30px;
    width:6rem;
  }
  .scoreQuery input.topSeveral{
    width:1.5rem;
    outline:none;
    border-top:none;
    border-left:none;
    border-right:none;
    border-bottom:1px solid #1f2d3d;
    text-align: center;
  }
</style>
