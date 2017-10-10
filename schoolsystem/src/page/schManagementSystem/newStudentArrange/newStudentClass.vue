<template>
  <div class="g-container">
    <header class="g-textHeader">
      <h2>新生分班</h2>
      <div class="g-liOneRow g-headerBottom--chart">
        <el-form class="leftForm" :model="evaluationForm" label-position="left" label-width="80px">
          <el-form-item label="考评名称:">
            <el-select v-model="evaluationForm.evaluationName" placeholder="请选择考评名称">
              <el-option label="1年级" value="1"></el-option>
            </el-select>
          </el-form-item>
        </el-form>
        <ul class="g-liOneRow g-headerBottomR">
          <li class="step completed">已完成</li>
          <li class="step main_process">主要流程</li>
          <li class="step second_process">次要流程</li>
          <li class="step inactived">未激活</li>
        </ul>
      </div>
    </header>
    <section class="g-content--chart">
      <div class="g-row_content_1">
        <div class="g-column_1">
          <div class="g-col-1x g-col_content"></div>
          <div class="g-space-1x"></div>
        </div>
        <div class="g-column_2">
          <div class="g-col-1x g-col_content">
            <router-link to="/newStudentSpecial" class="item_a main_process" tag="div">指定学生到班</router-link>
            <div class="line--width-RD_container">
              <div class="lineTwo main_process"></div>
              <div class="g-arrow_container">
                <span class="arrow main_process el-icon-arrow-down"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="g-row_arrow_1">
        <div class="g-column_1">
          <div class="g-col-1x g-col_content"></div>
          <div class="g-space-1x"></div>
        </div>
        <div class="g-column_2">
          <div class="g-col-1x g-col_line_up">
            <div class="g-line_container">
              <div class="g-arrow_container">
                <span class="arrow main_process el-icon-arrow-up"></span>
              </div>
              <span class="line main_process"></span>
            </div>
          </div>
        </div>
      </div>
      <div class="g-row_content_2">
        <div class="g-column_1">
          <div class="g-col-1x g-col_content">
            <router-link to="/newStudentClassName" class="item_a completed" tag="div">新生分班名单</router-link>
          </div>
          <div class="g-space-1x g-col_right_line">
            <div class="g-line_container">
              <span class="line completed"></span>
              <span class="arrow completed el-icon-arrow-right"></span>
            </div>
          </div>
        </div>
        <div class="g-column_2">
          <div class="g-col-1x g-col_content">
            <router-link to="/createdClass" class="item_a completed" tag="div">创建班级</router-link>
          </div>
          <div class="g-space-1x g-col_right_line">
            <div class="g-line_container">
              <span class="line completed"></span>
              <span class="arrow completed el-icon-arrow-right"></span>
            </div>
          </div>
        </div>
        <div class="g-column_3">
          <div class="g-col-1x g-col_content">
            <router-link to="/placementFast" class="item_a completed" tag="div">快速分班</router-link>
          </div>
          <div class="g-space-1x g-col_right_line">
            <div class="g-line_container">
              <span class="line completed"></span>
              <span class="arrow completed el-icon-arrow-right"></span>
            </div>
          </div>
        </div>
        <div class="g-column_4">
          <div class="g-col-1x g-col_content">
            <router-link to="/printMessage" class="item_a completed" tag="div">打印报表</router-link>
          </div>
          <div class="g-space-1x"></div>
        </div>
      </div>
      <div class="g-row_arrow_2">
        <div class="g-column_1">
          <div class="g-col-1x g-col_line_down"></div>
        </div>
      </div>
      <div class="g-row_content_3">
        <div class="g-column_1">
          <div class="g-col-1x g-col_content"></div>
          <div class="g-space-1x"></div>
        </div>
        <div class="g-column_2">
          <div class="g-col-1x g-col_content">
            <router-link to="/organizeResults" class="item_a main_process" tag="div">分班成绩合成设置</router-link>
            <div class="line--width_container">
              <div class="line--width-LB_container">
                <div class="lineTwo completed"></div>
                <div class="g-arrow_container">
                  <span class="arrow completed el-icon-arrow-right"></span>
                </div>
              </div>
              <div class="line--width-RT_container">
                <div class="g-arrow_container">
                  <span class="arrow main_process el-icon-arrow-up"></span>
                </div>
                <div class="lineTwo main_process"></div>
              </div>
            </div>
          </div>
          <div class="g-space-1x"></div>
        </div>
        <div class="g-column_3">
          <div class="g-col-7x g-col_content"></div>
          <div class="g-col-1x g-col_content">
            <router-link to="/changeBySelf" class="item_a completed" tag="div">手动调整</router-link>
            <div class="line--width-BL_container">
              <div class="lineTwo completed"></div>
              <div class="g-arrow_container">
                <span class="arrow completed el-icon-arrow-right"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="g-row_arrow_3">
        <div class="g-column_1">
          <div class="g-col-1x g-col_content"></div>
          <div class="g-space-1x"></div>
        </div>
        <div class="g-column_2">
          <div class="g-col-1x g-col_line_down">
            <div class="g-line_container">
              <span class="line main_process"></span>
              <div class="g-arrow_container">
                <span class="arrow main_process el-icon-arrow-down"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="g-row_content_4">
        <div class="g-column_1">
          <div class="g-col-1x g-col_content"></div>
          <div class="g-space-1x"></div>
        </div>
        <div class="g-column_2">
          <div class="g-col-1x g-col_content">
            <router-link to="/classResult" class="item_a completed" tag="div">确认分班合成成绩</router-link>
          </div>
          <div class="g-space-1x"></div>
        </div>
        <div class="g-column_3">
          <div class="g-col-7x g-col_content"></div>
          <div class="g-col-1x g-col_content">
            <router-link to="/newStudentRecord" class="item_a completed" tag="div">学生补录</router-link>
            <div class="line--width-BL_container hasOwnHeight">
              <div class="lineTwo completed"></div>
              <div class="g-arrow_container">
                <span class="arrow completed el-icon-arrow-right"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
  import {} from '@/api/http'
  export default{
    data(){
      return{
        /*考评名称*/
        evaluationForm:{
          evaluationName:'',
        },
        datePickerOption:{
          disabledDate(time){
            return time.getTime()<Date.now()-8.64e7;
          }
        },
      }
    },
  }
