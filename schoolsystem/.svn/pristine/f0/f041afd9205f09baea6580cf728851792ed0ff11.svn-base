<template>
    <div class="LeaveRecord" id="LeaveRecord">
        <el-col :span="24" style="border-bottom: 1px solid #d2d2d2;padding-bottom: 2rem;">
            <h3>请假明细</h3>
        </el-col>
        <!--<el-col class="LeaveRecord-title">-->
            <!--&lt;!&ndash;时间段&ndash;&gt;-->
            <!--<el-col :span="24">-->
                <!--<el-col :span="2">时间段：</el-col>-->
                <!--<el-col :span="3" style="margin-left: -3rem">-->
                    <!--<el-date-picker-->
                            <!--v-model="startvalue" type="date" :picker-options="pickerOptions0" style="width: 100%">-->
                    <!--</el-date-picker>-->
                <!--</el-col>-->
                <!--<el-col :span="1"  style="text-align: center">_</el-col>-->
                <!--<el-col :span="3">-->
                    <!--<el-date-picker-->
                            <!--v-model="endvalue" type="date" :picker-options="pickerOptions1" style="width: 100%">-->
                    <!--</el-date-picker>-->
                <!--</el-col>-->
                <!--<el-col :span="1" :offset="12">-->
                    <!--<el-button type="primary" icon="search" class="LeaveRecord-search" @click="querryDetails()">查询</el-button>-->
                <!--</el-col>-->
            <!--</el-col>-->
        <!--</el-col>-->
        <el-col :span="18" class="alertsBtn">
            <el-button class="delete" title="导出">
                <img class="delete_unactive"
                     src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out.png"
                     alt="">
                <img class="delete_active"
                     src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_out_highlight.png"
                     alt="">
            </el-button>
            <el-button-group style="margin-left: 2.1rem">
                <el-button class="filt" title="复制">
                    <img class="filt_unactive"
                         src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy.png"
                         alt="">
                    <img class="filt_active"
                         src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_copy_highlight.png"
                         alt="">
                </el-button>
                <el-button class="delete" title="打印">
                    <img class="delete_unactive"
                         src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png"
                         alt="">
                    <img class="delete_active"
                         src="../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png"
                         alt="">
                </el-button>
            </el-button-group>
        </el-col>
        <el-col :span="24">
            <el-row class="alertsList">
                <el-table
                        :data="tableData"
                        style="width: 100%"
                        @sort-change="sort"
                        align="center"
                        v-loading.body="isLoading"
                        element-loading-text="拼命加载中...">
                    <el-table-column
                            prop="proposer"
                            label="申请人"
                            sortable="custom">
                    </el-table-column>
                    <el-table-column
                            prop="name"
                            label="类型"
                            sortable="custom">
                    </el-table-column>
                    <el-table-column
                            prop="startTime"
                            label="开始时间"
                            width="200"
                            sortable="custom">
                    </el-table-column>
                    <el-table-column
                            prop="duration"
                            label="请假天数"
                            sortable="custom">
                    </el-table-column>
                    <el-table-column
                            prop="reason"
                            label="请假原因"
                            sortable="custom">
                    </el-table-column>
                    <el-table-column
                        prop=""
                        label="审批环节1">
                        <template  scope="scope">
                            <p v-for="item in scope.row.linkOne" v-html="item"></p>
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop=""
                        label="审批环节2">
                        <template  scope="scope">
                            <p v-for="item in scope.row.linkTwo" v-html="item"></p>
                        </template>
                    </el-table-column>
                    <el-table-column
                            label="操作">
                        <template  scope="scope">
                            <span style="color:#89bcf5;cursor: pointer;" @click="Showdialog(scope.row)">详情</span>
                        </template>
                    </el-table-column>
                </el-table>
            </el-row>
            <el-dialog title="请假明细详情" v-if="dialogTableVisible" :modal="false" :visible.sync="dialogTableVisible">
                <el-col :span="24" style="text-align: center;min-height: 35rem;">
                    <div class="LeaveRecord-table">
                        <div class="LeaveRecord-dialog-title">#{{dialogData.title}}#</div>
                        <el-col :span="24">
                            <div class="LeaveRecord-table-div">
                                <el-col :span="7">
                                    <div class="LeaveRecord-table-div-1">申请人</div>
                                </el-col>
                                <el-col :span="17">
                                    <div>{{dialogData.proposer}}</div>
                                </el-col>
                            </div>
                            <div class="LeaveRecord-table-div">
                                <el-col :span="7">
                                    <div class="LeaveRecord-table-div-1">请假类型</div>
                                </el-col>
                                <el-col :span="17">
                                    <div>{{dialogData.name}}</div>
                                </el-col>
                            </div>
                            <div class="LeaveRecord-table-div">
                                <el-col :span="7">
                                    <div class="LeaveRecord-table-div-1">起始时间</div>
                                </el-col>
                                <el-col :span="17">
                                    <div>{{dialogData.startTime}}</div>
                                </el-col>
                            </div>
                            <div class="LeaveRecord-table-div">
                            <el-col :span="7">
                            <div class="LeaveRecord-table-div-1">结束时间</div>
                            </el-col>
                            <el-col :span="17">
                            <div>{{dialogData.title}}</div>
                            </el-col>
                            </div>
                            <div class="LeaveRecord-table-div">
                                <el-col :span="7">
                                    <div class="LeaveRecord-table-div-1">请假天数</div>
                                </el-col>
                                <el-col :span="17">
                                    <div>{{dialogData.duration}}</div>
                                </el-col>
                            </div>
                            <div class="LeaveRecord-table-div">
                                <el-col :span="7">
                                    <div class="LeaveRecord-table-div-1">请假原因</div>
                                </el-col>
                                <el-col :span="17">
                                    <div>{{dialogData.reason}}</div>
                                </el-col>
                            </div>
                            <div class="LeaveRecord-table-div LeaveRecord-table-div-final">
                            <el-col :span="7">
                            <div class="LeaveRecord-table-div-1">创建时间</div>
                            </el-col>
                            <el-col :span="17">
                            <div>{{dialogData.title}}</div>
                            </el-col>
                            </div>
                        </el-col>
                        <el-col :span="24">
                            <div class="LeaveRecord-state-btn">审批状态</div>
                        </el-col>
                      <el-col :span="18" :offset="2" style="margin-top: 1.8rem">
                        <el-col :span="24" style="padding-bottom: 1.25rem">
                          <el-col :span="5">
                            <span>审批环节：</span>
                          </el-col>
                          <el-col :span="12" style="text-align: left">
                            <el-select v-model="link">
                              <el-option
                                v-for="item in dialogData.links"
                                :key="item"
                                :value="item">
                              </el-option>
                            </el-select>
                          </el-col>
                        </el-col>
                        <el-col :span="24" style="padding-bottom: 1.25rem">
                          <el-col :span="5">
                            <span>审批人：</span>
                          </el-col>
                          <el-col :span="12" style="text-align: left">
                            <el-select v-model="person">
                              <el-option
                                v-for="item in dialogData.approver[dialogData.linkIndex]"
                                :key="item"
                                :value="item">
                              </el-option>
                            </el-select>
                          </el-col>
                        </el-col>
                        <el-col :span="24" style="padding-bottom: 1.25rem;">
                          <el-col :span="5">
                            <span>审批结果：</span>
                          </el-col>
                          <el-col :span="12" style="text-align: left">
                            <span>{{dialogData.result[dialogData.linkIndex][dialogData.personIndex] | getResultState}}</span>
                          </el-col>
                        </el-col>
                        <el-col :span="24" style="padding-bottom: 1.25rem;">
                          <el-col :span="5">
                            <span>审批意见：</span>
                          </el-col>
                          <el-col :span="12" style="text-align: left">
                            <span>{{dialogData.opinion[dialogData.linkIndex][dialogData.personIndex] || '未填写'}}</span>
                          </el-col>
                        </el-col>
                      </el-col>
                    </div>
                </el-col>
            </el-dialog>
            <el-row class="pageAlerts">
                <el-pagination
                        @current-change="handleCurrentChange"
                        :current-page.sync="currentPage"
                        :page-size="pageALl"
                        layout="prev, pager, next, jumper"
                        :total="total">
                </el-pagination>
            </el-row>
        </el-col>
    </div>
