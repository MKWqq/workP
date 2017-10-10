<?php
/**
 * Created by PhpStorm.
 * User: hujun
 * Date: 2017/8/16
 * Time: 11:20
 */

namespace Home\Controller;

use Home\Model\BranchProcessModel;

/*
 * 分科分班
 * */
class DivideBranchController extends Base
{
    protected $roleId;
    protected $scId;
    protected $uid;
    protected $user;

    public function __construct()
    {
        parent::__construct();
        /*        $this->scId = $_SESSION['loginCheck']['data']['scId'];
                $this->uid = $_SESSION['loginCheck']['data']['userId'];
                $this->roleId = $_SESSION['loginCheck']['data']['roleId'];*/

        $this->roleId = 22;
        $uid = 1;
        $scId = 2;
        $this->scId = $scId;
        $this->uid = $uid;
        $this->user = D('User')->where(array('id' => $this->uid, 'scId' => $this->scId))->find();
    }

    /*************************************管理员操作*******************************************/
    //各流程变化
    function changeProcess(Array $process, $planId)
    {
        $steps=implode(',',array_keys($process));

        $sql = "UPDATE mks_branch_process SET status = CASE step ";
        foreach ($process as $step => $status) {
            $sql .= sprintf("WHEN %d THEN %d ",$step,$status);
        }
        $sql .= "END WHERE step in ({$steps}) and scId={$this->scId} and planId={$planId}";

        M('')->execute($sql);
    }

    //删除方案关联的信息
    function delPlan($planId)
    {
        $where = "planId={$planId} and scId={$this->scId}";
        D('BranchBasis')->where($where)->delete();
        D('BranchClass')->where($where)->delete();
        D('BranchExam')->where($where)->delete();
        D('BranchPlan')->where("id={$planId} and scId={$this->scId}")->delete();
        D('BranchProcess')->where($where)->delete();
        D('BranchStudent')->where($where)->delete();
        D('BranchSubject')->where($where)->delete();
        D('BranchWish')->where($where)->delete();
        return true;
    }

    //公共调用接口
    public function Common($func,$param=''){
        switch ($func){
            case 'getAllPlan':  //分班方案
                $this->getAllPlan();
                break;
            case 'getAllStudent': //待选分班学生
                $this->getAllStudent();
                break;
            case 'callExam': //调用考试
                $this->callExam($param);
                break;
            case 'callBranch': //调用科类
                $this->callBranch();
                break;
            case 'callMajor': //调用专业
                $this->callMajor($param);
                break;
            case 'getSubject':
                $this->getSubject($param);
                break;
            case 'getAllWish':
                $this->getAllWish($param);
                break;

            default:
                return null;
        }
    }

    //创建分班方案    //已测试
    public function createPlan()
    {
        $response = array(
            'status' => 0,
            'msg' => ''
        );
        $type = $_POST['type'];
        if (!$type || $type != 'create') {
            $response['msg'] = '没有权限创建';
            $this->ajaxReturn($response);
        } elseif ($type == 'create') {
            $data = $_POST;
            $plan = array(
                'creator' => $this->user['name'],
                'creatorId' => $this->uid,
                'name' => $data['name'],
                'fillStart' => strtotime($data['fillStart']),
                'fillEnd' => strtotime($data['fillEnd']),
                'changeStart' => strtotime($data['changeStart']),
                'changeEnd' => strtotime($data['changeEnd']),
                'stuSearch' => (int)$data['stuSearch'],
                'stuChange' => (int)$data['stuChange'],
                'teaChange' => (int)$data['teaChange'],
                'notice' => $data['notice'],
                'notFill' => 0,
                'fillNumber' => 0,
                'createTime' => time(),
                'scId' => $this->scId,
            );
            // 保存方案
            $rs = D('BranchPlan')->data($plan)->add();
            if (!$rs) {
                $response['msg'] = '保存方案失败';
                $this->ajaxReturn($response);
            }
            $bp = new BranchProcessModel();
            //存入流程设置
            $rs = $bp->addPlanProcess($rs, $this->scId);
            if (!$rs) {
                $response['msg'] = '保存流程失败';
                $this->ajaxReturn($response);
            }
            $response['msg'] = '创建成功';
            $response['status'] = 1;
            $this->ajaxReturn($response);
        }
    }

    //分科分班记录    //已测试
    public function planLog()
    {
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        $type = $_POST['type'];
        if (!empty($type)) {
            $rs = false;
            if ($type == 'del') {
                $planId = $_POST['planId'];
                $rs = $this->delPlan($planId);
            }
            if ($rs) {
                $response['msg'] = '删除成功';
                $response['status'] = 1;
                $this->ajaxReturn($response);
            }
            $response['msg'] = '无权限';
            $this->ajaxReturn($response);
        }


        $page = empty($_POST['page']) ? 1 : (int)$_POST['page'];
        $count = empty($_POST['count']) ? 10 : (int)$_POST['count'];
        $pre_page = ($page - 1) * $count;
        $limit_page = "$pre_page,$count";

        $data = D('BranchPlan')->where(
            array('scId' => $this->scId, 'creatorId' => $this->uid))
            ->field('id,name,fillStart,fillEnd,changeStart,changeEnd,notFill,fillNumber,createTime')
            ->limit($limit_page)->select();
        if ($data) {
            $response['data']=$data;
            $response['status'] = 1;
            $response['total'] = (int)D('BranchPlan')->where(
                array('scId' => $this->scId, 'creatorId' => $this->uid))->count();
            $response['maxPage'] = ceil($response['total'] / $count) > 0 ? 1 : ceil($response['total'] / $count);
            $this->ajaxReturn($response);
        }
    }

    //得到所有方案 //已测试
    private function getAllPlan()
    {
        $data = D('BranchPlan')->where(
            array('scId' => $this->scId, 'creatorId' => $this->uid))
            ->field('id,name')->select();
        if(empty($data))
            $data=array();
        $this->ajaxReturn($data);
    }

    //分科分班管理 //已测试
    public function getAllProcess($planId)
    {
        $pd = new BranchProcessModel();
        $data = $pd->getAllProcess($planId);
        if(empty($data))
            $data=array();
        $this->ajaxReturn($data);
    }

    //修改分班方案    //已测试
    public function updatePlan($planId)
    {
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        $type = $_POST['type'];
        if (!empty($type) && $type != 'update') {
            $response['msg'] = '没有权限保存';
            $this->ajaxReturn($response);
        } elseif ($type == 'update') {
            $data = $_POST;
            $update = array(
                'name' => $data['name'],
                'fillStart' => strtotime($data['fillStart']),
                'fillEnd' => strtotime($data['fillEnd']),
                'changeStart' => strtotime($data['changeStart']),
                'changeEnd' => strtotime($data['changeEnd']),
                'stuSearch' => (int)$data['stuSearch'],
                'stuChange' => (int)$data['stuChange'],
                'teaChange' => (int)$data['teaChange'],
                'notice' => $data['notice'],
                'lastRecordTime' => time()
            );
            $rs = D('BranchPlan')->where(
                array('id' => $planId))->data($update)->save();
            if (!$rs) {
                $response['msg'] = '修改出错';
                $this->ajaxReturn($response);
            }
            $response['msg'] = '修改成功';
            $response['status'] = 1;
            $this->ajaxReturn($response);
        }
        $plan = D('BranchPlan')->where(
            array('id' => $planId))
            ->field('id,name,fillStart,fillEnd,changeStart,changeEnd,stuSearch,stuChange,teaChange,notice')
            ->find();
        if ($plan) {
            $response['data'] = $plan;
            $response['status'] = 1;
        }
        $this->ajaxReturn($response);
    }

    //得到所有待选分班学生 @todo
    private function getAllStudent()
    {
        $where = array(
            'scId' => $this->scId
        );
        $allStudent = D('StudentInfo')->where($where)
            ->field('name,sex,grade,gradeId,classId,serialNumber,className,userId')
            ->select();
        if (!$allStudent)
            return null;
        $student = array();
        foreach ($allStudent as $k => $v) {
            if (!array_key_exists($v['grade'], $student)) {
                $student[$v['grade']] = array();
            }
            if (!array_key_exists($v['className'], $student[$v['grade']])) {
                $student[$v['grade']][$v['className']] = array();
            }
            $student[$v['grade']][$v['className']][] = $v;
        }
        $this->ajaxReturn($allStudent);
       //return $student;
    }

