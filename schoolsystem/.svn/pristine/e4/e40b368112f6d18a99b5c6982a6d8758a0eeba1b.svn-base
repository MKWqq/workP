<template>
  <div class="SchoolYear">
    <el-col :span="24">
      <el-col :span="22">
        <h3>学年学期</h3>
      </el-col>
      <el-col :span="2">
        <!--<el-button type="primary" class="CreateProcess-top-btn">保存</el-button>-->
      </el-col>
    </el-col>
    <el-row>
      <el-col :span="18" class="alertsBtn" style="margin-top:1.8rem;">
        <el-button type="primary" style="padding:0.5rem 0.9rem;" @click="addField()">
          <!--<img src="./../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add_highlight.png">-->
          <i class="el-icon-plus"></i>
          <span>添加学年学期</span>
        </el-button>
      </el-col>
    </el-row>
    <el-col :span="24">
      <el-row class="alertsList">
        <el-table
          :data="tableData"
          style="width: 100%"
          @sort-change="sort">
          <el-table-column
            type="index"
            label="序号"
            align="center"
            width="100">
          </el-table-column>
          <el-table-column
            prop="title"
            label="学年"
            align="center"
            sortable="column">
          </el-table-column>
          <el-table-column
            prop="name"
            label="学期"
            align="center"
            sortable="column">
          </el-table-column>
          <el-table-column
            prop="name"
            label="使用日期"
            align="center"
            sortable="column">
          </el-table-column>
          <el-table-column
            prop="name"
            label="更新时间"
            align="center"
            sortable="column">
          </el-table-column>
          <el-table-column
            prop="name"
            label="当前学年学期"
            align="center"
            sortable="column">
            <template scope="scope">
              <span style="color:#13B5B1;">√</span>
            </template>
          </el-table-column>
          <el-table-column
            label="操作"
            align="center">
            <template scope="scope">
              <span style="color:#4da1ff;cursor: pointer;border-right:1px solid #d2d2d2;padding-right:.6rem;" @click="Editdialog(scope.row)">编辑</span>
              <span style="color:#ff6a6a;cursor: pointer;padding-left:.6rem;" @click="Delectlist(scope.row)">删除</span>
            </template>
          </el-table-column>
        </el-table>
      </el-row>
      <el-dialog title="添加学年学期" size="tiny" v-if="dialogTableVisibleother" :modal="false" :visible.sync="dialogTableVisibleother">
        <el-form ref="form" label-position="right" label-width="75px" :model="form">
          <el-form-item label="学年:">
            <el-input placeholder="请输入"></el-input>
          </el-form-item>
          <el-form-item label="学期:">
            <el-input placeholder="请输入"></el-input>
          </el-form-item>
          <el-form-item label="日期:">
            <el-col :span="11">
              <el-date-picker type="date" placeholder="选择日期" v-model="form.value1" style="width: 100%;"></el-date-picker>
            </el-col>
            <el-col class="line" :span="1" :offset="1">-</el-col>
            <el-col :span="11">
              <el-date-picker type="date" placeholder="选择日期" v-model="form.value1" style="width: 100%;"></el-date-picker>
            </el-col>
          </el-form-item>
        </el-form>
        <el-col :span="1" :offset="10">
          <el-button type="primary" class="Field-save">保存</el-button>
        </el-col>
      </el-dialog>
      <el-dialog title="编辑学年学期" size="tiny" v-if="dialogTableVisible" :modal="false" :visible.sync="dialogTableVisible">
        <el-form ref="form" label-position="right" label-width="75px" :model="form">
          <el-form-item label="学年:">
            <el-input placeholder="请输入"></el-input>
          </el-form-item>
          <el-form-item label="学期:">
            <el-input placeholder="请输入"></el-input>
          </el-form-item>
          <el-form-item label="日期:">
            <el-col :span="11">
              <el-date-picker type="date" placeholder="选择日期" v-model="form.value1" style="width: 100%;"></el-date-picker>
            </el-col>
            <el-col class="line" :span="1" :offset="1">-</el-col>
            <el-col :span="11">
              <el-date-picker type="date" placeholder="选择日期" v-model="form.value1" style="width: 100%;"></el-date-picker>
            </el-col>
          </el-form-item>
        </el-form>
        <el-col :span="1" :offset="10">
          <el-button type="primary" class="Field-save">保存</el-button>
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
        dialogTableVisible:false,
        pickerOptions0: {
          disabledDate(time) {
            return time.getTime() < Date.now() - 8.64e7;
          }
        },
        form:{
          value1:new Date(),
        },
//        value1:new Date(),

      }
    },methods:{
      addField(){
        this.dialogTableVisibleother=true;
      },
      Editdialog(){
        this.dialogTableVisible=true;
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
  .SchoolYear{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .SchoolYear  .CreateProcess-top-btn{
    padding:.5rem 2.8rem ;
    border-radius: 1.1rem;
  }
  .SchoolYear .Field-save{
    margin: 2rem 0 1.4rem 0;
    padding: .5rem 2.1rem;
    border-radius: 1.1rem;
  }
</style>
