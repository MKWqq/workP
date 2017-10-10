<template>
    <div class="testReportPrinting">
      <el-row>
        <el-button type="primary" class="return_btn" @click="returnFlowchart"><img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png" alt=""><span class="returnTxt">返回流程图</span></el-button>
      </el-row>
      <el-row class="examManager_row">
        <span>报表类型：</span>
        <el-select @change="changeData" v-model="reportType" placeholder="请选择" class="testNumber">
          <el-option
            v-for="(item,index) in testNumbers"
            :key="item.value"
            :label="item.label"
            :value="index">
          </el-option>
        </el-select>
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
      <el-row v-if="reportTypeName">
        <h2>{{reportTypeName}}</h2>
        <el-row class="alertsList">
          <el-table
            :data="tableData"
            style="width: 100%"
            border
            @sort-change="sort"
          >
            <el-table-column
              prop="id"
              label="序号">
            </el-table-column>
            <el-table-column
              prop="type"
              label="考场">
            </el-table-column>
            <el-table-column
              prop="publisher"
              label="人数">
            </el-table-column>
            <el-table-column
              prop="publisher"
              label="列数">
            </el-table-column>
            <el-table-column
              prop="publisher"
              label="备注">
            </el-table-column>
          </el-table>
        </el-row>
        <el-row class="pageAlerts">
          <el-pagination
            @current-change="handleCurrentChange"
            :current-page.sync="currentPage"
            :page-size="pageALl"
            layout="prev, pager, next, jumper"
            :total="1000">
          </el-pagination>
        </el-row>
      </el-row>
    </div>
</template>
<script>
    export default{
        data(){
            return {
              testNumbers: [{
                value: '选项1',
                label: '省考号'
              }, {
                value: '选项2',
                label: '市考号'
              }, {
                value: '选项2',
                label: '校考号'
              }],
              reportType: '',
              reportTypeName:'',
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
              }],
              searchValue:'',
              currentPage: 1,
              pageALl: 100
            }
        },
        methods: {
          changeData(){
              this.reportTypeName=this.testNumbers[this.reportType].label;
            console.log(this.reportType);
          },
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
          returnFlowchart(){
              this.$router.push('/examManagerHome');
          }
        }
    }
</script>
<style>
  .testReportPrinting h2{
    font-size:1.5rem;
    margin-bottom:2rem;
    text-align: center;
  }
  .testReportPrinting .alertsList{
    width:60%;
    margin:auto;
  }
  .testReportPrinting .alertsList .el-table th{
    background-color: #deeefe;
    height:2.5rem;
  }
  .testReportPrinting .alertsList .el-table td{
    height:2.2rem;
  }
  .testReportPrinting .alertsList .el-table__footer-wrapper thead div,.testReportPrinting .alertsList .el-table__header-wrapper thead div{
    background-color: #deeefe;
    color: inherit;
  }
</style>
