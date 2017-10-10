<template>
  <div class="distributionProcess">
    <el-row type="flex" align="middle">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回</span></el-button>
      <h3>宿舍分配流程</h3>
    </el-row>
    <el-row type="flex" justify="end" class="steps">
      <span class="step unable_edit">不可编辑</span>
      <span class="step completed">已完成</span>
      <span class="step main_process">主要流程</span>
      <span class="step sec_process">次要流程</span>
      <span class="step un_activated ">未激活</span>
    </el-row>
    <el-row class="stepLists">
      <el-row class="distributionProcess_items">
        <div class="distributionProcess_items topMax">
          <div class="distributionProcess_item">
            <router-link to="/dormitoryDistributionHome/distributionPersonnelList" tag="div" class="item completed">
              设置分配人员名单
            </router-link>
          </div>
          <div>
            <div class="arrowRight horizontal_img completed">
              <i class="el-icon-arrow-right"></i>
            </div>
          </div>
        </div>
        <div>
          <el-row>
            <div class="arrowRight independent_img1 completed">
              <i class="el-icon-arrow-right"></i>
            </div>
          </el-row>
          <el-row class="distributionProcess_items">
            <div class="distributionProcess_item">
              <router-link to="/dormitoryDistributionHome/distributionDormitoryMsg" tag="div" class="item completed">
                设置分配宿舍人员信息
              </router-link>
            </div>
            <div>
              <div class="arrowRight horizontal_img completed">
                <i class="el-icon-arrow-right"></i>
              </div>
            </div>
          </el-row>
        </div>
        <div>
          <el-row class="distributionProcess_item">
            <router-link to="/dormitoryDistributionHome/specifiedStudentDormitory" tag="div" class="item main_process">
              指定学生到宿舍
            </router-link>
          </el-row>
          <el-row>
            <div class="arrowDown vertical_img main_process">
              <i class="el-icon-arrow-down"></i>
            </div>
          </el-row>
          <el-row class="distributionProcess_item">
            <router-link to="/dormitoryDistributionHome/fastDistributionDormitory" tag="div" class="item completed">快速分配宿舍
            </router-link>
          </el-row>
        </div>
        <div class="distributionProcess_items topMax">
          <div>
            <div class="arrowRight horizontal_img completed">
              <i class="el-icon-arrow-right"></i>
            </div>
          </div>
          <div>
            <el-row class="distributionProcess_item">
              <div class="item main_process" @click="publishedMsg">发布宿舍信息</div>
            </el-row>
            <el-row>
              <div class="arrowTop vertical_img sec_process">
                <i class="el-icon-arrow-up"></i>
              </div>
            </el-row>
            <el-row class="distributionProcess_item">
              <router-link to="/dormitoryDistributionHome/manuallyAdjustmentDormitory" tag="div"
                           class="item sec_process">手动调整
              </router-link>
            </el-row>
            <el-row>
              <div class="arrowTop vertical_img sec_process">
                <i class="el-icon-arrow-up"></i>
              </div>
            </el-row>
            <el-row class="distributionProcess_item">
              <router-link to="/dormitoryDistributionHome/dormitoryPrintReport" tag="div" class="item sec_process">
                打印报表
              </router-link>
            </el-row>
          </div>
        </div>
      </el-row>
    </el-row>
  </div>
</template>
<script>
  import req from '@/assets/js/common'

  export default{
    data(){
      return {}
    },
    methods: {
      returnFlowchart(){
        this.$router.go(-1);
      },
      publishedMsg(){
        this.$confirm('是否确定发布宿舍分配结果至学生？', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          this.$message({
            type: 'success',
            message: '发布成功!',
            showClose: true
          });
        }).catch(() => {
        });
      }
    }
  }
