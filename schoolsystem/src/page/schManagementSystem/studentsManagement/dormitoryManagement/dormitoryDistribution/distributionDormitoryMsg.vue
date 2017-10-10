<template>
    <div class="distributionDormitoryMsg">
      <el-row type="flex" align="middle">
        <el-col :span="16">
          <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
            src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
            alt=""><span class="returnTxt">返回流程图</span></el-button>
          <h3>设置分配宿舍信息</h3>
        </el-col>
        <el-col :span="8" class="save">
          <el-button type="primary">保存</el-button>
        </el-col>
      </el-row>
      <el-row :gutter="20" class="distributionPersonnel_head">
        <el-col :span="17">
          <el-row>
            <span>共 <span class="listNumber">0</span> 个宿舍（<span class="listNumber">0</span>个男生宿舍 ，<span class="listNumber">0</span> 个女生宿舍）。</span>
            <span class="d_gap">共可容纳 <span class="listNumber">0</span> 人（男 <span class="listNumber">0</span> ，女<span class="listNumber">0</span>）。</span>
          </el-row>
          <el-row class="d_line distributionPersonnel_row"></el-row>
          <el-row type="flex" align="middle" class="alertsBtn">
            <el-col :span="14">
              <el-button-group>
                <el-button class="filt" title="导出" @click="operationData('export')">
                  <img class="filt_unactive"
                       src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
                       alt="">
                  <img class="filt_active"
                       src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
                       alt="">
                </el-button>
                <el-button class="delete" title="删除" @click="operationData('delete')">
                  <img class="delete_unactive"
                       src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete.png" alt="">
                  <img class="delete_active"
                       src="../../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete_highlight.png"
                       alt="">
                </el-button>
              </el-button-group>
              <el-button class="delete secBtn-group" title="打印">
                <img class="delete_unactive"
                     src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png"
                     alt="">
                <img class="delete_active"
                     src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png"
                     alt="">
              </el-button>
            </el-col>
            <el-col :span="10">
              <div class="g-fuzzyInput">
                <el-input
                  placeholder="请输入姓名，科目"
                  icon="search"
                  v-model="searchValue"
                  :on-icon-click="goSearch">
                </el-input>
              </div>
            </el-col>
          </el-row>
          <el-row class="alertsList">
            <el-table
              :data="tableData"
              style="width: 100%"
              @selection-change="handleSelectionChange"
            >
              <el-table-column
                type="selection"
                width="55">
              </el-table-column>
              <el-table-column
                type="index"
                width="80"
                label="序号">
              </el-table-column>
              <el-table-column
                prop="type"
                label="宿舍楼名称">
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="栋号">
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="楼层">
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="宿舍号">
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="宿舍类型">
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="容纳人数">
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
                :data="treeData"
                show-checkbox
                node-key="id"
                ref="tree"
                :filter-node-method="filterNode"
                @check-change="chooseStudent"
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
                checked: false
              }, {
                id: 2,
                title: '下雨了',
                type: '通知',
                publisher: 'wy',
                publishPart: 'hjshf',
                date: '2016-05-03 16:16:55',
                vState: '未查阅',
                checked: false
              }, {
                id: 3,
                title: '那是',
                type: '通知',
                publisher: '超级管理员',
                publishPart: 'hjshf',
                date: '2016-05-03 16:16:55',
                vState: '已查阅',
                checked: false
              }],
              multipleSelection:[],
              searchValue: '',
              currentPage: 1,
              pageALl: 100,
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
              defaultProps: {
                children: 'children',
                label: 'label'
              },
              filterText: '',
            }
        },
      watch:{
        filterText(val) {
          this.$refs.tree.filter(val);
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
          operationData(type){
              if (type=='delete'){
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
              }
          },
          goSearch(ev) {  //查询
            console.log(ev);
          },
          handleSelectionChange(val) {
            this.multipleSelection = val;
          },
          handleCurrentChange(val) {
            this.currentPage = val;
            console.log(`当前页: ${this.currentPage}`);
          },
          chooseStudent(node,state,child){
            console.log(state);
          },
          save(){
          }
        }
    }
</script>
<style>
  .distributionDormitoryMsg .treeList{
    border: 1px solid #d2d2d2;
    border-radius: 5px;
    height:52.25rem;
    -webkit-box-shadow: 0 0 1px 1px #d2d2d2 inset;
    -moz-box-shadow: 0 0 1px 1px #d2d2d2 inset;
    box-shadow: 0 0 1px 1px #d2d2d2 inset;
  }
  .distributionDormitoryMsg .distributionPersonnel_head{
    margin-top:2rem;
  }
  .distributionDormitoryMsg .d_gap{
    margin-left:2rem;
  }
  .distributionDormitoryMsg .distributionPersonnel_row{
    margin:1.25rem 0;
  }
  .distributionDormitoryMsg .save .el-button{
    padding:10px 2.5rem;
    border-radius: 20px;
    float: right;
  }
  .distributionDormitoryMsg .listNumber{
    color: #4da1ff;
    font-size:.875rem;
  }
  .distributionDormitoryMsg .treeList_body{
    padding:.875rem;
  }
  .distributionDormitoryMsg .treeList_title{
    padding:.875rem .875rem 1.5rem;
  }
  .distributionDormitoryMsg .treeList_title h5{
    font-size:1rem;
  }
  .distributionDormitoryMsg .treeList .treeInput{
    margin:.875rem 0 0;
  }
  .distributionDormitoryMsg .treeList .el-tree{
    border:none;
  }
  .distributionDormitoryMsg .el-input-group--prepend .el-input__inner{
    border-radius: 20px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }
  .distributionDormitoryMsg .el-input-group__prepend{
    border-radius: 20px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }
</style>
