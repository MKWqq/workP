<template>
  <div class="newExam">
    <el-row type="flex" align="middle">
      <el-col :span="12">
        <h3>创建考试</h3>
      </el-col>
      <el-col :span="12" class="exam_steps clear_fix">
        <div>
          <div>
            <span class="circle" :class="{'active':examIdx==3}"></span>
          </div>
          <div>考试班级</div>
        </div>
        <div>
          <div>
            <span class="circle" :class="{'active':examIdx==2||examIdx==3}"></span>
          </div>
          <div>分数设置</div>
        </div>
        <div>
          <div>
            <span class="circleBanji active"></span>
          </div>
          <div>创建考试</div>
        </div>
      </el-col>
    </el-row>
    <div class="stepsOne" v-show="examIdx==1">
      <el-row class="newExam_process">
        <el-row class="newExam_processName">
          <span class="exam_subTitle">基本信息</span>
        </el-row>
        <el-row class="newExam_processSpec">
          <el-form :inline="true" :rules="rules" :model="rulesData" ref="ruleForm">
            <el-form-item label="年级：">
              <el-select class="grade" v-model="selectParam.gradeid" placeholder="请选择" @visible-change="setChangeState"
                         @change="changeTempList('grade')">
                <el-option
                  v-for="item in gradeList"
                  :key="item.gradeid"
                  :label="gradeListName[item.name]"
                  :value="item.gradeid">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="考试名称：" prop="examination">
              <el-input class="examName" v-model="rulesData.examination" placeholder="请输入考试名称"></el-input>
            </el-form-item>
            <el-form-item label="时间段：" required>
              <el-row class="tTime">
                <el-col :span="11">
                  <el-form-item prop="startTime">
                    <el-date-picker :editable="false" type="datetime" placeholder="选择日期时间" :picker-options="sTimePicker" v-model="rulesData.startTime"
                                    style="width: 100%;"></el-date-picker>
                  </el-form-item>
                </el-col>
                <el-col :span="2" class="newExam_arrow">
                  <i class="el-icon-caret-right"></i>
                </el-col>
                <el-col :span="11">
                  <el-form-item prop="endTime">
                    <el-date-picker :editable="false" type="datetime" placeholder="选择日期时间" :picker-options="sTimePicker" v-model="rulesData.endTime"
                                    style="width: 100%;"></el-date-picker>
                  </el-form-item>
                </el-col>
              </el-row>
            </el-form-item>
          </el-form>
        </el-row>
      </el-row>
      <el-row class="newExam_process">
        <el-row class="newExam_processName">
          <span class="exam_subTitle">考试科目</span>
        </el-row>
        <el-row class="newExam_processBody">
          <el-form :inline="true" class="templating">
            <el-form-item label="历次考试科目模板：">
              <el-select v-model="selectParam.examinationid" placeholder="请选择" @visible-change="setChangeState"
                         @change="changeTempList('temp')">
                <el-option
                  v-for="(item,index) in templateList"
                  :key="item.examinationid"
                  :label="item.examination"
                  :value="item.examinationid">
                </el-option>
              </el-select>
            </el-form-item>
          </el-form>
        </el-row>
        <el-row :gutter="30" class="newExam_processBody" v-for="(subject,index) in subjectlist" :key="subject.branchid">
          <el-col :span="4">
            <el-row class="arts">{{subject.branch}}：</el-row>
            <el-row>
              <el-col :span="8" class="choose"><span @click="checkedList('all',index,'subjectlist')">全选</span></el-col>
              <el-col :span="8" class="choose anti-election"><span
                @click="checkedList('anti',index,'subjectlist')">反选</span></el-col>
              <el-col :span="8" class="choose"><span @click="checkedList('clear',index,'subjectlist')">清空</span>
              </el-col>
            </el-row>
          </el-col>
          <el-col :span="20" class="newExam_subject">
            <el-button v-for="(data,idx) in subject.subjectlist" key="index" :class="{'active':data.state}"
                       @click="chooseSubject(index,idx,'subjectlist')">{{data.subjectname}}
            </el-button>
          </el-col>
        </el-row>
      </el-row>
      <el-row class="newExam_next">
        <el-button type="primary" @click="nextSteps(2)">下一步</el-button>
      </el-row>
    </div>
    <div class="stepTwo" v-show="examIdx==2">
      <el-row class="newExam_process">
        <el-row class="newExam_processName">
          <span class="exam_subTitle">分数设置</span>
        </el-row>
        <el-row class="newExam_processSpec">
          <el-col :span="12" v-for="data in tableData.data" :key="data.branchid">
            <el-row class="subject">
              <h3>{{data.branch}}</h3>
            </el-row>
            <el-row>
              <el-table
                :data="data.subjectlist"
                border
                style="width: 100%">
                <el-table-column
                  prop="subjectname"
                  label="科目"
                  width="180">
                </el-table-column>
                <el-table-column
                  label="全卷（单科满分）"
                  width="180">
                  <template scope="scope">
                    <input v-model="scope.row.fullcredit" placeholder=""/>
                  </template>
                </el-table-column>
                <el-table-column
                  label="计入总分比例(%)">
                  <template scope="scope">
                    <input v-model="scope.row.proportion" placeholder=""/>
                  </template>
                </el-table-column>
              </el-table>
            </el-row>
          </el-col>
        </el-row>
      </el-row>
      <el-row class="newExam_next">
        <el-button type="primary" @click="prevSteps(1)">上一步</el-button>
        <el-button type="primary" @click="nextSteps(3)">下一步</el-button>
      </el-row>
    </div>
    <div class="stepsThree" v-show="examIdx==3">
      <el-row class="newExam_process">
        <el-row class="newExam_processName">
          <span class="exam_subTitle">考试班级</span>
        </el-row>
        <el-row class="newExam_processBody">
          <el-checkbox v-model="headmaster">邀请班主任确认参考学生</el-checkbox>
        </el-row>
        <el-row :gutter="30" class="newExam_processBody" v-for="(data,index) in classlist" :key="data.branch">
          <el-col :span="4">
            <el-row class="arts">{{data.branch}}：</el-row>
            <el-row>
              <el-col :span="8" class="choose"><span @click="checkedList('all',index,'classlist')">全选</span></el-col>
              <el-col :span="8" class="choose anti-election"><span
                @click="checkedList('anti',index,'classlist')">反选</span></el-col>
              <el-col :span="8" class="choose"><span @click="checkedList('clear',index,'classlist')">清空</span></el-col>
            </el-row>
          </el-col>
          <el-col :span="20" class="newExam_subject">
            <el-button v-for="(classes,idx) in data.classlist" key="idx" :class="{'active':classes.state}"
                       @click="chooseSubject(index,idx,'classlist')">{{classes.classname}}班
            </el-button>
          </el-col>
        </el-row>
      </el-row>
      <el-row class="newExam_next">
        <el-button type="primary" @click="prevSteps(2)">上一步</el-button>
        <el-button type="primary" @click="saveMsg">保 存</el-button>
      </el-row>
    </div>
  </div>
