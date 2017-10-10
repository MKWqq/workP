<template>
  <div class="DocumentRecord">
    <h3>公文流转记录</h3>
    <el-row>
      <el-col class="LeaveRecord-title">
        <!--时间段-->
        <el-col :span="24">
          <el-col :span="2">时间段：</el-col>
          <el-col :span="3" style="margin-left: -3rem">
            <el-date-picker
              v-model="startvalue" type="date" :picker-options="pickerOptions0" style="width: 100%">
            </el-date-picker>
          </el-col>
          <el-col :span="1"  style="text-align: center">_</el-col>
          <el-col :span="3">
            <el-date-picker
              v-model="endvalue" type="date" :picker-options="pickerOptions1" style="width: 100%">
            </el-date-picker>
          </el-col>
          <el-col :span="1">
            <el-button type="primary" icon="search" class="LeaveRecord-search" @click="getRecord()">查询</el-button>
          </el-col>
        </el-col>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="17" class="alertsBtn" style="margin-top: 0">
        <el-button-group style="margin-top:1.8rem">
          <el-button class="delete" title="导出">
            <img class="delete_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
                 alt="">
            <img class="delete_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
                 alt="">
          </el-button>
          <el-button class="filt" title="复制">
            <img class="filt_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png"
                 alt="">
            <img class="filt_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png"
                 alt="">
          </el-button>
        </el-button-group>
      </el-col>
      <el-col :span="5" :offset="2" class="Infor-input-inner" style="margin-top:1.8rem;">
        <el-input style="border-radius:1rem" placeholder="请输入搜索内容" icon="search" v-model="Searchinput" :on-icon-click="handleIconClick"></el-input>
      </el-col>
    </el-row>
    <el-col :span="24">
      <el-row class="alertsList">
        <el-table
          :data="tableData"
          style="width: 100%"
          v-loading.body="isLoading"
          element-loading-text="拼命加载中...">
          <el-table-column
            prop="title"
            label="标题"
            align="center">
          </el-table-column>
          <el-table-column
            prop="name"
            label="类型"
            align="center">
          </el-table-column>
          <el-table-column
            prop="content"
            label="说明"
            align="center"
            width="200">
            <template scope="scope">
              <span>{{scope.row.content}}</span>
            </template>
          </el-table-column>
          <el-table-column
            prop="createTime"
            label="创建日期"
            align="center"
            width="180">
            <template scope="scope">
              <span>{{scope.row.createTime|formatDate}}</span>
            </template>
          </el-table-column>
          <el-table-column
            prop="result"
            label="审批结果"
            align="center">
            <template scope="scope">
              <p v-for="item in scope.row.result1" v-html="item"></p>
            </template>
          </el-table-column>
          <el-table-column
            prop="opinion"
            label="审批意见"
            align="center">
            <template scope="scope">
              <p v-for="item in scope.row.opinion1" v-html="item"></p>
            </template>
          </el-table-column>
          <el-table-column
            prop="approver"
            label="审批人"
            align="center">
            <template scope="scope">
              <p v-for="item in scope.row.approver1" v-html="item"></p>
            </template>
          </el-table-column>
          <el-table-column
            label="id"
            align="center">
            <template scope="scope">
              <span>{{scope.row.id}}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="操作"
            width="200">
            <template scope="scope">
              <span style="color:#4da1ff;cursor: pointer;border-right:1px solid #d2d2d2;padding-right:.6rem" @click="showDialog(scope.row)">编辑</span>
              <span style="color:#48b6c4;cursor: pointer;border-right:1px solid #d2d2d2;padding:0 .6rem" @click="showDialogother(scope.row)">详情</span>
              <span style="color:#ff6a6a;cursor: pointer;padding-left: .6rem" @click="Delectlist(scope.row)">删除</span>
            </template>
          </el-table-column>
        </el-table>
      </el-row>
      <el-dialog title="编辑信息" :modal="false" :visible.sync="dialogTableVisible" v-if="">
        <el-col :span="24" class="Doc-dia-top">
          <el-col :span="2">标题：</el-col>
          <el-col :span="22">
            <el-input v-model="form.title"></el-input>
          </el-col>
        </el-col>
        <el-col :span="24" class="Doc-dia-top">
          <el-col :span="2">类型：</el-col>
          <el-col :span="22">
            <el-select style="width:100%" v-model="form.name">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-col>
        </el-col>
        <el-col :span="24" class="Doc-dia-top">
          <el-col :span="2">内容：</el-col>
          <el-col :span="22" class="newDoc-vueditor">
            <Vueditor ref="vueditor" v-model="form.content"></Vueditor>
          </el-col>
        </el-col>
        <div slot="footer" class="dialog-footer">
          <el-col :span="24" class="Doc-dia-top">
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
                <div v-for="(file,index) in fileLists">
                  <img v-if="file.fileType.indexOf('ppt')>-1"
                       src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_ppt.png"
                       alt="">
                  <img v-if="file.fileType.indexOf('doc')>-1"
                       src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_word.png"
                       alt="">
                  <img v-if="file.fileType.indexOf('xls')>-1"
                       src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_excel.png"
                       alt="">
                  <span :title="file.name">{{file.name}}</span>
                </div>
              </el-col>
            </el-row>
          </el-col>
          <el-button type="primary" @click="editDoc()">保存</el-button>
        </div>
      </el-dialog>
      <el-dialog title="公文流转详情" :modal="false" :visible.sync="dialogTableVisibleother">
        <el-col :span="24" style="text-align: center;min-height: 35rem;">
          <div class="LeaveRecord-table">
            <el-col :span="24">
              <div class="LeaveRecord-table-div">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">标题</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.title}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div" style="height: 8rem;">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1" style="height: 8rem;line-height: 8rem;">附件</div>
                </el-col>
                <el-col :span="17">
                  <div style="text-align: left">
                    <a style="cursor: pointer;" id="downloadtext" @click="downloadtext(dialogData.id)">{{dialogData.accessoryName}}</a>
                  </div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div" style="height: 20rem;">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1" style="height: 20rem;line-height: 20rem;">内容</div>
                </el-col>
                <el-col :span="17">
                  <div style="text-align: left">{{dialogData.content}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div LeaveRecord-table-div-final">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">创建时间</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.createTime | formatDate}}</div>
                </el-col>
              </div>
            </el-col>
          </div>
        </el-col>
      </el-dialog>
      <el-row class="pageAlerts">
        <el-pagination
          @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-size="10"
          layout="prev, pager, next, jumper"
          :total="total">
        </el-pagination>
      </el-row>
    </el-col>
  </div>
