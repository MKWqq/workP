<template>
  <div class="personnelManagement">
    <el-row class="personnelManagement_row">
      <span>宿舍栋号：</span>
      <el-select v-model="selectParam.dormitory" placeholder="请选择" class="dormitory">
        <el-option
          v-for="item in dormitoryList"
          :key="item.value"
          :label="item.label"
          :value="item.value">
        </el-option>
      </el-select>
      <span class="l_gap">楼层：</span>
      <el-select v-model="selectParam.level" placeholder="请选择" class="level">
        <el-option
          v-for="item in levelList"
          :key="item.value"
          :label="item.label"
          :value="item.value">
        </el-option>
      </el-select>
      <span class="l_gap">宿舍类型：</span>
      <el-select v-model="selectParam.type" placeholder="请选择" class="typeDormitory">
        <el-option
          v-for="item in typeList"
          :key="item.value"
          :label="item.label"
          :value="item.value">
        </el-option>
      </el-select>
    </el-row>
    <el-row :gutter="20">
      <el-col :span="5">
        <el-row class="treeList">
          <el-row class="treeList_title">
            <el-row>
              <h5>宿舍（生活老师）</h5>
            </el-row>
            <el-row class="treeInput">
              <el-input
                placeholder="输入关键字查询"
                v-model="filterTeacher">
                <template slot="prepend">
                  <i class="el-icon-search"></i>
                </template>
              </el-input>
            </el-row>
          </el-row>
          <el-row class="d_line"></el-row>
          <el-row class="content_body">
            <div class="dTeacher" :class="{'active':data.state}" v-for="(data,index) in tableDataNew" :key="data.name"
                 @click="chooseTeacher(index)">{{data.name}}
            </div>
          </el-row>
        </el-row>
      </el-col>
      <el-col :span="12">
        <el-row class="treeList">
          <el-row class="mainContent_title">
            <h5>203(测试)</h5>
            <span class="warmTips">操作提示：1、选择左边的宿舍，再点击右边的待选学生进行添加；</span>
          </el-row>
          <el-row class="d_line"></el-row>
          <el-row class="content_body content_body_center">
            <el-tag
              :key="tag"
              v-for="tag in dynamicTags"
              :closable="true"
              :close-transition="false"
              @close="handleClose(tag)"
            >
              {{tag}}
            </el-tag>
          </el-row>
          <el-row class="saveBtn">
            <el-button type="danger" @click="save('clear')">清空</el-button>
            <el-button type="primary" @click="save('save')">保存</el-button>
          </el-row>
        </el-row>
      </el-col>
      <el-col :span="7">
        <el-row class="treeList">
          <el-row class="treeList_title">
            <el-row>
              <h5>待选学生</h5>
            </el-row>
            <el-row class="treeInput">
              <el-input
                placeholder="输入查询班级或姓名"
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
              :data="studentList"
              node-key="id"
              ref="tree"
              :filter-node-method="filterNode"
              @node-click="chooseStudent"
              :props="defaultProps">
            </el-tree>
          </el-row>
        </el-row>
      </el-col>
    </el-row>
  </div>