    //分班学生管理 //已测试
    public function studentManage($planId)
    {
        $model = D('BranchStudent');
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        $type = $_POST['type'];
        if ($type == 'save') {
            $students = $_POST['students'];
            $stuLists = json_decode($students, true);
            if (is_array($stuLists)) {
                $rs = $model->where("planId={$planId}")->find();
                if ($rs) {
                    $model->startTrans();
                    $result = $model->where("planId={$planId} and scId={$this->scId}")->delete();
                    if (!$result)
                        $model->rollback();
                    $model->commit();
                }

                $val = '';
                foreach ($stuLists as &$v) {
                    $val .= '(' . "{$v['userId']}," . "'{$v['name']}'," . "'{$v['sex']}'," . "{$v['gradeId']}," . "'{$v['preGrade']}'," . "'{$v['preClass']}',"
                        . "'{$v['preSerialNumber']}'," . "{$planId}," . "{$this->scId}" . '),';
                }
                $val = rtrim($val, ',');
                $sql = "insert into mks_branch_student (userId,name,sex,gradeId,preGrade,preClass,preSerialNumber,planId,scId)
                          values {$val}";
                $res = M()->execute($sql);
                if ($res) {
                    $response['status'] = 1;
                    $response['msg'] = '保存成功';
                    $status=D('BranchProcess')
                        ->where(array('planId'=>$planId,'scId'=>$this->scId,'step'=>4))
                        ->getField('status');
                    if($status!=1){
                        $process=array(2=>1,3=>1);
                    }else{
                        $process=array(2=>1,3=>1,5=>2);
                    }
                    $this->changeProcess($process,$planId);
                    $this->ajaxReturn($response);
                }
                $response['msg'] = '保存失败';
                $this->ajaxReturn($response);
            }
        } elseif ($type == 'clean') {
            $model->startTrans();
            $rs = $model->where("planId={$planId}")->delete();
            if (!$rs) {
                $model->rollback();
                $response['msg'] = '保存失败';
                $this->ajaxReturn($response);
            }
            $model->commit();
            $response['status'] = 1;
            $response['msg'] = '保存成功';
            $this->ajaxReturn($response);
        }

        /*    $page = empty($_POST['page']) ? 1 : (int)$_POST['page'];
            $count = empty($_POST['count']) ? 10 : (int)$_POST['count'];
            $pre_page = ($page - 1) * $count;
            $limit_page = "$pre_page,$count";*/

        $data = $model->where("planId={$planId}")->field('userId,preGrade,preClass,name,sex')->select();
        if ($data) {
            $response['status'] = 1;
            $response['data'] = $data;
            // $total = (int)$model->where("planId={$planId}")->count();
            //$response['total'] = $total;
            //$response['maxPage'] = ceil($total / $count) > 0 ? 1 : ceil($total / $count);
            $this->ajaxReturn($response);
        }
        $this->ajaxReturn($response);
    }

    //调用考试 已测试 对数据库操作有点多 待优化 @todo
    private function callExam($param){
        $response['msg']='fail';
        $response['status']=0;
        $planId=$param['planId'];
        $type=$param['type'];
        $exam=$param['exam'];
        $grades=D('BranchStudent')->where(array('planId'=>$planId,'scId'=>$this->scId))
            ->field('DISTINCT(preGrade),gradeId')
            ->select();
        $grade=array();
        foreach ($grades as &$v){
            $grade[$v['gradeId']]=$v['preGrade'];
        }
        //得到年级id
        $gradeId=array_map(function($v){
            return $v['gradeId'];
        },$grades);
        //调用考试成绩
        if($type=='sure'){
            $total=D('BranchStudent')->where(array('planId'=>$planId,'scId'=>$this->scId))->count();
            foreach ($exam as &$v){
                $new_exam=array(
                    'examination'=>$v['name'],
                    'examinationId'=>$v['id'],
                    'planId'=>$planId,
                    'scId'=>$this->scId
                );
                $branExamId=D('BranchExam')->data($new_exam)->add();//将考试加入
                //$branExamId=18;
                if(!$branExamId)
                    $this->ajaxReturn($response);

                $subs=D('ExaminationSubject es')
                    ->join('mks_subject s ON es.subject=s.subjectid','LEFT')
                    ->where("es.scId={$this->scId} and es.examinationid={$v['id']}")
                    ->field('es.examinationid as examId,s.subjectid as subId,subjectname as subName')
                    ->select();                             //找出考试的拥有的科目
                $subject=array();
                $old_sub=array();
                foreach ($subs as &$val){
                    $subject[$val['subId']]=array(
                        'subject'=>$val['subName'],
                        'branchExamId'=>$branExamId,
                        'planId'=>$planId,
                        'scId'=>$this->scId,
                        'totalNumber'=>(int)$total,
                        'recordNumber'=>0,
                        'lastRecordTime'=>time()
                    );
                   $old_sub[$val['subName']]=$val['subId'];
                }

                $subjectLists=array_values($subject);
                $rs=D('BranchSubject')->addAll($subjectLists);//将科目加入
                if(!$rs)
                    $this->ajaxReturn($response);
                $new_sub=D('BranchSubject')
                    ->where(array('branchExamId'=>$branExamId,'scId'=>$this->scId,'planId'=>$planId))
                    ->field('id,subject')->select();        //得到科目id
                $map=array();
                foreach ($new_sub as &$k){
                    $map[$old_sub[$k['subject']]]=$k['id'];  //旧id---新id 映射关系
                }

                $subScore=D('BranchStudent bs')
                    ->join('mks_examination_results er ON bs.userId=er.userid','LEFT')
                    ->where("bs.planId={$planId} and bs.scId={$this->scId} and er.examinationid={$v['id']}")
                    ->field('bs.id,bs.subScore,er.subjectid as subId,er.results as score')
                    ->select();                         //得到现有分班学生在考试中各科目的成绩
                $new=array();
                $fillNumber=array();
                foreach($subScore as &$item){
                    if(!isset($new[$item['id']]['subScore']))
                        $new[$item['id']]['subScore']=json_decode($item['subScore'],true);
                    if(!isset($fillNumber[$map[$item['subId']]])) //填写人数
                        $fillNumber[$map[$item['subId']]]=0;
                        $new[$item['id']]['subScore'][$map[$item['subId']]]=(int)$item['score'];
                        $fillNumber[$map[$item['subId']]]+=1;
                }
                $sub_val='';
                foreach ($fillNumber as $k1=>$v1){
                    $sub_val.='(' . "{$k1}" . ',' . "{$v1}" . '),';
                }
                $sub_val = rtrim($sub_val, ',');
                $stu_val = '';
                foreach ($new as $k2 => $v2) {
                    $newScore = json_encode($v2['subScore']);
                    $stu_val .= '(' . "{$k2}" . ',' . "'{$newScore}'" . '),';
                }
                $stu_val = rtrim($stu_val, ',');
                $sub_sql = "insert into mks_branch_subject (id,recordNumber) 
            values {$sub_val} on duplicate key update recordNumber=values(recordNumber)";

                $stu_sql = "insert into mks_branch_student (id,subScore) 
            values {$stu_val} on duplicate key update subScore=values(subScore)";
                $res = M()->execute($sub_sql);
                if(!$res)
                    $this->ajaxReturn($response);
                $res = M()->execute($stu_sql);

                if(!$res)
                    $this->ajaxReturn($response);
            }
            $response['msg']='success';
            $response['status']=1;
            $this->ajaxReturn($response);
        }
        //得到考试
        $exams=D('Examination')
            ->where(array('gradeid'=>array('in',$gradeId),'scId'=>$this->scId))->field('gradeid,examinationid,examination')
            ->select();
        $exam=array();
        foreach ($exams as &$v){
            $exam[]=array(
                'examId'=>$v['examinationid'],
                'name'=>$v['examination'],
                'grade'=>$grade[$v['gradeid']]
            );
        }
        $this->ajaxReturn($exam);
    }

