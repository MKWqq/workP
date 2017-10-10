<template>
  <div>
    <el-col class="LeaveRecord-title">
      <!--时间段-->
      <el-col :span="24">
        <el-col :span="2">时间段：</el-col>
        <el-col :span="3" style="margin-left: -3rem">
          <el-date-picker
            v-model="startvalue" type="date" :picker-options="pickerOptions0" style="width: 100%">
          </el-date-picker>
        </el-col>
        <el-col :span="1"  style="text-align: center">_</el-col>
        <el-col :span="3">
          <el-date-picker
            v-model="endvalue" type="date" :picker-options="pickerOptions1" style="width: 100%">
          </el-date-picker>
        </el-col>
        <el-col :span="1" :offset="1">
          <el-button type="primary" icon="search" class="LeaveRecord-search" @click="querryData()">查询</el-button>
        </el-col>
      </el-col>
    </el-col>
    <el-col :span="17" class="alertsBtn">
      <el-button class="delete" title="导出">
        <img class="delete_unactive"
             src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
             alt="">
        <img class="delete_active"
             src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
             alt="">
      </el-button>
      <el-button-group style="margin-left: 2.1rem">
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
    <el-col :span="5" :offset="2" class="Infor-input-inner" style="margin-top:1.8rem;">
      <el-input style="border-radius:1rem" placeholder="请输入搜索内容" icon="search" v-model="Searchinput" :on-icon-click="handleIconClick"></el-input>
    </el-col>
    <el-col :span="24">
      <el-row class="alertsList">
        <el-table
          :data="tableData"
          style="width: 100%"
          @sort-change="sort"
          v-loading.body="isLoading"
          element-loading-text="拼命加载中...">
          <el-table-column
            prop="title"
            label="标题"
            align="center">
          </el-table-column>
          <el-table-column
            prop="name"
            label="类型"
            align="center">
          </el-table-column>
          <el-table-column
            prop="startTime"
            label="申请人"
            align="center">
          </el-table-column>
          <el-table-column
            prop="duration"
            label="上一级审批人"
            align="center">
          </el-table-column>
          <el-table-column
            prop="reason"
            label="审批结果"
            align="center">
          </el-table-column>
          <el-table-column
            prop="proposer"
            label="审批意见"
            align="center">
          </el-table-column>
          <el-table-column
            prop="createTime"
            label="创建日期"
            align="center">
          </el-table-column>
          <el-table-column
            label="操作"
            align="center">
            <template  scope="scope">
              <span style="color:#89bcf5;cursor: pointer;"  @click="showDialogTable(scope.row)">点击审批</span>
            </template>
          </el-table-column>
        </el-table>
      </el-row>
      <el-dialog title="用车申请审批详情" :modal="false" :visible.sync="dialogTableVisible">
        <el-col :span="24" style="text-align: center;height:36rem;overflow-y:auto;">
          <div class="LeaveRecord-table">
            <div class="LeaveRecord-dialog-title">#{{dialogData.title}}#</div>
            <el-col :span="24">
              <div class="LeaveRecord-table-div">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">用车类型</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.proposer}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">申请人</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.name}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">用车人数</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.startTime}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">目的地</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.duration}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">用车联系人</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.reason}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">用车联系人电话</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.reason}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">起始时间</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.reason}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">结束时间</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.reason}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">用车时长</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.reason}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div LeaveRecord-table-div-final">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">用车原因</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.createTime}}</div>
                </el-col>
              </div>
            </el-col>
            <el-col :span="24">
              <div class="LeaveRecord-state-btn">我的审批</div>
            </el-col>
            <el-col :span="18" :offset="2" style="margin-top: 1.8rem">
              <el-col :span="24" style="padding-bottom: 1.25rem;">
                <el-col :span="5">
                  <span>审批结果：</span>
                </el-col>
                <el-col :span="12" style="text-align: left;font-size: 0;">
                  <span v-for="(list,index) in textLists"
                        :class="{ active:changecolor == index}" @click="toggleClass(index,list)"
                        class="LeaveRecord-agreed">{{list.text}}</span>
                </el-col>
              </el-col>
              <el-col :span="24" style="padding-bottom: 1.25rem;">
                <el-col :span="5">
                  <span>审批意见：</span>
                </el-col>
                <el-col :span="12" style="text-align: left">
                  <textarea v-model="dialogData.passReasonText" style="resize:none;border-radius: .5rem;width: 100%" rows="6"></textarea>
                </el-col>
              </el-col>
              <el-col :span="12" :offset="5" style="padding-bottom: 1.25rem;">
                <el-select v-model="dialogData.passReason" placeholder="常用审批意见" style="width: 100%">
                  <el-option
                    v-for="item in options"
                    :key="item.value"
                    :value="item.value">
                  </el-option>
                </el-select>
              </el-col>
              <el-col :span="12" :offset="5" style="padding-bottom: 1.25rem;">
                <el-button type="primary" style="  border-radius:2rem;" @click="confirm()" class="LeaveRecord-search">保存</el-button>
              </el-col>
            </el-col>
          </div>
        </el-col>
      </el-dialog>
      <el-row class="pageAlerts">
        <el-pagination
          @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-size="10"
          layout="prev, pager, next, jumper"
          :total="total">
        </el-pagination>
      </el-row>
    </el-col>
  </div>
