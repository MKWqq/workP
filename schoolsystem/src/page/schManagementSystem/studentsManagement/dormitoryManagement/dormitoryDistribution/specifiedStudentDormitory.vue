<template>
  <div class="specifiedStudentDormitory">
    <el-row type="flex" align="middle">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <h3>指定学生到宿舍</h3>
    </el-row>
    <el-row class="specifiedStudentDormitory_row">
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
              <h5>宿舍</h5>
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
                 @click="chooseTeacher(index)"><span>{{data.name}}（</span><span class="act">2</span><span>/8）</span>
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
              <h5>候选名单</h5>
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
      returnFlowchart(){
        this.$router.go(-1);
      },
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
  .specifiedStudentDormitory .treeList {
    border: 1px solid #d2d2d2;
    border-radius: 5px;
    height: 52.25rem;
  }

  .specifiedStudentDormitory .treeList_body {
    padding: .875rem;
  }

  .specifiedStudentDormitory .content_body {
    padding: 2rem .875rem;
  }

  .specifiedStudentDormitory .treeList_title {
    padding: .875rem;
  }

  .specifiedStudentDormitory h5 {
    font-size: 1rem;
  }

  .specifiedStudentDormitory .treeList .treeInput {
    margin: .875rem 0 0;
  }

  .specifiedStudentDormitory .treeList .el-tree {
    border: none;
  }

  .specifiedStudentDormitory .el-input-group--prepend .el-input__inner {
    border-radius: 20px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }

  .specifiedStudentDormitory .el-input-group__prepend {
    border-radius: 20px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }

  .specifiedStudentDormitory .treeList .el-tree {
    border: none;
  }

  .specifiedStudentDormitory .warmTips {
    font-size: .875rem;
    color: #999999;
    margin-left: 1rem;
  }

  .specifiedStudentDormitory .el-tag {
    background-color: #f08bc5;
    margin: 5px 0 5px 10px;
  }

  .specifiedStudentDormitory .mainContent_title h5 {
    display: inline-block;
    padding: 1rem;
  }

  .specifiedStudentDormitory .l_gap {
    margin-left: 2rem;
  }

  .specifiedStudentDormitory .typeDormitory, .specifiedStudentDormitory .dormitory {
    width: 8.75rem;
  }

  .specifiedStudentDormitory .level {
    width: 6.25rem;
  }

  .specifiedStudentDormitory .specifiedStudentDormitory_row {
    margin:2rem 0;
  }

  .specifiedStudentDormitory .dTeacher {
    padding: .7rem 0;
    text-align: center;
    font-weight: bold;
    border-radius: 20px;
    cursor: pointer;
  }
.specifiedStudentDormitory .dTeacher .act{
  color: #4da1ff;
}

  .specifiedStudentDormitory .dTeacher.active {
     background-color: #4da1ff;
     color: #fff;
   }
  .specifiedStudentDormitory .dTeacher.active .act {
    color: #fff;
  }

  .specifiedStudentDormitory .content_body_center {
    height: 44rem;
  }

  .specifiedStudentDormitory .saveBtn {
    text-align: right;
    padding: 1rem;
  }

  .specifiedStudentDormitory .saveBtn .el-button {
    padding: 10px 40px;
    border-radius: 20px;
  }

  .specifiedStudentDormitory .saveBtn .el-button--danger {
    background-color: #ff8686;
    border-color: #ff8686;
  }
</style>