    //分班成绩依据 //已测试
    public function scoreBasis($planId)
    {
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        $type = $_POST['type'];
        if (!empty($type)) {
            if ($type == 'addExam') {//添加考试依据

                $rs=D('BranchExam')->where(array('examination' => $_POST['exam'], 'planId' => $planId, 'scId' => $this->scId))->find();
                if($rs){
                    $response['msg']='考试已存在';
                    $this->ajaxReturn($response);
                }
                $rs = D('BranchExam')->add(array('examination' => $_POST['exam'], 'planId' => $planId, 'scId' => $this->scId));
            } elseif ($type == 'addSubject') {//添加科目依据
                $rs=D('BranchSubject')->where(array('subject' => $_POST['subject'],
                    'branchExamId' => $_POST['examId']))->find();
                if($rs){
                    $response['msg']='科目已存在';
                    $this->ajaxReturn($response);
                }
                $students = D('BranchStudent')
                    ->where("planId={$planId}")
                    ->field('userId,name,sex,preGrade,preClass')
                    ->order('userId asc')
                    ->select();
                /*foreach ($students as &$v) {
                    $v['score'] = null;
                }
                $score = json_encode($students);*/
                $total = count($students);
                $data = array(
                    'subject' => $_POST['subject'],
                    'branchExamId' => $_POST['examId'],
                    'recordNumber' => 0,
                    'totalNumber' => $total,
                    //'score' => $score,
                    'planId' => $planId,
                    'scId' => $this->scId
                );
                $rs = D('BranchSubject')->add($data);
            } elseif ($type == 'delExam') {//删除考试依据
                $rs = D('BranchExam')->where("id={$_POST['examId']}")->delete();
                if ($rs) {
                    $rs = D('BranchSubject')->where("branchExamId={$_POST['examId']}")->delete();
                }
            } elseif ($type == 'delSubject') {//删除科目依据
                $rs = D('BranchSubject')->where("id={$_POST['subId']}")->delete();
            } else {
                $response['msg'] = '没权限进行操作';
                $this->ajaxReturn($response);
            }
            if ($rs) {
                $response['status'] = 1;
                $response['msg'] = '操作成功';
                $this->ajaxReturn($response);
            } else {
                $response['msg'] = '操作失败';
                $this->ajaxReturn($response);
            }
        }

        $where = array(
            'e.planId' => $planId,
            'e.scId' => $this->scId);
        //得到分班成绩依据
        $data = M('BranchExam e')
            ->join('mks_branch_subject s ON e.id=s.branchExamId', 'LEFT')
            ->where($where)
            ->field('e.id as examId,e.examination,e.planId,s.id as subId,s.subject')
            ->select();

        if (!$data) {
            $this->ajaxReturn($response);
        }
        $response['data'] = $data;
        $this->ajaxReturn($response);
    }

    //成绩管理 //已测试
    public function scoreManage($planId)
    {
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        $type = $_POST['type'];
        /*        $field = 'id,subject,totalNumber,recordNumber';
                if (!empty($type)) {
                    if ($type == 'record') {
                        $field = 'id,score';
                    } elseif ($type == 'save') {
                        $score = json_encode($_POST['score']);
                        $i = 0;
                        foreach ($score as &$v) {
                            if (!is_null($v['score']))
                                $i++;
                        }
                        $data = array(
                            'score' => $score,
                            'recordNumber' => $i
                        );
                        $id = $_POST['id'];
                        $rs = D('BranchSubject')->where("id={$id}")->save($data);
                        if (!$rs) {
                            $response['msg'] = '保存失败';
                            $this->ajaxReturn($response);
                        }
                        $response['msg'] = '保存成功';
                        $this->ajaxReturn($response);
                    } else {
                        $response['msg'] = '没权限进行操作';
                        $this->ajaxReturn($response);
                    }
                }*/
        if (!empty($type)) {
            $subId = $_POST['subId'];
            $students = D('BranchStudent')
                ->where("planId={$planId}")
                ->field('id,userId,name,preClass,preGrade,subScore')
                ->select();
            if ($type == 'record') {
                foreach ($students as $k => $v) {
                    $subScore = json_decode($v['subScore'], true);
                    $score = array_key_exists($subId, $subScore) ? $subScore[$subId] : null;
                    $students[$k]['subScore'] = $score;
                }
                $response['status'] = 1;
                $response['data'] = $students;
                $this->ajaxReturn($response);
            } elseif ($type == 'save') {
                $subId = $_POST['subId'];
                $score = json_decode($_POST['subScore'], true);//userId=>score
                foreach ($students as $k => $v) {
                    $students[$k]['subScore'] = json_decode($students[$k]['subScore'], true);
                    $students[$k]['subScore'][$subId] = $score[$v['userId']];
                }

                $i = 0;
                $val = '';

                foreach ($students as $k => $v) {
                    if (!is_null($v['subScore'][$subId]))  //录入成绩人数
                        $i++;
                    $newScore = json_encode($v['subScore']);
                    $val .= '(' . "{$v['id']}" . ',' . "'{$newScore}'" . '),';
                }

                $data = array(
                    'recordNumber' => $i,
                    'lastRecordTime' => time()
                );
                $rs = D('BranchSubject')->where("id={$subId}")->data($data)->save();
                $val = rtrim($val, ',');
                $sql = "insert into mks_branch_student (id,subScore) 
            values {$val} on duplicate key update subScore=values(subScore)";
                $res = M()->execute($sql);
                if (!$rs || !$res) {
                    $response['msg'] = '保存失败';
                    $this->ajaxReturn($response);
                }
                $response['status'] = 1;
                $response['msg'] = '保存成功';
                $this->ajaxReturn($response);
            } else {
                $response['msg'] = '没权限进行操作';
                $this->ajaxReturn($response);
            }
        }

        $exId = $_POST['examId'];
        $field = 'id,subject,totalNumber,recordNumber';
        $subject = D('BranchSubject')->where("planId={$planId} and branchExamId={$exId}")
            ->field($field)
            ->select();
        if (!$subject) {
            $this->ajaxReturn($response);
        }
        $response['status'] = 1;
        $response['data'] = $subject;
        $this->ajaxReturn($response);
    }

    //调用科类  //已测试
    private function callBranch(){
        $response['data']=array();
        $rs=D('Branch')->where("scId={$this->scId}")->field('id,name')->select();
        if(!$rs)
            $this->ajaxReturn($response);
        $response['data']=$rs;
        $this->ajaxReturn($response);
    }

    //调用专业  //已测试
    private function callMajor($param){
        $response['data']=array();
        $rs=D('Branch')->where("branchId={$param['branchId']}")->field('id,name')->select();
        if(!$rs)
            $this->ajaxReturn($response);
        $response['data']=$rs;
        $this->ajaxReturn($response);
    }