</script>
<style lang="less" scoped>
  @import '../../../style/style';
  /*header下*/
  .g-headerBottom--chart{/*1582*/
    width:100%;.marginTop(32);.height(36);.marginBottom(25);
    .leftForm{}
    .g-headerBottomR{.width(530,1582);
      .before{content:'';.widthRem(10);color:@normalColor;.height(10);.box-sizing();margin-right:15/16rem;.border-radius(50%);display:inline-block;}
      li{.fontSize(14);color:#666;
        &:before{.before}
      }
    }
  }
  /*section*/
  .g-content--chart{
    /*图表走向*/
    /*列css，浮动，一行排多列，每列间距*/
    div[class*='g-row']{
      &:after{content:'';display:block;clear:both;}
    }
    div[class*='g-column']{float:left;position:relative;
      &>div{float:left;}
      &:after{display:block;content:'';clear:both;}
    }
    /*单元格*/
    /*含字的div，原本的a标签*/
    /*字体css*/
    div[class*='g-col_content']{
      position:relative;.NotLineheight(40);.border-radius(20/16rem);.fontSize(14);.box-sizing();text-align:center;

    }
    /*路由元素css*/
    div.item_a{display:inline-block;width:100%;.height(40);.border-radius(20/16rem);
      &:hover{cursor:pointer;}
    }
    /*线加箭头----*/
    /*箭头行占据的高度*/
    div[class*='g-col_line']{
      .NotLineheight(56);.marginTop(12);.marginBottom(15);
    }
    /*右下箭头*/
    .line--width-RD_container{/*185*/
      position:absolute;.widthRem(185);left:260/16rem;top:20/16rem;
      .lineTwo{width:100%;.NotLineheight(75);border-right:2/16rem solid ;border-top:2/16rem solid;}
      .g-arrow_container{width:100%;.marginTop(-4);text-align:right;
        span{.fontSize(16);font-weight:normal;.transformTranslate(50%);}
      }
    }
    /*包含左和右的箭头容器*/
    .line--width_container{position:absolute;top:0;left:0;}
    /*左下箭头-长*/
    .line--width-LB_container{
      position:absolute;left:-200/16rem;top:-70/16rem;
      .lineTwo{.widthRem(180);.NotLineheight(90);border-left:2/16rem solid ;border-bottom:2/16rem solid;}
      .g-arrow_container{position:absolute;right:0;bottom:0;
        span{.fontSize(16);font-weight:normal;.transformTranslate(100%,50%);}
      }
    }
    /*左下箭头-短*/
    .line--width-BL_container{
      position:absolute;left:-51/16rem;top:-70/16rem;
      .lineTwo{.widthRem(21);.NotLineheight(90);border-left:2/16rem solid ;border-bottom:2/16rem solid;}
      .g-arrow_container{position:absolute;right:0;bottom:0;
        span{.fontSize(16);font-weight:normal;.transformTranslate(100%,50%);}
      }
    }
    /*左下箭头-短,含自己高*/
    .line--width-BL_container.hasOwnHeight{
      position:absolute;left:-51/16rem;top:-102/16rem;
      .lineTwo{.widthRem(21);.NotLineheight(122);border-left:2/16rem solid ;border-bottom:2/16rem solid;}
      .g-arrow_container{position:absolute;right:0;bottom:0;
        span{.fontSize(16);font-weight:normal;.transformTranslate(100%,50%);}
      }
    }
    /*右上箭头*/
    .line--width-RT_container{position:absolute;top:-94/16rem;left:250/15rem;
      .lineTwo{.widthRem(21);.NotLineheight(94);border-right:2/16rem solid ;border-bottom:2/16rem solid;}
      .g-arrow_container{.transformTranslate(10%,25%);
        span{.fontSize(16);font-weight:normal;.transformTranslate(50%);}
      }
    }
    /*line单元格 向下箭头*/
    .g-col_line_down{
      text-align:center;
      .g-line_container{/*240*/
        width:100%;
        .line{display:inline-block;border-left:2/16rem solid;.height(40);}
      }
      .g-arrow_container{
        width:100%;.marginTop(-4);
        span{.fontSize(16);font-weight:normal;}
      }
    }
    /*line单元格 向上箭头*/
    .g-col_line_up{
      text-align:center;
      .g-line_container{/*240*/
        width:100%;
        .line{display:inline-block;border-left:2/16rem solid;.height(40);}
      }
      .g-arrow_container{
        width:100%;position:relative;top:6/16rem;
        span{.fontSize(16);font-weight:normal;}
      }
    }
    /*line单元格 向右箭头*/
    .g-col_right_line{
      text-align:center;.height(40);
      .g-line_container{
        .line{display:inline-block;border-top:2/16rem solid;.widthRem(40);position:relative;top:-2/16rem;left:4/16rem;}
        span.arrow{.fontSize(16);font-weight:normal;}
      }

    }
  }
</style>








