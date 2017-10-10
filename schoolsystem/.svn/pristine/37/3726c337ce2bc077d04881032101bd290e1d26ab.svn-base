<template>
  <div class="suspendedSchool">
    <el-row class="suspendedSchool_row">
      <el-form :inline="true" :model="selectParam" class="suspendedSchoolSelectForm">
        <el-form-item label="年级：">
          <el-select v-model="selectParam.grade" placeholder="请选择年级" class="grade">
            <el-option label="区域一" value="shanghai"></el-option>
            <el-option label="区域二" value="beijing"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="班级：">
          <el-select v-model="selectParam.class" placeholder="请选择班级" class="sClass">
            <el-option label="区域一" value="shanghai"></el-option>
            <el-option label="区域二" value="beijing"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" icon="search" @click="onSearch">查询</el-button>
        </el-form-item>
      </el-form>
    </el-row>
    <el-row class="d_line abnormalMotionOperation_row"></el-row>
    <el-row type="flex" justify="end" class="alertsBtn">
      <div class="g-fuzzyInput">
        <el-input
          placeholder="请选择日期"
          icon="search"
          v-model="selectParam.searchValue"
          :on-icon-click="goSearch">
        </el-input>
      </div>
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        style="width: 100%"
        @sort-change="sort"
      >
        <el-table-column
          prop="type"
          label="年级" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="班级" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="姓名" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="性别" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="学籍号" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="身份证件类型" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="身份证号" sortable>
        </el-table-column>
        <el-table-column
          prop="publisher"
          label="户籍所在地" sortable>
        </el-table-column>
        <el-table-column
          label="操作">
          <template scope="scope">
            <span class="edit" @click="suspendedSchool(scope.$index)">休学</span>
          </template>
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
    <el-dialog
      title="休学"
      :visible.sync="dialogVisible"
      :modal="false"
      :before-close="handleClose">
      <el-row type="flex" justify="center">
        <el-col :span="18">
          <el-row type="flex" justify="center">
            <el-col :span="8" class="headMsg">姓名：很舒服</el-col>
            <el-col :span="8" class="headMsg">年级：七年级</el-col>
            <el-col :span="8" class="headMsg">班级：1班</el-col>
          </el-row>
          <el-row class="headRow">
            <el-form ref="form" :model="form" label-width="100px">
              <el-form-item label="休学日期：">
                <el-date-picker type="date" placeholder="选择日期" v-model="form.date1"
                                style="width: 100%;"></el-date-picker>
              </el-form-item>
              <el-form-item label="复学日期：">
                <el-date-picker type="date" placeholder="选择日期" v-model="form.date2"
                                style="width: 100%;"></el-date-picker>
              </el-form-item>
              <el-form-item label="申请理由：">
                <el-input resize="none" type="textarea" placeholder="请输入申请休学理由" v-model="form.desc"></el-input>
              </el-form-item>
            </el-form>
          </el-row>
        </el-col>
      </el-row>
      <span slot="footer" class="dialog-footer">
    <el-button type="primary" @click="save">提交</el-button>
    <el-button @click="dialogVisible = false">取消</el-button>
  </span>
    </el-dialog>
  </div>
</template>
<script>
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
        selectParam: {
          grade: '',
          class: '',
          searchValue: ''
        },
        dialogVisible: false,
        form: {
          name: '',
          region: '',
          date1: '',
          date2: '',
          delivery: false,
          type: [],
          resource: '',
          desc: ''
        }
      }
    },
    methods: {
      onSearch() {
        console.log('submit!');
      },
      goSearch(ev) {  //查询
        console.log(ev);
      },
      sort(column){
        console.log(column);
      },
      handleCurrentChange(val) {
        this.currentPage = val;
        console.log(`当前页: ${this.currentPage}`);
      },
      suspendedSchool(idx){
        this.dialogVisible = true;
      },
      handleClose(done) {
        done();
      },
      save(){

      }
    }
  }
</script>
<style>
  .suspendedSchool .suspendedSchool_row {
    margin-top: 2rem;
  }

  .suspendedSchool .suspendedSchoolSelectForm .el-form-item {
    margin-bottom: 0;
    margin-right: 2.5rem;
  }

  .suspendedSchool .suspendedSchoolSelectForm .el-button {
    border-radius: 20px;
    padding: 8px 25px;
  }

  .suspendedSchool .suspendedSchoolSelectForm .grade {
    width: 8.75rem;
  }

  .suspendedSchool .suspendedSchoolSelectForm .sClass {
    width: 9.375rem;
  }

  .suspendedSchool .headMsg {
    text-align: center;
  }

  .suspendedSchool .headRow {
    margin-top: 32px;
  }
</style>
