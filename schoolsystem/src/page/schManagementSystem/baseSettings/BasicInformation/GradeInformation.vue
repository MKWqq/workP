<template>
  <div class="GradeInformation">
    <h3>年级信息</h3>
    <el-row class="alertsList GradeInformation-top">
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
          label="年级代码"
          align="center"
          sortable="column">
        </el-table-column>
        <el-table-column
          prop="name"
          label="年级名称"
          align="center"
          sortable="column">
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
  </div>
</template>
<script>
  export default{
      data(){
          return{
            tableData:[{title:'111'}],
          }
      },
    methods:{
      sort(){

      },
      Delectlist(){

      },
    }
  }
</script>
<style lang="less">
  .GradeInformation{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .GradeInformation-top{
    margin-top: 2rem;
  }
</style>
