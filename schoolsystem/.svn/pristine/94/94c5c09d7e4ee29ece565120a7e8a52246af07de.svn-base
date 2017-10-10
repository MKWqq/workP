<template>
  <div class="subClassDivision">
    <h3>分科分班管理</h3>
    <el-row type="flex" align="middle" class="subClassDivision_row">
      <el-col :span="10">
        <el-form :inline="true">
          <el-form-item label="分班方案：">
            <el-select
              @change="getProgramme"
              v-model="value" placeholder="请选择">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-form-item>
        </el-form>
      </el-col>
      <el-col :span="14" class="steps">
        <span class="step unable_edit">不可编辑</span>
        <span class="step completed">已完成</span>
        <span class="step main_process">主要流程</span>
        <span class="step sec_process">次要流程</span>
        <span class="step un_activated ">未激活</span>
      </el-col>
    </el-row>
    <el-row class="stepLists">
      <el-row class="subClassDivision_items">
        <div>
          <div class="arrowDown independent_img1 completed">
            <i class="el-icon-arrow-down"></i>
          </div>
        </div>
        <div>
          <el-row class="subClassDivision_item">
            <router-link to="/subClassDivisionHome/reviseSubClassPlan" tag="div" class="item completed">修改分班方案
            </router-link>
          </el-row>
          <el-row>
            <div class="arrowDown vertical_img completed">
              <i class="el-icon-arrow-down"></i>
            </div>
          </el-row>
          <el-row class="subClassDivision_item">
            <router-link to="/subClassDivisionHome/subStudentManagement" tag="div" class="item completed">分班学生管理
            </router-link>
          </el-row>
          <el-row>
            <div class="arrowDown vertical_img completed">
              <i class="el-icon-arrow-down"></i>
            </div>
          </el-row>
          <el-row class="subClassDivision_item">
            <router-link to="/subClassDivisionHome/subScoreBasis" tag="div" class="item completed">分班成绩依据</router-link>
          </el-row>
          <el-row>
            <div class="arrowDown vertical_img completed">
              <i class="el-icon-arrow-down"></i>
            </div>
          </el-row>
        </div>
      </el-row>
      <el-row class="subClassDivision_items subClassDivision_item">
        <router-link to="/subClassDivisionHome/fillVolunteerSet" tag="div" class="item completed">填报志愿设置</router-link>
        <div class="arrowRight horizontal_img completed">
          <i class="el-icon-arrow-right"></i>
        </div>
        <div>
          <router-link to="/subClassDivisionHome/scoreCountSet" tag="div" class="item main_process">成绩统计设置</router-link>
          <div class="arrowDown vertical_img main_process">
            <i class="el-icon-arrow-down"></i>
          </div>
        </div>
        <div class="arrowRight horizontal_img main_process">
          <i class="el-icon-arrow-right"></i>
        </div>
        <router-link to="/subClassDivisionHome/aggregateScoreCount" tag="div" class="item un_activated">合计成绩统计
        </router-link>
      </el-row>
      <el-row class="subClassDivision_items subClassDivision_item">
        <div>
          <el-row class="arrowDown independent_img6 un_activated">
            <i class="el-icon-arrow-down"></i>
          </el-row>
          <el-row>
            <router-link to="/subClassDivisionHome/specifiedStudentClass" tag="div" class="item un_activated">指定学生到班
            </router-link>
          </el-row>
        </div>
        <div>
          <el-row>
            <div class="item unable_edit">学生填报志愿</div>
          </el-row>
          <el-row>
            <div class="arrowDown vertical_img un_activated">
              <i class="el-icon-arrow-down"></i>
            </div>
          </el-row>
          <el-row>
            <router-link to="/subClassDivisionHome/likeSubClassSet" tag="div" class="item un_activated">拟分班级设置
            </router-link>
          </el-row>
          <el-row class="arrowDown vertical_img un_activated">
            <i class="el-icon-arrow-down"></i>
          </el-row>
        </div>
        <div>
          <el-row class="arrowRight independent_img3 un_activated">
            <i class="el-icon-arrow-right"></i>
          </el-row>
          <el-row class="arrowDown independent_img4 un_activated">
            <i class="el-icon-arrow-down"></i>
          </el-row>
          <el-row type="flex" align="middle" class="spec">
            <router-link to="/subClassDivisionHome/studentVolunteerRevise" tag="div" class="item un_activated">学生志愿调整
            </router-link>
            <div class="arrowRight horizontal_img un_activated">
              <i class="el-icon-arrow-right"></i>
            </div>
          </el-row>
          <el-row class="arrowLeft independent_img5 un_activated">
            <i class="el-icon-arrow-left"></i>
          </el-row>
        </div>
        <div class="group un_activated">
          <el-row>
            <router-link to="/subClassDivisionHome/studentVolunteerCount" tag="div" class="item un_activated">学生志愿统计
            </router-link>
          </el-row>
          <el-row>
            <router-link to="/subClassDivisionHome/unFillVolunteerList" tag="div" class="item un_activated">未报志愿学生名单
            </router-link>
          </el-row>
          <el-row>
            <router-link to="/subClassDivisionHome/volunteerConfirmList" tag="div" class="item un_activated">志愿确认签名单
            </router-link>
          </el-row>
        </div>
      </el-row>
      <el-row class="subClassDivision_items subClassDivision_item">
        <div class="arrowRightT independent_img7 un_activated">
          <i class="el-icon-arrow-right"></i>
        </div>
        <div>
          <el-row>
            <router-link to="/subClassDivisionHome/quicklySplitclass" tag="div" class="item un_activated">快速分班
            </router-link>
          </el-row>
          <el-row>
            <div class="arrowDown vertical_img un_activated">
              <i class="el-icon-arrow-down"></i>
            </div>
          </el-row>
          <el-row>
            <router-link to="/subClassDivisionHome/publishSubClassResult" tag="div" class="item un_activated">发布分班结果
            </router-link>
          </el-row>
          <el-row>
            <div class="arrowDown vertical_img un_activated">
              <i class="el-icon-arrow-down"></i>
            </div>
          </el-row>
          <el-row>
            <div class="item un_activated">同步分科分班数据</div>
          </el-row>
        </div>
        <div>
          <el-row class="arrowRightT arrowLine un_activated">
          </el-row>
          <el-row class="subClassDivision_items">
            <div>
              <div class="arrowDown independent_img4 un_activated">
                <i class="el-icon-arrow-down"></i>
              </div>
              <router-link to="/subClassDivisionHome/manuallyAdjustment" tag="div" class="item spec un_activated">手动调整
              </router-link>
              <div class="arrowLeft independent_img5 un_activated">
                <i class="el-icon-arrow-left"></i>
              </div>
            </div>
            <div>
              <div class="arrowDown independent_img4 un_activated el-row">
                <i class="el-icon-arrow-down"></i>
              </div>
              <div>
                <div class="arrowRight horizontal_imgs un_activated">
                  <i class="el-icon-arrow-right"></i>
                </div>
                <router-link to="/subClassDivisionHome/printReport" tag="div" class="item un_activated">打印报表
                </router-link>
              </div>
            </div>
          </el-row>
        </div>
      </el-row>
    </el-row>
  </div>
