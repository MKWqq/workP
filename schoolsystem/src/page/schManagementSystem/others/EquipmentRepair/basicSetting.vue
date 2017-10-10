<template>
  <div class="g-container">
    <header>
      <div class="g-textHeader g-liOneRow">
        <h2>基础设置</h2>
      </div>
      <div class="g-selection">
        <div class="g-switch">
          <span>是否允许非登录状态扫码报修:</span>
          <el-switch v-model="switchValue" on-text="是" off-text="否" on-color="" off-color=""></el-switch>
        </div>
      </div>
    </header>
    <section class="g-section">
      <div class="gs-header g-liOneRow">
        <div class="gs-button alertsBtn">
          <el-button-group>
            <el-button @click="addClick" data-msg="add" class="filt" title="添加">
              <img class="filt_unactive" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add.png" />
              <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add_highlight.png" />
            </el-button>
            <el-button @click="" data-msg="delete" class="filt" title="删除">
              <img class="filt_unactive" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_delete.png" />
              <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_delete_highlight.png" />
            </el-button>
          </el-button-group>
          <el-button-group class="elGroupButton_two">
            <el-button @click="" data-msg="copy" class="filt" title="复制">
              <img class="filt_unactive" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png" />
              <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png" />
            </el-button>
            <el-button @click="" data-msg="print" class="filt" title="打印">
              <img class="filt_unactive" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png" />
              <img class="filt_active" src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png" />
            </el-button>
          </el-button-group>
        </div>
        <div class="g-fuzzyInput selfCenter">
          <el-input type="text" v-model="fuzzyInput" icon="search" :on-icon-click="fuzzyClick"></el-input>
        </div>
      </div>
      <div class="centerTable alertsList">
        <el-table class="g-NotHover" ref="studentMsgTable" :data="headerButtonData.studentBasicMsg" style="width:100%" @sort-change="sortChange" @selection-change="handleStudentTable">
          <!--show-overflow-tooltip 超出部分省略号显示-->
          <el-table-column type="selection" width="55"></el-table-column>
          <el-table-column label="序号" type="index" width="110"></el-table-column>
          <el-table-column label="报修类别" sortable></el-table-column>
          <el-table-column label="维修人员"></el-table-column>
          <el-table-column label="操作" width="100" fixed="right">
            <template scope="props">
              <el-button type="text" @click="changeMsg(props.$index)">编辑</el-button>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </section>
    <el-dialog class="headerNotBackground" title="新增保修类别" :modal="false" :visible.sync="isDialog" size="tiny" :before-close="handlerClose">
      <el-form :model="gradeDialogForm" label-width="75px" label-position="right">
        <el-form-item label="报修类别:">
          <el-input v-model="gradeDialogForm.type" placeholder="请输入报修类别"></el-input>
        </el-form-item>
      </el-form>
      <div class="g-button">
        <el-button type="primary">确定</el-button>
        <el-button @click="isDialog=false">取消</el-button>
      </div>
    </el-dialog>
    <el-dialog class="headerNotBackground" title="分配人员" :modal="false" :visible.sync="isChangeDialog" :before-close="handlerClose">
      <div class="dialogHeader">
        <el-button class="defineHeight" type="primary">保存</el-button>
      </div>
      <section class="g-liOneRow">
        <div class="centerTable">
          <div class="g-defineInput">
            <span>报修类别:</span>
            <el-input v-model="repairName"></el-input>
          </div>
          <el-table class="g-NotHover" :data="repairPersonTable">
            <el-table-column label="序号" type="index" width="100"></el-table-column>
            <el-table-column label="维修人员"></el-table-column>
            <el-table-column label="操作">
              <template scope="props">
                <el-button type="text" class="deleteColor">删除</el-button>
              </template>
            </el-table-column>
          </el-table>
        </div>
        <div class="alertsList centerTable">
          <div class="g-fuzzyInput selfCenter">
            <el-input type="text" v-model="fuzzyDialogInput" icon="search" :on-icon-click="fuzzyDialogClick"></el-input>
          </div>
          <el-table :data="repairTeacherTable">
            <el-table-column label="序号" type="index" width="100"></el-table-column>
            <el-table-column label="维修人员"></el-table-column>
            <el-table-column label="教职工类别"></el-table-column>
          </el-table>
        </div>
      </section>
    </el-dialog>
  </div>
</template>
<script>
  import {} from '@/api/http'
  export default{
    data(){
      return{
        /*ajax data*/
        headerButtonData:{
          gradeloadData:[],
          classesLoadData:[],
          msgTypeLoadData:[],
          studentBasicMsg:[{name:1}],
        },
        /*switch值*/
        switchValue:'',
        /*form表单双向绑定数据*/
        dataHeader:{
          gradeId:'',
        },
        /*table*/
        isFilter: false,
        tableData: [
          {
            serialNum:'1',
            classes:'1',
            seatNum:'1',//座位号
            name: 'hhh',
            sex: '女',
            sexNum: 0,
            tel: '123565566',
            section:'文科'//科类
          }
        ],
        sortList: {   //排序按钮
          serialNum:{
            filterText:''
          },
          classes:{
            filterText:''
          },
          seatNum:{
            filterText:''
          },
          name: {
            filterText: ''
          },
          sex: {
            filterText: ''
          },
          tel: {
            filterText: ''
          },
          section:{
            filterText:''
          }
        },
        /*fuzzyFilter*/
        fuzzyInput:'',
        /*footer*/
        pageALl:1,
        currentPage:1,
        /*弹框*/
        isDialog:false,
        gradeDialogForm:{
          type:''
        },
        /*编辑*/
        repairName:'',
        repairPersonTable:[1],
        repairTeacherTable:[1],
        fuzzyDialogInput:'',
        /*分配人员*/
        isChangeDialog:false,
      }
    },
    computed: {},
    methods:{
      /*footer*/
      handleCurrentChange(val) {
        this.currentPage = val;
        console.log(`当前页: ${this.currentPage}`);
      },
      /*弹框*/
      handlerClose(done){
        done();
      },
      /*table*/
      handleStudentTable(section){
        /*section为选择项行信息组成的数组*/
        console.log(section);
      },
      sortChange(column){
        /*table排序回调*/
        console.log(column)
      },
      /*编辑*/
      changeMsg(index){
        this.isChangeDialog=true;
      },
      fuzzyDialogClick(){
        /*点击search按钮*/
        console.log('弹框模糊查询');
      },
      /*添加报修类别*/
      addClick(){
        this.isDialog=true;
      },
      /*模糊查询*/
      fuzzyClick(){
        /*点击search按钮*/
        console.log('模糊查询');
      },
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/style';
  .dialogHeader{position:absolute;right:20px;top:0.625rem;
    button{.border-radius(1rem);}
  }
  .headerNotBackground{
    .centerTable{.widthRem(438);
      &>div{.marginBottom(20);}
      .g-defineInput .el-input{.widthRem(260);}
      .g-defineInput span{margin-right:20/16rem;}
    }
    .centerTable:not(:first-of-type){padding-left:30/16rem;}
  }
</style>





