<template>
  <div class="specifiedTurningClass">
    <el-row type="flex" align="middle">
      <el-col :span="12">
        <h3>教师指定调课</h3>
      </el-col>
      <el-col :span="12">
        <el-row type="flex" justify="end">
          <el-button type="primary" class="submittedBtn" @click="save">提交申请</el-button>
        </el-row>
      </el-col>
    </el-row>
    <el-row class="specifiedTurningClass_row">
      <el-row class="specifiedTurning_body">
        <el-row type="flex" align="middle" class="scheduleSearch">
          <el-col :span="12">
            <span class="scheduleSearch_txt">某某--课表</span>
            <el-select v-model="selectParam.grade" placeholder="请选择">
              <el-option
                v-for="item in gradeList"
                :key="item.value"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
            <el-select v-model="selectParam.class" placeholder="请选择">
              <el-option
                v-for="item in classList"
                :key="item.value"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-col>
          <el-col :span="12">
            <el-row class="weekBtnList">
              <span class="weekBtn" @click="changeData('now')">本周</span>
              <span class="weekBtn" @click="changeData('prev')">上一周</span>
              <span class="weekBtn" @click="changeData('next')">下一周</span>
            </el-row>
          </el-col>
        </el-row>
        <el-row class="scheduleContent">
          <el-row type="flex" align="middle" class="scheduleContent_head">
            <el-col :span="3">
              <span>节/周</span>
            </el-col>
            <el-col :span="3" v-for="week in weekList" :key="week.date">
              <span>{{week.date}}</span><br/><span>{{week.week}}</span>
            </el-col>
          </el-row>
          <el-row class="scheduleContent_body">
            <el-row type="flex" align="middle" class="scheduleContent_body_row" v-for="(schedule,index) in scheduleList"
                    :key="schedule.id">
              <el-col :span="3" class="schedule_box">
                <span class="idx_number">第{{index+1}}节</span>
              </el-col>
              <el-col :span="3" class="schedule_box schedule_subject" v-for="(data,idx) in schedule.dataList"
                      :key="idx">
                <span class="schedule_subject_normal"
                      :class="{'schedule_subject_use':data.state==1,'schedule_subject_unUse':data.state==2}">{{data.value}}</span>
              </el-col>
            </el-row>
          </el-row>
        </el-row>
      </el-row>
    </el-row>
  </div>
</template>
<script>
  import req from '@/assets/js/common'
  export default{
    data(){
      return {
        gradeList: [{
          value: '选项1',
          label: '黄金糕'
        }, {
          value: '选项2',
          label: '双皮奶'
        }],
        classList: [{
          value: '选项1',
          label: '黄金糕'
        }, {
          value: '选项2',
          label: '双皮奶'
        }],
        selectParam: {
          grade: '',
          class: ''
        },
        weekList: [{
          date: '2017-10-09',
          name: '周一'
        }, {
          date: '2017-10-09',
          name: '周二'
        }, {
          date: '2017-10-09',
          name: '周三'
        }, {
          date: '2017-10-09',
          name: '周四'
        }, {
          date: '2017-10-09',
          name: '周五'
        }, {
          date: '2017-10-09',
          name: '周六'
        }, {
          date: '2017-10-09',
          name: '周日'
        }],
        scheduleList: [{
          id: 1,
          dataList: [{
            value: '语文',
            state: 0
          }, {
            value: '语文',
            state: 0
          }, {
            value: '语文',
            state: 0
          }, {
            value: '语文',
            state: 0
          }, {
            value: '语文',
            state: 0
          }, {
            value: '语文',
            state: 2
          }, {
            value: '语文',
            state: 1
          }]
        }, {
          id: 2,
          dataList: [{
            value: '数学',
            state: 0
          }, {
            value: '数学',
            state: 0
          }, {
            value: '数学',
            state: 0
          }, {
            value: '数学',
            state: 0
          }, {
            value: '数学',
            state: 0
          }, {
            value: '数学',
            state: 2
          }, {
            value: '数学',
            state: 1
          }]
        }],
        currentFirstDate:''
      }
    },
    created:function () {
      this.weekList=this.setDate(this.addDate(new Date(), 7));
    },
    methods: {
      changeData(type){
        var cDate='';
        if (type == 'now') { //本周

        } else if (type == 'prev') {  //上周
          console.log(3);
          this.setDate(this.addDate(this.currentFirstDate,-7));
        } else {   //下周
          this.setDate(this.addDate(this.currentFirstDate,7));
        }
      },
      save(){
      },
      addDate(date,n){
        /*
         * 日期加上指定的天数，使用的是DATE类本身自带的方法，当第二个参数为负数的时候进行减法运算
         * 这样可以避免自己写的方法会出现错误
         * 需要注意的是，此方法中的setDate并不是咱们自定义的方法，而是Date对象自带的方法
         */
        date.setDate(date.getDate()+n);
        return date;
      },
      setDate(date){
        var clen = 7;
        //表示当前已经点击到的日期
        var week = date.getDay()-1,weekAry=[];
        date = this.addDate(date,week*-1);
        this.currentFirstDate = new Date(date);
        //格式化日期
        var formatDate = function(date){
          var year = date.getFullYear()+'-';
          var month = (date.getMonth()+1)+'-';
          var day = date.getDate();
          var week = ['星期天','星期一','星期二','星期三','星期四','星期五','星期六'][date.getDay()];
          return {
            date:year+month+day,
            week:week
          };
        };
        //循环为单元格进行赋值
        for(var i = 0;i<clen;i++){
          var nn=formatDate(i==0 ? date : this.addDate(date,1));
          weekAry.push(nn);
        }
        return weekAry;
      }
    }
  }
