<template>
  <div class="setLifeTeacher">
    <el-row type="flex" align="middle">
      <el-col :span="12">
        <h3>设置生活老师</h3>
      </el-col>
      <el-col :span="12">
        <el-button type="primary" class="saveBtn" @click="save">保存</el-button>
      </el-col>
    </el-row>
    <el-row :gutter="20" class="setLifeTeacher_row">
      <el-col :span="5">
        <el-row class="treeList">
          <el-row class="treeList_title">
            <el-row>
              <h5>生活教师：</h5>
            </el-row>
            <el-row class="treeInput">
              <el-input
                placeholder="输入查询分类或姓名"
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
              :data="teacherList"
              node-key="id"
              ref="tree"
              :filter-node-method="filterNode"
              @node-click="chooseTeacher"
              :props="defaultProps">
            </el-tree>
          </el-row>
        </el-row>
      </el-col>
      <el-col :span="12">
        <el-row class="alertsBtn">
          <el-button-group>
            <el-button class="filt" title="添加">
              <img class="filt_unactive"
                   src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add.png"
                   alt="">
              <img class="filt_active"
                   src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add_highlight.png"
                   alt="">
            </el-button>
            <el-button class="delete" title="删除" @click="deleteData">
              <img class="delete_unactive"
                   src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete.png"
                   alt="">
              <img class="delete_active"
                   src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete_highlight.png"
                   alt="">
            </el-button>
          </el-button-group>
          <span class="warmTips">操作提示：从左边选择生活老师，从右边选择对应宿舍。</span>
        </el-row>
        <el-row class="alertsList">
          <el-table
            :data="tableData"
            style="width: 100%"
            border
            @selection-change="handleSelectionChange"
          >
            <el-table-column
              type="selection"
              width="55">
            </el-table-column>
            <el-table-column
              label="生活老师">
              <template scope="scope">
                <span>
                   <el-tag
                     :key="tag"
                     v-for="tag in scope.row.dynamicTags"
                     :closable="true"
                     :close-transition="false"
                     @close="handleClose(scope.$index,'dynamicTags',tag)"
                   >
                  {{tag}}
                </el-tag>
                </span>
                <span class="addPersonBtn" :class="{'active':scope.row.tChecked}"
                      @click="setActive(scope.$index,'tChecked')"><i class="el-icon-plus"></i></span>
              </template>
            </el-table-column>
            <el-table-column
              label="宿舍">
              <template scope="scope">
                <span>
                   <el-tag
                     :key="tag"
                     v-for="tag in scope.row.dynamicTags2"
                     :closable="true"
                     :close-transition="false"
                     @close="handleClose(scope.$index,'dynamicTags2',tag)"
                   >
                  {{tag}}
                </el-tag>
                </span>
                <span class="addPersonBtn" :class="{'active':scope.row.dChecked}"
                      @click="setActive(scope.$index,'dChecked')"><i class="el-icon-plus"></i></span>
              </template>
            </el-table-column>
          </el-table>
        </el-row>
        <el-row class="dormitoryDirector">
          <h5>宿舍主任：
            <span>
                   <el-tag
                     :key="tag"
                     v-for="(tag,index) in dynamicTags3"
                     :closable="true"
                     :close-transition="false"
                     @close="handleClose(index,'director',tag)"
                   >
                  {{tag}}
                </el-tag>
                </span>
            <span class="addPersonBtn" :class="{'active':idxData.director}" @click="setActive('director','tChecked')"><i
              class="el-icon-plus"></i></span>
          </h5>
        </el-row>
      </el-col>
      <el-col :span="7">
        <el-row class="treeList">
          <el-row class="treeList_title">
            <el-row>
              <h5>选择宿舍：</h5>
            </el-row>
            <el-row class="treeInput">
              <el-input
                placeholder="输入查询分类或姓名"
                v-model="filterText2">
                <template slot="prepend">
                  <i class="el-icon-search"></i>
                </template>
              </el-input>
            </el-row>
          </el-row>
          <el-row class="d_line"></el-row>
          <el-row class="treeList_body">
            <el-tree
              :data="dormitoryList"
              node-key="id"
              ref="tree2"
              :filter-node-method="filterNode2"
              @node-click="chooseDormitory"
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
          id: 1,
          title: '今天天气不错啊',
          type: '通知',
          publisher: '超级管理员',
          publishPart: 'hjshf',
          date: '2016-05-03 16:16:55',
          vState: '已查阅',
          checked: false,
          tChecked: false,
          dChecked: false,
          dynamicTags: [],
          dynamicTags2: []
        }, {
          id: 2,
          title: '下雨了',
          type: '通知',
          publisher: 'wy',
          publishPart: 'hjshf',
          date: '2016-05-03 16:16:55',
          vState: '未查阅',
          checked: false,
          tChecked: false,
          dChecked: false,
          dynamicTags: ['标签一', '标签二', '标签三'],
          dynamicTags2: ['标签一', '标签二', '标签三']
        }, {
          id: 3,
          title: '那是',
          type: '通知',
          publisher: '超级管理员',
          publishPart: 'hjshf',
          date: '2016-05-03 16:16:55',
          vState: '已查阅',
          checked: false,
          tChecked: false,
          dChecked: false,
          dynamicTags: [],
          dynamicTags2: []
        }],
        dynamicTags3: [],
        teacherList: [{
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
        dormitoryList: [{
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
        filterText2: '',
        multipleSelection: [],
        idxData: {   //用来记录应该加入哪个宿舍和生活老师
          tIdx: '',
          dIdx: '',
          director: false
        }
      }
    },
    watch: {
      filterText(val) {
        this.$refs.tree.filter(val);
      },
      filterText2(val) {
        this.$refs.tree2.filter(val);
      }
    },
    methods: {
      filterNode(value, data) {
        if (!value) return true;
        return data.label.indexOf(value) !== -1;
      },
      filterNode2(value, data) {
        if (!value) return true;
        return data.label.indexOf(value) !== -1;
      },
      handleSelectionChange(val) {
        this.multipleSelection = val;
      },
      chooseDormitory(data){  //选择宿舍
        var idx = this.idxData.dIdx;
        if (!data.children) {
          if (!idx && typeof idx == 'string') {
            this.$message({
              message: '请先点击宿舍加号键！',
              showClose: true
            });
            return false;
          }
          if (this.tableData[idx].dynamicTags2.indexOf(data.label) != -1) {
            this.$message({
              type: 'error',
              message: '已添加过该成员！',
              showClose: true
            });
            return false;
          }
          this.tableData[idx].dynamicTags2.push(data.label);
        }
      },
      chooseTeacher(data){  //选择教师
        var idx = this.idxData.tIdx;
        if (!data.children) {
          if (!this.idxData.director) {   //选择教师
            if (!idx && typeof idx == 'string') {
              this.$message({
                message: '请先点击生活老师加号键！',
                showClose: true
              });
              return false;
            }
            if (this.tableData[idx].dynamicTags.length != 0) {
              this.$message({
                type: 'error',
                message: '每行只允许添加一个老师！',
                showClose: true
              });
              return false;
            }
            this.tableData[idx].dynamicTags.push(data.label);
          } else {   //选择宿舍主任
            if (this.dynamicTags3.length != 0) {
              this.$message({
                type: 'error',
                message: '只允许添加一个宿舍主任！',
                showClose: true
              });
              return false;
            }
            this.dynamicTags3.push(data.label);
          }
        }
      },
      deleteData(){
        var self = this;
        if (self.multipleSelection.length == 0) {
          self.$message({
            message: '请选择记录！',
            showClose: true
          });
          return false;
        }
        self.$confirm('确定删除?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {

        }).catch(() => {
        });
      },
      handleClose(idx, type, tag) {
        if (type != 'director') {
          this.tableData[idx][type].splice(this.tableData[idx][type].indexOf(tag), 1);
        } else {
          this.dynamicTags3.splice(idx, 1);
        }
      },
      setActive(idx, type){
        for (let obj of this.tableData) {
          obj[type] = false;
        }
        if (type == 'tChecked') {
          if (idx != 'director') {
            this.idxData.tIdx = idx;
            this.tableData[idx][type] = true;
            this.idxData.director = false;
          } else {
            this.idxData.tIdx = '';
            this.idxData.director = true;
          }
        } else {
          this.idxData.dIdx = idx;
          this.tableData[idx][type] = true;
        }
      },
      save(){

      }
    }
  }
