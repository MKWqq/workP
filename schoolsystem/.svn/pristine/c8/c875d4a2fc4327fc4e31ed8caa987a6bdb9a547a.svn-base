<template>
  <div class="testNumberSetting testNumberManagement">
    <el-row>
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <span class="breadcrumb"><router-link
        :to="{name:'testNumberSetting',params:{gradeid:selectParam.gradeid,examinationid:selectParam.examinationid}}"
        tag="span">考号调用</router-link><span>|</span><span class="breadcrumb_active">学生考号管理</span></span>
    </el-row>
    <el-row class="examManager_row">
      <el-form :inline="true" class="formInline">
        <el-form-item label="年级：">
          <span>{{gradeListName[selectParam.gradeid]}}</span>
        </el-form-item>
        <el-form-item label="考号：">
          <el-select v-model="selectParam.program" placeholder="请选择" class="testNumber" @visible-change="setState"
                     @change="changeData">
            <el-option
              v-for="item in testNumberTypes"
              :key="item.value"
              :label="item.label"
              :value="item.label">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="参考学生：">
          <span>{{joinTests}}人</span>
        </el-form-item>
        <el-form-item label="有效考号：">
          <span>{{testNumbers}}个</span>
        </el-form-item>
      </el-form>
    </el-row>
    <el-row class="d_line"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
      <el-col :span="18">
        <el-button class="delete" title="导出" @click="operationTable('out')">
          <img class="delete_unactive"
               src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
               alt="">
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
            placeholder="请输入名字"
            icon="search"
            v-model="selectParam.screen"
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
          width="100"
          label="序号">
        </el-table-column>
        <el-table-column
          prop="className"
          label="班级" sortable>
        </el-table-column>
        <el-table-column
          prop="serialNumber"
          label="班级座号" sortable>
        </el-table-column>
        <el-table-column
          prop="name"
          label="姓名" sortable>
        </el-table-column>
        <el-table-column
          :label="selectParam.program">
          <template scope="scope">
            <el-popover trigger="click" placement="top" @show="editTestNumber(scope.$index)"
                        v-model="scope.row.checked">
              <el-row type="flex" align="middle">
                <el-col :span="18">
                  <el-input v-model="editNumber.number"/>
                </el-col>
                <el-col :span="3" class="confirm"><i class="el-icon-check" @click="saveMsg('edit',scope.$index)"></i>
                </el-col>
                <el-col :span="3" class="cancel"><i class="el-icon-close" @click="scope.row.checked=false"></i></el-col>
              </el-row>
              <div slot="reference" class="name-wrapper">
                <span class="editState">{{ scope.row.number }}</span>
              </div>
            </el-popover>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
    <el-row class="testOperation_btn">
      <el-button @click="operationTestNumber('clear')">清空考号</el-button>
      <el-button type="primary" class="c_color" @click="operationTestNumber('生成考号')">生成考号</el-button>
      <el-button type="primary" class="c_color" @click="operationTestNumber('导入考号')">导入考号</el-button>
    </el-row>
    <el-row class="pageAlerts" v-if="tableData">
      <el-pagination
        @current-change="handleCurrentChange"
        :current-page.sync="selectParam.page"
        layout="prev, pager, next, jumper"
        :total="totalNum">
      </el-pagination>
    </el-row>
    <el-dialog
      :title="formTitle"
      :visible.sync="dialogVisible"
      :before-close="handleClose"
      :modal="false">
      <el-row class="testNumber_dialog_body">
        <el-form ref="testNumberForm" :rules="verifyRules" :model="form" label-width="100px" class="testNumber_form"
                 v-if="formTitle=='生成考号'">
          <el-form-item label="考号前缀：" prop="prefix">
            <el-input v-model="form.prefix"></el-input>
          </el-form-item>
          <el-form-item label="生成规则：">
            <el-select v-model="form.rule" placeholder="请选择">
              <el-option v-for="rules in ruleList" :label="rules.label" :key="rules.value"
                         :value="rules.value"></el-option>
            </el-select>
          </el-form-item>
        </el-form>
        <el-row class="testNumber_form" v-if="formTitle=='导入考号'">
          <el-row type="flex" align="middle" class="importTestNumber">
            <el-col :span="5">文件路径：</el-col>
            <el-col :span="12">
              <el-input readonly v-model="templateFile.name"></el-input>
            </el-col>
            <el-col :span="6" :offset="1">
              <div class="uploadFile">
                <el-button type="primary">
                  <img
                    src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_choice.png"
                    alt="">
                  <span>选择文件</span>
                </el-button>
                <input type="file" class="file_input" @change="sendFile">
              </div>
            </el-col>
          </el-row>
          <el-row type="flex" align="middle" class="importTestNumber">
            <el-col :span="5">匹配规则：</el-col>
            <el-col :span="19">
              <el-select v-model="templateMatchRule" placeholder="请选择">
                <el-option label="班级+姓名" value="0"></el-option>
              </el-select>
            </el-col>
          </el-row>
        </el-row>
        <el-row class="testNumber_tips">
          提示：生成考号将覆盖掉原来的考号，如果原来已有考号，请谨慎操作！
        </el-row>
        <el-row class="download" v-if="formTitle=='导入考号'">
          <a href="javascript:void(0)" @click="downTemplate">下载模板</a>
        </el-row>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" v-if="formTitle=='生成考号'" @click="saveMsg('create')">保存</el-button>
        <el-button type="primary" v-if="formTitle=='导入考号'" @click="saveMsg('import')">保存</el-button>
        <el-button @click="dialogVisible = false">取消</el-button>
      </span>
    </el-dialog>
  </div>
