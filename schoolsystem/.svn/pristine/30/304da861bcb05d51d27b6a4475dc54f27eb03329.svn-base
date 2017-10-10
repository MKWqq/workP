<template>
    <div class="abnormalMotionDetail">
      <h3>异动明细</h3>
      <el-row class="abnormalMotionDetail_row">
        <el-form ref="form" :inline="true" :model="form" label-width="100px" class="abnormalMotionDetail_form">
          <el-form-item label="档案时间：">
            <el-col :span="11">
              <el-date-picker type="date" :editable="false" placeholder="选择日期" v-model="form.date1" style="width: 100%;"></el-date-picker>
            </el-col>
            <el-col class="line" :span="2">-</el-col>
            <el-col :span="11">
              <el-date-picker type="date" :editable="false" placeholder="选择时间" v-model="form.date2" style="width: 100%;"></el-date-picker>
            </el-col>
          </el-form-item>
          <el-form-item>
            <el-button icon="search" type="primary">查询</el-button>
          </el-form-item>
        </el-form>
      </el-row>
      <el-row class="d_line abnormalMotionDetail_row"></el-row>
      <el-row type="flex" justify="end" class="alertsBtn">
        <div class="g-fuzzyInput">
          <el-input
            placeholder="请选择日期"
            icon="search"
            v-model="selectParam.searchValue"
            :on-icon-click="goSearch">
          </el-input>
        </div>
      </el-row>
      <el-row class="alertsList">
        <el-table
          :data="tableData"
          style="width: 100%"
        >
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
            label="异动类型">
          </el-table-column>
          <el-table-column
            prop="publisher"
            label="更新时间">
          </el-table-column>
          <el-table-column
            label="操作">
            <template scope="scope">
              <span class="edit" @click="showDetail(scope.$index)">异动详情</span>
            </template>
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
        title="异动详情"
        :visible.sync="dialogVisible"
        :modal="false"
        :before-close="handleClose">
        <el-row class="detail">
          <el-row>
            <el-row class="into_row">
              <span class="into_subTitle">维修结果</span>
            </el-row>
            <el-row>
              <el-col :span="12">
                <el-form label-width="100px">
                  <el-form-item label="姓名：">
                    <span>张三</span>
                  </el-form-item>
                  <el-form-item label="性别：">
                    <span>女</span>
                  </el-form-item>
                  <el-form-item label="学籍号：">
                    <span>123456789</span>
                  </el-form-item>
                </el-form>
              </el-col>
              <el-col :span="12">
                <el-form label-width="100px">
                  <el-form-item label="身份证类型：">
                    <span>身份证</span>
                  </el-form-item>
                  <el-form-item label="身份证号：">
                    <span>1234567895636656</span>
                  </el-form-item>
                  <el-form-item label="户籍所在地：">
                    <span>123456789</span>
                  </el-form-item>
                </el-form>
              </el-col>
            </el-row>
          </el-row>
          <el-row>
            <el-row class="into_row">
              <span class="into_subTitle">账号信息</span>
            </el-row>
            <el-row>
              <el-col :span="12">
                <el-form label-width="100px">
                  <el-form-item label="学生账号：">
                    <span>张三</span>
                  </el-form-item>
                  <el-form-item label="家长账号：">
                    <span>女</span>
                  </el-form-item>
                </el-form>
              </el-col>
              <el-col :span="12">
                <el-form label-width="100px">
                  <el-form-item label="密码：">
                    <span>123456</span>
                  </el-form-item>
                  <el-form-item label="密码：">
                    <span>1234567</span>
                  </el-form-item>
                </el-form>
              </el-col>
            </el-row>
          </el-row>
          <el-row>
            <el-row class="into_row">
              <span class="into_subTitle">转班</span>
            </el-row>
            <el-row>
              <el-col :span="12">
                <el-form label-width="100px">
                  <el-form-item label="原年级：">
                    <span>张三</span>
                  </el-form-item>
                  <el-form-item label="新年级：">
                    <span>女</span>
                  </el-form-item>
                  <el-form-item label="报道日期：">
                    <span>123456789</span>
                  </el-form-item>
                  <el-form-item label="申请理由：">
                    <span>我愿意</span>
                  </el-form-item>
                </el-form>
              </el-col>
              <el-col :span="12">
                <el-form label-width="100px">
                  <el-form-item label="原班级：">
                    <span>身份证</span>
                  </el-form-item>
                  <el-form-item label="新班级：">
                    <span>1234567</span>
                  </el-form-item>
                </el-form>
              </el-col>
            </el-row>
          </el-row>
        </el-row>
        <span slot="footer" class="dialog-footer">
    <el-button type="primary" @click="printList">打印异动确认单</el-button>
  </span>
      </el-dialog>
    </div>
