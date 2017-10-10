<?php
/**
 * Created by PhpStorm.
 * User: xiaolong
 * Date: 2017/6/22
 * Time: 14:15
 * 教务管理
 */
namespace Home\Controller;
//use Think\Controller;
//use Vendor\PHPExcel\PHPExcel;
class StudentleaveController extends Base
{
    private function stateToZn($i){
        $array = array(
            1 => '待处理',
            2 => '已维修',
            3 => '维修失败',
            4 => '已验收'
        );
        return $array[$i];
    }
    public function createLeave(){ //新建请假
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'createLeave'){
            $user = M('user')->field('class,className,gradeId,grade')->where(array('scId' => $scId,'id' => $userId))->find();
            //$class = M('class')->where(array('scId' => $scId,'classid' => $user['class']))->find();
            //$approverId = $class['userid'];
            if(M('student_leave_list')->add(array(
                'title' => $_POST['title'],
                'leaveTypeId' => $_POST['leaveTypeId'],
                'startTime' => $_POST['startTime'],
                'endTime' => $_POST['endTime'],
                'times' => $_POST['times'],
                'approverId' => 0,
                'reason' => $_POST['reason'],
                'scId' => $scId,
                'createTime' => date('Y-m-d H:i:s'),
                'userId' => $userId,
                'state' => 0,
                'leaveState' => 0,
                'replaceState' => 0,
                'replaceUserId' => null,
                'gradeId' => $user['gradeId'],
                'classId' => $user['class'],
                'gradeName' => $user['grade'],
                'className' => $user['className']
            ))){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
    }
    public function getLeaveList(){//请假记录
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'getLeaveList'){
            $userName = M('user')->field('name')->where(array('scId' => $scId,'id' => $userId))->find();
            $startTime = '2010-09-13 00:00:00';
            $endTime = date('Y-m-d H:i:s');
            if($_GET['startTime']){
                $startTime = $_GET['startTime'];
            }
            if($_GET['endTime']){
                $endTime = $_GET['endTime'];
            }
            $data = M('student_leave_list')->field('leaveId,title,times,state,createTime')->where(array('userId' => $userId,'scId' => $scId,'createTime' => array(array('gt',$startTime),array('lt',$endTime))))->select();
            foreach($data as $key => $value){
                $data[$key]['userName'] = $userName['name'];
            }
            $this->returnJson(array('stata' => 1,'message' => 'success','data' => $data),true);
        }
    }
    public function replaceLe(){//代学生请假
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'createLeave'){
            $user = M('user')->field('class,className,gradeId,grade')->where(array('scId' => $scId,'id' => $_GET['userId']))->find();
            //$class = M('class')->where(array('scId' => $scId,'classid' => $user['class']))->find();
            //$approverId = $class['userid'];
            if(M('student_leave_list')->add(array(
                'title' => $_POST['title'],
                'leaveTypeId' => $_POST['leaveTypeId'],
                'startTime' => $_POST['startTime'],
                'endTime' => $_POST['endTime'],
                'times' => $_POST['times'],
                'approverId' => 0,
                'reason' => $_POST['reason'],
                'scId' => $scId,
                'createTime' => date('Y-m-d H:i:s'),
                'userId' => $_GET['userId'],
                'state' => 0,
                'leaveState' => 0,
                'replaceState' => 1,
                'replaceUserId' => $userId,
                'gradeId' => $user['gradeId'],
                'classId' => $user['class'],
                'gradeName' => $user['grade'],
                'className' => $user['className']
            ))){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'getStudentList'){
            if($userRoleId == $this::$teacherRoleId){
                $class = M('jw_schedule')->field('classId')->where(array('techerId' => $userId))->group('classId')->order('gradeName,className')->select();
                $count = count($class);
                $classStr = '';
                $i = 1;
                foreach($class as $key => $value){
                    if($count == $i){
                        $classStr = $classStr.$value['classId'];
                    }else{
                        $classStr = $value['classId'].','.$classStr;
                    }
                    $i++;
                }
                $strole = $this::$studentRoleId;
                $user = M('')->query("select name,id from mks_user where scId=$scId and roleId=$strole and class IN ($classStr)");
                $this->returnJson(array('statu' =>1,'message' =>'success','data' => $user),true);
            }
            if($userRoleId == $this::$jZroleId){
                $user = M('user')->field('name,id,childId,childName')->where(array('id' => $userId,'scId' => $scId))->find();
                $userRe[0] = array(
                    'name' => $user['childName'],
                    'id' => $user['childId']
                );
                $this->returnJson(array('statu' =>1,'message' =>'success','data' => $userRe),true);
            }
        }
        if($type == 'valueStudent'){
            $valuePost = $_GET['value'];
            if($userRoleId == $this::$teacherRoleId){
                $class = M('jw_schedule')->field('classId')->where(array('techerId' => $userId))->group('classId')->order('gradeName,className')->select();
                $count = count($class);
                $classStr = '';
                $i = 1;
                foreach($class as $key => $value){
                    if($count == $i){
                        $classStr = $classStr.$value['classId'];
                    }else{
                        $classStr = $value['classId'].','.$classStr;
                    }
                    $i++;
                }
                $strole = $this::$studentRoleId;
                $user = M('')->query("select name,id from mks_user where scId=$scId and roleId=$strole and  name LIKE '%$valuePost%' and class IN ($classStr)");
                $this->returnJson(array('statu' =>1,'message' =>'success','data' => $user),true);
            }
            if($userRoleId == $this::$jZroleId){
                $user = M('user')->field('name,id,childId,childName')->where(array('id' => $userId,'scId' => $scId))->find();
                $userRe[0] = array(
                    'name' => $user['childName'],
                    'id' => $user['childId']
                );
                $this->returnJson(array('statu' =>1,'message' =>'success','data' => $userRe),true);
            }
        }
    }
    public function replaceRecord(){//代请假记录
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'getLeaveList'){
            $startTime = '2010-09-13 00:00:00';
            $endTime = date('Y-m-d H:i:s');
            if($_GET['startTime']){
                $startTime = $_GET['startTime'];
            }
            if($_GET['endTime']){
                $endTime = $_GET['endTime'];
            }
            $data = M('student_leave_list')->field('leaveId,title,times,state,createTime,userId')->where(array('replaceUserId' => $userId,'scId' => $scId,'createTime' => array(array('gt',$startTime),array('lt',$endTime))))->select();
            foreach($data as $key => $value){
                $userName = M('user')->field('name')->where(array('scId' => $scId,'id' => $value['userId']))->find();
                $data[$key]['userName'] = $userName['name'];
            }
            $this->returnJson(array('stata' => 1,'message' => 'success','data' => $data),true);
        }
        if($type == 'export'){
            $startTime = '2010-09-13 00:00:00';
            $endTime = date('Y-m-d H:i:s');
            if($_GET['startTime']){
                $startTime = $_GET['startTime'];
            }
            if($_GET['endTime']){
                $endTime = $_GET['endTime'];
            }
            $data = M('student_leave_list')->field('leaveId,leaveTypeId,title,times,state,createTime,userId')->where(array('replaceUserId' => $userId,'scId' => $scId,'createTime' => array(array('gt',$startTime),array('lt',$endTime))))->select();
            foreach($data as $key => $value){
                $userName = M('user')->field('name')->where(array('scId' => $scId,'id' => $value['userId']))->find();
                $data[$key]['userName'] = $userName['name'];
                $data[$key]['type'] = $this->toLeave($data[$key]['leaveTypeId']);
                $data[$key]['state'] = $this->state($data[$key]['state']);
            }
            $tr = array(
                '0' => array(
                    'en' => 'title',
                    'zh' => '标题'
                ),
                '1' => array(
                    'en' => 'type',
                    'zh' => '类型'
                ),  '2' => array(
                    'en' => 'times',
                    'zh' => '请假天数'
                ), '3' => array(
                    'en' => 'userName',
                    'zh' => '申请人'
                ), '4' => array(
                    'en' => 'state',
                    'zh' => '审批状态'
                ), '5' => array(
                    'en' => 'createTime',
                    'zh' => '申请时间'
                )
            );
            $this->export($data,$tr);
        }
    }
    private function state($id){
        $array = array(
            0 => '未审批',
            1 => '已审批'
        );
        return $array[$id];
    }
    public function leaveApproval(){
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'getGrade'){
            if($this::$teacherRoleId == $userRoleId){
                if($grade[] = M('grade')->where(array('scId' => $scId,'userId' => $userId))->find()){
                    //$class = M('class')->where(array('scId' => $scId,'grade' => $grade[0]['gradeid']))->order('classname asc')->select();
                    $this->returnJson(array('message' => 'success','statu' => 1,'data' => $grade),true);
                }
                if($class[] = M('class')->where(array('scId' => $scId,'userid' => $userId))->find()){
                    $grade[] = M('grade')->where(array('scId' => $scId,'gradeid' => $class[0]['grade']))->find();
                    $this->returnJson(array('message' => 'success','statu' => 1,'data' => $grade),true);
                }
            }else{
                $grade = M('grade')->where(array('scId' => $scId))->order('name')->select();
                $this->returnJson(array('message' => 'success','statu' => 1,'data' => $grade),true);
            }
        }
        if($type == 'getClass'){
            $gradeid = $_GET['gradeid'];
            if($this::$teacherRoleId == $userRoleId){
                if($grade[] = M('grade')->where(array('scId' => $scId,'userId' => $userId))->find()){
                    $class = M('class')->where(array('scId' => $scId,'grade' => $grade[0]['gradeid']))->order('classname asc')->select();
                    $this->returnJson(array('message' => 'success','statu' => 1,'data' => $class),true);
                }
                if($class[] = M('class')->where(array('scId' => $scId,'userid' => $userId))->find()){
                    $grade[] = M('grade')->where(array('scId' => $scId,'gradeid' => $class[0]['grade']))->find();
                    $this->returnJson(array('message' => 'success','statu' => 1,'data' => $class),true);
                }
            }else{
                $class = M('class')->where(array('scId' => $scId,'grade' => $gradeid))->select();
                $this->returnJson(array('message' => 'success','statu' => 1,'data' => $class),true);
            }
        }
        if($type == 'approvalList'){
            $startTime = '2010-09-13 00:00:00';
            $endTime = date('Y-m-d H:i:s');
            if($_GET['startTime']){
                $startTime = $_GET['startTime'];
            }
            if($_GET['endTime']){
                $endTime = $_GET['endTime'];
            }
            $classId = $_GET['classid'];
            $gradeId = $_GET['gradeid'];
            $state = $_GET['state'];
            $data = M('')->query("select leaveId,title,leaveTypeId,times,state,createTime,userId,leaveState from mks_student_leave_list WHERE gradeId=$gradeId AND state=$state AND scId = $scId AND createTime> '$startTime' AND createTime< '$endTime' AND classId IN($classId) ");
            foreach($data as $key => $value){
                $userName = M('user')->field('name')->where(array('scId' => $scId,'id' => $value['userId']))->find();
                $data[$key]['userName'] = $userName['name'];
            }
            $this->returnJson(array('stata' => 1,'message' => 'success','data' => $data),true);
        }
        if($type == 'approvalHandle'){
            $leaveId = $_POST['leaveId'];
            if(M('student_leave_list')->where(array('leaveId' => $leaveId,'scId' => $scId))->setField(array('state' => 1,'approverId' => $userId))){
                $this->returnJson(array('stata' => 1,'message' => 'success'),true);
            }
            $this->returnJson(array('stata' => 0,'message' => 'fail'),true);
        }
        if($type == 'export'){
            $startTime = '2010-09-13 00:00:00';
            $endTime = date('Y-m-d H:i:s');
            if($_GET['startTime']){
                $startTime = $_GET['startTime'];
            }
            if($_GET['endTime']){
                $endTime = $_GET['endTime'];
            }
            $classId = $_GET['classid'];
            $gradeId = $_GET['gradeid'];
            $state = $_GET['state'];
            $data = M('')->query("select leaveId,title,leaveTypeId,times,state,createTime,userId,leaveState from mks_student_leave_list WHERE gradeId=$gradeId AND state=$state AND scId = $scId AND createTime> '$startTime' AND createTime< '$endTime' AND classId IN($classId) ");
            foreach($data as $key => $value){
                $userName = M('user')->field('name')->where(array('scId' => $scId,'id' => $value['userId']))->find();
                $data[$key]['userName'] = $userName['name'];
                $data[$key]['type'] = $this->toLeave($data[$key]['leaveTypeId']);
                $data[$key]['state'] = $this->state($data[$key]['state']);
            }
            $tr = array(
                '0' => array(
                    'en' => 'title',
                    'zh' => '标题'
                ),
                '1' => array(
                    'en' => 'type',
                    'zh' => '类型'
                ),  '2' => array(
                    'en' => 'times',
                    'zh' => '请假天数'
                ), '3' => array(
                    'en' => 'userName',
                    'zh' => '申请人'
                ), '4' => array(
                    'en' => 'state',
                    'zh' => '审批状态'
                ), '5' => array(
                    'en' => 'createTime',
                    'zh' => '申请时间'
                )
            );
            $this->export($data,$tr);
        }
    }
    public function leaveSchool(){
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'approvalList'){
            $startTime = '2010-09-13 00:00:00';
            $endTime = date('Y-m-d H:i:s');
            if($_GET['startTime']){
                $startTime = $_GET['startTime'];
            }
            if($_GET['endTime']){
                $endTime = $_GET['endTime'];
            }
            $classId = $_GET['classid'];
            $gradeId = $_GET['gradeid'];
            $data = M('')->query("select leaveId,title,leaveTypeId,times,state,createTime,userId,leaveState from mks_student_leave_list WHERE gradeId=$gradeId AND scId = $scId AND createTime> '$startTime' AND createTime< '$endTime' AND classId IN($classId) ");
            foreach($data as $key => $value){
                $userName = M('user')->field('name')->where(array('scId' => $scId,'id' => $value['userId']))->find();
                $data[$key]['userName'] = $userName['name'];
            }
            $this->returnJson(array('stata' => 1,'message' => 'success','data' => $data),true);
        }
        if($type == 'leaveSchoolHandle'){
            $leaveId = $_GET['leaveId'];
            if(M('student_leave_list')->where(array('leaveId' => $leaveId,'scId' => $scId))->setField(array('leaveState' => 1,'leaveUserId' => $userId))){
                $this->returnJson(array('stata' => 1,'message' => 'success'),true);
            }
            $this->returnJson(array('stata' => 0,'message' => 'fail'),true);
        }
    }
    public function leaveSelect(){
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'approvalList'){
            $startTime = '2010-09-13 00:00:00';
            $endTime = date('Y-m-d H:i:s');
            if($_GET['startTime']){
                $startTime = $_GET['startTime'];
            }
            if($_GET['endTime']){
                $endTime = $_GET['endTime'];
            }
            $classId = $_GET['classid'];
            $gradeId = $_GET['gradeid'];
            $data = M('')->query("select leaveId,leaveTypeId,title,times,state,createTime,userId,leaveState from mks_student_leave_list WHERE gradeId=$gradeId AND scId = $scId AND createTime> '$startTime' AND createTime< '$endTime' AND classId IN($classId) ");
            foreach($data as $key => $value){
                $userName = M('user')->field('name')->where(array('scId' => $scId,'id' => $value['userId']))->find();
                $data[$key]['userName'] = $userName['name'];
            }
            $this->returnJson(array('stata' => 1,'message' => 'success','data' => $data),true);
        }
        if($type == 'export'){
            $startTime = '2010-09-13 00:00:00';
            $endTime = date('Y-m-d H:i:s');
            if($_GET['startTime']){
                $startTime = $_GET['startTime'];
            }
            if($_GET['endTime']){
                $endTime = $_GET['endTime'];
            }
            $classId = $_GET['classid'];
            $gradeId = $_GET['gradeid'];
            $data = M('')->query("select leaveId,leaveTypeId,title,times,state,createTime,userId,leaveState from mks_student_leave_list WHERE gradeId=$gradeId AND scId = $scId AND createTime> '$startTime' AND createTime< '$endTime' AND classId IN($classId) ");
            foreach($data as $key => $value){
                $userName = M('user')->field('name')->where(array('scId' => $scId,'id' => $value['userId']))->find();
                $data[$key]['userName'] = $userName['name'];
                $data[$key]['type'] = $this->toLeave($data[$key]['leaveTypeId']);
                $data[$key]['state'] = $this->state($data[$key]['state']);
                $data[$key]['leaveState'] = $this->leaveState($data[$key]['leaveState']);
            }
            $tr = array(
                '0' => array(
                    'en' => 'title',
                    'zh' => '标题'
                ),
                '1' => array(
                    'en' => 'type',
                    'zh' => '类型'
                ),  '2' => array(
                    'en' => 'times',
                    'zh' => '请假天数'
                ), '3' => array(
                    'en' => 'userName',
                    'zh' => '申请人'
                ), '4' => array(
                    'en' => 'state',
                    'zh' => '审批状态'
                ), '5' => array(
                    'en' => 'createTime',
                    'zh' => '申请时间'
                ), '6' => array(
                    'en' => 'leaveState',
                    'zh' => '离校状态'
                )
            );
            $this->export($data,$tr);
        }
    }
    private function leaveState($id){
        $array = array(
            0 => '未离校',
            1 => '已离校'
        );
        return $array[$id];
    }
    private function toLeave($id){
        $array = array(
            1 => '事假',
            2 => '病假',
            3 => '其他',
        );
        return $array[$id];
    }
    public function leaveStatistics(){
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'approvalList') {
            $startTime = '2010-09-13 00:00:00';
            $endTime = date('Y-m-d H:i:s');
            if ($_GET['startTime']) {
                $startTime = $_GET['startTime'];
            }
            if ($_GET['endTime']) {
                $endTime = $_GET['endTime'];
            }
            $classId = $_GET['classid'];
            $gradeId = $_GET['gradeid'];
            $data = M('')->query("select times,leaveId,state,leaveTypeId,times,className from mks_student_leave_list WHERE gradeId=$gradeId AND scId = $scId AND createTime> '$startTime' AND createTime< '$endTime' AND classId IN($classId)");
            $dataRe = array();
            $classAll = 0;
            $timeAll = 0;
            foreach($data as $key => $value){
                $dataRe[$value['className']]['allCount']++;
                $dataRe[$value['className']]['allTimes'] = $dataRe[$value['className']]['allTimes']+$value['times'];
                $dataRe[$value['className']][$value['leaveTypeId']]++;
            }
            foreach($dataRe as $key => $value){
                $dataRe[$key]['className'] = $key;
                if(!isset($value[1])){
                    $dataRe[$key][1] = 0;
                }
                if(!isset($value[2])){
                    $dataRe[$key][2] = 0;
                }
                if(!isset($value[3])){
                    $dataRe[$key][3] = 0;
                }
            }
            $return = array();
            foreach($dataRe as $key => $value){
                $return[] = $value;
            }
            $this->returnJson(array('statu' => 1,'message' => 'success','data' => $return),true);
        }
    }
    private function gradeToZhong($gradeName){
        $return = array(
            '1' => '一年级',
            '2' => '二年级',
            '3' => '三年级',
            '4' => '四年级',
            '5' => '五年级',
            '6' => '六年级',
            '7' => '初一',
            '8' => '初二',
            '9' => '初三',
            '10' => '高一',
            '11' => '高二',
            '12' => '高三',
        );
        return $return[$gradeName];
    }
}