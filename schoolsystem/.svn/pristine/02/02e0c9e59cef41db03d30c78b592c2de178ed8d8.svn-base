<template>
  <div class="studentGrowthRecord">
    <h3>学生成长记录</h3>
    <el-row :gutter="20" class="studentGrowthRecord_row">
      <el-col :span="4">
        <el-row class="treeList">
          <el-row class="treeList_title">
            <el-row>
              <h5>选择学生：</h5>
            </el-row>
            <el-row class="treeInput">
              <el-input
                placeholder="输入关键字进行过滤"
                v-model="filterText">
                <template slot="prepend">
                  <i class="el-icon-search"></i>
                </template>
              </el-input>
            </el-row>
          </el-row>
          <el-row class="d_line"></el-row>
          <el-row class="treeList_body">
            <el-tree
              :data="treeData"
              node-key="id"
              ref="tree"
              :filter-node-method="filterNode"
              :props="defaultProps"
              @node-click="choosePerson">
            </el-tree>
          </el-row>
        </el-row>
      </el-col>
      <el-col :span="20">
        <el-row class="treeList">
          <el-row type="flex" align="middle" class="secHeader">
            <h5 class="isActive" v-if="!treeActiveData.label">请选择学生</h5>
            <h5 v-if="treeActiveData.label">{{treeActiveData.label}}的成长记录</h5>
          </el-row>
          <el-row class="studentGrowthRecord_content">
            <el-row class="studentGrowthRecord_mainContent">
              <el-row class="arrowContent">
                <img
                  src="../../../../assets/img/schManagementSystem/studentsManagement/studentGrowthRecord/icon_arrow.png"
                  alt="" class="arrowTop">
              </el-row>
              <el-row>
                <el-row class="lineDevice" v-for="(a,index) in tableData" :key="a.title">
                  <el-col :span="5">
                    <el-row class="studentGrowthRecord_content_row studentGrowthRecord_content_l">
                      <p>2017-08-20 16:45:25</p>
                      <p>***老师</p>
                      <span class="circle"></span>
                    </el-row>
                  </el-col>
                  <el-col :span="19">
                    <el-row type="flex" align="middle">
                      <el-col :span="22" class="gap">
                        <el-row class="studentGrowthRecord_content_row studentGrowthRecord_content_center">
                          <el-row type="flex" align="middle">
                            <el-col :span="10">
                              <h5>啦啦啦啦</h5>
                            </el-col>
                            <el-col :span="14">
                              <el-tag
                                v-for="tag in a.tags"
                                :key="tag.name"
                                :closable="true"
                                @close="closeRecordTag(tag)"
                              >
                                {{tag.name}}
                              </el-tag>
                            </el-col>
                          </el-row>
                          <el-row class="detail">
                            <p>
                              这风铃跟心动很接近，这封信还在怀念旅行，路过的爱情都太年轻，你是我想要再回去的风景，这别离被瓶装成秘密，这雏菊美的
                              像诗句，而我在风中等你的消息，等月光落雪地，等枫红染秋季等相遇，我重温午后的阳光，将吉他斜背在肩上，跟多年前一样，
                              我们轻轻的唱去任何地方。
                            </p>
                          </el-row>
                        </el-row>
                      </el-col>
                      <el-col :span="2">
                        <el-row type="flex" justify="center" class="operation">
                          <span class="edit" @click="operationRecord('edit',index)"><i class="el-icon-edit"></i></span>
                        </el-row>
                        <el-row type="flex" justify="center" class="operation">
                          <span class="delete" @click="operationRecord('delete',index)"><i class="el-icon-close"></i></span>
                        </el-row>
                      </el-col>
                    </el-row>
                  </el-col>
                </el-row>
              </el-row>
            </el-row>
          </el-row>
        </el-row>
      </el-col>
    </el-row>
    <el-dialog
      title="编辑成长记录"
      :modal="false"
      :visible.sync="dialogVisible"
      :before-close="handleClose">
      <el-row class="writeCommentForm">
        <el-form ref="form" :model="form" label-width="60px">
          <el-form-item label="标题：">
            <el-row>
              <el-input placeholder="请输入标题" v-model="form.name"></el-input>
            </el-row>
            <el-row>
              <el-row v-show="!tagState.editTagState">
                <el-checkbox-group v-model="form.checkList">
                  <el-checkbox v-for="tag in tagList" :label="tag.name" :vlaue="tag.id" :key="tag.id"></el-checkbox>
                </el-checkbox-group>
              </el-row>
              <el-row class="editTag" v-show="tagState.editTagState">
                <el-tag
                  v-for="tag in tagList"
                  :key="tag.name"
                  :closable="true"
                  @close="removeTag(tag)"
                >
                  {{tag.name}}
                </el-tag>
              </el-row>
            </el-row>
            <el-row class="writeCommentForm_btn" v-show="!tagState.editTagState&&!tagState.addTagState">
              <el-button type="primary" @click="operationTag('add',true)">添加</el-button>
              <el-button class="writeCommentForm_edit" @click="operationTag('edit',true)">编辑</el-button>
            </el-row>
            <el-row class="writeCommentForm_btn writeCommentForm_btn_edit" v-show="tagState.editTagState">
              <el-button type="primary" @click="operationTag('edit',false)">退出编辑</el-button>
            </el-row>
            <el-row class="writeCommentForm_btn writeCommentForm_btn_add" v-show="tagState.addTagState">
              <el-input v-model="addTagValue"></el-input>
              <el-button type="primary" @click="operationTag('add',false,true)">确定</el-button>
              <el-button class="writeCommentForm_edit" @click="operationTag('add',false)">取消</el-button>
            </el-row>
          </el-form-item>
          <el-form-item label="评语：">
            <el-input type="textarea" resize="none" placeholder="请填写评语内容" v-model="form.desc"></el-input>
          </el-form-item>
          <el-form-item label="附件：">
            <div class="uploadFile">
              <el-button>选择附件</el-button>
              <input type="file" accept=".jpg,.png" class="file_input" @change="sendFile">
            </div>
          </el-form-item>
        </el-form>
      </el-row>
      <span slot="footer" class="dialog-footer">
    <el-button type="primary" @click="saveComment">提交</el-button>
  </span>
    </el-dialog>
  </div>
