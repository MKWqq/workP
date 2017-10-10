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
        <el-table-column label="分类代码" prop="name"></el-table-column>
        <el-table-column label="归还日期"></el-table-column>
        <el-table-column label="创建日期"></el-table-column>
        <el-table-column label="单价(元)"></el-table-column>
        <el-table-column label="创建人"></el-table-column>
        <el-table-column label="归还人"></el-table-column>
        <el-table-column label="操作" width="150" fixed="right">
          <template scope="props">
            <el-button type="text" @click="isDialog=true">编辑</el-button>
          </template>
        </el-table-column>
      </el-table>
    </section>
    <el-dialog class="headerNotBackground g-tree_content" title="信息编辑" :modal="false" :visible.sync="isDialog" size="tiny" :before-close="handlerClose">
      <el-form :model="gradeDialogForm" label-width="75px" label-position="right">
        <el-form-item label="归还时间:">
          <el-date-picker type="date" placeholder="选择日期" v-model="gradeDialogForm.date" style="width: 100%;"></el-date-picker>
        </el-form-item>
        <el-form-item label="说明:">
          <el-input v-model="gradeDialogForm.address" placeholder="请输入使用地址"></el-input>
        </el-form-item>
      </el-form>
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
</style>


