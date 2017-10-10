<template>
  <div class="newNotice">
    <el-row class="newNotice_content">
      <h3>新建通知</h3>
      <el-row :gutter="24" class="newNotice_center">
        <el-col :span="18">
          <el-row type="flex" align="middle">
            <el-col :span="2">标题：</el-col>
            <el-col :span="12">
              <el-input placeholder="请输入内容" class="newNotice_title_input" v-model="form.title"></el-input>
            </el-col>
            <el-col :span="2" :offset="2">类型：</el-col>
            <el-col :span="6">
              <el-select v-model="form.kind" placeholder="请选择" class="newNotice_title_select">
                <el-option v-for="item in options" :key="item.value" :label="item.label"
                           :value="item.value"></el-option>
              </el-select>
            </el-col>
          </el-row>
          <el-row type="flex" align="middle" class="newNotice_two">
            <el-col :span="2">通知对象：</el-col>
            <el-col :span="22">
              <div class="noticeObj">
                <span v-if="form.uids.length==0" class="noStaff">在右边联系人栏中选择</span>
                <el-tag v-if="form.uids.length!=0" v-for="tag in form.uids" :key="tag.label" :closable="true"
                        :type="tag.type"
                        @close="handleClose(tag)">{{tag.label}}
                </el-tag>
              </div>
            </el-col>
          </el-row>
          <el-row class="newNotice_two">
            <el-col class="newNotice_edit">编辑内容：</el-col>
          </el-row>
          <el-row class="noticeUeditor">
            <Vueditor ref="vueditor"></Vueditor>
          </el-row>
        </el-col>
        <el-col :span="6">
          <el-row class="contact">
            <el-col :span="12" class="contact_all" :class="{'contact_active':contactType==1}">
              <span @click="getContact(1)">全部联系人</span>
            </el-col>
            <el-col :span="12" class="contact_used" :class="{'contact_active':contactType==2}">
              <span @click="getContact(2)">常用联系人</span>
            </el-col>
          </el-row>
          <el-row class="contact_list">
            <div id="treeList" style="width:100%; margin: auto auto;">
              <el-tree
                :data="treeData"
                show-checkbox
                node-key="id"
                :props="defaultProps"
                ref="tree"
                @check-change="choosePeople"
                :render-content="renderContent">
              </el-tree>
            </div>
          </el-row>
        </el-col>
      </el-row>
    </el-row>
    <el-row class="newNotice_footer">
      <el-col :span="17">
        <el-row>
          <el-col :span="5">
            <span>附件：</span>
            <div class="uploadFile">
              <el-button>选择附件</el-button>
              <input type="file" accept=".xlsx,.xlsm,.xls.doc,.docx,.ppt" class="file_input" @change="sendFile">
            </div>
          </el-col>
          <el-col :span="19" class="fileLists">
            <div v-for="(file,index) in fileList">
              <img v-if="file.fileType==1"
                   src="../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_ppt.png"
                   alt="">
              <img v-if="file.fileType==2"
                   src="../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_word.png"
                   alt="">
              <img v-if="file.fileType==3"
                   src="../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_excel.png"
                   alt="">
              <span :title="file.name">{{file.name}}</span>
              <i class="el-icon-close" @click="deleteFile(index)"></i>
            </div>
          </el-col>
        </el-row>
      </el-col>
      <el-col :span="7">
        <el-button type="primary" @click="published(0)">发布</el-button>
        <el-button @click="preview">预览</el-button>
        <el-button @click="published(1)">保存草稿</el-button>
      </el-col>
    </el-row>
    <el-dialog
      title="查看通知"
      :visible.sync="dialogVisible"
      :before-close="handleClose"
      :modal="false" class="previewDetail">
      <h3 class="previewDetail_title">{{form.title}}</h3>
      <el-row class="previewDetail_subTitle" :gutter="10">
        <el-col :span="5">发布者：{{userInfo.name}}</el-col>
        <el-col :span="7" class="previewDetail_subTitle_part">发布部门：{{userInfo.department}}</el-col>
        <el-col :span="12" class="previewDetail_subTitle_time">发布时间：{{nowDate|formatDate}}</el-col>
      </el-row>
      <el-row class="previewDetail_center">
        <div v-html="form.content"></div>
      </el-row>
      <el-row>
        <el-button class="previewDetail_annex" type="primary">附件下载</el-button>
      </el-row>
      <el-row class="previewDetail_list clear_fix">
        <div v-for="file in fileList">
          <img v-if="file.fileType==1"
               src="../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_ppt.png"
               alt="">
          <img v-if="file.fileType==2"
               src="../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_word.png"
               alt="">
          <img v-if="file.fileType==3"
               src="../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_excel.png"
               alt="">
          <span :title="file.name">{{file.name}}</span>
        </div>
      </el-row>
    </el-dialog>
  </div>
