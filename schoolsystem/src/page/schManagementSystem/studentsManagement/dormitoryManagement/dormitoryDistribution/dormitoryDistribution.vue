<template>
  <div class="dormitoryDistribution">
    <el-row type="flex" align="middle">
      <el-col :span="12">
        <h3>宿舍分配</h3>
      </el-col>
      <el-col :span="12" class="createDistribution">
        <el-button type="primary" @click="operation('create')">创建分配方案</el-button>
      </el-col>
    </el-row>
    <el-row class="d_line dormitoryDistribution_row"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
      <el-col :span="18">
        <el-button-group>
          <el-button class="filt" title="导出" @click="operationData('out')">
            <img class="filt_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
                 alt="">
            <img class="filt_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
                 alt="">
          </el-button>
          <el-button class="delete" title="打印">
            <img class="delete_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png"
                 alt="">
            <img class="delete_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png"
                 alt="">
          </el-button>
        </el-button-group>
      </el-col>
      <el-col :span="6">
        <div class="g-fuzzyInput">
          <el-input
            placeholder="请输入名字/科目"
            icon="search"
            v-model="selectParam.value"
            :on-icon-click="goSearch">
          </el-input>
        </div>
      </el-col>
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        style="width: 100%"
        @sort-change="sort"
      >
        <el-table-column
          type="index"
          label="序号"
          width="100">
        </el-table-column>
        <el-table-column
          prop="name"
          label="方案名称"
          sortable>
        </el-table-column>
        <el-table-column
          prop="sex"
          label="创建时间"
          sortable>
        </el-table-column>
        <el-table-column
          prop="teachingSubjects"
          label="分配宿舍"
          sortable>
        </el-table-column>
        <el-table-column
          prop="politics"
          label="人数"
          sortable>
        </el-table-column>
        <el-table-column
          prop="phone"
          label="方案状态"
          sortable>
        </el-table-column>
        <el-table-column
          width="350"
          label="操作">
          <template scope="scope">
            <span class="operation edit" @click="operation('process',scope.$index)">宿舍分配</span>
            <span class="operation edit" @click="operation('edit',scope.$index)">编辑</span>
            <span class="operation delete">删除</span>
            <span class="operation delete">清空人员</span>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
    <el-row class="pageAlerts" v-if="tableData.length!=0">
      <el-pagination
        @current-change="handleCurrentChange"
        :current-page.sync="selectParam.page"
        layout="prev, pager, next, jumper"
        :total="totalNum">
      </el-pagination>
    </el-row>
  </div>
</template>
<script>
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
        selectParam: {
          page: 1,
          pageSize: 10,
          sort: '',
          sortType: '',
          value: ''
        },
        totalNum: 0
      }
    },
    methods: {
      sort(column){

      },
      goSearch() {  //查询
        this.selectParam.page = 1;
        this.selectParam.sort = '';
        this.selectParam.sortType = '';
        this.loadDataList(this.selectParam);
      },
      handleCurrentChange(val){
        this.selectParam.page = val;
      },
      operationData(type){  //操作整体数据，导入导出

      },
      operation(type, idx){   //操作单挑数据
        if (type == 'create') {
          this.$router.push({name: 'createDistribution'});
        } else if (type == 'edit') {
          this.$router.push({name: 'editDistribution', params: {id: idx}});
        } else if (type == 'process') {
          this.$router.push({name: 'distributionProcess', params: {id: idx}});
        }
      }
    }
  }
</script>
<style>
  .dormitoryDistribution .dormitoryDistribution_row {
    margin-top: 2rem;
  }

  .dormitoryDistribution .createDistribution .el-button {
    border-radius: 20px;
    float: right;
  }

  .dormitoryDistribution .operation {
    padding: 0 16px;
    cursor: pointer;
  }

  .dormitoryDistribution .operation + .operation {
    border-left: 2px solid #d2d2d2;
  }

  .dormitoryDistribution .operation.edit {
    color: #4da1ff;
  }

  .dormitoryDistribution .operation.delete {
    color: #ff5b5a;
  }
</style>
