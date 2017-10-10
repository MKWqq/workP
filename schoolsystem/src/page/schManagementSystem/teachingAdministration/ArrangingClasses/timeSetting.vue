<template>
  <div class="g-timeSetting">
    <header class="g-timeHeader">
      <el-button class="g-gobackChart RedButton" @click="goBackChart">
        <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
        返回流程图
      </el-button>
      <el-button class="blueButton" @click="saveSetting">保存</el-button>
    </header>
    <section class="g-timeSection">
      <div class="g-timeContent_one">
        <header class="g-contentOne_header">周表设置</header>
        <section class="g-contentOne_section">
          <el-table class="g-timeSettingTable" :data="weekChoose" style="width:100%">
            <el-table-column label="时段/周" prop="rowName"></el-table-column>
            <el-table-column v-for="n in 7" :key="n" :label="weekData[n-1]">
              <template scope="props">
                <el-checkbox v-if="props.row.rowName=='上午'" :disabled="section.morningCount==0" v-model="weekAjaxData[props.$index][n-1]"></el-checkbox>
                <el-checkbox v-if="props.row.rowName=='下午'" :disabled="section.noon==0" v-model="weekAjaxData[props.$index][n-1]"></el-checkbox>
                <el-checkbox v-if="props.row.rowName=='晚上'" :disabled="section.night==0" v-model="weekAjaxData[props.$index][n-1]"></el-checkbox>
              </template>
            </el-table-column>
          </el-table>
          <p class="prompt">* 勾选之后即表示上课，并且只有在“节次设置”中设置了当前时段的节次，周表设置才会保存成功。</p>
        </section>
      </div>
      <div class="g-timeContent_two">
        <header class="g-contentTwo_header">节次设置</header>
        <section class="g-contentTwo_section">
          <div class="g-courseChoose clear_fix">
            <div class="courseChoose-row">
              <span class="g-rowTimer">上午</span>
              <input type="text" v-model="section.morningCount" />
              <span class="g-RowCourse">节</span>
            </div>
            <div class="courseChoose-row">
              <span class="g-rowTimer">下午</span>
              <input type="text" v-model="section.noon" />
              <span>节</span>
            </div>
            <div class="courseChoose-row">
              <span class="g-rowTimer">晚上</span>
              <input type="text" v-model="section.night" />
              <span>节</span>
            </div>
            <el-button class="createTimer greenButton" @click="createTimeTable">生成时间表</el-button>
          </div>
          <el-table class="g-timeSettingTable" :data="courseSetting" style="width:100%">
            <el-table-column label="节次/时间">
              <template scope="props">
                <div v-text="'第'+(props.$index+1)+'节'"></div>
              </template>
            </el-table-column>
            <el-table-column label="开始时间">
              <template scope="props">
                <el-time-select placeholder="开始时间" v-model="props.row.startTime" :picker-options="props.row.pickerOptionsStart"></el-time-select>
              </template>
            </el-table-column>
            <el-table-column label="结束时间">
              <template scope="props">
                <el-time-select placeholder="开始时间" v-model="props.row.endTime" :picker-options="props.row.pickerOptionsEnd"></el-time-select>
              </template>
            </el-table-column>
          </el-table>
        </section>
      </div>
    </section>
  </div>
</template>
<script>
  import {mapState} from 'vuex'
  import {courseSetting} from '@/api/http'
  export default{
    data(){
      const _self=this;
      return{
        /*星期课程时间选择*/
        weekChoose:[
          {rowName:'上午'},
          {rowName:'下午'},
          {rowName:'晚上'},
        ],
        /*星期课程时间选择——星期数据双向绑定*/
        /*发送请求时将其转化为Number型*/
        weekAjaxData:[
          [false,false,false,false,false,false,false],
          [false,false,false,false,false,false,false],
          [false,false,false,false,false,false,false],
        ],
        /*节次设置*/
        /*单行数据*/
        oneRowData:{startTime:'',endTime:'',
          pickerOptionsStart:{start:'04:00',step:'00:15',end:'23:00'},
          pickerOptionsEnd:{start:'04:00',step:'00:15',end:'23:00'}
        },
        /*节次设置table框*/
        courseSetting:[],
        /*节数填写表单*/
        section:{
          morningCount:0,
          noon:0,
          night:0,
        },
        /*星期转换*/
        weekData:['星期一','星期二','星期三','星期四','星期五','星期六','星期日'],
      }
    },
    computed:{
      ...mapState(['pkListId']),
    },
    methods:{
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'examinationChart'});
      },
      /*保存设置*/
      saveSetting(){
        /*isSettingWeek为判定周表设置是否设置*/
        let isSettingWeek=this.weekAjaxData.some((value)=>{
          return value.some((childValue)=>{
            return childValue;
          });
        });
        /*isSettingTime为时间判定设置完没*/
        let isSettingTime=this.courseSetting.every((value)=>{
          return value.startTime && value.endTime;
        });
        if(isSettingWeek && this.courseSetting.length>0 && isSettingTime){
          this.saveAjaxSetting();
        }
        else{
          this.errorAlert('请完成周表设置，节次设置，节次时间设置!');
        }
      },
      /*生成时间表点击事件*/
      createTimeTable(){
        /*总上课节数*/
        this.courseSetting=[];
        const courseNum=Number(this.section.morningCount)+Number(this.section.noon)+Number(this.section.night);
        for(let i=0;i<courseNum;i++){
          /*向节次设置table表中加时间设置表*/
          this.courseSetting.push(Object.assign({},this.oneRowData));
        }
      },
      /*ajax=====*/
      saveAjaxSetting(){
        /*转换复选框的值为0或1*/
        const week=[[],[],[]];
        this.weekAjaxData.forEach((value,index)=>{
          value.forEach((childValue,childIndex)=>{
            week[index].push(Number(childValue));
          });
        });
        courseSetting({pkListId:this.pkListId,data:{week:week,section:this.section,day:this.courseSetting}}).then(data=>{
          this.sendAjaxPrompt(data,'保存时间设置');
        });
      },
      /*错误弹框*/
      errorAlert(msg){
        this.$alert(msg,'提示',{
          confirmButtonText:'确定',
          type:'error',
          callback:action=>{}
        });
      },
      /*发送ajax提示框*/
      sendAjaxPrompt(data,msg){
        if(data.statu){
          this.$message({
            message:msg+'成功!',
            type:'success'
          });
          this.initWeekAjaxData();
        }else{
          this.$message.error(msg+'失败,请重试!');
        }
      },
      /*重置check的双向绑定数据，因为转为0，1之后不能控制checkbox的选中*/
      initWeekAjaxData(){
        /*周表设置table框*/
        this.weekAjaxData=[
          [false,false,false,false,false,false,false],
          [false,false,false,false,false,false,false],
          [false,false,false,false,false,false,false],
        ];
        /*节次设置table框*/
        this.courseSetting=[];
        /*节数填写表单*/
        this.section={
          morningCount:0,
            noon:0,
            night:0,
        };
      },
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/arrangeClasses/arrangeClasses.css';
  @import '../../../../style/arrangeClasses/timeSetting.less';
</style>




