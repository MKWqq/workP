import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);
export default new Router({
  routes: [
    {
      path: '/',
      component: resolve => require(['@/page/Home'], resolve)
    },
    {
      path:'/Home',     //主页
      name:'Home',
      component:resolve => require(['@/page/Home'], resolve)
    },
    /*wqq-排课管理*/
    {
      path:'/arrangeManage',  //校园管理/教学教务/排课管理
      name:'arrangeManage',
      component:resolve=>require(['@/page/schManagementSystem/teachingAdministration/ArrangingClasses/arrangeManage.vue'],resolve)
    },
    {
      path:'/examinationChart',  //校园管理/教学教务/排课管理
      name:'examinationChart',
      component:resolve=>require(['@/page/schManagementSystem/teachingAdministration/ArrangingClasses/examinationChart.vue'],resolve)
    },
    {
      path: '/timeSetting',//上课时间限制
      name: 'timeSetting',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ArrangingClasses/timeSetting.vue'], resolve)
    },
    {
      path: '/importCourse',//导入课程
      name: 'importCourse',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ArrangingClasses/importCourse.vue'], resolve)
    },
    {
      path: '/teachingPlan',//教学计划
      name: 'teachingPlan',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ArrangingClasses/teachingPlan.vue'], resolve)
    },
    {
      path: '/classesTimeSetting',//班级上课时间限制
      name: 'classesTimeSetting',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ArrangingClasses/classesTimeSetting.vue'], resolve)
    },
    {
      path: '/workTogetherTimeSetting',//合班上课时间限制
      name: 'workTogetherTimeSetting',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ArrangingClasses/workTogetherTimeSetting.vue'], resolve)
    },
    {
      path: '/courseTimeSetting',//课程上课时间限制
      name: 'courseTimeSetting',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ArrangingClasses/courseTimeSetting.vue'], resolve)
    },
    {
      path: '/coursePrevious',//课程预先安排
      name: 'coursePrevious',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ArrangingClasses/coursePrevious.vue'], resolve)
    },
    {
      path: '/teacherTimeSetting',//教师上课时间限制
      name: 'teacherTimeSetting',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ArrangingClasses/teacherTimeSetting.vue'], resolve)
    },
    {
      path:'/AutomaticScheduce',//自动排课
      name:'AutomaticScheduce',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ArrangingClasses/AutomaticScheduce.vue'], resolve)
    },
    {
      path:'/ManualScheduce',//手动排课
      name:'ManualScheduce',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ArrangingClasses/ManualScheduce.vue'], resolve)
    },
    {
      path:'/PublishCourse',//发布课程
      name:'PublishCourse',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ArrangingClasses/PublishCourse.vue'], resolve)
    },
    {
      path:'/classSchedule',//课程表
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ArrangingClasses/classSchedule.vue'], resolve),
      children:[
        {
          path:'/',//班级课表
          name:'classesSchedule',
          component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ArrangingClasses/classSchedule/classesSchedule.vue'], resolve)
        },
        {
          path:'teacherSchedule',//教师课表
          name:'teacherSchedule',
          component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ArrangingClasses/classSchedule/teacherSchedule.vue'], resolve)
        },
        {
          path:'totalSchedule',//总课表
          name:'totalSchedule',
          component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ArrangingClasses/classSchedule/totalSchedule.vue'], resolve)
        }
      ]
    },
    /*教研管理-------*/
    /*学生综合素养*/
    /*方案管理*/
    {
      path:'/programManagement',//方案管理
      name:'programManagement',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/studentLiteracy/programManagement.vue'], resolve)
    },
    {
      path:'/literacyAssess',//素养考核方向
      name:'literacyAssess',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/studentLiteracy/literacyAssess.vue'], resolve)
    },
    {
      path:'/handleLiteracyAssess',//编辑考核方向
      name:'handleLiteracyAssess',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/studentLiteracy/handleLiteracyAssess.vue'], resolve)
    },
    {
      path:'/AssessDetail',//考核明细
      name:'AssessDetail',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/studentLiteracy/AssessDetail.vue'], resolve)
    },
    {
      path:'/AverageStatistic',//均分统计
      name:'AverageStatistic',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/studentLiteracy/AverageStatistic.vue'], resolve)
    },
    {
      path:'/assessScore',//学生素养评分
      name:'assessScore',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/studentLiteracy/assessScore.vue'], resolve)
    },
    {
      path:'/integratedAssessScore',//综合素养成绩
      name:'integratedAssessScore',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/studentLiteracy/integratedAssessScore.vue'], resolve)
    },
    /*教师考评*/
    {
      path:'/newEvaluation',//新建考评
      name:'newEvaluation',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/teacherEvaluation/newEvaluation.vue'], resolve)
    },
    {
      path:'/evaluationManagement',//考评管理
      name:'evaluationManagement',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/teacherEvaluation/evaluationManagement.vue'], resolve)
    },
    {
      path:'/judgesGroup',//评委分组
      name:'judgesGroup',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/teacherEvaluation/judgesGroup.vue'], resolve)
    },
    {
      path:'/evaluationGroup',//考评分组
      name:'evaluationGroup',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/teacherEvaluation/evaluationGroup.vue'], resolve)
    },
    {
      path:'/addEvaluationPerson',//添加被评人员
      name:'addEvaluationPerson',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/teacherEvaluation/addEvaluationPerson.vue'], resolve)
    },
    {
      path:'/addJudges',//添加评委
      name:'addJudges',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/teacherEvaluation/addJudges.vue'], resolve)
    },
    {
      path:'/statisticalAnalysis',//统计分析
      name:'statisticalAnalysis',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/teacherEvaluation/statisticalAnalysis.vue'], resolve)
    },
    {
      path:'/evaluationRecord',//考评记录
      name:'evaluationRecord',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/teacherEvaluation/evaluationRecord.vue'], resolve)
    },
    {
      path:'/judgesScoring',//考评打分
      name:'judgesScoring',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/teacherEvaluation/judgesScoring.vue'], resolve)
    },
    {
      path:'/evaluationProgress',//考评进度跟踪
      name:'evaluationProgress',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/teacherEvaluation/evaluationProgress.vue'], resolve)
    },
    {
      path:'/changeEvaluationProgram',//修改评分方案
      name:'changeEvaluationProgram',
      component: resolve => require(['@/page/schManagementSystem/researchManagement/teacherEvaluation/changeEvaluationProgram.vue'], resolve)
    },
    /*wqq-学生管理*/
    {
      path:'/studentMessage',
      name:'studentMessage',
      component:resolve=>require(['@/page/schManagementSystem/baseSettings/userManager/student/studentMessage'],resolve)
    },
    {
      path:'/studentImport',
      name:'studentImport',
      component:resolve=>require(['@/page/schManagementSystem/baseSettings/userManager/student/studentImport'],resolve)
    },
    {
      path:'/studentManager',
      name:'studentManager',
      component:resolve=>require(['@/page/schManagementSystem/baseSettings/userManager/student/studentManager.vue'],resolve)
    },
    {
      path:'/studentRecord',
      name:'studentRecord',
      component:resolve=>require(['@/page/schManagementSystem/baseSettings/userManager/student/studentRecord.vue'],resolve)
    },
    {
      path:'/studentStatistics',
      name:'studentStatistics',
      component:resolve=>require(['@/page/schManagementSystem/baseSettings/userManager/student/studentStatistics.vue'],resolve)
    },
    /*新生管理*/
    {
      path:'/newStudentmanagement',//新生管理
      name:'newStudentmanagement',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/newStudentmanagement.vue'],resolve)
    },
    {
      path:'/addNewStudent/:id',//添加新生
      name:'addNewStudent',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/addNewStudent.vue'],resolve)
    },
    {
      path:'/ImportNewStudent',//批量导入新生
      name:'ImportNewStudent',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/ImportNewStudent.vue'],resolve)
    },
    {
      path:'/SignUpStudentManagement',//签约生管理
      name:'SignUpStudentManagement',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/SignUpStudentManagement.vue'],resolve)
    },
    {
      path:'/AddSignUpStudent',//添加签约生
      name:'AddSignUpStudent',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/AddSignUpStudent.vue'],resolve)
    },
    {
      path:'/SignUpStudentImport',//批量导入签约生
      name:'SignUpStudentImport',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/SignUpStudentImport.vue'],resolve)
    },
    {
      path:'/newStudentClass',//新生分班
      name:'newStudentClass',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/newStudentClass.vue'],resolve)
    },
    {
      path:'/newStudentClassName',//新生分班名单
      name:'newStudentClassName',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/newStudentClassName.vue'],resolve)
    },
    {
      path:'/createdClass',//创建班级
      name:'createdClass',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/createdClass.vue'],resolve)
    },
    {
      path:'/organizeResults',//分班成绩合班设置
      name:'organizeResults',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/organizeResults.vue'],resolve)
    },
    {
      path:'/importExam',//导入成绩
      name:'importExam',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/importExam.vue'],resolve)
    },
    {
      path:'/scoreEntry',//成绩录入
      name:'scoreEntry',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/scoreEntry.vue'],resolve)
    },
    {
      path:'/classResult',//分班合成成绩情况
      name:'classResult',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/classResult.vue'],resolve)
    },
    {
      path:'/placementFast',//快速分班
      name:'placementFast',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/placementFast.vue'],resolve)
    },
    {
      path:'/changeBySelf',//手动调整
      name:'changeBySelf',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/changeBySelf.vue'],resolve)
    },
    {
      path:'/newStudentRecord',//学生补录
      name:'newStudentRecord',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/newStudentRecord.vue'],resolve)
    },
    {
      path:'/newStudentSpecial',//指定学生到班
      name:'newStudentSpecial',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/newStudentSpecial.vue'],resolve)
    },
    {
      path:'/printMessage',//打印报表
      name:'printMessage',
      component:resolve=>require(['@/page/schManagementSystem/newStudentArrange/printMessage.vue'],resolve)
    },
    /*设备保修---------*/
    {
      path:'/basicSetting',//基础设置
      name:'basicSetting',
      component:resolve=>require(['@/page/schManagementSystem/others/EquipmentRepair/basicSetting.vue'],resolve)
    },
    {
      path:'/repairReport',//我的保修单
      component:resolve=>require(['@/page/schManagementSystem/others/EquipmentRepair/repairReport.vue'],resolve),
      children:[
        {
          path:'/',//待处理
          name:'reportWait',
          component:resolve=>require(['@/page/schManagementSystem/others/EquipmentRepair/repayment/pending.vue'],resolve)
        },
        {
          path:'processed',//已处理
          name:'reportProcessed',
          component:resolve=>require(['@/page/schManagementSystem/others/EquipmentRepair/repayment/processed.vue'],resolve)
        },
        {
          path:'accepted',//已验收
          name:'reportAccepted',
          component:resolve=>require(['@/page/schManagementSystem/others/EquipmentRepair/repayment/accepted.vue'],resolve)
        }
      ]
    },
    {
      path:'/repairSpace',//报修空间
      component:resolve=>require(['@/page/schManagementSystem/others/EquipmentRepair/repairSpace.vue'],resolve),
      children:[
        {
          path:'/',//待处理
          name:'SpaceWait',
          component:resolve=>require(['@/page/schManagementSystem/others/EquipmentRepair/repairSpace/pending.vue'],resolve)
        },
        {
          path:'processed',//已处理
          name:'SpaceProcessed',
          component:resolve=>require(['@/page/schManagementSystem/others/EquipmentRepair/repairSpace/processed.vue'],resolve)
        },
        {
          path:'accepted',//已验收
          name:'SpaceAccepted',
          component:resolve=>require(['@/page/schManagementSystem/others/EquipmentRepair/repairSpace/accepted.vue'],resolve)
        }
      ]
    },
    {
      path:'/serviceTask',//维修任务
      component:resolve=>require(['@/page/schManagementSystem/others/EquipmentRepair/serviceTask.vue'],resolve),
      children:[
        {
          path:'/',//待处理
          name:'TaskWait',
          component:resolve=>require(['@/page/schManagementSystem/others/EquipmentRepair/serviceTask/pending.vue'],resolve)
        },
        {
          path:'/processed',//已处理
          name:'TaskProcessed',
          component:resolve=>require(['@/page/schManagementSystem/others/EquipmentRepair/serviceTask/processed.vue'],resolve)
        },
        {
          path:'/accepted',//已验收
          name:'TaskAccepted',
          component:resolve=>require(['@/page/schManagementSystem/others/EquipmentRepair/serviceTask/accepted.vue'],resolve)
        }
      ]
    },
    {
      path:'/handlerTask',//处理任务
      name:'handlerTask',
      component:resolve=>require(['@/page/schManagementSystem/others/EquipmentRepair/handlerTask.vue'],resolve)
    },
    {
      path:'/repairStatical',//报修统计
      name:'repairStatical',
      component:resolve=>require(['@/page/schManagementSystem/others/EquipmentRepair/repairStatical.vue'],resolve)
    },
    /*问卷调查*/
    {
      path:'/newQuestionNaire/:id',//新建问卷、编辑问卷
      name:'newQuestionNaire',
      component:resolve=>require(['@/page/schManagementSystem/others/questionNaire/newQuestionNaire.vue'],resolve)
    },
    {
      path:'/questionNaireRecord',//问卷记录
      name:'questionNaireRecord',
      component:resolve=>require(['@/page/schManagementSystem/others/questionNaire/questionNaireRecord.vue'],resolve)
    },
    {
      path:'/fillInProgress',//填写进度
      component:resolve=>require(['@/page/schManagementSystem/others/questionNaire/fillInProgress.vue'],resolve),
      children:[
        {
          path:'/',//教师
          name:'teacherFillIn',
          component:resolve=>require(['@/page/schManagementSystem/others/questionNaire/fillProgress/teacherFillIn.vue'],resolve)
        },
        {
          path:'/studentFillIn',//学生
          name:'studentFillIn',
          component:resolve=>require(['@/page/schManagementSystem/others/questionNaire/fillProgress/studentFillIn.vue'],resolve)
        },
        {
          path:'/staffFillIn',//职工
          name:'staffFillIn',
          component:resolve=>require(['@/page/schManagementSystem/others/questionNaire/fillProgress/staffFillIn.vue'],resolve)
        },
        {
          path:'/parentFillIn',//家长
          name:'parentFillIn',
          component:resolve=>require(['@/page/schManagementSystem/others/questionNaire/fillProgress/parentFillIn.vue'],resolve)
        },
        {
          path:'/othersFillIn',//其他
          name:'othersFillIn',
          component:resolve=>require(['@/page/schManagementSystem/others/questionNaire/fillProgress/othersFillIn.vue'],resolve)
        },
      ]
    },
    {
      path:'/questionNaireStatistic',//问卷统计
      name:'questionNaireStatistic',
      component:resolve=>require(['@/page/schManagementSystem/others/questionNaire/questionNaireStatistic.vue'],resolve),
      /*children:[
        {
          path:'/',//统计图标
          name:'echartsStatistic',
          component:resolve=>require(['@/page/schManagementSystem/others/questionNaire/QRStatistic/echartsStatistic.vue'],resolve)
        },
        {
          path:'/replyDetail',//回答详情
          name:'replyDetail',
          component:resolve=>require(['@/page/schManagementSystem/others/questionNaire/QRStatistic/replyDetail.vue'],resolve)
        },
      ]*/
    },
    {
      path:'/scanQuestionNaire/:id',//查看问卷
      name:'scanQuestionNaire',
      component:resolve=>require(['@/page/schManagementSystem/others/questionNaire/scanQuestionNaire.vue'],resolve)
    },
    {
      path:'/handlerQuestionNaire',//编辑问卷
      name:'handlerQuestionNaire',
      component:resolve=>require(['@/page/schManagementSystem/others/questionNaire/handlerQuestionNaire.vue'],resolve)
    },
    {
      path:'/shareQuestionNaire',//分享问卷
      name:'shareQuestionNaire',
      component:resolve=>require(['@/page/schManagementSystem/others/questionNaire/shareQuestionNaire.vue'],resolve)
    },
    {
      path:'/fillInTask',//填写任务
      name:'fillInTask',
      component:resolve=>require(['@/page/schManagementSystem/others/questionNaire/fillInTask.vue'],resolve)
    },
    /*资产管理*/
    {
      path:'/assetClassify',//资产分类
      name:'assetClassify',
      component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/assetClassify.vue'],resolve)
    },
    {
      path:'/approvalSetting',//审批设置
      name:'approvalSetting',
      component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/approvalSetting.vue'],resolve)
    },
    {
      path:'/assetImport',//批量导入
      name:'assetImport',
      component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/assetImport.vue'],resolve)
    },
    {
      path:'/assetStorage',//资产入库
      component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/assetStorage.vue'],resolve),
      children:[
        {
          path:'/',//新增入库
          name:'newStorage',
          component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/assetStorage/newStorage'],resolve),
        },
        {
          path:'/storageRecord',//入库记录
          name:'storageRecord',
          component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/assetStorage/storageRecord'],resolve),
        }
      ]
    },
    {
      path:'/QRCodeStorage',//二维码入库
      name:'QRCodeStorage',
      component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/QRCodeStorage.vue'],resolve)
    },
    {
      path:'/assetOutOfLibrary',//资产出库
      component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/assetOutOfLibrary.vue'],resolve),
      children:[
        {
          path:'/',//新增出库
          name:'newOut',
          component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/assetOutOfLibrary/newOut'],resolve),
        },
        {
          path:'/outRecord',//出库记录
          name:'outRecord',
          component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/assetOutOfLibrary/outRecord'],resolve),
        }
      ]
    },
    {
      path:'/assetReceipt',//资产领还
      component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/assetReceipt.vue'],resolve),
      children:[
        {
          path:'/',//新增领用
          name:'newReceipt',
          component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/assetReceipt/newReceipt'],resolve),
        },
        {
          path:'/ReceiptRecord',//领用记录
          name:'ReceiptRecord',
          component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/assetReceipt/ReceiptRecord'],resolve),
        },
        {
          path:'/returnRecord',//归还记录
          name:'returnRecord',
          component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/assetReceipt/returnRecord'],resolve),
        }
      ]
    },
    {
      path:'/assetApproval',//资产审批
      component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/assetApproval.vue'],resolve),
      children:[
        {
          path:'/',//待审批
          name:'assetPendApproval',
          component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/assetApproval/assetPendApproval'],resolve),
        },
        {
          path:'/assetAlreadyApproval',//已审批
          name:'assetAlreadyApproval',
          component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/assetApproval/assetAlreadyApproval'],resolve),
        }
      ]
    },
    {
      path:'/assetDetail',//资产明细
      name:'assetDetail',
      component:resolve=>require(['@/page/schManagementSystem/others/assetManagment/assetDetail.vue'],resolve)
    },
    {
      path:'/newNotice',     //校园管理/校园办公/新建通知
      name:'newNotice',
      component:resolve => require(['@/page/schManagementSystem/campusOffice/notificationNotice/newNotice'], resolve)
    },
    {
      path:'/viewAlerts',     //校园管理/校园办公/查看通知
      name:'viewAlerts',
      component:resolve => require(['@/page/schManagementSystem/campusOffice/notificationNotice/viewAlerts'], resolve)
    },
    {
      path:'/publish',     //校园管理/校园办公/发布记录
      name:'publish',
      component:resolve => require(['@/page/schManagementSystem/campusOffice/notificationNotice/publish'], resolve)
    },
    {
      path:'/newDcoument',     //校园管理/校园办公/办公申请/公文流传/新建公文流转
      name:'newDcoument',
      component:resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/DocumentCirculation/newDcoument.vue'], resolve)
    },
    {
      path:'/DocumentRecord',     //校园管理/校园办公/办公申请/公文流传/公文留转记录
      name:'DocumentRecord',
      component:resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/DocumentCirculation/DocumentRecord.vue'], resolve)
    },
    {
      path:'/DocumentApproval',     //校园管理/校园办公/办公申请/公文流传/公文留转审批
      component:resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/DocumentCirculation/DocumentApproval.vue'], resolve),
      children: [
        {
        path: '/',
        name: 'Docnapprovel',//未审批
        component: resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/DocumentCirculation/Docnapprovel.vue'], resolve)
      }, {
        path: 'DocApproved',
        name: 'DocApproved',//已审批
        component: resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/DocumentCirculation/DocApproved.vue'], resolve)
      }]
    },
    {
      path:'/NewCar',     //校园管理/校园办公/办公申请/用车申请/新建用车申请
      name:'NewCar',
      component:resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/CarApplication/NewCar.vue'], resolve)
    },
    {
      path:'/CarRecord',     //校园管理/校园办公/办公申请/用车申请/用车申请记录
      name:'CarRecord',
      component:resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/CarApplication/CarRecord.vue'], resolve)
    },
    {
      path:'/CarApproval',     //校园管理/校园办公/办公申请/用车申请/用车申请审批
      component:resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/CarApplication/CarApproval.vue'], resolve),
      children: [{
        path: '/',
        name: 'CarunApprovel',//未审批
        component: resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/CarApplication/CarunApprovel.vue'], resolve)
      }, {
        path: 'CarApproved',
        name: 'CarApproved',//已审批
        component: resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/CarApplication/CarApproved.vue'], resolve)
  }]
    },
    {
      path:'/NewfieldHome',     //校园管理/校园办公/办公申请/场地申请/新建场地申请
      component:resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/FieldApplication/NewfieldHome.vue'], resolve),
      children: [{
        path: '/',
        name: 'Newfield',
        component: resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/FieldApplication/Newfield.vue'], resolve)
      },{
        path: '/Newfield/NewfieldDetails',
        name: 'NewfieldDetails',
        component: resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/FieldApplication/NewfieldDetails.vue'], resolve)
      }]
    },
    {
      path:'/FieldRecord',     //校园管理/校园办公/办公申请/场地申请/场地申请记录
      name:'FieldRecord',
      component:resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/FieldApplication/FieldRecord.vue'], resolve)
    },
    {
      path:'/Fieldapprovel',     //校园管理/校园办公/办公申请/场地申请/场地申请审批
      component:resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/FieldApplication/Fieldapprovel.vue'], resolve),
      children: [{
        path: '/',
        name: 'Fieldunapprovel',//未审批
        component: resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/FieldApplication/Fieldunapprovel.vue'], resolve)
      }, {
        path: 'FieldApproved',
        name: 'Fieldapproved',//已审批
        component: resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/FieldApplication/FieldApproved.vue'], resolve)
      }]
    },
    {
      path:'/FieldAdministration',     //校园管理/校园办公/办公申请/场地申请/场地管理
      name:'FieldAdministration',
      component:resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/FieldApplication/FieldAdministration.vue'], resolve)
    },
    {
      path:'/FieldSet',     //校园管理/校园办公/办公申请/场地申请/场地配置设置
      name:'FieldSet',
      component:resolve => require(['@/page/schManagementSystem/campusOffice/officeApplication/FieldApplication/FieldSet.vue'], resolve)
    },
    {
      path:'/Tagset',     //校园管理/教研管理/档案管理/标签设置
      name:'Tagset',
      component:resolve => require(['@/page/schManagementSystem/researchManagement/fileManagement/Tagset.vue'], resolve)
    },
    {
      path:'/Approvalsettings',     //校园管理/教研管理/档案管理/审批设置
      name:'Approvalsettings',
      component:resolve => require(['@/page/schManagementSystem/researchManagement/fileManagement/Approvalsettings.vue'], resolve)
    },
    {
      path:'/Filerecord',       //校园管理/教研管理/档案管理/档案记录
      component:resolve => require(['@/page/schManagementSystem/researchManagement/fileManagement/Filerecord.vue'], resolve),
      children: [{
        path: '/',
        name: 'FilerecordPending',//待处理
        component: resolve => require(['@/page/schManagementSystem/researchManagement/fileManagement/FilerecordPending.vue'], resolve)
      }, {
        path: 'FilerecordPassed',
        name: 'FilerecordPassed',//已通过
        component: resolve => require(['@/page/schManagementSystem/researchManagement/fileManagement/FilerecordPassed.vue'], resolve)
      }]
    },
    {
      path:'/Fileapproval',       //校园管理/教研管理/档案管理/档案审批
      component:resolve => require(['@/page/schManagementSystem/researchManagement/fileManagement/Fileapproval.vue'], resolve),
      children: [{
        path: '/',
        name: 'FileapprovalPending',//待审批
        component: resolve => require(['@/page/schManagementSystem/researchManagement/fileManagement/FileapprovalPending.vue'], resolve)
      }, {
        path: 'FileapprovalEd',
        name: 'FileapprovalEd',//已审批
        component: resolve => require(['@/page/schManagementSystem/researchManagement/fileManagement/FileapprovalEd.vue'], resolve)
      }]
    },
    {
      path:'/ArchivesStatistics',     //校园管理/教研管理/档案管理/档案统计
      name:'ArchivesStatistics',
      component:resolve => require(['@/page/schManagementSystem/researchManagement/fileManagement/ArchivesStatistics.vue'], resolve)
    },




    {
      path:'/NewEvaluationTeacher',     //校园管理/教研管理/学生评教/创建教学评价
      name:'NewEvaluationTeacher',
      component:resolve => require(['@/page/schManagementSystem/researchManagement/StudentEvaluation/NewEvaluationTeacher.vue'], resolve)
    },
    {
      path:'/ScoringSystemSetting',     //校园管理/教研管理/学生评教/评分方式设置
      name:'ScoringSystemSetting',
      component:resolve => require(['@/page/schManagementSystem/researchManagement/StudentEvaluation/ScoringSystemSetting.vue'], resolve)
    },
    {
      path:'/TeachingEvaluationRecord',     //校园管理/教研管理/学生评教/教学评价记录
      name:'TeachingEvaluationRecord',
      component:resolve => require(['@/page/schManagementSystem/researchManagement/StudentEvaluation/TeachingEvaluationRecord.vue'], resolve)
    },
    {
      path:'/ClassEvaluationList',     //校园管理/教研管理/学生评教/班级评教名单
      name:'ClassEvaluationList',
      component:resolve => require(['@/page/schManagementSystem/researchManagement/StudentEvaluation/ClassEvaluationList.vue'], resolve)
    },
    {
      path:'/StatisticsOfTeacher',     //校园管理/教研管理/学生评教/评教数据分析/各班主任统计
      name:'StatisticsOfTeacher',
      component:resolve => require(['@/page/schManagementSystem/researchManagement/StudentEvaluation/DataAnalysis/StatisticsOfTeacher.vue'], resolve)
    },
    {
      path:'/ClassStatistics',     //校园管理/教研管理/学生评教/评教数据分析/班级各科统计
      name:'ClassStatistics',
      component:resolve => require(['@/page/schManagementSystem/researchManagement/StudentEvaluation/DataAnalysis/ClassStatistics.vue'], resolve)
    },
    {
      path:'/StatisticsOfEachClass',     //校园管理/教研管理/学生评教/评教数据分析/科目各班统计
      name:'StatisticsOfEachClass',
      component:resolve => require(['@/page/schManagementSystem/researchManagement/StudentEvaluation/DataAnalysis/StatisticsOfEachClass.vue'], resolve)
    },
    {
      path:'/SubjectGradeStatistics',     //校园管理/教研管理/学生评教/评教数据分析/科目年级统计
      name:'SubjectGradeStatistics',
      component:resolve => require(['@/page/schManagementSystem/researchManagement/StudentEvaluation/DataAnalysis/SubjectGradeStatistics.vue'], resolve)
    },
    {
      path:'/GradeStatistics',     //校园管理/教研管理/学生评教/评教数据分析/年级各科统计
      name:'GradeStatistics',
      component:resolve => require(['@/page/schManagementSystem/researchManagement/StudentEvaluation/DataAnalysis/GradeStatistics.vue'], resolve)
    },
    {
      path:'/TeachingEvaluationStudents',     //校园管理/教研管理/学生评教/教学评价学生
      name:'TeachingEvaluationStudents',
      component:resolve => require(['@/page/schManagementSystem/researchManagement/StudentEvaluation/TeachingEvaluationStudents.vue'], resolve)
    },
    {
      path:'/EvaluationOfTeachingAchievement',     //校园管理/教研管理/学生评教/评教成绩查询
      name:'EvaluationOfTeachingAchievement',
      component:resolve => require(['@/page/schManagementSystem/researchManagement/StudentEvaluation/EvaluationOfTeachingAchievement.vue'], resolve)
    },



    {
      path:'/ProcessManagement',     //校园管理/校园办公/流程中心/流程管理
      name:'ProcessManagement',
      component:resolve => require(['@/page/schManagementSystem/campusOffice/ProcessCenter/ProcessManagement.vue'], resolve)
    },
    {
      path:'/CreateProcess',     //校园管理/校园办公/流程中心/创建流程
      name:'CreateProcess',
      component:resolve => require(['@/page/schManagementSystem/campusOffice/ProcessCenter/CreateProcess.vue'], resolve)
    },
    {
      path:'/ExpressLane',     //校园管理/基础设置/系统设置/快速通道
      name:'ExpressLane',
      component:resolve => require(['@/page/schManagementSystem/baseSettings/Systemesttings/ExpressLane.vue'], resolve)
    },
    {
      path:'/BindAccount',     //校园管理/基础设置/系统设置/账号绑定
      name:'BindAccount',
      component:resolve => require(['@/page/schManagementSystem/baseSettings/Systemesttings/BindAccount.vue'], resolve)
    },
    {
      path:'/PasswordModification',     //校园管理/基础设置/系统设置/密码修改
      name:'PasswordModification',
      component:resolve => require(['@/page/schManagementSystem/baseSettings/Systemesttings/PasswordModification.vue'], resolve)
    },
    {
      path:'/SchoolInformation',     //校园管理/基础设置/基本信息/学校信息
      name:'SchoolInformation',
      component:resolve => require(['@/page/schManagementSystem/baseSettings/BasicInformation/SchoolInformation.vue'], resolve)
    },
    {
      path:'/GradeInformation',     //校园管理/基础设置/基本信息/年级信息
      name:'GradeInformation',
      component:resolve => require(['@/page/schManagementSystem/baseSettings/BasicInformation/GradeInformation.vue'], resolve)
    },
    {
      path:'/KeleiInformation',     //校园管理/基础设置/基本信息/科类信息
      name:'KeleiInformation',
      component:resolve => require(['@/page/schManagementSystem/baseSettings/BasicInformation/KeleiInformation.vue'], resolve)
    },
    {
      path:'/SubjectInformation',     //校园管理/基础设置/基本信息/科目信息
      name:'SubjectInformation',
      component:resolve => require(['@/page/schManagementSystem/baseSettings/BasicInformation/SubjectInformation.vue'], resolve)
    },
    {
      path:'/ProfessionalInformation',     //校园管理/基础设置/基本信息/专业信息
      name:'ProfessionalInformation',
      component:resolve => require(['@/page/schManagementSystem/baseSettings/BasicInformation/ProfessionalInformation.vue'], resolve)
    },
    {
      path:'/ClassLevel',     //校园管理/基础设置/基本信息/班级级别
      name:'ClassLevel',
      component:resolve => require(['@/page/schManagementSystem/baseSettings/BasicInformation/ClassLevel.vue'], resolve)
    },
    {
      path:'/SchoolYear',     //校园管理/基础设置/基本信息/学年学期
      name:'SchoolYear',
      component:resolve => require(['@/page/schManagementSystem/baseSettings/BasicInformation/SchoolYear.vue'], resolve)
    },
    {
      path:'/SectorInformation',     //校园管理/基础设置/基本信息/部门信息
      name:'SectorInformation',
      component:resolve => require(['@/page/schManagementSystem/baseSettings/BasicInformation/SectorInformation.vue'], resolve)
    },


    {
      path:'/teacherManagement',     //校园管理/教师管理/信息管理
      name:'teacherManagement',
      component:resolve => require(['@/page/schManagementSystem/baseSettings/userManager/teacher/messageManagement'], resolve)
    },
    {
      path:'/teacherImport',     //校园管理/教师管理/批量导入
      name:'teacherImport',
      component:resolve => require(['@/page/schManagementSystem/baseSettings/userManager/teacher/bulkImport'], resolve)
    },
    {
      path:'/workersManagement',     //校园管理/教职工/信息管理
      name:'workersManagement',
      component:resolve => require(['@/page/schManagementSystem/baseSettings/userManager/workers/messageManagement'], resolve)
    },
    {
      path:'/workersImport',     //校园管理/教职工/批量导入
      name:'workersImport',
      component:resolve => require(['@/page/schManagementSystem/baseSettings/userManager/workers/bulkImport'], resolve)
    },
    /*wy*/
    {
      path: '/permissionsManagement',  //校园管理/基础设置/权限管理
      name: 'permissionsManagement',
      component: resolve => require(['@/page/schManagementSystem/baseSettings/permissionsManager/permissionsManagement.vue'], resolve)
    },
    {
      path: '/newExam',  //校园管理/本校考试/新建考试
      name:'newExam',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/newExam/newExam.vue'], resolve),
    },
    {
      path: '/examManagerHome',  //校园管理/本校考试/考试管理
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/examManagerHome.vue'], resolve),
      children: [{
        path: '/',
        name: 'examManagement',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/examManagement.vue'], resolve)
      }, {   //考号设置
        path: 'testNumberSetting/:gradeid/:examinationid',
        name: 'testNumberSetting',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/testNumberSetting.vue'], resolve)
      }, {   //考号管理
        path: 'testNumberManagement/:gradeid/:examinationid',
        name: 'testNumberManagement',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/testNumberManagement.vue'], resolve)
      },{   //各班学生确认情况
        path: 'confirmStatus/:examinationid',
        name: 'confirmStatus',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/confirmStatus.vue'], resolve)
      },{   //各班学生确认参考
        path: 'referenceConfirm/:examinationid',
        name: 'referenceConfirm',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/referenceConfirm.vue'], resolve)
      },{   //考场分配
        path: 'examinationDistribution/:examinationid',
        name: 'examinationDistribution',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/examinationDistribution.vue'], resolve)
      },{   //监考任务
        path: 'invigilatorTask',
        name: 'invigilatorTask',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/invigilatorTask.vue'], resolve)
      },{   //考务报表打印
        path: 'testReportPrinting',
        name: 'testReportPrinting',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/testReportPrinting.vue'], resolve)
      },{   //考生安排
        path: 'candidatesArrangement',
        name: 'candidatesArrangement',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/candidatesArrangement.vue'], resolve)
      },{   //成绩导入
        path: 'importGrades',
        name: 'importGrades',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/importGrades.vue'], resolve)
      },{   //成绩自己录入
        path: 'selfEntry',
        name: 'selfEntry',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/selfEntry.vue'], resolve)
      },{   //授权他们录入
        path: 'authorizedEntry',
        name: 'authorizedEntry',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/authorizedEntry.vue'], resolve)
      },{   //学生单独考试
        path: 'studentTestAlone',
        name: 'studentTestAlone',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/studentTestAlone.vue'], resolve)
      },{   //发布成绩
        path: 'releaseResults',
        name: 'releaseResults',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/releaseResults.vue'], resolve)
      },{   //考试划线
        path: 'testScribing',
        name: 'testScribing',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/testScribing.vue'], resolve)
      },{   //分率设置
        path: 'percentageSet',
        name: 'percentageSet',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/percentageSet.vue'], resolve)
      },{   //分数等级设置
        path: 'scoresLevel',
        name: 'scoresLevel',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/scoresLevel.vue'], resolve)
      },{   //各科目考试时间
        path: 'testTime',
        name: 'testTime',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/testTime.vue'], resolve)
      },{   //监考安排/文科
        path: 'proctorArrangementArts',
        name: 'proctorArrangementArts',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/proctorArrangementArts.vue'], resolve)
      },{   //监考安排/理科
        path: 'proctorArrangementScience',
        name: 'proctorArrangementScience',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/examManager/proctorArrangementScience.vue'], resolve)
      }]
    },
    {
      path: '/previousExam',  //校园管理/本校考试/历年考试
      name: 'previousExam',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/schoolExam/previousExams/previousExam.vue'], resolve)
    },
    {
      path: '/scoreQuery',  //校园管理/本校考试/成绩查询
      name: 'scoreQuery',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/studentScores/scoreQuery/scoreQuery.vue'], resolve)
    },
    {
      path:'/subjectCount',  //校园管理/本校考试/学科统计
      name:'subjectCount',
      component:resolve=>require(['@/page/schManagementSystem/teachingAdministration/studentScores/scoreCount/subjectCount.vue'],resolve)
    },
    {
      path: '/rankingCount',  //校园管理/本校考试/名次统计
      name: 'rankingCount',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/studentScores/scoreCount/rankingCount.vue'], resolve)
    },
    {
      path: '/subparagraphCount',  //校园管理/本校考试/分段统计
      name: 'subparagraphCount',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/studentScores/scoreCount/subparagraphCount.vue'], resolve)
    },
    {
      path: '/totalCount',  //校园管理/本校考试/均分总表
      name: 'totalCount',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/studentScores/scoreCount/totalCount.vue'], resolve)
    },
    {
      path: '/subClassDivisionHome',  //校园管理/教学教务/分班分科/分班分科管理
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/subClassDivisionHome.vue'], resolve),
      children: [{   //流程图
        path: '/',
        name: 'subClassDivision',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/subClassDivision.vue'], resolve)
      },{   //修改分班方案
        path: 'reviseSubClassPlan',
        name: 'reviseSubClassPlan',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/reviseSubClassPlan.vue'], resolve)
      },{   //分班学生管理
        path: 'subStudentManagement',
        name: 'subStudentManagement',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/subStudentManagement.vue'], resolve)
      },{   //分班成绩依据
        path: 'subScoreBasis',
        name: 'subScoreBasis',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/subScoreBasis.vue'], resolve)
      },{   //成绩管理
        path: 'scoresManagement',
        name: 'scoresManagement',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/scoresManagement.vue'], resolve)
      },{   //成绩录入
        path: 'scoresEntry',
        name: 'scoresEntry',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/scoresEntry.vue'], resolve)
      },{   //填报志愿设置
        path: 'fillVolunteerSet',
        name: 'fillVolunteerSet',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/fillVolunteerSet.vue'], resolve)
      },{   //合计成绩统计-成绩总汇
        path: 'aggregateScoreCount',
        name: 'aggregateScoreCount',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/aggregateScoreCount.vue'], resolve)
      },{   //合计成绩统计-成绩明细
        path: 'scoreDetails',
        name: 'scoreDetails',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/scoreDetails.vue'], resolve)
      },{   //学生志愿调整
        path: 'studentVolunteerRevise',
        name: 'studentVolunteerRevise',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/studentVolunteerRevise.vue'], resolve)
      },{   //批量导入学生志愿
        path: 'importStudentVolunteer',
        name: 'importStudentVolunteer',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/importStudentVolunteer.vue'], resolve)
      },{   //学生志愿统计-志愿填报情况
        path: 'studentVolunteerCount',
        name: 'studentVolunteerCount',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/studentVolunteerCount.vue'], resolve)
      },{   //学生志愿统计-志愿分布情况
        path: 'volunteerDistributionStatus',
        name: 'volunteerDistributionStatus',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/volunteerDistributionStatus.vue'], resolve)
      },{   //未报志愿学生名单
        path: 'unFillVolunteerList',
        name: 'unFillVolunteerList',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/unFillVolunteerList.vue'], resolve)
      },{   //志愿确认签名表
        path: 'volunteerConfirmList',
        name: 'volunteerConfirmList',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/volunteerConfirmList.vue'], resolve)
      },{   //快速分班
        path: 'quicklySplitclass',
        name: 'quicklySplitclass',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/quicklySplitclass.vue'], resolve)
      },{   //打印报表
        path: 'printReport',
        name: 'printReport',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/printReport.vue'], resolve)
      },{   //发布分班结果
        path: 'publishSubClassResult',
        name: 'publishSubClassResult',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/publishSubClassResult.vue'], resolve)
      },{   //成绩统计设置
        path: 'scoreCountSet',
        name: 'scoreCountSet',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/scoreCountSet.vue'], resolve)
      },{   //拟分班级设置
        path: 'likeSubClassSet',
        name: 'likeSubClassSet',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/likeSubClassSet.vue'], resolve)
      },{   //指定学生到班
        path: 'specifiedStudentClass',
        name: 'specifiedStudentClass',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/specifiedStudentClass.vue'], resolve)
      },{   //手动调整
        path: 'manuallyAdjustment',
        name: 'manuallyAdjustment',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionManagement/manuallyAdjustment.vue'], resolve)
      }]
    },
    {   //校园管理/教学教务/分班分科/创建分班方案
      path: '/newSubClassPlan',
      name: 'newSubClassPlan',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/newSubClassDivision/newSubClassPlan.vue'], resolve)
    },
    {   //校园管理/教学教务/分班分科/分班分科记录
      path: '/subClassDivisionRecords',
      name: 'subClassDivisionRecords',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionRecords/subClassDivisionRecords.vue'], resolve)
    },
    {   //校园管理/教学教务/分班分科/分班分科结果——学生
      path: '/subClassDivisionResults',
      name: 'subClassDivisionResults',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/subClassDivision/subClassDivisionResults/subClassDivisionResults.vue'], resolve)
    },
    {   //校园管理/教学教务/教务管理/在读证明
      path: '/inSchoolProve',
      name: 'inSchoolProve',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/educationalAdministration/inSchoolProve.vue'], resolve)
    },
    {   //校园管理/教学教务/教务管理/成绩证明
      path: '/scoresProve',
      name: 'scoresProve',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/educationalAdministration/scoresProve.vue'], resolve)
    },
    {   //校园管理/教学教务/教务管理/班年级管理
      path: '/classGradeManagement',
      name: 'classGradeManagement',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/educationalAdministration/classGradeManagement.vue'], resolve)
    },
    {   //校园管理/教学教务/教务管理/班年级主任
      path: '/classGradeDirector',
      name: 'classGradeDirector',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/educationalAdministration/classGradeDirector.vue'], resolve)
    },
    {   //校园管理/教学教务/教务管理/任课教师
      path: '/classTeacher',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/educationalAdministration/classTeacher/classTeacher.vue'], resolve),
      children: [{   //任课教师管理
        path: '/',
        name: 'classTeacherManagement',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/educationalAdministration/classTeacher/classTeacherManagement.vue'], resolve)
      },{   //任课教师设置
        path: 'classTeacherSet',
        name: 'classTeacherSet',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/educationalAdministration/classTeacher/classTeacherSet.vue'], resolve)
      }]
    },
    {   //校园管理/教学教务/教务管理/套打中心
      path: '/printCenter',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/educationalAdministration/printCenter/printCenter.vue'], resolve),
      children: [{   //开始设计
        path: '/',
        name: 'startDesign',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/educationalAdministration/printCenter/startDesign.vue'], resolve)
      },{   //我的设计
        path: 'myDesign',
        name: 'myDesign',
        component: resolve => require(['@/page/schManagementSystem/teachingAdministration/educationalAdministration/printCenter/myDesign.vue'], resolve)
      }]
    },
    {
      path: '/NewLeave',  //校园办公/教师请假/新建请假
      name: 'NewLeave',
      component: resolve => require(['@/page/schManagementSystem/campusOffice/TeacherLeave/NewLeave.vue'], resolve)
    },
    {
      path: '/LeaveRecord',  //校园办公/教师请假/请假记录
      name: 'LeaveRecord',
      component: resolve => require(['@/page/schManagementSystem/campusOffice/TeacherLeave/LeaveRecord.vue'], resolve)
    },
    {
      path: '/LeaveApproval',  //校园办公/教师请假/请假审批/
      component: resolve => require(['@/page/schManagementSystem/campusOffice/TeacherLeave/LeaveApproval.vue'], resolve),
      children: [{
        path: '/',
        name: 'PendingApproval',//未审批
        component: resolve => require(['@/page/schManagementSystem/campusOffice/TeacherLeave/PendingApproval.vue'], resolve)
      }, {
        path: 'TeacherApproved',
        name: 'TeacherApproved',//已审批
        component: resolve => require(['@/page/schManagementSystem/campusOffice/TeacherLeave/TeacherApproved.vue'], resolve)
      }]
    },
    {
      path: '/LeaveStatistics',  //校园办公/教师请假/请假统计
      name: 'LeaveStatistics',
      component: resolve => require(['@/page/schManagementSystem/campusOffice/TeacherLeave/LeaveStatistics.vue'], resolve)
    },
    {
      path: '/LeaveDetails',  //校园办公/教师请假/请假明细
      name: 'LeaveDetails',
      component: resolve => require(['@/page/schManagementSystem/campusOffice/TeacherLeave/LeaveDetails.vue'], resolve)
    },
    {
      path: '/SeatingArrangement',  //教学教务/班级管理/座位调整/座位布局
      name: 'SeatingArrangement',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ClassManagement/SeatAdjustment/SeatingArrangement.vue'], resolve)
    },
    {
      path: '/SeatingArrangements',  //教学教务/班级管理/座位调整/座位安排
      name: 'SeatingArrangements',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ClassManagement/SeatAdjustment/SeatingArrangements.vue'], resolve)
    },
    {
      path: '/InformationService',  //教学教务/班级管理/学生信息查询
      name: 'InformationService',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ClassManagement/InformationService.vue'], resolve)
    },
    {
      path: '/ReferenceConfirmation',  //教学教务/班级管理/学生参考确认
      name: 'ReferenceConfirmation',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/ClassManagement/ReferenceConfirmation.vue'], resolve)
    },
    {
      path: '/StudentInformationInquiry',  //教学教务/年级管理/学生信息查询
      name: 'StudentInformationInquiry',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/GradeManagement/StudentInformationInquiry.vue'], resolve)
    },
    {
      path: '/ClassConfirmation',  //教学教务/年级管理/学生参考确认/各班参考确认
      name: 'ClassConfirmation',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/GradeManagement/StudentReferenceConfirmation/ClassConfirmation.vue'], resolve)
    },
    {
      path: '/StudentConfirmation',  //教学教务/年级管理/学生参考确认/学生参考确认
      name: 'StudentConfirmation',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/GradeManagement/StudentReferenceConfirmation/StudentConfirmation.vue'], resolve)
    },
    {
      path: '/writeComment',  //校园管理系统/学生管理/学生成长记录/写评语
      name: 'writeComment',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentGrowthRecord/writeComment.vue'], resolve)
    },
    {
      path: '/studentGrowthRecord',  //校园管理系统/学生管理/学生成长记录/成长记录
      name: 'studentGrowthRecord',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentGrowthRecord/studentGrowthRecord.vue'], resolve)
    },
    {
      path: '/familyReport',  //校园管理系统/学生管理/学生成长记录/家庭报告书
      name: 'familyReport',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentGrowthRecord/familyReport.vue'], resolve)
    },
    {
      path: '/abnormalMotionOperation',  //校园管理系统/学生管理/学生异动/异动操作
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentAbnormalMotion/abnormalMotionOperation/abnormalMotionOperation.vue'], resolve),
      children: [{
        path: '/',
        name: 'shiftClass',   //校园管理系统/学生管理/学生异动/异动操作——转班
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentAbnormalMotion/abnormalMotionOperation/shiftClass.vue'], resolve)
      },{
        path: 'into/:idx',
        name: 'into',   //校园管理系统/学生管理/学生异动/异动操作——转入
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentAbnormalMotion/abnormalMotionOperation/into.vue'], resolve)
      },{
        path: 'turnOut/:idx',
        name: 'turnOut',   //校园管理系统/学生管理/学生异动/异动操作——转出
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentAbnormalMotion/abnormalMotionOperation/turnOut.vue'], resolve)
      },{
        path: 'suspendedSchool/:idx',
        name: 'suspendedSchool',   //校园管理系统/学生管理/学生异动/异动操作——休学
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentAbnormalMotion/abnormalMotionOperation/suspendedSchool.vue'], resolve)
      },{
        path: 'recoverSchool/:idx',
        name: 'recoverSchool',   //校园管理系统/学生管理/学生异动/异动操作——复学
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentAbnormalMotion/abnormalMotionOperation/recoverSchool.vue'], resolve)
      },{
        path: 'transient/:idx',
        name: 'transient',   //校园管理系统/学生管理/学生异动/异动操作——借读
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentAbnormalMotion/abnormalMotionOperation/transient.vue'], resolve)
      },{
        path: 'hangRead/:idx',
        name: 'hangRead',   //校园管理系统/学生管理/学生异动/异动操作——挂读
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentAbnormalMotion/abnormalMotionOperation/hangRead.vue'], resolve)
      },{
        path: 'dropout/:idx',
        name: 'dropout',   //校园管理系统/学生管理/学生异动/异动操作——退学
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentAbnormalMotion/abnormalMotionOperation/dropout.vue'], resolve)
      }]
    },
    {
      path: '/abnormalMotionCount',  //校园管理系统/学生管理/学生异动/异动统计
      name: 'abnormalMotionCount',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentAbnormalMotion/abnormalMotionCount/abnormalMotionCount.vue'], resolve)
    },
    {
      path: '/abnormalMotionDetail',  //校园管理系统/学生管理/学生异动/异动明细
      name: 'abnormalMotionDetail',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentAbnormalMotion/abnormalMotionDetail/abnormalMotionDetail.vue'], resolve)
    },
    {
      path: '/applicationForm',  //校园管理系统/学生管理/学生异动/异动申请表
      name: 'applicationForm',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentAbnormalMotion/applicationForm/applicationForm.vue'], resolve)
    },
    {
      path: '/studyingWayApproval',  //校园管理系统/学生管理/宿舍管理/就读方式审批
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/studyingWayApproval/studyingWayApproval.vue'], resolve),
      children: [{
        path: '/',
        name: 'pendingApproval',   //校园管理系统/学生管理/宿舍管理/就读方式审批——待审批
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/studyingWayApproval/pendingApproval.vue'], resolve)
      },{
        path: 'liveSchool/:index',
        name: 'liveSchool',   //校园管理系统/学生管理/宿舍管理/就读方式审批——住校
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/studyingWayApproval/liveSchool.vue'], resolve)
      },{
        path: 'unLiveSchool/:index',
        name: 'unLiveSchool',   //校园管理系统/学生管理/宿舍管理/就读方式审批——走读
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/studyingWayApproval/unLiveSchool.vue'], resolve)
      }]
    },
    {
      path: '/dormitoryMsgManagement',  //校园管理系统/学生管理/宿舍管理/宿舍信息管理
      name: 'dormitoryMsgManagement',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/dormitoryMsgManagement/dormitoryMsgManagement.vue'], resolve)
    },
    {
      path: '/dormitoryImport',  //校园管理系统/学生管理/宿舍管理/宿舍信息管理——批量导入
      name: 'dormitoryImport',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/dormitoryMsgManagement/bulkImport.vue'], resolve)
    },
    {
      path: '/setLifeTeacher',  //校园管理系统/学生管理/宿舍管理/设置生活老师
      name: 'setLifeTeacher',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/setLifeTeacher/setLifeTeacher.vue'], resolve)
    },
    {
      path: '/personnelManager',  //校园管理系统/学生管理/宿舍管理/住宿人员管理
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/dormitoryPersonnelManagement/personnelManager.vue'], resolve),
      children: [{
        path: '/',
        name: 'personnelManagement',   //校园管理系统/学生管理/宿舍管理/住宿人员管理
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/dormitoryPersonnelManagement/personnelManagement.vue'], resolve)
      },{
        path: 'personnelDetail/:idx',
        name: 'personnelDetail',   //校园管理系统/学生管理/宿舍管理/住宿人员明细
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/dormitoryPersonnelManagement/personnelDetail.vue'], resolve)
      }]
    },
    {
      path: '/dormitoryDistributionHome',  //校园管理系统/学生管理/宿舍管理/住宿人员分配
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/dormitoryDistribution/distributionHome.vue'], resolve),
      children: [{
        path: '/',
        name: 'dormitoryDistribution',   //校园管理系统/学生管理/宿舍管理/住宿人员分配
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/dormitoryDistribution/dormitoryDistribution.vue'], resolve)
      },{
        path: 'createDistribution',
        name: 'createDistribution',   //校园管理系统/学生管理/宿舍管理/创建宿舍分配方案
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/dormitoryDistribution/createDistribution.vue'], resolve)
      },{
        path: 'editDistribution/:id',
        name: 'editDistribution',   //校园管理系统/学生管理/宿舍管理/编辑宿舍分配方案
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/dormitoryDistribution/editDistribution.vue'], resolve)
      },{
        path: 'distributionProcess/:id',
        name: 'distributionProcess',   //校园管理系统/学生管理/宿舍管理/宿舍分配流程
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/dormitoryDistribution/distributionProcess.vue'], resolve)
      },{
        path: 'distributionPersonnelList',
        name: 'distributionPersonnelList',   //校园管理系统/学生管理/宿舍管理/设置人员名单
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/dormitoryDistribution/distributionPersonnelList.vue'], resolve)
      },{
        path: 'distributionDormitoryMsg',
        name: 'distributionDormitoryMsg',   //校园管理系统/学生管理/宿舍管理/设置分配宿舍信息
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/dormitoryDistribution/distributionDormitoryMsg.vue'], resolve)
      },{
        path: 'specifiedStudentDormitory',
        name: 'specifiedStudentDormitory',   //校园管理系统/学生管理/宿舍管理/指定学生到宿舍
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/dormitoryDistribution/specifiedStudentDormitory.vue'], resolve)
      },{
        path: 'manuallyAdjustmentDormitory',
        name: 'manuallyAdjustmentDormitory',   //校园管理系统/学生管理/宿舍管理/手动调整
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/dormitoryDistribution/manuallyAdjustmentDormitory.vue'], resolve)
      },{
        path: 'dormitoryPrintReport',
        name: 'dormitoryPrintReport',   //校园管理系统/学生管理/宿舍管理/报表打印
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/dormitoryDistribution/dormitoryPrintReport.vue'], resolve)
      },{
        path: 'fastDistributionDormitory',
        name: 'fastDistributionDormitory',   //校园管理系统/学生管理/宿舍管理/快速分配宿舍
        component: resolve => require(['@/page/schManagementSystem/studentsManagement/dormitoryManagement/dormitoryDistribution/fastDistributionDormitory.vue'], resolve)
      }]
    },
    {
      path: '/createLeave',  //校园管理系统/学生管理/学生请假/新建请假
      name:'createLeave',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentLeave/createLeave.vue'], resolve)
    },
    {
      path: '/leaveRecords',  //校园管理系统/学生管理/学生请假/请假记录
      name:'leaveRecords',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentLeave/leaveRecords.vue'], resolve)
    },
    {
      path: '/generationLeave',  //校园管理系统/学生管理/学生请假/代学生请假
      name:'generationLeave',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentLeave/generationLeave.vue'], resolve)
    },
    {
      path: '/generationLeaveRecords',  //校园管理系统/学生管理/学生请假/代学生请假记录
      name:'generationLeaveRecords',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentLeave/generationLeaveRecords.vue'], resolve)
    },
    {
      path: '/leaveApproved',  //校园管理系统/学生管理/学生请假/请假审批——已审批
      name:'leaveApproved',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentLeave/leaveApproved.vue'], resolve)
    },
    {
      path: '/leaveNotApproved',  //校园管理系统/学生管理/学生请假/请假审批——未审批
      name:'leaveNotApproved',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentLeave/leaveNotApproved.vue'], resolve)
    },
    {
      path: '/leaveSchoolConfirmation',  //校园管理系统/学生管理/学生请假/离校确认
      name:'leaveSchoolConfirmation',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentLeave/leaveSchoolConfirmation.vue'], resolve)
    },
    {
      path: '/leaveSelect',  //校园管理系统/学生管理/学生请假/请假查询
      name:'leaveSelect',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentLeave/leaveSelect.vue'], resolve)
    },
    {
      path: '/leaveCount',  //校园管理系统/学生管理/学生请假/请假统计
      name:'leaveCount',
      component: resolve => require(['@/page/schManagementSystem/studentsManagement/studentLeave/leaveCount.vue'], resolve)
    },
    {
      path: '/turnClassApprovalSet',  //校园管理系统/教学教务/调课代课/审批设置
      name:'turnClassApprovalSet',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/turningClassSubstitute/approvalSettings/turnClassApprovalSet.vue'], resolve)
    },
    {
      path: '/specifiedTurningClass',  //校园管理系统/教学教务/调课代课/调课/教师指定调课
      name:'specifiedTurningClass',
      component: resolve => require(['@/page/schManagementSystem/teachingAdministration/turningClassSubstitute/turningClass/specifiedTurningClass.vue'], resolve)
    }
  ]
})