</template>
<script>
  export default{
    data(){
      return {
        treeData: [{
          id: 1,
          label: '一级 1',
          children: [{
            id: 4,
            label: '二级 1-1',
            children: [{
              id: 9,
              label: '三级 1-1-1'
            }, {
              id: 10,
              label: '三级 1-1-2'
            }]
          }]
        }, {
          id: 2,
          label: '一级 2',
          children: [{
            id: 5,
            label: '二级 2-1'
          }, {
            id: 6,
            label: '二级 2-2'
          }]
        }, {
          id: 3,
          label: '一级 3',
          children: [{
            id: 7,
            label: '二级 3-1'
          }, {
            id: 8,
            label: '二级 3-2'
          }]
        }],
        treeActiveData: {},
        defaultProps: {
          children: 'children',
          label: 'label'
        },
        filterText: '',
        tableData: [{
          id: 1,
          title: '今天天气不错啊',
          type: '通知',
          publisher: '超级管理员',
          publishPart: 'hjshf',
          date: '2016-05-03 16:16:55',
          vState: '已查阅',
          checked: false,
          tags: [
            {name: '标签一'},
            {name: '标签二'}
          ]
        }],
        dialogVisible:false,
        form: {
          name: '',
          desc: '',
          checkList: []
        },
        tagState:{
          editTagState:false,
          addTagState:false
        },
        addTagValue:'',
        tagList:[  //标题标签
          { name: '标签一',id:'1'},
          { name: '标签二',id:'2'},
          { name: '标签三',id:'3'},
          { name: '标签四',id:'4'},
          { name: '标签五',id:'5'},
          { name: '标签六',id:'6'}
        ],
        fileList: []
      }
    },
    watch: {
      filterText(val) {
        this.$refs.tree.filter(val);
      }
    },
    methods: {
      filterNode(value, data) {
        if (!value) return true;
        return data.label.indexOf(value) !== -1;
      },
      choosePerson(data){
        console.log(data);
        if (!data.children) {
          this.treeActiveData = data;
        }
      },
      closeRecordTag(tag) {   //关闭记录中的标签
        this.tags.splice(this.tags.indexOf(tag), 1);
      },
      operationRecord(type,idx){
          if (type=='edit'){  //编辑
            this.dialogVisible = true;
          }else{   //删除
            console.log(this.tableData[idx]);
          }
      },
      handleClose(done) {   //关闭弹框
        done();
      },
      operationTag(name,state,isave){
        if(name=='edit'){  //编辑
          this.tagState.editTagState=state;
        }else{   //添加
          if(isave){  //保存添加
            console.log(this.addTagValue);
          }else{   //取消添加
            this.tagState.addTagState=state;
          }
        }
      },
      removeTag(tag) {   //关闭弹框中的标签
        this.tagList.splice(this.tagList.indexOf(tag), 1);
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
        var suffix;
        // 遍历图片文件列表，插入到表单数据中
        for (var i = 0, file; file = $('.file_input').prop('files')[i]; i++) {
          suffix = file.name.split('.')[1];
          switch (suffix) {
            case 'png':
            case 'jpg':
              break;
            default:
              this.$message({
                message: '只能上传png、jpg格式图片！',
                showClose: true
              });
              return false;
          }
          this.fileList.push({'name': file.name, 'file': file});
        }
      },
      saveComment(){
        var self = this, sendFormData = new FormData();
        for (let i of self.fileList) {
          sendFormData.append('accessory[]', i.file);
        }
        self.dialogVisible = false;
      }
    }
  }
