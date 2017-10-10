<template>
  <div>
    <el-row>
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <span class="breadcrumb"><span class="breadcrumb_active">各班确认情况</span><span>|</span><router-link
        :to="{name:'referenceConfirm',params:{examinationid:selectParam.examinationid}}" tag="span">学生确认参考</router-link></span>
    </el-row>
    <el-row class="d_line"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
      <el-col :span="18">
        <el-button-group>
          <el-button class="filt" title="复制">
            <img class="filt_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png"
                 alt="">
            <img class="filt_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png"
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
            placeholder="请输入"
            icon="search"
            v-model="selectParam.screen"
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
          prop="branch"
          label="科类" sortable>
        </el-table-column>
        <el-table-column
          prop="className"
          label="班级" sortable>
        </el-table-column>
        <el-table-column
          prop="all"
          label="班级人数" sortable>
        </el-table-column>
        <el-table-column
          prop="participate"
          label="参考人数" sortable>
        </el-table-column>
        <el-table-column
          prop="unparticipate"
          label="不参考人数" sortable>
        </el-table-column>
        <el-table-column
          prop="reported"
          label="上报人数" sortable>
        </el-table-column>
        <el-table-column
          prop="unreported"
          label="不上报人数" sortable>
        </el-table-column>
        <el-table-column
          prop="teacher"
          label="班主任">
        </el-table-column>
      </el-table>
    </el-row>
    <el-row class="pageAlerts" v-if="tableData">
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
  import req from '@/assets/js/common'
  export default{
    data(){
      return {
        tableData: [],
        selectParam: {
          page: 1,
          limit: 10,
          field: '',
          examinationid: '',
          screen: '',
          order: ''
        },
        totalNum: 0
      }
    },
    created: function () {
      this.selectParam.examinationid = this.$route.params.examinationid;
      this.loadData(this.selectParam);
    },
    methods: {
      returnFlowchart(){
        this.$router.push('/examManagerHome');
      },
      goSearch() {  //查询
        this.selectParam.page = 1;
        this.selectParam.field = '';
        this.selectParam.order = '';
        this.loadData(this.selectParam);
      },
      sort(column){
        this.selectParam.field = column.prop || '';
        this.selectParam.order = column.order || '';
        this.loadData(this.selectParam);
      },
      handleCurrentChange(val) {
        this.selectParam.page = val;
        this.loadData(this.selectParam);
      },
      loadData(param){
        var self = this;
        req.ajaxSend('/school/Examination/exmanagement/type/confirm/typename/attendselect', 'post', param, function (res) {
          self.tableData = res.data;
          self.totalNum = Number.parseInt(res.page.count);
        })
      }
    }
  }
</script>
<style>
</style>
