<template>
  <div class="g-container">
    <header class="g-textHeader g-importCourseHeader">
      <div class="g-flexStartRow">
        <el-button class="g-gobackChart g-imgContainer RedButton" @click="goBackChart">
          <img src="../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
          返回流程图
        </el-button>
        <h2 class="selfCenter">手动调整</h2>
      </div>
      <div class="g-chooseButton g-flexStartRow">
        <span class="selfCenter">调整方式:</span>
        <div class="activeCss" @click="changeTypeClick">指定学生换班</div>
        <div class="normalCss" @click="changeTypeClick">相邻分数学生互换</div>
      </div>
    </header>
    <div class="g-containerNoPadding">
      <section class="g-section g-liOneRow">
        <div class="g-joinClassPart">
          <header class="g-textHeader">当前人数/容纳人数</header>
          <ul class="g-joinClassContainer g-liOneWrapRow">
            <li v-for="n in 5">
              <div @click="chooseClassClick" class="normalBoxShadow">
                <h2><span v-text="">29</span><span>/</span><span v-text="">30</span></h2>
                <p>七年级1重点班</p>
              </div>
              <el-button class="examRadiusButton radiusButton" type="primary">加入班级</el-button>
            </li>
          </ul>
        </div>
        <div class="g-tableH centerTable alertsList">
          <header class="g-liOneRow">
            <h2>参与分班学生名单</h2>
            <div class="gs-refresh selfCenter g-fuzzyInput">
              <el-input type="text" v-model="fuzzyInput" icon="search" :on-icon-click="fuzzyClick"></el-input>
            </div>
          </header>
          <el-table class="g-NotHover" border ref="studentMsgTable" :data="headerButtonData.studentBasicMsg" style="width:100%" @sort-change="sortChange" @selection-change="handleStudentTable">
            <!--show-overflow-tooltip 超出部分省略号显示-->
            <el-table-column type="selection" width="55px"></el-table-column>
            <el-table-column label="序号" width="80" type="index"></el-table-column>
            <el-table-column label="姓名"></el-table-column>
            <el-table-column label="性别"></el-table-column>
            <el-table-column label="合层总分"></el-table-column>
            <el-table-column label="指定班级"></el-table-column>
            <el-table-column label="备注"></el-table-column>
          </el-table>
        </div>
      </section>
    </div>
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
      }
    },
    computed: {},
    methods:{
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'newStudentClass'});
      },
      /*调整方式*/
      changeTypeClick(event){
        let e=$(event.currentTarget);
        this.changeCss(e,'activeCss','normalCss');
      },
      /*班级选择*/
      chooseClassClick(event){
        let e=$(event.currentTarget);
        e.removeClass('normalBoxShadow');
        e.parent().siblings().find('div').removeClass('activeBoxShadow');
        e.parent().siblings().find('div').addClass('normalBoxShadow');
        e.addClass('activeBoxShadow');
      },
      changeCss(e,active,normal){
        e.removeClass(normal);
        e.siblings().removeClass(active);
        e.addClass(active);
        e.siblings().addClass(normal);
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
      /*模糊查询*/
      fuzzyClick(){
        /*点击search按钮*/
        console.log('模糊查询');
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
  /*调整方式处css*/
  .g-chooseButton{/*1582*/
    width:100%;padding:30/16rem 0 0;.fontSize(14);color:@normalColor;
    span{.marginRight(20,1582);}
    div{padding:5/16rem 30/1582*100%;
      &:hover{cursor:pointer;}
    }
    div:first-of-type{.border-bottom-left-radius(4/16rem);.border-top-left-radius(4/16rem);}
    div:last-of-type{.border-bottom-right-radius(4/16rem);.border-top-right-radius(4/16rem);}
    div.activeCss{background:@green;color:#fff;border:none;}
    div.normalCss{color:@normalColor;border:1px solid @borderColor;}
  }
  /*下方css*/
  .g-section{width:100%;.marginTop(20);
    .g-joinClassPart{/*640*/
      .width(640,1582);
      .g-textHeader{.fontSize(14);color:@normalColor;.height(40);}
      .g-joinClassContainer{
        width:100%;
        li{.width(150,640);.NotLineheight(160);float:left;.marginBottom(30);position:relative;
          &>div{width:100%;height:100%;
            h2{.fontSize(20);text-align:center;color:@HColor;padding:20/16rem 0;
              span:not(:first-of-type){}
            }
            p{color:@normalColor;.fontSize(15);width:100%;text-align:center;}
          }
          .radiusButton.el-button{padding:0.5rem 20/16rem;left:50%;.transformTranslate(-50%,50%);}
        }
        //li:not(:first-of-type){.marginLeft(20,640);}
      }
    }
    .activeBoxShadow{.box-shadow(0 0 10/16rem 1/16rem rgba(0,0,0,.2));border:2/16rem solid @backgroundBlue;}
    .normalBoxShadow{border:2/16rem solid @borderColor;}
  }
</style>








