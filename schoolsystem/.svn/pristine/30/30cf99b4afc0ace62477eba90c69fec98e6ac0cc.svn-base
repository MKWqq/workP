<template>
  <div class="FilerecordPassed">
    <el-col class="LeaveRecord-title">
      <!--时间段-->
      <el-col :span="24">
        <el-col :span="2" style="margin-top: .3rem;">信息类别：</el-col>
        <el-col :span="5">
          <el-col :span="24">
            <el-input v-model="optionsvalue" @focus="Showcheckbox()"></el-input>
          </el-col>
          <!--多选框-->
          <el-col :span="5" v-if="showcheckbox" class="FilerecordPassed-checkbox">
            <el-checkbox :indeterminate="isIndeterminate" v-model="checkAll" @change="handleCheckAllChange">全选</el-checkbox>
            <div style="margin: 15px 0;"></div>
            <el-checkbox-group v-model="checkedCities" @change="handleCheckedCitiesChange">
              <el-checkbox v-for="city in cities" :label="city" :key="city">{{city}}</el-checkbox>
            </el-checkbox-group>
            <el-col :span="1" :offset="10">
              <el-button type="primary"  class="Hidecheckbox-btn" @click ="Hidecheckbox()">确定</el-button>
            </el-col>
          </el-col>
        </el-col>
        <el-col :span="2" :offset="1" style="margin-top: .3rem;">档案时间：</el-col>
        <el-col :span="3" style="margin-left: -1rem">
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
          <el-button type="primary" icon="search" class="LeaveRecord-search">查询</el-button>
        </el-col>
      </el-col>
    </el-col>
    <el-col :span="17" class="alertsBtn" style="margin-top: 0">
      <el-button-group style="margin-top:1.8rem">
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
    </el-col>
  </div>
</template>
<script>
  const cityOptions = ['上海', '北京', '广州', '深圳'];
    export default{
        data(){
            return{
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
              optionsvalue:'',
              checkAll: true,
              checkedCities: [],
              cities: cityOptions,
              isIndeterminate: true,
              showcheckbox:false,


              Searchinput:'',
              dialogTableVisible:false,
              accessory:false,
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
//              pickerOptions0: {
//                disabledDate(time) {
//                  return time.getTime() < Date.now() - 8.64e7;
//                }
//              },
              switchvalue:true,
//              checkAll: true,
            }
        },
      methods:{
        Showcheckbox(){
          this.showcheckbox=true;
        },
        Hidecheckbox(){
          this.showcheckbox=false;
        },
        Offaccessory(){
          this.accessory=false;
        },
        sendFile(){

        },
        handleCheckAllChange(event) {
          this.checkedCities = event.target.checked ? cityOptions : [];
          this.isIndeterminate = false;
        },
        handleCheckedCitiesChange(value) {
//          this.optionsvalue=value;
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
      },
    }
</script>
<style lang="less">
  .FilerecordPassed-checkbox{
    border: 1px solid #d1dbe5;
    border-radius: 3px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,.12), 0 0 6px rgba(0,0,0,.04);
    box-sizing: border-box;
    margin:48px 0;
    z-index:1001;
    position: absolute;
    padding: 1rem;
  }
  .FilerecordPassed  .el-checkbox-group .el-checkbox{
    margin-left: 0;
    margin-top: .6rem;
    margin-right: .6rem;
  }
  .FilerecordPassed .Field-save{
    position: absolute;
    bottom: 1.4rem;
    padding: .6rem 2.6rem;
    border-radius: 1.1rem;
  }
 .FilerecordPassed .Hidecheckbox-btn{
    margin-top: 1.6rem;
    padding: .35rem 1rem;
  }
</style>
