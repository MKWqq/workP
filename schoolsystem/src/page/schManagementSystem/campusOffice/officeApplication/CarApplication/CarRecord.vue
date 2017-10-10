<template>
  <div class="DocumentRecord">
    <h3>用车申请记录</h3>
    <el-row>
      <el-col class="LeaveRecord-title">
        <!--时间段-->
        <el-col :span="24">
          <el-col :span="2">时间段：</el-col>
          <el-col :span="3" style="margin-left: -3rem">
            <el-date-picker
              v-model="startvalue" type="date" :picker-options="pickerOptions0" style="width: 100%">
            </el-date-picker>
          </el-col>
          <el-col :span="1"  style="text-align: center">_</el-col>
          <el-col :span="3">
            <el-date-picker
              v-model="endvalue" type="date" :picker-options="pickerOptions1" style="width: 100%">
            </el-date-picker>
          </el-col>
          <el-col :span="1">
            <el-button type="primary" icon="search" class="LeaveRecord-search" @click="getRecord()">查询</el-button>
          </el-col>
        </el-col>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="17" class="alertsBtn" style="margin-top: 0">
        <el-button-group style="margin-top:1.8rem">
          <el-button class="delete" title="导出">
            <img class="delete_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
                 alt="">
            <img class="delete_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
                 alt="">
          </el-button>
          <el-button class="delete" title="删除">
            <img class="delete_unactive" src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete.png" alt="">
            <img class="delete_active" src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete_highlight.png" alt="">
          </el-button>
          <el-button class="filt" title="复制" style="margin-left: 2rem;">
            <img class="filt_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png"
                 alt="">
            <img class="filt_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png"
                 alt="">
          </el-button>
          <el-button class="filt" title="打印">
            <img class="filt_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png"
                 alt="">
            <img class="filt_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png"
                 alt="">
          </el-button>
        </el-button-group>
      </el-col>
      <el-col :span="5" :offset="2" class="Infor-input-inner" style="margin-top:1.8rem;">
        <el-input style="border-radius:1rem" placeholder="请输入搜索内容" icon="search" v-model="Searchinput" :on-icon-click="handleIconClick"></el-input>
      </el-col>
    </el-row>
    <el-col :span="24">
      <el-row class="alertsList">
        <el-table
          :data="tableData"
          style="width: 100%"
          v-loading.body="isLoading"
          element-loading-text="拼命加载中...">
          <el-table-column
            type="selection"
            width="55"
            @change="chooseAll">
          </el-table-column>
          <el-table-column
            prop="title"
            label="标题"
            align="center">
          </el-table-column>
          <el-table-column
            prop="name"
            label="类型"
            align="center">
          </el-table-column>
          <el-table-column
            prop="createTime"
            label="创建日期"
            align="center">
            <template scope="scope">
              <span>{{scope.row.createTime|formatDate}}</span>
            </template>
          </el-table-column>
          <el-table-column
            prop="result"
            label="审批状态"
            align="center">
            <template scope="scope">
              <span></span>
            </template>
          </el-table-column>
          <el-table-column
            label="操作"
            align="center">
            <template scope="scope">
              <span style="color:#4da1ff;cursor: pointer;" @click="ShowDatils(scope.row)">详情</span>
            </template>
          </el-table-column>
        </el-table>
      </el-row>
      <el-dialog title="用车申请记录详情" :modal="false" size="tiny" :visible.sync="dialogTableVisible">
        <el-col :span="24" style="text-align: center;height:26rem;overflow-y:auto;">
          <div class="LeaveRecord-table">
            <div class="LeaveRecord-dialog-title">#{{dialogData.title}}#</div>
            <el-col :span="24">
              <div class="LeaveRecord-table-div">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">类型</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.proposer}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">创建日期</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.name}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div LeaveRecord-table-div-final">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">审批状态</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.createTime}}</div>
                </el-col>
              </div>
            </el-col>
          </div>
        </el-col>
      </el-dialog>


      <el-row class="pageAlerts">
        <el-pagination
          @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-size="10"
          layout="prev, pager, next, jumper"
          :total="total">
        </el-pagination>
      </el-row>
    </el-col>
  </div>
