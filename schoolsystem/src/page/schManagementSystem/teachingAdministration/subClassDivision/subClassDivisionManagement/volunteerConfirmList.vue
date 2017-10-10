<template>
  <div class="volunteerConfirmList">
    <el-row type="flex" align="middle" class="subClassDivision_title">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <h3>志愿确认签名表</h3>
    </el-row>
    <el-row class="d_line"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
          <el-button class="delete" title="打印">
            <img class="delete_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png"
                 alt="">
            <img class="delete_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png"
                 alt="">
          </el-button>
    </el-row>
    <el-row class="volunteerConfirmList_row">
      <el-row class="listTitle">
        <p>分科分班志愿核对确认表</p>
        <p>八年级1班</p>
      </el-row>
      <el-row :gutter="40" type="flex" justify="center">
        <el-col :span="10">
          <el-table
            :data="tableData"
            style="width: 100%"
            border
          >
            <el-table-column
              prop="type"
              label="班级序号">
            </el-table-column>
            <el-table-column
              prop="type"
              label="姓名">
            </el-table-column>
            <el-table-column
              prop="type"
              label="志愿">
            </el-table-column>
            <el-table-column
              prop="type"
              label="确认签字">
            </el-table-column>
          </el-table>
        </el-col>
        <el-col :span="10">
          <el-table
            :data="tableData1"
            style="width: 100%"
            border
          >
            <el-table-column
              prop="type"
              label="班级序号">
            </el-table-column>
            <el-table-column
              prop="type"
              label="姓名">
            </el-table-column>
            <el-table-column
              prop="type"
              label="志愿">
            </el-table-column>
            <el-table-column
              prop="type"
              label="确认签字">
            </el-table-column>
          </el-table>
          <el-row class="total">合计：未填报38</el-row>
        </el-col>
      </el-row>
    </el-row>
    <el-row class="volunteerConfirmList_row">
      <el-row class="listTitle">
        <p>分科分班志愿核对确认表</p>
        <p> 八年级2班</p>
      </el-row>
      <el-row :gutter="40" type="flex" justify="center">
        <el-col :span="10">
          <el-table
            :data="tableData"
            style="width: 100%"
            border
          >
            <el-table-column
              prop="type"
              label="班级序号">
            </el-table-column>
            <el-table-column
              prop="type"
              label="姓名">
            </el-table-column>
            <el-table-column
              prop="type"
              label="志愿">
            </el-table-column>
            <el-table-column
              prop="type"
              label="确认签字">
            </el-table-column>
          </el-table>
        </el-col>
        <el-col :span="10">
          <el-table
            :data="tableData1"
            style="width: 100%"
            border
          >
            <el-table-column
              prop="type"
              label="班级序号">
            </el-table-column>
            <el-table-column
              prop="type"
              label="姓名">
            </el-table-column>
            <el-table-column
              prop="type"
              label="志愿">
            </el-table-column>
            <el-table-column
              prop="type"
              label="确认签字">
            </el-table-column>
          </el-table>
          <el-row class="total">合计：未填报38</el-row>
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
        tableData1: [{
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
        }]
      }
    },
    methods: {
      returnFlowchart(){
        this.$router.push('/subClassDivisionHome');
      }
    }
  }
</script>
<style>
  .volunteerConfirmList .volunteerConfirmList_row{
    margin-bottom:3.5rem;
  }
  .volunteerConfirmList .alertsBtn {
    margin: 1.25rem 0;
  }
  .volunteerConfirmList .total{
    text-align: center;
    height:2.5rem;
    line-height:2.5rem;
    font-size: .875rem;
    border-left:1px solid #dfe6ec;
    border-right:1px solid #dfe6ec;
    border-bottom:1px solid #dfe6ec;
  }
  .volunteerConfirmList .el-table th{
    background-color: #deeefe;
    height:2.5rem;
  }
  .volunteerConfirmList .el-table td{
    height:2.5rem;
    font-size:.875rem;
  }
  .volunteerConfirmList .el-table__footer-wrapper thead div, .volunteerConfirmList .el-table__header-wrapper thead div{
    background-color: #deeefe;
    color: #282828;
  }
  .volunteerConfirmList .listTitle{
    text-align: center;
    margin-bottom:1.5rem;
  }
  .volunteerConfirmList .listTitle>p:first-child{
    font-size:1.5rem;
  }
  .volunteerConfirmList .listTitle>p:last-child{
    font-size:1.25rem;
    margin-top:1rem;
  }
</style>
