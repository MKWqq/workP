<template>
  <div class="g-classSchedule">
    <header class="g-timeHeader g-flexStartRow">
      <div class="g-headerButtonGroup">
        <el-button class="g-gobackChart RedButton" @click="goBackChart">
          <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
          返回流程图
        </el-button>
      </div>
      <ul class="changeRouter selfCenter clear_fix">
        <li class="activeCss" data-msg="classesSchedule" @click="changeRouterClick">班级课表</li>
        <li class="normalCss" data-msg="teacherSchedule" @click="changeRouterClick">教师课表</li>
        <li class="normalCss" data-msg="totalSchedule" @click="changeRouterClick">总课表</li>
      </ul>
    </header>
    <router-view></router-view>
  </div>
</template>
<script>
  import {mapState} from 'vuex'
  import {classesTimeSettingGrade,//得到班级年级
    classesTimeSettingTable,/*table默认数据*/
    classesTimeSettingSaved,//保存时间限制
  } from '@/api/http'
  export default{
    data(){
      return{
      }
    },
    computed:{
      ...mapState(['pkListId']),
    },
    methods:{
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'examinationChart'});
      },
      /*顶部li标签点击事件*/
      changeRouterClick(event){
        const e=$(event.currentTarget);
        e.addClass('activeCss');
        e.removeClass('normalCss');
        e.siblings().addClass('normalCss');
        e.siblings().removeClass('activeCss');
        this.$router.push({name:e.data('msg')});
      },
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/style';
  @import '../../../../style/arrangeClasses/classSchedule';
  @import '../../../../style/arrangeClasses/arrangeClasses.css';
</style>




