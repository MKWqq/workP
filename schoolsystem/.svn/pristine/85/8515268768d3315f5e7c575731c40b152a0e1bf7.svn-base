<template>
  <div class="applicationForm">
    <h3>异动申请表</h3>
    <el-row class="applicationForm_row">
      <el-button type="primary" class="uploadTemplate" @click="showDialog">
        <img src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_upload.png"
             alt="">
        <span>上传模板</span>
      </el-button>
      <span class="warmHint">温馨提示：您可以上传Word、Excel模板表格，方便您下次打印和下载使用。</span>
    </el-row>
    <el-row class="d_line"></el-row>
    <el-row type="flex" justify="end" class="alertsBtn">
      <el-col :span="18">
        <el-button class="delete" title="导出">
          <img class="delete_unactive"
               src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png" alt="">
          <img class="delete_active"
               src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
               alt="">
        </el-button>
        <el-button-group class="secBtn-group">
          <el-button class="filt" title="复制">
            <img class="filt_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png"
                 alt="">
            <img class="filt_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png"
                 alt="">
          </el-button>
          <el-button class="delete" title="打印">
            <img class="delete_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png"
                 alt="">
            <img class="delete_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png"
                 alt="">
          </el-button>
        </el-button-group>
      </el-col>
      <el-col :span="8">
        <div class="g-fuzzyInput">
          <el-input
            placeholder="请选择日期"
            icon="search"
            v-model="selectParam.searchValue"
            :on-icon-click="goSearch">
          </el-input>
        </div>
      </el-col>
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        style="width: 100%"
      >
        <el-table-column
          type="index"
          width="100"
          label="序号">
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="表格名称">
        </el-table-column>
        <el-table-column
          label="操作">
          <template scope="scope">
            <span class="operation edit" @click="operation('load',scope.$index)">下载</span>
            <span class="operation edit" @click="operation('preview',scope.$index)">预览</span>
            <span class="operation edit" @click="operation('rename',scope.$index)">重命名</span>
            <span class="operation delete" @click="operation(delete'',scope.$index)">删除</span>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
    <el-row class="pageAlerts" v-if="tableData.length!=0">
      <el-pagination
        @current-change="handleCurrentChange"
        :current-page.sync="currentPage"
        :page-size="pageALl"
        layout="prev, pager, next, jumper"
        :total="1000">
      </el-pagination>
    </el-row>
    <el-dialog
      title="上传申请表模板"
      :visible.sync="dialogVisible"
      :modal="false"
      :before-close="handleClose">
      <el-row>
        <el-form ref="templateForm" :model="templateForm" label-width="100px">
          <el-form-item label="申请表名称：">
            <el-col :span="17">
              <el-input v-model="fileData.name">
                <template slot="append">.txt</template>
              </el-input>
            </el-col>
            <el-col :span="6" :offset="1">
              <div class="uploadFile">
                <el-button>选择文件</el-button>
                <input type="file" accept=".xlsx,.xlsm,.xls.doc,.docx" class="file_input" @change="sendFile">
              </div>
            </el-col>
          </el-form-item>
          <el-form-item label="修改名称：">
            <el-switch on-text="是" off-text="否" on-color="#09baa7" v-model="templateForm.isChange"></el-switch>
          </el-form-item>
        </el-form>
      </el-row>
      <span slot="footer" class="dialog-footer">
    <el-button type="primary" @click="save(0)">保存</el-button>
    <el-button @click="dialogVisible = false">取消</el-button>
  </span>
    </el-dialog>
    <el-dialog
      title="修改名称"
      :visible.sync="nameDialogVisible"
      :modal="false"
      :before-close="handleClose">
      <el-row type="flex" justify="center">
        <el-col :span="18">
          <el-form ref="nameForm" :model="nameForm" label-width="100px">
            <el-form-item label="表格名称：">
              <el-input v-model="nameForm.name">
                <template slot="append">.txt</template>
              </el-input>
            </el-form-item>
          </el-form>
        </el-col>
      </el-row>
      <span slot="footer" class="dialog-footer">
    <el-button type="primary" @click="save(1)">保存</el-button>
    <el-button @click="nameDialogVisible = false">取消</el-button>
  </span>
    </el-dialog>
  </div>
