<template>
  <div v-show="childShowName">
    <div class="ChildNavShow" v-text="navMsgSend.Msg"></div>
    <ul class="ChildNav">
      <li @click="chooseChild" v-for="childNav in navMsgSend.NavTotal" v-text="childNav"></li>
    </ul>
  </div>
</template>
<script>
  export default{
    data(){
      return {
        isSearchNav:false,
        isGslbNav:false,
        isChartsNav:false,
        isReportNav:false,
      }
    },
    props:['childShowName'],
    methods:{
      chooseChild(){
        console.log(1);
      }
    }
  }
</script>
<style lang="less">
  .ChildNavShow{position:relative;width:auto;
    &:after{content:"";}
  }
</style>