</template>
<script>
  import moment from 'moment'
  import req from '@/assets/js/common'
  export default{
    data(){
      return {
        examIdx: 1, //导航小圆点
        /*步骤一的数据*/
        gradeList: [],
        gradeListName: ['', '一年级', '二年级', '三年级', '四年级', '五年级', '六年级', '初一', '初二', '初三', '高一', '高二', '高三'],
        templateList: [],
        rules: {
          examination: [
            {required: true, message: '请输入考试名称', trigger: 'blur'}
          ],
          startTime: [
            {type: 'date', required: true, message: '请选择时间', trigger: 'blur'}
          ],
          endTime: [
            {type: 'date', required: true, message: '请选择时间', trigger: 'blur'}
          ]
        },
        rulesData:{
          startTime:'',
          endTime:'',
          examination:''
        },
        sTimePicker:{
          disabledDate:function (val) {
            var ms=new Date(val).getTime();
            var cur=new Date().getTime();
            return ms<cur;
          }
        },
        subjectlist: [],
        selectParam: {
          gradeid: '',
          examinationid: 0
        },
        isChange: false,
        /*步骤二的数据*/
        tableData: {},
        /*步骤三的数据*/
        classlist: [],
        headmaster: false,
        /*创建考试提交后台的数据*/
        form: {
          gradeid: '',
          examination: '',
          starttime: '',
          endtime: '',
          data: [],
          headmaster: 0,
          class: []
        }
      }
    },
    computed:{
      /*eTimePicker(){
          var self=this;
          return {
            disabledDate:function (val) {
              console.log(self);
              var ms=new Date(val).getTime();
              var min=new Date(self.rulesData.startTime).getTime();
              return ms<min;
            }
          }
      }*/
    },
    created: function () {
      var self = this;
      req.ajaxSend('/school/Examination/excreat/type/examcreat/typename/grade', 'post', '', function (res) {  //年级列表
        self.gradeList = res;
        self.selectParam.gradeid = res[0].gradeid;
        req.ajaxSend('/school/Examination/excreat/type/examcreat/typename/template', 'post', self.selectParam, function (re) {  //模板列表
          self.templateList = re;
          if (re.length != 0) {
            self.selectParam.examinationid = re[0].examinationid;
          }
          req.ajaxSend('/school/Examination/excreat/type/examcreat/typename/subject', 'post', self.selectParam, function (data) {   //科目列表
            self.subjectlist = data;
          })
        })
      });
    },
    methods: {
      setChangeState(state){   //防止下拉框的change事件在第一次加载是触发
        this.isChange = state;
      },
      changeTempList(type){
        var self = this;
        if (!self.isChange) {
          return false;
        }
        if (type == 'grade') {
          self.selectParam.examinationid = '';
          req.ajaxSend('/school/Examination/excreat/type/examcreat/typename/template', 'post', self.selectParam, function (re) {
            self.templateList = re;
            if (re.length != 0) {
              self.selectParam.examinationid = re[0].examinationid;
            }
            req.ajaxSend('/school/Examination/excreat/type/examcreat/typename/subject', 'post', self.selectParam, function (data) {
              self.subjectlist = data;
            })
          })
        } else {
          req.ajaxSend('/school/Examination/excreat/type/examcreat/typename/subject', 'post', self.selectParam, function (data) {
            self.subjectlist = data;
          })
        }
      },
      chooseSubject(index, idx, name){
        this[name][index][name][idx].state = !this[name][index][name][idx].state;
      },
      checkedList(val, idx, name){
        if (val == 'all') {
          for (let obj of this[name][idx][name]) {
            if (!obj.state) {
              obj.state = true;
            }
          }
        } else if (val == 'anti') {
          for (let obj of this[name][idx][name]) {
            if (obj.state) {
              obj.state = false;
            } else {
              obj.state = true;
            }
          }
        } else {
          for (let obj of this[name][idx][name]) {
            if (obj.state) {
              obj.state = false;
            }
          }
        }
      },
      prevSteps(idx){
        this.examIdx = idx;
      },
      nextSteps(idx){
        var self = this;
        if (idx == 2) {
          self.$refs['ruleForm'].validate((valid) => {
            if (valid) {
              self.form.data = [];
              self.form.gradeid = self.selectParam.gradeid;
              for (let obj of self.subjectlist) {
                let branch = {
                  branchid: obj.branchid,
                  branch: obj.branch,
                  subjectlist: []
                };
                for (let sub of obj.subjectlist) {
                  if (sub.state) {
                    branch.subjectlist.push(sub);
                  }
                }
                self.form.data.push(branch);
              }
              self.examIdx = idx;
              self.tableData = self.form;
            } else {
              return false;
            }
          });
        }
        if (idx == 3) {
          self.examIdx = idx;
          self.headmaster = false;
          var param = {
            gradeid: self.form.gradeid
          };
          req.ajaxSend('/school/Examination/excreat/type/examcreat/typename/clexselect', 'post', param, function (res) {
            for (let ob of res) {
              for (let m of ob.classlist) {
                m.state = false;
              }
            }
            self.classlist = res;
          })
        }
      },
      saveMsg(){
        var self = this;
        self.form.class = [];
        self.form.headmaster = self.headmaster ? 1 : 0;   //是否邀请班主任
        self.form.starttime = moment(self.rulesData.startTime).format('YYYY-MM-DD HH:mm:ss');  //格式化时间
        self.form.endtime = moment(self.rulesData.endTime).format('YYYY-MM-DD HH:mm:ss');
        self.form.examination = self.rulesData.examination;   //考试名称
        for (let obj of self.classlist) {
          for (let mb of obj.classlist) {
            if (mb.state) {
              self.form.class.push(mb.classid);
            }
          }
        }
        self.form.class = self.form.class.join(',');
        req.ajaxSend('/school/Examination/excreat/type/examcreat/typename/exinsert', 'post', self.form, function (res) {
          if (res.return) {
            self.$message({
              type: 'success',
              message: '创建成功!',
              showClose: true
            });
          } else {
            self.$message({
              type: 'error',
              message: '创建失败!',
              showClose: true
            });
          }
        });
      }
    }
  }
