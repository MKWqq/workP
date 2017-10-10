<template>
  <div class="LeaveRecord">
    <el-col :span="24">
      <h3>请假统计</h3>
    </el-col>
    <el-col class="LeaveRecord-title">
      <!--时间段-->
      <el-col :span="24">
        <el-col :span="2">时间段：</el-col>
        <el-col :span="3" style="margin-left: -3rem">
          <el-date-picker
            v-model="startvalue" type="date" :picker-options="pickerOptions0" style="width: 100%">
          </el-date-picker>
        </el-col>
        <el-col :span="1"  style="text-align: center">_</el-col>
        <el-col :span="3">
          <el-date-picker
            v-model="endvalue" type="date" :picker-options="pickerOptions1" style="width: 100%">
          </el-date-picker>
        </el-col>
        <el-col :span="1" :offset="12">
          <el-button type="primary" icon="search" class="LeaveRecord-search" @click="querryList()">查询</el-button>
        </el-col>
      </el-col>
    </el-col>
    <el-col :span="18" class="alertsBtn">
      <el-button class="delete" title="导出">
        <img class="delete_unactive"
             src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
             alt="">
        <img class="delete_active"
             src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
             alt="">
      </el-button>
      <el-button-group style="margin-left: 2.1rem">
        <el-button class="filt" title="复制">
          <img class="filt_unactive"
               src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png"
               alt="">
          <img class="filt_active"
               src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png"
               alt="">
        </el-button>
        <el-button class="delete" title="打印">
          <img class="delete_unactive"
               src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png"
               alt="">
          <img class="delete_active"
               src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png"
               alt="">
        </el-button>
      </el-button-group>
    </el-col>
    <el-col :span="24">
      <el-row class="alertsList">
        <el-table
          :data="tableData"
          style="width: 100%"
          @sort-change="sort"
          align="center"
          v-loading.body="isLoading"
          element-loading-text="拼命加载中...">
          <el-table-column
            prop="proposer"
            label="姓名"
            align="center" sortable="custom">
          </el-table-column>
          <el-table-column
            prop="times"
            label="总计次数"
            align="center" sortable="custom">
          </el-table-column>
          <el-table-column
            prop="totalDays"
            label="总计天数"
            align="center" sortable="custom">
          </el-table-column>
        </el-table>
      </el-row>
      <el-row class="pageAlerts">
        <el-pagination
          @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-size="10"
          layout="prev, pager, next, jumper"
          :total="total">
        </el-pagination>
      </el-row>
    </el-col>
  </div>
</template>
<script>
  import req from './../../../../assets/js/common'
  import formatdata from './../../../../assets/js/date'
  export default{
    data(){
      return{
        isLoading:false,
        pickerOptions0: {
          disabledDate(time) {
            return time.getTime() > Date.now();
          }
        },
        pickerOptions1: {
          disabledDate(time) {
            return time.getTime() > Date.now();
          }
        },
        startvalue:new Date(),
        endvalue:new Date(),
        tableData: [],
        currentPage: 1,
        pageALl: 10,
        total:0,
        order:'createTime desc',
      }
    },
    created(){
       this.querryList(1)
    },
    methods:{
      querryList(page){
        if(page!==this.currentPage){
          this.currentPage=page;
        }
        this.isLoading=true;
        let startvalue=formatdata.format(this.startvalue,'yyyy-MM-dd');
        let endvalue=formatdata.format(this.endvalue,'yyyy-MM-dd');
        let param = {
          page: this.currentPage,
          count: 10,
          startTime:startvalue,
          endTime: endvalue,
          order:this.order
        };
        req.ajaxSend('/school/TeacherLeave/statistics','post',param,(res)=> {
//            console.log(res);
          if (res.status === -1) {
            this.tableData = [];
            this.isLoading = false;
            return;
          }
          this.tableData = res.data;
          this.total = res.total;
          this.isLoading = false;
        })
      },
      sort(column){
        this.order = `${column.prop} ${column.order==='ascending'?'asc':'desc'}`;
        this.querryList(1);
      },
      handleCurrentChange(val) {
        this.currentPage = val;
        this.querryList(val);
//        console.log(`当前页: ${this.currentPage}`);
      }
    }
  }
</script>
<style>
  .LeaveRecord{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .LeaveRecord-title{
    margin-top: 2rem;
    padding-bottom: 1.3rem;
    border-bottom: 1px solid #d2d2d2;
  }
  .LeaveRecord-search{
    background: #4da1ff;
    width: 7.6rem;
    border-radius: 1.1rem;
  }
  .alertsBtn{
    margin-top: 1.5rem;
  }
</style>
