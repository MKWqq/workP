<template>
  <div class="g-AutomaticScheduce">
    <header class="g-timeHeader">
      <el-button class="g-gobackChart RedButton" @click="goBackChart">
        <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_return.png" />
        返回流程图
      </el-button>
      <el-button class="g-gobackChart blueButton" @click="saveSetting">
        <img src="../../../../assets/img/schManagementSystem/teachingAdministration/arrangeClasses/icon_paike.png" />
        一键排课
      </el-button>
    </header>
    <section class="g-classesTimeSetSection">
      <ul class="clear_fix">
        <li>
          <header>排课范围</header>
          <section>
            <p class="pkRange pkFloat" v-for="content in LoadData.pkRange" v-text="content"></p>
          </section>
        </li>
        <li>
          <header>周课时</header>
          <section>
            <p class="weekRow"><span>上课天数:</span><span v-if="LoadData.weekAndCount" v-text="LoadData.weekAndCount.days"></span></p>
            <p class="weekRow"><span>上课节数:</span><span v-if="LoadData.weekAndCount" v-text="LoadData.weekAndCount.count"></span></p>
          </section>
        </li>
        <li>
          <header>班级不排</header>
          <section>
            <p class="teacherRow pkFloat" v-for="content in LoadData.classLimit" v-text="content"></p>
          </section>
        </li>
        <li>
          <header>教师不排</header>
          <section>
            <p class="teacherRow pkFloat" v-for="content in LoadData.teacherLimit" v-text="content"></p>
          </section>
        </li>
        <li>
          <header>科目不排</header>
          <section>
            <p class="weekRow" v-for="content in LoadData.subjectLimitReturn"><span v-text="content.curriculumName"></span><span v-text="content.data"></span></p>
          </section>
        </li>
        <li>
          <header>科目预排</header>
          <section>
            <div class="previousRow clear_fix" v-for="(content,index) in LoadData.yP">
              <p class="previousSubject pkFloat" v-text="content.name+'：'"></p>
              <div class="previousCloumn clear_fix">
                <p class="previousCell pkFloat" v-for="(childContent,childIndex) in content.data " v-text="childContent"></p>
              </div>
            </div>
          </section>
        </li>
        <li>
          <header>合班教学</header>
          <section>
            <div class="previousRow clear_fix" v-for="(content,index) in LoadData.hbClass">
              <p class="previousSubject pkFloat" v-text="content.subject"></p>
              <div class="previousCloumn workTogetherCloumn clear_fix">
                <p class="previousCell pkFloat" v-for="(childContent,childIndex) in content.data " v-text="childContent"></p>
              </div>
            </div>
          </section>
        </li>
      </ul>
    </section>
  </div>
</template>
<script>
  import {mapState} from 'vuex'
  import {classesTimeSettingGrade,//得到班级年级
    classesTimeSettingSaved,//保存时间限制
    AutomaticScheduceGet,//得到自动排课信息
  } from '@/api/http'
  export default{
    data(){
      return{
        /*table数据请求所需参数*/
        gradeId:'',
        gradeName:'',
        classId:'',
        className:'',
        /*ajax数据*/
        LoadData:[],
        /*年级显示转换*/
        gradeData:['一年级','二年级','三年级','四年级','五年级','六年级','初一','初二',
          '初三','高一','高二','高三'
        ],
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
      /*send Ajax=====*/
      /*保存*/
      saveSetting(){
        classesTimeSettingSaved({pkListId:this.pkListId,gradeId:this.gradeId,classId:this.classId,className:this.className,gradeName:this.gradeName,data:this.classesTimeSetTable}).then(data=>{
          if(data.statu==1){
            this.$message({
              message:'保存成功!',
              type:'success'
            });
            /*this.getTableData();*/
          }else{
            this.$message.error('保存失败!');
          }
        })
      },
      /*得到自动排课数据*/
      getLoadData(){
        AutomaticScheduceGet({pkListId:this.pkListId}).then(data=>{
          this.LoadData=this.handlerData(data).classSet;
          console.log(data);
        })
      },
      /*处理数据*/
      handlerData(data){
        if(data.statu){
          return data;
        }else{
          this.$alert('加载失败,请重新加载页面!','提示',{
            confirmButtonText:'确定',
            type:'error',
            callback:action=>{}
          });
        }
      },
    },
    created(){
      this.getLoadData();
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/arrangeClasses/AutomaticScheduce';
  @import '../../../../style/arrangeClasses/arrangeClasses.css';
</style>




