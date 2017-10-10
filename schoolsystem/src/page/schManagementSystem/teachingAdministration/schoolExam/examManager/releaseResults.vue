<template>
  <div class="releaseResults">
    <el-row>
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
    </el-row>
    <el-row class="examManager_row switch" type="flex" align="middle">
      <span>向学生和家长发布排名：</span>
      <el-switch
        v-model="isPublic"
        on-color="#13b5b1"
        off-color="#ff4949"
        on-text="是"
        off-text="否">
      </el-switch>
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        style="width: 100%"
        @sort-change="sort"
      >
        <el-table-column
          prop="type"
          label="科类" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="科目" sortable>
        </el-table-column>
        <el-table-column
          prop="title"
          label="考试人数（人）" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="已录入成绩（人）">
        </el-table-column>
        <el-table-column
          prop="title"
          label="考场座位号" sortable>
        </el-table-column>
        <el-table-column
          prop="title"
          label="未录入成绩（人）" sortable>
        </el-table-column>
        <el-table-column
          prop="title"
          label="完成度（%）" sortable>
        </el-table-column>
      </el-table>
    </el-row>
    <el-row class="testOperation_btn">
      <el-button type="primary" @click="releaseResults">发布成绩</el-button>
    </el-row>
    <!--<el-row class="pageAlerts">
      <el-pagination
        @current-change="handleCurrentChange"
        :current-page.sync="currentPage"
        :page-size="pageALl"
        layout="prev, pager, next, jumper"
        :total="1000">
      </el-pagination>
    </el-row>-->
  </div>
</template>
<script>
  export default{
    data(){
      return {
        isPublic: true,
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
        currentPage: 1,
        pageALl: 100
      }
    },
    methods: {
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
      releaseResults(){

      }
    }
  }
</script>
<style>
  .releaseResults .examManager_row .el-button--primary {
    background-color: #13b5b1;
    border-color: #13b5b1;
    height: 36px;
    padding: 0 15px;
  }
</style>
