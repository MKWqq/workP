<template>
  <div class="scoreCountSet">
    <el-row type="flex" align="middle" class="subClassDivision_title">
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <h3>成绩统计设置</h3>
    </el-row>
    <el-row :gutter="20" class="subClassDivision_row">
      <el-col :span="7">
        <el-row class="treeList_class">
          <el-tree
            :data="treeData"
            node-key="id"
            ref="tree"
            :props="defaultProps">
          </el-tree>
        </el-row>
        <el-row class="treeList_test">
          <el-tree
            :data="treeData"
            show-checkbox
            node-key="id"
            ref="tree"
            @check-change="chooseStudent"
            :props="defaultProps">
          </el-tree>
        </el-row>
      </el-col>
      <el-col :span="17">
        <el-row>
          <span>文科-1班</span>
          <el-radio-group v-model="synchronization" class="synchronization">
            <el-radio :label="1">同步到本科类全部专业</el-radio>
            <el-radio :label="2">同步到全部科类及其他专业</el-radio>
          </el-radio-group>
        </el-row>
        <el-row class="subClassDivision_row dataLists">
          <el-table
            :data="tableData"
            style="width: 100%"
          >
            <el-table-column
              width="300"
              label="考试">
              <template scope="scope">
                <p>八年级二班成绩</p>
                <el-row>
                  <el-input class="percentInput" v-model="scope.row.publisher"></el-input>
                  <span>%</span>
                </el-row>
              </template>
            </el-table-column>
            <el-table-column
              label="统计科目">
              <template scope="scope">
                <div v-for="data in scope.row.cList" :key="" class="subject">
                  <span>{{data.name}}</span>
                  <el-input class="percentInput" v-model="data.percent"></el-input>
                  <span>%</span>
                </div>
              </template>
            </el-table-column>
          </el-table>
        </el-row>
        <el-row class="subClassDivision_row operationBtn">
          <el-button type="primary" @click="save">保存</el-button>
        </el-row>
        <!--<el-row class="pageAlerts" v-if="tableData.length!=0">
          <el-pagination
            @current-change="handleCurrentChange"
            :current-page.sync="currentPage"
            :page-size="pageALl"
            layout="prev, pager, next, jumper"
            :total="1000">
          </el-pagination>
        </el-row>-->
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
          cList:[{
              name:'语文',
            percent:10
          },{
            name:'语文',
            percent:10
          },{
            name:'语文',
            percent:10
          },{
            name:'语文',
            percent:10
          },{
            name:'语文',
            percent:10
          },{
            name:'语文',
            percent:10
          }]
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
        synchronization:1
      }
    },
    methods: {
      returnFlowchart(){
        this.$router.push('/subClassDivisionHome');
      },
      exportFile(){
//            req.downloadFile('.messageManagement', '/school/user/exportTeacherOrZg?type=teacher', 'post');
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
  .scoreCountSet .treeList_class,.scoreCountSet .treeList_test{
    padding:.875rem;
    border: 1px solid #d2d2d2;
    border-radius: 5px;
    -webkit-box-shadow: 0 0 1px 1px #d2d2d2 inset;
    -moz-box-shadow: 0 0 1px 1px #d2d2d2 inset;
    box-shadow: 0 0 1px 1px #d2d2d2 inset;
  }
  .scoreCountSet .treeList_class{
    height:18.75rem;
  }
  .scoreCountSet .treeList_class .el-tree{
    height:17rem;
    overflow: auto;
  }
  .scoreCountSet .treeList_test{
    height:32.5rem;
    margin-top:1.25rem;
  }
  .scoreCountSet .treeList_test .el-tree{
    height:30.75rem;
    overflow: auto;
  }
  .scoreCountSet .treeList_class .el-tree,.scoreCountSet .treeList_test .el-tree{
    border:none;
  }
  .scoreCountSet .el-table th{
    background-color: #89bcf5;
    height:3.5rem;
  }
  .scoreCountSet .el-table td{
    font-size: .875rem;
  }
  .scoreCountSet .el-table__footer-wrapper thead div, .scoreCountSet .el-table__header-wrapper thead div{
    background-color: #89bcf5;
    color: #fff;
  }
  .scoreCountSet .synchronization{
    margin-left:2rem;
  }
  .scoreCountSet .dataLists{
    min-height: 35rem;
  }
  .scoreCountSet .percentInput.el-input,.scoreCountSet .percentInput .el-input__inner{
    width:6.25rem;
  }
  .scoreCountSet .subject{
    float: left;
    background-color: #f08bc5;
    color: #fff;
    padding:8px;
    border-radius: 5px;
    margin:.5rem .5rem 0 0;
  }
  .scoreCountSet .subject .percentInput.el-input,.scoreCountSet .subject .percentInput .el-input__inner{
    width:3.2rem;
    height:1.5rem;
  }
 .scoreCountSet .el-table .cell,.scoreCountSet .el-table th>div{
   padding:.5rem .5rem 1rem .5rem;
  }
</style>
