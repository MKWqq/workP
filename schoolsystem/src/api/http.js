/**
 * Created by wqq on 2017/6/20.
 */
/*import axios from 'axios'
export const loginHTTP=params=>{return axios.get('http://192.168.10.15:8080/123qwe.php')}*/
/*封装发送请求方法*/
const domain='/api/';
const sendAjaxCom=(params,urlS,typeS)=>{return $.ajax({url:domain+urlS,type:typeS,data:params,dataType:'json'}).then(data=>data)};
/*学生信息管理*/
export const studentMessageGradeLoad=params=>{return $.ajax({url:domain+'school/User/getGrade?type=getGradeList',data:params,dataType:'json',type:'post'}).then(data=>data)};
export const studentMessageClassLoad=params=>{return $.ajax({url:domain+'school/User/getGrade?type=getClass',data:params,dataType:'json',type:'get'}).then(data=>data)};
export const studentMessageTypeLoad=params=>{return $.ajax({url:domain+'school/User/getGrade?type=getSelectType',data:params,dataType:'json',type:'get'}).then(data=>data)};
export const studentMessageSearchLoad=params=>{return $.ajax({url:domain+'school/user/userGl?type=studentList',data:params,dataType:'json',type:'get'}).then(data=>data)};
export const studentMessageDelete=params=>{return $.ajax({url:domain+'school/user/userGl?type=deleteStudent',data:params,dataType:'json',type:'post'}).then(data=>data)};
export const studentMessageUpdate=params=>{return $.ajax({url:domain+'school/user/userGl?type=studentPersonalUpdata',data:params,dataType:'json',type:'post'}).then(data=>data)};

/*学生批量导入*/
export const studentImportUpload=params=>{return $.ajax({url:domain+'school/user/userGl?type=export&roleNameEn=xs',data:params,dataType:'json',type:'post'}).then(data=>data)};


/*排课管理---------*/
/*排课管理首页面*/
export const arrangeManageLoad=params=>{return $.ajax({url:domain+'school/Curriculum/pkPlan?type=pkList',dataType:'json',type:'get'}).then(data=>data)};
export const arrangeManageGradeRange=params=>{return $.ajax({url:domain+'school/Curriculum/pkPlan?type=getPkRang',dataType:'json',type:'get'}).then(data=>data)};
export const arrangeManageAdd=params=>{return $.ajax({url:domain+'school/Curriculum/pkPlan?type=pkCreate',data:params,dataType:'json',type:'post'}).then(data=>data)};
export const arrangeManageDelete=params=>{return $.ajax({url:domain+'school/Curriculum/deletePkList?type=pkDelete',data:params,dataType:'json',type:'post'}).then(data=>data)};

/*上课时间设置*/
export const courseSetting=params=>{return $.ajax({url:domain+'school/Curriculum/createPkPlan?type=timeSet',data:params,dataType:'json',type:'post'}).then(data=>data)};

/*教学计划*/
export const teachingPlanLoad=params=>{return $.ajax({url:domain+'school/curriculum/jxPlan?type=jsPlanList',data:params,dataType:'json',type:'get'}).then(data=>data)};
export const teachingPlanCreate=params=>{return $.ajax({url:domain+'school/curriculum/jxPlan?type=createJxPlan',data:params,dataType:'json',type:'post'}).then(data=>data)};

/*班级上课限制表*/
export const classesTimeSettingTable=params=>{return $.ajax({url:domain+'school/Curriculum/limitCreateList?type=classSkTimeLimitList',data:params,dataType:'json',type:'get'}).then(data=>data)};
export const classesTimeSettingGrade=params=>{return $.ajax({url:domain+'school/Curriculum/getGradeAndClass?type=getList',data:params,dataType:'json',type:'get'}).then(data=>data)};
export const classesTimeSettingSaved=params=>{return $.ajax({url:domain+'school/Curriculum/limitCreateList?type=classSkTimeLimit',data:params,dataType:'json',type:'post'}).then(data=>data)};

/*课程上课时间限制*/
export const courseTimeSettingCourseLoad=params=>{return $.ajax({url:domain+'school/Curriculum/getSubjectList?type=pkList',dataType:'json',type:'get'}).then(data=>data)};
export const courseTimeSettingTableLoad=params=>{return $.ajax({url:domain+'school/Curriculum/limitCreateList?type=subjectSkTimeList',data:params,dataType:'json',type:'get'}).then(data=>data)};
export const courseTimeSettingSaved=params=>{return $.ajax({url:domain+'school/Curriculum/limitCreateList?type=subjectSkTimeLimit',data:params,dataType:'json',type:'post'}).then(data=>data)};

/*教师上课时间限制*/
export const teacherTimeSettingTeacherLoad=params=>{return $.ajax({url:domain+'school/Curriculum/getTeacherList?type=pkList',data:params,dataType:'json',type:'get'}).then(data=>data)};
export const teacherTimeSettingTabelLoad=params=>{return $.ajax({url:domain+'school/Curriculum/limitCreateList?type=getTeacherListLimit',data:params,dataType:'json',type:'get'}).then(data=>data)};
export const teacherTimeSettingSaved=params=>{return $.ajax({url:domain+'school/Curriculum/limitCreateList?type=jsSkTimeLimit',data:params,dataType:'json',type:'post'}).then(data=>data)};

/*课程预先安排*/
export const coursePreviousTableLoad=params=>{return $.ajax({url:domain+'school/Curriculum/limitCreateList?type=getArrangementList',data:params,dataType:'json',type:'get'}).then(data=>data)};
export const coursePreviousSaved=params=>{return $.ajax({url:domain+'school/Curriculum/limitCreateList?type=kcArrangement',data:params,dataType:'json',type:'post'}).then(data=>data)};

/*合班上课*/
export const workTogetherTeacherLoad=params=>{return $.ajax({url:domain+'school/curriculum/getSubjectTeacher?type=pkList',data:params,dataType:'json',type:'get'}).then(data=>data)};
export const workTogetherSetting=params=>{return $.ajax({url:domain+'school/Curriculum/limitCreateList?type=createHbKcSet',data:params,dataType:'json',type:'post'}).then(data=>data)};
export const workTogetherGet=params=>{return $.ajax({url:domain+'school/Curriculum/limitCreateList?type=getHbKcSet',data:params,dataType:'json',type:'get'}).then(data=>data)};
/*拆班*/
export const workSelfSet=params=>{return $.ajax({url:domain+'school/Curriculum/limitCreateList?type=delHb',data:params,dataType:'json',type:'post'}).then(data=>data)};

/*得到自动排课*/
export const AutomaticScheduceGet=params=>{return $.ajax({url:domain+'school/Curriculum/zdPk?type=getZdPkList',data:params,dataType:'json',type:'get'}).then(data=>data)};

/*教师考评------*/
export const TeacherEvaluationCreate=params=>{return $.ajax({url:domain+'school/TeacherEvaluate/createEvaluate',data:params,dataType:'json',type:'post'}).then(data=>data)};

/*考评分组*/
/*得到和保存接口*/
export const judgeGroupSave=params=>{return $.ajax({url:domain+'school/TeacherEvaluate/groupOfEvaluate',data:params,dataType:'json',type:'post'}).then(data=>data)};
/*点击新增按钮*/
export const judgeGroupLoad=params=>{return $.ajax({url:domain+'school/TeacherEvaluate/getJudgeGroup',data:params,dataType:'json',type:'post'}).then(data=>data)};