</script>
<style>
  .specifiedTurningClass {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .specifiedTurningClass h3 {
    font-size: 1.25rem;
  }

  .specifiedTurningClass .specifiedTurningClass_row {
    margin-top: 2rem;
  }

  .specifiedTurningClass .submittedBtn {
    border-radius: 20px;
    padding: 10px 2rem;
  }

  .specifiedTurningClass .specifiedTurning_body {
    border: 1px solid #d2d2d2;
    border-radius: 5px;
  }

  .specifiedTurningClass .scheduleSearch {
    padding: .5rem 1rem;
  }

  .specifiedTurningClass .scheduleSearch_txt {
    margin-right: 2rem;
  }

  .specifiedTurningClass .specifiedTurning_body .el-select {
    width: 90px;
  }

  .specifiedTurningClass .specifiedTurning_body .el-select + .el-select {
    margin-left: 1rem;
  }

  .specifiedTurningClass .weekBtnList {
    text-align: right;
    font-size: 14px;
  }

  .specifiedTurningClass .weekBtn {
    padding: 0 .5rem;
    color: #4da1ff;
    cursor: pointer;
  }

  .specifiedTurningClass .weekBtn + .weekBtn {
    border-left: 2px solid #d2d2d2;
  }

  .specifiedTurningClass .scheduleContent_head {
    background-color: #89bcf5;
    color: #fff;
  }

  .specifiedTurningClass .scheduleContent_head > div {
    text-align: center;
    font-size: 14px;
    padding: .6rem 0;
  }

  .specifiedTurningClass .scheduleContent_head > div + div {
    border-left: 1px solid #d2d2d2;
  }

  .specifiedTurningClass .scheduleContent_body .scheduleContent_body_row + .scheduleContent_body_row {
    border-top: 1px solid #d2d2d2;
  }

  .specifiedTurningClass .scheduleContent_body .schedule_box + .schedule_box {
    border-left: 1px solid #d2d2d2;
  }

  .specifiedTurningClass .scheduleContent_body .idx_number {
    display: inline-block;
    width: 100%;
    text-align: center;
    font-size: .75rem;
  }

  .specifiedTurningClass .scheduleContent_body .schedule_subject {
    padding: .5rem;
  }

  .specifiedTurningClass .scheduleContent_body .schedule_subject_normal {
    display: inline-block;
    width: 100%;
    text-align: center;
    font-size: 1.125rem;
    font-weight: bold;
    padding: 1.8rem 0;
    border-radius: .5rem;
  }

  .specifiedTurningClass .scheduleContent_body .schedule_subject_use {
    background-color: #13b5b1;
    color: #fff;
    font-size: 1rem;
  }

  .specifiedTurningClass .scheduleContent_body .schedule_subject_unUse {
    background-color: #d2d2d2;
    font-size: 1rem;
  }
</style>
