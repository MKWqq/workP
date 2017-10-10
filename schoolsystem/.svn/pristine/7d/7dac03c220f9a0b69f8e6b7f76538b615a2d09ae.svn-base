<template>
  <div class="scoresEntry">
    <el-row type="flex" align="middle" class="subClassDivision_title">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回上一步</span></el-button>
      <h3>成绩录入</h3>
    </el-row>
    <el-row type="flex" align="middle" class="subClassDivision_row">
      <el-col :span="18" class="fileMsg">
        <el-row type="flex" align="middle">
          <span>设置最大分数值：</span>
          <el-input v-model="filePath.name" placeholder="" class="scores"></el-input>
          <span class="l_span">文件路径：</span>
          <el-input readonly v-model="filePath.name" placeholder="" class="fileName"></el-input>
          <div class="uploadFile">
            <el-button type="primary">
              <img src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_choice.png"
                   alt="">
              <span>选择文件</span>
            </el-button>
            <input type="file" accept=".xlsx,.xlsm,.xls" class="file_input" @change="sendFile">
          </div>
        </el-row>
      </el-col>
      <el-col :span="6" class="saveFile">
        <el-button type="primary">保存</el-button>
      </el-col>
    </el-row>
    <el-row class="d_line"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
      <el-col :span="18">
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
      </el-col>
      <el-col :span="6">
        <div class="g-fuzzyInput">
          <el-input
            placeholder="请选择日期"
            icon="search"
            v-model="searchValue"
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
          type="index"
          label="序号"
          width="100">
        </el-table-column>
        <el-table-column
          prop="type"
          label="年级" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="班级" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="姓名" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="考号" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="全卷（分）" sortable>
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
        searchValue: '',
        currentPage: 1,
        pageALl: 100,
        filePath:{
            name:''
        }
      }
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
      operationData(type){

      }
    }
  }
</script>
<style>
  .scoresEntry .alertsBtn{
    margin:1.25rem 0;
  }
  .scoresEntry .fileMsg .fileName.el-input {
    width: 15.625rem;
    margin-right: 10px;
  }
  .scoresEntry .fileMsg .scores.el-input {
    width: 6.25rem;
    margin-right: 10px;
  }

  .scoresEntry .fileMsg .el-button {
    padding: 0;
    width: 7.5rem;
    font-size: .875rem;
    height: 30px;
    background-color: #099f9b;
    border-color: #099f9b;
  }

  .scoresEntry .fileMsg .el-input__inner {
    height: 30px;
    font-size: .875rem;
  }

  .scoresEntry .uploadFile {
    display: inline-block;
    position: relative;
    margin-right: 10px;
  }

  .scoresEntry .uploadFile .file_input {
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
  .scoresEntry .l_span{
    margin-left:2.5rem;
  }
  .saveFile{
    text-align: right;
  }
  .saveFile .el-button{
    border-radius: 20px;
    width:6.25rem;
  }
</style>
