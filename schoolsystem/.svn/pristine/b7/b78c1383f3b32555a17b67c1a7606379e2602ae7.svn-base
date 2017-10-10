<template>
    <div class="examManagement">
      <el-row type="flex" justify="center">
        <el-col :span="24">
          <h3>考试管理</h3>
        </el-col>
      </el-row>
      <el-row class="em-top">
        <el-col :span="24">
          <el-col :span="12">
            <el-col :span="10">
              <div class="em-top-grade">
                <el-col :span="5" class="em-top-text">年级：</el-col>
                <el-col :span="12">
                  <el-select v-model="gradevalue" class="el-select" @change="changeGrade">
                    <el-option
                      v-for="item in gradeoptions"
                      :key="item.gradeid"
                      :value="item.gradeid"
                      :label="item.name">
                    </el-option>
                  </el-select>
                </el-col>
              </div>
            </el-col>
            <el-col :span="10" style="margin-left: -3rem">
              <div class="em-top-exam">
                <el-col :span="5" class="em-top-text">考试：</el-col>
                <el-col :span="19">
                  <el-select v-model="examvalue" class="el-select2">
                    <el-option
                      v-for="(item,index) in examoptions"
                      :key="item.index"
                      :value="item.examinationid"
                      :label="item.examination">
                    </el-option>
                  </el-select>
                </el-col>
              </div>
            </el-col>
          </el-col>
          <el-col :span="8" :offset="4">
            <div class="em-top-describe">
              <el-col :span="5">
                <div class="em-top-describe-1">
                  <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_not-editable.png" alt="">
                  <span>不可编辑</span>
                </div>
              </el-col>
              <el-col :span="5">
                <div class="em-top-describe-1">
                  <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_completed.png" alt="">
                  <span>已完成</span>
                </div>
              </el-col>
              <el-col :span="5">
                <div class="em-top-describe-1">
                  <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_mainflow.png" alt="">
                  <span>主要流程</span>
                </div>
              </el-col>
              <el-col :span="5">
                <div class="em-top-describe-1">
                  <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_minor.png" alt="">
                  <span>次要流程</span>
                </div>
              </el-col>
              <el-col :span="4">
                <div class="em-top-describe-1">
                  <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_nonactivated.png" alt="">
                  <span>未激活</span>
                </div>
              </el-col>
            </div>
          </el-col>
        </el-col>
      </el-row>
      <el-row style=" height: 36rem;">
        <!--第一行-->
       <el-col :span="24">
         <div class="em-flow-1">
           <el-col :span="5">
             <el-col :span="19">
               <div class="em-flow-1-div em-flow-1-div-gray">2016级高一下学期期末考试</div>
             </el-col>
             <el-col :span="5">
               <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows5.png"
                    alt="">
             </el-col>
           </el-col>
           <el-col :span="5">
             <el-col :span="19">
               <router-link class="em-flow-1-div em-flow-1-div-green" :to="{name:'testNumberSetting',params:{gradeid:gradevalue,examinationid:examvalue}}" tag="div">
                 考号设置
               </router-link>
             </el-col>
             <el-col :span="5">
               <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows3.png"
                    alt="">
             </el-col>
           </el-col>
           <el-col :span="5">
             <el-col :span="19">
               <div class="em-flow-1-div em-flow-1-div-gray">学生考试</div>
             </el-col>
             <el-col :span="5">
               <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows5.png"
                    alt="">
             </el-col>
           </el-col>
           <el-col :span="5">
             <el-col :span="19">
               <router-link class="em-flow-1-div em-flow-1-div-green" to="/examManagerHome/importGrades" tag="div">导入成绩</router-link>
             </el-col>
             <el-col :span="5">
               <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows3.png"
                    alt="">
             </el-col>
           </el-col>
           <el-col :span="4">
             <el-col :span="19">
               <router-link class="em-flow-1-div em-flow-1-div-blue" to="/examManagerHome/releaseResults" tag="div">发布成绩</router-link>
             </el-col>
           </el-col>
         </div>
       </el-col>
        <!--第二行-->
       <el-col :span="24">
         <el-col :span="4" style="text-align: center;padding-top: 2rem">
           <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows8.png" alt="">
         </el-col>
         <el-col :span="20">
           <div class="em-flow-2">
             <el-col :span="4">
               <img class="em-flow-2-1" src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows2.png" alt="">
             </el-col>
             <el-col :span="3">
               <img class="em-flow-2-2" src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows4.png" alt="">
             </el-col>
             <el-col :span="3">
               <img class="em-flow-2-3" src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows2.png" alt="">
             </el-col>
             <el-col :span="6">
               <img class="em-flow-2-4" src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows2.png" alt="">
             </el-col>
             <el-col :span="3">
               <img class="em-flow-2-5" src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows4.png" alt="">
             </el-col>
             <el-col :span="3">
               <img class="em-flow-2-6" src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows2.png" alt="">
             </el-col>
           </div>
           <el-col :span="24">
             <div class="em-flow-3">
               <el-col :span="1" style="margin-left: -0.8rem">
                 <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows5.png" alt="">
               </el-col>
               <el-col :span="6" style="margin-left: 0.5rem">
                 <router-link class="em-flow-1-div em-flow-1-div-minor" :to="{name:'confirmStatus',params:{examinationid:examvalue}}" tag="div">各班参考学生确认</router-link>
               </el-col>
               <el-col :span="6" style="margin-left: 0.3rem">
                 <router-link class="em-flow-1-div em-flow-1-div-minor" to="/examManagerHome/testReportPrinting" tag="div">考务报表打印</router-link>
               </el-col>
               <el-col :span="6">
                 <router-link class="em-flow-1-div em-flow-1-div-minor" to="/examManagerHome/studentTestAlone" tag="div">学生单独参考</router-link>
               </el-col>
               <el-col :span="5">
                 <router-link class="em-flow-1-div em-flow-1-div-minor" to="/examManagerHome/testScribing" tag="div">考试划线</router-link>
               </el-col>
             </div>
           </el-col>
           <el-col :span="11">
             <div class="em-flow-4">
               <el-col :span="7">
                 <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows6.png" alt="">
               </el-col>
               <el-col :span="14" style="margin-left: -0.5rem">
                 <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows6.png" alt="">
               </el-col>
             </div>
             <div class="em-flow-5">
               <el-col :span="7" :offset="2">
                 <router-link class="em-flow-1-div em-flow-1-div-minor em-flow-1-div-5" :to="{name:'examinationDistribution',params:{examinationid:examvalue}}" tag="div">考场分配</router-link>
               </el-col>
               <el-col :span="6" style="padding-top: 0.5rem;padding-left:-0.8rem">
                 <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows5.png" alt="">
               </el-col>
               <el-col :span="7" style="padding-left: 1.8rem">
                 <router-link class="em-flow-1-div em-flow-1-div-minor" to="/examManagerHome/candidatesArrangement" tag="div">考生安排</router-link>
               </el-col>
             </div>
             <div class="em-flow-6">
               <el-col :span="7" style="padding-top: 1rem">
                 <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows6.png" alt="">
               </el-col>
             </div>
           </el-col>
           <el-col :span="12" style="padding-left:4rem">
             <img class="em-flow-6-1" src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows1.png" alt="">
           </el-col>
         </el-col>
      </el-col>
        <!--第三行-->
        <el-col :span="24">
          <div class="em-flow-1">
           <el-col :span="5">
             <el-col :span="19">
               <router-link class="em-flow-1-div em-flow-1-div-minor" to="/examManagerHome/testTime" tag="div">各科目参考时间</router-link>
             </el-col>
             <el-col :span="5">
               <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows5.png" alt="">
             </el-col>
           </el-col>
            <el-col :span="5">
              <el-col :span="19">
                <router-link class="em-flow-1-div em-flow-1-div-minor" to="/examManagerHome/invigilatorTask" tag="div">监考任务</router-link>
              </el-col>
              <el-col :span="5">
                <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/ic_arrows5.png" alt="">
              </el-col>
            </el-col>
            <el-col :span="5">
              <el-col :span="19">
                <router-link to="/examManagerHome/proctorArrangementArts" tag="div" class="em-flow-1-div em-flow-1-div-minor">监考安排</router-link>
              </el-col>
            </el-col>
          </div>
        </el-col>
      </el-row>
    </div>
