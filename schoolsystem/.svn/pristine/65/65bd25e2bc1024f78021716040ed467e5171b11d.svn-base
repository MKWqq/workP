<template>
  <div>
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
        <el-col :span="1" :offset="1">
          <el-button type="primary" icon="search" class="LeaveRecord-search" @click="querryData()">查询</el-button>
        </el-col>
      </el-col>
    </el-col>
    <el-col :span="17" class="alertsBtn">
      <el-button-group>
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
      </el-button-group>
      <el-button-group style="margin-left: 2.1rem">
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
    <el-col :span="5" :offset="2" class="Infor-input-inner" style="margin-top:1.8rem;">
      <el-input style="border-radius:1rem" placeholder="请输入搜索内容" icon="search" v-model="Searchinput" :on-icon-click="handleIconClick"></el-input>
    </el-col>
    <el-col :span="24">
      <el-row class="alertsList">
        <el-table
          :data="tableData"
          style="width: 100%"
          v-loading.body="isLoading"
          element-loading-text="拼命加载中...">
          <el-table-column
            type="selection"
            width="40"
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
          </el-table-column>
          <el-table-column
            prop="createTime"
            label="审批结果"
            align="center">
          </el-table-column>
          <el-table-column
            prop="createTime"
            label="审批意见"
            align="center">
          </el-table-column>
          <el-table-column
            prop="createTime"
            label="审批人"
            align="center">
          </el-table-column>
        </el-table>
      </el-row>
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
  import formatdata from './../../../../../assets/js/date'
  export default{
    data(){
      return{
        Searchinput: '',
        changecolor:0,
        isLoading:false,
        dialogTableVisible: false,
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
        startvalue:new Date(),
        endvalue:new Date(),
        tableData: [
          {name:'1111'},
          {name:'1111'},
          {name:'1111'},
          {name:'1111'},
        ],
        checkedAll:false,
        currentPage: 1,
        pageALl: 10,
        total:0,
        order:'createTime desc',
        type:'',
        opinion:'',
        id:''
      }
    },
    created(){
      this.querryData(1);
    },
    methods:{
      handleIconClick(){

      },
      querryData(page){
        if(page!==this.currentPage){
          this.currentPage=page;
        }
        this.isLoading=true;
        let startvalue=formatdata.format(this.startvalue,'yyyy-MM-dd');
        let endvalue=formatdata.format(this.endvalue,'yyyy-MM-dd');
        let param = {
          page: this.currentPage,
          whether: 1,
          count: 10,
          startTime:startvalue,
          endTime: endvalue,
          id:this.id
        };
//        req.ajaxSend('/school/TeacherLeave/approve','post',param,(res)=>{
//          if(res.status===-1){
//            this.tableData=[];
//            this.isLoading=false;
//            return;
//          }
//          res.data.forEach((val)=>{
//            val.createTime=new Date((val.createTime)*1000);
//            val.createTime=formatdata.format(val.createTime,'yyyy-MM-dd HH:mm:ss');
//            val.startTime=new Date((val.startTime)*1000);
//            val.startTime=formatdata.format(val.startTime,'yyyy-MM-dd HH:mm:ss');
//          });
//          this.tableData =res.data;
//          this.total = res.total;
        this.isLoading=false;
//        });
      },
      handleCurrentChange(val) {
        this.currentPage = val;
        this.querryData(val);
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
    }
  }

</script>
<style scoped></style>