</template>
<script>
  import req from './../../../../assets/js/common'
  import formatdata from './../../../../assets/js/date'
  export default{
    data(){
      return{
        isLoading:false,
        dialogData:{},
        link:'',
        person:'',
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
        tableData: [],
        currentPage: 1,
        pageALl: 10,
        total:0,
        order:'createTime desc'
      }
    },
    created(){
      this.querryDetails(1)
    },
    methods:{
      Showdialog(row){
//        console.log(JSON.stringify(row,null,4));
        if(row.approver){
          row.links=row.approver.map((val,idx)=>`第${idx+1}审批环节`);
          row.approver.forEach((val,idx)=>{
            if(typeof val==='object'){
              if(!row.opinion[idx]){
                row.opinion[idx]=[]
              }
            }
          })
          row.linkIndex=0;
          row.personIndex=0;
          this.link = row.links[0];
          this.person = row.approver[0][0];
        }else{
          row.links=['无选项'];
          row.approver=[['无选项']];
          row.result=[[-2]];
          row.opinion=[['无']];
          row.linkIndex=0;
          row.personIndex=0;
          this.link = row.links[0];
          this.person = row.approver[0][0];
        }
        this.dialogData=row;
        this.dialogTableVisible=true;
      },
      querryDetails(page){
        if(page!==this.currentPage){
          this.currentPage=page;
        }
        this.isLoading=true;
//        let startvalue=formatdata.format(this.startvalue,'yyyy-MM-dd');
//        let endvalue=formatdata.format(this.endvalue,'yyyy-MM-dd');
        let param = {
          page: this.currentPage,
          count: 10,
//          startTime:startvalue,
//          endTime: endvalue,
          order:this.order
        };
        req.ajaxSend('/school/TeacherLeave/detail','post',param,(res)=> {
          if (res.status === -1) {
            this.tableData = [];
            this.isLoading = false;
            return;
          }
          res.data.forEach((val)=>{
            val.startTime=new Date((val.startTime)*1000);
            val.startTime=formatdata.format(val.startTime,'yyyy-MM-dd HH:mm:ss');
            val.linkOne = [];
            val.linkTwo = [];
            if(val.approver&&val.approver[0]){
              val.approver[0].forEach((subval,idx)=>{
                if(subval){
                  let result = this.getResultState(val.result[0][idx]);
                  val.linkOne.push(`<span>${subval}</span>  <span style="color:#48b6c4;">${result}</span>`)
                }
              })
            }
            if(val.approver&&val.approver[1]){
              val.approver[1].forEach((subval,idx)=>{
                if(subval){
                  let result = this.getResultState(val.result[1][idx]);
                  val.linkTwo.push(`<span>${subval}</span>  <span style="color:#48b6c4;">${result}</span>`)
                }
              })
            }
          });
          this.tableData = res.data;
          this.total = res.total;
          this.isLoading = false;
        })
      },
      sort(column){
        this.order = `${column.prop} ${column.order==='ascending'?'asc':'desc'}`;
        this.querryDetails(1);
      },
      handleCurrentChange(val) {
        this.currentPage = val;
        this.querryDetails(val);
//        console.log(`当前页: ${this.currentPage}`);
      },
      getResultState(val){
        return val===1?'通过':
          val===2?'审批过期':
            val===-2?'无':'未通过';
      }
    },
    watch:{
      link(val){
        let linkIndex;
        this.dialogData.links.forEach((subVal,idx)=>{
          if(subVal===val){
            linkIndex = idx;
          }
        })

        this.dialogData.personIndex = 0;
        this.dialogData.linkIndex=linkIndex;
        this.person = this.dialogData.approver[linkIndex][0];
      },
      person(val){
        let personIndex;
        this.dialogData.approver[this.dialogData.linkIndex].forEach((subVal,idx)=>{
          if(subVal===val){
            personIndex = idx;
          }
        })

        this.dialogData.personIndex=personIndex;
      }
    },
    filters:{
      getResultState(val){
        return val===1?'通过':
          val===2?'审批过期':
            val===-2?'无':'未通过';
      }
    }
  }
