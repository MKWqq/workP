<template>
  <div class="leaveRecords">
    <h3>请假记录</h3>
    <el-row class="leaveRecords_row">
      <el-form :inline="true" class="formInline">
        <el-form-item label="创建日期：">
          <el-col :span="11">
            <el-date-picker type="date" :editable="false" placeholder="选择日期" v-model="selectParam.date1" style="width: 100%;"></el-date-picker>
          </el-col>
          <el-col class="line" :span="2">-</el-col>
          <el-col :span="11">
            <el-date-picker type="date" :editable="false" placeholder="选择日期" v-model="selectParam.date2" style="width: 100%;"></el-date-picker>
          </el-col>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" icon="search" class="searchBtn" @click="search">查询</el-button>
        </el-form-item>
      </el-form>
    </el-row>
    <el-row class="d_line"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
        <el-button class="delete" title="导出" @click="operationTable('out')">
          <img class="delete_unactive"
               src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
               alt="">
          <img class="delete_active"
               src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
               alt="">
        </el-button>
        <el-button-group class="secBtn-group">
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
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        style="width: 100%"
        @sort-change="sort"
      >
        <el-table-column
          label="标题" sortable>
          <template scope="scope">
            <span class="leaveRecordDetail" @click="showDetail(scope.$index)">{{scope.row.title}}</span>
          </template>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="类型" sortable>
        </el-table-column>
        <el-table-column
          prop="name"
          label="申请人" sortable>
        </el-table-column>
        <el-table-column
          prop="name"
          label="创建时间" sortable>
        </el-table-column>
        <el-table-column
          prop="name"
          label="审批状态" sortable>
        </el-table-column>
      </el-table>
    </el-row>
    <el-row class="pageAlerts" v-if="tableData">
      <el-pagination
        @current-change="handleCurrentChange"
        :current-page.sync="selectParam.page"
        layout="prev, pager, next, jumper"
        :total="totalNum">
      </el-pagination>
    </el-row>
    <el-dialog
      title="请假记录详情"
      :visible.sync="dialogVisible"
      :modal="false"
      :before-close="handleClose">
      <el-row class="recordDetail">
        <h3>#{{recordMsg.title}}#</h3>
        <el-row class="recordDetail_row">
          <el-row type="flex" align="middle" class="recordDetail_items">
            <el-col :span="10" class="recordDetail_item">起始时间</el-col>
            <el-col :span="14" class="recordDetail_item">第三个</el-col>
          </el-row>
          <el-row type="flex" align="middle" class="recordDetail_items">
            <el-col :span="10" class="recordDetail_item">结束时间</el-col>
            <el-col :span="14" class="recordDetail_item">2016-16-32</el-col>
          </el-row>
          <el-row type="flex" align="middle" class="recordDetail_items">
            <el-col :span="10" class="recordDetail_item">请假天数</el-col>
            <el-col :span="14" class="recordDetail_item">说的</el-col>
          </el-row>
          <el-row type="flex" align="middle" class="recordDetail_items">
            <el-col :span="10" class="recordDetail_item">请假类型</el-col>
            <el-col :span="14" class="recordDetail_item">dsg</el-col>
          </el-row>
          <el-row type="flex" align="middle" class="recordDetail_items">
            <el-col :span="10" class="recordDetail_item">请假原因</el-col>
            <el-col :span="14" class="recordDetail_item">dsg</el-col>
          </el-row>
        </el-row>
        <el-row class="recordDetail_row">
          <span class="annex">审批状态</span>
        </el-row>
        <el-row >
          <el-col :offset="2" :span="20">
            <el-form ref="form" label-width="100px">
              <el-form-item label="审批环节：">
                <el-select v-model="recordMsg.name" placeholder="请选审批环节" style="width:100%;">
                  <el-option label="区域一" value="shanghai"></el-option>
                  <el-option label="区域二" value="beijing"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item label="审批人：">
                第三个返回
              </el-form-item>
              <el-form-item label="审批结果：">
                讽德诵功
              </el-form-item>
            </el-form>
          </el-col>
        </el-row>
      </el-row>
    </el-dialog>
  </div>
