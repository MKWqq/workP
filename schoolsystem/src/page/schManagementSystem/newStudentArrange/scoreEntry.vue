<template>
  <div class="g-container">
    <header class="g-header">
      <div class="g-liOneRow">
        <div class="g-textHeader g-flexStartRow selfSpace">
          <el-button class="g-gobackChart g-imgContainer RedButton" @click="goBackChart">
            <img src="../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
            返回上一步
          </el-button>
          <h2 class="selfCenter">成绩录入</h2>
        </div>
        <el-button class="radiusButton" type="primary">保存</el-button>
      </div>
      <div class="g-upload-section g-flexStartRow">
        <el-form ref="studentImportForm" label-position="left" :rules="importFormRules" :model="dataHeader" label-width="85px">
          <el-form-item label="文件路径:" prop="fileName">
            <div class="fileName" v-text="dataHeader.fileName"></div>
          </el-form-item>
          <div class="button_row">
            <button class="fileButtonShow headerButton">
              <img src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_choice.png" />
              选择文件
            </button>
            <input type="file" @change="chooseFile" class="chooseFile" title="选择文件" />
          </div>
          <div class="button_row">
            <button class="headerButton">
              <img src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_download.png" />
              下载模版
            </button>
          </div>
          <div class="button_row">
            <button class="headerButton">
              <img src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_upload.png" />
              上传
            </button>
          </div>
        </el-form>
      </div>
    </header>
    <section class="g-section">
      <div class="gs-header g-liOneRow">
        <div class="gs-button alertsBtn">
          <el-button-group>
            <el-button @click="" data-msg="copy" class="filt buttonChild" title="复制">
              <img class="filt_unactive"  src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png" />
              <img class="filt_active" src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png" />
            </el-button>
            <el-button @click="" data-msg="print" class="filt buttonChild" title="打印">
              <img class="filt_unactive"  src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png" />
              <img class="filt_active" src="../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png" />
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
          <el-table-column label="序号" sortable></el-table-column>
          <el-table-column label="年级"></el-table-column>
          <el-table-column label="班级" sortable></el-table-column>
          <el-table-column label="姓名" sortable></el-table-column>
          <el-table-column label="考号" sortable></el-table-column>
          <el-table-column label="全卷(分)" sortable>
            <template scope="props">
              <input type="text" class="tableInput" v-model="score" />
            </template>
          </el-table-column>
        </el-table>
      </div>
    </section>
    <footer class="g-footer">
      <el-row class="pageAlerts">
        <el-pagination
          @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-size="pageALl"
          layout="prev, pager, next, jumper"
          :total="1000">
        </el-pagination>
      </el-row>
    </footer>
  </div>
</template>
<script>
  import {fileTypeCheck} from '@/assets/js/common'
  import {studentImportUpload} from '@/api/http'
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
        /*table*/
        score:'100',
        /*form表单双向绑定数据*/
        dataHeader:{
          /*显示div中文件信息值*/
          fileName:'',
        },
        /*type='file'input框的值*/
        fileInputValue:'',
        /*fuzzyFilter*/
        fuzzyInput:'',
        /*footer*/
        pageALl:1,
        currentPage:1,
        /*表单验证规则*/
        importFormRules:{
          fileName:[
            {required:true,message:'请选择文件!'}
          ],
        }
      }
    },
    computed: {},
    methods:{
      /*返回*/
      goBackChart(){
        this.$router.push('/importExam');
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
      /*footer*/
      handleCurrentChange(val) {
        this.currentPage = val;
        console.log(`当前页: ${this.currentPage}`);
      },
      /*header的button群*/
      /*批量导入上传*/
      uploadFile(){
        this.$refs['studentImportForm'].validate(valid=>{
          if(valid){
            console.log($('.chooseFile')[0].files[0]);
            let formData=new FormData();
            formData.append('userFile',$('.chooseFile')[0].files[0]);
//            this.fileInputValue=$('.chooseFile')[0].files[0];
            /*this.fileInputValue*/
            studentImportUpload(formData).then(data=>{
              console.log(data);
            });
          }
          else{
            return ;
          }
        });
      },
      /*模糊查询*/
      fuzzyClick(){
        /*点击search按钮*/
        console.log('模糊查询');
      },
      /*选择文件change事件*/
      chooseFile(event){
        /*this.fileName=this.extractFilename($(event.currentTarget).val());*/
        if(!fileTypeCheck(this.extractFilename($(event.currentTarget).val()),['.xls','.xlsx'])){
          this.$alert('文件不符合,请选择excel文件(*.xls或*.xlsx)!','提示',{
            confirmButtonText:'确定',
            type:'error',
            callback: action => {
              console.log(action);
            }
          });
        }else{
          this.dataHeader.fileName=this.extractFilename($(event.currentTarget).val());
          this.fileInputValue=$(event.currentTarget).val();
        }
      },
      extractFilename(path){
        let x;
        x = path.lastIndexOf('\\');
        if (x >= 0) // 基于Windows的路径
          return path.substr(x+1);
        x = path.lastIndexOf('/');
        if (x >= 0) // 基于Unix的路径
          return path.substr(x+1);
        return path; // 仅包含文件名
      },
      /*导出数据*/
      exportAjax(){
        this.hrefExport='/api/school/user/userGl?type=export&roleNameEn=xs'
      },
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../style/style';
  .g-container{
    .g-textHeader{
      h2{.marginLeft(40,1582);}
    }
    .g-prompt{margin-left:20/16rem;padding-top:11/16rem;}
  }
</style>