</template>
<script>
  import req from './../../../../../assets/js/common'
  import formatdata from './../../../../../assets/js/date'
    export default{
      data(){
          return{
            Searchinput: '',
            changecolor:0,

            textLists:[{
              text:'同意'
            },{
              text:'不同意'
            }],
            options: [{
              value: '情况属实，申请通过'
            }, {
              value: '情况存在异议，申请不予通过'
            }, {
              value: '申请内容不符，申请不予通过'
            }],
            isLoading:false,
            dialogTableVisible: false,
            pickerOptions0: {
              disabledDate(time) {
                return time.getTime() > Date.now();
              }
            },
            pickerOptions1: {
              disabledDate(time) {
                return time.getTime() > Date.now();
              }
            },
            startvalue:new Date(),
            endvalue:new Date(),
            tableData: [
              {title:'111'},
              {title:'111'},
              {title:'111'}
            ],
            currentPage: 1,
            pageALl: 10,
            total:0,
            order:'createTime desc',
            dialogData:{},
            type:'',
            opinion:'',
            id:''
          }
      },
      created(){
        this.querryData(1);
      },
      methods:{
        showDialogTable(row){
          row.pass = true;
//        row.passReason = '';
          this.$set(row,'passReason','');
          this.$set(row,'passReasonText','');
          this.dialogData=row;
          this.dialogTableVisible = true;
        },
        toggleClass:function(index,list){
          this.changecolor = index;
        },
        handleIconClick(){

        },
        querryData(page){
          if(page!==this.currentPage){
            this.currentPage=page;
          }
          this.isLoading=true;
//          let startvalue=formatdata.format(this.startvalue,'yyyy-MM-dd');
//          let endvalue=formatdata.format(this.endvalue,'yyyy-MM-dd');
//          let param = {
//            page: this.currentPage,
//            whether: 1,
//            count: 10,
//            startTime:startvalue,
//            endTime: endvalue,
//            id:this.id
//          };
//          req.ajaxSend('/school/TeacherLeave/approve','post',param,(res)=>{
//            if(res.status===-1){
//              this.tableData=[];
//              this.isLoading=false;
//              return;
//            }
//            res.data.forEach((val)=>{
//              val.createTime=new Date((val.createTime)*1000);
//              val.createTime=formatdata.format(val.createTime,'yyyy-MM-dd HH:mm:ss');
//              val.startTime=new Date((val.startTime)*1000);
//              val.startTime=formatdata.format(val.startTime,'yyyy-MM-dd HH:mm:ss');
//            });
//            this.tableData =res.data;
//            this.total = res.total;
            this.isLoading=false;
//          });
        },
        sort(column){
          this.order = `${column.prop} ${column.order==='ascending'?'asc':'desc'}`;
          this.querryData(1);
        },
        handleCurrentChange(val) {
          this.currentPage = val;
          this.querryData(val);
        },
        confirm(){
          if(this.dialogData.pass===true){
            this.$message('请先点击选择审批结果');
            return;
          }
          if(this.dialogData.passReasonText==='' && this.dialogData.passReason===''){
            this.$message('请先填写审批意见');
            return;
          }
          this.id=this.dialogData.id;
          this.type = this.dialogData.pass==='同意' ? 'pass':'reject';
          this.opinion = this.dialogData.passReasonText===''? this.dialogData.passReason:this.dialogData.passReasonText;
          let startvalue=formatdata.format(this.startvalue,'yyyy-MM-dd');
          let endvalue=formatdata.format(this.endvalue,'yyyy-MM-dd');
          let param = {
            page: this.currentPage,
            whether: 1,
            count: 10,
            startTime:startvalue,
            endTime: endvalue,
            order:this.order,
            type:this.type,
            opinion:this.opinion,
            id:this.id
          };
          this.$confirm('此操作将录入系统, 是否继续?', '提示', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning'
          }).then(() => {
            req.ajaxSend('/school/TeacherLeave/approve','post',param,(res)=>{
              console.log(res);
              if(res.status===1){
                this.$message({
                  type: 'success',
                  message: '审批成功!'
                });
              }else {
                this.$message({
                  type: 'warning',
                  message: res.msg
                });
              }
            });
          }).catch(() => {
            this.$message({
              type: 'info',
              message: '已取消审批'
            });
          });
        }
      }
    }
</script>
<style scoped></style>
