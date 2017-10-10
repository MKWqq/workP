<template>
  <div class="g-container">
    <header class="g-importCourseHeader">
      <div class="g-textHeader g-flexStartRow">
        <el-button class="g-gobackChart g-imgContainer RedButton" @click="goBackChart">
          <img src="../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
          返回流程图
        </el-button>
        <h2 class="selfCenter">创建班级</h2>
      </div>
      <div class="g-text--container">
        <div class="g-flexStartRow">
          <p>新生人数:<span v-text="">162</span>人</p>
          <p>容纳人数:<span v-text="">180</span>人</p>
        </div>
        <div class="g-prompt">注：如果班级专业划分特长班，则特长生将自动划分到特长班而不参与分班计算，如果班级不分专业，则特长生参与分班计算。</div>
      </div>
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
              <el-button @click="" data-msg="delete" class="filt buttonChild" title="删除">
                <img class="filt_unactive"  src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_delete.png" />
                <img class="filt_active" src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_delete_highlight.png" />
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
            <el-table-column type="selection" width="55px"></el-table-column>
            <el-table-column label="分组名称"></el-table-column>
            <el-table-column label="最高分去除" sortable></el-table-column>
            <el-table-column label="最低分去除" sortable></el-table-column>
            <el-table-column label="评委名单" sortable></el-table-column>
            <el-table-column label="操作" width="75px" fixed="right">
              <template scope="props">
                <el-button @click="changeClick(props.$index)" type="text">编辑</el-button>
              </template>
            </el-table-column>
          </el-table>
        </div>
      </section>
    </div>
    <el-dialog class="headerNotBackground scheduleDialog" :title="dialogTitle" size="tiny" :modal="false" :visible.sync="isDialog" :before-close="handlerClose">
      <el-form :model="dialogForm" label-width="100px" label-position="right">
        <el-form-item label="班级名称:">
          <el-input v-model="dialogForm.name"></el-input>
        </el-form-item>
        <el-form-item label="班级人数:">
          <el-input v-model="dialogForm.num"></el-input>
        </el-form-item>
        <el-form-item label="班级科类:">
          <el-select v-model="dialogForm.type">
            <el-option value="0" label="文科"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="班级专业:">
          <el-select v-model="dialogForm.profession">
            <el-option value="0" label="美术"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="班级级别:">
          <el-select v-model="dialogForm.classes">
            <el-option value="0" label="平行班"></el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div class="g-button">
        <el-button type="primary">保存</el-button>
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
        /*ajax data*/
        headerButtonData:{
          studentBasicMsg:[1],
        },
        /*fuzzyFilter*/
        fuzzyInput:'',
        /*弹框---------*/
        isDialog:false,
        dialogTitle:'添加信息',
        /*form*/
        dialogForm:{
          name:'',
          num:'',
          type:'',
          profession:'',
          classes:''//等级
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
      /*编辑*/
      changeClick(index){
        this.isDialog=true;
        this.dialogTitle='编辑信息';
        console.log(index);
      },
      /*header的button群*/
      addClick(){
        this.isDialog=true;
        this.dialogTitle='添加信息';
      },
      /*模糊查询*/
      fuzzyClick(){
        /*点击search按钮*/
        console.log('模糊查询');
      },
      /*弹框*/
      /*关闭按钮点击*/
      handlerClose(done){
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
  .g-prompt{text-align:left;padding-top:5/16rem;}
</style>








