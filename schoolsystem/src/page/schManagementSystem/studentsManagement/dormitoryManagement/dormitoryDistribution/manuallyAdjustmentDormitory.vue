<template>
    <div class="manuallyAdjustmentDormitory">
      <el-row type="flex" align="middle">
        <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
          src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
          alt=""><span class="returnTxt">返回流程图</span></el-button>
        <h3>手动调整</h3>
      </el-row>
      <el-row type="flex" align="middle" class="manuallyAdjustmentDormitory_rows">
        <span>宿舍类型：</span>
        <el-select v-model="selectParam.type" placeholder="请选择" class="dormitory">
          <el-option
            v-for="item in typeList"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
        <span class="l_gap">宿舍号：</span>
        <el-select v-model="selectParam.level" placeholder="请选择" class="dormitory">
          <el-option
            v-for="item in levelList"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
        <span class="l_gap">姓名：</span>
        <el-input placeholder="" v-model="selectParam.type" class="dormitory"></el-input>
        <el-button type="primary" icon="search" class="l_gap">查询</el-button>
      </el-row>
      <el-row class="d_line manuallyAdjustmentDormitory_row"></el-row>
      <el-row :gutter="20" class="manuallyAdjustmentDormitory_row">
        <el-col :span="10">
          <el-row class="pNum">当前人数/容纳人数</el-row>
          <el-row>
            <el-row class="subjects">
              <div class="subject disable">
                <h5>29 / 30</h5>
                <p>1（九年级）</p>
                <p>九年级一班（男）</p>
                <span class="joinBtn disable">加入宿舍</span>
              </div>
              <div class="subject">
                <h5>29 / 30</h5>
                <p>1（九年级）</p>
                <p>九年级一班（男）</p>
                <span class="joinBtn">加入宿舍</span>
              </div>
              <div class="subject">
                <h5>29 / 30</h5>
                <p>1（九年级）</p>
                <p>九年级一班（男）</p>
                <span class="joinBtn">加入宿舍</span>
              </div>
              <div class="subject">
                <h5>29 / 30</h5>
                <p>1（九年级）</p>
                <p>九年级一班（男）</p>
                <span class="joinBtn">加入宿舍</span>
              </div>
            </el-row>
          </el-row>
        </el-col>
        <el-col :span="14">
          <el-row type="flex" align="middle" class="listHeader">宿舍学生名单（九年级，九一班/男）</el-row>
          <el-row class="studentsList">
            <el-table
              :data="tableData"
              style="width: 100%"
              border
              @sort-change="sort"
              @selection-change="handleSelectionDormitory"
            >
              <el-table-column
                type="selection"
                width="55">
              </el-table-column>
              <el-table-column
                prop="type"
                label="年级">
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="班级">
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="姓名">
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="性别">
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="是否指定到宿舍">
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="备注">
              </el-table-column>
            </el-table>
          </el-row>
          <el-row type="flex" align="middle" class="listHeader">待调整学生名单</el-row>
          <el-row class="studentsList">
            <el-table
              :data="tableData"
              style="width: 100%"
              border
              @sort-change="sort"
              @selection-change="handleSelectionStudent"
            >
              <el-table-column
                type="selection"
                width="55">
              </el-table-column>
              <el-table-column
                prop="type"
                label="年级">
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="班级">
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="姓名">
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="性别">
              </el-table-column>
              <el-table-column
              prop="publisher"
              label="是否指定到宿舍">
            </el-table-column>
              <el-table-column
                prop="publisher"
                label="宿舍楼名称">
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="栋号">
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="宿舍号">
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="备注">
              </el-table-column>
            </el-table>
          </el-row>
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
              multipleSelection1:[],
              multipleSelection2:[],
              adjustmentType:'',
              dormitoryList: [],
              levelList: [],
              typeList: [{
                value: 0,
                label: '男生宿舍'
              }, {
                value: 1,
                label: '女生宿舍'
              }, {
                value: 2,
                label: '综合宿舍'
              }, {
                value: 3,
                label: '其他'
              }],
              selectParam: {
                dormitory: '',
                level: '',
                type: ''
              }
            }
        },
        methods: {
          returnFlowchart(){
            this.$router.go(-1);
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
          handleSelectionDormitory(val) {
            this.multipleSelection1 = val;
          },
          handleSelectionStudent(val) {
            this.multipleSelection2 = val;
          },
          handleCurrentChange(val) {
            this.currentPage = val;
            console.log(`当前页: ${this.currentPage}`);
          }
        }
    }
</script>
<style>
  .manuallyAdjustmentDormitory{
    font-size:14px;
  }
  .manuallyAdjustmentDormitory .manuallyAdjustmentDormitory_row{
    margin:1.25rem 0;
  }
  .manuallyAdjustmentDormitory_rows{
    margin:2rem 0;
  }
  .manuallyAdjustmentDormitory .pNum{
    color: #999999;
  }
  .manuallyAdjustmentDormitory .subject{
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
  .manuallyAdjustmentDormitory .subjects>div:last-child{
    margin-right:0;
  }
  .manuallyAdjustmentDormitory .subject .joinBtn{
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
  .manuallyAdjustmentDormitory .subject.disable{
    border:1px solid #89bcf5;
    -webkit-box-shadow: 0 0 10px 1px #d2d2d2;
    -moz-box-shadow: 0 0 10px 1px #d2d2d2;
    box-shadow: 0 0 10px 1px #d2d2d2;
  }
  .manuallyAdjustmentDormitory .subject .joinBtn.disable{
    background-color: #d2d2d2;
  }
  .manuallyAdjustmentDormitory .subject h5{
    font-size:1.5rem;
    margin-bottom:1.5rem;
  }
  .manuallyAdjustmentDormitory .listHeader{
    height:3.375rem;
    background-color: #89bcf5;
    color: #fff;
    font-size:.875rem;
    padding-left:1rem;
  }
  .manuallyAdjustmentDormitory .studentsList{
    margin-bottom:1rem;
  }
  .manuallyAdjustmentDormitory .studentsList .el-table th{
    background-color: #deeefe;
    height:3rem;
  }
  .manuallyAdjustmentDormitory .studentsList .el-table td{
    height:3rem;
    font-size: .875rem;
  }
  .manuallyAdjustmentDormitory .studentsList .el-table__footer-wrapper thead div, .manuallyAdjustmentDormitory .studentsList .el-table__header-wrapper thead div{
    background-color: #deeefe;
  }
  .manuallyAdjustmentDormitory .l_gap {
    margin-left: 2rem;
  }
  .manuallyAdjustmentDormitory .el-button.l_gap {
    border-radius: 20px;
    padding:10px 1.5rem;
  }
  .manuallyAdjustmentDormitory .dormitory {
    width: 9.375rem;
  }
</style>
