<template>
  <div class="FieldAdministration">
    <h3>场地管理</h3>
    <el-row>
      <el-col :span="24" class="LeaveRecord-title">
        <el-col :span="2" style="padding-top: .3rem;">文件路径：</el-col>
        <el-col :span="4" style="margin-left: -1.5rem;">
          <el-input></el-input>
        </el-col>
        <el-col :span="2" style="margin-left: 1.6rem">
          <el-button type="primary" class="FieldAdmin-titlebtn">
            <img src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_choice.png"
                 alt="">
            <span>选择文件</span>
          </el-button>
        </el-col>
        <el-col :span="2" style="margin-left:1.6rem">
          <el-button type="primary" class="FieldAdmin-titlebtn">
            <img src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_download.png"
                 alt="">
            <span>下载模板</span>
          </el-button>
        </el-col>

      </el-col>
    </el-row>
    <el-row>
      <el-col :span="17" class="alertsBtn" style="margin-top:1.8rem;">
        <el-button type="primary" style="padding:0.5rem 0.9rem;" @click="addField()">
          <!--<img src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add_highlight.png"-->
               <!--alt="">-->
          <i class="el-icon-plus"></i>
          <span>添加场地</span>
        </el-button>
      </el-col>
      <el-col :span="5" :offset="2" class="Infor-input-inner" style="padding:1.8rem 0 1rem 0;">
        <el-input style="border-radius:1rem" placeholder="请输入搜索内容" icon="search" v-model="Searchinput" :on-icon-click="handleIconClick"></el-input>
      </el-col>
    </el-row>
    <el-col :span="24">
      <el-row class="alertsList">
        <el-table
          :data="tableData"
          style="width: 100%">
          <el-table-column
            prop="title"
            label="栋号"
            align="center">
          </el-table-column>
          <el-table-column
            prop="name"
            label="栋名"
            align="center">
          </el-table-column>
          <el-table-column
            prop="name"
            label="层"
            align="center">
          </el-table-column>
          <el-table-column
            prop="createTime"
            label="号"
            align="center">
            <template scope="scope">
              <span></span>
            </template>
          </el-table-column>
          <el-table-column
            prop="result"
            label="场地名称"
            align="center">
            <template scope="scope">
              <span></span>
            </template>
          </el-table-column>
          <el-table-column
            prop="result"
            label="是否开放"
            align="center">
            <template scope="scope">
              <el-switch
                v-model="Switchvalue"
                on-text="是"
                off-text="否">
              </el-switch>
            </template>
          </el-table-column>
          <el-table-column
            label="操作"
            align="center">
            <template scope="scope">
              <span style="color:#4da1ff;cursor: pointer;border-right:1px solid #d2d2d2;padding-right: .6rem" @click="ShowDatils(scope.row)">编辑</span>
              <span style="color:#ff6a6a;cursor: pointer;padding-left: .6rem" @click="Delectlist(scope.row)">删除</span>
            </template>
          </el-table-column>
        </el-table>
      </el-row>
      <el-dialog title="添加场地" size="tiny" v-if="dialogTableVisibleother" :modal="false" :visible.sync="dialogTableVisibleother">
          <el-col style="min-height: 20rem;">
            <el-col :span="24">
              <el-col :span="3" style="padding-top: .4rem;">栋号：</el-col>
              <el-col :span="8">
                <el-input placeholder="请输入"></el-input>
              </el-col>
              <el-col :span="3" style="padding-top: .4rem;" :offset="2">栋名：</el-col>
              <el-col :span="8">
                <el-input placeholder="请输入"></el-input>
              </el-col>
            </el-col>
            <el-col :span="24" style="padding-top: 2rem;">
              <el-col :span="3" style="padding-top: .4rem;">层：</el-col>
              <el-col :span="8">
                <el-input placeholder="请输入"></el-input>
              </el-col>
              <el-col :span="3" style="padding-top: .4rem;" :offset="2">号：</el-col>
              <el-col :span="8">
                <el-input placeholder="请输入"></el-input>
              </el-col>
            </el-col>
            <el-col :span="24" style="padding-top: 2rem;">
              <el-col :span="5"  style="padding-top: .4rem;">场地名称：</el-col>
              <el-col :span="19">
                <el-input placeholder="请输入"></el-input>
              </el-col>
            </el-col>
            <el-col :span="2" :offset="10">
              <el-button type="primary" class="Field-save">保存</el-button>
            </el-col>
          </el-col>
      </el-dialog>
      <el-dialog title="编辑场地" size="tiny" v-if="dialogTableVisible" :modal="false" :visible.sync="dialogTableVisible">
        <el-col style="min-height: 20rem;">
          <el-col :span="24">
            <el-col :span="3" style="padding-top: .4rem;">栋号：</el-col>
            <el-col :span="8">
              <el-input placeholder="请输入"></el-input>
            </el-col>
            <el-col :span="3" style="padding-top: .4rem;" :offset="2">栋名：</el-col>
            <el-col :span="8">
              <el-input placeholder="请输入"></el-input>
            </el-col>
          </el-col>
          <el-col :span="24" style="padding-top: 2rem;">
            <el-col :span="3" style="padding-top: .4rem;">层：</el-col>
            <el-col :span="8">
              <el-input placeholder="请输入"></el-input>
            </el-col>
            <el-col :span="3" style="padding-top: .4rem;" :offset="2">号：</el-col>
            <el-col :span="8">
              <el-input placeholder="请输入"></el-input>
            </el-col>
          </el-col>
          <el-col :span="24" style="padding-top: 2rem;">
            <el-col :span="5" style="padding-top: .4rem;">场地名称：</el-col>
            <el-col :span="19">
              <el-input placeholder="请输入"></el-input>
            </el-col>
          </el-col>
          <el-col :span="2" :offset="10">
            <el-button type="primary" class="Field-save">保存</el-button>
          </el-col>
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
        Switchvalue:true,
        dialogTableVisible: false,
        dialogTableVisibleother:false,
        tableData: [{title:'111'}],
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
        link:'',
        person:'',
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
        this.dialogTableVisible=true;
      },
      addField(){
          this.dialogTableVisibleother=true;
      },
      Delectlist(){},
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
//          this.tableData =res.data;
          this.total = res.total;
          this.isLoading=false;
        });
      },
      handleCurrentChange(val) {
        this.currentPage = val;
        this.getRecord(val);
      }
    },
    filters:{
      getResultState(val){
        return val===1?'通过':
          val===2?'审批过期':
            val===-2?'无':'未通过';
      }
    }
  }
</script>
<style lang="less">
  .FieldAdministration .el-button.FieldAdmin-titlebtn {
    background-color: #13b5b1;
    border-color: #13b5b1;
    height: 36px;
    padding: 0 .9rem;
  }
  .Field-save{
    position: absolute;
    bottom: 1.4rem;
    padding: .5rem 2.1rem;
    border-radius: 1.1rem;
  }
  .FieldAdministration{
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
