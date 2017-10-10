<template>
  <div class="g-container">
    <header class="g-importCourseHeader g-liOneRow">
      <div class="g-textHeader g-flexStartRow selfSpace">
        <el-button class="g-gobackChart g-imgContainer RedButton" @click="goBackChart">
          <img src="../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
          返回流程图
        </el-button>
        <h2 class="selfCenter">分班成绩合成设置</h2>
      </div>
      <el-button class="radiusButton" type="primary">保存</el-button>
    </header>
    <div class="g-container g-containerNoPadding">
      <section class="g-section">
        <div class="gs-header g-liOneRow">
          <div class="gs-button alertsBtn">
            <el-button-group>
              <el-button @click="addClick" data-msg="add" class="filt buttonChild" title="添加">
                <img class="filt_unactive"  src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add.png" />
                <img class="filt_active" src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add_highlight.png" />
              </el-button>
            </el-button-group>
          </div>
          <div class="gs-refresh g-fuzzyInput">
            <el-input type="text" v-model="fuzzyInput" icon="search" :on-icon-click="fuzzyClick"></el-input>
          </div>
        </div>
        <div class="gs-table centerTable alertsList">
          <el-table class="g-NotHover" ref="studentMsgTable" :data="headerButtonData.studentBasicMsg" style="width:100%" @sort-change="sortChange" @selection-change="handleStudentTable">
            <!--show-overflow-tooltip 超出部分省略号显示-->
            <el-table-column type="selection" width="55px"></el-table-column>
            <el-table-column label="序号" type="index" width="80px"></el-table-column>
            <el-table-column label="考试名称"></el-table-column>
            <el-table-column label="计入合成总分比例(%)"></el-table-column>
            <el-table-column label="依据科目">
              <template scope="props">
                <ul class="g-flexStartRow">
                  <li @click="changeSubject" v-for="n in 8">语文</li>
                  <li class="el-icon-plus" @click="addSubject"><!--添加按钮--></li>
                </ul>
              </template>
            </el-table-column>
            <el-table-column label="操作" width="180px" fixed="right">
              <template scope="props">
                <el-button @click="importScore" type="text">导入成绩</el-button>
                <el-button @click="changeClick(props.$index)" type="text">编辑</el-button>
                <el-button @click="deleteExam" class="deleteColor" type="text">删除</el-button>
              </template>
            </el-table-column>
          </el-table>
        </div>
      </section>
    </div>
    <el-dialog class="headerNotBackground" :title="ExamDialog" size="tiny" :modal="false" :visible.sync="isExamDialog" :before-close="handlerExamClose">
      <el-form :model="dialogExamForm" label-width="125px" label-position="right">
        <el-form-item label="依据考试名称:">
          <el-input placeholder="请输入考试名称" v-model="dialogExamForm.name"></el-input>
        </el-form-item>
        <el-form-item label="计入总分比例(%):">
          <el-input placeholder="请输入计入总分比例" v-model="dialogExamForm.percent"></el-input>
        </el-form-item>
      </el-form>
      <div class="g-button">
        <el-button @click="addExamSave" type="primary">保存</el-button>
        <el-button @click="isExamDialog=false">取消</el-button>
      </div>
    </el-dialog>
    <el-dialog class="headerNotBackground" :title="subjectDialog" size="tiny" :modal="false" :visible.sync="isSubjectDialog" :before-close="handlerSubjectClose">
      <el-form :model="dialogSubjectForm" label-width="100px" label-position="right">
        <el-form-item label="科目名称:">
          <el-input placeholder="请输入科目名称" v-model="dialogSubjectForm.name"></el-input>
        </el-form-item>
        <el-form-item label="科目满分:">
          <el-input placeholder="请输入科目满分" v-model="dialogSubjectForm.score"></el-input>
        </el-form-item>
        <el-form-item label="统计比例(%):">
          <el-input placeholder="请输入统计比例" v-model="dialogSubjectForm.percent"></el-input>
        </el-form-item>
      </el-form>
      <div class="g-button">
        <el-button @click="addExamSave" type="primary">保存</el-button>
        <el-button @click="isSubjectDialog=false">取消</el-button>
      </div>
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
          studentBasicMsg:[1],
        },
        /*fuzzyFilter*/
        fuzzyInput:'',
        /*弹框---------*/
        /*添加依据考试*/
        isExamDialog:false,
        ExamDialog:'添加依据考试',
        /*form*/
        dialogExamForm:{
          name:'',
          percent:'',
        },
        /*添加依据科目*/
        isSubjectDialog:false,
        subjectDialog:'添加依据科目',
        /*form*/
        dialogSubjectForm:{
          name:'',
          score:'',
          percent:'',
        },
      }
    },
    computed: {},
    methods:{
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'newStudentClass'});
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
      /*导入成绩*/
      importScore(){
        this.$router.push('/importExam')
      },
      /*编辑*/
      changeClick(index){
        console.log(index);
        this.isExamDialog=true;
        this.ExamDialog='修改依据考试';
      },
      deleteExam(){},
      /*修改依据科目*/
      changeSubject(){
        this.subjectDialog='修改依据科目';
        this.isSubjectDialog=true;
      },
      /*添加依据科目*/
      addSubject(){
        this.subjectDialog='添加依据科目';
        this.isSubjectDialog=true;
      },
      /*header的button群*/
      addClick(){
        this.isExamDialog=true;
        this.ExamDialog='添加依据考试';
      },
      /*模糊查询*/
      fuzzyClick(){
        /*点击search按钮*/
        console.log('模糊查询');
      },
      /*弹框*/
      /*关闭按钮点击*/
      /*添加依据考试*/
      handlerExamClose(done){
        done();
      },
      /*保存*/
      addExamSave(){},
      /*添加依据科目*/
      handlerSubjectClose(done){
        done();
      },
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../style/style';
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
  .g-textHeader{
    h2{.marginLeft(40,1582);}
  }
  .g-text--container{
    .marginTop(30);
  }
  .g-flexStartRow{
    p{color:#666;.fontSize(14);
      span{color:#4da1ff;}
    }
  }
  .gs-table li:hover{cursor:pointer;}
  .gs-table li:not(:first-of-type){margin-left:5/16rem;}
  .gs-table li:last-of-type{.widthRem(24);.height(24);border:1px solid @liColor;.box-sizing();text-align:center;color:@liColor;.fontSize(14);}
  .gs-table li:not(:last-of-type){.widthRem(60);.height(24);background:@liColor;color:#fff;.fontSize(14);.border-radius(4/16rem);}
</style>








