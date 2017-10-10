<template>
  <div class="importGrades">
    <el-row>
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <span class="breadcrumb"><span class="breadcrumb_active">成绩录入</span><span>|</span><router-link
        to="/examManagerHome/authorizedEntry" tag="span">授权他们录入</router-link></span>
    </el-row>
    <el-row class="importGrades_process">
      <el-row class="subjectName">
        <span class="exam_subTitle">文科</span>
      </el-row>
      <el-row class="subjectLists">
        <div class="subject_row" v-for="i in option" :key="i.id">
          <el-row type="flex" align="middle">
            <el-col :span="12">
              <!--<chart :options="i"></chart>-->
              <el-progress :width="100" :stroke-width="10" type="circle" :percentage="i.angle"></el-progress>
            </el-col>
            <el-col :span="12">
              <h6>语文</h6>
              <p>总数：1235</p>
              <p>已录：255</p>
              <p>未录：66</p>
            </el-col>
          </el-row>
          <el-button type="primary" class="import" @click="toNext(i)">成绩录入</el-button>
        </div>
      </el-row>
    </el-row>
    <el-row class="importGrades_process">
      <el-row class="subjectName">
        <span class="exam_subTitle">理科</span>
      </el-row>
      <el-row class="subjectLists">
        <div class="subject_row" v-for="i in option1" :key="i.id">
          <el-row type="flex" align="middle">
            <el-col :span="12">
              <!--<chart :options="i"></chart>-->
              <el-progress :width="100" :stroke-width="10" type="circle" :percentage="i.angle"></el-progress>
            </el-col>
            <el-col :span="12">
              <h6>语文</h6>
              <p>总数：1235</p>
              <p>已录：255</p>
              <p>未录：66</p>
            </el-col>
          </el-row>
          <el-button type="primary" class="import" @click="toNext(i)">成绩录入</el-button>
        </div>
      </el-row>
    </el-row>
  </div>
</template>
<script>
//  import circle from './circleChart.vue'

  export default{
    /*components: {
      'chart': circle
    },*/
    data(){
      return {
        option: [{
          id: 'one',
          angle: 25
        }, {
          id: 'two',
          angle: 25
        }, {
          id: 'three',
          angle: 10
        }, {
          id: 'four',
          angle: 5
        }, {
          id: 'five',
          angle: 36
        }, {
          id: 'six',
          angle: 25
        }],
        option1: [{
          id: 'one1',
          angle: 88
        }, {
          id: 'two1',
          angle: 9
        }, {
          id: 'three1',
          angle: 1
        }, {
          id: 'four1',
          angle: 5
        }, {
          id: 'five1',
          angle: 36
        }, {
          id: 'six1',
          angle: 25
        }]
      }
    },
    methods: {
      returnFlowchart(){
        this.$router.push('/examManagerHome');
      },
      toNext(val){
        console.log(val);
        this.$router.push('/examManagerHome/selfEntry');
      }
    }
  }
</script>
<style>
  .importGrades_process {
    margin-top: 2rem;
  }

  .importGrades .subjectName {
    margin-bottom: 2rem;
  }

  .importGrades .subjectName .exam_subTitle {
    display: inline-block;
    width: 6.25rem;
    height: 2rem;
    line-height:2rem;
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

  .importGrades .subject_row {
    position: relative;
    float: left;
    width: 240px;
    margin-right: 1rem;
    margin-bottom: 30px;
    border: 1px solid #d2d2d2;
    border-radius: 6px;
    padding:20px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }

  .importGrades .subjectLists > div:last-child {
    margin-right: 0;
  }

  .importGrades .subject_row h6,
  .importGrades .subject_row p {
    font-size: .875rem;
    padding-left: 16px;
    margin: 10px 0;
  }
  .importGrades .subject_row .el-button.import{
    position: absolute;
    left:50%;
    -webkit-transform: translateX(-50%);
    -moz-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    -o-transform: translateX(-50%);
    transform: translateX(-50%);
    bottom:-18px;
    border-radius: 20px;
    padding:10px 20px;
  }
</style>
