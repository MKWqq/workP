<template>
  <div class="writeComment">
    <h3>写评语</h3>
    <el-row :gutter="20" class="writeComment_row">
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
      <el-col :span="10">
        <el-row class="treeList">
          <el-row type="flex" align="middle" class="secHeader">
            <h5 :class="{'isActive':!treeActiveData.label}">{{treeActiveData.label||'请选择学生'}}</h5>
          </el-row>
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
                <!--<el-upload
                  class="upload-demo"
                  action=""
                  :on-preview="handlePreview"
                  :on-remove="handleRemove"
                  :file-list="fileList">
                  <el-button size="small" type="primary">点击上传</el-button>
                  <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
                </el-upload>-->
                <div class="uploadFile">
                  <el-button>选择附件</el-button>
                  <input type="file" accept=".jpg,.png" class="file_input" @change="sendFile">
                </div>
              </el-form-item>
            </el-form>
          </el-row>
          <el-row class="saveComment">
            <el-button type="primary" @click="saveComment">提交</el-button>
          </el-row>
        </el-row>
      </el-col>
      <el-col :span="10">
        <el-row class="treeList">
          <el-row type="flex" align="middle" class="secHeader">
            <el-col :span="16">
              <h5><span>评论模板</span> <span class="doubleC">（双击引用）</span></h5>
            </el-col>
            <el-col :span="8">
              <el-button @click="openDialog">添加模板</el-button>
            </el-col>
          </el-row>
          <el-row class="templateLabelList">
            <el-row>
              <span class="templateLabel" :class="{'active':label.checked}" v-for="(label,index) in labelList"
                    :key="label.id" @click="searchBabel(index)">{{label.name}}</span>
            </el-row>
            <el-row class="templateLabel_search">
              <el-input
                placeholder="请输入关键字"
                icon="search"
                v-model="searchVal"
                :on-icon-click="handleIconClick">
              </el-input>
            </el-row>
          </el-row>
          <el-row class="alertsList">
            <el-table
              :data="tableData"
              style="width: 100%"
            >
              <el-table-column
                type="index"
                label="序号"
                width="80">
              </el-table-column>
              <el-table-column
                prop="title"
                label="内容">
              </el-table-column>
              <el-table-column
                prop="type"
                label="引用数">
              </el-table-column>
              <el-table-column
                label="操作">
                <template scope="scope">
                  <div @click="operationTemplate(scope.$index)">
                    <span class="operation" v-if="!scope.row.checked">置顶</span>
                    <span class="operation active" v-if="scope.row.checked">取消置顶</span>
                  </div>
                </template>
              </el-table-column>
            </el-table>
          </el-row>
        </el-row>
      </el-col>
    </el-row>
    <el-dialog
      title="添加模板"
      :modal="false"
      :visible.sync="dialogVisible"
      :before-close="handleClose">
      <el-row type="flex" justify="center" class="templateForm">
        <el-col :span="18">
          <el-form ref="templateForm" :rules="templateFormRules" :model="templateForm" label-width="70px">
            <el-form-item prop="type" label="类型：">
              <el-select v-model="templateForm.type" placeholder="请选择" style="width: 100%">
                <el-option label="区域一" value="shanghai"></el-option>
                <el-option label="区域二" value="beijing"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item prop="content" label="评语：">
              <el-input type="textarea" resize="none" placeholder="请填写评语内容" v-model="templateForm.content"></el-input>
            </el-form-item>
            <el-form-item>
              <span class="tip">评语首尾请勿添加标点符号</span>
            </el-form-item>
          </el-form>
        </el-col>
      </el-row>
      <span slot="footer" class="dialog-footer">
    <el-button type="primary" @click="saveTemplate">提交</el-button>
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
        form: {
          name: '',
          desc: '',
          checkList: []
        },
        tagState: {
          editTagState: false,
          addTagState: false
        },
        addTagValue: '',
        tagList: [  //标题标签
          {name: '标签一', id: '1'},
          {name: '标签二', id: '2'},
          {name: '标签三', id: '3'},
          {name: '标签四', id: '4'},
          {name: '标签五', id: '5'},
          {name: '标签六', id: '6'}
        ],
        fileList: [],
        labelList: [{   //评语模板标签
          name: '开头',
          checked: false,
          id: 1
        }],
        searchVal: '',
        tableData: [{
          id: 1,
          title: '今天天气不错啊',
          type: '通知',
          publisher: '超级管理员',
          publishPart: 'hjshf',
          date: '2016-05-03 16:16:55',
          vState: '已查阅',
          checked: false
        }],
        dialogVisible: false,
        templateForm: {
          type: '',
          content: ''
        },
        templateFormRules: {
          type: [
            {required: true, message: '请输选择类型', trigger: 'change'}
          ],
          content: [
            {required: true, message: '请填写评语', trigger: 'blur'}
          ]
        }
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
      operationTag(name, state, isave){
        if (name == 'edit') {  //编辑
          this.tagState.editTagState = state;
        } else {   //添加
          if (isave) {  //保存添加
            console.log(this.addTagValue);
          } else {   //取消添加
            this.tagState.addTagState = state;
          }
        }
      },
      removeTag(tag) {
        this.tagList.splice(this.tagList.indexOf(tag), 1);
      },
      handleRemove(file, fileList) {
        console.log(file, fileList);
      },
      handlePreview(file) {
        console.log(file);
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
      },
      openDialog(){
        this.dialogVisible = true;
        for (let name in this.templateForm) {
          this.templateForm[name] = '';
        }
      },
      handleClose(done) {
        done();
      },
      handleIconClick(){  //输入框查询

      },
      searchBabel(idx){   //点击标签查询
        for (let obj of this.labelList) {
          obj.checked = false;
        }
        this.labelList[idx].checked = true;
      },
      operationTemplate(idx){
        this.tableData[idx].checked = true;
      },
      saveTemplate(){
        this.$refs['templateForm'].validate((valid) => {
          if (valid) {
            this.dialogVisible = false;
          } else {
            return false;
          }
        });
      }
    }
  }
