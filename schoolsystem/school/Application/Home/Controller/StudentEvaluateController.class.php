<?php
/**
 * Created by PhpStorm.
 * User: hujun
 * Date: 2017/9/20
 * Time: 10:10
 */

namespace Home\Controller;

use Home\Model;

/*
 * 学生考评
 * */
ob_end_clean();
class StudentEvaluateController extends Base
{
    protected $leave;
    protected $scId;
    protected $uId;
    protected $roleId;
    protected $user;


    public function __construct()
    {
        parent::__construct();
        $scId = $_SESSION['loginCheck']['data']['scId'];
        $uId = $_SESSION['loginCheck']['data']['userId'];
        $this->roleId = $_SESSION['loginCheck']['data']['roleId'];
        $this->roleId = 22;
        $scId = 2;
        $uId = 1;
        $this->scId = $scId;
        $this->uId = $uId;
        $this->user = D('User')->where(array('id' => $this->uId, 'scId' => $this->scId))->find();
    }

    /*********************************************管理员************************************************/

    //公用接口
    public function common($func, $param = array())
    {
        switch ($func) {
            case 'getSemester':
                $this->getSemester();
                break;
            case 'getScope':
                $this->getScope();
                break;
            case 'getClass':
                $this->getClass();
                break;
            case 'getCheckBox':
                $this->getCheckBox($param['option']);
                break;
            case 'getStuEvaluate':
                $this->getStuEvaluate();
                break;
            default:
                return null;
        }
    }

    //得到学期学年 //已测试
    private function getSemester()
    {
        $now = time();
        $where = array(
            'scId' => $this->scId,
            'startTime' => array('lt', $now),
            'endTime' => array('gt', $now)
        );
        $data = D('SchoolYear')->where($where)->field('yearname,term')->find();
        $this->ajaxReturn($data);
    }

    //学生评教范围 //已测试
    private function getScope()
    {
        $where = array(
            'c.scId' => $this->scId
        );
        $data = D('Class c')
            ->join('mks_grade g ON c.grade=g.gradeid', 'LEFT')
            ->where($where)
            ->field('c.classid,c.classname,c.classType,g.name,g.gradeid')
            ->select();
        $scope = array();
        foreach ($data as &$v) {
            if ($v['classType'] == 1) {
                $temp = '教学班';
            } else {
                $temp = '选课班';
            }
            $scope[$temp][$v['name']][] = array(
                'gradeId' => $v['gradeid'],
                'classId' => $v['classid'],
                'className' => $v['classname']
            );
        }
        $this->ajaxReturn($scope);
    }

    //创建教学评价 //已测试
    public function createEvaluate()
    {

        $response = array(
            'status' => 0,
            'msg' => ''
        );
        $type = $_POST['type'];
        if (isset($type)) {
            if ($type == 'create') {
                $data = $_POST;
                $evaluate = array(
                    'semester' => $data['semester'],
                    'name' => $data['name'],
                    'scope' => implode(',', $data['scope']),
                    'startTime' => strtotime($data['startTime']),
                    'endTime' => strtotime($data['endTime']),
                    'mode' => $data['mode'],
                    'min' => $data['min'],
                    'max' => $data['max'],
                    'comment' => $data['comment'],
                    'createTime' => time(),
                    'creator' => $this->user['name'],
                    'creatorId' => $this->uId,
                    'publish' => 0,
                    'scId' => $this->scId,
                );
                // 保存方案
                $rsId = D('EvaluateTeach')->data($evaluate)->add();
                if (!$rsId) {
                    $response['msg'] = '保存方案失败';
                    $this->ajaxReturn($response);
                }
                //添加教师
                $where_tea = array(
                    'scId' => $this->scId,
                    'classId' => array('in', $_POST['scope'])
                );
                $teacher = D('JwSchedule')->where($where_tea)
                    ->field('className,subject,techerId as teacherId,techerName as teacherName,gradeId,subjectId,classId,gradeName')
                    ->select();
                $record = array();
                foreach ($teacher as &$v) {
                    $record[] = array(
                        'userId' => $v['teacherId'],
                        'name' => $v['teacherName'],
                        'subjectId' => $v['subjectId'],
                        'subject' => $v['subject'],
                        'classId' => $v['classId'],
                        'class' => $v['className'],
                        'gradeId' => $v['gradeId'],
                        'grade' => $v['gradeName'],
                        'total' => 0,
                        'evaluateId' => $rsId,
                        'scId'=>$this->scId
                    );
                }
                $rs = D('EvaluateRecord')->addAll($record);
                if (!$rs) {
                    $response['msg'] = '保存老师失败';
                    $this->ajaxReturn($response);
                }
                //添加学生
                $where_stu = array(
                    's.scId' => $this->scId,
                    's.classId' => array('in', $_POST['scope'])
                );
                $students = D('StudentInfo s')->join('mks_class c on s.classId=c.classid')->where($where_stu)
                    ->field('s.userId,s.name,s.grade,s.gradeId,s.classId,s.className,s.serialNumber,c.classType')
                    ->select();
                $record = array();
                foreach ($students as &$v) {
                    $record[] = array(
                        'classId' => $v['classId'],
                        'class' => $v['className'],
                        'gradeId' => $v['gradeId'],
                        'grade' => $v['grade'],
                        'classType'=>$v['classType'],
                        'serialNumber'=>$v['serialNumber'],
                        'userId' => $v['userId'],
                        'name' => $v['name'],
                        'evaluateId' => $rsId,
                        'joined' => 0,
                        'scId'=>$this->scId
                    );
                }
                $rs = D('EvaluateStudent')->addAll($record);
                if (!$rs) {
                    $response['msg'] = '保存学生失败';
                    $this->ajaxReturn($response);
                }
                $response['status'] = 1;
                $response['msg'] = '操作成功';
            } else {
                $response['msg'] = '没有权限';
            }
        }
        $this->ajaxReturn($response);

    }

