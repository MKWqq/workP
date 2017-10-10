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
        <el-button class="largeButton" type="primary">保存</el-button>
      </div>
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
        /*表格header文本*/
        headerText:'',
        /*教师模糊查询*/
        fuzzyInput:'',
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
        this.$router.push({name:'examinationChart'});
      },
      /*保存*/
      saveSetting(){
        teacherTimeSettingSaved({pkListId:this.pkListId,teacherId:this.techerId,teacherName:this.techerName,data:this.classesTimeSetTable}).then(data=>{
          if(data.statu==1){
            this.$message({
              message:'保存成功!',
              type:'success'
            });
            this.getTableData();
          }else{
            this.$message.error('保存失败!');
          }
        })
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
        if('data' in data){
          return;
        }else{
          this.techerId=data.techerId;
          this.techerName=data.techerName;
          this.headerText=data.techerName+'('+node.parent.data.techerName+')';
          this.getTableData();
        }
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
</style>