</template>
<script>
  export default{
    data(){
      return {
        tableData: [{
          id: 1,
          title: '今天天气不错啊',
          type: '通知',
          publisher: 1,
          publishPart: 'hjshf',
          date: '2016-05-03 16:16:55',
          vState: '已查阅',
          checked: false
        }, {
          id: 2,
          title: '下雨了',
          type: '通知',
          publisher: 2,
          publishPart: 'hjshf',
          date: '2016-05-03 16:16:55',
          vState: '未查阅',
          checked: false
        }, {
          id: 3,
          title: '那是',
          type: '通知',
          publisher: 0,
          publishPart: 'hjshf',
          date: '2016-05-03 16:16:55',
          vState: '已查阅',
          checked: false
        }],
        currentPage: 1,
        pageALl: 100,
        selectParam: {
          grade: '',
          class: '',
          searchValue: ''
        },
        dialogVisible: false,
        templateForm:{
            name:'',
          isChange:true
        },
        fileData:{},
        nameDialogVisible:false,
        nameForm:{
            name:''
        }
      }
    },
    methods: {
      goSearch(ev) {  //查询
        console.log(ev);
      },
      sendFile(){   //上传文件
        var suffix, file = $('.file_input').prop('files')[0],nameR;
        suffix = file.name.split('.')[1];
        nameR = file.name.split('.')[0];
        switch (suffix) {
          case 'docx':
          case 'doc':
          case 'xlsx':
          case 'xlsm':
          case 'xls':
              this.fileData.name=suffix;
              this.fileData.nameR=nameR;
              this.fileData.file=file;
            console.log(this.fileData);
            break;
          default:
            this.$message({
              message: '只能上传word、xlsx、xlsm、xls格式文件！',
              showClose: true
            });
            return false;
        }
      },
      handleCurrentChange(val) {
        this.currentPage = val;
        console.log(`当前页: ${this.currentPage}`);
      },
      showDialog(){
          this.dialogVisible=true;
      },
      handleClose(done) {
        done();
      },
      operation(type, idx){
        if (type == 'load') {

        } else if (type == 'preview') {

        } else if (type == 'rename') {
            this.nameDialogVisible=true;
        } else {

        }
      },
      save(type){
        if(type==0){
          var formData=new FormData();
          formData.append('file',this.fileData.file);
          this.dialogVisible = false;
        }else{
          this.nameDialogVisible = false;
        }
      }
    }
  }
</script>
<style>
  .applicationForm {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .applicationForm .applicationForm_row {
    margin-top: 2rem;
  }

  .applicationForm .alertsBtn {
    margin: 1.25rem 0;
  }

  .applicationForm .alertsList .el-table th, .applicationForm .alertsList .el-table td {
    text-align: center;
  }

  .applicationForm h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
    display: inline-block;
  }

  .applicationForm .warmHint {
    color: #999999;
    margin-left: 1.25rem;
    font-size: 14px;
  }

  .applicationForm .uploadTemplate {
    padding: 8px 20px;
  }

  .applicationForm .d_line {
    margin: 1.25rem 0;
  }

  .applicationForm .g-fuzzyInput {
    float: right;
  }

  .applicationForm .operation {
    cursor: pointer;
    padding: 0 1.125rem;
  }

  .applicationForm .operation + .operation {
    border-left: 1px solid #d2d2d2;
  }

  .applicationForm .edit {
    color: #4da1ff;
  }

  .applicationForm .delete {
    color: #ff6773;
  }

  .applicationForm .uploadFile {
    position: relative;
  }
.applicationForm .uploadFile .el-button{
  border-radius: 20px;
  width:100%;
}
  .applicationForm .file_input {
    width: 100%;
    height: 36px;
    position: absolute;
    right: 0;
    top: 0;
    z-index: 1;
    -moz-opacity: 0;
    -ms-opacity: 0;
    -webkit-opacity: 0;
    opacity: 0; /*css属性——opcity不透明度，取值0-1*/
    filter: alpha(opacity=0); /*兼容IE8及以下--filter属性是IE特有的，它还有很多其它滤镜效果，而filter: alpha(opacity=0); 兼容IE8及以下的IE浏览器(如果你的电脑IE是8以下的版本，使用某些效果是可能会有一个允许ActiveX的提示,注意点一下就ok啦)*/
    cursor: pointer;
  }

  .applicationForm .el-dialog--small {
    width: 600px;
  }
</style>
