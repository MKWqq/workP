<template>
  <div class="g-container">
    <header class="g-textHeader">
      <div class="g-liOneRow g-sa_header_search">
        <div class="gs-button alertsBtn">
          <el-button type="primary" @click="totalApproval">批量审批</el-button>
        </div>
        <div class="gs-refresh g-fuzzyInput">
          <el-input type="text" v-model="fuzzyInput" icon="search" placeholder="班级/姓名" :on-icon-click="fuzzyClick"></el-input>
        </div>
      </div>
    </header>
    <section class="centerTable alertsList">
      <el-table class="g-NotHover" :data="classesTimeSetTable" @selection-change="handleSelectionChange" @sort-change="sortChange">
        <el-table-column type="selection"></el-table-column>
        <el-table-column label="序号" type="index" width="100px"></el-table-column>
        <el-table-column label="业务名称"></el-table-column>
        <el-table-column label="资产名称"></el-table-column>
        <el-table-column label="资产编号" prop="name"></el-table-column>
        <el-table-column label="分类代码" prop="name"></el-table-column>
        <el-table-column label="总价(元)"></el-table-column>
        <el-table-column label="业务日期"></el-table-column>
        <el-table-column label="申请日期"></el-table-column>
        <el-table-column label="使用地址"></el-table-column>
        <el-table-column label="操作" width="150" fixed="right">
          <template scope="props">
            <el-button type="text" @click="isDialog=true">审批</el-button>
          </template>
        </el-table-column>
      </el-table>
    </section>
    <el-dialog class="g-tree_content" title="资产审批" :modal="false" :visible.sync="isDialog" :before-close="handlerClose">
      <div class="g-dialogConContainer">
        <h2 class="g-titleContent" v-text="">123</h2>
        <ul>
          <li class="g-dialogRow g-flexStartRow">
            <div>资产名称</div>
            <div v-text="">空调</div>
          </li>
          <li class="g-dialogRow g-flexStartRow">
            <div>领用人</div>
            <div v-text="">空调</div>
          </li>
          <li class="g-dialogRow g-flexStartRow">
            <div>资产编号</div>
            <div v-text="">空调</div>
          </li>
          <li class="g-dialogRow g-flexStartRow">
            <div>分类代码</div>
            <div v-text="">空调</div>
          </li>
          <li class="g-dialogRow g-flexStartRow">
            <div>单价（元）</div>
            <div v-text="">空调</div>
          </li>
          <li class="g-dialogRow g-flexStartRow">
            <div>业务日期</div>
            <div v-text="">空调</div>
          </li>
          <li class="g-dialogRow g-flexStartRow">
            <div>申请时间</div>
            <div v-text="">空调</div>
          </li>
          <li class="g-dialogRow g-flexStartRow">
            <div>使用地址</div>
            <div v-text="">空调</div>
          </li>
          <li class="g-dialogRow g-flexStartRow">
            <div>说明</div>
            <div v-text="">空调</div>
          </li>
        </ul>
        <div class="g-contentOne_header">我的审批</div>
        <div class="g-chooseButton g-flexStartRow">
          <span class="selfCenter">审批结果:</span>
          <div class="activeCss" @click="changeTypeClick">通过</div>
          <div class="normalCss" @click="changeTypeClick">不通过</div>
        </div>
        <div class="g-chooseButton g-flexStartRow">
          <span class="selfCenter">审批意见:</span>
          <el-input type="textarea" v-model="opinionTextarea" :maxlength="100" style="width:50%;"></el-input>
        </div>
      </div>
      <div class="g-footer">
        <el-button class="radiusButton" type="primary">提交</el-button>
      </div>
    </el-dialog>
    <el-dialog class="g-tree_content" title="资产批量审批" :modal="false" :visible.sync="isTotalDialog" :before-close="handlerTotalClose">
      <div>
        <div class="g-contentOne_header">我的审批</div>
        <div class="g-chooseButton g-flexStartRow">
          <span class="selfCenter">审批结果:</span>
          <div class="activeCss" @click="changeTypeClick">通过</div>
          <div class="normalCss" @click="changeTypeClick">不通过</div>
        </div>
        <div class="g-chooseButton g-flexStartRow">
          <span class="selfCenter">审批意见:</span>
          <el-input type="textarea" v-model="opinionTotalTextarea" :maxlength="100" style="width:80%;"></el-input>
        </div>
      </div>
      <div class="g-footer">
        <el-button class="radiusButton" type="primary">提交</el-button>
      </div>
    </el-dialog>
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
        /*弹框——单个审批*/
        isDialog:false,
        opinionTextarea:'',
        /*弹框——批量审批*/
        isTotalDialog:false,
        opinionTotalTextarea:'',
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
      /*弹框——单个审批*/
      handlerClose(done){
        done();
      },
      /*调整方式*/
      changeTypeClick(event){
        let e=$(event.currentTarget);
        this.changeCss(e,'activeCss','normalCss');
      },
      changeCss(e,active,normal){
        e.removeClass(normal);
        e.siblings().removeClass(active);
        e.addClass(active);
        e.siblings().addClass(normal);
      },
      /*弹框——批量审批*/
      handlerTotalClose(done){
        done();
      },
      /*table*/
      fuzzyTableClick(){},
      handleSelectionChange(val){
        console.log(val);
      },
      sortChange(column,prop,order){},
      /*批量审批*/
      totalApproval(){
        this.isTotalDialog=true;
      },
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../../style/test';
  @import '../../../../../style/style';
  @import '../../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.css';
  @import '../../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.less';
  .g-sa_header_search{.marginTop(32);.marginBottom(20);}
  div.g-container{padding:0;width:100%;}
  .headerNotBackground.g-tree_content{
    .g-sectionR{.width(585,940);margin:0;}
    .g-sectionL{.width(330,940);.NotLineheight(541);}
  }

  /*弹框*/
  .g-tree_content h2{text-align:center;.fontSize(12);color:@HColor;padding-bottom:20/16rem;}
  .g-tree_content .el-dialog--tiny{.NotLineheight(560);}
  /*容器*/
  .g-dialogConContainer{width:100%;.NotLineheight(405);overflow-x:hidden;overflow-y:auto;}
  .g-tree_content ul{
    width:100%;border-top:1px solid @borderColor;border-bottom:1px solid @borderColor;.marginBottom(24);
  }
  /*行*/
  .g-tree_content .g-dialogRow{
    width:100%;
    &:not(:last-of-type){border-bottom:1px solid @borderColor;}
  }
  /*列*/
  .g-tree_content .g-dialogRow>div{
    text-align:center;.fontSize(14);color:@normalColor;padding:15/16rem 0;
    &:nth-of-type(odd){width:35.7%;border-right:1px solid @borderColor;}
    &:nth-of-type(even){width:64.3%;}
  }

  .g-contentOne_header{.widthRem(100);.height(30);margin-bottom:25/16rem;font-size:14/16rem;color:#fff;background:@buttonActive;.box-shadow(0 4/16rem 6/16rem 0 rgba(0,0,0,.2));text-align:center;.border-bottom-right-radius(15/16rem);.border-top-right-radius(15/16rem);}
  /*审批结果处css*/
  .g-chooseButton{/*1582*/
    width:100%;padding:0 0 30/16rem 60/16rem;.fontSize(14);color:@normalColor;
    span{margin-right:20/16rem;}
    div{.widthRem(80);.height(30);text-align:center;.box-sizing();
      &:hover{cursor:pointer;}
      &:first-of-type{.border-bottom-left-radius(15/16rem);.border-top-left-radius(15/16rem);}
      &:last-of-type{.border-top-right-radius(15/16rem);.border-bottom-right-radius(15/16rem);}
    }
    div.activeCss{background:@green;color:#fff;border:none;}
    div.normalCss{color:@normalColor;border:1px solid @borderColor;}
  }
  .g-footer{width:100%;padding:24/16rem 0;text-align:center;}
</style>


