<template>
  <div class="g-container">
    <header class="g-textHeader">
      <h2>资产分类</h2>
    </header>
    <section class="g-section">
      <treeTable :columns="columns" :dataSource="assetTypeTable" isChecked :handleButton="handleButton" v-on:handleDialog="handleDialog"></treeTable>
    </section>
    <el-dialog class="headerNotBackground" :title="dialogTitle" :modal="false" :visible.sync="isDialog" size="tiny" :before-close="handlerClose">
      <el-form :model="gradeDialogForm" label-width="75px" label-position="right">
        <el-form-item label="分类名称:">
          <el-input v-model="gradeDialogForm.name" placeholder="请输入分类名称"></el-input>
        </el-form-item>
      </el-form>
      <div class="g-button">
        <el-button type="primary" @click="addClassity">确定</el-button>
        <el-button @click="isDialog=false">取消</el-button>
      </div>
    </el-dialog>
  </div>
</template>
<script>
  import {} from '@/api/http'
  import treeTable from '../../../../components/treeTable/treeTable.vue'
  export default{
    data(){
      return{
        /*table组件*/
        handleButton:{
          /*操作button*/
          parentHandle:[{name:'新增',msg:'add'},{name:'编辑',msg:'handle'},{name:'删除',msg:'delete',cls:'deleteColor'}],
          childHandle:[{name:'新增',msg:'add'},{name:'删除',msg:'delete',cls:'deleteColor'}],
        },
        columns:[
          /*props为列绑定数据*/
            {name:'资产分类',props:'type'},{name:'分类代码',props:'code'}
          ],
        assetTypeTable:[
          /*tree数据*/
          {type:'通用',code:'1',
            children:[{type:'电脑',code:'1-1', children:[{type:'电脑1',code:'1-1-1'}]},
              {type:'电脑',code:'1-2',children:[{type:'电脑1',code:'1-2-1'}]}]},
          {type:'通用',code:'1'}
        ],
        /*弹框*/
        isDialog:false,
        dialogTitle:'新增分类',
        gradeDialogForm:{
          name:''
        },
      }
    },
    computed: {},
    components:{treeTable},
    methods:{
      /*table*/
      handleDialog(msg){
        this.isDialog=true;
        if(msg=='add'){
          this.dialogTitle='新增分类';
        }
        else if(msg=='handle'){
          this.dialogTitle='编辑分类';
        }
      },
      /*弹框*/
      handlerClose(done){
        done();
      },
      /*保存*/
      addClassity(){
      },
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/style';
</style>