</script>
<style>
  /*主页面样式*/
  .newExam {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
    font-size: 14px;
  }

  .newExam h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
  }

  .exam_steps > div {
    float: right;
    text-align: center;
  }

  .exam_steps > div:nth-child(2), .exam_steps > div:nth-child(3) {
    margin-right: 80px;
  }

  .exam_steps .circle, .exam_steps .circleBanji {
    display: inline-block;
    position: relative;
    width: 8px;
    height: 8px;
    background-color: #d2d2d2;
    border-radius: 100%;
  }

  .exam_steps .circle:before {
    content: '';
    display: inline-block;
    position: absolute;
    top: 4px;
    left: -130px;
    width: 130px;
    border-bottom: 1px dashed #d2d2d2;
  }

  .exam_steps .circle.active, .exam_steps .circleBanji.active {
    background-color: #4da1ff;
  }

  .exam_steps .circle.active:before {
    border-bottom: 1px dashed #4da1ff;
  }

  /*步骤样式*/
  .newExam_process {
    margin-top: 3.125rem;
  }

  .newExam_processName .el-button {
    width: 6.25rem;
    height: 2rem;
    padding: 0;
    border-radius: 0 15px 15px 0;
    -webkit-box-shadow: 0 5px 5px 0 #ddd;
    -moz-box-shadow: 0 5px 5px 0 #ddd;
    box-shadow: 0 5px 5px 0 #ddd;
  }

  .newExam_processSpec .el-button--primary {
    background-color: #89bcf5;
    border-color: #89bcf5;
  }

  .newExam_processSpec {
    margin-top: 2rem;
  }

  .newExam_processSpec .grade {
    width: 8.75rem;
  }

  .newExam_processSpec .tTime {
    width: 30rem;
  }

  .newExam_processBody {
    padding: 2rem 0;
    border-bottom: 1px solid #d2d2d2;
  }

  .newExam_processBody .el-form-item {
    margin-bottom: 0;
  }

  .newExam .el-form--inline .el-form-item {
    margin-right: 2.5rem;
  }

  .newExam .el-form--inline .tTime .el-form-item {
    margin-right: 0;
  }

  .examName.el-input, .examName .el-input__inner {
    width: 15.625rem;
  }

  .newExam_arrow {
    color: #797979;
    text-align: center;
    font-size: 12px;
  }

  .newExam .el-icon-time:before {
    content: '';
    display: block;
    -webkit-background-size: contain;
    background-size: contain;
    background-image: url('../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_calendar.png');
    width: 15px;
    height: 15px;
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    -o-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
  }

  .newExam .choose {
    color: #4da1ff;
    text-align: center;
    cursor: pointer;
  }

  .newExam .choose.anti-election {
    border-left: 1px solid #d2d2d2;
    border-right: 1px solid #d2d2d2;
  }

  .arts, .science {
    text-align: center;
    margin-bottom: 2rem;
  }

  .newExam_subject .el-button {
    width: 7.5rem;
    height: 1.875rem;
    padding: 0;
    margin-right: 1.25rem;
    margin-bottom: .5rem;
    margin-top: .5rem;
  }

  .newExam_subject .el-button + .el-button {
    margin-left: 0;
  }

  .newExam_subject .el-button.active {
    border-color: #13b5b1;
    background-color: #13b5b1;
    color: #fff;
  }

  .newExam_next {
    text-align: center;
    margin-top: 3.75rem;
  }

  .newExam_next .el-button {
    width: 7.5rem;
    height: 2.25rem;
    padding: 0;
    border-radius: 1.2rem;
  }

  .newExam .newExam_next .el-button + .el-button {
    margin-left: 3.1rem;
  }

  .newExam .exam_subTitle {
    display: inline-block;
    width: 6.25rem;
    height: 2rem;
    line-height: 2rem;
    padding: 0;
    border-radius: 0 15px 15px 0;
    -webkit-box-shadow: 0 5px 5px 0 #ddd;
    -moz-box-shadow: 0 5px 5px 0 #ddd;
    box-shadow: 0 5px 5px 0 #ddd;
    background-color: #89bcf5;
    border-color: #89bcf5;
    color: #fff;
    text-align: center;
  }

  .stepsOne .newExam_next {
    padding: 0 0 7rem 0;
  }

  .stepTwo .subject {
    text-align: center;
    padding: 1rem 0;
  }

  .stepTwo .el-table--border th {
    border-right: 0;
  }

  .stepTwo .el-table th {
    background-color: #89bcf5;
    height: 3.5rem;
    text-align: center;
  }

  .stepTwo .el-table td {
    text-align: center;
    height: 3rem;
    font-size: .875rem;
  }

  .stepTwo .el-input__inner {
    text-align: center;
    height: 2rem;
  }

  .stepTwo .el-table__footer-wrapper thead div, .stepTwo .el-table__header-wrapper thead div {
    background-color: #89bcf5;
    color: #fff;
  }

  .stepTwo .newExam_next {
    padding: 7rem 0;
  }

  .stepTwo .el-table--enable-row-hover .el-table__body tr:hover > td {
    background: none;
  }

  .stepTwo .el-table input {
    height: 2rem;
    width: 100%;
    border: none;
    text-align: center;
  }

  .stepsThree .el-checkbox__label {
    padding-left: 1.25rem;
  }

  .stepsThree .newExam_next {
    padding: 7rem 0;
  }
</style>
