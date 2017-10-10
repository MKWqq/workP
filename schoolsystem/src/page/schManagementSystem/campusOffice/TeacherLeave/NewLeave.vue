<template>
  <div class="NewLeave">
    <el-row>
      <el-col :span="24">
        <h3>新建请假</h3>
      </el-col>
      <el-col :span="16" :offset="4">
        <div class="new-leave-content">
          <!--请假标题-->
          <el-col :span="24">
            <el-col :span="3">
              请假标题：
            </el-col>
            <el-col :span="21">
              <el-input v-model="inputTitle"></el-input>
            </el-col>
          </el-col>
          <!--请假类型-->
          <el-col :span="24">
            <el-col :span="3">
              请假类型：
            </el-col>
            <el-col :span="21">
              <el-select v-model="Typevalue" placeholder="请选择" style="width: 100%">
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-col>
          </el-col>
          <!--起始时间-->
          <el-col :span="24">
            <el-col :span="3">起始时间：</el-col>
            <el-col :span="8">
              <el-date-picker
                v-model="startdata" type="date" :picker-options="pickerOptions0" style="width: 100%">
              </el-date-picker>
            </el-col>
            <el-col :span="2"  style="text-align: center">_</el-col>
            <el-col :span="8">
              <el-time-picker v-model="startTime" style="width: 100%"></el-time-picker>
            </el-col>
          </el-col>
          <!--结束时间-->
          <el-col :span="24">
            <el-col :span="3">结束时间：</el-col>
            <el-col :span="8">
              <el-date-picker
                v-model="enddata" type="date" :picker-options="pickerOptions1" style="width: 100%">
              </el-date-picker>
            </el-col>
            <el-col :span="2"  style="text-align: center">_</el-col>
            <el-col :span="8">
              <el-time-picker v-model="endTime" style="width: 100%"></el-time-picker>
            </el-col>
          </el-col>
          <!--请假原因-->
          <el-col :span="24">
            <el-col :span="3">
              请假原因：
            </el-col>
            <el-col :span="21" class="new-leave-Reasons">
              <span @click="leaveSick()"><el-tag color="#fff">因病请假</el-tag></span>
              <span @click="leaveThings()"><el-tag color="#fff">因事请假</el-tag></span>
              <span @click="leaveOthers()"><el-tag color="#fff">其他</el-tag></span>
            </el-col>
          </el-col>
          <!--请假原因框-->
          <el-col :span="21" :offset="3">
            <div class="ReasonsText">
              <!--tags标签-->
              <el-col :span="24">
                <el-tag
                  :closable="true"
                  @close="handleClose()"
                  v-if="tagsShow"
                  class="NewLeave-tags">因病请假</el-tag>
                <el-tag
                  :closable="true"
                  @close="handleClose2()"
                  v-if="tagsShow2"
                  class="NewLeave-tags">因事请假</el-tag>
                <el-tag
                  :closable="true"
                  @close="handleClose3()"
                  v-if="tagsShow3"
                  class="NewLeave-tags">其他</el-tag>
              </el-col>
             <el-col :span="24">
               <textarea type="text" v-model="Reasons" placeholder="请输入请假原因" style="width: 100%;margin-top:1rem;height: 10rem;border: none;outline:none;resize : none;"></textarea>
             </el-col>
            </div>
          </el-col>
          <el-col :span="7" :offset="17">
           <el-col :span="12">
             <el-button type="primary" class="NewLeave-btn1" @click="SaveMsg()">保存</el-button>
           </el-col>
            <el-col :span="12">
              <el-button class="NewLeave-btn2" @click="Refreshpage()">重置</el-button>
            </el-col>
          </el-col>
        </div>
      </el-col>
    </el-row>
  </div>
