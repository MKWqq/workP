<template>
  <div class="g-container">
    <header class="g-textHeader g-liOneRow">
      <div class="g-flexStartRow">
        <el-button @click="goBackParent" class="g-gobackChart g-imgContainer RedButton">
          <img src="../../../../assets/img/commonImg/icon_return.png" />
          返回
        </el-button>
        <span class="selfCenter">考评方向</span>
      </div>
      <div>
        <el-button type="primary" @click="addProject"><i class="el-icon-plus"></i>添加考核项目</el-button>
        <el-button type="primary">保存</el-button>
      </div>
    </header>
    <section>
      <header class="g-textHeader g-flexStartRow">
        <div class="g-contentRow">
          <span class="selfCenter g-NotMarginLeft" style="margin-right:1.25rem;">考核方向名称:</span>
          <el-input v-model="direction" style="width:10rem;"></el-input>
        </div>
        <div class="g-contentRow selfCenter">
          <span class="selfCenter" style="margin-right:1.25rem;">满分分值:</span>
          <span class="g-NotMarginLeft" v-text="">50</span>
        </div>
      </header>
      <treeTable :columns="columns" :dataSource="assetTypeTable" :handleButton="handleButton" v-on:handleDialog="handleDialog"></treeTable>
    </section>
    <el-dialog class="g-tree_content g-defineDialog headerNotBackground" size="tiny" :title="dialogTitle" :modal="false" :visible.sync="isDialog" :before-close="handlerClose">
      <el-form :model="gradeDialogForm" ref="dialogForm" label-width="100px" label-position="right">
        <el-form-item label="考核项目:">
          <el-input v-model="gradeDialogForm.name" placeholder="请输入考核项目"></el-input>
        </el-form-item>
      </el-form>
    <div class="g-button">
      <el-button type="primary">确定</el-button>
      <el-button @click="isDialog=false">取消</el-button>
    </div>
  </el-dialog>
    <el-dialog class="g-tree_content g-defineDialog headerNotBackground" size="tiny" title="添加子项目" :modal="false" :visible.sync="isChildDialog" :before-close="handlerChildClose">
      <el-form :model="ChildDialogForm" ref="dialogForm" label-width="100px" label-position="right">
        <el-form-item label="考核子项目:">
          <el-input v-model="ChildDialogForm.name" placeholder="请输入考核子项目"></el-input>
        </el-form-item>
      </el-form>
    <div class="g-button">
      <el-button type="primary">确定</el-button>
      <el-button @click="isChildDialog=false">取消</el-button>
    </div>
  </el-dialog>
    <el-dialog class="g-tree_content g-defineDialog headerNotBackground" size="tiny" :title="SpecificDialogTitle" :modal="false" :visible.sync="isSpecificDialog" :before-close="handlerSpecificClose">
      <el-form :model="specificDialogForm" ref="dialogForm" label-width="100px" label-position="right">
        <el-form-item label="考核条例:">
          <el-input v-model="specificDialogForm.name" placeholder="请输入考核条例"></el-input>
        </el-form-item>
        <el-form-item label="分值:">
          <el-input v-model="specificDialogForm.scores" placeholder="请输入考核条例"></el-input>
        </el-form-item>
      </el-form>
      <div class="g-button">
        <el-button type="primary">确定</el-button>
        <el-button @click="isSpecificDialog=false">取消</el-button>
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
        /*form表单*/
        dataForm:{},
        /*考核方向名称*/
        direction:'',
        /*弹框——添加考核项目*/
        isDialog:false,
        dialogTitle:'添加考核项目',
        gradeDialogForm:{
          name:'',
        },
        /*弹框——添加子项目*/
        isChildDialog:false,
        ChildDialogForm:{
          name:'',
        },
        /*弹框——添加具体条例*/
        isSpecificDialog:false,
        specificDialogForm:{
          name:'',
          scores:50
        },
        SpecificDialogTitle:'添加具体条例',
        /*table组件*/
        handleButton:{
          /*操作button*/
          parentHandle:[
            {name:'添加子项目',msg:'add'},
            {name:'添加具体条例',msg:'addSpecific'},
            {name:'编辑',msg:'handle'},
            {name:'删除',msg:'delete',cls:'deleteColor'}
          ],
          childHandle:[
            {name:'编辑',msg:'handleChild'},
            {name:'删除',msg:'delete',cls:'deleteColor'}
          ],
        },
        columns:[
          /*props为列绑定数据*/
          {name:'考核项目',props:'type'},
          {name:'具体条例',props:'code'},
          {name:'分值',props:'code'}
        ],
        assetTypeTable:[
          /*tree数据*/
          {type:'是否有',code:'1打断点',
            /*isSpecific判断哪条数据为具体条例，因为button不同*/
            children:[{type:'电脑',code:'1-1',children:[{type:'',code:'1-1-1',isSpecific:true}]},
              {type:'dfa',code:'1-1'}
            ],
          },
          {type:'no项',code:'淡淡的'}
        ],
      }
    },
    components:{treeTable},
    methods:{
      goBackParent(){
        this.$router.push('/literacyAssess');
      },
      /*弹框——添加考核项目与编辑考核项目为一个弹框，添加子项目为一个弹框
      * 添加具体条例与编辑具体条例为一个弹框*/
      /*弹框——添加考核项目*/
      addProject(){
        this.isDialog=true;
        this.dialogTitle='添加考核项目';
      },
      handlerClose(done){
        done();
      },
      /*弹框——添加子项目*/
      handlerChildClose(done){
        done();
      },
      /*弹框——添加具体条例*/
      handlerSpecificClose(done){
        done();
      },
      /*table——组件*/
      handleDialog(msg){
        if(msg=='add'){
          this.isChildDialog=true;
          this.DialogChildTitle='添加子项目';
        }
        else if(msg=='addSpecific'){
          this.isSpecificDialog=true;
          this.SpecificDialogTitle='添加具体条例';
        }
        else if(msg=='handle'){
          this.isDialog=true;
          this.dialogTitle='编辑';
        }
        else if(msg=='handleChild'){
          this.isSpecificDialog=true;
          this.SpecificDialogTitle='编辑具体条例';
        }
      },
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/test';
  @import '../../../../style/style';
  .g-textHeader{border:none;padding-bottom:70/16rem;
    span{.fontSize(19);color:@HColor;margin-left:40/16rem;}
  }

  i{.fontSize(14);margin-right:10/16rem;}
  .g-container .g-textHeader .g-NotMarginLeft{margin-left:0;}
</style>




