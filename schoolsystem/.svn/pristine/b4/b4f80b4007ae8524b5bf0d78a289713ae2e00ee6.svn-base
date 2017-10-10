<template>
  <div class="g-evaluationGroup g-container">
    <header class="g-evaluationGroupHeader">
      <el-button class="g-gobackChart g-imgContainer RedButton" @click="goBackChart">
        <img src="../../../../assets/img/commonImg/icon_return.png" />
        返回流程图
      </el-button>
      <el-button class="blueButton">保存</el-button>
    </header>
    <section class="g-threePart g-evaluationGroupSection">
      <div class="g-sectionL">
        <header class="gL-header">
          <h2>被考评人分组</h2>
        </header>
        <section class="gL-section">
          <ul>
            <li @click="chooseCourse" class="['activeLi']">1</li>
          </ul>
        </section>
      </div>
      <div class="g-sectionC">
        <header class="gL-header">
          <h2>候选人员名单</h2>
        </header>
        <section class="gL-section">
          <el-tree @check-change="checkChange" :highlight-current="true" show-checkbox node-key="id" :data="treeData" :props="defaultProps" ref="allMsg" @node-click="handleNodeClick"></el-tree>
        </section>
      </div>
      <div class="g-sectionR alertsList centerTable">
        <header>
          <h2>添加评委</h2>
        </header>
        <el-table :data="classesTimeSetTable" class="g-timeSettingTable">
          <el-table-column label="姓名" prop="name"></el-table-column>
          <el-table-column label="操作">
            <template scope="props">
              <el-button class="deleteColor" type="text">删除</el-button>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </section>
  </div>
</template>
<script>
  import {} from '@/api/http'
  export default{
    data(){
      return{
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
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'evaluationManagement'});
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
  @import '../../../../style/style';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.css';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.less';

</style>


