<template>
  <div class="viewAlerts">
    <h3>查看通知</h3>
    <el-row class="alertsBtn">
      <el-col :span="18">
        <el-button class="delete" title="删除" @click="deleteAlerts">
          <img class="delete_unactive"
               src="../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete.png" alt="">
          <img class="delete_active"
               src="../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete_highlight.png"
               alt="">
        </el-button>
      </el-col>
      <el-col :span="6">
        <div class="g-fuzzyInput">
          <el-input
            placeholder="请输入标题/发布者/部门"
            icon="search"
            v-model="selectParam.key"
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
          label="标题"
          prop="title"
          sortable
          show-overflow-tooltip>
          <template scope="scope">
            <div class="alertTitle" @click="showAlertDetail(scope.row,scope.$index)">{{scope.row.title}}</div>
          </template>
        </el-table-column>
        <el-table-column
          label="类型"
          prop="kind"
          sortable>
          <template scope="scope">
            <span v-if="scope.row.kind==1">通知</span>
            <span v-if="scope.row.kind==2">公告</span>
            <span v-if="scope.row.kind==3">通报</span>
            <span v-if="scope.row.kind==4">决议</span>
          </template>
        </el-table-column>
        <el-table-column
          prop="creator"
          label="发布者"
          sortable>
        </el-table-column>
        <el-table-column
          prop="department"
          label="发布部门"
          sortable>
        </el-table-column>
        <el-table-column
          prop="createTime"
          label="发布时间"
          sortable>
          <template scope="scope">
            <span>{{scope.row.createTime | formatDate}}</span>
          </template>
        </el-table-column>
        <el-table-column
          prop="status"
          label="查阅状态">
        </el-table-column>
      </el-table>
    </el-row>
    <el-row class="pageAlerts" v-if="tableData.length!=0">
      <el-pagination
        @current-change="handleCurrentChange"
        :current-page.sync="selectParam.page"
        layout="prev, pager, next, jumper"
        :total="totalNum">
      </el-pagination>
    </el-row>
    <el-dialog
      title="查看通知"
      :visible.sync="dialogVisible"
      :before-close="handleClose"
      :modal="false" class="alertDetail">
      <h3 class="alertDetail_title">{{actData.title}}</h3>
      <el-row class="alertDetail_subTitle" :gutter="10">
        <el-col :span="5">发布者：{{actData.creator}}</el-col>
        <el-col :span="7" class="alertDetail_subTitle_part">发布部门：{{actData.department}}</el-col>
        <el-col :span="12" class="alertDetail_subTitle_time">发布时间：{{actData.createTime|formatDate}}</el-col>
      </el-row>
      <el-row class="alertDetail_center">
        <div v-html="actData.content"></div>
      </el-row>
      <el-row>
        <el-button class="alertDetail_annex" type="primary"  @click="download(actData.id)">附件下载</el-button>
      </el-row>
      <el-row class="alertDetail_list clear_fix">
        <div v-for="actImg in actData.accessory">
          <img src="../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_word.png" alt="" v-if="actImg.split('.')[1]=='doc'||actImg.split('.')[1]=='docx'">
          <img src="../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_ppt.png" alt="" v-if="actImg.split('.')[1]=='ppt'">
          <img src="../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_excel.png" alt="" v-if="actImg.split('.')[1]=='xlsx'||actImg.split('.')[1]=='xlsm'">
          <span :title="actImg">{{actImg}}</span>
        </div>
      </el-row>
    </el-dialog>
  </div>
