<template>
  <div class="dormitoryBulkImport">
    <el-row type="flex" align="middle">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回</span></el-button>
      <h3>批量导入</h3>
    </el-row>
    <el-row type="flex" align="middle" class="dormitoryBulkImport_row">
      <el-col :span="18" class="fileMsg">
        <span>文件路径：</span>
        <el-input readonly v-model="filePath.name" placeholder=""></el-input>
        <div class="uploadFile">
          <el-button type="primary">
            <img src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_choice.png"
                 alt="">
            <span>选择文件</span>
          </el-button>
          <input type="file" accept=".xlsx,.xlsm,.xls" class="file_input" @change="sendFile">
        </div>
        <el-button type="primary" @click="operationData('downloadTemplate')">
          <img src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_download.png"
               alt="">
          <span>下载模板</span>
        </el-button>
      </el-col>
      <el-col :span="6" class="bulkImport_btn">
        <el-button type="primary" @click="operationData('upload')">
          <img src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_upload.png"
               alt="">
          <span>上传</span>
        </el-button>
      </el-col>
    </el-row>
    <el-row class="d_line"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
      <el-col :span="18">
        <el-button class="delete" title="导出" @click="operationData('out')">
          <img class="delete_unactive"
               src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png" alt="">
          <img class="delete_active"
               src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
               alt="">
        </el-button>
        <el-button-group class="secBtn-group">
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
      </el-col>
      <el-col :span="6">
        <div class="g-fuzzyInput">
          <el-input
            placeholder="请输入名字/科目"
            icon="search"
            v-model="selectParam.value"
            :on-icon-click="goSearch">
          </el-input>
        </div>
      </el-col>
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        style="width: 100%"
        @sort-change="sort"
      >
        <el-table-column
          prop="name"
          label="栋号"
          sortable>
        </el-table-column>
        <el-table-column
          prop="sex"
          label="宿舍楼名称"
          sortable>
        </el-table-column>
        <el-table-column
          prop="jobNumber"
          label="楼层"
          sortable>
        </el-table-column>
        <el-table-column
          prop="teachingSubjects"
          label="宿舍号"
          sortable>
        </el-table-column>
        <el-table-column
          prop="politics"
          label="宿舍名称"
          sortable>
        </el-table-column>
        <el-table-column
          prop="phone"
          label="宿舍类型">
        </el-table-column>
        <el-table-column
          prop="phone"
          label="容纳人数">
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
  </div>
</template>
<script>
  import req from '@/assets/js/common'
  export default{
    data(){
      return {
        filePath: {},
        tableData: [],
        selectParam: {
          page: 1,
          pageSize: 10,
          sort: '',
          sortType: '',
          value: ''
        },
        totalNum: 0
      }
    },
    created: function () {
      this.loadDataList(this.selectParam);
    },
    methods: {
      returnFlowchart(){
          this.$router.go(-1);
      },
      sendFile(){   //上传文件
        var file = $('.file_input').prop('files')[0], suffix;
        suffix = file.name.split('.')[1];
        if (!file) return false;
        if (suffix != 'xlsx' && suffix != 'xlsm' && suffix != 'xls') {
          this.$message({
            message: '只能上传xls、xlsx、xlsm格式文件',
            showClose: true
          });
          return false;
        }
        this.filePath = {
          name: file.name,
          file: file
        };
      },
      operationData(type){
        var self = this;
        var formData = new FormData();
        if (type == 'downloadTemplate') {
          req.downloadFile('.bulkImport', '/school/user/userGl?type=download&downType=teacher', 'post');
        } else if (type == 'upload') {
          formData.append('userFile', $('.file_input').prop('files')[0]);
          if (!self.filePath.name) {
            self.$message({
              message: '请先下载模板并选择文件再上传！',
              showClose: true
            });
            return false;
          }
          req.ajaxFile('/school/user/userGl?type=export&roleNameEn=js', 'post', formData, function (res) {
            if (res.statu == 1) {
              self.$message({
                type: 'success',
                message: '上传成功！',
                showClose: true
              });
              self.selectParam.page = 1;
              self.selectParam.sort = '';
              self.selectParam.sortType = '';
              self.loadDataList(self.selectParam);
            } else {
              self.$message({
                type: 'error',
                message: '上传失败，请检查数据格式!',
                showClose: true
              });
            }
          })
        } else if (type == 'out') {
          req.downloadFile('.bulkImport', '/school/user/exportTeacherOrZg?type=teacher', 'post');
        }
      },
      goSearch() {  //查询
        this.selectParam.page = 1;
        this.selectParam.sort = '';
        this.selectParam.sortType = '';
        this.loadDataList(this.selectParam);
      },
      sort(column){
        this.selectParam.sort = column.order || '';
        this.selectParam.sortType = column.prop || '';
        this.loadDataList(this.selectParam);
      },
      handleCurrentChange(val) {
        this.selectParam.page = val;
        this.loadDataList(this.selectParam);
      },
      handleClose(done) {   //关闭弹框
        done();
      },
      loadDataList(data){
        var self = this;
        req.ajaxSend('/school/user/userGl?type=teacherList', 'get', data, function (res) {
          self.tableData = res.data;
          self.totalNum = res.count;
        })
      }
    }
  }