</template>
<script>
    import req from './../../../../assets/js/common'
    import formatdata from './../../../../assets/js/date'
    export default{
      data(){
        let _this = this;
        return {
          inputTitle: '',
          options: [
              {
            value: ''
          }],
          Typevalue: '',
          pickerOptions0: {
            disabledDate(time) {
              return time.getTime() < Date.now() - 8.64e7;
            }
          },
          startdata: new Date(),
          enddata: new Date(),
          startTime: new Date(),
          pickerOptions1: {
            disabledDate(time) {
                if(Date.parse(_this.startdata)===Date.parse(_this.enddata)){
                  return time.getTime() < Date.now() - 8.64e7;
                }else{
                  return time.getTime() < Date.parse(_this.startdata);
                }
            }
          },
          Reasons:'',
          endTime: new Date(),
          tagsShow:false,
          tagsShow3:false,
          tagsShow2:false
        }
      },
      created(){
        let param={};
        req.ajaxSend('/school/TeacherLeave/getName','post',param,(res)=>{
//          let options = [];
//          for(let i = 0;i<res.length;i++){
//            options.push({
//              value:res[i].name
//            })
//          }
//          this.options = options;
          this.options = res.map(val=>({value:val.name}))
        });
      },
      methods: {
        Refreshpage(){
          window.location.reload();
        },
        SaveMsg(){
         let inputTitle=this.inputTitle,
         namearray=this.Typevalue,
         Reasons=this.Reasons,
         startdata=formatdata.format(this.startdata,'yyyy-MM-dd'),
         enddata=formatdata.format(this.enddata,'yyyy-MM-dd'),
         startTime=formatdata.format(this.startTime,'HH:mm:ss'),
         endTime=formatdata.format(this.endTime,'HH:mm:ss'),
         _start=startdata+' '+startTime,
         _end=enddata+' '+endTime,
         _timedistance=((Date.parse(enddata) - Date.parse(startdata))/1000/60/60/24)+1,
           param={
            type:'create',
            title:inputTitle,
            name:namearray,
            startTime:_start,
            endTime:_end,
            duration:_timedistance,
            reason:Reasons
          };
          if(this.inputTitle===''){
            this.$message('请输入请假标题');
            return;
          }
          else if(this.Typevalue===''){
            this.$message('请选择请假类型');
            return;
          }else if(this.Reasons===''){
            this.$message('请输入请假原因');
            return;
          }
          else{
            this.$confirm('此操作将录入系统, 是否继续?', '提示', {
              confirmButtonText: '确定',
              cancelButtonText: '取消',
              type: 'warning'
            }).then(() => {
              req.ajaxSend('/school/TeacherLeave/create','post',param,(res)=>{
//                console.log(res);
                if(res.status===1){
                  this.$message({
                    type: 'success',
                    message: '申请成功!'
                  });
                }else {
                  this.$message('申请出错，请刷新页面重新提交');
                }
              });
            }).catch(() => {
              this.$message({
                type: 'info',
                message: '已取消申请'
              });
            });
          }
        },
        handleClose() {
          this.tagsShow=false;
        },
        handleClose2() {
          this.tagsShow2=false;
        },
        handleClose3() {
          this.tagsShow3=false;
        },
        leaveSick(){
            this.tagsShow=true;
        },
        leaveThings(){
          this.tagsShow2=true;
        },
        leaveOthers(){
          this.tagsShow3=true;
        }
      }
    }
</script>
<style>
.NewLeave{
  padding: 1.25rem 2rem;
  box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
  border-radius: .5rem;
  margin: 1.25rem 0;
  background-color: #fff;
}
  .new-leave-content{
    margin-top: 3.75rem;
    min-height: 43.5rem;
  }
  .new-leave-content>div{
    margin-bottom: 1.875rem;
  }
  .new-leave-Reasons .el-tag{
    color:#f08bc5;
    border: 1px solid #f08bc5;
    height: 1.875rem;
    line-height: 1.875rem;
    width: 6.25rem;
    text-align: center;
    margin-right:1.25rem;
    cursor: pointer;
  }
  .ReasonsText{
    height:12.75rem;
    border: 1px solid #d2d2d2;
    border-radius: 0.5rem;
    width: 54rem;
    padding: 1.5rem;
  }
  .NewLeave-btn1{
    background: #4da1ff;
    width: 7.6rem;
    border-radius: 1.1rem;
  }
.NewLeave-btn2{
  color: #4da1ff;
  width: 7.6rem;
  border-radius: 1.1rem;
  border: 1px solid #4da1ff;
}
.NewLeave-tags{
  width: 7rem;
  height: 2.4rem;
  line-height: 2.4rem;
  background-color: #f08bc5;
  text-align: center;
  }
</style>