</script>
<style>
  .writeComment {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
    font-size: 14px;
  }

  .writeComment h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
  }

  .writeComment .writeComment_row {
    margin-top: 3rem;
  }

  .writeComment .treeList {
    border: 1px solid #d2d2d2;
    border-radius: 5px;
    height: 52.25rem;
  }

  .writeComment .treeList .isActive {
    color: #ff5b5b;
  }

  .writeComment .treeList_body {
    padding: .875rem;
  }

  .writeComment .treeList_title {
    padding: .875rem .875rem 1.5rem;
  }

  .writeComment .treeList_title h5, .writeComment .secHeader h5 {
    font-size: 1rem;
  }

  .writeComment .treeList .treeInput {
    margin: .875rem 0 0;
  }

  .writeComment .treeList .el-tree {
    border: none;
  }

  .writeComment .el-input-group--prepend .el-input__inner {
    border-radius: 20px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }

  .writeComment .el-input-group__prepend {
    border-radius: 20px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }

  .writeComment .secHeader {
    height: 3.125rem;
    padding: 0 1rem;
    border-bottom: 1px solid #d2d2d2;
  }

  .writeComment .secHeader .el-button {
    padding: .5rem 1rem;
    font-size: .875rem;
    float: right;
  }

  .writeComment .secHeader .doubleC, .writeComment .tip {
    color: #999999;
  }

  .writeComment .writeCommentForm {
    padding: 2rem 1rem;
    height: 44rem;
    overflow: auto;
  }

  .writeComment .writeCommentForm .el-textarea__inner, .writeComment .templateForm .el-textarea__inner {
    height: 14.375rem;
    font-family: inherit;
  }

  .writeComment .writeCommentForm .el-button {
    padding: 8px 15px;
  }

  .writeComment .writeCommentForm .el-tag {
    background-color: #f08bc5;
    margin-right: .6rem;
  }

  .writeComment .writeCommentForm .el-checkbox + .el-checkbox {
    margin-left: 0;
  }

  .writeComment .writeCommentForm .el-checkbox {
    margin-right: 1rem;
  }

  .writeComment .writeCommentForm_btn .el-button {
    padding: 5px 15px;
  }

  .writeComment .writeCommentForm_btn_edit {
    text-align: right;
  }

  .writeComment .writeCommentForm_btn_add .el-input {
    width: 50%;
  }

  .writeComment .writeCommentForm .writeCommentForm_edit {
    background-color: #13b5b1;
    color: #fff;
    border-color: #13b5b1;
  }

  .writeComment .saveComment {
    text-align: center;
    padding: 1rem;
  }

  .writeComment .saveComment .el-button {
    width: 100%;
  }

  .writeComment .uploadFile {
    display: inline-block;
    position: relative;
    margin-right: 10px;
  }

  .writeComment .uploadFile .file_input {
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

  .writeComment .templateLabelList {
    padding: 0 1rem;
  }

  .writeComment .templateLabel {
    display: inline-block;
    padding: .2rem 1rem;
    border: 1px solid #d2d2d2;
    border-radius: 4px;
    font-size: .875rem;
    margin-right: .625rem;
    margin-top: 1rem;
    cursor: pointer;
  }

  .writeComment .templateLabel.active {
    background-color: #4da1ff;
    color: #fff;
  }

  .writeComment .templateLabel_search {
    margin: 1rem 0;
  }

  .writeComment .templateLabel_search .el-input__inner {
    border-radius: 20px;
  }

  .writeComment .alertsList .operation {
    color: #4da1ff;
    cursor: pointer;
  }

  .writeComment .alertsList .operation.active {
    color: #ff5b5b;
    cursor: pointer;
  }

  .writeComment .el-table th, .writeComment .el-table td {
    text-align: center;
  }

  .writeComment .el-dialog--small {
    width: 550px;
  }
</style>
