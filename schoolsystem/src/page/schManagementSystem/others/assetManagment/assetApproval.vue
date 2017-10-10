<template>
  <div class="g-classSchedule">
    <header class="g-timeHeader g-flexStartRow">
      <div class="g-headerButtonGroup">
        <h2>资产审批</h2>
      </div>
      <ul class="changeRouter selfCenter clear_fix">
        <li class="activeCss" data-msg="assetPendApproval" @click="changeRouterClick">待审批</li>
        <li class="normalCss" data-msg="assetAlreadyApproval" @click="changeRouterClick">已审批</li>
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