</template>
<script>
  import req from '@/assets/js/common'
  export default{
    data(){
      return {
        testNumberTypes: [{
          value: '选项1',
          label: '本次考试'
        }, {
          value: '选项2',
          label: '省考号'
        }, {
          value: '选项2',
          label: '市考号'
        }, {
          value: '选项2',
          label: '校考号'
        }],
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
        selectParam: {
          page: 1,
          limit: 10,
          date1:'',
          date2:'',
          field: '',   //排序字段
          screen: '',   //搜索框的值
          order: ''   //正序还是倒叙
        },
        totalNum: 0,
        dialogVisible: false,
        recordMsg:{}
      }
    },
    created: function () {
    },
    methods: {
      search(){
        console.log(22);
      },
      sort(column){
        this.selectParam.order = column.order || '';
        this.selectParam.field = column.prop || '';
        this.loadData(this.selectParam);
      },
      handleCurrentChange(val) {
        this.selectParam.page = val;
        this.loadData(this.selectParam);
      },
      operationTable(type){
          if(type=='out'){
            req.downloadFile('.testNumberSetting','/school/Examination/exmanagement/type/exnumber/typename/export?program='+this.selectParam.program+'&gradeid='+this.selectParam.gradeid+'&examinationid='+this.selectParam.examinationid,'post')
          }
      },
      handleClose(done) {
        done();
      },
      showDetail(idx){
          this.dialogVisible=true;
          $.extend(this.recordMsg,this.tableData[idx]);
      },
      loadData(data){
      }
    }
  }
</script>
<style>
  .leaveRecords {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .leaveRecords h3 {
    font-size: 1.25rem;
  }
  .leaveRecords .leaveRecords_row{
    margin:2rem 0 1.25rem;
  }
  .leaveRecords .searchBtn{
    border-radius: 20px;
    padding:10px 25px;
  }
  .leaveRecords .el-form--inline .el-form-item{
    margin-bottom:0;
    margin-right:2rem;
  }
  .leaveRecords .line{
    text-align: center;
  }
  .leaveRecords .alertsBtn{
    margin:1.25rem 0;
  }
  .leaveRecords .el-table th,.leaveRecords .el-table td{
    text-align: center;
  }
  .leaveRecords .leaveRecordDetail{
    cursor: pointer;
    border-bottom:1px dashed #4da1ff;
  }
  .leaveRecords .el-dialog--small{
    width:600px;
  }
  .leaveRecords .recordDetail h3{
    font-size:16px;
    text-align: center;
  }
  .leaveRecords .recordDetail .recordDetail_items{
    border-top:1px solid #d2d2d2;
  }
  .leaveRecords .recordDetail .recordDetail_items:last-child{
    border-bottom:1px solid #d2d2d2;
  }
  .leaveRecords .recordDetail .recordDetail_item{
    text-align: center;
    padding:12px 0;
  }
  .leaveRecords .recordDetail .recordDetail_item+.recordDetail_item{
    border-left:1px solid #d2d2d2;
  }
  .leaveRecords .recordDetail .recordDetail_row{
    margin:16px 0;
  }
  .leaveRecords .recordDetail .annex {
    display: inline-block;
    padding:8px 16px;
    background-color: #4ba8ff;
    color: #fff;
    border-radius: 0 18px 18px 0;
    -webkit-box-shadow: 0 5px 5px 1px #d2d2d2;
    -moz-box-shadow: 0 5px 5px 1px #d2d2d2;
    box-shadow: 0 5px 5px 1px #d2d2d2;
  }
  .leaveRecords .recordDetail .el-form-item{
    margin-bottom:12px;
  }
</style>
