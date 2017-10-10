<template>
  <div class="specifiedStudentClass g-container">
    <header class="g-textHeader g-importCourseHeader">
      <div class="g-flexStartRow">
        <el-button class="g-gobackChart g-imgContainer RedButton" @click="goBackChart">
          <img src="../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
          返回流程图
        </el-button>
        <h2 class="selfCenter">学生补录</h2>
      </div>
    </header>
    <el-row :gutter="20" class="subClassDivision_row">
      <el-col :span="5">
        <el-row class="treeList">
          <el-row class="treeList_title">
            <el-row>
              <h5>待选班级</h5>
            </el-row>
          </el-row>
          <el-row class="d_line"></el-row>
          <el-row class="treeList_body">
            <el-tree
              :data="treeData"
              node-key="id"
              ref="tree"
              check-strictly
              @node-click="chooseStudent"
              :props="defaultProps">
            </el-tree>
          </el-row>
        </el-row>
      </el-col>
      <el-col :span="5">
        <el-row class="treeList">
          <el-row class="treeList_title">
            <el-row>
              <h5>美术二班 <span class="classNum">（<span>0</span>/80人）</span></h5>
            </el-row>
          </el-row>
          <el-row class="d_line"></el-row>
          <el-row class="nameLists">
            <el-row v-for="(tab,idx) in tableData" :key="tab.id" class="nameList">
              {{tab.title}}
              <i class="el-icon-close" @click="deleteData(idx)"></i>
            </el-row>
          </el-row>
          <el-row type="flex" justify="center">
            <el-col :span="22" class="search">
              <el-input placeholder="请输入添加学生名字" v-model="studentName">
              </el-input>
              <span class="searchBtn" @click="goSearchStudent">
                  <i class="el-icon-plus"></i>
                </span>
            </el-col>
          </el-row>
          <el-row class="btns">
            <el-button @click="save('clear')">清空</el-button>
            <el-button type="primary" @click="save">保存</el-button>
          </el-row>
        </el-row>
      </el-col>
      <el-col :span="14">
        <el-row class="studentsList">
          <div class="g-tableH centerTable alertsList">
            <header class="g-liOneRow">
              <h2>参与分班学生名单</h2>
              <div class="gs-refresh selfCenter g-fuzzyInput">
                <el-input type="text" v-model="fuzzyInput" icon="search" :on-icon-click="fuzzyClick"></el-input>
              </div>
            </header>
            <el-table
              :data="tableData"
              style="width: 100%"
              border
              @sort-change="sort"
            >
              <el-table-column
                type="index"
                width="80"
                label="序号">
              </el-table-column>
              <el-table-column
                prop="type"
                label="姓名" sortable>
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="性别" sortable>
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="当前班级" sortable>
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="拟分班级" sortable>
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="专业" sortable>
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="指定班级" sortable>
              </el-table-column>
              <el-table-column
                prop="publisher"
                label="分班志愿" sortable>
              </el-table-column>
            </el-table>
          </div>
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
        currentPage: 1,
        pageALl: 100,
        treeData: [{
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
          label: 'label',
          disabled:'disabled'
        },
        studentName:'',
        /*模糊查询*/
        fuzzyInput:'',
      }
    },
    methods: {
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'newStudentClass'});
      },
      /*模糊查询*/
      fuzzyClick(){
        /*点击search按钮*/
        console.log('模糊查询');
      },
      goSearchStudent(){//查询
        console.log(this.studentName);
      },
      sort(column){
        console.log(column);
      },
      handleCurrentChange(val) {
        this.currentPage = val;
        console.log(`当前页: ${this.currentPage}`);
      },
      deleteData(idx){
        this.tableData.splice(idx,1);
      },
      /*展开班级*/
      chooseStudent(value){
        console.log(value);
      },
      save(type){
        if(type=='clear'){  //清空

        }else{   //保存

        }
      }
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../style/style';
  .g-textHeader{
    h2{.marginLeft(40,1582);}
  }
  .g-tableH{width:100%;}
  .specifiedStudentClass .treeList{
    border: 1px solid #d2d2d2;
    border-radius: 5px;
    height:52.25rem;
  }
  .specifiedStudentClass .treeList_body{
    padding:.875rem;
  }
  .specifiedStudentClass .treeList_title{
    padding:.875rem;
  }
  .specifiedStudentClass h5{
    font-size:1rem;
  }
  .specifiedStudentClass h5 .classNum{
    float: right;
    font-size:14px;
    font-weight:normal;
  }
  .specifiedStudentClass .classNum>span{
    color: #4da1ff;
  }
  .specifiedStudentClass .treeList .el-tree{
    border:none;
  }
  .specifiedStudentClass .alertsBtn{
    margin:0 0 1.25rem 0;
  }
  .specifiedStudentClass .nameList{
    padding:.625rem 1rem;
    font-size:.875rem;
    position: relative;
  }
  .specifiedStudentClass .nameList:hover{
    background-color: #deeefe;
  }
  .specifiedStudentClass .nameLists{
    height:40rem;
    overflow: auto;
  }
  .specifiedStudentClass .nameList i{
    font-size:12px;
    color: #ff5b5a;
    position: absolute;
    right:1rem;
    top:.625rem;
    cursor: pointer;
  }
  .specifiedStudentClass .nameList:hover>i{
    display: inline-block;
  }
  .specifiedStudentClass .btns{
    text-align: center;
    margin-top:1.25rem;
  }
  .specifiedStudentClass .btns .el-button{
    border-radius: 20px;
    width:6.25rem;
    padding:10px 0;
  }
  .specifiedStudentClass .search{
    position: relative;
  }
  .specifiedStudentClass .search .el-input__inner{
    border-radius: 18px;
    padding:3px 40px 3px 10px;
    border:1px solid #4da1ff;
  }
  .specifiedStudentClass .searchBtn{
    display: block;
    width:36px;
    height:36px;
    position: absolute;
    text-align: center;
    line-height:36px;
    font-size:14px;
    right:0;
    top:0;
    background-color: #4da1ff;
    color: #fff;
    border-radius: 100%;
    cursor: pointer;
  }
  .specifiedStudentClass .listHeader{
    height:3.375rem;
    background-color: #89bcf5;
    color: #fff;
    font-size:.875rem;
  }
  .specifiedStudentClass .studentsList .el-table th{
    background-color: #deeefe;
    height:3rem;
  }
  .specifiedStudentClass .studentsList .el-table td{
    height:3rem;
    font-size: .875rem;
  }
  .specifiedStudentClass .studentsList .el-table__footer-wrapper thead div, .specifiedStudentClass .studentsList .el-table__header-wrapper thead div{
    background-color: #deeefe;
  }
</style>
