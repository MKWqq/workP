<template>
  <div class="g-container">
    <header class="g-header">
      <div class="gh-header">信息管理</div>
      <div class="gh-section notRequire clear_fix">
        <el-form ref="studentMessge" :rules="studentMsgRules" lable-position="left" :model="dataHeader" label-width="75px">
          <el-form-item label="年级" prop="grade">
            <el-select class="g-select" @change="gradeClick" v-model="dataHeader.grade" placeholder="请选择年级">
              <el-option v-for="(content,index) in headerButtonData.gradeloadData"
                         :label="gradeData[content.name-1]"
                         :key="content.gradeid"
                         :value="content.gradeid"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="班级" prop="classes">
            <el-select class="g-select" v-model="dataHeader.classes" placeholder="请选择班级">
              <el-option label="全选" value="all" :disabled="!headerButtonData.classesLoadData.length>0"></el-option>
              <el-option v-for="(content,index) in headerButtonData.classesLoadData"
                         :key='index' :label="content.classname"
                         :value="content.classid"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="信息类别" prop="messageType">
            <el-select class="g-select" v-model="dataHeader.messageType" placeholder="请选择信息类别">
              <el-option v-for="(content,index) in headerButtonData.msgTypeLoadData" :key="index" :label="content.name" :value="content.ListType"></el-option>
            </el-select>
          </el-form-item>
        </el-form>
      </div>
      <div class="gh-buttonGroup clear_fix">
        <el-button icon="reset" @click="resetClick('studentMessge')">重置</el-button>
        <el-button type="primary" @click="searchClick('studentMessge')">查询</el-button>
      </div>
    </header>
    <section class="g-section">
      <div class="gs-header">
        <div class="gs-button">
          <el-button-group>
            <el-button @click="buttonClick" data-msg="export" class="buttonChild" title="导出">
              <img src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png" />
              <img v-show="false" src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png" />
              <a :href="hrefExport"></a>
            </el-button>
            <el-button @click="buttonClick" data-msg="delete" class="buttonChild" title="删除">
              <img src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete.png" />
              <img v-show="false" src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete_highlight.png" />
            </el-button>
          </el-button-group>
          <el-button-group class="elGroupButton_two">
            <el-button @click="buttonClick" data-msg="print" class="buttonChild" title="打印预览">
              <img src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png" />
              <img v-show="false" src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png" />
            </el-button>
          </el-button-group>
        </div>
        <div class="gs-refresh g-fuzzyInput">
          <el-input type="text" v-model="fuzzyInput" icon="search" placeholder="班级/姓名" :on-icon-click="fuzzyClick"></el-input>
        </div>
      </div>
      <div class="gs-table alertsList">
        <el-table v-show="headerButtonData.hasBasicData" ref="studentMsgTable" :data="headerButtonData.studentBasicMsg" style="width:100%" @sort-change="sortChange" @selection-change="handleStudentTable">
          <!--show-overflow-tooltip 超出部分省略号显示-->
          <el-table-column type="selection"></el-table-column>
          <el-table-column label="序号" width="110" type="index"></el-table-column>
          <el-table-column v-for="(content,index) in headerButtonData.studentBasicTr" :key="index" :label="content.zh" :prop="content.en" sortable></el-table-column>
          <el-table-column label="操作" fixed="right" width="55">
            <template scope="scope">
              <el-button @click="changeBasicMsg(scope.$index)" type="text" size="small">修改</el-button>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </section>
    <footer v-show="headerButtonData.hasBasicData" class="g-footer">
      <el-row class="pageAlerts">
        <el-pagination
          @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          layout="prev, pager, next, jumper"
          :page-count="pageALl">
        </el-pagination>
      </el-row>
    </footer>
    <el-dialog class="addDialog g-twoColumDialog" :title="dialogTitle" :modal="false" :visible.sync="isDialog" size="tiny" :before-close="handlerClose">
      <el-form ref="addForm" :model="addForm" label-width="80px">
        <el-form-item v-for="(content,index) in headerButtonData.studentBasicTr" :key="index" :label="content.zh">
          <el-input v-model="updateData[content.en]"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button type="primary" @click="updateAjax">确定</el-button>
        <el-button @click="isDialog=false">取消</el-button>
      </div>
    </el-dialog>
    <!--提示框-->
  </div>
