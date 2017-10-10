<template>
  <div class="personnelDetail">
    <el-row class="d_line personnelDetail_row"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
      <el-col :span="18">
        <el-button-group>
          <el-button class="filt" title="导出" @click="operationData('out')">
            <img class="filt_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
                 alt="">
            <img class="filt_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
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
            placeholder="请输入名字/科目"
            icon="search"
            v-model="selectParam.value"
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
          label="序号"
          width="100">
        </el-table-column>
        <el-table-column
          prop="name"
          label="宿舍楼名称"
          sortable>
        </el-table-column>
        <el-table-column
          prop="sex"
          label="栋号"
          sortable>
        </el-table-column>
        <el-table-column
          prop="jobNumber"
          label="楼层"
          sortable>
        </el-table-column>
        <el-table-column
          prop="teachingSubjects"
          label="宿舍名称"
          sortable>
        </el-table-column>
        <el-table-column
          prop="politics"
          label="宿舍类型"
          sortable>
        </el-table-column>
        <el-table-column
          prop="phone"
          label="容纳人数"
          sortable>
        </el-table-column>
        <el-table-column
          prop="phone"
          label="实住人数"
          sortable>
        </el-table-column>
        <el-table-column
          prop="phone"
          label="实住人员名单"
          sortable>
        </el-table-column>
      </el-table>
    </el-row>
    <el-row class="pageAlerts" v-if="tableData.length!=0">
      <el-pagination
        @current-change="handleCurrentChange"
        :current-page.sync="selectParam.page"
        layout="prev, pager, next, jumper"
        :total="totalNum">
      </el-pagination>
    </el-row>
  </div>
</template>
<script>
  export default{
    data(){
      return {
        tableData: [{
          name: '123',
          state: false
        }, {
          name: '456',
          state: false
        }, {
          name: '7',
          state: true
        }],
        selectParam: {
          page: 1,
          pageSize: 10,
          sort: '',
          sortType: '',
          value: ''
        },
        totalNum: 0
      }
    },
    methods: {
      sort(column){

      },
      goSearch() {  //查询
        this.selectParam.page = 1;
        this.selectParam.sort = '';
        this.selectParam.sortType = '';
        this.loadDataList(this.selectParam);
      },
      handleCurrentChange(val){
        this.selectParam.page = val;
      },
      operationData(type){

      }
    }
  }
</script>
<style>
  .personnelDetail .personnelDetail_row {
    margin-top: 2rem;
  }

  .personnelDetail .alertsBtn {
    margin: 1.25rem 0;
  }

  .personnelDetail .g-fuzzyInput {
    float: right;
  }

  .personnelDetail .el-table th, .personnelDetail .el-table td {
    text-align: center;
  }
</style>