</script>
<style>
  .studentGrowthRecord {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .studentGrowthRecord h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
  }

  .studentGrowthRecord .studentGrowthRecord_row {
    margin-top: 3rem;
  }

  .studentGrowthRecord .treeList {
    border: 1px solid #d2d2d2;
    border-radius: 5px;
    height: 52.25rem;
  }

  .studentGrowthRecord .treeList .isActive {
    color: #ff5b5b;
  }

  .studentGrowthRecord .treeList_body {
    padding: .875rem;
  }

  .studentGrowthRecord .treeList_title {
    padding: .875rem .875rem 1.5rem;
  }

  .studentGrowthRecord h5 {
    font-size: 1rem;
  }

  .studentGrowthRecord .treeList .treeInput {
    margin: .875rem 0 0;
  }

  .studentGrowthRecord .treeList .el-tree {
    border: none;
  }

  .studentGrowthRecord .el-input-group--prepend .el-input__inner {
    border-radius: 20px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }

  .studentGrowthRecord .el-input-group__prepend {
    border-radius: 20px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }

  .studentGrowthRecord .secHeader {
    height: 3.125rem;
    padding: 0 1rem;
    border-bottom: 1px solid #d2d2d2;
  }

  .studentGrowthRecord .studentGrowthRecord_content {
    height: 46.125rem;
    overflow: auto;
    margin-top: 3rem;
  }

  .studentGrowthRecord .lineDevice {
    margin: 3rem 0;
  }

  .studentGrowthRecord .studentGrowthRecord_mainContent {
    position: relative;
    min-height:46.125rem;
  }

  .studentGrowthRecord .studentGrowthRecord_mainContent .gap {
    margin-left: 3rem;
  }

  .studentGrowthRecord .studentGrowthRecord_mainContent .arrowContent {
    position: absolute;
    left: 20.8333%;
    height: 97%;
    width: .2rem;
    background-color: #dcdcdc;
    bottom: 0;
  }

  .studentGrowthRecord .studentGrowthRecord_mainContent .arrowTop {
    width: 1.75rem;
    position: absolute;
    top: -1.2rem;
    left: -.775rem;
  }

  .studentGrowthRecord .studentGrowthRecord_content_l {
    padding: 1rem;
  }

  .studentGrowthRecord .studentGrowthRecord_content_l .circle {
    position: absolute;
    width: 1.2rem;
    height: 1.2rem;
    border-radius: 100%;
    background: rgba(77, 161, 255, .5);
    top: 1rem;
    right: -.75rem;
  }

  .studentGrowthRecord .studentGrowthRecord_content_l .circle:before {
    display: block;
    content: '';
    width: .7rem;
    height: .7rem;
    background-color: #4da1ff;
    border-radius: 100%;
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    -o-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
  }

  .studentGrowthRecord .studentGrowthRecord_content_row {
    position: relative;
  }

  .studentGrowthRecord .studentGrowthRecord_content_center {
    border: 1px solid #d2d2d2;
    padding: .5rem 1rem;
    border-radius: 5px;
    background-color: #fff;
  }

  .studentGrowthRecord .studentGrowthRecord_content_center .el-tag {
    margin: .2rem .625rem .2rem 0;
  }

  .studentGrowthRecord .studentGrowthRecord_content_center:before {
    display: block;
    content: '';
    position: absolute;
    width: .8rem;
    height: .8rem;
    background-color: #fff;
    border-left: 1px solid #d2d2d2;
    border-top: 1px solid #d2d2d2;
    -webkit-transform: rotate(-45deg);
    -moz-transform: rotate(-45deg);
    -ms-transform: rotate(-45deg);
    -o-transform: rotate(-45deg);
    transform: rotate(-45deg);
    left: -.5rem;
    top: 1rem;
  }

  .studentGrowthRecord .studentGrowthRecord_content_center .detail {
    margin: 1.5rem 0;
    line-height: 2;
  }

  .studentGrowthRecord .edit, .studentGrowthRecord .delete {
    display: block;
    width: 2rem;
    height: 2rem;
    border-radius: 100%;
    border: 2px solid;
    text-align: center;
    line-height: 2rem;
    cursor: pointer;
  }

  .studentGrowthRecord .edit {
    border-color: #53a0f6;
    color: #53a0f6;
  }

  .studentGrowthRecord .delete {
    border-color: #ff6767;
    color: #ff6767;
  }

  .studentGrowthRecord .operation + .operation {
    margin-top: 2rem;
  }
  .studentGrowthRecord .writeCommentForm .el-textarea__inner,.studentGrowthRecord .templateForm .el-textarea__inner{
    height: 14.375rem;
    font-family: inherit;
  }

  .studentGrowthRecord .writeCommentForm .el-button {
    padding: 8px 15px;
  }
  .studentGrowthRecord .el-tag{
    background-color: #f08bc5;
    margin-right:.6rem;
  }
  .studentGrowthRecord .writeCommentForm .el-checkbox+.el-checkbox{
    margin-left:0;
  }
  .studentGrowthRecord .writeCommentForm .el-checkbox{
    margin-right:1rem;
  }
  .studentGrowthRecord .writeCommentForm_btn .el-button {
    padding: 5px 15px;
  }
  .studentGrowthRecord .writeCommentForm_btn_edit{
    text-align: right;
  }
  .studentGrowthRecord .writeCommentForm_btn_add .el-input{
    width:50%;
  }
  .studentGrowthRecord .writeCommentForm .writeCommentForm_edit {
    background-color: #13b5b1;
    color: #fff;
    border-color: #13b5b1;
  }
  .studentGrowthRecord .el-dialog--small{
    width:550px;
  }
  .studentGrowthRecord .uploadFile {
    display: inline-block;
    position: relative;
    margin-right: 10px;
  }
  .studentGrowthRecord .uploadFile .file_input {
    width: 100%;
    height: 30px;
    border-radius: 1.125rem;
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
</style>
