<template>
  <div class="g-hasPadding g-container">
    <header class="g-textHeader g-flexStartRow">
      <div class="g-headerButtonGroup">
        <h2>资产审批</h2>
      </div>
    </header>
    <section class="g-tree_content">
      <div class="g-sectionL">
        <header class="gL-header">
          <h2>选择资产分类</h2>
          <el-input @input="fuzzyClick" v-model="fuzzyInput" class="fuzzyInput" placeholder="请输入查询类别" icon="search"></el-input>
        </header>
        <section class="gL-section">
          <el-tree :highlight-current="true" default-expand-all :data="treeData" :props="defaultProps" ref="allMsg" :filter-node-method="filterNode" @node-click="handleNodeClick"></el-tree>
        </section>
      </div>
      <div class="g-sectionR alertsList">
        <header class="g-liOneRow g-sa_header_search">
          <div class="gs-button alertsBtn">
            <el-button-group>
              <el-button class="filt buttonChild" title="导出">
                <img class="filt_unactive"  src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png" />
                <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png" />
              </el-button>
              <el-button class="filt buttonChild" title="打印预览">
                <img class="filt_unactive"  src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png" />
                <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png" />
              </el-button>
            </el-button-group>
          </div>
          <div class="gs-refresh g-fuzzyInput">
            <el-input type="text" v-model="fuzzyInput" icon="search" placeholder="班级/姓名" :on-icon-click="fuzzyClick"></el-input>
          </div>
        </header>
        <el-table class="g-NotHover" :data="newStoragetable" @selection-change="handleSelectionChange" @sort-change="sortChange">
          <el-table-column type="selection"></el-table-column>
          <el-table-column label="序号" type="index" width="100px"></el-table-column>
          <el-table-column label="资产名称" props="name"></el-table-column>
          <el-table-column label="资产编号" prop="name"></el-table-column>
          <el-table-column label="分类代码" prop="name"></el-table-column>
          <el-table-column label="存放位置"></el-table-column>
          <el-table-column label="打印次数"></el-table-column>
          <el-table-column label="操作" fixed="right">
            <template scope="props">
              <el-button type="text" @click="isDialog=true">编辑</el-button>
            </template>
          </el-table-column>
        </el-table>
      </div>
      <el-dialog class="g-tree_content" title="编辑" :modal="false" :visible.sync="isDialog" :before-close="handlerClose">
        <div class="g-dialogConContainer">
          <el-form :model="gradeDialogForm" ref="dialogForm" label-width="100px" label-position="right">
            <el-form-item label="资产名称:">
              <el-input v-model="gradeDialogForm.name" placeholder="请输入资产名称"></el-input>
            </el-form-item>
            <el-form-item label="存放位置:">
              <el-input v-model="gradeDialogForm.thingAddress" placeholder="请输入存放位置"></el-input>
            </el-form-item>
            <el-form-item label="供应商:">
              <el-input v-model="gradeDialogForm.person" placeholder="请输入供应商"></el-input>
            </el-form-item>
            <el-form-item label="单位:">
              <el-input v-model="gradeDialogForm.address" placeholder="请输入单位"></el-input>
            </el-form-item>
            <el-form-item label="品牌型号:">
              <el-input v-model="gradeDialogForm.type" placeholder="请输入品牌型号"></el-input>
            </el-form-item>
            <el-form-item label="规格:">
              <el-input v-model="gradeDialogForm.size" placeholder="请输入规格"></el-input>
            </el-form-item>
            <el-form-item label="单价（元）:">
              <el-input v-model="gradeDialogForm.price" placeholder="请输入单价（元）"></el-input>
            </el-form-item>
            <el-form-item label="备注:">
              <el-input v-model="gradeDialogForm.description" placeholder="请输入备注"></el-input>
            </el-form-item>
          </el-form>
        </div>
        <div class="g-footer">
          <el-button class="radiusButton" type="primary">确定</el-button>
        </div>
      </el-dialog>
    </section>
  </div>
</template>
<script>
  import {mapState} from 'vuex'
  import {teacherTimeSettingTeacherLoad,//得到教师
    teacherTimeSettingTabelLoad,/*table默认数据*/
    teacherTimeSettingSaved,//保存时间限制
  } from '@/api/http'
  import {fuzzyQuery} from '@/assets/js/fuzzyQuery'
  export default{
    data(){
      return{
        /*教师模糊查询*/
        fuzzyInput:'',
        /*table表单*/
        newStoragetable:[{name:1}],
        /*tree*/
        treeData:[],
        defaultProps: {
          children: 'data',
          label:'techerName',
        },
        /*右边*/
        /*模糊查询*/
        fuzzyTableInput:'',
        /*弹框*/
        isDialog:false,
        gradeDialogForm:{
          name:'',
          type:'',//品牌型号
          thingAddress:'',//存放位置
          person:'',//供应商
          address:'',//单位
          size:'',//规格
          description:'',
          price:'',//单价
        },
      }
    },
    methods:{
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'examinationChart'});
      },
      /*教师信息模糊查询*/
      fuzzyClick(){
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
      },
      /*右边*/
      /*模糊查询*/
      fuzzyTableClick(){},
      handleSelectionChange(val){
        console.log(val);
      },
      sortChange(column,prop,order){},
      /*弹框*/
      handlerClose(done){
        done();
      },
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/test';
  @import '../../../../style/style';
  .g-tree_content .g-sectionR > header.g-liOneRow{border:none;}

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




