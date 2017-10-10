<template>
  <div class="g-container">
    <header class="g-textHeader g-flexStartRow">
      <div class="g-headerButtonGroup">
        <h2>方案管理</h2>
      </div>
    </header>
    <section>
      <header class="g-textHeader">
        <div class="g-liOneRow g-sa_header_search">
          <div class="gs-button alertsBtn">
            <el-button type="primary" @click="totalApproval"><i class="el-icon-plus"></i>新建方案</el-button>
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
        <el-form :model="gradeDialogForm" ref="dialogForm" label-width="90px" label-position="right">
          <el-form-item label="方案名称:" required>
            <el-input v-model="gradeDialogForm.name" placeholder="请输入方案名称"></el-input>
          </el-form-item>
          <el-form-item label="考核范围:">
            <el-select v-model="gradeDialogForm.range" style="width:100%;">
              <el-option label="ww" value="0"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="起始时间:">
            <el-col :span="11">
              <el-date-picker type="date" placeholder="选择日期" v-model="gradeDialogForm.startDate" style="width: 100%;"></el-date-picker>
            </el-col>
            <el-col class="line" :span="2">-</el-col>
            <el-col :span="11">
              <el-time-picker type="fixed-time" placeholder="选择时间" v-model="gradeDialogForm.startTime" style="width: 100%;"></el-time-picker>
            </el-col>
          </el-form-item>
          <el-form-item label="结束时间:">
            <el-col :span="11">
              <el-date-picker type="date" placeholder="选择日期" v-model="gradeDialogForm.endDate" style="width: 100%;"></el-date-picker>
            </el-col>
            <el-col class="line" :span="2">-</el-col>
            <el-col :span="11">
              <el-time-picker type="fixed-time" placeholder="选择时间" v-model="gradeDialogForm.endTime" style="width: 100%;"></el-time-picker>
            </el-col>
          </el-form-item>
          <el-form-item label="考核方向:">
            <el-select v-model="gradeDialogForm.direction" style="width:100%;">
              <el-option label="ww" value="0"></el-option>
            </el-select>
          </el-form-item>
          <div class="g-dialogOther">
            <span>需要角色评分:</span>
            <el-switch on-text="是" off-text="否" on-color="" off-color="" v-model="gradeDialogForm.isPersonScore"></el-switch>
          </div>
          <div class="g-dialogOther g-flexStartRow" v-if="gradeDialogForm.isPersonScore">
            <div>
              <span>班主任:</span>
              <el-input class="defineInputWidth" v-model="gradeDialogForm.headTeacher"></el-input>
              <span>%</span>
            </div>
            <div>
              <span>任课老师:</span>
              <el-input class="defineInputWidth" v-model="gradeDialogForm.secondTeacher"></el-input>
              <span>%</span>
            </div>
            <div>
              <span>学生自评:</span>
              <el-input class="defineInputWidth" v-model="gradeDialogForm.studentScore"></el-input>
              <span>%</span>
            </div>
          </div>
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
        this.isDialog=true;
        this.dialogTitle='修改考核方案';
      },
      /*批量审批*/
      totalApproval(){
        this.isDialog=true;
        this.dialogTitle='创建考核方案';
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