</script>
<style>
  .dormitoryBulkImport {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .dormitoryBulkImport .return_btn.el-button--primary{
    background-color: #ff8686;
    border-color: #ff8686;
    border-radius: 20px;
    padding:10px 25px;
  }
  .dormitoryBulkImport .return_btn.el-button--primary .returnTxt{
    margin-left:10px;
  }
  .dormitoryBulkImport .return_btn+h3{
    font-size:1.25rem;
    display: inline-block;
    margin-left:2rem;
  }

  .dormitoryBulkImport .dormitoryBulkImport_row{
    margin:2rem 0 1.25rem 0;
  }
  .dormitoryBulkImport .g-fuzzyInput {
    float: right;
  }

  .dormitoryBulkImport .alertsBtn {
    margin: 1.25rem 0;
  }

  .dormitoryBulkImport .alertsList {
    text-align: center;
  }

  .dormitoryBulkImport .el-table th {
    text-align: center;
  }
  .dormitoryBulkImport .bulkImport_btn {
    text-align: right;
  }

  .dormitoryBulkImport .bulkImport_btn .el-button {
    padding: 0;
    height: 30px;
    border-radius: 15px;
    width: 100px;
    font-size: .875rem;
  }

  .dormitoryBulkImport .fileMsg .el-input {
    width: 15.625rem;
    margin-right: 10px;
  }

  .dormitoryBulkImport .fileMsg .el-button {
    padding: 0;
    width: 7.5rem;
    font-size: .875rem;
    height: 30px;
    background-color: #099f9b;
    border-color: #099f9b;
  }

  .dormitoryBulkImport .fileMsg .el-input__inner {
    height: 30px;
    font-size: .875rem;
  }

  .dormitoryBulkImport .uploadFile {
    display: inline-block;
    position: relative;
    margin-right: 10px;
  }

  .dormitoryBulkImport .uploadFile .file_input {
    width: 100%;
    height: 30px;
    border-radius: 1.125rem;
    position: absolute;
    right: 0;
    top: 0;
    z-index: 1;
    -moz-opacity: 0;
    -ms-opacity: 0;
    -webkit-opacity: 0;
    opacity: 0; /*css属性——opcity不透明度，取值0-1*/
    filter: alpha(opacity=0); /*兼容IE8及以下--filter属性是IE特有的，它还有很多其它滤镜效果，而filter: alpha(opacity=0); 兼容IE8及以下的IE浏览器(如果你的电脑IE是8以下的版本，使用某些效果是可能会有一个允许ActiveX的提示,注意点一下就ok啦)*/
    cursor: pointer;
  }
</style>
