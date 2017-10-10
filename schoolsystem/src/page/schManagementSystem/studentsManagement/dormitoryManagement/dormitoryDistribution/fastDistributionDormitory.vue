<template>
  <div class="distributionDormitoryMsg">
    <el-row type="flex" align="middle">
      <el-col :span="16">
        <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
          src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
          alt=""><span class="returnTxt">返回流程图</span></el-button>
        <h3>快速分配宿舍</h3>
      </el-col>
      <el-col :span="8" class="save">
        <el-button type="primary">保存</el-button>
      </el-col>
    </el-row>
    <el-row class="distributionPersonnel_head">
      <span>成绩规则：</span>
      <el-select class="ruleWith" v-model="selectParam.gradeRule" placeholder="请选择">
        <el-option
          v-for="item in gradeRuleList"
          :key="item.value"
          :label="item.name"
          :value="item.value">
        </el-option>
      </el-select>
      <span class="d_gap">考试：</span>
      <el-select class="ruleWith" v-model="selectParam.test" placeholder="请选择">
        <el-option
          v-for="item in testList"
          :key="item.value"
          :label="item.name"
          :value="item.value">
        </el-option>
      </el-select>
      <span class="d_gap">班级规则：</span>
      <el-select class="ruleWith" v-model="selectParam.classRule" placeholder="请选择">
        <el-option
          v-for="item in classRuleList"
          :key="item.value"
          :label="item.name"
          :value="item.value">
        </el-option>
      </el-select>
      <el-select class="ruleWith d_gap_sm" v-model="selectParam.isCross" placeholder="请选择">
        <el-option
          v-for="item in crossList"
          :key="item.value"
          :label="item.name"
          :value="item.value">
        </el-option>
      </el-select>
      <el-button type="primary" class="d_gap distributionBtn">分配宿舍</el-button>
      <span class="distributionRule d_gap_sm" @click="dialogVisible=true">查看宿舍分配规则</span>
    </el-row>
    <el-row class="d_line distributionPersonnel_row"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
      <el-col :span="14">
        <el-button class="filt" title="导出" @click="operationData('export')">
          <img class="filt_unactive"
               src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
               alt="">
          <img class="filt_active"
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
      <el-col :span="10">
        <div class="g-fuzzyInput">
          <el-input
            placeholder="请输入姓名，宿舍号"
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
        @srot-change="sort"
      >
        <el-table-column
          type="index"
          width="80"
          label="序号">
        </el-table-column>
        <el-table-column
          prop="type"
          min-width="120"
          label="考号" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          min-width="120"
          label="姓名" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          min-width="100"
          label="性别" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          min-width="120"
          label="年级" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          min-width="120"
          label="班级" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          min-width="120"
          label="手机号" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          min-width="150"
          label="户口所在地" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          min-width="120"
          label="生活老师" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          min-width="150"
          label="宿舍楼名称" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          min-width="120"
          label="栋号" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          min-width="120"
          label="楼层" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          min-width="120"
          label="宿舍号" sortable>
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
    <el-dialog
      title="宿舍分配规则"
      :modal="false"
      :visible.sync="dialogVisible"
      :before-close="handleClose">
      <p>
        1、宿舍分配默认男女必须分开。<br><br>
        2、请先选择成绩规则、班级规则。若按成绩分，请从成绩规则里的“按总分降序”、“按总分升序”及“考试”里的某次考试选择出来。若按班级分，请先去本系统的“分科分班”模块中完成分班，再从班级规则里选择一项。若综合成绩和班级分配宿舍，请选择所需的成绩规则和班级规则。<br><br>
        3、班级规则选择按班级升序或按班级降序后：<br>
        （1）班级不交叉：假如宿舍分配后，每个宿舍可容纳6人，而1班剩余5人，则此5人单独住一个宿舍；2班剩余1人，则此1人单独住一个宿舍，以此类推。<br><br>
        （2）连续不间断分配：在宿舍分配时，假如1班剩余5人，则与2班刚开始参与分配宿舍的第1人共同分配至一个宿舍；2班分完后剩余1人，则与3班刚开始参与分配宿舍的第1人至第5人共同分配至一个宿舍，以此类推。<br><br>
        （3）班级剩余人员统一另分： 假如1班剩余5人，2班剩余1人，3班剩余4人，4班剩余2人...在宿舍分配结束后，再来统一分配各班的剩余人员的宿舍。<br><br>
        4、若无固定的宿舍分配方式，成绩规则可选择“随机”，班级规则也选择“随机”。
      </p>
      <span slot="footer" class="dialog-footer">
    <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
  </span>
    </el-dialog>
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
        selectParam:{
            gradeRule:'',
          test:'',
          classRule:'',
          isCross:''
        },
        gradeRuleList:[{
          name:'按总分降序',
          value:0
        },{
          name:'按总分升序',
          value:1
        },{
          name:'随机',
          value:2
        }],
        testList:[],
        classRuleList:[{
          name:'按班级降序',
          value:0
        },{
          name:'按班级升序',
          value:1
        },{
          name:'随机',
          value:2
        }],
        crossList:[{
          name:'班级不交叉',
          value:0
        },{
          name:'连续不间断分配',
          value:1
        },{
          name:'班级剩余人员统一另分',
          value:2
        }],
      dialogVisible: false
      }
    },
    methods: {
      returnFlowchart(){
        this.$router.go(-1);
      },
      operationData(type){
        if (type == 'export') {

        }
      },
      goSearch(ev) {  //查询
        console.log(ev);
      },
      handleCurrentChange(val) {
        this.currentPage = val;
        console.log(`当前页: ${this.currentPage}`);
      },
      sort(column){

      },
      save(){
      },
      handleClose(done) {
        done();
      }
    }
  }
</script>
<style>
  .distributionDormitoryMsg .distributionPersonnel_head {
    margin-top: 2rem;
  }

  .distributionDormitoryMsg .d_gap {
    margin-left: 2rem;
  }
  .distributionDormitoryMsg .d_gap_sm{
    margin-left:1rem;
  }

  .distributionDormitoryMsg .distributionPersonnel_row {
    margin: 1.25rem 0;
  }

  .distributionDormitoryMsg .save .el-button {
    padding: 10px 2.5rem;
    border-radius: 20px;
    float: right;
  }

  .distributionDormitoryMsg .distributionRule {
    color: #4da1ff;
    font-size: .875rem;
    cursor: pointer;
    text-decoration: underline;
  }
  .distributionDormitoryMsg .ruleWith{
    width:9.375rem;
  }
  .distributionDormitoryMsg .distributionBtn{
    padding:10px 2rem;
    border-radius: 20px;
  }
  .distributionDormitoryMsg .el-dialog--small{
    width:600px;
  }
  .distributionDormitoryMsg .el-dialog__footer{
    -webkit-box-shadow: 0 -5px 20px -5px #d2d2d2;
    -moz-box-shadow: 0 -5px 20px -5px #d2d2d2;
    box-shadow: 0 -5px 20px -5px #d2d2d2;
  }
</style>
