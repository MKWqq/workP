<template>
    <div class="newDcoument">
      <h3>新建公文</h3>
      <el-row class="newDoc-top" type="flex" align="middle">
        <el-col :span="24">
          <el-col :span="11">
            <el-col :span="2" class="newDoc-top-title">标题：</el-col>
            <el-col :span="22">
              <el-input v-model="param.title"></el-input>
            </el-col>
          </el-col>
          <el-col :span="11" :offset="2">
            <el-col :span="2" class="newDoc-top-title">类型：</el-col>
            <el-col :span="22">
              <el-select style="width: 100%" v-model="param.name" placeholder="请选择">
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-col>
          </el-col>
        </el-col>
      </el-row>
      <el-row>
        <el-col :span="24" class="newDoc-text-title">编辑内容：</el-col>
      </el-row>
      <el-row class="newDoc-vueditor">
        <Vueditor ref="vueditor"></Vueditor>
      </el-row>
      <el-row class="newDoc_footer">
        <el-col :span="22">
          <el-row>
            <el-col :span="5">
              <el-col :span="7" style="margin-top: .3rem">附件：</el-col>
              <el-col :span="16" style="border-right: 1px solid #d2d2d2">
                <div class="uploadFile">
                <el-button>选择附件</el-button>
                <input type="file" accept=".xlsx,.xlsm,.xls.doc,.docx,.ppt" class="file_input" @change="sendFile">
              </div>
              </el-col>
            </el-col>
            <el-col :span="19" class="fileLists">
              <div v-for="(file,index) in fileList">
                <img v-if="file.fileType==1"
                     src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_ppt.png"
                     alt="">
                <img v-if="file.fileType==2"
                     src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_word.png"
                     alt="">
                <img v-if="file.fileType==3"
                     src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_excel.png"
                     alt="">
                <span :title="file.name">{{file.name}}</span>
                <i class="el-icon-close" @click="deleteFile(index)"></i>
              </div>
            </el-col>
          </el-row>
        </el-col>
        <el-col :span="2">
          <el-button type="primary" @click="PublishnewDoc()">发布</el-button>
        </el-col>
      </el-row>
    </div>
</template>
<script>
  import Vue from 'vue'
  import Vueditor from 'vueditor'
  import 'vueditor/dist/style/vueditor.min.css'
  import config from '../../../../../components/vueditor/config'
  import req from '../../../../../assets/js/common'
  import ElCol from "element-ui/packages/col/src/col";
  Vue.use(Vueditor, config);
    export default{
      data(){
            return {
              options: [{
                value: '',
              }],
              fileList: [],
              param: {
                title: '',
                name:'',
                type: 'create',
                content: '',
              }
            }
        },
      created(){
        let param={
          kind:4
        };
        req.ajaxSend('/school/WorkDemand/getName','post',param,(res)=>{
          this.options = res.map(val=>({value:val.name}))
        });
      },
        methods: {
          sendFile(){   //上传文件
            if (this.fileList.length >= 3) {
              this.$message({
                message: '最多只能上传三个附件！',
                showClose: true
              });
              return false;
            }
            // 实例化一个表单数据对象
            var fileType, suffix;
            // 遍历图片文件列表，插入到表单数据中
            for (var i = 0, file; file = $('.file_input').prop('files')[i]; i++) {
              suffix = file.name.split('.')[1];
              switch (suffix) {
                case 'ppt':
                  fileType = 1;
                  break;
                case 'docx':
                case 'doc':
                  fileType = 2;
                  break;
                case 'xlsx':
                case 'xlsm':
                case 'xls':
                  fileType = 3;
                  break;
                default:
                  this.$message({
                    message: '只能上传word、xlsx、xlsm、xls、ppt格式文件！',
                    showClose: true
                  });
                  return false;
              }
              this.fileList.push({'fileType': fileType, 'name': file.name, 'file': file});
            }
          },
          deleteFile(idx){   //删除文件
            this.fileList.splice(idx,1);
          },
          PublishnewDoc(){
            let sendFormData=new FormData(),
              contenttext = this.$refs.vueditor.getContent();
              this.param.content=contenttext;
              for (let i of this.fileList){
                sendFormData.append('accessory[]', i.file);
              }
            sendFormData.append('content', contenttext);
            sendFormData.append('name',this.param.name);
            sendFormData.append('title',this.param.title);
            sendFormData.append('type',this.param.type);
            if(this.param.title===''){
                this.$message('请输入公文标题');
                return;
              }
              else if(this.param.name===''){
                this.$message('请选择发布类型');
                return;
              }
              else if(contenttext===''){
                this.$message('请完善公文内容');
                return;
              }
              else{
                this.$confirm('此操作将录入系统, 是否继续?', '提示', {
                  confirmButtonText: '确定',
                  cancelButtonText: '取消',
                  type: 'warning'
                }).then(() => {
                  req.ajaxFile('/school/WorkDemand/createDoc','post',sendFormData,(res)=>{
                    if(res.status===1){
                      this.$message({
                        type: 'success',
                        message: res.msg
                      });
                    }else {
                      this.$message(res.msg);
                    }
                  });
                }).catch(() => {
                  this.$message({
                    type: 'info',
                    message: '已取消创建'
                  });
                });
              }
          },
        }
    }
</script>
<style lang="less">
  .newDcoument{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .newDoc-top{
    margin: 2rem 0;
  }
  .newDoc-top-title{
    margin-top: 0.5rem;
  }
  .newDoc-text-title{
    font-weight: bold;
    padding-bottom: .8rem;
  }
  .newDoc-vueditor{
    height: 39rem;
    border: 1px solid #c0c0c0;
    border-radius: 6px;
  }
  @media (max-width: 1600px) {
    .noticeUeditor {
      height: 38.5rem;
    }
  }
  @media (max-width: 1420px) {
    .noticeUeditor {
      height: 37.7rem;
    }
  }
  .newDoc_footer{
    margin-top: 24/16rem;
    border-top: 1px solid #c0c0c0;
    padding: 1rem 2rem;
    .el-button {
      width: 110/16rem;
      border-radius: 18/16rem;
      padding: 10px 0;
    }
  }
  .fileLists > div {
    float: left;
    position: relative;
    font-size: 14/16rem;
    margin-left: 2rem;
    span {
      display: inline-block;
      max-width: 10rem;
      text-overflow: ellipsis;
      overflow: hidden;
      white-space: nowrap;
    }
    img {
      width: 22/16rem;
      margin-right: 14/16rem;
    }
    i {
      position: absolute;
      right: -10px;
      top: -5px;
      cursor: pointer;
      font-size: 12px;
    }
  }
  .uploadFile {
    display: inline-block;
    position: relative;
    .file_input {
      width: 100%;
      height: 36px;
      border-radius: 18/16rem;
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
  }
</style>
