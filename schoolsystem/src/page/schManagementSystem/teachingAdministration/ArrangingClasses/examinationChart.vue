<template>
  <div class="examChart">
    <header class="g-examHeader clear_fix">
      <el-button class="g-gobackChart RedButton" @click="goBackChart">
        <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
        返回
      </el-button>
      <h2>排课流程图</h2>
      <h2 class="activeFont" v-text="headerText"></h2>
    </header>
    <section class="g-examSection">
      <div class="g-row">
        <div class="g-col_3x"></div>
        <div class="g-col_1x">
          <div class="g-column_container">
            <router-link to="importCourse" class="g-column_con_blue">导入课表</router-link>
            <div class="g-column_left_row1 g_flex">
              <div class="g-column_left_line_row"></div>
              <div class="g-column_left_arrow_row">
                <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/arrow_blue.png" />
              </div>
            </div>
            <div class="g-column_right_row1">
              <div class="g-column_right_line_row"></div>
              <div class="g-column_right_arrow_row">
                <img class="column_img" src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/arrow_blue.png" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--箭头行-->
      <div class="g-row">
        <div class="g-col_3x"></div>
        <div class="g-col_1x">
          <div class="g-column_container">
            <div class="g-column_line_con">
              <div class="g-column_line"></div>
              <div class="g-column_img">
                <img class="column_img" src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/arrow_blue.png" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="g-row">
        <div class="g-col_1x">
          <div class="g-column_container">
            <a class="g-column_con_blue" v-text="headerText"></a>
            <div class="g-column_right_row2 g_flex">
              <div class="g-column_right_line_row"></div>
              <div class="g-column_right_arrow_row">
                <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/arrow_blue.png" />
              </div>
            </div>
          </div>
        </div>
        <div class="g-col_1x">
          <div class="g-column_container">
            <div class="g-column_con_blue_more">
              <router-link to="timeSetting" class="g-column_con_blue">上课时间设置</router-link>
              <router-link to="teachingPlan" class="g-column_con_blue">教学计划设置</router-link>
            </div>
            <div class="g-column_right_row2 hasMoreA_blue g_flex">
              <div class="g-column_right_line_row"></div>
              <div class="g-column_right_arrow_row">
                <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/arrow_blue.png" />
              </div>
            </div>
          </div>
        </div>
        <div class="g-col_1x">
          <div class="g-column_container">
            <router-link to="AutomaticScheduce" class="g-column_con_blue">自动排课</router-link>
            <div class="g-column_right_row2 g_flex">
              <div class="g-column_right_line_row"></div>
              <div class="g-column_right_arrow_row">
                <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/arrow_blue.png" />
              </div>
            </div>
          </div>
        </div>
        <div class="g-col_1x">
          <div class="g-column_container">
            <router-link to="ManualScheduce" class="g-column_con_blue">手动调整</router-link>
            <div class="g-column_right_row2 g_flex">
              <div class="g-column_right_line_row"></div>
              <div class="g-column_right_arrow_row">
                <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/arrow_blue.png" />
              </div>
            </div>
          </div>
        </div>
        <div class="g-col_last">
          <div class="g-column_container">
            <router-link to="PublishCourse" class="g-column_con_blue">发布课程</router-link>
          </div>
        </div>
      </div>
      <!--箭头行-->
      <div class="g-row">
        <div class="g-col_1x"></div>
        <div class="g-col_1x">
          <div class="g-column_container">
            <div class="g-column_line_con">
              <div class="g-column_line"></div>
              <div class="g-column_img">
                <img class="column_img" src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/arrow_blue.png" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="g-row">
        <div class="g-col_1x"></div>
        <div class="g-col_1x">
          <div class="g-column_container">
            <div class="g-column_con_green_more">
              <router-link to="classesTimeSetting" class="g-column_con_green">班级上课时间限制</router-link>
              <router-link to="courseTimeSetting" class="g-column_con_green">课程上课时间限制</router-link>
              <router-link to="teacherTimeSetting" class="g-column_con_green">教师上课时间限制</router-link>
              <router-link to="coursePrevious" class="g-column_con_green">课程预先安排</router-link>
              <router-link to="workTogetherTimeSetting" class="g-column_con_green">合班课程设置</router-link>
            </div>
            <div class="g-column_right_row3 hasMoreA_green">
              <div class="g-column_right_line_row"></div>
              <div class="g-column_right_arrow_row">
                <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/arrow_green.png" />
              </div>
            </div>
          </div>
        </div>
        <div class="g-col_2x"></div>
        <div class="g-col_last">
          <div class="g-column_container">
            <router-link to="classSchedule" class="g-column_con_blue">课程表</router-link>
            <div class="g-column_left_row3 g_flex">
              <div class="g-column_left_line_row"></div>
              <div class="g-column_left_arrow_row">
                <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/arrow_blue.png" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
  import {mapState} from 'vuex'
  export default{
    data(){
      return {}
    },
    computed:{
      ...mapState({headerText:'theArrangeClasses'}),
    },
    methods:{
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'arrangeManage'});
      },
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/arrangeClasses/arrangeClasses.css';
  @import '../../../../style/arrangeClasses/examChart.less';
</style>



