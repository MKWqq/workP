<template>
  <div class="g-container">
    <header class="g-header">
      <div class="g-textHeader g-flexStartRow">
        <el-button @click="goBackParent" class="g-gobackChart g-imgContainer RedButton">
          <img src="../../../assets/img/commonImg/icon_return.png" />
          返回
        </el-button>
        <h2 class="selfCenter">批量导入新生</h2>
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
        </el-form>
        <div class="g-prompt"> 温馨提示:准考证号、姓名为必填字段！选择文件后点击预览进行数据确认；仅支持xls、xlsx格式的表格文件；</div>
      </div>
      <div class="gh-buttonGroup selfCenter clear_fix">
        <el-button type="primary" @click="uploadFile" class="uploadButton">上传</el-button>
      </div>
    </header>
    <section class="g-section">
      <div class="gs-header g-flexEndRow">
        <div class="gs-refresh g-fuzzyInput">
          <el-input type="text" v-model="fuzzyInput" icon="search" :on-icon-click="fuzzyClick"></el-input>
        </div>
      </div>
      <div class="gs-table alertsList">
        <el-table ref="studentMsgTable" :data="headerButtonData.studentBasicMsg" style="width:100%" @sort-change="sortChange" @selection-change="handleStudentTable">
          <!--show-overflow-tooltip 超出部分省略号显示-->
          <el-table-column label="序号" sortable></el-table-column>
          <el-table-column label="班级"></el-table-column>
          <el-table-column label="座号" sortable></el-table-column>
          <el-table-column label="姓名" sortable></el-table-column>
          <el-table-column label="性别" sortable></el-table-column>
          <el-table-column label="手机号" sortable></el-table-column>
          <el-table-column label="科类" sortable></el-table-column>
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
          studentBasicMsg:[],
        },
        /*form表单双向绑定数据*/
        dataHeader:{
          /*显示div中文件信息值*/
          fileName:'',
        },
        /*type='file'input框的值*/
        fileInputValue:'',
        /*导出数据*/
        hrefExport:'javascript:void(0);',
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
      goBackParent(){
        this.$router.push('/newStudentmanagement');
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
      buttonClick(event){
        const e=$(event.currentTarget),targetMsg=e.data('msg');
        if(targetMsg=='add'){
          this.isDialog=true;
        }
        this.changeButtonCss(e);
      },
      changeButtonCss(target){
        const index=$('.buttonChild').index(target);
        for(let i=0,len=$('.buttonChild').length;i<len;i++){
          if(i==index){
            /*修改css*/
            if(index % 2==0){
              /*even*/
              target.css({background:'#4da1ff',borderColor:'#4da1ff'});
            }else{
              target.css({background:'#ff5b5b',borderColor:'#ff5b5b'});
            }
            /*修改img*/
            target.find('img').eq(0).css({display:'none'});
            target.find('img').eq(1).css({display:'inline-block'});
          }else{
            /*修改img*/
            $('.buttonChild').eq(i).find('img').eq(0).css({display:'inline-block'});
            $('.buttonChild').eq(i).find('img').eq(1).css({display:'none'});
            /*修改css*/
            $('.buttonChild').eq(i).css({background:'',borderColor:''});
          }
        }
      },
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


