<template>
  <div class="g-classSchedule">
    <header class="g-timeHeader g-flexStartRow">
      <div class="g-headerButtonGroup g-flexStartRow">
        <el-button class="g-gobackChart RedButton" @click="goBackChart">
          <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
          返回
        </el-button>
        <h2 class="selfCenter">填写进度</h2>
      </div>
      <ul class="changeRouter selfCenter clear_fix">
        <li class="activeCss" data-msg="teacherFillIn" @click="changeRouterClick">教师</li>
        <li class="normalCss" data-msg="studentFillIn" @click="changeRouterClick">学生</li>
        <li class="normalCss" data-msg="staffFillIn" @click="changeRouterClick">职工</li>
        <li class="normalCss" data-msg="parentFillIn" @click="changeRouterClick">家长</li>
        <li class="normalCss" data-msg="othersFillIn" @click="changeRouterClick">其他</li>
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
        this.$router.push({name:'questionNaireRecord'});
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
  .g-headerButtonGroup h2{margin-left:20/16rem;}
</style>




