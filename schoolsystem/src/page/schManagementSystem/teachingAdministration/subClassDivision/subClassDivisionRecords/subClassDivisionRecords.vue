<template>
  <div class="subClassDivisionRecords">
    <el-row type="flex" align="middle" class="subClassDivision_title">
      <h3>分班分科记录</h3>
    </el-row>
    <el-row class="subClassDivisionRecords_row">
      <div class="g-fuzzyInput">
        <el-input
          placeholder="请选择日期"
          icon="search"
          v-model="searchValue"
          :on-icon-click="goSearch">
        </el-input>
      </div>
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        style="width: 100%"
        @sort-change="sort"
      >
        <el-table-column
          prop="type"
          label="方案名称" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="学生填报志愿" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="班主任调志愿" sortable>
        </el-table-column>
        <el-table-column
          label="报志愿进度">
          <template scope="scope">
            <div class="progress_bar">
              <span class="progress_bar_active" style="width: 20%;"></span>
              <span class="progress_bar_text">2/14</span>
            </div>
          </template>
        </el-table-column>
        <el-table-column
          prop="type"
          label="创建时间" sortable>
        </el-table-column>
        <el-table-column
          label="操作">
          <template scope="scope">
            <span class="delete" @click="deleteData(scope.$index)">删除</span>
          </template>
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
      deleteData(idx){
        console.log(this.tableData[idx]);
      }
    }
  }
</script>
<style>
  .subClassDivisionRecords {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .subClassDivisionRecords h3 {
    font-size: 1.25rem;
  }

  .subClassDivisionRecords .subClassDivisionRecords_row{
    margin: 1.25rem 0;
  }
 .subClassDivisionRecords .g-fuzzyInput{
   float: right;
 }
  .subClassDivisionRecords .delete{
    color: #ff5b5b;
    cursor: pointer;
  }
  .subClassDivisionRecords .el-table td, .subClassDivisionRecords .el-table th {
    text-align: center;
  }
  .subClassDivisionRecords .progress_bar{
    background-color: #f0f0f0;
    position: relative;
    height:22px;
  }
  .subClassDivisionRecords .progress_bar .progress_bar_active{
    display: block;
    position: absolute;
    left:0;
    top:0;
    background-color: #13b5b1;
    height:100%;
    z-index:1;
  }
  .subClassDivisionRecords .progress_bar .progress_bar_text{
    display: block;
    width:100%;
    position: absolute;
    z-index:2;
  }
</style>