    //填报志愿设置 //已测试
    public function wishSetting($planId)
    {
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        $type = $_POST['type'];
        if (!empty($type)) {
            if ($type == 'addBranch') {//@todo BUG
                $rs = D('BranchWish')->where(array('branch'=>$_POST['branch'],'planId'=>$planId))->find();
                if ($rs) {
                    $response['msg'] = '科类已存在';
                    $this->ajaxReturn($response);
                }
                $data = array(
                    'branch' => $_POST['branch'],
                    'branchId'=>$_POST['branchId'],
                    'planId' => $planId,
                    'scId'=>$this->scId
                );
                $rs = D('BranchWish')->add($data);
            } elseif ($type == 'addMajor') {
                $rs = D('BranchWish')->where(array(
                    'branch' => $_POST['branch'],
                    'major' => $_POST['major'],
                    'planId' => $planId,
                    'scId'=>$this->scId
                ))->find();
                if ($rs) {
                    $response['msg'] = '专业已存在';
                    $this->ajaxReturn($response);
                }
                $rs = D('BranchWish')->data(array(
                    'branch' => $_POST['branch'],
                    'major' => $_POST['major'],
                    'majorId'=>$_POST['majorId'],
                    'branchId'=>$_POST['branchId'],
                    'planId' => $planId,
                    'scId'=>$this->scId))->add();
            } elseif ($type == 'delBranch') {
                $where = array(
                    'branch' => $_POST['branch'],
                    'planId' => $planId,
                );
                $rs = D('BranchWish')->where($where)->delete();
            } elseif ($type == 'delMajor') {
                $wishId = $_POST['id'];
                $rs = D('BranchWish')->where("id = {$wishId}")->delete();
            } else {
                $response['msg'] = '没权限进行操作';
                $this->ajaxReturn($response);
            }
            if ($rs) {
                $response['status'] = 1;
                $response['msg'] = '操作成功';
                $status=D('BranchProcess')
                    ->where(array('planId'=>$planId,'scId'=>$this->scId,'step'=>3))
                    ->getField('status');

                if($status!=1){
                    $process=array(4=>1);
                }else{
                    $process=array(4=>1,5=>2);
                }
                $this->changeProcess($process,$planId);
                $this->ajaxReturn($response);
            } else {
                $response['msg'] = '操作失败';
                $this->ajaxReturn($response);
            }
        }

        $wish = D('BranchWish')->where("planId={$planId}")->field('id,branch,major')->select();
        if ($wish) {
            $data = array();
            foreach ($wish as &$v) {
                if (!array_key_exists($v['branch'], $data))
                    $data[$v['branch']] = array();
                $data[$v['branch']][] = $v;
            }
            $response['data'] = $data;
            $response['status'] = 1;
        }
        $this->ajaxReturn($response);
    }

    //成绩统计设置
    //得到科类/专业
    private function getWish($param)
    {
        $planId=$param['planId'];
        $wish = array();
        $data = D('BranchWish')->where("planId={$planId}")
            ->field('id as wishId,branch,major')
            ->select();
        if (!$data)
            return false;
        foreach ($data as &$v) {
            if (!array_key_exists($v['branch'], $wish))
                $wish[$v['branch']] = array();
            $wish[$v['branch']][] = $v;
        }
        $this->ajaxReturn($wish);
    }

    //得到待选考试及科目
    private function getSubject($param)
    {
        $planId=$param['planId'];
        $subject = array();
        $data = D('BranchExam e')
            ->join('mks_branch_subject s ON e.id=s.branchExamId', 'LEFT')
            ->where("s.planId={$planId}")
            ->field('e.id as examId,e.examination,s.id as subId,s.subject')
            ->select();
        if (!$data)
            return false;

        foreach ($data as &$v) {
            if (!array_key_exists($v['examination'], $subject))
                $subject[$v['examination']] = array();
            $subject[$v['examination']][] = $v;
        }
        $this->ajaxReturn($subject);
    }

    //已测试
    public function scoreSetting($planId)
    {//成绩统计设置
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        $type = $_POST['type'];
        $rs = false;
        if (!empty($type)) {
            if ($type == 'save') {//添加分数比重
                $ratio = $_POST['ratio'];
                //$subRatio=json_encode($_POST['subjectRatio']);
                $ratio = array(
                    'ratio' => $ratio,
                );
                $rs = D('BranchWish')->where("id={$_POST['wishId']}")->data($ratio)->save();
            }
            if ($rs) {
                $response['status'] = 1;
                $response['msg'] = '保存成功';
                $process=array(
                    5=>1,6=>3
                );
                $this->changeProcess($process,$planId);
                $this->scoreCombine($planId);
                $this->ajaxReturn($response);
            } else {
                $response['msg'] = '操作失败';
                $this->ajaxReturn($response);
            }
        }
        $response['wish'] = $this->getWish($planId) ? $this->getWish($planId) : array();
        $response['subject'] = $this->getSubject($planId) ? $this->getSubject($planId) : array();
        $data = D('BranchWish')->where("planId={$planId}")->field('id as wishId,ratio')
            ->select();
        if (!$data) {
            $this->ajaxReturn($response);
        }
        $response['status'] = 1;
        $response['data'] = $data;
        $this->ajaxReturn($response);
    }

    //合成成绩  //已测试
     public function scoreCombine($planId)
    {//合成成绩
        //得到比重规则
        $ratios = D('BranchWish')->where("planId={$planId}")
            ->field('id,ratio')->select();//subId=>ratio,examRatio
        if (!$ratios)
            return false;
        $ratio = array();
        foreach ($ratios as &$temp) {
            $ratio[$temp['id']] = json_decode($temp['ratio'], true);//wishId=>subId=>ratio,examRatio
        }
        //得到成绩
        $students = D('BranchStudent')
            ->where("planId={$planId}")
            ->field('id,userId,subScore')
            ->select();


        //得到合成成绩

        foreach ($ratio as $w => $r) {//一个专业的比重
            $rankScore = array();
            foreach ($students as $k => $v) {//v每个学生
                $subScore = json_decode($v['subScore'], true);
                $score = json_decode($v['comScore'], true);
                foreach ($r as $sId => $rs) {//rs包含sub,exam的比重
                    if (!array_key_exists($w, $score))
                        $score[$w] = array(
                            'score' => 0,
                        );
                    $score[$w]['score'] += $rs['examRatio'] * (int)$subScore[$sId] * $rs['ratio'];
                }

                $rankScore[$v['userId']] = $score[$w]['score'];
                $students[$k]['comScore'] = json_encode($score);
            }

            //得到排名
            arsort($rankScore);
            $rankScore = array_keys($rankScore);

            foreach ($students as $k => $v) {
                $rank = json_decode($v['comRank'], true);
                $perRank = array_search($v['userId'], $rankScore) + 1;
                $rank[$w] = $perRank;
                $students[$k]['comRank'] = json_encode($rank);
            }
        }

        $cnt = count($students);
        $val = '';
        for ($i = 0; $i < $cnt; $i++) {
            $val .= '(' . $students[$i]['id'] . ',' . "'{$students[$i]['comScore']}'" . ','
                . "'{$students[$i]['comRank']}'" . '),';
        }
        $val = rtrim($val, ',');
        $sql = "insert into mks_branch_student (id,comScore,comRank) 
            values {$val} on duplicate key update comScore=values(comScore),comRank=values(comRank)";

       $rs= M()->execute($sql);
        return $rs;
    }

    //合成成绩统计    //已测试
    public function scoreStatistics($planId, $sort)
    {//$sort 1成绩汇总 2 成绩明细
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        if ($sort == 1) {
            $field = 'userId,preGrade,preClass,name,comScore,comRank';
        } elseif ($sort == 2) {
            $field = 'userId,preGrade,preClass,name,comScore,comRank,subScore';
        }
        $data = D('BranchStudent')->where("planId={$planId}")->field($field)->select();
        if ($data) {
            $response['status'] = 1;
            $response['data'] = $data;
            $this->ajaxReturn($response);
        }
        $this->ajaxReturn($response);
    }

    //得到一个方案对应的科类和专业
    public function getAllWish($planId)
    {
        $data = D('BranchWish')
            ->where("planId={$planId}")
            ->field('id,branch,branchId,major,majorId')
            ->select();
        $wish = array();
        if (!$data)
            return $wish;
        foreach ($data as &$v) {
            $wish[$v['branch']][] = array(
                'id' => $v['id'],
                'branchId' => $v['branchId'],
                'major' => $v['major'],
                'majorId' => $v['majorId']
            );
        }
        return $wish;
    }