</template>
<script>
  import req from '../../../../../assets/js/common'
    export default{
      data() {
        return {
          gradeoptions: [],
          gradevalue: '',
          examoptions: [],
          examvalue: ''
        }
      },
      created(){
          let param={};
          var self=this;
        req.ajaxSend('/school/Examination/exmanagement/type/interface/typename/exselect','post',param,(res)=>{
          console.log(res);
          self.gradeoptions=res;
          self.gradevalue=res[0].gradeid;
          self.examoptions=res[0].ex;
          self.examvalue=res[0].ex[0].examinationid;
        })
      },
      methods:{
        changeGrade(){
            for(let obj of this.gradeoptions){
              if(obj.gradeid==this.gradevalue){
                  this.examoptions=obj.ex;
                  this.examvalue=obj.ex[0].examinationid;
                }
            }
        }
      }
    }
</script>
<style>
.em-top{
  margin-top:2.0625rem;
  height:9.1875rem;
}
  .em-top-text{
    padding-top: 0.5rem;
  }
.em-flow-1-div{
  width: 15rem;
  height: 2.35rem;
  color: #fff;
  font-size: 13px;
  text-align: center;
  line-height: 2.35rem;
  border-radius: 1.1rem;
  float: left;
  cursor: pointer;
}
.em-flow-1-div-gray{
  background: #d2d2d2;
  cursor: auto;
}
.em-flow-1-div-green{
  background: #13b5b1;
}
.em-flow-1-div-blue{
  background: #4da1ff;
}
  .em-flow-1 img{
    padding-top: 0.5rem;
    padding-left: 0.3rem;
  }
.em-flow-2{
  height: 2.875rem;
  padding: 0.9rem 0;
  margin-left: -3rem;
}
.em-flow-1-div-minor{
  background: #89bcf5;
}
  .em-flow-3,.em-flow-4,.em-flow-2,.em-flow-5,.em-flow-6{
    text-align: right;
  }
  .em-flow-4{
    padding: 1rem 0;
  }
.em-flow-5{
  margin-top: 2.5rem;
 }
</style>
