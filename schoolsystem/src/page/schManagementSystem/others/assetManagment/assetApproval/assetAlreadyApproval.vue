<template>
  <div class="g-container">
    <header class="g-textHeader">
      <div class="g-liOneRow g-sa_header_search">
        <div class="gs-button alertsBtn">
          <el-button-group>
            <el-button class="filt buttonChild" title="导出">
              <img class="filt_unactive"  src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png" />
              <img class="filt_active" src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png" />
            </el-button>
            <el-button class="filt buttonChild" title="打印预览">
              <img class="filt_unactive"  src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png" />
              <img class="filt_active" src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png" />
            </el-button>
          </el-button-group>
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
        <el-table-column label="业务名称">
          <template scope="props">
            <el-button type="text" v-text="props.row.name" @click="isDialog=true"></el-button>
          </template>
        </el-table-column>
        <el-table-column label="资产名称"></el-table-column>
        <el-table-column label="资产编号" prop="name"></el-table-column>
        <el-table-column label="分类代码" prop="name"></el-table-column>
        <el-table-column label="总价(元)"></el-table-column>
        <el-table-column label="审批日期"></el-table-column>
        <el-table-column label="业务日期"></el-table-column>
        <el-table-column label="申请日期"></el-table-column>
        <el-table-column label="使用地址"></el-table-column>
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
        <div class="g-contentOne_header">审批状态</div>
        <div class="g-chooseButton g-flexStartRow">
          <span class="selfCenter">审批人:</span>
          <span class="normalCss" v-text="">外墙漆</span>
        </div>
        <div class="g-chooseButton g-flexStartRow">
          <span class="selfCenter">审批结果:</span>
          <span class="activeCss" v-if="true" v-text="">通过</span>
          <span class="normalCss" v-else v-text="">不通过</span>
        </div>
        <div class="g-chooseButton g-flexStartRow">
          <span class="selfCenter">审批意见:</span>
          <span class="normalCss" v-text="">情况属实</span>
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
        /*弹框*/
        isDialog:false,
        gradeDialogForm:{
          person:'',
          address:'',
          description:'',
          date:''
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
      fuzzyDialogClick(){
        /*input框输入值改变触发的函数*/
        this.$refs['allMsg'].filter(this.fuzzyInput);
      },
      filterNode(value, data) {
        /*筛选节点*/
        if (!value) return true;
        return data.techerName.indexOf(value) !== -1;
      },
      /*tree点击事件*/
      handleNodeClick(data,node){
        /*点击节点回调*/
        /*点击名字发送请求，返回数据绑定在右边部分*/
        /*给每一级赋值一个唯一的id即可辨认点击的是几级*/
        if('data' in data){
          return;
        }else{
          this.techerId=data.techerId;
          this.techerName=data.techerName;
          this.headerText=data.techerName+'('+node.parent.data.techerName+')';
          this.getTableData();
        }
      },
      /*table*/
      fuzzyTableClick(){},
      handleSelectionChange(val){
        console.log(val);
      },
      sortChange(column,prop,order){},
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
    width:100%;padding:0 0 15/16rem 60/16rem;.fontSize(14);color:@normalColor;
    span{margin-right:20/16rem;}
    div{.widthRem(80);.height(30);text-align:center;.box-sizing();
      &:hover{cursor:pointer;}
      &:first-of-type{.border-bottom-left-radius(15/16rem);.border-top-left-radius(15/16rem);}
      &:last-of-type{.border-top-right-radius(15/16rem);.border-bottom-right-radius(15/16rem);}
    }
    span.activeCss{color:@green;font-weight:bold;}
    span.normalCss{color:@HColor;font-weight:bold;}
  }
  .g-footer{width:100%;padding:24/16rem 0;text-align:center;}
</style>