    //评分方式设置
    public function modeSetting()
    {
        $response = array(
            'status' => 0,
            'msg' => ''
        );
        $type = $_POST['type'];
        if (isset($type)) {
            if ($type != 'save') {
                $response['msg'] = '没有权限';
                $this->ajaxReturn($response);
            }
            $mode = array(
                'score' => $_POST['score'],
                'field' => implode(',', $_POST['field']),
                'star' => (int)$_POST['star']
            );
            $rs = D('EvaluateMode')->where("id={$_POST['id']}")->save($mode);
            $response['status'] = 1;
            $response['msg'] = '操作成功';
            if (!$rs) {
                $response['status'] = 0;
                $response['msg'] = '操作失败';
            }
            $this->ajaxReturn($response);
        }
        $data = D('EvaluateMode')->where("scId={$this->scId}")->find();
        $response['status'] = 1;
        $response['data'] = $data;
        $this->ajaxReturn($response);
    }

    //教学评价记录
    public function recordEvaluate(){
        $response = array(
            'status' => 0,
            'msg' => ''
        );
        $type = $_POST['type'];
        if (isset($type)) {
            $response['msg'] = '操作成功';
            $response['status'] = 1;
            $rs=false;
            if ($type == 'publish') {
                $id = $_POST['id'];
                $rs = D('EvaluateTeach')->where("id={$id}")->data(array('publish' => 1))->save();
            } elseif ($type == 'del') {
                $id = $_POST['id'];
                //删除相关表
                $map=array(
                    'evaluateId'=>$id
                );
                D('EvaluateRecord')->where($map)->delete();
                D('EvaluateStudent')->where($map)->delete();
                $rs = D('EvaluateTeach')->where("id={$id}")->delete();
            } else {
                $response['msg'] = '没有权限';
            }
            if (!$rs) {
                $response['msg'] = '保存学生失败';
                $this->ajaxReturn($response);
            }
            $response['status'] = 1;
            $response['msg'] = '操作成功';
            $this->ajaxReturn($response);
        }

        $where = array(
            't.scId' => $this->scId
        );

        $data = D('EvaluateTeach t')->join('mks_evaluate_student es ON t.id=es.evaluateId', 'Right')
            ->where($where)
            ->group('es.classId')
            ->field('t.id,t.name,t.startTime,t.endTime,t.mode,t.createTime,es.grade,es.class,es.classType,count(es.id) as total,count(if(es.joined=1,1,null)) as yet')
            ->select();

        if (!$data) {
            $this->ajaxReturn($response);
        }
        $record = array();
        foreach ($data as &$v) {
            if (!isset($record[$v['id']]))
                $record[$v['id']] = array(
                    'id' => $v['id'],
                    'name' => $v['name'],
                    'startTime' => $v['startTime'],
                    'endTime' => $v['endTime'],
                    'mode' => $v['mode'],
                    'createTime' => $v['createTime'],
                    'list' => array(),
                    'yet' => 0,
                    'total' => 0,
                );
            $record[$v['id']]['list'][$v['classType']][] = array(
                'grade' => $v['grade'],
                'class' => $v['class'],
                'total' => $v['total'],
                'yet' => $v['yet']
            );
            $record[$v['id']]['total'] += $v['total'];
            $record[$v['id']]['yet'] += $v['yet'];
        }
        sort($record);
        $response['status'] = 1;
        $response['data'] = $record;
        $this->ajaxReturn($response);
    }

