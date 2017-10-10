<template>
  <div class="selfEntry">
    <el-row>
      <el-button type="primary" class="returnBtn" @click="returnPrev"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回上一步</span></el-button>
    </el-row>
    <el-row type="flex" align="middle" class="examManager_row selfEntry_row">
      <el-form :inline="true" class="formInline">
        <el-form-item label="全卷（单科）满分：">
          <el-input v-model="params.score1"/>
        </el-form-item>
        <el-form-item label="全卷（单科）满分：">
          <el-input v-model="params.score2"/>
        </el-form-item>
        <el-form-item label="班级：">
          <el-select v-model="params.classes" placeholder="请选择" class="g_class">
            <el-option
              v-for="item in testNumbers"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="文件路径：">
          <el-input class="spec" v-model="params.filePath"/>
          <div class="uploadFile">
            <el-button type="primary" class="chFile">
              <img src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_choice.png"
                   alt="">
              <span>选择文件</span>
            </el-button>
            <input type="file" class="file_input" @change="getFileName">
          </div>
        </el-form-item>
      </el-form>
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
          prop="title"
          label="序号" sortable>
        </el-table-column>
        <el-table-column
          prop="type"
          label="班级" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="班级序号" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="考号" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="考场" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="考场座号" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="姓名" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="全卷" sortable>
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
  </div>
</template>
<script>
  export default{
    data(){
      return {
        testNumbers: [{
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
        params: {
          score1: '',
          score2: '',
          classes: '',
          filePath: ''
        },
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
        searchValue: '',
        currentPage: 1,
        pageALl: 100
      }
    },
    methods: {
      returnPrev(){
        this.$router.go(-1);
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
      getFileName(node){
        if (this.fileList.length >= 3) {
          this.$message({
            message: '最多只能上传三个附件！',
            showClose: true
          });
          $('.file_input').val('');
          return false;
        }
        // 实例化一个表单数据对象
        this.formData = new FormData();
        var fileType, suffix;
        // 遍历图片文件列表，插入到表单数据中
        for (var i = 0, file; file = $('.file_input').prop('files')[i]; i++) {
          suffix = file.name.split('.')[1];
          switch (suffix) {
            case 'ppt':
              fileType = 1;
              break;
            case 'docx':
            case 'doc':
              fileType = 2;
              break;
            case 'xlsx':
              fileType = 3;
              break;
            default:
              this.$message('只能上传word、xlsx、ppt格式文件');
              return false;
          }
          this.fileList.push({'fileType': fileType, 'name': file.name});
          this.formData[file.name] = file;
        }
      }
    }
  }
</script>
<style>
  .selfEntry .returnBtn.el-button--primary {
    border-radius: 20px;
  }

  .selfEntry .returnBtn.el-button--primary .returnTxt {
    margin-left: 10px;
  }

  .selfEntry .uploadFile {
    margin-left: .5rem;
  }

  .selfEntry .el-button.chFile {
    background-color: #13b5b1;
    border-color: #13b5b1;
    height: 30px;
    padding: 0 .8rem;
  }

  .selfEntry .g_class, .selfEntry_row .el-input, .selfEntry_row .el-input__inner {
    width: 7.8rem;
  }

  .selfEntry_row .spec.el-input, .selfEntry_row .spec .el-input__inner {
    width: 14rem;
  }

  .selfEntry_row .uploadFile {
    display: inline-block;
    position: relative;
  }

  .selfEntry_row .file_input {
    width: 100%;
    height: 36px;
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

  .selfEntry .formInline .el-form-item {
    margin-right: 1rem;
    margin-bottom: 0;
  }
</style>
