<template>
  <div class="testScribing">
    <el-row>
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <span class="breadcrumb"><span class="breadcrumb_active">考试划线</span><span>|</span><router-link
        to="/examManagerHome/percentageSet" tag="span">分数率设置</router-link><span>|</span><router-link tag="span" to="/examManagerHome/scoresLevel">分数等级设置</router-link></span>
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
          label="线1" sortable>
        </el-table-column>
        <el-table-column
          prop="line2"
          label="线2">
        </el-table-column>
        <el-table-column
          prop="line3"
          label="线3" sortable>
        </el-table-column>
        <el-table-column
          prop="line4"
          label="线4" sortable>
        </el-table-column>
        <el-table-column
          prop="line5"
          label="线5" sortable>
        </el-table-column>
        <el-table-column
          prop="line6"
          label="线6" sortable>
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
      <el-button type="primary" class="c_color" @click="editMsg(1)">名称设置</el-button>
      <el-button type="primary" class="c_color" @click="editMsg(2)">快速划线</el-button>
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
        <el-form ref="form" :model="form" label-width="80px">
          <el-form-item label="科类：">
            <span>{{form.type}}</span>
          </el-form-item>
          <el-form-item label="科目：">
            <span>{{form.subject}}</span>
          </el-form-item>
          <el-form-item label="线1：">
            <el-input v-model="form.line1"></el-input>
          </el-form-item>
          <el-form-item label="线2：">
            <el-input v-model="form.line2"></el-input>
          </el-form-item>
          <el-form-item label="线3：">
            <el-input v-model="form.line3"></el-input>
          </el-form-item>
          <el-form-item label="线4：">
            <el-input v-model="form.line4"></el-input>
          </el-form-item>
          <el-form-item label="线5：">
            <el-input v-model="form.line5"></el-input>
          </el-form-item>
          <el-form-item label="线6：">
            <el-input v-model="form.line6"></el-input>
          </el-form-item>
        </el-form>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg(0)">保存</el-button>
        <el-button @click="dialogVisible = false">取消</el-button>
      </span>
    </el-dialog>
    <el-dialog
      title="名称设置"
      :visible.sync="nameDialogVisible"
      :before-close="handleClose"
      :modal="false">
      <el-row class="formMsg">
        <el-form ref="form" :model="tableName" label-width="120px">
          <el-form-item label="分数线1名称：">
            <el-input v-model="tableName.line1"></el-input>
          </el-form-item>
          <el-form-item label="分数线2名称：">
            <el-input v-model="tableName.line2"></el-input>
          </el-form-item>
          <el-form-item label="分数线3名称：">
            <el-input v-model="tableName.line3"></el-input>
          </el-form-item>
          <el-form-item label="分数线4名称：">
            <el-input v-model="tableName.line4"></el-input>
          </el-form-item>
          <el-form-item label="分数线5名称：">
            <el-input v-model="tableName.line5"></el-input>
          </el-form-item>
          <el-form-item label="分数线6名称：">
            <el-input v-model="tableName.line6"></el-input>
          </el-form-item>
        </el-form>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg(1)">保存</el-button>
        <el-button @click="nameDialogVisible = false">取消</el-button>
      </span>
    </el-dialog>
    <el-dialog
      title="快速划线"
      :visible.sync="scribeDialogVisible"
      :before-close="handleClose"
      :modal="false">
      <el-row class="formMsg scribeLine">
        <el-row class="formSubject">
          <span class="sub" :class="{'subject_active':scribeParam.scribeSubject=='arts'}" @click="chooseSubject('arts')">文科</span>
          <span class="gap">|</span>
          <span class="sub" :class="{'subject_active':scribeParam.scribeSubject=='science'}" @click="chooseSubject('science')">理科</span>
        </el-row>
        <el-form ref="form" :model="scribeParam" label-width="120px">
          <el-form-item label="线1：">
            <el-input v-model="scribeParam.line1"></el-input><span class="unit">人</span>
          </el-form-item>
          <el-form-item label="线2：">
            <el-input v-model="scribeParam.line2"></el-input><span class="unit">人</span>
          </el-form-item>
          <el-form-item label="线3：">
            <el-input v-model="scribeParam.line3"></el-input><span class="unit">人</span>
          </el-form-item>
          <el-form-item label="线4：">
            <el-input v-model="scribeParam.line4"></el-input><span class="unit">人</span>
          </el-form-item>
          <el-form-item label="线5：">
            <el-input v-model="scribeParam.line5"></el-input><span class="unit">人</span>
          </el-form-item>
          <el-form-item label="线6：">
            <el-input v-model="scribeParam.line6"></el-input><span class="unit">人</span>
          </el-form-item>
        </el-form>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg(2)">保存</el-button>
        <el-button @click="scribeDialogVisible = false">取消</el-button>
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
        nameDialogVisible: false,
        tableName: {
          line1: '',
          line2: '',
          line3: '',
          line4: '',
          line5: '',
          line6: ''
        },
        scribeDialogVisible: false,
        scribeParam: {
          scribeSubject:'arts',
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
      editMsg(val,idx){
          if(val==0){
            this.dialogVisible = true;
            $.extend(this.form, this.tableData[idx]);
          }else if(val==1){
            this.nameDialogVisible = true;
          }else{
            this.scribeDialogVisible = true;
          }
      },
      handleClose(done) {   //关闭弹框
        for (let ob in this.form) {
          this.form[ob] = '';
        }
        for (let ob in this.tableName) {
          this.tableName[ob] = '';
        }
        done();
      },
      chooseSubject(val){
          this.scribeParam.scribeSubject=val;
      },
      saveMsg(val){
        if (val == 0) {
          this.dialogVisible = false;
          console.log(this.form);
        } else if(val==1){
          this.nameDialogVisible = false;
          console.log(this.tableName);
        } else{
          this.scribeDialogVisible = false;
          console.log(this.scribeParam);
        }
      }
    }
  }
</script>
<style>
  .testScribing .formMsg {
    width: 80%;
    margin: auto;
  }
  .testScribing .formSubject{
    text-align: center;
    margin-bottom:20px;
    font-size:18px;
  }
  .testScribing .formSubject .sub{
    cursor: pointer;
  }
  .testScribing .formSubject .gap{
    margin:0 30px;
  }
  .testScribing .formSubject .subject_active{
    color: #4da1ff;
  }
  .testScribing .scribeLine .el-input{
    width:80%;
  }
  .testScribing .unit{
    margin-left:10px;
  }
  .testScribing .edit{
    color: #ff5b5a;
    cursor: pointer;
  }
</style>