    //学生志愿调整    //已测试
    public function wishAdjust($planId)
    {
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        $type = $_POST['type'];
        if (!empty($type)) {
            if ($type == 'save') {
                $stus = D('BranchStudent')->where("planId={$planId}")->field('id,comScore,comRank')->select();
                $rank = array();
                $score = array();
                foreach ($stus as $k => $v) {
                    $score[$v['id']] = json_decode($v['comScore'], true);
                    $rank[$v['id']] = json_decode($v['comRank'], true);
                }

                $val = '';
                $wish = $_POST['wish'];

                $wish = json_decode($wish,true);


                $cnt = count($wish);
                for ($i = 0; $i < $cnt; $i++) {
                    $val .= '(' . $wish[$i]['sId'] . ',' . $wish[$i]['wishId'] .
                        ',' . "'{$wish[$i]['branch']}'" . ',' . "'{$wish[$i]['major']}'" .
                        ',' . $score[$wish[$i]['sId']][$wish[$i]['wishId']]['score']
                        . ',' . $rank[$wish[$i]['sId']][$wish[$i]['wishId']] .
                        '),';
                }
                $val = rtrim($val, ',');
                $sql = "insert into mks_branch_student (id,wishId,branch,major,score,rank) 
            values {$val} on duplicate key update wishId=values(wishId),branch=values(branch),major=values(major)
            ,score=values(score),rank=values(rank)";

                $rs = M()->execute($sql);
                if (!$rs) {
                    $response['msg'] = '保存失败';
                    $this->ajaxReturn($response);
                }
                $response['msg'] = '保存成功';
                $response['status'] = 1;
                $this->ajaxReturn($response);
            } else {
                $response['msg'] = '没权限进行操作';
                $this->ajaxReturn($response);
            }
        }
        $students = D('BranchStudent s')->join('mks_branch_wish w ON s.wishId=w.id', 'LEFT')
            ->where("s.planId={$planId}")
            ->field('s.id as sId,s.userId,s.name,s.preClass,s.preGrade,s.wishId,w.id as wId,w.branch,w.major')
            ->select();
        if (!$students)
            $this->ajaxReturn($students);
        $response['data'] = $students;
        $response['status'] = 1;
        $this->ajaxReturn($response);
    }

    //学生志愿统计    //已测试
    public function wishStatistics($planId, $sort)
    { //1志愿填报情况 2成绩分布情况
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        if ($sort == 1) {
            $students = D('BranchStudent')->where(array(
                'planId' => $planId
            ))->select();
            if (!$students)
                $this->ajaxReturn($response);
            //学生填报志愿进度图 wishStu
            //各科类学生志愿分布图 wishStuBra
            //各专业学生志愿分布图  wishStuMaj
            //各班志愿填报进步统计图   wishClass
            //各班志愿分布图-科类    wishClassBra
            //各班志愿分布图-专业    wishClassMaj
            $wishStu = array(
                'not' => 0,
                'al' => 0
            );
            $wishStuBra = array();
            $wishStuMaj = array();
            $wishClass = array();
            $wishClassBra = array();
            $wishClassMaj = array();

            foreach ($students as &$v) {
                if (!isset($wishStuBra[$v['branch']]))
                    $wishStuBra[$v['branch']] = 0;
                if (!isset($wishStuBra[$v['branch']]))
                    $wishStuBra[$v['branch']] = 0;
                if (!isset($wishStuMaj[$v['major']]))
                    $wishStuMaj[$v['major']] = 0;
                if (!isset($wishClass[$v['preGrade']][$v['preClass']]))
                    $wishClass[$v['preGrade']][$v['preClass']] = array(
                        'not' => 0,
                        'alr' => 0,
                    );
                if (!isset($wishClassBra[$v['preGrade']][$v['preClass']][$v['branch']]))
                    $wishClassBra[$v['preGrade']][$v['preClass']][$v['branch']] = 0;
                if (!isset($wishClassMaj[$v['preGrade']][$v['preClass']][$v['major']]))
                    $wishClassMaj[$v['preGrade']][$v['preClass']][$v['major']] = 0;


                $wishStuBra[$v['branch']] += 1;
                $wishStuBra[$v['branch']] += 1;
                $wishStuMaj[$v['major']] += 1;
                if (!empty($v['wishId'])) {
                    $wishStu['al'] += 1;
                    $wishClass[$v['preGrade']][$v['preClass']]['al'] += 1;
                } else {
                    $wishStu['not'] += 1;
                    $wishClass[$v['preGrade']][$v['preClass']]['not'] += 1;
                }
                $wishClassBra[$v['preGrade']][$v['preClass']][$v['branch']] += 1;
                $wishClassMaj[$v['preGrade']][$v['preClass']][$v['major']] += 1;
            }
            $response['wishStu'] = $wishStu;
            $response['wishStuBra'] = $wishStuBra;
            $response['wishStuMaj'] = $wishStuMaj;
            $response['wishClass'] = $wishClass;
            $response['wishClassBra'] = $wishClassBra;
            $response['wishClassMaj'] = $wishClassMaj;
            $response['status'] = 1;
            $this->ajaxReturn($response);
        } elseif ($sort == 2) {
            $genre = $_POST['genre'];
            $students = D('BranchStudent')->where("planId={$planId}")
                ->field('wishId,preGrade,preClass,rank')->select();
            if (!$students)
                $this->ajaxReturn($response);
            $segment = $_POST['segment'];
            $situation = array();
            $cnt = count($segment);
            if ($genre == 'class') {//各班填报志愿成分布情况统计
                foreach ($students as &$v) {
                    for ($i = 0; $i < $cnt; $i++) {
                        if (!isset($situation[$v['preGrade']][$v['preClass']][$i]))
                            $situation[$v['preGrade']][$v['preClass']][$i] = 0;
                        if ((int)$v['rank'] <= (int)$segment[$i]) {
                            $situation[$v['preGrade']][$v['preClass']][$i] += 1;
                        }
                    }
                }
            } elseif ($genre == 'branch') {//各科类填报志愿成绩分布情况统计
                foreach ($students as &$v) {
                    for ($i = 0; $i < $cnt; $i++) {
                        if (!isset($situation[$v['wishId']][$i]))
                            $situation[$v['wishId']][$i] = 0;
                        if ($v['rank'] <= $segment[$i]) {
                            $situation[$v['wishId']][$i] += 1;
                        }
                    }
                }
            }
            $response['data'] = $situation;
            $response['status'] = 1;
            $this->ajaxReturn($response);
        }
        $this->ajaxReturn($response);
    }

    //未报志愿学生名单  //已测试
    public function wishNot($planId)
    {
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        $where = array(
            'planId' => $planId,
            'wishId' => null
        );
        $students = D('BranchStudent')
            ->where($where)
            ->field('id,userId,preClass,preGrade,name,sex')
            ->select();
        if (!$students)
            $this->ajaxReturn($students);
        $response['status'] = 1;
        $response['data'] = $students;
        $this->ajaxReturn($response);
    }

