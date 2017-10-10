<template>
    <div class="TeachingEvaluationRecord">
      <h3>教学评价记录</h3>
      <el-col :span="17" class="alertsBtn">
        <el-button class="delete" title="导出">
          <img class="delete_unactive"
               src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
               alt="">
          <img class="delete_active"
               src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
               alt="">
        </el-button>
        <el-button-group style="margin-left: 2.1rem">
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
      <el-col :span="24">
        <el-row class="alertsList">
          <el-table
            :data="tableData"
            style="width: 100%"
            v-loading.body="isLoading"
            element-loading-text="拼命加载中...">
            <el-table-column
              prop="title"
              label="评教名称"
              align="center">
            </el-table-column>
            <el-table-column
              prop="name"
              label="评教开始日期"
              align="center">
            </el-table-column>
            <el-table-column
              prop="name"
              label="评教结束时间"
              align="center">
            </el-table-column>
            <el-table-column
              prop="createTime"
              label="评教人数"
              align="center">
              <template scope="scope">
                <div class="grayDiv">4/14</div>
                <div class="greenDiv" :style="{width:a/b+'px'}"></div>
              </template>
            </el-table-column>
            <el-table-column
              prop=""
              label="评教方式"
              align="center">
              <template scope="scope">
                <span></span>
              </template>
            </el-table-column>
            <el-table-column
              prop="result"
              label="创建时间"
              align="center">
              <template scope="scope">
                <span></span>
              </template>
            </el-table-column>
            <el-table-column
              label="操作"
              align="center">
              <template scope="scope">
                <span style="color:#4da1ff;cursor: pointer;border-right:1px solid #d2d2d2;padding-right:.6rem" v-if="publishGrade">发布成绩</span>
                <span style="color:#48b6c4;cursor: pointer;border-right:1px solid #d2d2d2;padding:0 .6rem" v-if="published">已发布</span>
                <span style="color:#ff6a6a;cursor: pointer;padding-left: .6rem">删除</span>
              </template>
            </el-table-column>
          </el-table>
        </el-row>
      </el-col>
    </div>
</template>
<script>
    export default{
        data(){
            return {
              Searchinput:'',
              isLoading:false,
              tableData:[{title:'1111'}],
              a:'20',
              b:'100',
              published:true,
              publishGrade:false,
            }
        },
      methods:{
        handleIconClick(){},
      }
    }
</script>
<style lang="less">
  .TeachingEvaluationRecord{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
    .grayDiv{
      background-color: #F0F0F0;
      height:22/16rem;
      position: absolute;
      width: 100%;
    }
    .greenDiv{
      background-color: #13B5B1;
      height:22/16rem;
      position: relative;
      top:0;
      left:0;
    }
    .Infor-input-inner .el-input__inner{
      border-radius: 1.1rem;
    }
  }
</style>
