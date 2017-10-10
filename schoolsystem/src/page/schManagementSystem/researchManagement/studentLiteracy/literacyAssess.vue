<template>
  <div class="g-container">
    <header class="g-textHeader g-flexStartRow">
      <div class="g-headerButtonGroup">
        <h2>素养考核方向</h2>
      </div>
    </header>
    <section>
      <header class="g-textHeader">
        <div class="g-liOneRow g-sa_header_search">
          <div class="gs-button alertsBtn">
            <el-button type="primary" @click="totalApproval"><i class="el-icon-plus"></i>添加考核方向</el-button>
          </div>
          <div class="gs-refresh g-fuzzyInput">
            <el-input type="text" v-model="fuzzyInput" icon="search" placeholder="班级/姓名" :on-icon-click="fuzzyClick"></el-input>
          </div>
        </div>
      </header>
      <section class="centerTable alertsList">
        <el-table class="g-NotHover g-fixedColumn" :data="classesTimeSetTable" @selection-change="handleSelectionChange" @sort-change="sortChange">
          <el-table-column label="素养考核方向"></el-table-column>
          <el-table-column label="满分分数" prop="name"></el-table-column>
          <el-table-column label="操作" width="150" fixed="right">
            <template scope="props">
              <el-button type="text" @click="handleClick">编辑</el-button>
              <el-button class="deleteColor" type="text">删除</el-button>
            </template>
          </el-table-column>
        </el-table>
      </section>
      <el-dialog class="g-tree_content g-defineDialog headerNotBackground" size="tiny" :title="dialogTitle" :modal="false" :visible.sync="isDialog" :before-close="handlerClose">
        <el-form :model="gradeDialogForm" ref="dialogForm" label-width="100px" label-position="right">
          <el-form-item label="素养考核方向:">
            <el-input v-model="gradeDialogForm.direction" placeholder="请输入考核方向"></el-input>
          </el-form-item>
        </el-form>
        <div class="g-button">
          <el-button type="primary">确定</el-button>
          <el-button>取消</el-button>
        </div>
      </el-dialog>
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
        classesTimeSetTable:[{name:1}],
        /*弹框*/
        isDialog:false,
        dialogTitle:'添加考核方向',
        gradeDialogForm:{
          name:'',
          range:'',
          startDate:'',
          startTime:'',
          endDate:'',
          endTime:'',
          direction:'',
          isPersonScore:false,
          headTeacher:'',
          secondTeacher:'',
          studentScore:'',
        },
        /*tree*/
        treeData:[],
        defaultProps: {
          children: 'data',
          label:'techerName',
        },
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
      /*弹框*/
      handlerClose(done){
        done();
      },
      /*table*/
      fuzzyTableClick(){},
      handleSelectionChange(val){
        console.log(val);
      },
      sortChange(column,prop,order){},
      handleClick(){
        this.$router.push('/handleLiteracyAssess');
      },
      /*批量审批*/
      totalApproval(){
        this.isDialog=true;
        this.dialogTitle='创建考核方向';
      },
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/test';
  @import '../../../../style/style';
  .g-sa_header_search{.marginTop(32);.marginBottom(20);}
  .headerNotBackground.g-tree_content{
    .g-sectionR{.width(585,940);margin:0;}
    .g-sectionL{.width(330,940);.NotLineheight(541);}
  }

  /*弹框*/
  .g-tree_content h2{text-align:center;.fontSize(12);color:@HColor;padding-bottom:20/16rem;}
  .g-tree_content .el-dialog--tiny{.NotLineheight(560);}
  /*容器*/
  .gs-button button{
    i{.fontSize(14);margin-right:10/16rem;}
  }
  .g-tree_content .g-flexStartRow>div:not(:first-of-type){margin-left:2rem;}
  .g-dialogOther{padding-left:15/16rem;padding-bottom:20/16rem;}
</style>


