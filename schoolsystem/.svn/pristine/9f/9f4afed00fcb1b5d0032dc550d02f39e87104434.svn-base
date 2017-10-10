<template>
  <div class="KeleiInformation">
    <el-col :span="24">
      <el-col :span="22">
        <h3>科类信息</h3>
      </el-col>
      <el-col :span="2">
        <el-button type="primary" class="CreateProcess-top-btn">保存</el-button>
      </el-col>
    </el-col>
    <el-row>
      <el-col :span="18" class="alertsBtn" style="margin-top:1.8rem;">
        <el-button type="primary" style="padding:0.5rem 0.9rem;" @click="addField()">
          <!--<img src="./../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add_highlight.png">-->
          <i class="el-icon-plus"></i>
          <span>添加科类</span>
        </el-button>
      </el-col>
    </el-row>
    <el-col :span="24">
      <el-row class="alertsList KeleiInformation-input">
        <el-table
          :data="tableData"
          style="width: 100%"
          @sort-change="sort">
          <el-table-column
            type="index"
            label="序号"
            align="center"
            width="400">
          </el-table-column>
          <el-table-column
            prop="title"
            label="科类"
            align="center"
            sortable="column">
            <template scope="scope">
              <el-input style="width:45%;"></el-input>
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
      <el-dialog title="添加科类" size="tiny" v-if="dialogTableVisibleother" :modal="false" :visible.sync="dialogTableVisibleother">
        <el-col style="min-height:13rem;">
          <el-col :span="24">
            <el-col :span="5" :offset="2" style="padding-top: .4rem;">科类：</el-col>
            <el-col :span="15">
              <el-input placeholder="请输入"></el-input>
            </el-col>
          </el-col>
          <el-col :span="2" :offset="10">
            <el-button type="primary" class="Field-save">保存</el-button>
          </el-col>
        </el-col>
      </el-dialog>
    </el-col>
  </div>
</template>
<script>
  export default{
    data(){
      return{
        tableData:[{title:'1111'}],
        dialogTableVisibleother:false,

      }
    },methods:{
      addField(){
        this.dialogTableVisibleother=true;
      },
      Delectlist(){},
      sort(column){
//          this.order = `${column.prop} ${column.order==='ascending'?'asc':'desc'}`;
//          this.getList(1);
      },
    }
  }
</script>
<style lang="less">
  .KeleiInformation{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .KeleiInformation  .CreateProcess-top-btn{
    padding:.5rem 2.8rem ;
    border-radius: 1.1rem;
  }
  .KeleiInformation  .Field-save{
    position: absolute;
    bottom: 1rem;
    padding: .5rem 2.1rem;
    border-radius: 1.1rem;
  }
  .KeleiInformation-input .el-input__inner{
    border: none;
  }
  .KeleiInformation-input .el-input__inner:focus{
    outline:1px solid #96C3F9;
  }
</style>
