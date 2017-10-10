<template>
  <div class="percentageSet">
    <el-row>
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <span class="breadcrumb"><router-link to="/examManagerHome/testScribing"
                                            tag="span">考试划线</router-link><span>|</span><span class="breadcrumb_active">分数率设置</span><span>|</span><router-link tag="span" to="/examManagerHome/scoresLevel">分数等级设置</router-link></span>
    </el-row>
    <el-row class="d_line"></el-row>
    <el-row type="flex" align="middle" class="alertsBtn">
      <el-button class="delete" title="导出">
        <img class="delete_unactive"
             src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
             alt="">
        <img class="delete_active"
             src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
             alt="">
      </el-button>
    </el-row>
    <el-row class="alertsList">
      <el-table
        :data="tableData"
        style="width: 100%"
        @sort-change="sort"
      >
        <el-table-column
          prop="type"
          label="科类" sortable>
        </el-table-column>
        <el-table-column
          prop="subject"
          label="科目" sortable>
        </el-table-column>
        <el-table-column
          prop="line1"
          label="满分" sortable>
        </el-table-column>
        <el-table-column
          prop="line2"
          label="优秀（>=）">
        </el-table-column>
        <el-table-column
          prop="line3"
          label="及格（>=）" sortable>
        </el-table-column>
        <el-table-column
          prop="line4"
          label="低分（>=）" sortable>
        </el-table-column>
        <el-table-column
          label="操作">
          <template scope="scope">
            <span class="edit" @click="editMsg(0,scope.$index)">编辑</span>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
    <el-row class="testOperation_btn">
      <el-button>清空数据</el-button>
      <el-button type="primary" class="c_color" @click="editMsg(1)">快速设置</el-button>
    </el-row>
    <!--<el-row class="pageAlerts">
      <el-pagination
        @current-change="handleCurrentChange"
        :current-page.sync="currentPage"
        :page-size="pageALl"
        layout="prev, pager, next, jumper"
        :total="1000">
      </el-pagination>
    </el-row>-->
    <el-dialog
      title="修改信息"
      :visible.sync="dialogVisible"
      :before-close="handleClose"
      :modal="false">
      <el-row class="formMsg">
        <el-form ref="form" :model="form" label-width="120px">
          <el-form-item label="科类：">
            <span>{{form.type}}</span>
          </el-form-item>
          <el-form-item label="科目：">
            <span>{{form.subject}}</span>
          </el-form-item>
          <el-form-item label="满分：">
            <el-input v-model="form.line1"></el-input>
          </el-form-item>
          <el-form-item label="优秀（>=）：">
            <el-input v-model="form.line2"></el-input>
          </el-form-item>
          <el-form-item label="及格（>=）：">
            <el-input v-model="form.line3"></el-input>
          </el-form-item>
          <el-form-item label="低分（>=）：">
            <el-input v-model="form.line4"></el-input>
          </el-form-item>
        </el-form>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg(0)">保存</el-button>
        <el-button @click="dialogVisible = false">取消</el-button>
      </span>
    </el-dialog>
    <el-dialog
      title="快速设置"
      :visible.sync="percentageDialogVisible"
      :before-close="handleClose"
      :modal="false">
      <el-row class="formMsg scribeLine">
        <el-form ref="form" :model="percentageParam" label-width="120px">
          <el-form-item label="优秀（>=）：">
            <el-input v-model="percentageParam.line1"></el-input>
            <span class="unit">%</span>
          </el-form-item>
          <el-form-item label="及格（>=）：">
            <el-input v-model="percentageParam.line2"></el-input>
            <span class="unit">%</span>
          </el-form-item>
          <el-form-item label="低分（>=）：">
            <el-input v-model="percentageParam.line3"></el-input>
            <span class="unit">%</span>
          </el-form-item>
        </el-form>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg(1)">保存</el-button>
        <el-button @click="percentageDialogVisible = false">取消</el-button>
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
          type: '文科',
          subject: '语文',
          line1: 20,
          line2: 5,
          line3: 6,
          line4: 0,
          line5: 7,
          line6: 8
        }, {
          id: 2,
          type: '理科',
          subject: '物理',
          line1: 20,
          line2: 5,
          line3: 6,
          line4: 0,
          line5: 7,
          line6: 8
        }],
        searchValue: '',
        currentPage: 1,
        pageALl: 100,
        dialogVisible: false,
        form: {
          id: '',
          type: '',
          subject: '',
          line1: '',
          line2: '',
          line3: '',
          line4: '',
          line5: '',
          line6: ''
        },
        percentageDialogVisible: false,
        percentageParam: {
          scribeSubject: 'arts',
          line1: '',
          line2: '',
          line3: '',
          line4: '',
          line5: '',
          line6: ''
        }
      }
    },
    methods: {
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
      returnFlowchart(){
        this.$router.push('/examManagerHome');
      },
      editMsg(val, idx){
        if (val == 0) {
          this.dialogVisible = true;
          $.extend(this.form, this.tableData[idx]);
        } else {
          this.percentageDialogVisible = true;
        }
      },
      handleClose(done) {   //关闭弹框
        for (let ob in this.form) {
          this.form[ob] = '';
        }
        done();
      },
      saveMsg(val){
        if (val == 0) {
          this.dialogVisible = false;
          console.log(this.form);
        } else {
          this.percentageDialogVisible = false;
          console.log(this.percentageParam);
        }
      }
    }
  }
</script>
<style>
  .percentageSet .formMsg {
    width: 80%;
    margin: auto;
  }

  .percentageSet .unit {
    margin-left: 10px;
  }

  .percentageSet .scribeLine .el-input {
    width: 80%;
  }

  .percentageSet .edit {
    color: #ff5b5a;
    cursor: pointer;
  }
</style>
