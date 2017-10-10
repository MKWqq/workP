<template>
    <div class="manuallyAdjustment">
      <el-row type="flex" align="middle" class="subClassDivision_title">
        <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
          src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
          alt=""><span class="returnTxt">返回流程图</span></el-button>
        <h3>手动调整</h3>
      </el-row>
      <el-row type="flex" align="middle">
        <span>调整方式：</span>
        <span class="adjustment_btn">
          <span :class="{adjustment_btn_active:adjustmentType=='student'}" @click="changeType('student')">指定学生换班</span>
          <span :class="{adjustment_btn_active:adjustmentType=='adjacent'}" @click="changeType('adjacent')">相邻分数学生换班</span>
        </span>
        <span>
          注：1、相邻分数学生互换，不能跨科类操作。2、跨科类指定学生换班不会影响学生志愿专业
        </span>
      </el-row>
      <el-row class="manuallyAdjustment_row d_line"></el-row>
      <el-row :gutter="20" class="manuallyAdjustment_row">
        <el-col :span="10">
          <el-row class="pNum">当前人数/容纳人数</el-row>
          <el-row class="manuallyAdjustment_row">
            <el-row class="exam_subTitle">文科</el-row>
            <el-row class="subjects">
              <div class="subject disable">
                <h5>29 / 30</h5>
                <p>七年级1重点班</p>
                <span class="joinBtn disable">加入班级</span>
              </div>
              <div class="subject">
                <h5>29 / 30</h5>
                <p>七年级1重点班</p>
                <span class="joinBtn">加入班级</span>
              </div>
              <div class="subject">
                <h5>29 / 30</h5>
                <p>七年级1重点班</p>
                <span class="joinBtn">加入班级</span>
              </div>
              <div class="subject">
                <h5>29 / 30</h5>
                <p>七年级1重点班</p>
                <span class="joinBtn">加入班级</span>
              </div>
            </el-row>
          </el-row>
          <el-row class="manuallyAdjustment_rows">
            <el-row class="exam_subTitle">艺术科</el-row>
            <el-row class="subjects">
              <div class="subject">
                <h5>29 / 30</h5>
                <p>七年级1重点班</p>
                <span class="joinBtn">加入班级</span>
              </div>
              <div class="subject">
                <h5>29 / 30</h5>
                <p>七年级1重点班</p>
                <span class="joinBtn">加入班级</span>
              </div>
              <div class="subject">
                <h5>29 / 30</h5>
                <p>七年级1重点班</p>
                <span class="joinBtn">加入班级</span>
              </div>
              <div class="subject">
                <h5>29 / 30</h5>
                <p>七年级1重点班</p>
                <span class="joinBtn">加入班级</span>
              </div>
            </el-row>
          </el-row>
        </el-col>
        <el-col :span="14">
          <el-row type="flex" align="middle" justify="center" class="listHeader">
            <el-col :span="7">参与分班学生名单</el-col>
            <el-col :span="16">
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
          <el-row class="studentsList">
            <el-table
              :data="tableData"
              style="width: 100%"
              border
              @sort-change="sort"
              @selection-change="handleSelectionChange"
            >
              <el-table-column
                type="selection"
                width="55">
              </el-table-column>
              <el-table-column
                prop="type"
                label="姓名" sortable>
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="性别" sortable>
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="指定班级" sortable>
              </el-table-column>
            </el-table>
          </el-row>
          <!--<el-row class="pageAlerts" v-if="tableData.length!=0">
            <el-pagination
              @current-change="handleCurrentChange"
              :current-page.sync="currentPage"
              :page-size="pageALl"
              layout="prev, pager, next, jumper"
              :total="1000">
            </el-pagination>
          </el-row>-->
        </el-col>
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
              currentPage: 1,
              pageALl: 100,
              searchValue:'',
              multipleSelection:[],
              adjustmentType:''
            }
        },
        methods: {
          returnFlowchart(){
            this.$router.push('/subClassDivisionHome');
          },
          changeType(type){  //切换调整方式
            this.adjustmentType=type;
          },
          goSearch() {  //查询
            console.log(this.searchValue);
          },
          sort(column){
            console.log(column);
          },
          handleSelectionChange(val) {
            this.multipleSelection = val;
          },
          handleCurrentChange(val) {
            this.currentPage = val;
            console.log(`当前页: ${this.currentPage}`);
          }
        }
    }
</script>
<style>
  .manuallyAdjustment{
    font-size:14px;
  }
  .manuallyAdjustment .manuallyAdjustment_row{
    margin:1rem 0;
  }
  .manuallyAdjustment_rows{
    margin:4.5rem 0;
  }
  .manuallyAdjustment .adjustment_btn{
    display: inline-block;
    width:17.5rem;
    height:30px;
    line-height:30px;
    border-radius: 4px;
    border:1px solid #d2d2d2;
    font-size:0;
  }
  .manuallyAdjustment .adjustment_btn+span{
    margin-left:2rem;
  }
  .manuallyAdjustment .adjustment_btn>span{
    width:50%;
    display: inline-block;
    text-align: center;
    font-size:.875rem;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    cursor: pointer;
  }
  .manuallyAdjustment .adjustment_btn>span:first-child{
    border-right:1px solid #d2d2d2;
  }
  .manuallyAdjustment .adjustment_btn span.adjustment_btn_active{
    color: #fff;
    background-color: #09baa7;
  }
  .manuallyAdjustment .pNum{
    color: #999999;
  }
  .manuallyAdjustment .exam_subTitle {
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
  .manuallyAdjustment .subject{
    position: relative;
    float: left;
    width:6.25rem;
    padding:1.25rem 1.25rem 2.5rem 1.25rem;
    border: 1px solid #d2d2d2;
    border-radius: 4px;
    margin-top:2rem;
    text-align: center;
    margin-right:1.25rem;
  }
  .manuallyAdjustment .subjects>div:last-child{
    margin-right:0;
  }
  .manuallyAdjustment .subject .joinBtn{
    position: absolute;
    bottom:-1rem;
    left:50%;
    margin-left:-3.025rem;
    width:6.25rem;
    height:2rem;
    line-height:2rem;
    display: block;
    color: #fff;
    background-color: #4da1ff;
    border-radius: 1.5rem;
    cursor: pointer;
    font-size:.875rem;
  }
  .manuallyAdjustment .subject.disable{
    border:1px solid #89bcf5;
    -webkit-box-shadow: 0 0 10px 1px #d2d2d2;
    -moz-box-shadow: 0 0 10px 1px #d2d2d2;
    box-shadow: 0 0 10px 1px #d2d2d2;
  }
  .manuallyAdjustment .subject .joinBtn.disable{
    background-color: #d2d2d2;
  }
  .manuallyAdjustment .subject h5{
    font-size:1.5rem;
  }
  .manuallyAdjustment .subject p{
    margin:1.5rem 0;
  }
  .manuallyAdjustment .listHeader{
    height:3.375rem;
    background-color: #89bcf5;
    color: #fff;
    font-size:.875rem;
  }
  .manuallyAdjustment .studentsList .el-table th{
    background-color: #deeefe;
    height:3rem;
  }
  .manuallyAdjustment .studentsList .el-table td{
    height:3rem;
    font-size: .875rem;
  }
  .manuallyAdjustment .studentsList .el-table__footer-wrapper thead div, .manuallyAdjustment .studentsList .el-table__header-wrapper thead div{
    background-color: #deeefe;
  }
</style>