</script>
<style>
  .distributionProcess .steps {
    text-align: right;
    margin: 2rem 0 4.375rem;
  }

  .distributionProcess .step + .step {
    margin-left: 3.5rem;
  }

  .distributionProcess .step {
    position: relative;
    font-size: .875rem;
  }

  .distributionProcess .step:before {
    position: absolute;
    display: block;
    content: '';
    width: .6rem;
    height: .6rem;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    left: -1.5rem;
    border-radius: 100%;
  }

  .distributionProcess .step.unable_edit:before, .distributionProcess .distributionProcess_item .item.unable_edit {
    background: #d2d2d2;
    color: #fff;
    text-align: center;
  }

  .distributionProcess .step.completed:before, .distributionProcess .distributionProcess_item .item.completed {
    background: #13b5b1;
    color: #fff;
    text-align: center;
  }

  .distributionProcess .step.main_process:before, .distributionProcess .distributionProcess_item .item.main_process {
    background: #4da1ff;
    color: #fff;
    text-align: center;
  }

  .distributionProcess .step.sec_process:before, .distributionProcess .distributionProcess_item .item.sec_process {
    background: #89bcf5;
    color: #fff;
    text-align: center;
  }

  .distributionProcess .step.un_activated:before, .distributionProcess .distributionProcess_item .item.un_activated {
    border: 1px solid #d2d2d2;
  }

  .distributionProcess .stepLists {
    width: 75rem;
    margin: 0 auto 10rem;
  }

  .distributionProcess .distributionProcess_items > div {
    float: left;
  }

  .distributionProcess .distributionProcess_item .item {
    display: inline-block;
    width: 15rem;
    padding: .75rem 0;
    border-radius: 1.5rem;
    font-size: .875rem;
    text-align: center;
  }

  .distributionProcess .distributionProcess_item .item.completed, .distributionProcess .distributionProcess_item .item.main_process, .distributionProcess .distributionProcess_item .item.sec_process {
    cursor: pointer;
  }

  .distributionProcess .arrowDown, .distributionProcess .arrowRight, .distributionProcess .arrowTop {
    position: relative;
  }

  .distributionProcess .arrowDown i {
    position: absolute;
    bottom: -.8rem;
    left: -.6rem;
  }

  .distributionProcess .arrowRight i {
    position: absolute;
    top: -.5rem;
    right: -.6rem;
  }

  .distributionProcess .arrowTop i {
    position: absolute;
    top: -.6rem;
    right: -.4rem;
  }

  .distributionProcess .vertical_img {
    position: relative;
    width: 0;
    height: 2.5rem;
    margin: .8rem 0 1rem 0;
    left: 50%;
    -webkit-transform: translateX(-50%);
    -moz-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    -o-transform: translateX(-50%);
    transform: translateX(-50%);
    border-left: .125rem solid;
  }

  .distributionProcess .horizontal_img {
    display: inline-block;
    width: 2.5rem;
    margin: 1.5rem 1.2rem 1rem .8rem;
    border-bottom: .125rem solid;
  }

  .distributionProcess .independent_img1 {
    display: inline-block;
    width: 12rem;
    height: 4.5rem;
    margin: 1.5rem 1.2rem .5rem 6.25rem;
    border-top: .125rem solid;
    border-left: .125rem solid;
  }

  .distributionProcess .horizontal_img.completed i, .distributionProcess .vertical_img.completed i, .distributionProcess .independent_img1.completed i {
    color: #09baa7;
  }

  .distributionProcess .vertical_img.completed, .distributionProcess .horizontal_img.completed, .distributionProcess .independent_img1.completed {
    border-color: #09baa7;
  }

  .distributionProcess .horizontal_img.main_process i, .distributionProcess .vertical_img.main_process i, .distributionProcess .independent_img1.main_process i {
    color: #4da1ff;
  }

  .distributionProcess .vertical_img.main_process, .distributionProcess .horizontal_img.main_process, .distributionProcess .independent_img1.main_process {
    border-color: #4da1ff;
  }

  .distributionProcess .horizontal_img.sec_process i, .distributionProcess .vertical_img.sec_process i, .distributionProcess .independent_img1.sec_process i {
    color: #89bcf5;
  }

  .distributionProcess .vertical_img.sec_process, .distributionProcess .horizontal_img.sec_process, .distributionProcess .independent_img1.sec_process {
    border-color: #89bcf5;
  }

  .distributionProcess .horizontal_img.un_activated i, .distributionProcess .vertical_img.un_activated i, .distributionProcess .independent_img1.un_activated i {
    color: #d2d2d2;
  }

  .distributionProcess .vertical_img.un_activated, .distributionProcess .horizontal_img.un_activated, .distributionProcess .independent_img1.un_activated {
    border-color: #d2d2d2;
  }

  .distributionProcess .horizontal_img.unable_edit i, .distributionProcess .vertical_img.unable_edit i, .distributionProcess .independent_img1.unable_edit i {
    color: #d2d2d2;
  }

  .distributionProcess .vertical_img.unable_edit, .distributionProcess .horizontal_img.unable_edit, .distributionProcess .independent_img1.unable_edit {
    border-color: #d2d2d2;
  }

  .distributionProcess .topMax {
    margin-top: 6.8rem;
  }
</style>
