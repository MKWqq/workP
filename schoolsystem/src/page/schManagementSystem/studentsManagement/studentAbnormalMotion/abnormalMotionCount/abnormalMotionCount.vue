<template>
    <div class="abnormalMotionCount">
      <h3>异动统计</h3>
      <el-row class="abnormalMotionCount_row">
        <el-form ref="form" :inline="true" :model="form" label-width="100px" class="abnormalMotionCount_form">
          <el-form-item label="档案时间：">
            <el-col :span="11">
              <el-date-picker type="date" :editable="false" placeholder="选择日期" v-model="form.date1" style="width: 100%;"></el-date-picker>
            </el-col>
            <el-col class="line" :span="2">-</el-col>
            <el-col :span="11">
              <el-date-picker type="date" :editable="false" placeholder="选择时间" v-model="form.date2" style="width: 100%;"></el-date-picker>
            </el-col>
          </el-form-item>
          <el-form-item>
            <el-button icon="search" type="primary">查询</el-button>
          </el-form-item>
        </el-form>
      </el-row>
      <el-row class="d_line abnormalMotionCount_row"></el-row>
      <el-row type="flex" justify="end" class="alertsBtn">
        <div class="g-fuzzyInput">
          <el-input
            placeholder="请选择日期"
            icon="search"
            v-model="selectParam.searchValue"
            :on-icon-click="goSearch">
          </el-input>
        </div>
      </el-row>
      <el-row class="alertsList">
        <el-table
          :data="tableData"
          style="width: 100%"
          @cell-click="viewList"
        >
          <el-table-column
            prop="type"
            label="年级/异动类型">
          </el-table-column>
          <el-table-column
            label="转班">
            <template scope="scope">
              <span :class="{'active':scope.row.publisher!=0}">{{scope.row.publisher}}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="转入">
            <template scope="scope">
              <span :class="{'active':scope.row.publisher!=0}">{{scope.row.publisher}}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="转出">
            <template scope="scope">
              <span :class="{'active':scope.row.publisher!=0}">{{scope.row.publisher}}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="休学">
            <template scope="scope">
              <span :class="{'active':scope.row.publisher!=0}">{{scope.row.publisher}}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="复学">
            <template scope="scope">
              <span :class="{'active':scope.row.publisher!=0}">{{scope.row.publisher}}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="借读">
            <template scope="scope">
              <span :class="{'active':scope.row.publisher!=0}">{{scope.row.publisher}}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="挂读">
            <template scope="scope">
              <span :class="{'active':scope.row.publisher!=0}">{{scope.row.publisher}}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="退学">
            <template scope="scope">
              <span :class="{'active':scope.row.publisher!=0}">{{scope.row.publisher}}</span>
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
      <el-dialog
        title="异动学生名单"
        :visible.sync="dialogVisible"
        :modal="false"
        :before-close="handleClose">
        <el-row class="viewList">
          <el-table
            :data="tableData"
            style="width: 100%"
            border
          >
            <el-table-column
              prop="type"
              label="姓名">
            </el-table-column>
            <el-table-column
              prop="publisher"
              label="年级">
            </el-table-column>
            <el-table-column
              prop="publisher"
              label="班级">
            </el-table-column>
            <el-table-column
              prop="publisher"
              label="异动类型">
            </el-table-column>
            <el-table-column
              prop="publisher"
              label="更新日期">
            </el-table-column>
          </el-table>
        </el-row>
      </el-dialog>
    </div>
</template>
<script>
    export default{
        data(){
            return {
              tableData: [{
                id: 1,
                title: '今天天气不错啊',
                type: '通知',
                publisher: 1,
                publishPart: 'hjshf',
                date: '2016-05-03 16:16:55',
                vState: '已查阅',
                checked: false
              }, {
                id: 2,
                title: '下雨了',
                type: '通知',
                publisher: 2,
                publishPart: 'hjshf',
                date: '2016-05-03 16:16:55',
                vState: '未查阅',
                checked: false
              }, {
                id: 3,
                title: '那是',
                type: '通知',
                publisher:0,
                publishPart: 'hjshf',
                date: '2016-05-03 16:16:55',
                vState: '已查阅',
                checked: false
              }],
              currentPage: 1,
              pageALl: 100,
              selectParam: {
                grade: '',
                class: '',
                searchValue: ''
              },
              form:{
                  date1:'',
                  date2:''
              },
              dialogVisible: false
            }
        },
        methods: {
          onSearch() {
            console.log('submit!');
          },
          goSearch(ev) {  //查询
            console.log(ev);
          },
          handleCurrentChange(val) {
            this.currentPage = val;
            console.log(`当前页: ${this.currentPage}`);
          },
          viewList(row, column, cell, event){
            this.dialogVisible = true;
            console.log(column);
            console.log(row);
          },
          handleClose(done) {
            done();
          }
        }
    }
</script>
<style>
  .abnormalMotionCount {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .abnormalMotionCount .abnormalMotionCount_row{
    margin-top:2rem;
  }
  .abnormalMotionCount .alertsBtn {
    margin: 1.25rem 0;
  }
  .abnormalMotionCount .alertsList .el-table th, .abnormalMotionCount .alertsList .el-table td {
    text-align: center;
  }
  .abnormalMotionCount h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
    display: inline-block;
  }
  .abnormalMotionCount .el-form--inline .el-form-item{
    margin-right:2rem;
    margin-bottom:0;
  }
  .abnormalMotionCount .line{
    text-align: center;
  }
  .abnormalMotionCount .d_line.abnormalMotionCount_row{
    margin:1.25rem 0;
  }
  .abnormalMotionCount .abnormalMotionCount_form .el-button{
    border-radius: 20px;
    padding:10px 25px;
  }
  .abnormalMotionCount .viewList .el-table th{
    background-color: #deeefe;
  }
  .abnormalMotionCount .viewList .el-table__footer-wrapper thead div, .abnormalMotionCount .viewList .el-table__header-wrapper thead div{
    background-color: #deeefe;
  }
  .abnormalMotionCount .viewList .el-table th,.abnormalMotionCount .viewList .el-table td{
    text-align: center;
  }
  .abnormalMotionCount .alertsList .active{
    color: #4da1ff;
  }
</style>