</template>
<script>
  import req from './../../../../../assets/js/common'
  import Vue from 'vue'
  import Vueditor from 'vueditor'
  import 'vueditor/dist/style/vueditor.min.css'
  import config from '../../../../../components/vueditor/config'
  import formatdata from './../../../../../assets/js/date'
  Vue.use(Vueditor, config);
  export default{
    data(){
      return{
        Searchinput: '',
        pickerOptions0: {
          disabledDate(time) {
            return time.getTime() > Date.now();
          }
        },
        pickerOptions1: {
          disabledDate(time) {
            return time.getTime() > Date.now();
          }
        },
        isLoading:false,
        dialogTableVisible: false,
        dialogTableVisibleother:false,
        tableData: [],
        form:{},
        fileList: [],
        dialogData:[],
        options: [{
          value: '',
        }],
        formLabelWidth: '120px',
        currentPage: 1,
        pageALl: 10,
        total:0,
        startvalue:new Date(),
        endvalue:new Date(),
        params:{
          title: '',
          name:'',
          type: 'edit',
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
      this.getRecord(1)
    },
    computed:{
      fileLists(){
        return this.form.accessoryName?this.form.accessoryName.split(',').map(val=>({'fileType': val.split('.')[1], 'name': val, 'file': null})):[]
      }
    },
    methods:{
//        编辑
      showDialog(row){
        this.form=row;
        this.dialogTableVisible=true;
        setTimeout(()=>{
          this.$refs.vueditor.setContent(row.content);
        },20)
      },
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
      editDoc(){
        let sendFormData=new FormData(),
          contenttext = this.$refs.vueditor.getContent();
        this.params.content=contenttext;
        for (let i of this.fileList){
          sendFormData.append('accessory[]', i.file);
        }
        sendFormData.append('content', contenttext);
        sendFormData.append('name',this.form.name);
        sendFormData.append('title',this.form.title);
        sendFormData.append('type',this.params.type);
//        console.log(contenttext);
//        console.log(this.form.name);
//        console.log(this.form.title);
//        console.log(this.params.type);
        if(this.form.title===''){
          this.$message('请输入公文标题');
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
            req.ajaxFile('/school/WorkDemand/logDoc','post',sendFormData,(res)=>{
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
      showDialogother(row){
        this.dialogTableVisibleother=true;
        this.dialogData=row;
      },
      downloadtext(id){
        req.downloadFile('.DocumentRecord','/school/WorkDemand/LogDoc?type=download&nid='+id,'post');
      },
      handleIconClick(){
        console.log("这是模糊查询")
      },
      getRecord(page){
        if(page!==this.currentPage){
          this.currentPage=page;
        }
        this.isLoading=true;
        let
//        startvalue=formatdata.format(this.startvalue,'yyyy-MM-dd'),
          startvalue=formatdata.format(this.startvalue,'2017-09-12'),
          endvalue=formatdata.format(this.endvalue,'yyyy-MM-dd')+'23:59:59',
          param={
            page: page,
            count:10,
            startTime:startvalue,
            endTime: endvalue,
          };
        req.ajaxSend('/school/WorkDemand/LogDoc','post',param,(res)=>{
          if (res.status === -1) {
            this.tableData = [];
            this.isLoading = false;
            return;
          }
          res.data.forEach((val)=>{
            for(let key in val){
              if(typeof val[key] === 'string'&&(val[key].indexOf('[')>-1||val[key].indexOf('{')>-1)){
                val[key] = JSON.parse(val[key]);
              }
            }
//            console.log(JSON.stringify(val,null,4));
            val.approver1 = [];
            val.opinion1 = [];
            val.result1 = [];
            if(val.approver){
              //审批人
              val.approver.forEach((v,i)=>{
                if(val.approver[i]){
                  val.approver[i].forEach((subval)=>{
                    if(subval){
                      val.approver1.push(`${subval}`)
                    }
                  })
                }
              });
              //审批意见
              val.opinion.forEach((v,i)=>{
                if(val.opinion[i]){
                  val.opinion[i].forEach((subval)=>{
                    if(subval){
                      val.opinion1.push(`${subval}`)
                    }
                  })
                }
              });
              //审批结果
              val.result.forEach((v,i)=>{
                if(val.result[i]){
                  val.result[i].forEach((subval,idx)=>{
                    if(subval){
                      let result = this.resultFilter(val.result[i][idx]);
                      val.result1.push(`${result}`);
                    }
                  })
                }
              });
            }else{
              val.approver1 = '无';
              val.opinion1 = '无';
              val.result1 = '无';
            }
          });
          this.tableData =res.data;
          this.total = res.total;
          this.isLoading=false;
        });
      },
      resultFilter(v){
        return v===1?'通过':
          v===2?'审批过期':
            v===-2?'无':'未通过';
      },
      Delectlist(row){
        let that=this,
          idsarray=[],
          detailsarray=[],
          param={
            type:'del',
            id:idsarray,
            detailId:detailsarray,
          };
        idsarray.push(row.id);
        detailsarray.push(row.detailId);
        that.$confirm('此操作将永久删除该文件, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          req.ajaxSend('/school/WorkDemand/LogDoc','post',param,function (res){
            for(let i=0;i<that.tableData.length;i++){
              if(that.tableData[i].id===row.id){
                that.tableData.splice(i,1);
                i--;
              }
            }
            console.log();
            that.$message({
              type: 'success',
              message: res.msg
            });
          })
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '已取消删除'
          });
        });
      },
      handleCurrentChange(val) {
        this.currentPage = val;
        this.getRecord(val);
      }
    },
  }
</script>
<style lang="less">
  .DocumentRecord{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .Doc-dia-top{
    margin-top: 1.3rem;
  }
  .LeaveRecord-title{
    margin-top: 2rem;
    padding-bottom: 1.3rem;
    border-bottom: 1px solid #d2d2d2;
  }
  .LeaveRecord-search{
    background: #4da1ff;
    width: 7rem;
    margin-left: 1.6rem;
  }
  .Infor-input-inner .el-input__inner{
    /*border-radius: 1.2rem;*/
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
  .newDoc-vueditor{
    height: 24rem;
    border: 1px solid #c0c0c0;
    border-radius: 6px;
    width: 90%;
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

  .LeaveRecord-table-div{
    width: 100%;
    height: 2.625rem;
    border-top: 1px solid #d2d2d2;
    text-align: center;
    line-height: 2.625rem;
    box-sizing:border-box;
  }
  .LeaveRecord-table-div-final{
    border-bottom: 1px solid #d2d2d2;
  }
  .LeaveRecord-table-div-1{
    border-right: 1px solid #d2d2d2;
  }

</style>