    //下拉框
    // 得到年级
    private function getCheckBox($option){
        $result=array();
        if($option=='class'){
            $scope=D('EvaluateTeach')->where(array('scId'=>$this->scId,'publish'=>1))
                ->field('id,name,scopeInfo')->select();
            foreach ($scope as &$v){
                $temp=json_decode($v['scopeInfo'],true);
                $v['scopeInfo']=$temp['教学班'];
            }
            $result=$scope;
        }elseif ($option=='subject'){
            $where=array(
                't.scId'=>$this->scId,
                'r.type'=>1,
                't.publish'=>1
            );
            $data=D('EvaluateTeach t')
                ->join('mks_evaluate_record r ON t.id=r.evaluateId','RIGHT')
                ->where($where)
                ->field('t.name,t.id,r.subject,r.subjectId,r.gradeId,r.grade')
                ->select();
            foreach ($data as &$v){
                if(!isset($result[$v['name']]))
                    $result[$v['name']]=array(
                        'id'=>$v['id'],
                        'name'=>$v['name'],
                        'scopeInfo'=>array()
                    );
                $result[$v['name']]['scopeInfo'][$v['grade']][]=array(
                    'subjectId'=>$v['subjectId'],
                    'subject'=>$v['subject']
                );
            }
        }elseif($option=='allSubject'){
            $where=array(
                't.scId'=>$this->scId,
                'r.type'=>1,
                't.publish'=>1
            );
            $data=D('EvaluateTeach t')
                ->join('mks_evaluate_record r ON t.id=r.evaluateId','RIGHT')
                ->where($where)
                ->field('t.name,t.id,r.subject,r.subjectId,r.gradeId,r.grade')
                ->select();
            foreach ($data as &$v){
                if(!isset($result[$v['name']]))
                    $result[$v['name']]=array(
                        'id'=>$v['id'],
                        'name'=>$v['name'],
                        'scopeInfo'=>array()
                    );
                $result[$v['name']]['scopeInfo'][]=array(
                    'subjectId'=>$v['subjectId'],
                    'subject'=>$v['subject']
                );
            }
        }elseif ($option=='course'){

        }
        else{
    }
        $this->ajaxReturn($result);
    }

    // 得到班级
    private function getClass(){
        $where=array(
            't.scId'=>$this->scId,
            's.scId'=>$this->scId
        );
        $info=D('EvaluateTeach t')->join('mks_evaluate_student s ON t.id=s.evaluateId','Right')->
        where($where)->group('s.classId')->
        field('t.id,t.name,s.grade,s.gradeId,s.class,s.classId')->select();
        $data=array();
        $i=0;
        foreach ($info as &$v){
            if($data[$i]['id']!=$v['id']){
                $i++;
                $data[$i]=array(
                    'id'=>$v['id'],
                    'name'=>$v['name'],
                    'grades'=>array(),
                    'classes'=>array()
                );
            }
            $temp=array(
                'gradeId'=>$v['gradeId'],
                'grade'=>$v['grade']
            );
            if(!in_array($temp,$data[$i]['grades']))
                $data[$i]['grades'][]=$temp;

            $data[$i]['classes'][]=array(
                    'classId'=>$v['classId'],
                    'class'=>$v['class']
                );
        }
        sort($data);
        $this->ajaxReturn($data);
    }

    //班级评教名单
    public function teachEvaluate(){
        $response=array(
            'status'=>0
        );
        $classId=$_POST['classId'];
        $evaluateId=$_POST['evaluateId'];
        $where=array(
            'classId'=>$classId,
            'evaluateId'=>$evaluateId,
            'scId'=>$this->scId
        );
        $data=D('EvaluateStudent')->where($where)->field('serialNumber,name,joined')->select();
        if($data){
            $response['status']=1;
            $response['data']=$data;
        }
        $this->ajaxReturn($data);
    }

    //选课评教名单 //@ todo
    public function courseEvaluate(){

    }

