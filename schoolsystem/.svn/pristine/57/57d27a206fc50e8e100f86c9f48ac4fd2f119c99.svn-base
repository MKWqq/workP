<template>
  <div class="g-container">
    <header class="g-textHeader">
      <h2>考核明细</h2>
      <div class="g-flexStartRow">
        <span class="selfCenter" style="margin-right:1.25rem;">方案名称:</span>
        <el-select v-model="repairForm.name">
          <el-option value="0" label="ggg"></el-option>
        </el-select>
      </div>
    </header>
    <section class="">
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
        <div class="g-textHeader g-sectionR g-contentHeader">
          <h2 class="g-centerH" v-text="">123</h2>
          <p class="g-prompt">eee</p>
          <ul class="g-flexCenterRow">
            <li>
              <span>姓名:</span>
              <span v-text="">12</span>
            </li>
            <li>
              <span>满分:</span>
              <span v-text="">50</span>
            </li>
            <li>
              <span>得分:</span>
              <span v-text="">12</span>
            </li>
            <li>
              <span>考核人:</span>
              <span v-text="">rgr</span>
            </li>
          </ul>
          <!--el-table-->
          <treeTable :columns="columns" :dataSource="assetTypeTable"></treeTable>
        </div>
      </section>
    </section>
  </div>
</template>
<script>
  import {} from '@/api/http'
  import treeTable from '../../../../components/treeTable/treeTable.vue'
  export default{
    data(){
      let _self=this;
      return{
        /*模糊查询*/
        fuzzyInput:'',
        evaluationName:'',
        /*form表单*/
        repairForm:{
          name:'',
        },
        /*tree*/
        treeData:[],
        defaultProps: {
          children: 'data',
          label:'techerName',
        },
        /*table组件*/
        columns:[
          /*props为列绑定数据*/
          {name:'考核项目',props:'type'},
          {name:'具体条例',props:'code'},
          {name:'分值（分）',props:'code'},
          {name:'得分（分）（班主任评20%）',props:'code'},
          {name:'合计',props:'code'},
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
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'evaluationManagement'});
      },
      /*table*/
      handleSelectionChange(choose){
        console.log(choose);
      },
      sortChange(value){
        console.log(value);
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
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/test';
  @import '../../../../style/style';
  .g-textHeader>div{.marginTop(20);}
  .g-contentHeader{
    width:100%;
    h2{text-align:center;}
    .g-prompt{.fontSize(14);margin:10/16rem 0 30/16rem;}
    ul{.widthRem(580);margin:0 auto;text-align:center;
      li{.fontSize(14);color:@normalColor;}
      li:not(:first-of-type){margin-left:20/16rem;}
    }
  }
</style>