</script>
<style>
  .setLifeTeacher {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .setLifeTeacher h3 {
    font-size: 1.25rem;
    color: #4e4e4e;
    display: inline-block;
  }

  .setLifeTeacher .saveBtn {
    border-radius: 20px;
    padding: 10px 40px;
    float: right;
  }

  .setLifeTeacher .setLifeTeacher_row {
    margin-top: 2rem;
  }

  .setLifeTeacher .treeList {
    border: 1px solid #d2d2d2;
    border-radius: 5px;
    height: 52.25rem;
    -webkit-box-shadow: 0 0 1px 1px #d2d2d2 inset;
    -moz-box-shadow: 0 0 1px 1px #d2d2d2 inset;
    box-shadow: 0 0 1px 1px #d2d2d2 inset;
  }

  .setLifeTeacher .treeList_body {
    padding: .875rem;
  }

  .setLifeTeacher .treeList_title {
    padding: .875rem;
  }

  .setLifeTeacher h5 {
    font-size: 1rem;
  }

  .setLifeTeacher .treeList .treeInput {
    margin: .875rem 0 0;
  }

  .setLifeTeacher .treeList .el-tree {
    border: none;
  }

  .setLifeTeacher .alertsBtn {
    margin: 0 0 1.25rem 0;
  }

  .setLifeTeacher .el-input-group--prepend .el-input__inner {
    border-radius: 20px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }

  .setLifeTeacher .el-input-group__prepend {
    border-radius: 20px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }

  .setLifeTeacher .treeList .el-tree {
    border: none;
  }

  .setLifeTeacher .warmTips {
    font-size: .875rem;
    color: #999999;
    margin-left: 1rem;
  }

  .setLifeTeacher .el-table th {
    text-align: center;
  }

  .setLifeTeacher .el-table tr > td:first-child {
    text-align: center;
  }

  .setLifeTeacher .alertsList {
    height: 44rem;
    border: 1px solid #d2d2d2;
    border-radius: 0 0 5px 5px;
    overflow: auto;
  }

  .setLifeTeacher .dormitoryDirector {
    border: 1px solid #d2d2d2;
    border-radius: 5px;
    padding: .9rem;
    margin-top: 1rem;
  }

  .setLifeTeacher .addPersonBtn {
    display: inline-block;
    border-radius: 6px;
    border: 1px solid #999999;
    font-size: .875rem;
    padding: .2rem;
    margin-left: 10px;
    cursor: pointer;
    color: #999999;
    line-height: normal;
  }

  .setLifeTeacher .addPersonBtn.active {
    border-color: #f08bc5;
    color: #f08bc5;
  }

  .setLifeTeacher .el-tag {
    background-color: #f08bc5;
    margin: 5px 0 5px 10px;
  }
</style>