</template>
<script>
  import req from '@/assets/js/common'
  export default{
    data(){
      return {
        tableData: [{
          name: '123',
          state: false
        }, {
          name: '456',
          state: false
        }, {
          name: '7',
          state: true
        }],
        tableDataNew: [{
          name: '123',
          state: false
        }, {
          name: '456',
          state: false
        }, {
          name: '7',
          state: true
        }],
        dynamicTags: ['标签一', '标签二', '标签三'],
        studentList: [{
          id: 1,
          label: '一级 1',
          disabled: true,
          children: [{
            id: 4,
            label: '二级 1-1'
          }]
        }, {
          id: 2,
          label: '一级 2',
          disabled: true,
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
          disabled: true,
          children: [{
            id: 7,
            label: '二级 3-1'
          }, {
            id: 8,
            label: '二级 3-2'
          }]
        }],
        defaultProps: {
          children: 'children',
          label: 'label'
        },
        filterText: '',
        filterTeacher: '',
        dormitoryList: [],
        levelList: [],
        typeList: [{
          value: 0,
          label: '男生宿舍'
        }, {
          value: 1,
          label: '女生宿舍'
        }, {
          value: 2,
          label: '综合宿舍'
        }, {
          value: 3,
          label: '其他'
        }],
        selectParam: {
          dormitory: '',
          level: '',
          type: ''
        }
      }
    },
    watch: {
      filterText(val) {
        this.$refs.tree.filter(val);
      },
      filterTeacher(val){
        this.tableDataNew = this.tableData.filter(function (obj) {
          obj.state = false;
          return obj.name.indexOf(val) !== -1;
        });
        return this.tableDataNew;
      }
    },
    methods: {
      filterNode(value, data) {
        if (!value) return true;
        return data.label.indexOf(value) !== -1;
      },
      chooseTeacher(idx){
        for (let obj of this.tableDataNew) {
          obj.state = false;
        }
        this.tableDataNew[idx].state = true;
      },
      chooseStudent(data){  //选择宿舍
        if (!data.children) {
          if (this.dynamicTags.indexOf(data.label) != -1) {
            this.$message({
              type: 'error',
              message: '已添加过该成员！',
              showClose: true
            });
            return false;
          }
          this.dynamicTags.push(data.label);
        }
      },
      handleClose(tag) {
        this.dynamicTags.splice(this.dynamicTags.indexOf(tag), 1);
      },
      save(type){
        if (type == 'clear') {  //清空

        } else {   //保存

        }
      }
    }
  }
</script>
<style>
  .personnelManagement .treeList {
    border: 1px solid #d2d2d2;
    border-radius: 5px;
    height: 52.25rem;
  }

  .personnelManagement .treeList_body {
    padding: .875rem;
  }

  .personnelManagement .content_body {
    padding: 2rem .875rem;
  }

  .personnelManagement .treeList_title {
    padding: .875rem;
  }

  .personnelManagement h5 {
    font-size: 1rem;
  }

  .personnelManagement .treeList .treeInput {
    margin: .875rem 0 0;
  }

  .personnelManagement .treeList .el-tree {
    border: none;
  }

  .personnelManagement .el-input-group--prepend .el-input__inner {
    border-radius: 20px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }

  .personnelManagement .el-input-group__prepend {
    border-radius: 20px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }

  .personnelManagement .treeList .el-tree {
    border: none;
  }

  .personnelManagement .warmTips {
    font-size: .875rem;
    color: #999999;
    margin-left: 1rem;
  }

  .personnelManagement .el-tag {
    background-color: #f08bc5;
    margin: 5px 0 5px 10px;
  }

  .personnelManagement .mainContent_title h5 {
    display: inline-block;
    padding: 1rem;
  }

  .personnelManagement .l_gap {
    margin-left: 2rem;
  }

  .personnelManagement .typeDormitory, .personnelManagement .dormitory {
    width: 8.75rem;
  }

  .personnelManagement .level {
    width: 6.25rem;
  }

  .personnelManagement .personnelManagement_row {
    font-size: 14px;
  }

  .personnelManagement .dTeacher {
    padding: .7rem 0;
    text-align: center;
    font-weight: bold;
    border-radius: 20px;
    cursor: pointer;
  }

  .personnelManagement .dTeacher.active {
    background-color: #4da1ff;
    color: #fff;
  }

  .personnelManagement .content_body_center {
    height: 44rem;
  }

  .personnelManagement .saveBtn {
    text-align: right;
    padding: 1rem;
  }

  .personnelManagement .saveBtn .el-button {
    padding: 10px 40px;
    border-radius: 20px;
  }

  .personnelManagement .saveBtn .el-button--danger {
    background-color: #ff8686;
    border-color: #ff8686;
  }
</style>