</template>
<script>
  //vueditor编辑器
  import Vue from 'vue'
  import Vuex from 'vuex'
  import Vueditor from 'vueditor'
  import 'vueditor/dist/style/vueditor.min.css'
  import config from '@/components/vueditor/config'
  import req from '@/assets/js/common'

  Vue.use(Vuex);
  Vue.use(Vueditor, config);

  export default {
    data() {
      return {
        options: [{
          value: 1,
          label: '通知'
        }, {
          value: 2,
          label: '公告'
        }, {
          value: 3,
          label: '通报'
        }, {
          value: 4,
          label: '决议'
        }],
        form: {
          title: '',
          kind: '',
          uids: [{label: '一级', id: 1}, {label: '二级', id: 2}],
          type: 'create',
          content: '',
          draft: 0
        },
        treeData: [{
          id: 1,
          parentId: 0,
          label: '一级 1',
          state: true,
          children: [{
            id: 4,
            parentId: 1,
            label: '二级 1-1',
            children: [{
              id: 9,
              parentId: 4,
              label: '三级 1-1-1'
            }, {
              id: 10,
              parentId: 4,
              label: '三级 1-1-2',
              children: [{
                id: 11,
                parentId: 10,
                label: '四级1-1-2-1'
              }, {
                id: 12,
                parentId: 10,
                label: '四级1-1-2-2'
              }]
            }]
          }]
        }, {
          id: 2,
          parentId: 0,
          label: '一级 2',
          children: [{
            id: 5,
            parentId: 2,
            label: '二级 2-1'
          }, {
            id: 6,
            parentId: 2,
            label: '二级 2-2'
          }]
        }, {
          id: 3,
          parentId: 0,
          label: '一级 3',
          children: [{
            id: 7,
            parentId: 3,
            label: '二级 3-1'
          }, {
            id: 8,
            parentId: 3,
            label: '二级 3-2'
          }]
        }],
        defaultProps: {
          children: 'children',
          label: 'label'
        },
        contactType: 1,
        fileList: [],
        dialogVisible: false,
        nowDate:''
      }
    },
    computed: {
      userInfo () {   //获取登录后的用户信息
        return this.$store.state.userInfo;
      }
    },
    created: function () {
      var self = this;
      req.ajaxSend('/school/Notification/getUser', 'post', {which: this.contactType}, function (res) {
//        self.treeData=res.js;
      })
    },
    methods: {
      renderContent(h, {node, data, store}) {   //树空间自定义渲染
        var nSpan = '';
        if (data.state) {
          nSpan =
        <
          span
          style = "color: #05adaa;" >（已绑定微信）</
          span >;
        } else {
          nSpan =
        <
          span >（未绑定微信）</
          span >;
        }
        return ( < span >
          < span >
          < span > {node.label
      }</
        span >
        < / span >
        < span
        style = "font-size:12px" > {nSpan} < / span >
          < / span >
      )
        ;
      },
      getContact(type){
        this.contactType = type;
      },
      handleClose(tag){
        this.$refs.tree.setChecked(tag, false, true);
        this.form.uids.splice(this.form.uids.indexOf(tag), 1);
      },
      choosePeople(data, state, child){
//        this.form.uids=[];
        let cNode1 = this.$refs.tree.getCheckedNodes(true);
        let cNode2 = this.$refs.tree.getCheckedNodes();
        let nAry = [];
        console.log(cNode1);
        console.log('***********');
        console.log(cNode2);
        for (let obj of cNode1) {
          for (let [idx, ob] of cNode2.entries()) {
            if (obj.id != ob.id) {
              cNode2.splice(idx, 1);
            }
          }
        }
        this.form.uids = cNode2;
        /*console.log(child);
         if (state&&!child) {
         this.form.uids.push(data);
         } else {
         if (!this.form.uids) return false;
         for (let [i, obj] of  this.form.uids.entries()) {
         if (data.id == obj.id) {
         this.form.uids.splice(i, 1);
         break;
         }
         }
         }*/
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
        this.fileList.splice(idx, 1);
      },
      handleClose(done) {   //关闭弹框
        done();
      },
      preview(){
        this.dialogVisible = true;
        let inst = this.$refs.vueditor.getContent();
        this.form.content = inst;
        this.nowDate=new Date().getTime()/1000;
      },
      published(type){
        var self = this,sendFormData=new FormData();
        let inst = self.$refs.vueditor.getContent();
        self.form.content = inst;
        self.form.draft = type;
        for (let i of self.fileList) {
          sendFormData.append('accessory[]', i.file);
        }
        for (let ob in self.form) {
          if (ob == 'uids') {
            for (let l of self.form[ob]) {
              sendFormData.append('uids[]', l.id);
            }
          } else {
            sendFormData.append(ob, self.form[ob]);
          }
        }
        if (self.form.uids.length == 0) {
          self.$message({
            message: '请选择通知对象',
            showClose: true
          });
          return false;
        }
        req.ajaxFile('/school/Notification/create', 'post', sendFormData, function (res) {
          if (res.status == 1) {
            self.$message({
              type: 'success',
              message: '新建成功',
              showClose: true
            });
          } else {
            self.$message({
              type: 'error',
              message: '新建失败',
              showClose: true
            });
          }
        })
      }
    }
  }