</template>
<script>
  import req from './../../../../../assets/js/common'
  import Vue from 'vue'
  import formatdata from './../../../../../assets/js/date'
  export default{
    data(){
      return{
        Searchinput: '',
        pickerOptions0: {
          disabledDate(time) {
            return time.getTime() > Date.now();
          }
        },
        pickerOptions1: {
          disabledDate(time) {
            return time.getTime() > Date.now();
          }
        },
        isLoading:false,
        dialogTableVisible: false,
        dialogTableVisibleother:false,
        tableData: [],
        form:{},
        dialogData:[],
        options: [{
          value: '',
        }],
        formLabelWidth: '120px',
        currentPage: 1,
        pageALl: 10,
        total:0,
        checkedAll:false,
        startvalue:new Date(),
        endvalue:new Date(),
        params:{
          title: '',
          name:'',
          type: 'edit',
          content: '',
        }
      }
    },
    created(){
      let param={
        kind:4
      };
      req.ajaxSend('/school/WorkDemand/getName','post',param,(res)=>{
        this.options = res.map(val=>({value:val.name}))
      });
      this.getRecord(1)
    },
    methods:{
      ShowDatils(row){
        this.dialogData=row;
        this.dialogTableVisible = true;
      },
      handleIconClick(){
        console.log("这是模糊查询")
      },
      getRecord(page){
        if(page!==this.currentPage){
          this.currentPage=page;
        }
        this.isLoading=true;
        let
//        startvalue=formatdata.format(this.startvalue,'yyyy-MM-dd'),
          startvalue=formatdata.format(this.startvalue,'2017-09-12'),
          endvalue=formatdata.format(this.endvalue,'yyyy-MM-dd')+'23:59:59',
          param={
            page: page,
            count:10,
            startTime:startvalue,
            endTime: endvalue,
          };
        req.ajaxSend('/school/WorkDemand/LogDoc','post',param,(res)=>{
          if (res.status === -1) {
            this.tableData = [];
            this.isLoading = false;
            return;
          }
          res.data.forEach((val)=>{
            for(let key in val){
              if(typeof val[key] === 'string'&&(val[key].indexOf('[')>-1||val[key].indexOf('{')>-1)){
                val[key] = JSON.parse(val[key]);
              }
            }
//            console.log(JSON.stringify(val,null,4))
          });
          this.tableData =res.data;
          this.total = res.total;
          this.isLoading=false;
        });
      },
      chooseAll(){
        if (this.checkedAll) {
          for (let obj of this.tableData) {
            obj.checked = true;
          }
          $.extend(this.multipleSelection, this.tableData);
        } else {
          for (let obj of this.tableData) {
            obj.checked = false;
          }
          this.multipleSelection = [];
        }
      },
      handleCurrentChange(val) {
        this.currentPage = val;
        this.getRecord(val);
      }
    },
  }
</script>
<style lang="less">
  .DocumentRecord{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .Doc-dia-top{
    margin-top: 1.3rem;
  }
  .LeaveRecord-title{
    margin-top: 2rem;
    padding-bottom: 1.3rem;
    border-bottom: 1px solid #d2d2d2;
  }
  .LeaveRecord-search{
    background: #4da1ff;
    width: 7rem;
    margin-left: 1.6rem;
  }
  .Infor-input-inner .el-input__inner{
    border-radius: 1.2rem;
  }
  .LeaveRecord-table-div{
    width: 100%;
    height: 2.625rem;
    border-top: 1px solid #d2d2d2;
    text-align: center;
    line-height: 2.625rem;
    box-sizing:border-box;
  }
  .LeaveRecord-table-div-final{
    border-bottom: 1px solid #d2d2d2;
  }
  .LeaveRecord-table-div-1{
    border-right: 1px solid #d2d2d2;
  }
  .LeaveRecord-dialog-title{
    display: inline-block;
    margin: auto;
    font-weight: bold;
    font-size: 16px;
    padding-bottom: 1.2rem;
  }
</style>
