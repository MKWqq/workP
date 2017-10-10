<template>
  <div class="g-container">
    <header class="g-textHeader g-flexStartRow">
      <div class="g-headerButtonGroup">
        <h2>均分统计</h2>
      </div>
    </header>
    <div class="g-statisticalAnalysis">
      <header class="g-textHeader g-flexStartRow">
        <span class="selfCenter" style="margin-right:1.25rem;">方案名称:</span>
        <el-select v-model="repairForm.name">
          <el-option value="0" label="ggg"></el-option>
        </el-select>
      </header>
      <section class="centerTable alertsList">
        <div class="g-liOneRow g-sa_header_search">
          <div class="gs-button alertsBtn">
            <el-button-group>
              <el-button data-msg="export" class="filt buttonChild" title="导出">
                <img class="filt_unactive"  src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png" />
                <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png" />
              </el-button>
            </el-button-group>
            <el-button-group class="elGroupButton_two">
              <el-button data-msg="copy" class="filt buttonChild" title="复制">
                <img class="filt_unactive"  src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png" />
                <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png" />
              </el-button>
              <el-button  data-msg="print" class="filt buttonChild" title="打印预览">
                <img class="filt_unactive"  src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png" />
                <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png" />
              </el-button>
            </el-button-group>
          </div>
          <div class="gs-refresh g-fuzzyInput">
            <el-input type="text" v-model="fuzzyInput" icon="search" placeholder="班级/姓名" :on-icon-click="fuzzyClick"></el-input>
          </div>
        </div>
        <el-table class="" :data="classesTimeSetTable" @sort-change="sortChange" @selection-change="handleSelectionChange">
          <el-table-column label="年级"></el-table-column>
          <el-table-column label="班级"></el-table-column>
          <el-table-column label="被评人数"></el-table-column>
          <el-table-column label="平均分数" sortable></el-table-column>
        </el-table>
      </section>
    </div>
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
          name:'',
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
  @import '../../../../style/style';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.css';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.less';
  .g-sa_header_search{.marginTop(32);.marginBottom(20);}
  .g-classSchedule .g-container{padding:0;}
  .g-statisticalAnalysis header.g-textHeader.g-flexStartRow{.marginTop(20);.marginBottom(20);border-bottom:1px solid @borderColor;}
  .g-textHeader .el-form{.width(825,1582);}
  .g-textHeader .el-form-item{float:left;margin-bottom:0;}
  .g-textHeader .el-form-item:nth-of-type(1){.width(222,825);}
  .g-textHeader .el-form-item:nth-of-type(2){.width(558,825);.marginLeft(40,825);}
  .g-liOneRow.g-sa_header_search{margin-top:0;}

  .defineSelect{margin-right:20/16rem;}
</style>