    //志愿确认名单    //已测试
    public function wishConfirm($planId)
    {
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        $students = D('BranchStudent s')
            ->join('mks_branch_wish w ON s.wishId=w.id', 'LEFT')
            ->where("s.planId={$planId}")
            ->field('s.id as sId,s.userId,s.preSerialNumber,s.preClass,s.preGrade,s.name,s.confirm,
            w.id as wId,w.branch,w.major')
            ->order('s.preClass asc')
            ->select();
        if (!$students)
            $this->ajaxReturn($students);
        $response['status'] = 1;
        $response['data'] = $students;
        $this->ajaxReturn($response);
    }

    //得到各年级各科类各专业的人数
    function getAllStu($planId)
    {
        $students = D('BranchStudent')->where("planId={$planId}")->select();
        $data = array();

        foreach ($students as &$v) {
            if (!isset($data[$v['preGrade']][$v['branch']]['major'][$v['major']]))
                $data[$v['preGrade']][$v['branch']]['major'][$v['major']] = 0;
            if (!isset($data[$v['preGrade']][$v['branch']]['total']))
                $data[$v['preGrade']][$v['branch']]['total'] = 0;
            $data[$v['preGrade']][$v['branch']]['major'][$v['major']] += 1;
            $data[$v['preGrade']][$v['branch']]['total'] += 1;
        }

        $rs = D('BranchStudent')->where(array(
            'planId' => $planId,
            'wishId' => null
        ))->count();

        if (is_bool($rs) || !$students)
            return array();
        $response['stu'] = $data;
        $response['not'] = $rs;
        //$this->ajaxReturn($data);
        return $response;
    }

    //拟分班设置 //已测试
    public function classSetting($planId)
    {
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        $type = $_POST['type'];
        if (!empty($type)) {
            if ($type == 'save') {
                $class = $_POST['class'];//@todo
                $grade = (int)$_POST['grade'];
                $braClass = array(
                    'grade' => $grade,
                    'class' => $class,
                    'planId' => $planId
                );
                $rs = D('BranchClass')->where("grade={$grade} and planId={$planId}")->find();
                if ($rs)
                    $rs = D('BranchClass')->where("grade={$grade} and planId={$planId}")->data($braClass)->save();
                else
                    $rs = D('BranchClass')->data($braClass)->add();
            } elseif ($type == 'set') {
                $grade = $_POST['grade'];
                $stu = json_decode($_POST['stu'], true);
                $number = (int)$_POST['number'];
                $stu = $stu[$grade];
                $braClass = array();
                $j = 1;//班级名
                $wishes = D('BranchWish')->where("planId={$planId}")->field('id,major')->select();
                $wish = array();
                foreach ($wishes as &$v) {
                    $wish[$v['major']] = (int)$v['id'];
                }

                foreach ($stu as $key => $val) {
                    $k = ceil((int)$val['total'] / $number);//班级总数
                    $everyNumber = ceil((int)$val['total'] / $k);
                    $majorNumber = array();
                    foreach ($val['major'] as $x => $y) {
                        $majorNumber[$wish[$x]] = array(
                            'major' => $x,
                            'number' => ceil((int)$y / $k)
                        );
                    }
                    //每个班每个专业分多少人
                    for ($i = 0; $i < $k; $i++) { //$i班级数
                        $braClass[] = array(
                            'name' => $i + $j,
                            'grade' => $grade,
                            'branch' => $key,
                            'level' => 1,//默认平行班
                            'number' => $everyNumber,
                            'majorNumber' => $majorNumber
                        );
                        $index = $i + $j;
                    }
                    $j = $index;
                    $j++;//班级名
                }
                $response['data'] = $braClass;
                $response['status'] = 1;
                //$this->ajaxReturn($response);
                $this->ajaxReturn($braClass);
            } else {
                $response['msg'] = '没权限进行操作';
                $this->ajaxReturn($response);
            }
            if (!$rs) {
                $response['msg'] = '操作失败';
                $this->ajaxReturn($response);
            }
            $response['msg'] = '保存成功';
            $response['status'] = 1;
            $this->ajaxReturn($response);
        }


        $stu = $this->getAllStu($planId);

        if (empty($stu))
            $this->ajaxReturn($response);
        $response['not'] = $stu['not'];//没填志愿你的人数
        $response['stu'] = $stu['stu'];//一些展示信息
        $class = D('BranchClass')->where("planId={$planId}")->select();
        if (!$class)
            $this->ajaxReturn($response);
        $response['data'] = $class;
        $response['status'] = 1;
        $this->ajaxReturn($response);
    }

    //获得首字母
    function getFirstCharter($str)
    {
        if (empty($str)) {
            return '';
        }
        $fchar = ord($str{0});
        if ($fchar >= ord('A') && $fchar <= ord('z')) return strtoupper($str{0});
        $s1 = iconv('UTF-8', 'gb2312', $str);
        $s2 = iconv('gb2312', 'UTF-8', $s1);
        $s = $s2 == $str ? $s1 : $str;
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 && $asc <= -20284) return 'A';
        if ($asc >= -20283 && $asc <= -19776) return 'B';
        if ($asc >= -19775 && $asc <= -19219) return 'C';
        if ($asc >= -19218 && $asc <= -18711) return 'D';
        if ($asc >= -18710 && $asc <= -18527) return 'E';
        if ($asc >= -18526 && $asc <= -18240) return 'F';
        if ($asc >= -18239 && $asc <= -17923) return 'G';
        if ($asc >= -17922 && $asc <= -17418) return 'H';
        if ($asc >= -17417 && $asc <= -16475) return 'J';
        if ($asc >= -16474 && $asc <= -16213) return 'K';
        if ($asc >= -16212 && $asc <= -15641) return 'L';
        if ($asc >= -15640 && $asc <= -15166) return 'M';
        if ($asc >= -15165 && $asc <= -14923) return 'N';
        if ($asc >= -14922 && $asc <= -14915) return 'O';
        if ($asc >= -14914 && $asc <= -14631) return 'P';
        if ($asc >= -14630 && $asc <= -14150) return 'Q';
        if ($asc >= -14149 && $asc <= -14091) return 'R';
        if ($asc >= -14090 && $asc <= -13319) return 'S';
        if ($asc >= -13318 && $asc <= -12839) return 'T';
        if ($asc >= -12838 && $asc <= -12557) return 'W';
        if ($asc >= -12556 && $asc <= -11848) return 'X';
        if ($asc >= -11847 && $asc <= -11056) return 'Y';
        if ($asc >= -11055 && $asc <= -10247) return 'Z';
        return null;
    }

