<template>
  <div class="ClassEvaluationList">
    <h3>各班主任统计</h3>
    <el-row>
      <el-col :span="24" class="Infor-head">
        <el-col :span="22">
          <el-form :inline="true" :model="formInline" class="demo-form-inline Infor-title clear_fix">
            <el-form-item label="评教名称：">
              <el-select v-model="formInline.region" placeholder="请选择评教名称">
                <el-option label="区域一" value="shanghai"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="年级：" class="Infor-item">
              <el-select v-model="formInline.region" placeholder="请选择年级">
                <el-option label="全选" value="all"></el-option>
              </el-select>
            </el-form-item>
          </el-form>
        </el-col>
        <el-col :span="2">
          <el-button type="primary" icon="search">查询</el-button>
        </el-col>
      </el-col>
      <el-col :span="17" class="alertsBtn">
        <el-button class="delete" title="导出">
          <img class="delete_unactive"
               src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
               alt="">
          <img class="delete_active"
               src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
               alt="">
        </el-button>
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
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        style="width: 100%"
        v-loading.body="isLoading"
        element-loading-text="拼命加载中...">
        <el-table-column
          prop="name"
          label="班级"
          align="center">
        </el-table-column>
        <el-table-column
          prop="name"
          label="班主任"
          align="center">
        </el-table-column>
        <el-table-column
          prop=""
          label="参评人数"
          align="center">
          <!--<template  scope="scope">-->
            <!---->
          <!--</template>-->
        </el-table-column>
        <el-table-column
          prop=""
          label="满意数"
          align="center">
        </el-table-column>
        <el-table-column
          prop=""
          label="满意率"
          align="center">
        </el-table-column>
        <el-table-column
          prop=""
          label="一般数"
          align="center">
        </el-table-column>
        <el-table-column
          prop=""
          label="一般率"
          align="center">
        </el-table-column>
        <el-table-column
          prop=""
          label="不满意数"
          align="center">
        </el-table-column>
        <el-table-column
          prop=""
          label="不满意率"
          align="center">
        </el-table-column>
      </el-table>
    </el-row>
  </div>
</template>
<script>
  export default{
    data(){
      return {
        formInline: {
          region: ''
        },
        Searchinput: '',
        tableData:[
          {
            name:'1111'
          }
        ],
        isLoading:false,
        teaching:true,
        Notteaching:false,
      }
    },
    methods:{
      handleIconClick:{

      },
    }
  }
</script>
<style lang="less">
  .ClassEvaluationList{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
</style>
