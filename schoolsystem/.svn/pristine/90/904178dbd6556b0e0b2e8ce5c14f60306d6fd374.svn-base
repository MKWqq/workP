<template>
  <div class="InformationService">
    <h3>学生参考确认</h3>
    <el-row>
      <el-col :span="24" class="Infor-head">
        <el-form :inline="true" :model="formInline" class="demo-form-inline Infor-title clear_fix">
          <el-form-item label="年级：">
            <el-select v-model="formInline.region" placeholder="请选择年级">
              <el-option label="区域一" value="shanghai"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="班级：" class="Infor-item">
            <el-select v-model="formInline.region" placeholder="请选择班级">
              <el-option label="全选" value="all"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="信息类别：" class="Infor-item">
            <el-select v-model="formInline.region" placeholder="请选择信息类别">
              <el-option label="区域一" value="shanghai"></el-option>
            </el-select>
          </el-form-item>
        </el-form>
        <el-col :span="2" :offset="22">
          <el-button type="primary" icon="search" class="Infor-search">查询</el-button>
        </el-col>
      </el-col>
      <el-col :span="17" class="alertsBtn" style="margin-top: 0">
        <el-button-group style="margin-top:1.8rem">
          <el-button class="filt" title="复制">
            <img class="filt_unactive"
                 src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png"
                 alt="">
            <img class="filt_active"
                 src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png"
                 alt="">
          </el-button>
          <el-button class="delete" title="打印">
            <img class="delete_unactive"
                 src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png"
                 alt="">
            <img class="delete_active"
                 src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png"
                 alt="">
          </el-button>
        </el-button-group>
      </el-col>
      <el-col :span="5" :offset="2" class="Infor-input-inner" style="margin-top:1.8rem;">
        <el-input style="border-radius:1rem" placeholder="请输入搜索内容" icon="search" v-model="Searchinput" :on-icon-click="handleIconClick"></el-input>
      </el-col>
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
          prop="a"
          label="班级"
          align="center"
          sortable="column">
          <template  scope="scope">

          </template>
        </el-table-column>
        <el-table-column
          prop="b"
          label="班级序号"
          align="center"
          sortable="column">
          <template  scope="scope">

          </template>
        </el-table-column>
        <el-table-column
          prop="c"
          label="姓名"
          align="center"
          sortable="column">
          <template  scope="scope">

          </template>
        </el-table-column>
        <el-table-column
          prop="c"
          label="性别"
          align="center"
          sortable="column">
          <template  scope="scope">

          </template>
        </el-table-column>
        <el-table-column
          prop="d"
          label="是否参加考试"
          align="center">
          <template  scope="scope">
            <el-switch
              v-model="Switchvalue"
              on-text="是"
              off-text="否">
            </el-switch>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
    <el-row class="pageAlerts">
      <el-pagination
        @current-change="handleCurrentChange"
        :current-page.sync="currentPage"
        :page-size="10"
        layout="prev, pager, next, jumper"
        :total="100">
      </el-pagination>
    </el-row>
  </div>
</template>
<script>
  export default{
    data() {
      return {
        formInline: {
          region: ''
        },
        Searchinput: '',
        tableData:[
          {
            a:'高一',
            b:'高一',
            c:'高一',
            d:'高一'
          }
        ],
        isLoading:false,
        currentPage: 1,
        dialogTableVisible: false,
        Switchvalue:true
      }
    },
    methods: {
      showDialogTable(row){
        this.dialogTableVisible = true;
      },
      handleIconClick:{

      },
      handleSelectionChange(val) {
//          this.multipleSelection = val.map(val=>{
//            val.checked = true;
//            return val;
//          });
      },
      sort(column){
//          this.order = `${column.prop} ${column.order==='ascending'?'asc':'desc'}`;
//          this.getList(1);
      },
      handleCurrentChange(val) {
        this.currentPage = val;
//          this.getList(val);
        console.log(`当前页: ${this.currentPage}`);
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
<style>
  .InformationService{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .Infor-item{
    margin-left: 2.8rem;
  }
  .Infor-search{
    background: #4da1ff;
    padding:.5rem 2rem;
    border-radius: 1.1rem;
    margin-top: -1rem;
  }
  .Infor-confirm{
    background: #4da1ff;
    padding:.5rem 2rem;
    border-radius: 1.1rem;
    margin-top: 4rem;
  }
  .Infor-cancel{
    border: 1px solid #d2d2d2;
    padding:.5rem 2rem;
    border-radius: 1.1rem;
    color: #888888;
    margin-top: 4rem;
  }
  .Infor-head{
    margin-top: 2rem;
    padding-bottom: 1.1rem;
    border-bottom: 1px solid #d2d2d2;
  }
  .Infor-input-inner .el-input__inner{
    border-radius: 1.2rem;
  }
</style>

