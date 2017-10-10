<template>
  <div class="g-statisticalAnalysis g-container">
    <header class="g-textHeader g-flexStartRow">
      <el-form :model="repairForm" label-width="75px" label-position="left">
        <el-form-item label="报修类别:">
          <el-select v-model="repairForm.type">
            <el-option value="0" label="设备"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="时间段:">
          <el-col :span="10">
            <el-date-picker type="date" :picker-options="pickerOptionStart" placeholder="选择日期" v-model="repairForm.startTime" style="width:100%"></el-date-picker>
          </el-col>
          <el-col :span="2" class="line" style="text-align:center;">--</el-col>
          <el-col :span="10">
            <el-date-picker type="date" :picker-options="pickerOptionEnd" placeholder="选择日期" v-model="repairForm.endTime" style="width:100%"></el-date-picker>
          </el-col>
        </el-form-item>
      </el-form>
      <el-button class="radiusButton selfCenter" type="primary" icon="search">查询</el-button>
    </header>
    <section class="centerTable alertsList">
      <div class="g-liOneRow g-sa_header_search">
        <div class="gs-button alertsBtn">
          <el-button-group>
            <el-button data-msg="export" class="filt buttonChild" title="导出">
              <img class="filt_unactive"  src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png" />
              <img class="filt_active" src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png" />
            </el-button>
          </el-button-group>
          <el-button-group class="elGroupButton_two">
            <el-button data-msg="copy" class="filt buttonChild" title="复制">
              <img class="filt_unactive"  src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png" />
              <img class="filt_active" src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png" />
            </el-button>
            <el-button  data-msg="print" class="filt buttonChild" title="打印预览">
              <img class="filt_unactive"  src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png" />
              <img class="filt_active" src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png" />
            </el-button>
          </el-button-group>
        </div>
        <div class="gs-refresh g-fuzzyInput">
          <el-input type="text" v-model="fuzzyInput" icon="search" placeholder="班级/姓名" :on-icon-click="fuzzyClick"></el-input>
        </div>
      </div>
      <el-table class="g-NotHover" :data="classesTimeSetTable" @sort-change="sortChange" @selection-change="handleSelectionChange">
        <el-table-column label="序号" type="text" width="100"></el-table-column>
        <el-table-column label="报修单号" sortable>
          <template scope="props">
            <el-button @click="isDetailDialog=true" type="text" v-text="props.row.name"></el-button>
          </template>
        </el-table-column>
        <el-table-column label="报修物品"></el-table-column>
        <el-table-column label="报修类别"></el-table-column>
        <el-table-column label="申请人"></el-table-column>
        <el-table-column label="维修员"></el-table-column>
        <el-table-column label="申请时间"></el-table-column>
        <el-table-column label="接单时间"></el-table-column>
        <el-table-column label="到场时间"></el-table-column>
        <el-table-column label="维修状态"></el-table-column>
      </el-table>
    </section>
    <el-dialog class="overflowDialog headerNotBackground" :modal="false" title="维修详情" :visible.sync="isDetailDialog" :before-close="handlerDetailClose">
      <div class="g-repairDetail">
        <div class="g-liOneWrapRow">
          <div class="g-detailRow">
            <span class="g-detailLable">报修单号:</span>
            <span>1</span>
          </div>
          <div class="g-detailRow">
            <span class="g-detailLable">维修地点:</span>
            <span v-text="">1</span>
          </div>
          <div class="g-detailRow">
            <span class="g-detailLable">报修物品:</span>
            <span v-text="">1</span>
          </div>
          <div class="g-detailRow">
            <span class="g-detailLable">联系方式:</span>
            <span v-text="">1</span>
          </div>
          <div class="g-detailRow">
            <span class="g-detailLable">资产编号:</span>
            <span v-text="">1</span>
          </div>
          <div class="g-detailRow">
            <span class="g-detailLable">报修类别:</span>
            <span v-text="">1</span>
          </div>
        </div>
        <div class="g-detailRow">
          <span class="g-detailLable">报修内容:</span>
          <span v-text="">1</span>
        </div>
        <div class="g-detailRow g-repairPerson g-liOneRow">
          <span class="g-detailLable">图片:</span>
          <ul class="g-flexStartWrapRow">
            <li v-for="url in detailImgUpload">
              <img :src="url.url" alt="" />
            </li>
          </ul>
        </div>
      </div>
      <div class="g-repairPerson g-liOneWrapRow">
        <div class="g-detailRow">
          <span class="g-detailLable">维修人员:</span>
          <span v-text="">1</span>
        </div>
        <div class="g-detailRow">
          <span class="g-detailLable">到场时间:</span>
          <span v-text="">1</span>
        </div>
        <div class="g-detailRow">
          <span class="g-detailLable">维修状态:</span>
          <span v-text="">待维修</span>
        </div>
        <div class="g-detailRow">
          <span class="g-detailLable">接单时间:</span>
          <span v-text="">1</span>
        </div>
        <div class="g-detailRow">
          <span class="g-detailLable">申请时间:</span>
          <span v-text="">1</span>
        </div>
      </div>
    </el-dialog>
  </div>
