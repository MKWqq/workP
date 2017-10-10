<template>
  <div class="g-home">
    <div class="g-homeT">
      <div class="g-homeCalendar">
        <div id="homeCalendar1" style="max-width:74.4%;"></div>
        <div id="homeCalendar2" style="max-width:22.1%;"></div>
      </div>
      <div class="g-homeContact">
        <header class="g-contactHeader">通讯录</header>
        <section>
          <div class="g-contactSearch">
            <img src="../assets/img/commonNav/icon_search.png" />
            <input type="text" @input="fuzzySearch" v-model="fuzzySearchText" placeholder="请输入姓名" />
          </div>
          <ul class="g-contactCon">
            <!--v-for data from database-->
            <li class="g-contactRow" v-for="content in fuzzySearchArr">
              <div class="g-contactImg">
                <img src="../assets/img/commonNav/top_touxiang_no.png" />
              </div>
              <div class="g-contactMsg">
                <p class="s-contactText" v-text="content.nameMsg"></p>
                <p class="s-contactPhone" v-text="content.telMsg"></p>
              </div>
            </li>
          </ul>
        </section>
      </div>
    </div>
    <div class="g-homeB">
      <div class="g-homeNotice">
        <header>
          <h2 class="u-NoticeText">通知公告</h2>
          <div class="s-NoticeNew" @click="">
            <div class="u-NoticeImg">
              <img src="../assets/img/commonNav/home_add.png" />
            </div>
            <div class="g-NoticeText">新建通知</div>
          </div>
        </header>
        <section>
          <!--data from database-->
          <!--v-for-->
          <ul class="m-NoticeRow" v-for="n in 10" @click="">
            <li class="m-NoticeMsg">高考动员大会将于6月10日举行</li>
            <li class="m-NoticeDate">2017-05-02</li>
            <li class="m-NoticeHour">17:00:00</li>
          </ul>
        </section>
      </div>
      <div class="g-homeThing">
        <header>
          <h2 class="u-NoticeText">待办事项</h2>
        </header>
        <section id="ThingPart">
          <!--data from database-->
          <!--v-for-->
          <div class="m-ThingRow" v-for="n in 5">
            <div class="m-ThingL">
              <h2 class="m-ThingLHeader">#用车申请#</h2>
              <div class="m-ThingLPrompt">
                <p class="m-ThingLPMsg">到xx中学考察用车</p>
                <p class="m-ThingLPDate">2017/07/12</p>
                <p class="m-ThingLPHour">08:10:12</p>
              </div>
            </div>
            <div class="m-ThingR">杨升昊</div>
          </div>
        </section>
      </div>
      <div class="g-homeExpressway">
        <header>
          <h2 class="u-NoticeText">快速通道</h2>
        </header>
        <section>
          <!--overflow:hidden-->
          <div class="g-ExpresswayBanner">
            <ul class="j-ExpresswayBanner">
              <!--data from database-->
              <!--one page-->
              <!--v-for-->
              <li class="j-Page" v-for="n in expresswayPage">
                <!--v-for-->
                <p><span>{{n}}中国教育信息网</span></p>
                <p><span>四川教育网</span></p>
                <p><span>学信网</span></p>
                <p><span>百度</span></p>
              </li>
            </ul>
          </div>
        </section>
        <footer>
          <!--page=1 display:none-->
          <ul>
            <!--v-for page-->
            <li v-for="n in expresswayPage" :data-index="n-1" :style="{background:expresswayFooter[n-1]?'#ff5b5b':'#c9c9c9'}" @click="changeExpressPage"></li>
          </ul>
        </footer>
      </div>
    </div>
    <div class="g-promptBox">
      <el-dialog class="scheduleDialog" title="新增日程" size="tiny" :modal="false" :visible.sync="isNewScheduleForm">
        <el-form ref="form" label-position="right" label-width="75px" :model="newScheduleForm">
          <el-form-item label="标题:">
            <el-input v-model="newScheduleForm.title"></el-input>
          </el-form-item>
          <el-form-item label="日程类型:">
            <el-select v-model="newScheduleForm.type">
              <el-option label="会议" value="1"></el-option>
              <el-option label="升旗仪式" value="2"></el-option>
              <el-option label="考试" value="3"></el-option>
              <el-option label="集会" value="4"></el-option>
              <el-option label="课程" value="5"></el-option>
              <el-option label="班级活动" value="6"></el-option>
              <el-option label="教职工活动" value="7"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="通知范围:">
            <el-checkbox-group v-model="newScheduleForm.range">
              <el-checkbox label="自己" name="range"></el-checkbox>
              <el-checkbox label="职工" name="range"></el-checkbox>
              <el-checkbox label="教师" name="range"></el-checkbox>
              <el-checkbox label="家长" name="range"></el-checkbox>
            </el-checkbox-group>
          </el-form-item>
          <el-form-item label="开始时间:">
          <el-col :span="11">
            <el-date-picker type="date" placeholder="选择日期" v-model="newScheduleForm.startDate1" style="width: 100%;"></el-date-picker>
          </el-col>
          <el-col class="line" :span="2">-</el-col>
          <el-col :span="11">
            <el-time-picker type="fixed-time" placeholder="选择时间" v-model="newScheduleForm.startDate2" style="width: 100%;"></el-time-picker>
          </el-col>
        </el-form-item>
          <el-form-item label="结束时间:">
            <el-col :span="11">
              <el-date-picker type="date" placeholder="选择日期" v-model="newScheduleForm.endDate1" style="width: 100%;"></el-date-picker>
            </el-col>
            <el-col class="line" :span="2">-</el-col>
            <el-col :span="11">
              <el-time-picker type="fixed-time" placeholder="选择时间" v-model="newScheduleForm.endDate1" style="width: 100%;"></el-time-picker>
            </el-col>
          </el-form-item>
          <el-form-item label="内容:">
            <el-input type="textarea" v-model="newScheduleForm.content"></el-input>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button class="scheduleConfirm" type="primary" @click="isNewScheduleForm = false">确 定</el-button>
          <el-button class="scheduleCancel" @click="isNewScheduleForm = false">取 消</el-button>
        </div>
      </el-dialog>
      <el-dialog class="scheduleDialog" title="编辑日程" size="tiny" :modal="false" :visible.sync="isHandlerSchefule">
        <el-form ref="form2" label-position="right" label-width="80px" :model="handlerSchedule">
          <el-form-item label="标题:">
            <el-input v-model="handlerSchedule.title"></el-input>
          </el-form-item>
          <el-form-item label="日程类型:">
            <el-select v-model="handlerSchedule.type">
              <el-option label="会议" value="1"></el-option>
              <el-option label="升旗仪式" value="2"></el-option>
              <el-option label="考试" value="3"></el-option>
              <el-option label="集会" value="4"></el-option>
              <el-option label="课程" value="5"></el-option>
              <el-option label="班级活动" value="6"></el-option>
              <el-option label="教职工活动" value="7"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="开始时间:">
            <el-col :span="11">
              <el-date-picker type="date" placeholder="选择日期" v-model="handlerSchedule.startDate1"></el-date-picker>
            </el-col>
            <el-col class="line" :span="2">-</el-col>
            <el-col :span="11">
              <el-date-picker type="fixed-time" placeholder="选择时间" v-model="handlerSchedule.startDate2"></el-date-picker>
            </el-col>
          </el-form-item>
          <el-form-item label="结束时间:">
            <el-col :span="11">
              <el-date-picker v-model="handlerSchedule.endDate1" placeholder="选择日期" type="date"></el-date-picker>
            </el-col>
            <el-col :span="2" class="line">-</el-col>
            <el-col :span="11">
              <el-date-picker v-model="handlerSchedule.endDate2" placeholder="选择时间" type="fixed-time"></el-date-picker>
            </el-col>
          </el-form-item>
          <el-form-item label="内容:">
            <el-input type="textarea" v-model="handlerSchedule.content"></el-input>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button class="scheduleConfirm" type="primary" @click="isHandlerSchefule=false">确定</el-button>
          <el-button class="scheduleCancel" @click="isHandlerSchefule=false">取消</el-button>
        </div>
      </el-dialog>