</script>
<style>
    .el-table tr{
        overflow: hidden;/*内容超出后隐藏*/
        text-overflow: ellipsis;/* 超出内容显示为省略号*/
        white-space: nowrap;/*文本不进行换行*/
    }
    .LeaveRecord{
        padding: 1.25rem 2rem;
        box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
        border-radius: .5rem;
        margin: 1.25rem 0;
        background-color: #fff;
    }
    .LeaveRecord-title{
        margin-top: 2rem;
        padding-bottom: 1.3rem;
        border-bottom: 1px solid #d2d2d2;
    }
    .LeaveRecord-search{
        background: #4da1ff;
        width: 7.6rem;
        border-radius: 1.1rem;
    }
    .alertsBtn{
        margin-top: 1.5rem;
    }
    .LeaveRecord-dialog-title{
        display: inline-block;
        margin: auto;
        font-weight: bold;
        font-size: 16px;
        padding-bottom: 1.2rem;
    }
    .LeaveRecord-table-div{
        width: 100%;
        height: 2.625rem;
        border-top: 1px solid #d2d2d2;
        text-align: center;
        line-height: 2.625rem;
        box-sizing:border-box;
    }
    .LeaveRecord-table-div-final{
        border-bottom: 1px solid #d2d2d2;
    }
    .LeaveRecord-table-div-1{
        border-right: 1px solid #d2d2d2;
    }
    .LeaveRecord-state-btn{
        width: 6.25rem;
        height: 1.875rem;
        background:#4ba8ff;
        color:#fff;
        text-align: center;
        line-height: 1.875rem;
        border-top-right-radius: 1.1rem;
        border-bottom-right-radius: 1.1rem;
        margin-top: 1.2rem;
    }
    .LeaveRecord-agreed{
        color: #4cb6c1;
    }
</style>
