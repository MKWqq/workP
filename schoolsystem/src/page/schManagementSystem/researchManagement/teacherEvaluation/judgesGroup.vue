<template>
  <div class="g-importCourse">
    <header class="g-importCourseHeader">
      <el-button class="g-gobackChart g-imgContainer RedButton" @click="goBackChart">
        <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
        返回流程图
      </el-button>
      <el-button class="blueButton">保存</el-button>
    </header>
    <div class="g-container g-containerNoPadding">
      <section class="g-section">
        <div class="gs-header">
          <div class="gs-button alertsBtn">
            <el-button-group>
              <el-button @click="buttonClick" data-msg="add" class="filt buttonChild" title="添加">
                <img class="filt_unactive"  src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add.png" />
                <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add_highlight.png" />
              </el-button>
              <el-button @click="buttonClick" data-msg="export" class="filt buttonChild" title="导出">
                <img class="filt_unactive"  src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png" />
                <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png" />
              </el-button>
            </el-button-group>
            <el-button-group class="elGroupButton_two">
              <el-button @click="buttonClick" data-msg="copy" class="filt buttonChild" title="复制">
                <img class="filt_unactive"  src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png" />
                <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png" />
              </el-button>
              <el-button @click="buttonClick" data-msg="print" class="filt buttonChild" title="打印预览">
                <img class="filt_unactive"  src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png" />
                <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png" />
              </el-button>
            </el-button-group>
          </div>
          <div class="gs-refresh g-fuzzyInput">
            <el-input type="text" v-model="fuzzyInput" icon="search" :on-icon-click="fuzzyClick"></el-input>
          </div>
        </div>
        <div class="gs-table alertsList">
          <el-table class="g-NotHover" ref="studentMsgTable" :data="headerButtonData.studentBasicMsg" style="width:100%" @sort-change="sortChange" @selection-change="handleStudentTable">
            <!--show-overflow-tooltip 超出部分省略号显示-->
            <el-table-column label="序号" sortable></el-table-column>
            <el-table-column label="分组名称"></el-table-column>
            <el-table-column label="最高分去除" sortable></el-table-column>
            <el-table-column label="最低分去除" sortable></el-table-column>
            <el-table-column label="评委名单" sortable></el-table-column>
            <el-table-column label="操作" width="120px" fixed="right">
              <template scope="props">
                <el-button type="text">编辑</el-button>
                <el-button type="text" class="delete">删除</el-button>
              </template>
            </el-table-column>
          </el-table>
        </div>
      </section>
    </div>
    <el-dialog class="headerNotBackground" title="新增评委分组" :modal="false" :visible.sync="isDialog" :before-close="handlerClose">
      <div class="dialogHeader">
        <el-button class="defineHeight" type="primary">保存</el-button>
      </div>
      <section class="dialogSection">
        <el-form :model="dialogForm" :rules="dialogRule" label-width="85px" label-position="left">
          <el-form-item label="分组名称:" prop="name" required>
            <el-input class='NotAllWidth' v-model="dialogForm.name" placeholder="请输入分组名称"></el-input>
          </el-form-item>
          <el-form-item label="分数采样:">
            <span>本组最高分去除</span>
            <el-input class="defineInputWidth" v-model="dialogForm.max"></el-input>
            <span>%的人，本组最低分去除</span>
            <el-input class="defineInputWidth" v-model="dialogForm.min"></el-input>
            <span>%的人</span>
          </el-form-item>
        </el-form>
        <div class="g-tree_content g-dialog_content">
          <div class="g-sectionL">
            <header class="gL-header">
              <h2>待选教师</h2>
              <el-input @input="dialogFuzzyClick" v-model="dialogFuzzyInput" class="fuzzyInput" placeholder="请输入教师姓名" icon="search"></el-input>
            </header>
            <section class="gL-section">
              <el-tree @check-change="checkChange" :highlight-current="true" show-checkbox node-key="id" :data="treeData" :props="defaultProps" ref="allMsg" :filter-node-method="filterNode" @node-click="handleNodeClick"></el-tree>
            </section>
          </div>
          <div class="g-sectionR alertsList centerTable">
            <el-table :data="classesTimeSetTable" class="g-timeSettingTable">
              <el-table-column label="姓名" prop="name"></el-table-column>
              <el-table-column label="操作">
                <template scope="props">
                  <el-button class="deleteColor" type="text">删除</el-button>
                </template>
              </el-table-column>
            </el-table>
          </div>
        </div>
      </section>
    </el-dialog>
  </div>
</template>
<script>
  import {} from '@/api/http'
  export default{
    data(){
      return{
        /*ajax data*/
        headerButtonData:{
          gradeloadData:[],
          classesLoadData:[],
          msgTypeLoadData:[],
          studentBasicMsg:[1],
        },
        /*form表单双向绑定数据*/
        dataHeader:{
          /*显示div中文件信息值*/
          fileName:'',
        },
        /*type='file'input框的值*/
        fileInputValue:'',
        /*导出数据*/
        /*fuzzyFilter*/
        fuzzyInput:'',
        /*弹框---------*/
        isDialog:false,
        /*评委组名称form表单*/
        dialogForm:{
          name:'',
          max:0,
          min:0
        },
        /*左边tree树*/
        dialogFuzzyInput:'',
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
    computed: {},
    methods:{
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'evaluationManagement'});
      },
      /*table*/
      handleStudentTable(section){
        /*section为选择项行信息组成的数组*/
        console.log(section);
      },
      sortChange(column){
        /*table排序回调*/
        console.log(column)
      },
      /*header的button群*/
      buttonClick(event){
        const e=$(event.currentTarget),targetMsg=e.data('msg');
        console.log(targetMsg);
        if(targetMsg=='add'){
          this.isDialog=true;
        }
      },
      /*模糊查询*/
      fuzzyClick(){
        /*点击search按钮*/
        console.log('模糊查询');
      },
      /*导出数据*/
      exportAjax(){},
      /*弹框*/
      /*关闭按钮点击*/
      handlerClose(done){
        done();
      },
      /*tree点击事件*/
      handleNodeClick(data,node){
        /*点击节点回调*/
        /*点击名字发送请求，返回数据绑定在右边部分*/
        /*给每一级赋值一个唯一的id即可辨认点击的是几级*/
        console.log(data);
        console.log(node);
      },
      /*tree模糊查询*/
      dialogFuzzyClick(){
        /*input框输入值改变触发的函数*/
        this.$refs['allMsg'].filter(this.dialogFuzzyInput);
      },
      filterNode(value, data) {
        /*筛选节点*/
        if (!value) return true;
        return data.label.indexOf(value) !== -1;
      },
      /*el-tree复选框选中发生变化时回调*/
      checkChange(data,value,child){
        console.log(value);
        console.log(child);
        console.log(data);
      },
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/style';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.css';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.less';
  @import '../../../../style/arrangeClasses/importCourse.less';
  .g-importCourse .g-container .g-section{margin:1.25rem 0;width:100%;}
  /*弹框*/
  .headerNotBackground{
    .dialogHeader{position:absolute;right:20px;top:0.625rem;
      button{.border-radius(1rem);}
    }
    .dialogSection{
      .NotAllWidth{width:auto;}
      .defineInputWidth{.widthRem(60);}
    }
  }
</style>