</template>
<script>
    export default{
        data(){
            return {
              tableData: [{
                id: 1,
                title: '今天天气不错啊',
                type: '通知',
                publisher: 1,
                publishPart: 'hjshf',
                date: '2016-05-03 16:16:55',
                vState: '已查阅',
                checked: false
              }, {
                id: 2,
                title: '下雨了',
                type: '通知',
                publisher: 2,
                publishPart: 'hjshf',
                date: '2016-05-03 16:16:55',
                vState: '未查阅',
                checked: false
              }, {
                id: 3,
                title: '那是',
                type: '通知',
                publisher:0,
                publishPart: 'hjshf',
                date: '2016-05-03 16:16:55',
                vState: '已查阅',
                checked: false
              }],
              currentPage: 1,
              pageALl: 100,
              selectParam: {
                grade: '',
                class: '',
                searchValue: ''
              },
              form:{
                  date1:'',
                  date2:''
              },
              dialogVisible: false
            }
        },
        methods: {
          onSearch() {
            console.log('submit!');
          },
          goSearch(ev) {  //查询
            console.log(ev);
          },
          handleCurrentChange(val) {
            this.currentPage = val;
            console.log(`当前页: ${this.currentPage}`);
          },
          handleClose(done) {
            done();
          },
          showDetail(idx){
            console.log(idx);
            this.dialogVisible=true;
          },
          printList(){
            this.dialogVisible=false;
          }
        }
    }
</script>
<style>
  .abnormalMotionDetail {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .abnormalMotionDetail .abnormalMotionDetail_row{
    margin-top:2rem;
  }
  .abnormalMotionDetail .alertsBtn {
    margin: 1.25rem 0;
  }
  .abnormalMotionDetail .alertsList .el-table th, .abnormalMotionDetail .alertsList .el-table td {
    text-align: center;
  }
  .abnormalMotionDetail h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
    display: inline-block;
  }
  .abnormalMotionDetail .el-form--inline .el-form-item{
    margin-right:2rem;
    margin-bottom:0;
  }
  .abnormalMotionDetail .line{
    text-align: center;
  }
  .abnormalMotionDetail .d_line.abnormalMotionDetail_row{
    margin:1.25rem 0;
  }
  .abnormalMotionDetail .abnormalMotionDetail_form .el-button{
    border-radius: 20px;
    padding:10px 25px;
  }
  .abnormalMotionDetail .edit{
    color: #4da1ff;
    cursor: pointer;
  }
  .abnormalMotionDetail .into_row{
    margin:1.625rem 0;
  }
  .abnormalMotionDetail .into_subTitle {
    display: inline-block;
    width: 7.5rem;
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
  .abnormalMotionDetail .detail{
    max-height:400px;
    overflow: auto;
  }
  .abnormalMotionDetail .detail .el-form-item{
    margin-bottom:10px;
  }
  .abnormalMotionDetail .el-dialog--small{
    width:600px;
  }
  .abnormalMotionDetail .el-dialog__footer{
    -webkit-box-shadow: 0 -10px 30px -10px #d2d2d2;
    -moz-box-shadow: 0 -10px 30px -10px #d2d2d2;
    box-shadow: 0 -10px 30px -10px #d2d2d2;
  }
</style>
