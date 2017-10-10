<template>
  <div class="testNumberSetting candidatesArrangement">
    <el-row>
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
    </el-row>
    <el-row class="examManager_row" type="flex" align="middle" justify="space-between">
      <el-col :span="18">
        <el-form :inline="true" class="formInline">
          <el-form-item label="学生排位方式：">
            <el-select v-model="rankConditions.type" placeholder="请选择">
              <el-option
                v-for="(item,index) in testNumbers"
                :key="item.value"
                :label="item.label"
                :value="index">
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="考号：">
            <el-select v-model="rankConditions.number" placeholder="请选择">
              <el-option
                v-for="(item,index) in testNumbers"
                :key="item.value"
                :label="item.label"
                :value="index">
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="changeData">
              <img class="rank_img" src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_rank.png" alt="">
              <span>生成排位</span>
            </el-button>
          </el-form-item>
        </el-form>
      </el-col>
      <el-col :span="6" class="rankConditions_isStraight">
        <span>借读生连续排位：</span>
        <el-switch
          v-model="rankConditions.isStraight"
          on-color="#13b5b1"
          off-color="#ff4949"
          on-text="是"
          off-text="否">
        </el-switch>
      </el-col>
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
          prop="type"
          label="班级" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="班级序号" sortable>
        </el-table-column>
        <el-table-column
          prop="title"
          label="姓名" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="考场">
        </el-table-column>
        <el-table-column
          prop="title"
          label="考场座位号" sortable>
        </el-table-column>
        <el-table-column
          prop="title"
          label="科类" sortable>
        </el-table-column>
        <el-table-column
          prop="title"
          label="考号" sortable>
        </el-table-column>
        <el-table-column
          prop="title"
          label="是否借读" sortable>
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
        testNumbers: [{
          value: '选项1',
          label: '省考号'
        }, {
          value: '选项2',
          label: '市考号'
        }, {
          value: '选项2',
          label: '校考号'
        }],
        rankConditions: {
            type:'',
          number:'',
          isStraight:true
        },
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
      returnFlowchart(){
        this.$router.push('/examManagerHome');
      },
      changeData(){
        console.log(this.rankConditions);
      }
    }
  }
</script>
<style>
  .candidatesArrangement .examManager_row .el-button--primary {
    background-color: #13b5b1;
    border-color: #13b5b1;
    height: 36px;
    padding: 0 15px;
  }
  .candidatesArrangement .rankConditions_isStraight{
    text-align: right;
  }
  .candidatesArrangement .rank_img{
    width:14px;
  }
</style>