</template>
<script>
  import req from '@/assets/js/common'
  export default{
    data(){
      return {
        testNumberTypes: [ {
          value: '选项1',
          label: '省考号'
        }, {
          value: '选项2',
          label: '市考号'
        }, {
          value: '选项2',
          label: '校考号'
        }],
        gradeListName: ['', '一年级', '二年级', '三年级', '四年级', '五年级', '六年级', '初一', '初二', '初三', '高一', '高二', '高三'],
        tableData: [],
        selectParam: {   //查询表格数据的参数
          page: 1,
          limit: 10,
          program: '省考号',   //考试类型
          gradeid: '',
          field: '',   //排序字段
          find: '学生考号管理',
          examinationid: '',
          screen: '',   //搜索框的值
          order: ''   //正序还是倒叙
        },
        totalNum: 0,
        joinTests: 0,
        testNumbers: 0,
        changeState: false,
        dialogVisible: false,
        ruleList: [{
          label: '前缀+流水号',
          value: 1
        }, {
          label: '前缀+班级+座号',
          value: 2
        }, {
          label: '班级+座号',
          value: 3
        }],
        formTitle: '',
        form: {   //生成考号数据
          rule: 1,
          program: '',
          gradeid: '',
          prefix: ''
        },
        verifyRules: {  //生成考号的验证规则
          prefix: [
            {required: true, message: '请输入考试前缀', trigger: 'blur'}
          ]
        },
        editNumber: {
          id: '',
          number: '',
          program: '',
          gradeid: '',
          userid: ''
        },
        templateFile:{   //导入考号数据'
            file:'',
          name:''
        },
        templateMatchRule:'0'  //导入考号匹配规则
      }
    },
    created: function () {
      var routeParam = this.$route.params;
      this.selectParam.gradeid = routeParam.gradeid;
      this.selectParam.examinationid = routeParam.examinationid;
      this.editNumber.userid = this.$store.state.userInfo.userId;
      this.loadData(this.selectParam);
    },
    methods: {
      returnFlowchart(){
        this.$router.push('/examManagerHome');
      },
      goSearch() {  //查询
        this.selectParam.page = 1;
        this.selectParam.order = '';
        this.selectParam.field = '';
        this.loadData(this.selectParam);
      },
      operationTable(type){   //导出、复制、打印数据
        if (type == 'out') {
          req.downloadFile('.testNumberManagement', '/school/Examination/exmanagement/type/exnumber/typename/export?program=' + this.selectParam.program + '&gradeid=' + this.selectParam.gradeid + '&examinationid=' + this.selectParam.examinationid, 'post')
        }
      },
      sort(column){
        this.selectParam.order = column.order || '';
        this.selectParam.field = column.prop || '';
        this.loadData(this.selectParam);
      },
      setState(state){
        this.changeState = state;
      },
      changeData(){
        if (!this.changeState) {
          return false;
        }
        this.selectParam.order = '';
        this.selectParam.field = '';
        this.selectParam.screen = '';
        this.selectParam.page = 1;
        this.loadData(this.selectParam);
      },
      handleCurrentChange(val) {
        this.selectParam.page = val;
        this.loadData(this.selectParam);
      },
      editTestNumber(val){  //打开编辑框
        this.editNumber.number = this.tableData[val].number;
      },
      operationTestNumber(title){   //操作考号
        var self = this;
        if (title != 'clear') {
          self.dialogVisible = true;
          self.formTitle = title;
          self.form.prefix='';
        } else {
          var clearData = {
            gradeid: self.selectParam.gradeid,
            program: self.selectParam.program
          };
          self.$confirm('此操作将清空该年级全部考号，确定继续？', '提示', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning'
          }).then(() => {
            req.ajaxSend('/school/Examination/exmanagement/type/exnumber/typename/exnumberdel', 'post', clearData, function (res) {
              if (res.return) {
                self.$message({
                  type: 'success',
                  message: '清空成功!',
                  showClose: true
                });
                self.selectParam.page = 1;
                self.loadData(self.selectParam);
              } else {
                self.$message({
                  type: 'error',
                  message: '清空失败!',
                  showClose: true
                });
              }
            });
          }).catch(() => {
          });
        }
      },
      downTemplate(){   //下载模板
        req.downloadFile('.testNumberManagement','/school/Examination/exmanagement/type/exnumber/typename/exnumberexport','post');
      },
      sendFile(){   //上传文件
        var file = $('.file_input').prop('files')[0], suffix;
        if (!file) return false;
        suffix = file.name.split('.')[1];
        if (suffix != 'xlsx' && suffix != 'xlsm' && suffix != 'xls') {
          this.$message({
            message: '只能上传xls、xlsx、xlsm格式文件',
            showClose: true
          });
          return false;
        }
        this.templateFile = {
          name: file.name,
          file: file
        };
      },
      handleClose(done) {   //关闭弹框
        done();
      },
      saveMsg(type,idx){
        var self = this;
        if(type=='create'){   //生成考号
          self.$refs['testNumberForm'].validate((valid) => {
            if (valid) {
              self.form.program = self.selectParam.program;
              self.form.gradeid = self.selectParam.gradeid;
              if (self.formTitle == '生成考号') {
                req.ajaxSend('/school/Examination/exmanagement/type/exnumber/typename/exnumberinsert', 'post', self.form, function (res) {
                  if (res.return) {
                    self.$message({
                      type: 'success',
                      message: '生成成功！',
                      showClose: true
                    });
                    self.dialogVisible = false;
                    self.selectParam.order = '';
                    self.selectParam.field = '';
                    self.selectParam.screen = '';
                    self.selectParam.page = 1;
                    self.loadData(self.selectParam);
                  } else {
                    self.$message({
                      type: 'error',
                      message: '生成失败！',
                      showClose: true
                    });
                  }
                });
              }
            } else {
              return false;
            }
          });
        }else if(type=='edit'){   //编辑考号
          self.editNumber.id = self.tableData[idx].id;
          self.editNumber.program = self.selectParam.program;
          self.editNumber.gradeid = self.selectParam.gradeid;
          req.ajaxSend('/school/Examination/exmanagement/type/exnumber/typename/exnumberupin', 'post', self.editNumber, function (res) {
            if (res.return) {
              self.$message({
                type: 'success',
                message: '修改成功！',
                showClose: true
              });
              self.loadData(self.selectParam);
            } else {
              self.$message({
                type: 'error',
                message: '修改失败！',
                showClose: true
              });
            }
          })
        }else{   //导入考号
          var formData = new FormData();
          formData.append('photo', $('.file_input').prop('files')[0]);
          formData.append('gradeid', self.selectParam.gradeid);
          formData.append('program', self.selectParam.program);
          if (!self.templateFile.name) {
            self.$message({
              message: '请先下载模板并选择文件再上传！',
              showClose: true
            });
            return false;
          }
          req.ajaxFile('/school/Examination/exmanagement/type/exnumber/typename/exnumbereimport', 'post', formData, function (res) {
            if (res.return) {
              self.$message({
                type: 'success',
                message: '保存成功！',
                showClose: true
              });
              self.dialogVisible = false;
              self.selectParam.order = '';
              self.selectParam.field = '';
              self.selectParam.screen = '';
              self.selectParam.page = 1;
              self.loadData(self.selectParam);
            } else {
              self.$message({
                type: 'error',
                message: '保存失败，请检查数据格式!',
                showClose: true
              });
            }
          })
        }
      },
      loadData(data){
        var self = this;
        req.ajaxSend('/school/Examination/exmanagement/type/exnumber/typename/exnumberfind', 'post', data, function (res) {
          for (let obj of res.data) {
            obj.checked = false;
          }
          self.tableData = res.data;
          self.totalNum = Number.parseInt(res.page.count);
          self.joinTests = res.num.student;
          self.testNumbers = res.num.number;
        })
      }
    }
  }
</script>
<style>
  .testNumberSetting .download a {
    text-decoration: underline;
  }

  .testNumberManagement .uploadFile {
    position: relative;
  }

  .testNumberManagement .file_input {
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
</style>
