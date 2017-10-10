<template>
  <div class="g-container">
    <header class="g-importCourseHeader">
      <div class="g-textHeader g-flexStartRow">
        <h2 class="selfCenter">回答详情</h2>
      </div>
      <div class="g-flexStartRow g-selectPadding">
        <el-form class="moreFormItem" :model="createPlacementForm" label-width="100px" label-position="left">
          <el-form-item label="问卷名称:">
            <el-select v-model="createPlacementForm.name">
              <el-option label="测试" value="0"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="统计维度:">
            <el-select v-model="createPlacementForm.statistic">
              <el-option label="系统内外数据" value="0"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="系统内外数据:">
            <el-select v-model="createPlacementForm.data">
              <el-option label="汇总数据" value="0"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="过滤重复IP:">
            <el-switch v-model="createPlacementForm.isSwitch" on-text="是" off-text="否" on-color="#13b5b1" off-color=""></el-switch>
          </el-form-item>
        </el-form>
        <el-button type="primary" class="radiusButton selfTop" icon="search">查询</el-button>
      </div>
    </header>
    <div class="g-container g-containerNoPadding">
      <section class="g-section">
        <div class="gs-table centerTable alertsList">
          <el-table class="g-NotHover" ref="studentMsgTable" :data="headerButtonData.studentBasicMsg" style="width:100%" @sort-change="sortChange" @selection-change="handleStudentTable">
            <!--show-overflow-tooltip 超出部分省略号显示-->
            <el-table-column label="姓名"></el-table-column>
            <el-table-column label="提交问卷时间" sortable></el-table-column>
            <el-table-column label="所用时间" sortable></el-table-column>
            <el-table-column label="年级班级"></el-table-column>
            <el-table-column label="部门"></el-table-column>
            <el-table-column label="操作" fixed="right">
              <template scope="props">
                <el-button type="text" @click="scanQNaire">查看问卷</el-button>
              </template>
            </el-table-column>
          </el-table>
        </div>
      </section>
    </div>
  </div>
</template>
<script>
  import {} from '@/api/http'
  export default{
    data(){
      return{
        /*ajax data*/
        headerButtonData:{
          studentBasicMsg:[1],
        },
        priority:'',
        /*fuzzyFilter*/
        fuzzyInput:'',
        /*生成分班*/
        createPlacementForm:{
          name:'',
          statistic:'',
          data:'',
          isSwitch:false,
        },
      }
    },
    computed: {},
    methods:{
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'newStudentClass'});
      },
      /*table*/
      handleStudentTable(section){
        /*section为选择项行信息组成的数组*/
        console.log(section);
      },
      sortChange(column){
        /*table排序回调*/
        console.log(column)
      },
      /*查看问卷*/
      scanQNaire(){
        this.$router.push({name:'scanQuestionNaire',params:{id:1}});
      },
      /*header的button群*/
      /*模糊查询*/
      fuzzyClick(){
        /*点击search按钮*/
        console.log('模糊查询');
      },
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/style';
  .g-importCourse .g-container .g-section{margin:1.25rem 0;width:100%;}
  .g-container header.g-importCourseHeader{padding:0;}
  /*弹框*/
  .headerNotBackground{
    .dialogHeader{position:absolute;right:20px;top:0.625rem;
      button{.border-radius(1rem);}
    }
    .dialogSection{
      .NotAllWidth{width:auto;}
      .defineInputWidth{.widthRem(60);}
    }
  }
  .g-flexStartRow{.fontSize(14);
    span{padding-left:30/16rem;.fontSize(14);}
  }
  .g-flexStartRow.g-selectPadding{padding:20/16rem 0 0;}
</style>