    //评教数据分析
    public function statisticsEvaluate($option){
        $data=$_POST;
        switch ($option){
            case 'teacher': //各班主任统计
                $teaId=D('Class')->where(array('scId'=>$this->scId))->field('userid')->select();
                $teaId=array_map(function($v){
                    return $v['userid'];
                },$teaId);
                $data=D('EvaluateRecord')
                    ->where(array('userId'=>array('in',$teaId),'gradeId'=>$_POST['gradeId'],
                        'evaluateId'=>$_POST['evaluateId'],'type'=>1))
                    ->field('class,name,total,record')
                    ->select();
                break;
            case 'class'://班级各科统计
                $data=D('EvaluateRecord')
                    ->where(array('classId'=>$_POST['gradeId'],
                        'evaluateId'=>$_POST['evaluateId'],'type'=>1))
                    ->field('subject,name,total,record')
                    ->select();
                break;
            case 'subjectClass'://科目各班统计
                /*$merge=$_POST['merge']; //合班统计
                $group='';
                if($merge==1){

                }*/
                $data=D('EvaluateRecord')
                    ->where(array('subjectId'=>$_POST['subjectId'],'gradeId'=>$_POST['gradeId'],
                        'evaluateId'=>$_POST['evaluateId'],'type'=>1))
                    ->field('class,name,total,record')
                    ->select();
                break;
            case 'subjectGrade'://科目年级统计
                $data=D('EvaluateRecord')
                    ->where(array('subjectId'=>$_POST['subjectId'],
                        'gradeId'=>$_POST['gradeId'],'type'=>1))
                    ->group('gradeId')
                    ->field('grade,total,record')
                    ->select();
                break;
            case 'grade'://年级各科统计
                $data=D('EvaluateRecord')
                    ->where(array('gradeId'=>$_POST['gradeId'],
                        'evaluateId'=>$_POST['evaluateId'],'type'=>1))
                    ->group('gradeId')
                    ->field('subject,total,record')
                    ->select();
                break;
            default :
                break;
        }
        foreach ($data as &$v){
            $v['record']=json_decode($v['record'],true);
        }
        $this->ajaxReturn($data);

    }

    /*********************************************学生************************************************/
    //得到所属评教方案
    private function getStuEvaluate(){
        $class=$this->user['class'];
        $where=array(
            'scId'=>$this->scId,
            '_string'=>"FIND_IN_SET($class,scope)"
        );
        $eva=D('EvaluateTeach')->where($where)->field('id,name,startTime,endTime')->select();
        if(!$eva)
            $eva=array();
        $this->ajaxReturn($eva);
    }


    //学生评分
    public function studentMark()
    {
        $response = array(
            'status' => 0,
            'msg' => ''
        );
        $uId = $this->uId;
        $type = $_POST['type'];
        $evaId = $_POST['evaluateId'];
        $classId = $this->user['class'];
        if (isset($type)) {
            if ($type != 'submit') {
                $response['msg'] = '没有权限';
                $this->ajaxReturn($response);
            }
            $record = $_POST['record'];
            //得到教师id
            $teaId=array_keys($record);
            //得到教师的评价
            $teaRecord=D('EvaluateRecord')->where(array())->field('record')->select();

        }

        $stuRecord = D('EvaluateStudent')
            ->where(array('evaluateId' => $evaId, 'userId' => $this->uId, 'scId' => $this->scId))
            ->field('record,joined')->find(); // @ todo 选课
        if (!$stuRecord) {
            $this->ajaxReturn($response);
        }
        $stuRecord['record'] = json_decode($stuRecord['record'], true);
        $teaRecord = D('EvaluateStudent')
            ->where(array('evaluateId' => $evaId, 'classId' => $classId, 'scId' => $this->scId))
            ->field('id,name,subject,type')
            ->select();
        $record = array();
        if ($stuRecord['joined'] == 1) {
            foreach ($teaRecord as &$v) {
                $record[$v['type']][] = array(
                    'id' => $v['id'],
                    'name' => $v['name'],
                    'subject' => $v['subject'],
                    'mark' => '',
                    'evaluate' => ''
                );
            }
        } else {
            foreach ($teaRecord as &$v) {
                $record[$v['type']][] = array(
                    'id' => $v['id'],
                    'name' => $v['name'],
                    'subject' => $v['subject'],
                    'mark' => $stuRecord['record'][$v['id']]['mark'],
                    'evaluate' => $stuRecord['record'][$v['id']]['evaluate']
                );
            }
        }
        $response['status'] = 1;
        $response['data'] = $record;
        $response['joined']=$stuRecord['joined'];
        $this->ajaxReturn($response);
    }

}