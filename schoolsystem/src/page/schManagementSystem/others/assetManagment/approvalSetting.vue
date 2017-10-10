<template>
  <div class="g-container">
    <header class="g-textHeader g-liOneRow">
      <h2>审批设置</h2>
      <el-button class="radiusButton" type="primary">保存</el-button>
    </header>
    <section class="g-threePart g-liOneRow">
      <div class="g-sectionL">
        <header class="gL-header">
          <h2>选择资产分类</h2>
          <el-input @input="fuzzySortClick" v-model="fuzzySortInput" class="fuzzyInput" placeholder="请输入教师姓名" icon="search"></el-input>
        </header>
        <section class="gL-section">
          <el-tree :highlight-current="true" default-expand-all :data="treeData" :props="defaultProps" ref="sortTree" :filter-node-method="filterSortNode" @node-click="handleNodeClick"></el-tree>
        </section>
      </div>
      <div class="g-sectionC">
        <header class="g-textHeader">
          <span>是否需审批:</span>
          <el-switch v-model="isChecked" on-text="是" off-text="否" on-color="#13b5b1" off-color=""></el-switch>
        </header>
        <section>
          <p>领用/出库审批人</p>
          <ul class="g-contentContainer g-flexStartWrapRow">
            <li v-for="n in 13" class="g-liOneRow">laoshi<i class="el-icon-close"></i></li>
          </ul>
        </section>
      </div>
      <div class="g-sectionL g-sectionL-R">
        <header class="gL-header">
          <h2>选择审批人</h2>
          <el-input @input="fuzzyPersonClick" v-model="fuzzyPersonInput" class="fuzzyInput" placeholder="请输入教师姓名" icon="search"></el-input>
        </header>
        <section class="gL-section">
          <el-tree @check-change="checkChange" :highlight-current="true" show-checkbox node-key="id" :data="treeData" :props="defaultProps" ref="personTree" :filter-node-method="filterPersonNode"></el-tree>
        </section>
      </div>
    </section>
  </div>
</template>
<script>
  import {} from '@/api/http'
  export default{
    data(){
      return{
        /*选择资产分类模糊查询*/
        fuzzySortInput:'',
        /*选择审批人模糊查询*/
        fuzzyPersonInput:'',
        /*是否需审批*/
        isChecked:false,
        /*左边tree树*/
        treeData:[{
          id: 1,
          label: '一级 2',
          children: [{
            id: 3,
            label: '二级 2-1',
            children: [{
              id: 4,
              label: '三级 3-1-1'
            }, {
              id: 5,
              label: '三级 3-1-2',
              disabled: true
            }]
          }, {
            id: 2,
            label: '二级 2-2',
            disabled: true,
            children: [{
              id: 6,
              label: '三级 3-2-1'
            }, {
              id: 7,
              label: '三级 3-2-2',
              disabled: true
            }]
          }]
        }],
        defaultProps:{
          children:'children',
          label:'label'
        },
        /*右边table框*/
        classesTimeSetTable:[{name:'123'}],
        dialogRule:{},
      }
    },
    methods:{
      /*选择资产分类模糊查询*/
      fuzzySortClick(){
        /*input框输入值改变触发的函数*/
        this.$refs['sortTree'].filter(this.fuzzyInput);
      },
      filterSortNode(value,data){
        /*筛选节点*/
        if (!value) return true;
        return data.techerName.indexOf(value) !== -1;
      },
      /*选择审批人模糊查询*/
      fuzzyPersonClick(){
        /*input框输入值改变触发的函数*/
        this.$refs['personTree'].filter(this.fuzzyInput);
      },
      filterPersonNode(value,data){
        /*筛选节点*/
        if (!value) return true;
        return data.techerName.indexOf(value) !== -1;
      },
      /*被考评人分组*/
      chooseCourse(event){
        const e=$(event.currentTarget);
        e.addClass('activeLi');
        e.siblings().removeClass('activeLi');
        this.curriculumId=e.data('id');
        this.curriculumName=e.text();
      },
      /*el-tree*/
      /*el-tree复选框选中发生变化时回调*/
      checkChange(data,value,child){
        console.log(value);
        console.log(child);
        console.log(data);
      },
      /*tree点击事件*/
      handleNodeClick(data,node){
        /*点击节点回调*/
        /*点击名字发送请求，返回数据绑定在右边部分*/
        /*给每一级赋值一个唯一的id即可辨认点击的是几级*/
        console.log(data);
        console.log(node);
      },
    }
  }
</script>
<style lang="less" scoped>
  /*@import '../../../../style/test';*/
  @import '../../../../style/style';
  .g-container .g-threePart .g-sectionC{.width(718,1582);margin-left:0;}
  .g-container .g-threePart .g-sectionL-R{margin-right:0;}
  .g-container .g-threePart .g-sectionL{.width(412,1582);}
  .g-sectionC .g-textHeader{padding:20/16rem;}
  .g-sectionC section{padding:0 20/16rem;
    p{.fontSize(20);.marginBottom(20);}
  }
  .g-contentContainer{/*678*/
    width:100%;
    li{.width(80,678);padding:8/16rem 10/16rem;position:relative;background:@liColor;.border-radius(4/16rem);margin-right:20/16rem;margin-bottom:20/16rem;color:#fff;.fontSize(14);
      i{.fontSize(14);color:#fff;
        &:hover{cursor:pointer;}
      }
    }
  }
</style>


