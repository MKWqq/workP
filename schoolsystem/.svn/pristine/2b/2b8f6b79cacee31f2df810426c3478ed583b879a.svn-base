<template>
  <div class="dormitoryPrintReport">
    <el-row type="flex" align="middle">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <h3>打印报表</h3>
    </el-row>
    <el-row class="dormitoryPrintReport_row">
      <el-form :inline="true" class="formInline">
        <el-form-item label="报表类型：">
          <el-select v-model="reportType" placeholder="请选择" class="reportType">
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
      </el-form>
    </el-row>
    <el-row class="d_line"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
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
    </el-row>
    <el-row class="volunteerConfirmList_row">
      <el-row type="flex" justify="center">
        <el-col :span="16" class="typeStyleOne" v-show="reportType==0">
          <el-row class="listTitle">
            <h5>新班学生名单</h5>
          </el-row>
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
              prop="type"
              label="性别">
            </el-table-column>
            <el-table-column
              prop="type"
              label="宿舍楼名称">
            </el-table-column>
            <el-table-column
              prop="type"
              label="栋号">
            </el-table-column>
            <el-table-column
              prop="type"
              label="宿舍号">
            </el-table-column>
            <el-table-column
              prop="type"
              label="宿舍名称">
            </el-table-column>
          </el-table>
        </el-col>
        <el-col class="alertsList" v-show="reportType==1||reportType==4">
          <el-table
            :data="tableData"
            style="width: 100%"
            @sort-change="sort"
          >
            <el-table-column
              type="index"
              label="序号"
              width="80">
            </el-table-column>
            <el-table-column
              label="考号"
              prop="title"
              min-width="100"
              sortable>
            </el-table-column>
            <el-table-column
              label="姓名"
              prop="kind"
              min-width="100"
              sortable>
            </el-table-column>
            <el-table-column
              prop="creator"
              label="性别"
              min-width="100"
              sortable>
            </el-table-column>
            <el-table-column
              prop="department"
              label="年级"
              min-width="100"
              sortable>
            </el-table-column>
            <el-table-column
              prop="createTime"
              label="班级"
              min-width="100"
              sortable>
            </el-table-column>
            <el-table-column
              prop="status"
              min-width="100"
              label="手机号">
            </el-table-column>
            <el-table-column
              prop="status"
              min-width="120"
              label="户口所在地">
            </el-table-column>
            <el-table-column
              prop="status"
              min-width="120"
              label="生活老师">
            </el-table-column>
            <el-table-column
              prop="status"
              min-width="150"
              label="宿舍楼名称">
            </el-table-column>
            <el-table-column
              prop="status"
              min-width="100"
              label="栋号">
            </el-table-column>
            <el-table-column
              prop="status"
              min-width="100"
              label="楼层">
            </el-table-column>
            <el-table-column
              prop="status"
              min-width="100"
              label="宿舍号">
            </el-table-column>
          </el-table>
        </el-col>
        <el-col :span="16" class="typeStyleOne typeStyleTwo" v-show="reportType==3">
          <el-row class="listTitle">
            <h5>新班学生名单</h5>
          </el-row>
          <el-row>
            <h6>生活老师：张三</h6>
          </el-row>
          <el-row class="typeStyleTwoList">
            <p><span class="tipRow">>></span>九年级等谁房东说宿舍（5/5）（男）男生宿舍</p>
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
                prop="type"
                label="年级">
              </el-table-column>
              <el-table-column
                prop="type"
                label="班级">
              </el-table-column>
              <el-table-column
                prop="type"
                label="手机号">
              </el-table-column>
              <el-table-column
                prop="type"
                label="备注">
              </el-table-column>
            </el-table>
          </el-row>
          <el-row>
            <p><span class="tipRow">>></span><span>九年级等谁房东说宿舍（5/5）（男）男生宿舍</span></p>
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
                prop="type"
                label="年级">
              </el-table-column>
              <el-table-column
                prop="type"
                label="班级">
              </el-table-column>
              <el-table-column
                prop="type"
                label="手机号">
              </el-table-column>
              <el-table-column
                prop="type"
                label="备注">
              </el-table-column>
            </el-table>
          </el-row>
        </el-col>
      </el-row>
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
        options: [{
          value: 0,
          label: '粘贴总名单'
        }, {
          value: 1,
          label: '宿舍分配总名单'
        }, {
          value: 2,
          label: '班级宿舍名单'
        }, {
          value: 3,
          label: '各宿舍学生名单'
        }, {
          value: 4,
          label: '宿舍住宿人数统计表'
        }],
        reportType: 3
      }
    },
    methods: {
      returnFlowchart(){
        this.$router.go(-1);
      },
      sort(column){
        var self = this;
      },
    }
  }
</script>
<style>
  .dormitoryPrintReport .dormitoryPrintReport_row {
    margin-top: 2rem;
  }

  .dormitoryPrintReport .volunteerConfirmList_row {
    margin-bottom: 3.5rem;
  }

  .dormitoryPrintReport .alertsBtn {
    margin: 1.25rem 0;
  }

  .dormitoryPrintReport .typeStyleOne .el-table th {
    background-color: #deeefe;
    height: 2.5rem;
  }

  .dormitoryPrintReport .typeStyleOne .el-table td {
    height: 2.5rem;
    font-size: .875rem;
  }

  .dormitoryPrintReport .typeStyleOne .el-table__footer-wrapper thead div, .dormitoryPrintReport .typeStyleOne .el-table__header-wrapper thead div {
    background-color: #deeefe;
    color: #282828;
  }

  .dormitoryPrintReport .listTitle {
    text-align: center;
    margin-bottom: 1.5rem;
  }

  .dormitoryPrintReport .listTitle h5 {
    font-size: 1.5rem;
    font-weight: bold;
  }

  .dormitoryPrintReport .typeStyleTwo h6 {
    font-size: 1.125rem;
    font-weight: bold;
    margin: 2rem 0;
  }

  .dormitoryPrintReport .typeStyleTwo p {
    font-size: 14px;
    margin-bottom: 1.125rem;
  }

  .dormitoryPrintReport .typeStyleTwoList {
    margin-bottom: 2rem;
  }

  .dormitoryPrintReport .typeStyleTwo p .tipRow {
    color: #4da1ff;
    margin-right: .75rem;
  }

  .dormitoryPrintReport .reportType {
    width: 15.625rem;
  }
</style>