</script>
<style>
  .newNotice .el-dialog--small {
    width: 554px;
  }
</style>
<style lang="less" scoped>
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
  .newNotice {
    padding-top: 20/16rem;
    -webkit-box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    -moz-box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 20/16rem 0;
    background-color: #fff;

  .newNotice_content {
    padding: 0 2rem;
  }

  h3 {
    font-size: 20/16rem;
    color: #4e4e4e;
  }

  .el-select {
    width: 100%;
  }

  }
  .newNotice_center {
    margin-top: 2rem;
  }

  .newNotice_two {
    margin-top: 24/16rem;

  .newNotice_edit {
    padding-bottom: .8rem;
  }

  .noticeObj {
    width: 100%;
    height: 36px;
    overflow: auto;
    border-radius: 6px;
    border: 1px solid #bfcbd9;
    padding: 0 .5rem;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;

  span.noStaff {
    color: #a8a8a8;
    line-height: 36px;
  }

  .el-tag {
    background-color: #f08bc4;
    padding: 0 .6rem;
    margin-right: 1rem;
    margin-top: 5px;
  }

  }
  }
  .noticeUeditor {
    height: 39rem;
    border: 1px solid #c0c0c0;
    border-radius: 6px;
  }

  .contact {
    padding: .8rem 0;
    text-align: center;
    border-radius: 6px 6px 0 0;
    color: #8c8c8c;
    border: 1px solid #c0c0c0;
    cursor: pointer;

  .contact_all {
    border-right: 1px solid #c0c0c0;
  }

  .contact_active {
    color: #4da1ff;

  &
  :after {
    position: absolute;
    content: '';
    display: block;
    bottom: -.8rem;
    left: 50%;
    -webkit-transform: translateX(-50%);
    -moz-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    -o-transform: translateX(-50%);
    transform: translateX(-50%);
    width: 50/16rem;
    height: 2px;
    background-color: #4da1ff;
  }

  }
  .contact_all, .contact_used {
    position: relative;
  }

  }
  .contact_list {
    height: 730/16rem;
    border-left: 1px solid #c0c0c0;
    border-right: 1px solid #c0c0c0;
    border-bottom: 1px solid #c0c0c0;
    border-radius: 0 0 6px 6px;
    padding-top: .5rem;

  .el-tree {
    border: none;
  }

  }
  .newNotice_footer {
    margin-top: 24/16rem;
    border-top: 1px solid #c0c0c0;
    padding: 1rem 2rem;

  .fileLists {
    padding: .6rem 0;
    border-left: 1px solid #c0c0c0;
    height: 2.8rem;
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
  .el-button {
    width: 110/16rem;
    border-radius: 18/16rem;
    padding: 10px 0;
  }

  }
  .previewDetail .el-dialog__body {
    padding: 1rem 20px;
  }

  h3.previewDetail_title {
    text-align: center;
    margin-bottom: 1rem;
    font-size: 1rem;
  }

  .previewDetail_subTitle {
    font-size: 12px;
    padding: .8rem 0;
    border-top: 1px solid #dcdcdc;
    border-bottom: 1px solid #dcdcdc;
  }

  .previewDetail_subTitle_part {
    text-align: center;
  }

  .previewDetail_subTitle_time {
    text-align: right;
  }

  .previewDetail_center {
    min-height: 10rem;
    padding: 1.875rem 0;
  }

  .previewDetail_annex {
    border-radius: 0 18px 18px 0;
    -webkit-box-shadow: 0 5px 5px 1px #d2d2d2;
    -moz-box-shadow: 0 5px 5px 1px #d2d2d2;
    box-shadow: 0 5px 5px 1px #d2d2d2;
    cursor: auto;
  }

  .previewDetail_list {
    margin-top: 1.875rem;
  }

  .previewDetail_list > div {
    float: left;
    border: 1px solid #fff;
    margin-right: 1.25rem;
    padding: 5px 10px;
  }

  .previewDetail_list > div:hover{
    border: 1px solid #d2d2d2;
  }
  .previewDetail_list > div > span {
    display: inline-block;
    max-width: 120px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-left: .875rem;
  }

  .previewDetail .el-dialog__footer {
    -webkit-box-shadow: 0 -10px 20px -5px #d2d2d2;
    -moz-box-shadow: 0 -10px 20px -5px #d2d2d2;
    box-shadow: 0 -10px 20px -5px #d2d2d2;
    margin-top: 1rem;
    padding: 1rem 0;
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
</style>