<!--        <div class="g-newScheduleL">
          <footer class="g-newScheduleFooter"></footer>
        </div>-->
        <!--<img src="../assets/img/commonNav/btn_close_n.png" />-->
    </div>
  </div>
</template>
<script>
import '@/../static/fullcalendar/fullcalendar.css'
//import '@/../static/fullcalendar/fullcalendar.print.css'
import '../../static/fullcalendar/moment.min'
import '../../static/fullcalendar/fullcalendar.min.js'
import {fuzzyQuery} from '../assets/js/fuzzyQuery'
export default{
  data(){
      return {
        isNewScheduleForm:false,
        isHandlerSchefule:false,
        fuzzySearchData:[
          {
            imgMsg:'',
            nameMsg:'傻逼',
            telMsg:'15254893666'
          },
          {
            imgMsg:'',
            nameMsg:'皮特',
            telMsg:'15899899886'
          },
          {
            imgMsg:'',
            nameMsg:'皮帅',
            telMsg:'15899899886'
          }
        ],
        fuzzySearchText:'',
        fuzzySearchArr:[],
        expresswayPage:3,
        prevActivePage:0,
        expresswayFooter:[],
        newScheduleForm:{
          title:'',
          type:'',
          range:'',
          startDate1:null,//年月日
          startDate2:null,
          endDate1:null,
          endDate2:null,
          content:''
        },
        handlerSchedule:{
          title:'',
          type:'',
          startDate1:null,//年月日
          startDate2:null,
          endDate1:null,
          endDate2:null,
          content:''
        },
        homeCalendar2_initDate:new Date()
      }
  },
  methods:{
    changeExpressPage(event){
      const e=$(event.srcElement||event.target);
      /*change footer li css*/
      this.expresswayFooter.forEach((value,index,arr)=>{
        if(Number(e.attr('data-index'))==index){
          this.$set(arr,index,true);
        }else{
          this.$set(arr,index,false);
        }
      });
      this.showActivePage(Number(e.attr('data-index')));
    },
    showActivePage(activePage){
      $('li.j-Page').eq(activePage).animate({zIndex:'2',left:'0rem'},300);
      $('li.j-Page').eq(this.prevActivePage).animate({zIndex:'1',left:'-16.5rem'},300).animate({zIndex:'1',left:'16.5rem'},0);
      this.prevActivePage=activePage;
    },
    initExpressway(){
      /*define expressway footer number*/
      for(let i=0,len=this.expresswayPage;i<len;i++){
        if(i==0){
          this.expresswayFooter.push(true);
        }else{
          this.expresswayFooter.push(false);
        }
      }
    },
    showNewSchedule(){
      this.isNewScheduleForm=true;
    },
    showHandlerSchedule(eventObj){
      console.log(eventObj);
      this.isHandlerSchefule=true;
    },
    fuzzySearch(){
      if(this.fuzzySearchText.length>0){
        this.fuzzySearchArr=fuzzyQuery(this.fuzzySearchText, this.fuzzySearchData);
      }else{
        this.fuzzySearchArr=this.fuzzySearchData;
      }
    }
  },
  mounted(){
    $('#ThingPart').mCustomScrollbar();
//    $('.g-contactCon').mCustomScrollbar();
    $('.g-homeNotice section').mCustomScrollbar();
    /*fullCalendar插件*/
    const date=new Date();
    $('#homeCalendar1').fullCalendar({
      locale:'en',
      header:{
        left:'prev,next',
        center:'title',
        right: 'month,agendaWeek,agendaDay'
      },
      /*MMMM的显示文字*/
      monthNames:['1','2','3','4','5','6','7','8','9','10','11','12'],
      /*dddd的显示文字*/
      dayNames:['日','一','二','三','四','五','六'],
/*      titleFormat:'YYYY年MMMM月',//日历头部文本显示信息
      columnFormat:'dddd M/D'||'M月d日 dddd'||'M月d日 dddd',//设置列【表头】显示文本*/
      views:{
        /*设置月、周、日title和column各自的显示文本*/
        month:{titleFormat:'YYYY年MMMM月',columnFormat:'D'},
        week:{titleFormat:'YYYY年MMMM月D日',columnFormat:'dddd M/D'},
        day:{titleFormat:'YYYY年MMMM月D日',columnFormat:'星期dddd'}
      },
      allDayText:'全天',//设置日中allDay的文本
      buttonText:{
        today:'今天',
        month:'月',
        week:'周',
        day:'日'
      },
      aspectRatio:2.27/*2.27*/,//宽高比
      weekMode:'liquid',//月视图的显示模式，fixed：固定显示6周高；liquid：高度随周数变化；variable: 高度固定
      dayClick:function(data){
        /*点击日历中的天【一个单元格】触发的事件*/
        console.log('时间为：', data.format());
      },
      eventClick:function(event){
        /*点击日程触发的事件*/
        /*跳转到event.start时间上*/
        const eventFormat=$.fullCalendar.moment(event.start).format();
        let eventDate=null;
        if(eventFormat.search('T')>0){
            eventDate=new Date(eventFormat.replace(/T/,' '));
        }else{
            eventDate=new Date(eventFormat);
        }
        $('#homeCalendar2').fullCalendar('gotoDate',eventDate);
      },
      eventMouseover:function(event){
          /*移入日程触发的事件*/
//          console.log('移入事件名：', event.title);
      },
      eventMouseout:function(event){
          /*移除日程触发的事件*/
//          console.log('移除事件名：',event.title);
      },
      defaultDate: '2017-05-07',
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      /*events可为array，可为function，在请求返回数据为json的arr，也可为json*/
      /*updateEvent事件$('#calendar').fullCalendar('refetchEvents'); //重新获取所有事件数据 */
      events: [
        {
          title: 'All Day Event',
          start: '2017-05-01'
        },
        {
          title: '123',
          start: '2017-05-01'
        },
        {
          title: '789',
          start: '2017-05-01'
        },
        {
          title: 'Long Event',
          start: '2017-05-07',
          end: '2017-05-10'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2017-05-09T16:00:00'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2017-05-16T16:00:00'
        },
        {
          title: 'Conference',
          start: '2017-05-11',
          end: '2017-05-13'
        },
        {
          title: 'Meeting',
          start: '2017-05-12T10:30:00',
          end: '2017-05-12T12:30:00'
        },
        {
          title: 'Lunch',
          start: '2017-05-12T12:00:00'
        },
        {
          title: 'Meeting',
          start: '2017-05-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2017-05-12T17:30:00'
        },
        {
          title: 'Dinner',
          start: '2017-05-12T20:00:00'
        },
        {
          title: 'Birthday Party',
          start: '2017-05-13T07:00:00'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2017-05-28'
        }
      ],
 /*     events: function(start, end, timezone, callback) {
        $.ajax({
          url: 'myxmlfeed.php',
          dataType: 'xml',
          data: {
            // our hypothetical feed requires UNIX timestamps
            start: start.unix(),
            end: end.unix()
          },
          success: function(doc) {
            var events = [];
            $(doc).find('event').each(function() {
              events.push({
                title: $(this).attr('title'),
                start: $(this).attr('start') // will be parsed
              });
            });
            callback(events);
          }
        });
      },*/
      eventBorderColor:'#ef2727',
      eventBackgroundColor:'#fff',
      eventTextColor:'red'
    });
    $('#homeCalendar2').fullCalendar({
      locale:'en',
      customButtons: {            //自定义header属性中按钮[customButtons与header并用]
        myCustomButton: {
          text: '新建日程',
          click: this.showNewSchedule/*显示新建日程弹框*/
        }
      },
      header:{
        left:'prev,next',
        right:'today,myCustomButton'
      },
      /*MMMM的显示文字*/
      monthNames:['1','2','3','4','5','6','7','8','9','10','11','12'],
      columnFormat:'YYYY/MMMM/DD 日程安排',//设置列【表头】显示文本
      buttonText:{
        today:'今天'
      },
      aspectRatio:0.7/*2.27*/,//宽高比
      weekMode:'liquid',//月视图的显示模式，fixed：固定显示6周高；liquid：高度随周数变化；variable: 高度固定
      defaultView:'basicDay',//控制日历content部分内容，会影响today点击效果
      eventClick:this.showHandlerSchedule,/*点击日程触发的事件*/
      isLoading:true,
      defaultDate:'2017-05-07',
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      /*events可为array，可为function，在请求返回数据为json的arr，也可为json*/
      events: [
        {
          title: 'All Day Event',
          start: '2017-05-01',
          content:'123'
        },
        {
          title: '123',
          start: '2017-05-01'
        },
        {
          title: '789',
          start: '2017-05-01'
        },
        {
          title: 'Long Event',
          start: '2017-05-07',
          end: '2017-05-10'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2017-05-09T16:00:00'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2017-05-16T16:00:00'
        },
        {
          title: 'Conference',
          start: '2017-05-11',
          end: '2017-05-13'
        },
        {
          title: 'Meeting',
          start: '2017-05-12T10:30:00',
          end: '2017-05-12T12:30:00'
        },
        {
          title: 'Lunch',
          start: '2017-05-12T12:00:00'
        },
        {
          title: 'Meeting',
          start: '2017-05-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2017-05-12T17:30:00'
        },
        {
          title: 'Dinner',
          start: '2017-05-12T20:00:00'
        },
        {
          title: 'Birthday Party',
          start: '2017-05-13T07:00:00'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2017-05-28'
        }
      ],
      eventBorderColor:'#ef2727',
      eventBackgroundColor:'#fff',
      eventTextColor:'red'
    });
  },
  created(){
    /*define bar by myself*/
    this.initExpressway();
    this.fuzzySearchArr=this.fuzzySearchData;
  }
}
</script>
<style lang="less" scoped>
  @import '../style/Home';
</style>






