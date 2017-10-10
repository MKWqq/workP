<template>
  <div class="g-statisticalAnalysis g-container">
    <header class="g-textHeader">
      <h2>问卷记录</h2>
      <div class="g-flexEndRow g-sa_header_search">
        <div class="gs-refresh g-fuzzyInput">
          <el-input type="text" v-model="fuzzyInput" icon="search" placeholder="班级/姓名" :on-icon-click="fuzzyClick"></el-input>
        </div>
      </div>
    </header>
    <section class="centerTable alertsList">
      <el-table class="g-NotHover" :data="classesTimeSetTable">
        <el-table-column label="问卷名"></el-table-column>
        <el-table-column label="创建时间"></el-table-column>
        <el-table-column label="问卷状态"></el-table-column>
        <el-table-column label="填写人数">
          <template scope="props">
            <el-button @click="fillInProgressClick" type="text" v-text="props.row.name"></el-button>
          </template>
        </el-table-column>
        <el-table-column label="问卷浏览器"></el-table-column>
        <el-table-column label="操作" width="500px" fixed="right">
          <template scope="props">
            <el-button @click="handlerClick" type="text">编辑</el-button>
            <el-button v-if="props.row.name==1" class="deleteColor" type="text">撤回</el-button>
            <el-button v-else type="text">发布</el-button>
            <el-button class="greenButtonColor" @click="shareQuestionNaire" type="text">分享</el-button>
            <el-button class="greenButtonColor" @click="scanQuestionNaire" type="text">预览</el-button>
            <el-button class="greenButtonColor" type="text">复制</el-button>
            <el-button class="greenButtonColor" type="text">下载</el-button>
            <el-button class="deleteColor" type="text">删除</el-button>
          </template>
        </el-table-column>
      </el-table>
    </section>
  </div>
</template>
<script>
  import {} from '@/api/http'
  export default{
    data(){
      return{
        /*模糊查询*/
        fuzzyInput:'',
        evaluationName:'',
        /*table*/
        classesTimeSetTable:[{name:1},{name:2}],
      }
    },
    methods:{
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'evaluationManagement'});
      },
      /*模糊查询*/
      fuzzyClick(){
        /*模糊查询执行回调*/
      },
      /*table*/
      /*填写人数点击*/
      fillInProgressClick(){
        this.$router.push('/fillInProgress');
      },
      /*编辑*/
      handlerClick(){
        this.$router.push('/newQuestionNaire/handle');
      },
      /*预览*/
      scanQuestionNaire(){
        this.$router.push({name:'scanQuestionNaire',params:{id:0}});
      },
      /*分享*/
      shareQuestionNaire(){
        this.$router.push({name:'shareQuestionNaire'});
      },
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/style';
  .g-sa_header_search{.marginTop(20);.marginBottom(20);}
</style>