    //生成分班     //已测试
    public function quickDivide($planId, $classLimit, $fill, $distribute, $sex,$priority,$snake,$numberLimit)
    {

        //得到所有班级
        $classes = D('BranchClass')->where("planId={$planId}")->select();

        //得到所有填了志愿的学生
        $students = D('BranchStudent')->where("planId={$planId} and assign=0")
            ->field('id,userId,name,sex,wishId,branch,major,preGrade,preClass,preSerialNumber,score,rank')
            ->select();
        shuffle($students);//将学生顺序打乱
        $stuTree = array();//将学生分为男女两大类
        foreach ($students as &$v) {
            if (!isset($stuTree[$v['preGrade']][$v['wishId']]))
                $stuTree[$v['preGrade']][$v['wishId']] = array();
            $stuTree[$v['preGrade']][$v['wishId']][] = $v;
        }

        //$generate = $_POST['generate'];

        /*$classLimit 班级限制 level 级别优先 parallel 所有班平行
        $fill 分配形式 sequence 按照班级序号 parallel 班级平行
        $distribute 分配方式 score 按照分数分配 random 随机分配
        $sex 性别 ave平均分配 random 随机*/

        //班级处理 //已测试
        $tempClass = array();
        foreach ($classes as $key => $val) {
            $tempClass[$val['grade']] = json_decode($val['class'], true);
        }

        $newClass = array();
        if ($classLimit == 'level') { //级别优先 将班级放入各自级别
            foreach ($tempClass as $k => $v) {
                foreach ($v as &$v1) {
                    /*if (!isset($newClass[$k][$v1['level']]))
                        $newClass[$k][$v1['level']] = array();
                    $newClass[$k][$v1['level']][] = $v1;*/
                    foreach ($priority as $key=>$levels){
                        if(!in_array($v1['level'],$levels))
                            continue;
                        else{
                            if (!isset($newClass[$k][$key]))
                                $newClass[$k][$key] = array();
                            $newClass[$k][$key][] = $v1;
                        }
                    }
                }
            }
            foreach ($newClass as $k => $v) {//按照优先级排序 key升序
                ksort($newClass[$k]);
            }
        } else {
            foreach ($tempClass as $k => $v) { //平行 将所有班级放入一个级别
                $newClass[$k][0] = $v;
            }
        }

        $proClass = array();

        //人数分配形式 一个班级一个班级的填充 按序号 number为总人数 平行 number=1

        foreach ($newClass as $grade => $level) {
            //取出相应的学生 $stuTree[$grade][$wishId]
            $grade_stu = $stuTree[$grade];

            if ($distribute == 'score') {
                foreach ($grade_stu as $w => $v) {
                    if ($sex == 'ave') {
                        $male = array();
                        $female = array();
                        foreach ($v as $key => $oneStu) {
                            if ($oneStu['sex'] == '男') {
                                $male[] = $oneStu;
                            } else {
                                $female[] = $oneStu;
                            }
                        }
                        usort($male, function ($a, $b) {
                            $al = (int)$a['rank'];
                            $bl = (int)$b['rank'];
                            if ($al == $bl)
                                return 0;
                            return ($al < $bl) ? -1 : 1; //升序
                        });
                        usort($female, function ($a, $b) {
                            $al = (int)$a['rank'];
                            $bl = (int)$b['rank'];
                            if ($al == $bl)
                                return 0;
                            return ($al > $bl) ? -1 : 1; //降序
                        });
                        $grade_stu[$w] = array_merge($male, $female);
                    } else {
                        usort($grade_stu[$w], function ($a, $b) {
                            $al = (int)$a['rank'];
                            $bl = (int)$b['rank'];
                            if ($al == $bl)
                                return 0;
                            return ($al < $bl) ? -1 : 1; //升序
                        });
                    }
                }
            } else {
                foreach ($grade_stu as $w => $v) {
                    if ($sex == 'ave') {
                        $male = array();
                        $female = array();
                        foreach ($v as $key => $oneStu) {
                            if ($oneStu['sex'] == '男') {
                                $male[] = $oneStu;
                            } else {
                                $female[] = $oneStu;
                            }
                        }
                        $grade_stu[$w] = array_merge($male, $female);
                    }
                }
            }
            foreach ($level as $l => $classes) {
                if ($fill == 'sequence') {//顺序填充 //正确
                    foreach ($classes as $k => $class) {
                        $proClass[$grade][$class['name']]['stu'] = array();
                        foreach ($class['majorNumber'] as $wid => $number) {
                            $fillNumber = $number['number'];
                            $count = count($grade_stu[$wid]);
                            if ($fillNumber > $count)
                                $fillNumber = $count;
                            if($sex=='ave'){
                                $fillNumber1=ceil($fillNumber/2);
                                $fillNumber2=$fillNumber-$fillNumber1;
                                $spliceStu1 = array_splice($grade_stu[$wid], 0, $fillNumber1);
                                $spliceStu2 = array_splice($grade_stu[$wid], -$fillNumber2);
                                $proClass[$grade][$class['name']]['stu']
                                    = array_merge($proClass[$grade][$class['name']]['stu'], $spliceStu1,$spliceStu2);
                            }else{
                                $spliceStu = array_splice($grade_stu[$wid], 0, $fillNumber);
                                $proClass[$grade][$class['name']]['stu']
                                    = array_merge($proClass[$grade][$class['name']]['stu'], $spliceStu);
                            }
                        }
                    }
                } else {//平行填充 //正确
                    do {
                        $flag = false;
                        $label=0;
                        $foo=1;//记录蛇形
                        foreach ($classes as $k => $class) {
                           // var_dump($class['name']);
                            if (!isset($proClass[$grade][$class['name']]['stu']))
                                $proClass[$grade][$class['name']]['stu'] = array();
                            $fillNumber = 1;
                            foreach ($class['majorNumber'] as $wid => $number) {
                                $number=$newClass[$grade][$l][$k]['majorNumber'][$wid]['number'];
                                $count = count($grade_stu[$wid]);
                                if($number==0||$count < 1)
                                    continue;
                                $spliceStu = array_splice($grade_stu[$wid], 0, $fillNumber);
                                $proClass[$grade][$class['name']]['stu']
                                    = array_merge($proClass[$grade][$class['name']]['stu'], $spliceStu);
                                $newClass[$grade][$l][$k]['majorNumber'][$wid]['number'] -= 1;
                                $number=$newClass[$grade][$l][$k]['majorNumber'][$wid]['number'];
                                $count = count($grade_stu[$wid]);
                                if($number==0||$count < 1)
                                    continue;
                                $spliceStu = array_splice($grade_stu[$wid], -1,$fillNumber);
                                $proClass[$grade][$class['name']]['stu']
                                    = array_merge($proClass[$grade][$class['name']]['stu'], $spliceStu);
                                $newClass[$grade][$l][$k]['majorNumber'][$wid]['number'] -= 1;
                                $number=$newClass[$grade][$l][$k]['majorNumber'][$wid]['number'];
                                $count = count($grade_stu[$wid]);
                                //var_dump($count);
                                if ($number > 0 && $count > 0)
                                    $label += $number;
                            }
                        }
                        if($snake)
                        $classes=array_reverse($classes);
                        if ($label > 0)
                            $flag = true;
                    } while ($flag);
                }
                //序号
                if($numberLimit!='random'){
                    if($numberLimit=='score'){
                        foreach ($proClass as $g=>$c){
                            foreach ($c as $class=>$stu){
                                usort($proClass[$g][$class]['stu'], function ($a, $b) {
                                    $al = (int)$a['rank'];
                                    $bl = (int)$b['rank'];
                                    if ($al == $bl)
                                        return 0;
                                    return ($al < $bl) ? -1 : 1; //升序
                                });
                            }
                        }
                    }elseif($numberLimit=='name'){
                        foreach ($proClass as $g=>$c){
                            foreach ($c as $class=>$stu){
                                foreach ($stu as $k=>$v){
                                    foreach ($v as $k1=>$v1){
                                        $proClass[$g][$class][$k][$k1]['char']=$this->getFirstCharter($v1['name']);
                                    }
                                }
                                usort($proClass[$g][$class]['stu'], function ($a, $b) {
                                    $al = $a['char'];
                                    $bl = $b['char'];
                                    if ($al == $bl)
                                        return 0;
                                    return ($al < $bl) ? -1 : 1; //升序
                                });
                            }
                        }
                    }

                }
            }

        }

       return $proClass;
    }

    //得到分班的限制条件
    function getCondition($way,$number,$sex,$equal,$priority){
        $response=array();
        //序号按成绩 否则random
        $response['number']=$number;
        $response['equal']=$equal=='add'?'add':'random';
        $response['sex']=$sex=='ave'?'ave':'random';
        $response['fill']='sequence';
        $response['snake']=false;
        if($way=='random'){
            $response['distribute']='random';
        }elseif($way=='score'){
            $response['distribute']='score';
        }elseif($way=='snake'){
            $response['distribute']='score';
            $response['fill']='parallel';
            $response['snake']=true;
        }
        //priority [[水平1s],[水平2s]] 优先级降序
        if(count($priority)==1){
            $response['classLimit']='parallel';
        }else{
            $response['classLimit']='level';
        }
        return $response;
    }

    //快速分班
    public function quickBranch($planId)
    {
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        $type = $_POST['type'];
        if (!empty($type)) {
            if ($type == 'save') {
                $stuLists = json_decode($_POST['stuLists'], true);
                $val = '';
                foreach ($stuLists as &$v) {
                    $val .= '(' . "{$v['id']}," . "'{$v['proGrade']}'," . "'{$v['proClass']}',"
                        . "'{$v['proSerialNumber']}'),";
                }
                $val = rtrim($val, ',');
                $sql = "insert into mks_branch_student (id,proGrade,proClass,proSerialNumber)
                          values {$val} on duplicate key update proGrade=values(proGrade),
                          proClass=values(proClass),proSerialNumber=values(proSerialNumber)";
                $res = M()->execute($sql);
                if ($res) {
                    $response['msg'] = '保存成功';
                    $response['status'] = 1;
                    $this->ajaxReturn($response);
                }
            } elseif ($type == 'divide') {
                $way=$_POST['way'];
                $number=$_POST['number'];
                $sex=$_POST['sex'];
                $equal=$_POST['equal'];
                $priority=json_decode($_POST['priority'],true);
                $condition=$this->getCondition($way,$number,$sex,$equal,$priority);
                $classLimit = $condition['classLimit'];//班级限制 level 级别优先 parallel 所有班平行
                $fill = $condition['fill'];//分配形式 sequence 按照班级序号 parallel 班级平行
                $distribute = $condition['distribute'];//分配方式 score 按照分数分配 random 随机分配
                $sex = $condition['sex'];//性别 ave平均分配 random 随机
                $snake = $condition['snake'];
                $number = $condition['number'];
                $data = $this->quickDivide($planId, $classLimit, $fill, $distribute, $sex,$priority,$snake,$number);
                $response['data'] = $data;
                $response['status'] = 1;
                $this->ajaxReturn($response);
            } else {
                $response['msg'] = '没权限进行操作';
                $this->ajaxReturn($response);
            }
        }
        $this->ajaxReturn($response);

    }

