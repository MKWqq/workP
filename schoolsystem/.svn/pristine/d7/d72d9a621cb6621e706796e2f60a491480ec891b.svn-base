<template>
    <div class="liveSchool">
      <el-row type="flex" align="middle" class="studyingWayApproval_row">
        <el-button type="primary" class="uploadTemplate" @click="changeState">调整为走路</el-button>
      </el-row>
      <el-row class="d_line"></el-row>
      <el-row type="flex" align="middle" class="alertsBtn">
        <el-col :span="18">
          <el-button class="delete" title="导出">
            <img class="delete_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png" alt="">
            <img class="delete_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
                 alt="">
          </el-button>
        </el-col>
        <el-col :span="8">
          <div class="g-fuzzyInput">
            <el-input
              placeholder="请选择日期"
              icon="search"
              v-model="selectParam.searchValue"
              :on-icon-click="goSearch">
            </el-input>
          </div>
        </el-col>
      </el-row>
      <el-row class="alertsList">
        <el-table
          :data="tableData"
          style="width: 100%"
          @selection-change="handleSelectionChange"
          @sort-change="sort"
        >
          <el-table-column
            type="selection"
            width="55">
          </el-table-column>
          <el-table-column
            type="index"
            width="80"
            label="序号">
          </el-table-column>
          <el-table-column
            prop="publisher"
            min-width="100"
            label="考号" sortable>
          </el-table-column>
          <el-table-column
            min-width="100"
            prop="publisher"
            label="姓名" sortable>
          </el-table-column>
          <el-table-column
            min-width="100"
            prop="publisher"
            label="性别" sortable>
          </el-table-column>
          <el-table-column
            min-width="100"
            prop="publisher"
            label="总分" sortable>
          </el-table-column>
          <el-table-column
            prop="publisher"
            min-width="100"
            label="年级" sortable>
          </el-table-column>
          <el-table-column
            prop="publisher"
            min-width="100"
            label="班级" sortable>
          </el-table-column>
          <el-table-column
            prop="publisher"
            min-width="100"
            label="手机号" sortable>
          </el-table-column>
          <el-table-column
            prop="publisher"
            min-width="120"
            label="身份证号" sortable>
          </el-table-column>
          <el-table-column
            prop="publisher"
            min-width="130"
            label="户口所在地" sortable>
          </el-table-column>
          <el-table-column
            prop="publisher"
            min-width="120"
            label="录取类型" sortable>
          </el-table-column>
          <el-table-column
            prop="publisher"
            min-width="100"
            label="备注" sortable>
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
                publisher: 0,
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
              multipleSelection: []
            }
        },
        methods: {
          goSearch(ev) {  //查询
            console.log(ev);
          },
          handleSelectionChange(val) {
            this.multipleSelection = val;
          },
          sort(column){

          },
          handleCurrentChange(val) {
            this.currentPage = val;
            console.log(`当前页: ${this.currentPage}`);
          },
          changeState(){  //是否通过审批
            var self = this;
            if (self.multipleSelection.length == 0) {
              self.$message({
                message: '请选择记录！',
                showClose: true
              });
              return false;
            }
            self.$confirm('确定删除?', '提示', {
              confirmButtonText: '确定',
              cancelButtonText: '取消',
              type: 'warning'
            }).then(() => {

            }).catch(() => {
            });
          }
        }
    }
</script>
<style>
</style>
