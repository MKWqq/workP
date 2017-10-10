<template>
  <div>
    <h3>新建场地申请</h3>
    <el-row class="Newfield-time">
      <el-col :span="2" style="margin-top: .4rem;">选择日期：</el-col>
      <el-col :span="8" style="margin-left: -.8rem;">
        <el-date-picker
          v-model="selectTime"
          type="datetime"
          placeholder="选择日期时间">
        </el-date-picker>
      </el-col>
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        style="width: 100%">
        <el-table-column
          type="index"
          label="序号"
          align="center"
          width="76">
        </el-table-column>
        <el-table-column
          prop="title"
          label="栋号"
          align="center">
        </el-table-column>
        <el-table-column
          prop="name"
          label="楼栋名称"
          align="center">
        </el-table-column>
        <el-table-column
          prop="createTime"
          label="层"
          align="center">
        </el-table-column>
        <el-table-column
          prop="createTime"
          label="号"
          align="center">
        </el-table-column>
        <el-table-column
          prop="createTime"
          label="场地"
          align="center">
        </el-table-column>
        <el-table-column
          prop="createTime"
          label="使用情况"
          align="center"
          width="460">
          <template  scope="scope">
            <el-slider v-model="Usetime"></el-slider>
          </template>
        </el-table-column>
        <el-table-column
          prop="createTime"
          label="操作"
          align="center">
          <template  scope="scope">
            <span style="color:#4da1ff;cursor: pointer;" @click="Todatails()">申请使用</span>
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
              selectTime:new Date(),
              tableData:[
                {title:'111'}
              ],
              Usetime:0,
            }
        },
      methods: {
        formatTooltip(val) {
          return val / 100;
        },
        Todatails(){
          this.$router.push('/Newfield/NewfieldDetails')
        }
      }
    }
</script>
<style>
  .Newfield-time{
    padding: 2rem 0;
  }
  /*.Newfield .el-slider__bar{*/
    /*background-color: #FF7F7E;*/
    /*height:.6rem;*/
    /*border-top-left-radius:6px;*/
    /*border-bottom-left-radius:6px;*/
  /*}*/
  /*.Newfield .el-slider__runway{*/
    /*height: .6rem;*/
    /*border-radius: 6px;*/
  /*}*/
  /*.Newfield  .el-slider__button{*/
    /*width:1.2rem;*/
    /*height:1.2rem;*/
  /*}*/
</style>