    //手动调整
    public function manualAdjust($planId)
    {
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        $class = D('BranchClass')->where("planId=$planId")->select();
        $newClass = array();
        foreach ($class as &$v) {
            $temp = json_decode($v['class'], true);
            foreach ($temp as $key => $val) {
                if (!isset($newClass[$val['branch']]))
                    $newClass[$val['branch']] = array();
                $newClass[$val['branch']][] = $val;
            }
        }
    }

    //指定学生到班
    public function assignStudent($stuIds,$proClass,$total){
        $val = '';
        $i=$total;
        foreach ($stuIds as &$v) {
            $i++;
            $val .= '(' . "{$v}," . "'{$proClass['grade']}'," . "'{$proClass['class']}',"
                . "'{$i}'),";
        }
        $val = rtrim($val, ',');
        $sql = "insert into mks_branch_student (id,proGrade,proClass,proSerialNumber)
                          values {$val} on duplicate key update proGrade=values(proGrade),
                          proClass=values(proClass),proSerialNumber=values(proSerialNumber)";
        $res = M()->execute($sql);
        return $res;
    }

    //相邻分数学生互换
    public function equalChange($stuIds,$preClass,$proClass,$planId){
        $i=count($stuIds);
        $notIds=array();
        $fill=array();
        $foo=0;
        $res=false;
        do{
            $i--;
            $where=array(
                'preGrade'=>$proClass['grade'],
                'preClass'=>$proClass['class'],
                'planId'=>$planId
            );
            if(count($notIds)>0){
                $where['id']=array('not in',$notIds);
            }
            $order="(rank-{$stuIds[$foo]['rank']})*(rank-{$stuIds[$foo]['rank']}) asc";
            $changeStu=D('BranchStudent')->where($where)->order($order)->select();
            if(!$changeStu)
                break;
            $fill[]=array(
                'id'=>$stuIds[$foo]['id'],
                'proGrade'=>$proClass['grade'],
                'proClass'=>$proClass['class'],
                'proSerialNumber'=>$changeStu['proSerialNumber'],

            );
            $fill[]=array(
                'id'=>$changeStu[$foo]['id'],
                'proGrade'=>$preClass['grade'],
                'proClass'=>$preClass['class'],
                'proSerialNumber'=>$stuIds[$foo]['proSerialNumber'],
            );
            $foo++;
        }while($i>0);
        if(count($fill)!=$i*2)
            return $res;
        $val = '';
        foreach ($fill as &$v) {
            $i++;
            $val .= '(' . "{$v['id']}," . "'{$v['proGrade']}'," . "'{$v['proClass']}',"
                . "'{$v['proSerialNumber']}'),";
        }
        $val = rtrim($val, ',');
        $sql = "insert into mks_branch_student (id,proGrade,proClass,proSerialNumber)
                          values {$val} on duplicate key update proGrade=values(proGrade),
                          proClass=values(proClass),proSerialNumber=values(proSerialNumber)";
        $res = M()->execute($sql);
        return $res;
    }

    //打印报表
    public function printReport()
    {

    }

    //发布分班结果
    public function publish()
    {

    }

    //同步分科分班数据
    public function sync()
    {

    }


    /*************************************学生操作*******************************************/

    //得到学生参与的分班方案
    public function getBelong(){
        $userId = $this->user['id'];
        $plans=D('BranchStudent')
            ->where("userId={$userId} and scId={$this->scId}")
            ->field('planId')
            ->select();
        $planId=array_map(function($v){
            return $v['planId'];
        },$plans);
        $where=array(
            'p.id'=>array('in',$planId),
            'p.scId'=>$this->scId
        );
        D('BranchPlan')
            ->where($where)->select();
    }

    //填报分班志愿
    public function fillWish()
    {
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        $planId = $_POST['planId'];
        $userId = $this->user['id'];
        $type = $_POST['type'];
        if(isset($type)){
            if($type=='submit'){

            }else{
                $response['msg']='没有权限';
            }
            $this->ajaxReturn($response);
        }
        $plan = D('BranchPlan')->where("id={$planId}")->find();
        if ($plan) {
            if((int)$plan['stuChange']!=1){
                $change=(int) D('BranchStudent')
                    ->where(array('userId' => $userId, 'planId' => $planId))
                    ->getField('change');
                if($change==1){
                }

            }
            $response['data'] = $plan;
            $response['status'] = 1;
        }
        $this->ajaxReturn($response);
    }

    //查看分班结果
    public function branchResult()
    {
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        $planId = $_POST['planId'];
        $userId = $this->user['id'];
        $info = D('BranchStudent')
            ->where("userId={$userId} and planId={$planId}")
            ->field('preClass,preGrade,preSerialNumber,proClass,proGrade,proSerialNumber')
            ->find();

        if ($info) {
            $response['status'] = 1;
            $response['data'] = $info;
        }
        $this->ajaxReturn($response);
    }

    //分班成绩查询
    public function personScore($whether = 1)
    {
        $response = array(
            'status' => 0,
            'msg' => '',
            'data' => ''
        );
        $planId = $_POST['planId'];
        $rs=(int)D('BranchPlan')->where("id={$planId}")->getField('stuSearch');
        if($rs==1){
            $userId = $this->user['id'];
            $info = D('BranchStudent')
                ->where("userId={$userId} and planId={$planId}")
                ->field('comScore,comRank,subScore')
                ->find();
            if ($info) {
                foreach ($info as $k => $v) {
                    $info[$k] = json_decode($v, true);
                }
                $score = array();
                if ($whether == 1) {
                    $foo = D('BranchWish')->where("planId={$planId}")->field('id,branch,major')->select();
                    $wish = array();
                    foreach ($foo as &$v) {
                        $wish[$v['id']] = array(
                            'branch' => $v['branch'],
                            'major' => $v['major']
                        );
                    }
                    $comScore = $info['comScore'];
                    $comRank = $info['comRank'];
                    foreach ($comScore as $k => $v) {
                        $score[$k] = array(
                            'branch' => $wish[$k]['branch'],
                            'major' => $wish[$k]['major'],
                            'score' => $v['score'],
                            'rank' => $comRank[$k]
                        );
                    }
                } else {
                    $foo=D('BranchSubject s')
                        ->join('mks_branch_exam e ON s.branchExamId=e.id','LEFT')
                        ->where("s.planId={$planId}")
                        ->field('s.id as subId,s.subject,e.id as examId,e.examination')
                        ->select();
                    $subject=array();
                    foreach ($foo as &$v){
                        $subject[$v['subId']]=array(
                            'subject'=>$v['subject'],
                            'exam'=>$v['examination']
                        );
                    }
                    $subScore=$info['subScore'];
                    foreach ($subScore as $k=>$v){
                        $score[$k]=array(
                            'exam'=>$subject[$k]['exam'],
                            'subject'=>$subject[$k]['subject'],
                            'score'=>$v,
                            'rank'=>null
                        );
                    }
                }
                $response['status']=1;
                $response['data']=$score;
            }
        }else{
            $response['msg']='本方案学生不可查看成绩';
            $response['status']=1;
        }
        $this->ajaxReturn($response);
    }

    public function test(){
       /* $students = D('BranchStudent')
            ->where("planId=105")
            ->field('id as sId,name,preClass,preGrade,subScore')
            ->select();
        $cnt = count($students);
        $score = array();
        for ($i = 0; $i < $cnt; $i++) {
            $a = array(
                13 => array(
                    'branch' => '理科',
                    'major' => '数学'

                ),
                14 => array(
                    'branch' => '理科',
                    'major' => '教师'

                ),
                15 => array(
                    'branch' => '文科',
                    'major' => '语言'
                ),
            19=> array(
                'branch' => '文科',
                'major' => '哲学'
            )
            );
            $sc = array_rand($a, 1);
            $score[] = array(
                'sId' => $students[$i]['sId'],
                'wishId' => $sc,
                'branch' => $a[$sc]['branch'],
                'major' => $a[$sc]['major'],
            );
        }
        $this->ajaxReturn($score);*/
     $where=array(
          'planId'=>105,
          'scId'=>2
      );
      $rs=D('BranchStudent')->where($where)->data(array('assign'=>0))->save();
    }

}