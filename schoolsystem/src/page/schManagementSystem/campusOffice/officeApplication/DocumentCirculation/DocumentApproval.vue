<template>
  <div class="LeaveRecord">
    <el-col :span="24">
      <h3 class="DocAp-title">公文流转审批</h3>
      <div class="DocAp-title" style="margin-left: 1.8rem;">
        <span v-for="(list,index) in AppLists"
              :class="{ Topactive:changeTopcolor == index}"
              @click="toggleTitleClass(index,list)">{{list.text}}
        </span>
      </div>
    </el-col>
    <router-view></router-view>
  </div>
</template>
<script>
  export default{
    data(){
      return{
        changeTopcolor:0,
        AppLists:[{
            text:'未审批'
        },{
          text:'已审批'
        }],
      }
    },
    created(){
      if(this.$route.path.indexOf('/DocumentApproval/DocApproved')>-1){
        this.$router.push('/DocumentApproval')
      }
    },
    methods:{
      toggleTitleClass:function(index){
        this.changeTopcolor = index;
        if(index===0){
          this.$router.push('/DocumentApproval')
        }else{
          this.$router.push('/DocumentApproval/DocApproved')
        }
      },
    }
  }
</script>
<style>
  .DocAp-title{
    display: inline-block;
  }
  .DocAp-title>span{
    cursor: pointer;
    margin-left: .5rem;
  }
  .DocAp-title>span:first-child{
    padding-right: 1rem;
    border-right: 1px solid #d2d2d2;
  }
  .DocAp-title>span:last-child{
    padding-left: 1rem;
  }
  .Topactive{
    color: #4ba8ff;
  }
  .LeaveRecord{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .LeaveRecord-title{
    margin-top: 2rem;
    padding-bottom: 1.3rem;
    border-bottom: 1px solid #d2d2d2;
  }
  .LeaveRecord-search{
    background: #4da1ff;
    width: 7.6rem;
  }
  .alertsBtn{
    margin-top: 1.5rem;
  }
  .LeaveRecord-dialog-title{
    display: inline-block;
    margin: auto;
    font-weight: bold;
    font-size: 16px;
    padding-bottom: 1.2rem;
  }
  .LeaveRecord-table-div{
    width: 100%;
    height: 2.625rem;
    border-top: 1px solid #d2d2d2;
    text-align: center;
    line-height: 2.625rem;
    box-sizing:border-box;
  }
  .LeaveRecord-table-div-final{
    border-bottom: 1px solid #d2d2d2;
  }
  .LeaveRecord-table-div-1{
    border-right: 1px solid #d2d2d2;
  }
  .LeaveRecord-state-btn{
    width: 6.25rem;
    height: 1.875rem;
    background:#4ba8ff;
    color:#fff;
    text-align: center;
    line-height: 1.875rem;
    border-top-right-radius: 1.1rem;
    border-bottom-right-radius: 1.1rem;
    margin-top: 1.2rem;
  }
  .LeaveRecord-agreed{
    width: 5rem;
    height: 2rem;
    text-align: center;
    display: inline-block;
    line-height: 2rem;
    cursor: pointer;
    font-size: 14px;
    color: #888888;
    border: 1px solid #d2d2d2;
    border-top-left-radius: 1rem;
    border-bottom-left-radius: 1rem;
  }
  .LeaveRecord-agreed:last-of-type{
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    border-top-right-radius: 1rem;
    border-bottom-right-radius: 1rem;
  }
  .active{
    background: #09baa7;
    color: #fff;
    border: 1px solid #09baa7;
  }
  .agreed2{
    border-top-right-radius: 1rem;
    border-bottom-right-radius: 1rem;
  }
  .Infor-input-inner .el-input__inner{
    border-radius: 1.2rem;
  }
</style>
