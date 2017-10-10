<template>
  <div class="leaveSchoolConfirmation">
    <h3>离校确认</h3>
    <el-row class="leaveSchoolConfirmation_row">
      <el-form :inline="true" class="formInline">
        <el-form-item label="年级：" class="grade">
          <el-select v-model="selectParam.grade" placeholder="请选择年级">
            <el-option label="区域一" value="shanghai"></el-option>
            <el-option label="区域二" value="beijing"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="班级：" class="grade">
          <el-select v-model="selectParam.class" placeholder="请选择班级">
            <el-option label="区域一" value="shanghai"></el-option>
            <el-option label="区域二" value="beijing"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="创建日期：" class="createDate">
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
          prop="title"
          label="标题" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="类型" sortable>
        </el-table-column>
        <el-table-column
          prop="name"
          label="天数" sortable>
        </el-table-column>
        <el-table-column
          prop="name"
          label="申请人" sortable>
        </el-table-column>
        <el-table-column
          prop="name"
          label="审批状态" sortable>
        </el-table-column>
        <el-table-column
          prop="name"
          label="创建时间" sortable>
        </el-table-column>
        <el-table-column
          label="操作">
          <template scope="scope">
            <span v-if="!scope.row.checked" class="edit" @click="confirmLeave(scope.$index)">确认离校</span>
            <span v-if="scope.row.checked">已离校</span>
          </template>
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
          grade:'',
          class:'',
          date1:'',
          date2:'',
          field: '',   //排序字段
          screen: '',   //搜索框的值
          order: ''   //正序还是倒叙
        },
        totalNum: 0,
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
      confirmLeave(idx){
        this.$confirm('学生是否离校?', '提示', {
          confirmButtonText: '是',
          cancelButtonText: '否',
          type: 'warning'
        }).then(() => {
          this.tableData[idx].checked=true;
        }).catch(() => {
        });
      },
      loadData(data){
      }
    }
  }
</script>
<style>
  .leaveSchoolConfirmation {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .leaveSchoolConfirmation h3 {
    font-size: 1.25rem;
  }
  .leaveSchoolConfirmation .leaveSchoolConfirmation_row{
    margin:2rem 0 1.25rem;
  }
  .leaveSchoolConfirmation .searchBtn{
    border-radius: 20px;
    padding:10px 25px;
  }
  .leaveSchoolConfirmation .el-form--inline .el-form-item{
    margin-bottom:0;
    margin-right:2rem;
  }
  .leaveSchoolConfirmation .el-form--inline .grade .el-select{
    width:8.75rem;
  }
  .leaveSchoolConfirmation .el-form--inline .createDate .el-form-item__content{
    width:31.25rem;
  }
  .leaveSchoolConfirmation .line{
    text-align: center;
  }
  .leaveSchoolConfirmation .alertsBtn{
    margin:1.25rem 0;
  }
  .leaveSchoolConfirmation .edit{
    color: #4da1ff;
    cursor: pointer;
  }
  .leaveSchoolConfirmation .el-table th,.leaveSchoolConfirmation .el-table td{
    text-align: center;
  }
</style>
