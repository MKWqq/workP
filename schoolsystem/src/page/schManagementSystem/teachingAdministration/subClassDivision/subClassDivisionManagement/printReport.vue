<template>
  <div class="printReport">
    <el-row type="flex" align="middle" class="subClassDivision_title">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <h3>打印报表</h3>
    </el-row>
    <el-row>
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
      <el-row class="listTitle">
        <p>新班学生名单</p>
        <p>八年级1班（<span class="pNumber">32人</span>）</p>
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
              label="性别">
            </el-table-column>
            <el-table-column
              prop="type"
              label="科类">
            </el-table-column>
            <el-table-column
              prop="type"
              label="专业">
            </el-table-column>
            <el-table-column
              prop="type"
              label="原班级">
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
              label="性别">
            </el-table-column>
            <el-table-column
              prop="type"
              label="科类">
            </el-table-column>
            <el-table-column
              prop="type"
              label="专业">
            </el-table-column>
            <el-table-column
              prop="type"
              label="原班级">
            </el-table-column>
          </el-table>
        </el-col>
      </el-row>
    </el-row>
    <el-row class="volunteerConfirmList_row">
      <el-row class="listTitle">
        <p>新班学生名单</p>
        <p>八年级2班（<span class="pNumber">32人</span>）</p>
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
        }],
        options: [{
          value: '选项1',
          label: '黄金糕'
        }, {
          value: '选项2',
          label: '双皮奶'
        }, {
          value: '选项3',
          label: '蚵仔煎'
        }, {
          value: '选项4',
          label: '龙须面'
        }, {
          value: '选项5',
          label: '北京烤鸭'
        }],
        reportType:''
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
  .printReport .volunteerConfirmList_row{
    margin-bottom:3.5rem;
  }
  .printReport .alertsBtn {
    margin: 1.25rem 0;
  }
  .printReport .el-table th{
    background-color: #deeefe;
    height:2.5rem;
  }
  .printReport .el-table td{
    height:2.5rem;
    font-size:.875rem;
  }
  .printReport .el-table__footer-wrapper thead div, .printReport .el-table__header-wrapper thead div{
    background-color: #deeefe;
    color: #282828;
  }
  .printReport .listTitle{
    text-align: center;
    margin-bottom:1.5rem;
  }
  .printReport .listTitle>p:first-child{
    font-size:1.5rem;
  }
  .printReport .listTitle>p:last-child{
    font-size:1.25rem;
    margin-top:1rem;
  }
  .printReport .reportType{
    width:12.5rem;
  }
  .printReport .pNumber{
    color: #4da1ff;
  }
</style>