</template>
<script>
  import {} from '@/api/http'
  export default{
    data(){
      let _self=this;
      return{
        /*模糊查询*/
        fuzzyInput:'',
        evaluationName:'',
        /*form表单*/
        repairForm:{
          type:'',
          startTime:'',
          endTime:''
        },
        /*table*/
        classesTimeSetTable:[{name:1}],
        pickerOptionStart:{
          disabledDate(time){
            if(_self.repairForm.endTime){
              return time.getTime()>Date.parse(_self.repairForm.endTime);
            }
          }
        },
        pickerOptionEnd:{
          disabledDate(time){
            if(_self.repairForm.startTime){
              return time.getTime()<Date.parse(_self.repairForm.startTime);
            }
          }
        },
        /*弹框——维修详情*/
        isDetailDialog:false,
        detailForm:{
          type:'',
          address:'',
          things:'',
          tel:'',
          content:'',
          uploadImg:''
        },
        detailImgUpload:[
          {name: 'food.jpeg', url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'}, {name: 'food2.jpeg', url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'},
        ],
      }
    },
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
      /*模糊查询*/
      fuzzyClick(){
        /*模糊查询执行回调*/
      },
      /*弹框——维修详情*/
      handlerDetailClose(done){
        done();
      },
    }
  }
</script>
<style lang="less" scoped>
  /*@import '../../../../../style/test';*/
  @import '../../../../../style/style';
  @import '../../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.css';
  @import '../../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.less';
  .g-sa_header_search{.marginTop(32);.marginBottom(20);}
  .g-classSchedule .g-container{padding:0;}
  .g-statisticalAnalysis header.g-textHeader.g-flexStartRow{.marginTop(20);.marginBottom(20);border-bottom:1px solid @borderColor;}
  .g-textHeader .el-form{.width(825,1582);}
  .g-textHeader .el-form-item{float:left;margin-bottom:0;}
  .g-textHeader .el-form-item:nth-of-type(1){.width(222,825);}
  .g-textHeader .el-form-item:nth-of-type(2){.width(558,825);.marginLeft(40,825);}
  .g-liOneRow.g-sa_header_search{margin-top:0;}
  /*维修详情弹框*/
  .g-repairDetail{border-bottom:2/16rem solid @borderColor;.marginBottom(20);}
  .g-liOneWrapRow .g-detailRow{.widthRem(385);}
  .g-detailRow{width:100%;.marginBottom(36);
    .g-detailLable{display:inline-block;.widthRem(80);text-align:right;margin-right:10/16rem;}
    span{.fontSize(14);color:@normalColor;}
  }
  .g-repairPerson{
    ul{width:100%;}
    li{width:7.5rem;height:7.5rem;margin-right:10/16rem;.marginBottom(10);
      img{width:100%;}
    }
  }
</style>