</template>
<script>
  import {studentMessageGradeLoad,studentMessageClassLoad,studentMessageTypeLoad,
    /*页面加载数据*/
    studentMessageSearchLoad,
    studentMessageDelete,//删除数据
    studentMessageUpdate//修改数据
  } from '@/api/http'
  export default{
    data(){
        return{
          /*form表单规则*/
          studentMsgRules:{
            grade:[{required:true,message:''}],
            classes:[{required:true,message:''}],
            messageType:[{required:true,message:''}],
          },
          /*ajax data*/
          headerButtonData:{
            gradeloadData:[],//年级返回数组
            classesLoadData:[],//班级返回数组
            msgTypeLoadData:[],//信息类别返回数组
            /*下面表格信息数据*/
            hasBasicData:false,
            studentBasicMsg:[],//学生基本信息数据
            studentBasicTr:[],//学生基本信息列
          },
          gradeData:['一年级','二年级','三年级','四年级','五年级','六年级','初一','初二',
            '初三','高一','高二','高三'
          ],
          /*ajax params*/
          ajaxClasses:[],
          ajaxGrade:'',
          /*form表单双向绑定数据*/
          dataHeader:{
            grade:'',
            classes:'',
            messageType:''
          },
          /*导出数据*/
          hrefExport:'javascript:void(0);',
          /*fuzzyFilter*/
          fuzzyInput:'',
          /*table*/
          mutipleChoose:[],
          /*page*/
          pageALl:1,
          currentPage:1,
          pageSize:14,
          /*弹框*/
          dialogTitle:'学生补录',
          isDialog:false,
          addForm:{
            username:'',
            sex:'',
            grade:'',
            classes:'',
            idCard:'',
            tel:'',
            book:''
          },
          /*修改数据弹框数据遍历*/
          updateData:{},//修改数据弹框中的默认值
        }
    },
    computed:{},
    methods:{
      /*button*/
      handleCurrentChange(val) {
        this.currentPage = val;
        /*显示当前页的数据*/
        this.searchStudentAjax({page:this.currentPage,ListType:this.dataHeader.messageType,class:this.ajaxClasses,grade:this.ajaxGrade,pageSize:this.pageSize});
      },
      /*table*/
      handleStudentTable(section){
        /*section为选择项行信息组成的数组*/
        this.mutipleChoose=section;
      },
      sortChange(column){
        /*table sortType排序回调*/
        if(this.headerButtonData.studentBasicMsg.length>0){
          if(column.order){
            this.searchStudentAjax({ListType:this.dataHeader.messageType,sort:column.order,sortType:column.prop,class:this.ajaxClasses,grade:this.ajaxGrade,pageSize:this.pageSize});
          }
          else{
            this.searchStudentAjax({ListType:this.dataHeader.messageType,class:this.ajaxClasses,grade:this.ajaxGrade,pageSize:this.pageSize});
          }
        }
        else{
            return;
        }
      },
      /*点击上部分按钮*/
      buttonClick(event){
        const e=$(event.currentTarget),targetMsg=e.data('msg');
        if(targetMsg=='delete'){
          this.deleteAjax();
        }else if(targetMsg=='export'){
          this.exportAjax();
        }
        this.changeButtonCss(e);
      },
      changeBasicMsg(index){
        /*修改信息弹框*/
        this.isDialog=true;
        this.dialogTitle='修改信息';
        this.updateData=Object.assign({},this.headerButtonData.studentBasicMsg[index]);
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
      /*模糊查询*/
      fuzzyClick(){
        /*点击search按钮*/
        this.searchStudentAjax({ListType:this.dataHeader.messageType,class:this.ajaxClasses,grade:this.ajaxGrade,pageSize:this.pageSize,value:this.fuzzyInput});
      },
      /*提示弹框*/
      handlerClose(done){
        /*this.$confirm('确认关闭？').then(()=>{done();}).catch();*/
        done();
      },
      /*重置*/
      resetClick(fileName){
        this.$refs[fileName].resetFields();
      },
      /*send ajax*/
      updateAjax(){
        this.isDialog=false;
        /*userId:this.updateData.userId,*/
        studentMessageUpdate({ListType:this.dataHeader.messageType,updataData:this.updateData}).then(data=>{
          if(data.statu){
            this.searchClick('studentMessge');
            this.$message({
              message:'修改成功!',
              type:'success'
            });
          }else{
            this.$message.error('修改失败!');
          }
        })
      },
      deleteAjax(){
        /*this.resetClick('studentMessge');*/
        if(this.mutipleChoose.length>0){
          const deleteArr=[];
          this.mutipleChoose.forEach((value)=>{
            deleteArr.push(value.userId);
          });
          studentMessageDelete({userId:deleteArr}).then(data=>{
            if(data.statu>0){
              this.$message({
                message:'删除成功!',
                type:'success'
              });
              /*刷新页面数据*/
              this.searchStudentAjax({ListType:this.dataHeader.messageType,class:this.ajaxClasses,grade:this.ajaxGrade,pageSize:this.pageSize});
            }else{
              this.$message.error('删除失败!');
            }
          });
        }else{
          this.$message({
            message:'请选择删除数据!',
            type:'warning'
          });
        }
      },
      /*导出数据*/
      exportAjax(){
        this.handlerParams();
        this.$refs['studentMessge'].validate((valid)=>{
          if(valid){
            this.hrefExport='/api/school/user/exportExcel?type='+this.dataHeader.messageType+'&class='+this.ajaxClasses+'&grade='+this.ajaxGrade;
          }else{
            this.$message({
              message:'请填完整相关信息!',
              type:'warning'
            });
          }
        });
      },
      sendLoadAjax(){
        studentMessageGradeLoad().then(data=>{
          this.headerButtonData.gradeloadData=data;
        });
        studentMessageTypeLoad().then(data=>{
          this.headerButtonData.msgTypeLoadData=data;
        });

      },
      gradeClick(){
        /*获取当前年级的班级*/
        studentMessageClassLoad({gradeid:this.dataHeader.grade}).then(data=>{
          if(data){
            this.headerButtonData.classesLoadData=data;
          }else{
            this.headerButtonData.classesLoadData=[];
          }
        });
      },
      /*页面数据请求*/
      searchClick(formName){
        this.fuzzyInput='';
        /*handler params*/
        this.handlerParams();
        /*send ajax*/
        this.searchStudentAjax({ListType:this.dataHeader.messageType,class:this.ajaxClasses,grade:this.ajaxGrade,pageSize:this.pageSize});
      },
      /*send student ajax*/
      searchStudentAjax(params){
        this.$refs['studentMessge'].validate((valid)=>{
          if(valid){
            studentMessageSearchLoad(params).then(data=>{
              this.headerButtonData.studentBasicMsg=data.data;
              this.headerButtonData.studentBasicTr=data.tr;
              this.pageALl=data.maxpage;
              this.currentPage=data.page;
              this.headerButtonData.hasBasicData=true;
              /*              if(data.data.length>0){
                this.headerButtonData.hasBasicData=true;
              }else{
                this.$message({
                  message:'无数据!'
                });
              }*/
            });
          }else{
            this.$message({
              message:'请填完整相关信息!',
              type:'warning'
            });
          }
        });
      },
      /*params处理，传grade的name和class的name*/
      handlerParams(){
        /*得到选择班级数组*/
        this.ajaxClasses=[];
        if(this.dataHeader.classes=='all'){
          this.headerButtonData.classesLoadData.forEach((value)=>{
            this.ajaxClasses.push(value.classname);
          });
          /*将this.dataHeader.classes改成包含所有classes的数组*/
        }
        else{
          this.headerButtonData.classesLoadData.forEach((value)=>{
            if(value.classid==this.dataHeader.classes){
              this.ajaxClasses.push(value.classname);
            }
          });
        }
        /*得到当前的年级的name值*/
        this.headerButtonData.gradeloadData.forEach((value)=>{
          if(value.gradeid==this.dataHeader.grade){
            this.ajaxGrade=value.name;
          }
        });
      },
      /*弹框提示*/
      alertDialog(msg,type){
        this.$alert(msg,'提示',{
          confirmButtonText:'确定',
          type:type,
          callback:action=>{}
        });
      },
    },
    created(){
      this.sendLoadAjax();
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../../style/userManager/student/studentMessage.less';
  @import '../../../../../style/userManager/student/studentManager.css';
</style>


