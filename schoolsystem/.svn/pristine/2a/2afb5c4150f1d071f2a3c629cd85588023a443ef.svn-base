<template>
  <div class="viewAlerts">
    <h3>发布记录</h3>
    <el-row class="alertsBtn">
      <el-button-group>
        <el-button class="delete" style="margin-top:-1.25rem;" @click="deleteAlerts">
          <img class="delete_unactive" src="../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete.png" alt="">
          <img class="delete_active" src="../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete_highlight.png" alt="">
        </el-button>
      </el-button-group>
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        style="width: 100%"
        @sort-change="sort"
        @selection-change="handleSelectionChange"
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
          sortable="column">
          <template  scope="scope">
            <div>{{scope.row.title}}</div>
          </template>
        </el-table-column>
        <el-table-column
          prop="kind"
          label="类型"
          sortable="column">
          <template  scope="scope">
            <span v-if="scope.row.kind==1">通知</span>
            <span v-if="scope.row.kind==2">通告</span>
            <span v-if="scope.row.kind==3">通报</span>
            <span v-if="scope.row.kind==4">决议</span>
          </template>
        </el-table-column>
        <el-table-column
          prop="draft"
          label="发布状态"
          sortable="column">
          <template  scope="scope">
            <span v-if="scope.row.draft==0">已发布</span>
            <span v-if="scope.row.draft==1">未发布</span>
          </template>
        </el-table-column>
        <el-table-column
          prop="ratio"
          label="查阅进度">
          <template  scope="scope">
            <span v-if="scope.row.draft==0">
              <span>{{scope.row.ratio}}</span>
              <span class="pu-speed" v-if="scope.row.state" @click="showDialogTable(scope.row)">[未查阅名单]</span>
            </span>
          </template>
        </el-table-column>
        <el-table-column
          prop="createTime"
          label="发布时间"
          sortable="column">
        </el-table-column>
      </el-table>
    </el-row>
    <el-dialog title="未查阅名单" :visible.sync="dialogTableVisible" :modal="false" class="pu-dialog">
      <el-col :span="19">
        <el-radio-group v-model="radio" @change="changeData">
          <el-radio :label="0">教师</el-radio>
          <el-radio :label="1">学生及家长</el-radio>
        </el-radio-group>
      </el-col>
      <el-col style="padding-bottom: 1.25rem" :span="5">
        <el-input placeholder="请输入姓名" icon="search" v-model="input2" :on-icon-click="handleIconClick"></el-input>
      </el-col>
      <el-table :data="fakeGridData" v-show="teacherState">
        <el-table-column type="index" label="序号" width="150"></el-table-column>
        <el-table-column property="roleName" label="家长姓名"></el-table-column>
      </el-table>
      <el-table :data="fakeGridData" v-show="!teacherState">
        <el-table-column  type="index" label="序号" width="150"></el-table-column>
        <el-table-column property="grade" label="年级" width="150"></el-table-column>
        <el-table-column property="class" label="班级" width="150"></el-table-column>
        <el-table-column property="name" label="学生姓名" width="200"></el-table-column>
        <el-table-column property="roleName" label="家长姓名"></el-table-column>
      </el-table>
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
  </div>
</template>
<script>
  import req from './../../../../assets/js/common'
  import formatdata from './../../../../assets/js/date'
  export default{
    data(){
      return {
        isLoading:false,
        radio: 0,
        input2: '',
        teacherState:true,
        gridData: [],
        fakeGridData: [],
        dialogTableVisible: false,
        tableData: [],
        checkedAll: false,
        multipleSelection: [],
        isFilter:false,
        currentPage: 1,
        pageALl: 10,
        total:0,
        order:'createTime desc'
      }
    },
    created(){
      this.getList(1);
    },
    methods: {
      getList(page){
        if(page!==this.currentPage){
          this.currentPage=page;
        }
        this.isLoading=true;
        let param={
          page:this.currentPage,
          count:10,
          order:this.order
        };
        req.ajaxSend('/school/Notification/log','post',param, (res)=> {
          if (res.status === -1) {
            this.tableData = [];
            this.isLoading = false;
            return;
          }
          res.data.forEach((val)=>{
            val.createTime=new Date((val.createTime)*1000);
            val.createTime=formatdata.format(val.createTime,'yyyy-MM-dd HH:mm:ss');
            val.checked=false;
            val.state=!val.list;
          });
          this.tableData =res.data;
          this.total = res.total;
          this.isLoading=false;
        });
      },
      handleSelectionChange(val) {
        this.multipleSelection = val.map(val=>{
          val.checked = true;
          return val;
        });
      },
      showDialogTable(row){
        this.dialogTableVisible = true;
        this.gridData = row.list;
        this.fakeGridData = JSON.parse(JSON.stringify(this.gridData));
      },
      handleIconClick() {
        if (this.input2 !== '') {
          this.fakeGridData=this.gridData.filter(val=>{
            return (val.name.indexOf(this.input2)>-1) || (val.roleName.indexOf(this.input2)>-1);
          })
        }else{
          this.fakeGridData = this.gridData;
        }
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
      sort(column){
        this.order = `${column.prop} ${column.order==='ascending'?'asc':'desc'}`;
        this.getList(1);
      },
      handleCurrentChange(val) {
        this.currentPage = val;
        this.getList(val);
//        console.log(`当前页: ${this.currentPage}`);
      },
      deleteAlerts(){
        let that=this;
        let idsarray=[];
        let param={
          type:'del',
          ids:idsarray
        };
        for(let i=0;i<that.multipleSelection.length;i++){
          idsarray.push(parseInt(that.multipleSelection[i].id));
        }
        if (!that.multipleSelection.length) {
          that.$message({
            message: '请选择记录！',
            showClose: true
          });
          return false;
        }
        that.$confirm('此操作将永久删除该文件, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          req.ajaxSend('/school/Notification/log','post',param,function (res){
//          console.log(res);
            for(let j=0;j<that.tableData.length;j++){
              if(that.tableData[j].checked){
                that.tableData.splice(j,1);
                j--;
              }
            }
            that.$message({
              type: 'success',
              message: '删除成功!'
            });
          })
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '已取消删除'
          });
        });
      },
      changeData(val){
        this.teacherState=!this.teacherState;
        this.fakeGridData = this.gridData;
      }
    }
  }
</script>
<style>
  /*弹框*/
  .pu-dialog .el-input__inner{
    height: 1.75rem;
    font-size: 0.875rem;
    color: #999999;
    padding-left: 1rem;
  }
  .pu-dialog .el-dialog__body{
    height: 34.875rem;
    overflow-y: auto;
  }
  .viewAlerts {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .pu-speed{
    color: #4da1ff;
    cursor: pointer;
  }
  .viewAlerts h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
  }
  .pageAlerts {
    text-align: center;
    margin-top: 1.5rem;
  }
</style>
