<template>
  <div class="g-container">
    <header class="g-textHeader">
      <div class="g-liOneRow g-sa_header_search">
        <div class="gs-button alertsBtn">
          <el-button-group>
            <el-button data-msg="export" class="filt buttonChild" title="导出">
              <img class="filt_unactive"  src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png" />
              <img class="filt_active" src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png" />
            </el-button>
            <el-button data-msg="delete" class="filt buttonChild" title="删除">
              <img class="filt_unactive"  src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_delete.png" />
              <img class="filt_active" src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_delete_highlight.png" />
            </el-button>
          </el-button-group>
          <el-button-group class="elGroupButton_two">
            <el-button  data-msg="print" class="filt buttonChild" title="打印预览">
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
        <el-table-column label="资产名称"></el-table-column>
        <el-table-column label="资产编号" prop="name"></el-table-column>
        <el-table-column label="资产分类" prop="name"></el-table-column>
        <el-table-column label="入库时间"></el-table-column>
        <el-table-column label="创建时间"></el-table-column>
        <el-table-column label="供应商"></el-table-column>
        <el-table-column label="规格"></el-table-column>
        <el-table-column label="单位"></el-table-column>
        <el-table-column label="操作" fixed="right">
          <template scope="props">
            <el-button type="text" @click="isDialog=true">编辑</el-button>
          </template>
        </el-table-column>
      </el-table>
    </section>
    <el-dialog class="headerNotBackground g-tree_content" title="入库信息编辑" :modal="false" :visible.sync="isDialog" :before-close="handlerClose">
      <div class="g-liOneRow">
        <div class="g-sectionR alertsList">
          <el-form :model="newStorageForm" label-width="80px" label-position="right">
            <el-form-item label="资产名称:">
              <el-input v-model="newStorageForm.name" placeholder="请填写资产名称"></el-input>
            </el-form-item>
            <el-form-item label="资产分类:">
              <el-input v-model="newStorageForm.assetType" placeholder="请从左侧选择资产分类"></el-input>
            </el-form-item>
            <el-form-item label="供应商:">
              <el-input v-model="newStorageForm.givePerson" placeholder="请输入供应商"></el-input>
            </el-form-item>
            <el-form-item label="数量:">
              <el-input v-model="newStorageForm.num" placeholder="请输入数量"></el-input>
            </el-form-item>
            <el-form-item label="单位:">
              <el-input v-model="newStorageForm.workAddress" placeholder="请输入单个资产的最小单位。如：一箱有10本书。此处应填写'本'。"></el-input>
            </el-form-item>
            <el-form-item label="品牌型号:">
              <el-input v-model="newStorageForm.thingType" placeholder="请输入品牌和型号"></el-input>
            </el-form-item>
            <el-form-item label="规格:">
              <el-input v-model="newStorageForm.size" placeholder="请输入单位资产规格。如：一箱有6台电脑，此处应填写一台电脑的规格"></el-input>
            </el-form-item>
            <el-form-item label="单价:">
              <el-input v-model="newStorageForm.price" placeholder="请输入该单位资产的价格"></el-input>
            </el-form-item>
            <el-form-item label="入库时间:">
              <el-date-picker type="date" placeholder="选择日期" v-model="newStorageForm.date" style="width: 100%;"></el-date-picker>
            </el-form-item>
            <el-form-item label="存放位置:">
              <el-input v-model="newStorageForm.thingAddress" placeholder="请输入存放位置"></el-input>
            </el-form-item>
            <el-form-item label="备注:">
              <el-input v-model="newStorageForm.prompt" placeholder="请输入备注"></el-input>
            </el-form-item>
          </el-form>
        </div>
        <div class="g-sectionL">
          <header class="gL-header">
            <h2>选择资产分类</h2>
            <el-input @input="fuzzyDialogClick" v-model="fuzzyDialogInput" class="fuzzyInput" placeholder="请输入查询类别" icon="search"></el-input>
          </header>
          <section class="gL-section">
            <el-tree :highlight-current="true" default-expand-all :data="treeData" :props="defaultProps" ref="allMsg" :filter-node-method="filterNode" @node-click="handleNodeClick"></el-tree>
          </section>
        </div>
      </div>
      <div class="g-button">
        <el-button type="primary">确定</el-button>
        <el-button @click="isDialog=false">取消</el-button>
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
        /*教师模糊查询*/
        fuzzyDialogInput:'',
        /*form表单*/
        newStorageForm:{
          name:'',
          assetType:'',
          givePerson:'',
          num:'',
          workAddress:'',
          thingType:'',
          size:'',
          price:'',
          date:'',
          thingAddress:'',
          prompt:''
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
</style>


