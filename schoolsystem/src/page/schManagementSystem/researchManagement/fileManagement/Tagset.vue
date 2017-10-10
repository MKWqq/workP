<template>
  <div class="FieldSet">
    <h3>标签设置</h3>
    <el-row>
      <el-col :span="17" class="alertsBtn" style="margin-top:1.8rem;">
        <el-button type="primary" style="padding:0.5rem 0.9rem;" @click="addField()">
          <!--<img src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add_highlight.png"-->
               <!--alt="">-->
          <i class="el-icon-plus"></i>
          <span>新增类型</span>
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
            label="标签类型"
            align="center">
          </el-table-column>
          <el-table-column
            prop=""
            label="标签名"
            align="center">
            <template scope="scope">
              <el-tag
                :key="tag"
                v-for="tag in dynamicTags"
                :closable="true"
                :close-transition="false"
                @close="handleClose(tag)">
                {{tag}}
              </el-tag>
              <span class="NewfieldDetails-add" @click="addoptions()">+</span>
            </template>
          </el-table-column>
          <el-table-column
            label="操作"
            align="center">
            <template scope="scope">
              <span style="color:#ff6a6a;cursor: pointer;" @click="Delectlist(scope.row)">删除</span>
            </template>
          </el-table-column>
        </el-table>
      </el-row>
      <el-dialog title="新增标签名" size="tiny" v-if="dialogTableVisible" :modal="false" :visible.sync="dialogTableVisible">
        <el-col style="min-height: 10rem;">
          <el-col :span="24">
            <el-col :span="5" :offset="2" style="padding-top: .5rem;">标签名称：</el-col>
            <el-col :span="15">
              <el-input
                class="input-new-tag"
                v-model="inputValue"
                ref="saveTagInput"
                @keyup.enter.native="handleInputConfirm">
              </el-input>
            </el-col>
          </el-col>
          <el-col :span="24">
            <el-col :span="2" :offset="10">
              <el-button type="primary" class="Field-save" @click="handleInputConfirm">保存</el-button>
            </el-col>
          </el-col>
        </el-col>
      </el-dialog>
      <el-dialog title="新增类型" size="tiny" v-if="dialogTableVisibleother" :modal="false" :visible.sync="dialogTableVisibleother">
        <el-col style="min-height: 10rem;">
          <el-col :span="24">
            <el-col :span="5" :offset="2" style="padding-top: .5rem;">标签类型：</el-col>
            <el-col :span="15">
              <el-input></el-input>
            </el-col>
          </el-col>
          <el-col :span="24">
            <el-col :span="2" :offset="7">
              <el-button type="primary" class="Field-save">确定</el-button>
            </el-col>
            <el-col :span="2" :offset="13">
              <el-button class="Field-save" @click="Offdialog()">取消</el-button>
            </el-col>
          </el-col>
        </el-col>
      </el-dialog>
    </el-col>
  </div>
</template>
<script>
  import req from './../../../../assets/js/common'
  import Vue from 'vue'
  import formatdata from './../../../../assets/js/date'
  export default{
    data(){
      return{
        dialogTableVisible: false,
        dialogTableVisibleother:false,
        tableData: [{
          title:'1111'
        }],
        form:{},
        dialogData:[],
        currentPage: 1,
        pageALl: 10,
        total:0,
        params:{
          title: '',
          name:'',
          type: 'edit',
          content: '',
        },
        dynamicTags: ['标签一', '标签二', '标签三'],
        inputValue: '',
        Searchinput:''
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
      handleClose(tag) {
        this.dynamicTags.splice(this.dynamicTags.indexOf(tag), 1);
      },

      handleInputConfirm() {
        let inputValue = this.inputValue;
        if (inputValue) {
          this.dynamicTags.push(inputValue);
        }
        this.inputVisible = false;
        this.inputValue = '';
        this.dialogTableVisible=false;
      },
      addField(){
        this.dialogTableVisibleother=true;
      },
      addoptions(){
        this.dialogTableVisible=true;
      },
      Offdialog(){
        this.dialogTableVisibleother=false;
      },
      handleClose(tag) {
        this.dynamicTags.splice(this.dynamicTags.indexOf(tag), 1);
      },
      Delectlist(){},
      getRecord(page){
        if(page!==this.currentPage){
          this.currentPage=page;
        }
        this.isLoading=true;
        let
          param={
            page: page,
            count:10,
          };
        req.ajaxSend('/school/WorkDemand/LogDoc','post',param,(res)=>{
          if (res.status === -1) {
            this.tableData = [];
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
      handleIconClick(){

      },
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
  .NewfieldDetails-add{
    border: 1.48px solid #F08BC5;
    display: inline-block;
    color: #F08BC5;
    padding:0 .35rem;
    cursor: pointer;
    font-weight: bold;
    font-size: 1.1rem;
    border-radius: .1rem;
    margin-left: .5rem;
  }
  .FieldSet{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .FieldSet .el-tag{
    background-color:#F08BC5 ;
    margin-left: .3rem;
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
    height: 30px;
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
