<template>
  <div class="FilerecordPending">
    <el-col :span="24" class="FilerecordPending-border"></el-col>
    <el-col :span="17" class="alertsBtn" style="margin-top: 0">
      <el-button-group style="margin-top:1.8rem">
        <el-button class="delete" title="新增" @click="addFilerecord()">
          <img class="delete_unactive" src="./../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add.png" alt="">
          <img class="delete_active" src="./../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_add_highlight.png" alt="">
        </el-button>
        <el-button class="delete" title="删除">
          <img class="delete_unactive" src="../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete.png" alt="">
          <img class="delete_active" src="../../../../assets/img/schManagementSystem/campusOffice/notificationNotice/icon_delete_highlight.png" alt="">
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
          v-loading.body="isLoading"
          element-loading-text="拼命加载中...">
          <el-table-column
            type="selection"
            width="50"
            @change="chooseAll">
          </el-table-column>
          <el-table-column
            prop="title"
            label="档案名称"
            align="center">
            <template scope="scope">
              <span style="color:#4da1ff;cursor: pointer;" @click="ShowDatils(scope.row)">{{scope.row.title}}</span>
            </template>
          </el-table-column>
          <el-table-column
            prop="name"
            label="档案编号"
            align="center">
          </el-table-column>
          <el-table-column
            prop="name"
            label="标签"
            align="center">
          </el-table-column>
          <el-table-column
            prop="createTime"
            label="档案所有者"
            align="center">
            <template scope="scope">
              <span>{{scope.row.createTime|formatDate}}</span>
            </template>
          </el-table-column>
          <el-table-column
            prop=""
            label="档案时间"
            align="center">
            <template scope="scope">
              <span></span>
            </template>
          </el-table-column>
          <el-table-column
            prop="result"
            label="备注"
            align="center">
            <template scope="scope">
              <span></span>
            </template>
          </el-table-column>
          <el-table-column
            prop="result"
            label="处理情况"
            align="center">
            <template scope="scope">
              <span></span>
            </template>
          </el-table-column>
          <el-table-column
            label="操作"
            align="center">
            <template scope="scope">
              <span style="color:#4da1ff;cursor: pointer;" @click="Showaccessory(scope.row)">附件</span>
            </template>
          </el-table-column>
        </el-table>
      </el-row>
      <el-dialog title="档案记录详情" v-if="dialogTableVisible" :modal="false" :visible.sync="dialogTableVisible">
        <el-col :span="24" style="text-align: center;min-height: 38rem;">
          <div class="LeaveRecord-table">
            <div class="LeaveRecord-dialog-title">#{{dialogData.title}}#</div>
            <el-col :span="24">
              <div class="LeaveRecord-table-div">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">档案标签</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.startTime|formatDate}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">档案所有者</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.endTime|formatDate}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">档案时间</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.duration}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">提交时间</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.duration}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">提交人</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.duration}}</div>
                </el-col>
              </div>
              <div class="LeaveRecord-table-div LeaveRecord-table-div-final">
                <el-col :span="7">
                  <div class="LeaveRecord-table-div-1">备注</div>
                </el-col>
                <el-col :span="17">
                  <div>{{dialogData.reason}}</div>
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
      <el-dialog title="附件" v-if="accessory" :modal="false" :visible.sync="accessory">
        <el-row class="alertsList">
          <el-table
            :data="tableData"
            style="width: 100%"
            border>
            <el-table-column
              type="index"
              label="序号"
              align="center"
              width="100">
            </el-table-column>
            <el-table-column
              prop="title"
              label="附件名"
              align="center">
            </el-table-column>
            <el-table-column
              label="操作"
              align="center">
              <template scope="scope">
                <span style="color:#4da1ff;cursor: pointer;">下载</span>
              </template>
            </el-table-column>
          </el-table>
        </el-row>
        <el-col :span="24" style="margin-top: 2rem;">
          <el-col :span="2" :offset="8">
            <el-button type="primary" class="Field-save">选择</el-button>
          </el-col>
          <el-col :span="2" :offset="13">
            <el-button class="Field-save" @click="Offaccessory()">取消</el-button>
          </el-col>
        </el-col>
      </el-dialog>
      <el-dialog title="新增档案记录" v-if="addFile" :modal="false" :visible.sync="addFile">
        <el-col :span="22" :offset="1" class="FilerecordPending-add">
          <el-col :span="24">
            <el-col :span="3" class="FilerecordPending-add-title">档案名称：</el-col>
            <el-col :span="8">
              <el-input></el-input>
            </el-col>
            <el-col :span="3" :offset="2" class="FilerecordPending-add-title">档案所有者：</el-col>
            <el-col :span="8">
              <el-select style="width: 100%;" v-model="value5" multiple placeholder="请选择">
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-col>
          </el-col>
          <el-col :span="24" class="FilerecordPending-add-top">
            <el-col :span="3" class="FilerecordPending-add-title">时间：</el-col>
            <el-col :span="8">
              <el-date-picker
                style="width: 100%"
                v-model="timeVal"
                type="date"
                placeholder="选择日期"
                :picker-options="pickerOptions0">
              </el-date-picker>
            </el-col>
            <el-col :span="3" :offset="2" class="FilerecordPending-add-title">备注：</el-col>
            <el-col :span="8">
              <el-input></el-input>
            </el-col>
          </el-col>
          <el-col :span="24" class="FilerecordPending-add-top">
            <el-col :span="3" class="FilerecordPending-add-title">选择标签：</el-col>
            <el-col :span="21">
              是否选中上次所选标签：
              <el-switch
                v-model="switchvalue"
                on-text="是"
                off-text="否">
              </el-switch>
            </el-col>
          </el-col>
          <el-col :span="24" class="FilerecordPending-add-top">
            <el-col :span="21" :offset="3" class="FilerecordPending-add-Remarks">注：每种标签类型都要选择</el-col>
          </el-col>
          <el-col :span="24" class="FilerecordPending-add-top">
            <el-col :span="21" :offset="3">
              <el-checkbox :indeterminate="isIndeterminate" v-model="checkAll" @change="handleCheckAllChange">类型1</el-checkbox>
              <div style="margin: 15px 0;"></div>
              <el-checkbox-group v-model="checkedCities" @change="handleCheckedCitiesChange">
                <el-checkbox v-for="city in cities" :label="city" :key="city">{{city}}</el-checkbox>
              </el-checkbox-group>
            </el-col>
          </el-col>
          <el-col :span="24" class="FilerecordPending-add-top" style="margin-top:1.6rem;">
            <el-col :span="21" :offset="3">
              <el-checkbox :indeterminate="isIndeterminate" v-model="checkAll" @change="handleCheckAllChange">类型2</el-checkbox>
              <div style="margin: 15px 0;"></div>
              <el-checkbox-group v-model="checkedCities" @change="handleCheckedCitiesChange">
                <el-checkbox v-for="city in cities" :label="city" :key="city">{{city}}</el-checkbox>
              </el-checkbox-group>
            </el-col>
          </el-col>
          <el-col :span="24" class="FilerecordPending-add-top">
            <el-col :span="3" class="FilerecordPending-add-title" style="margin-top: 1rem">上传附件：</el-col>
            <el-col :span="21">
              <div class="uploadFile">
                <el-button>选择附件</el-button>
                <input type="file" accept=".xlsx,.xlsm,.xls.doc,.docx,.ppt" class="file_input" @change="sendFile">
              </div>
            </el-col>
          </el-col>
          <el-col :span="24" class="FilerecordPending-add-top">
            <el-col :offset="3" :span="21" class="FilerecordPending-add-title" style="margin-top: 1rem">
              <div class="Sendfile-text">
                <span>
                  <span>开学通知.png</span>
                  <i class="el-icon-close" style="font-size: .875rem"></i>
                </span>
                <span>
                  <span>开学通知.png</span>
                <i class="el-icon-close" style="font-size: .875rem"></i>
                </span>
              </div>
            </el-col>
          </el-col>
          <el-col :span="24" style="margin-top: 2rem;">
            <el-col :span="2" :offset="8">
              <el-button type="primary" class="Field-save">保存</el-button>
            </el-col>
            <el-col :span="2" :offset="13">
              <el-button class="Field-save" @click="Offdialog()">取消</el-button>
            </el-col>
          </el-col>
        </el-col>
      </el-dialog>
    </el-col>
  </div>
