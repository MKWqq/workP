<template>
  <div class="g-container">
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
        <header class="g-liOneRow">
          <el-button type="primary">批量领用</el-button>
          <div class="gs-refresh g-fuzzyInput">
            <el-input type="text" v-model="fuzzyTableInput" icon="search" placeholder="班级/姓名" :on-icon-click="fuzzyTableClick"></el-input>
          </div>
        </header>
        <el-table class="g-NotHover" :data="newStoragetable" @selection-change="handleSelectionChange" @sort-change="sortChange">
          <el-table-column type="selection"></el-table-column>
          <el-table-column label="序号" type="index" width="100px"></el-table-column>
          <el-table-column label="资产名称" props="name"></el-table-column>
          <el-table-column label="资产编号" prop="name"></el-table-column>
          <el-table-column label="国际代码" prop="name"></el-table-column>
          <el-table-column label="单价（元）"></el-table-column>
          <el-table-column label="存放位置"></el-table-column>
          <el-table-column label="品牌型号"></el-table-column>
          <el-table-column label="操作" fixed="right">
            <template scope="props">
              <el-button type="text" @click="isDialog=true">领用</el-button>
            </template>
          </el-table-column>
        </el-table>
      </div>
      <el-dialog class="headerNotBackground" title="领用" :modal="false" :visible.sync="isDialog" size="tiny" :before-close="handlerClose">
        <el-form :model="gradeDialogForm" label-width="75px" label-position="right">
          <el-form-item label="领用人:">
            <el-select v-model="gradeDialogForm.person" style="width:100%;">
              <el-option label="完全" value="0"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="使用地址:">
            <el-input v-model="gradeDialogForm.address" placeholder="请输入使用地址"></el-input>
          </el-form-item>
          <el-form-item label="说明:">
            <el-input v-model="gradeDialogForm.address" placeholder="请输入使用地址"></el-input>
          </el-form-item>
          <el-form-item label="领用日期:">
            <el-date-picker type="date" placeholder="选择日期" v-model="gradeDialogForm.date" style="width: 100%;"></el-date-picker>
          </el-form-item>
        </el-form>
        <div class="g-button">
          <el-button type="primary">确定领用</el-button>
          <el-button @click="isDialog=false">取消</el-button>
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
          person:'',
          address:'',
          description:'',
          date:''
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
  @import '../../../../../style/test';
  @import '../../../../../style/style';
  div.g-container{padding:0;width:100%;}
  .g-tree_content .g-sectionR > header.g-liOneRow{border:none;}
</style>




