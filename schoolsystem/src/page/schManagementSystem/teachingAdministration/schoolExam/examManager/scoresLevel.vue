<template>
  <div class="scoresLevel">
    <el-row>
      <el-button type="primary" class="return_btn" @click="returnFlowchart"><img
        src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png"
        alt=""><span class="returnTxt">返回流程图</span></el-button>
      <span class="breadcrumb"><router-link to="/examManagerHome/testScribing"
                                            tag="span">考试划线</router-link><span>|</span><router-link
        to="/examManagerHome/percentageSet" tag="span">分数率设置</router-link><span>|</span><span class="breadcrumb_active">分数等级设置</router-link></span></span>
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
          label="优秀" sortable>
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
      <el-button type="primary" class="c_color" @click="editMsg(1)">快速设置</el-button>
      <el-button type="primary" @click="saveMsg(2)">保存</el-button>
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
      title="编辑信息"
      :visible.sync="dialogVisible"
      :before-close="handleClose"
      :modal="false">
      <el-row class="levelLists">
        <el-table
          :data="levelLists"
          border
          style="width: 100%">
          <el-table-column
            prop="levelName"
            width="240"
            label="等级名称">
          </el-table-column>
          <el-table-column
            label="分数占比">
            <template scope="scope">
              <el-row type="flex" align="middle">
                <el-col :span="3" class="level">>=</el-col>
                <el-col :span="18" class="level"><el-input v-model="scope.row.percent" /></el-col>
                <el-col :span="3" class="level">%</el-col>
              </el-row>
            </template>
          </el-table-column>
        </el-table>
        <el-row type="flex" align="middle" class="levelStart">
          <span>是否启用等级：</span>
          <el-switch
            v-model="levelStart"
            on-color="#09baa7"
            off-color="#ff4949"
            on-text="是"
            on-off="否">
          </el-switch>
        </el-row>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg(0)">保存</el-button>
        <el-button @click="dialogVisible = false">取消</el-button>
      </span>
    </el-dialog>
    <el-dialog
      title="名称设置"
      :visible.sync="percentageDialogVisible"
      :before-close="handleClose"
      :modal="false">
      <el-row class="levelLists">
        <el-table
          :data="levelLists"
          border
          style="width: 100%">
          <el-table-column
            width="240"
            label="等级名称">
            <template scope="scope">
              <el-input v-model="scope.row.levelName" />
            </template>
          </el-table-column>
          <el-table-column
            label="分数占比">
            <template scope="scope">
              <el-row type="flex" align="middle">
                <el-col :span="3" class="level">>=</el-col>
                <el-col :span="18" class="level"><el-input v-model="scope.row.percent" /></el-col>
                <el-col :span="3" class="level">%</el-col>
              </el-row>
            </template>
          </el-table-column>
        </el-table>
        <el-row class="tips">
          <el-col :span="3">温馨提示：</el-col>
          <el-col :span="21">
            <p>1、为确保等级显示正常，请按降序设置各等级分数段；</p>
            <p>2、留空即表示不设置该等级</p>
          </el-col>
        </el-row>
      </el-row>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveMsg(1)">保存</el-button>
        <el-button @click="percentageDialogVisible = false">关闭</el-button>
      </span>
    </el-dialog>
  </div>
</template>
<script>
  import ElCol from "element-ui/packages/col/src/col";
  export default{
    components: {ElCol},
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
          line6: 8,
          state:true
        }, {
          id: 2,
          type: '理科',
          subject: '物理',
          line1: 20,
          line2: 5,
          line3: 6,
          line4: 0,
          line5: 7,
          line6: 8,
          state:true
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
        levelLists:[{
                levelName:'1',
              percent:''
            },{
            levelName:'2',
            percent:''
          },{
            levelName:'3',
            percent:''
          },{
            levelName:'',
            percent:''
          },{
            levelName:'',
            percent:''
          },{
          levelName:'',
          percent:''
        },{
          levelName:'',
          percent:''
        }],
        levelStart:true
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
  .scoresLevel .edit {
    color: #20a0ff;
    cursor: pointer;
  }
  .scoresLevel .level{
    text-align: center;
  }
  .scoresLevel .tips{
    color: #888888;
    margin-top:20px;
  }
  .scoresLevel .tips p{
    margin-bottom:14px;
  }
  .levelLists .el-table--enable-row-hover .el-table__body tr:hover>td{
    background-color:#fff;
  }
  .scoresLevel .el-input__inner{
    height:25px;
    text-align: center;
  }
  .scoresLevel .levelStart{
    margin-top:20px;
  }
  .scoresLevel .el-dialog__body .el-table th{
    background-color: #deeefe;
  }
  .scoresLevel .el-dialog__body .el-table__footer-wrapper thead div, .scoresLevel .el-dialog__body .el-table__header-wrapper thead div{
    background-color: #deeefe;
  }
</style>