</template>
<script>
  const cityOptions = ['上海', '北京', '广州', '深圳'];
    export default{
        data(){
            return{
              Searchinput:'',
              dialogTableVisible:false,
              accessory:false,
              addFile:false,
              isLoading:false,
              tableData:[{title:'1111'}],
              checkedAll:false,
              dialogData:{},
              link:'',
              person:'',
              options: [{
                value: '选项1',
                label: '黄金糕'
              }],
              value5: [],
              timeVal:new Date(),
              pickerOptions0: {
                disabledDate(time) {
                  return time.getTime() < Date.now() - 8.64e7;
                }
              },
              switchvalue:true,
              checkAll: true,
              checkedCities: ['上海', '北京'],
              cities: cityOptions,
              isIndeterminate: true

            }
        },
      methods:{
        Offaccessory(){
          this.accessory=false;
        },
        Offdialog(){
          this.addFile=false;
        },
        sendFile(){

        },
        handleCheckAllChange(event) {
          this.checkedCities = event.target.checked ? cityOptions : [];
          this.isIndeterminate = false;
        },
        handleCheckedCitiesChange(value) {
          let checkedCount = value.length;
          this.checkAll = checkedCount === this.cities.length;
          this.isIndeterminate = checkedCount > 0 && checkedCount < this.cities.length;
        },
        handleIconClick(){},
        ShowDatils(row){
          if(row.approver){
            row.links=row.approver.map((val,idx)=>`第${idx+1}审批环节`);
            row.approver.forEach((val,idx)=>{
              if(typeof val==='object'){
                if(!row.opinion[idx]){
                  row.opinion[idx]=[]
                }
              }
            });
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
        addFilerecord(){
          this.addFile=true;
        },
        Showaccessory(){
          this.accessory=true;
        },
        chooseAll(){
          if (this.checkedAll) {
            for (let obj of this.tableData) {
              obj.checked = true;
            }
            $.extend(this.multipleSelection, this.tableData);
          } else {
            for (let obj of this.tableData) {
              obj.checked = false;
            }
            this.multipleSelection = [];
          }
        },
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
<style lang="less">
  .FilerecordPending .FilerecordPending-border{
    padding-top:1.6rem;
    border-bottom: 1px solid #d2d2d2;
  }
 .FilerecordPending .LeaveRecord-dialog-title{
    display: inline-block;
    margin: auto;
    font-weight: bold;
    font-size: 16px;
    padding-bottom: 1.2rem;
  }
 .FilerecordPending .LeaveRecord-table-div{
    width: 100%;
    height: 2.625rem;
    border-top: 1px solid #d2d2d2;
    text-align: center;
    line-height: 2.625rem;
    box-sizing:border-box;
  }
 .FilerecordPending .LeaveRecord-table-div-final{
    border-bottom: 1px solid #d2d2d2;
  }
 .FilerecordPending .LeaveRecord-table-div-1{
    border-right: 1px solid #d2d2d2;
  }
 .FilerecordPending .LeaveRecord-state-btn{
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
 .FilerecordPending .FilerecordPending-add{
    height: 38rem;
    overflow-y: auto;
  }
 .FilerecordPending .FilerecordPending-add .el-tag--primary{
   background-color:#F08BC5;
   border-color: #f08bc5;
   color: #fff;
  }
  .FilerecordPending .FilerecordPending-add .el-icon-close:hover{
    background-color:#fff;
    color: #888888;
  }
  .FilerecordPending-add-title{
    /*text-align: right;*/
  }
  .FilerecordPending-add-top{
    margin-top: 1.2rem;
  }
  .FilerecordPending-add-Remarks{
    color: #A6A6A6;
  }
 .FilerecordPending .uploadFile {
   display: inline-block;
   position: relative;
   .file_input {
     width: 100%;
     height: 36px;
     border-radius: 18/16rem;
     position: absolute;
     right: 0;
     top: 0;
     z-index: 1;
     -moz-opacity: 0;
     -ms-opacity: 0;
     -webkit-opacity: 0;
     opacity: 0; /*css属性——opcity不透明度，取值0-1*/
     filter: alpha(opacity=0); /*兼容IE8及以下--filter属性是IE特有的，它还有很多其它滤镜效果，而filter: alpha(opacity=0); 兼容IE8及以下的IE浏览器(如果你的电脑IE是8以下的版本，使用某些效果是可能会有一个允许ActiveX的提示,注意点一下就ok啦)*/
     cursor: pointer;
   }
   .el-button{
    border-radius:1.6rem;
     /*padding-left:1.6rem;*/
     /*padding-right:1.6rem;*/
     padding:.6rem 1.6rem;
     margin-top:.7rem;
   }
 }
  .Sendfile-text>span{
    padding:0 1rem;
    display: inline-block;
    border-right: 1px solid #d2d2d2;
  }
 .FilerecordPending .Field-save{
   position: absolute;
   bottom: 1.4rem;
   padding: .6rem 2.6rem;
   border-radius: 1.1rem;
 }
</style>