</template>
<script>
  import req from '@/assets/js/common'

  export default{
    data(){
      return {
        tableData: [],
        totalNum: 0,
        multipleSelection: [],
        msg:'javascript:void(0);',
        dialogVisible: false,
        selectParam: {
          order: {},
          key: '',
          count: 10,
          page: 1
        },
        actData: {}
      }
    },
    computed: {},
    created: function () {
      this.loadDataList(this.selectParam);
    },
    methods: {
      goSearch() {  //查询
        this.selectParam.page = 1;  //清空之前的筛选条件
        this.selectParam.order = {};
        this.loadDataList(this.selectParam);
      },
      handleSelectionChange(val) {
        this.multipleSelection = val;
      },
      sort(column){
        var self = this;
        self.selectParam.order={};
        switch (column.order) {
          case "descending":
            column.order = 'desc';
            self.selectParam.order[column.prop] = column.order;
            break;
          case "ascending":
            column.order = 'asc';
            self.selectParam.order[column.prop] = column.order;
            break;
          default:
            break;
        }
        self.loadDataList(self.selectParam);
      },
      handleCurrentChange(val) {
        this.selectParam.page = val;
        this.loadDataList(this.selectParam);
      },
      handleClose(done) {   //关闭弹框
        done();
      },
      showAlertDetail(data, idx){
        var toData = {
          type: 'check',
          nid: data.id
        };
        var self = this;
        self.actData = data;
        self.dialogVisible = true;
        if (self.tableData[idx].status == '未查阅') {
          req.ajaxSend('/school/Notification/lists', 'post', toData, function (res) {
            if (res.status == 1) {
              self.tableData[idx].status = '已查阅';
            }
          })
        }
      },
      deleteAlerts(){
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
          var ary = [], data;
          for (let obj of self.multipleSelection) {
            ary.push(obj.id);
          }
          data = {
            type: 'del',
            ids: ary
          };
          req.ajaxSend('/school/Notification/lists', 'post', data, function (res) {
            if (res.status == 1) {
              self.$message({
                type: 'success',
                message: '删除成功!',
                showClose: true
              });
              self.selectParam.page = 1;
              self.loadDataList(self.selectParam);
            } else {
              self.$message({
                type: 'error',
                message: '删除失败!',
                showClose: true
              });
            }
          });
        }).catch(() => {
        });
      },
      download(id){
        req.downloadFile('.viewAlerts','/school/Notification/lists?type=download&nid='+id,'post');
      },
      loadDataList(data){
        var self = this;
        req.ajaxSend('/school/Notification/lists', 'post', data, function (res) {
          self.tableData = res.data;
          self.totalNum = res.total;
        })
      }
    }
  }
</script>
<style>
  .viewAlerts {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .viewAlerts h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
  }

  .viewAlerts .g-fuzzyInput {
    float: right;
  }

  .alertDetail .el-dialog__body {
    padding: 1rem 20px;
  }

  h3.alertDetail_title {
    text-align: center;
    margin-bottom: 1rem;
    font-size: 1rem;
  }

  .alertDetail_subTitle {
    font-size: 12px;
    padding: .8rem 0;
    border-top: 1px solid #dcdcdc;
    border-bottom: 1px solid #dcdcdc;
  }

  .alertDetail_subTitle_part {
    text-align: center;
  }

  .alertDetail_subTitle_time {
    text-align: right;
  }

  .alertDetail_center {
    min-height: 10rem;
    padding: 1.875rem 0;
  }

  .alertDetail_annex {
    border-radius: 0 18px 18px 0;
    -webkit-box-shadow: 0 5px 5px 1px #d2d2d2;
    -moz-box-shadow: 0 5px 5px 1px #d2d2d2;
    box-shadow: 0 5px 5px 1px #d2d2d2;
  }

  .alertDetail_list {
    margin-top: 1.875rem;
  }

  .alertDetail_list > div {
    float: left;
    border: 1px solid #fff;
    margin-right: 1.25rem;
    padding: 5px 10px;
  }

  .alertDetail_list > div:hover {
    border: 1px solid #d2d2d2;
    /*cursor: pointer;*/
  }

  .alertDetail_list > div > span {
    display: inline-block;
    max-width: 100px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-left: 8px;
  }

  .alertDetail .el-dialog__footer {
    -webkit-box-shadow: 0 -10px 20px -5px #d2d2d2;
    -moz-box-shadow: 0 -10px 20px -5px #d2d2d2;
    box-shadow: 0 -10px 20px -5px #d2d2d2;
    margin-top: 1rem;
    padding: 1rem 0;
  }

  .viewAlerts .el-dialog--small {
    width: 554px;
  }
</style>