</template>
<script>
  export default{
    data(){
      return {
        options: [{
          value: '0',
          label: '黄金糕'
        }, {
          value: '1',
          label: '双皮奶'
        }, {
          value: '2',
          label: '蚵仔煎'
        }],
        value: ''
      }
    },
    methods: {
      getProgramme(){
        console.log(this.value);
      }
    }
  }
</script>
<style>
  .subClassDivision .steps {
    text-align: right;
  }

  .subClassDivision .step + .step {
    margin-left: 3.5rem;
  }

  .subClassDivision .step {
    position: relative;
    font-size: .875rem;
  }

  .subClassDivision .step:before {
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

  .subClassDivision .step.unable_edit:before, .subClassDivision .subClassDivision_item .item.unable_edit {
    background: #d2d2d2;
    color: #fff;
    text-align: center;
  }

  .subClassDivision .step.completed:before, .subClassDivision .subClassDivision_item .item.completed {
    background: #13b5b1;
    color: #fff;
    text-align: center;
  }

  .subClassDivision .step.main_process:before, .subClassDivision .subClassDivision_item .item.main_process {
    background: #4da1ff;
    color: #fff;
    text-align: center;
  }

  .subClassDivision .step.sec_process:before, .subClassDivision .subClassDivision_item .item.sec_process {
    background: #89bcf5;
    color: #fff;
    text-align: center;
  }

  .subClassDivision .step.un_activated:before, .subClassDivision .subClassDivision_item .item.un_activated {
    border: 1px solid #d2d2d2;
  }

  .subClassDivision .stepLists {
    width: 70rem;
    margin: auto;
  }

  .subClassDivision .subClassDivision_items > div {
    float: left;
  }

  .subClassDivision .subClassDivision_item .item {
    display: inline-block;
    width: 12.5rem;
    padding: .75rem 0;
    border-radius: 1.5rem;
    font-size: .875rem;
    text-align: center;
  }

  .subClassDivision .subClassDivision_item .item.completed, .subClassDivision .subClassDivision_item .item.main_process, .subClassDivision .subClassDivision_item .item.sec_process {
    cursor: pointer;
  }

  .subClassDivision .arrowDown, .subClassDivision .arrowRight, .subClassDivision .arrowLeft, .subClassDivision .arrowRightT {
    position: relative;
  }

  .subClassDivision .arrowDown i {
    position: absolute;
    bottom: -.8rem;
    left: -.6rem;
  }

  .subClassDivision .arrowRight i {
    position: absolute;
    top: -.5rem;
    right: -.6rem;
  }

  .subClassDivision .arrowLeft i {
    position: absolute;
    bottom: -.5rem;
    left: -.6rem;
  }

  .subClassDivision .arrowRightT i {
    position: absolute;
    bottom: -.5rem;
    right: -.6rem;
  }

  .subClassDivision .vertical_img {
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

  .subClassDivision .horizontal_img {
    display: inline-block;
    width: 2.5rem;
    margin: 1.5rem 1.2rem 1.5rem .8rem;
    border-bottom: .125rem solid;
  }

  .subClassDivision .horizontal_imgs {
    display: inline-block;
    width: 2.5rem;
    margin: 0 .8rem;
    border-bottom: .125rem solid;
  }

  .subClassDivision .independent_img1 {
    width: 10rem;
    height: 18.5rem;
    margin: 1.5rem .8rem 0 6.2rem;
    border-top: .125rem solid;
    border-left: .125rem solid;
  }

  .subClassDivision .independent_img3 {
    width: 19.375rem;
    margin: 1rem .8rem 0;
    border-bottom: .125rem solid;
  }

  .subClassDivision .independent_img4 {
    width: 0;
    height: 1.2rem;
    margin: 0 0 1rem 10.25rem;
    border-left: .125rem solid;
  }

  .subClassDivision .independent_img5 {
    width: 9.4rem;
    height: 1.3rem;
    margin: .8rem 1rem;
    border-right: .125rem solid;
    border-bottom: .125rem solid;
  }

  .subClassDivision .independent_img6 {
    width: 9.4rem;
    height: 1.625rem;
    margin: 8.5rem 1.2rem .8rem 6.25rem;
    float: right;
    border-left: .125rem solid #09baa7;
    border-top: .125rem solid #09baa7;
  }

  .subClassDivision .independent_img7 {
    width: 9.4rem;
    height: 1.625rem;
    margin: 0 1rem .8rem 6.25rem;
    border-left: .125rem solid;
    border-bottom: .125rem solid;
  }

  .subClassDivision .arrowLine {
    width: 26.5rem;
    margin-left: .8rem;
    margin-top: 1.5rem;
    border-top: .125rem solid;
  }

  .subClassDivision .group {
    border-left: 1px solid;
    border-right: 1px solid;
    margin-top: .5rem;
  }

  .subClassDivision .group > div {
    position: relative;
  }

  .subClassDivision .group > div:first-child {
    top: -1rem;
  }

  .subClassDivision .group > div:last-child {
    bottom: -1rem;
  }

  .subClassDivision .spec > div:first-child {
    margin-left: 4rem;
  }

  .subClassDivision .item.spec {
    margin-left: 4.25rem;
  }

  .subClassDivision .horizontal_img.completed i, .subClassDivision .horizontal_imgs.completed i, .subClassDivision .vertical_img.completed i, .subClassDivision .independent_img1.completed i, .subClassDivision .independent_img3.completed i, .subClassDivision .independent_img4.completed i, .subClassDivision .independent_img5.completed i, .subClassDivision .independent_img6.completed i, .subClassDivision .independent_img7.completed i {
    color: #09baa7;
  }

  .subClassDivision .horizontal_imgs.completed, .subClassDivision .vertical_img.completed, .subClassDivision .horizontal_img.completed, .subClassDivision .independent_img1.completed, .subClassDivision .independent_img3.completed, .subClassDivision .independent_img4.completed, .subClassDivision .independent_img5.completed, .subClassDivision .independent_img6.completed, .subClassDivision .independent_img7.completed, .subClassDivision .arrowLine.completed, .subClassDivision .group.completed {
    border-color: #09baa7;
  }

  .subClassDivision .horizontal_img.main_process i, .subClassDivision .horizontal_imgs.main_process i, .subClassDivision .vertical_img.main_process i, .subClassDivision .independent_img1.main_process i, .subClassDivision .independent_img3.main_process i, .subClassDivision .independent_img4.main_process i, .subClassDivision .independent_img5.main_process i, .subClassDivision .independent_img6.main_process i, .subClassDivision .independent_img7.main_process i {
    color: #4da1ff;
  }

  .subClassDivision .horizontal_imgs.main_process, .subClassDivision .vertical_img.main_process, .subClassDivision .horizontal_img.main_process, .subClassDivision .independent_img1.main_process, .subClassDivision .independent_img3.main_process, .subClassDivision .independent_img4.main_process, .subClassDivision .independent_img5.main_process, .subClassDivision .independent_img6.main_process, .subClassDivision .independent_img7.main_process, .subClassDivision .arrowLine.main_process, .subClassDivision .group.main_process {
    border-color: #4da1ff;
  }

  .subClassDivision .horizontal_img.sec_process i, .subClassDivision .horizontal_imgs.sec_process i, .subClassDivision .vertical_img.sec_process i, .subClassDivision .independent_img1.sec_process i, .subClassDivision .independent_img3.sec_process i, .subClassDivision .independent_img4.sec_process i, .subClassDivision .independent_img5.sec_process i, .subClassDivision .independent_img6.sec_process i, .subClassDivision .independent_img7.sec_process i {
    color: #89bcf5;
  }

  .subClassDivision .horizontal_imgs.sec_process, .subClassDivision .vertical_img.sec_process, .subClassDivision .horizontal_img.sec_process, .subClassDivision .independent_img1.sec_process, .subClassDivision .independent_img3.sec_process, .subClassDivision .independent_img4.sec_process, .subClassDivision .independent_img5.sec_process, .subClassDivision .independent_img6.sec_process, .subClassDivision .independent_img7.sec_process, .subClassDivision .arrowLine.sec_process, .subClassDivision .group.sec_process {
    border-color: #89bcf5;
  }

  .subClassDivision .horizontal_img.un_activated i, .subClassDivision .horizontal_imgs.un_activated i, .subClassDivision .vertical_img.un_activated i, .subClassDivision .independent_img1.un_activated i, .subClassDivision .independent_img3.un_activated i, .subClassDivision .independent_img4.un_activated i, .subClassDivision .independent_img5.un_activated i, .subClassDivision .independent_img6.un_activated i, .subClassDivision .independent_img7.un_activated i {
    color: #d2d2d2;
  }

  .subClassDivision .horizontal_imgs.un_activated, .subClassDivision .vertical_img.un_activated, .subClassDivision .horizontal_img.un_activated, .subClassDivision .independent_img1.un_activated, .subClassDivision .independent_img3.un_activated, .subClassDivision .independent_img4.un_activated, .subClassDivision .independent_img5.un_activated, .subClassDivision .independent_img6.un_activated, .subClassDivision .independent_img7.un_activated, .subClassDivision .arrowLine.un_activated, .subClassDivision .group.un_activated {
    border-color: #d2d2d2;
  }

  .subClassDivision .horizontal_img.unable_edit i, .subClassDivision .horizontal_imgs.unable_edit i, .subClassDivision .vertical_img.unable_edit i, .subClassDivision .independent_img1.unable_edit i, .subClassDivision .independent_img3.unable_edit i, .subClassDivision .independent_img4.unable_edit i, .subClassDivision .independent_img5.unable_edit i, .subClassDivision .independent_img6.unable_edit i, .subClassDivision .independent_img7.unable_edit i {
    color: #d2d2d2;
  }

  .subClassDivision .horizontal_imgs.unable_edit, .subClassDivision .vertical_img.unable_edit, .subClassDivision .horizontal_img.unable_edit, .subClassDivision .independent_img1.unable_edit, .subClassDivision .independent_img3.unable_edit, .subClassDivision .independent_img4.unable_edit, .subClassDivision .independent_img5.unable_edit, .subClassDivision .independent_img6.unable_edit, .subClassDivision .independent_img7.unable_edit, .subClassDivision .arrowLine.unable_edit, .subClassDivision .group.unable_edit {
    border-color: #d2d2d2;
  }
</style>
