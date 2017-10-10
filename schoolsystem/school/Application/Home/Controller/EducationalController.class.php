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
class EducationalController extends Base{
    /**公用的不设置权限*/
    public function getSubjectList(){//得到课程列表//公用的怎么写
        $type = $_GET['type'];
        $scId = $this->get_session('loginCheck',false);
        $scId = $scId['scId'];
        if($type == 'getSubjectList'){ //得到课程列表
            $this->returnJson(array('data' =>M('subject')->where(array('scId' => $scId))->select(),'staut' =>1 ,'message' => 'success'),true);
        }
        if($type == 'getGradeList'){ //得到年级列表
            $this->returnJson(array('data' =>M('grade')->where(array('scId' => $scId))->select(),'statu' =>1 ,'message' =>'success'),true);
        }
        if($type == 'getClassList'){ //得到班级列表
            $this->returnJson(array('data' =>M('class')->where(array('scId' =>$scId,'grade' => $_GET['grade']))->select(),'message' => 'success','statu' =>1),true);
        }
        if($type == 'getTeacherList'){ //得到教师列表
            $field = $_GET['sortType'];
            $sort = $_GET['sort'];
            $this->returnJson(array('statu' => 1,'message' => 'sucess','data' =>M('user')->field('id,teachingSubjects,name,jobNumber,phone')->where(array('scId' => $scId,'roleId' => $this::$teacherRoleId))->order("$field $sort")->select()),true);
        }
    }
    public function teacherSubject(){//任课教师
        $type = $_GET['type'];
        $scId = $this->get_session('loginCheck',false);
        $userId = $scId['userId'];
        $scId = $scId['scId'];
        if($type == 'createTeacherSubject'){
            $data = $_POST['data'];
            $gradeId = $_GET['gradeId'];
            $subjectId = $_GET['subjectId'];
            $model = M('jw_schedule');
            //$data['userId'] = $session['userId'];
            $model->startTrans();
            $model->where(array('gradeId' => $gradeId,'subjectId' => $subjectId,'scId' => $scId))->delete();
            foreach($data as $key => $value){
                $value['userId'] = $userId;
                $value['createTime'] = strtotime(date('Y-m-d H:i:s'));
                $value['scId'] = $scId;
                if(!$model->add($value)){
                    $this->returnJson(array('statu' => 1, 'message' => 'add fail'),true);
                }
            }
            $model->commit();
            $this->returnJson(array('statu' => 1, 'message' => 'add success'),true);
        }
        if($type == 'teacherSubjectCreateAll'){
            $data = $_POST['data'];
            foreach($data as $key => $value){
                foreach($value['data'] as $key1 => $value1){
                    if($value1['id']){
                        M('jw_schedule')->add($value1);
                    }else{
                        unset($value1['id']);
                        unset($value1['scId']);
                        M('jw_schedule')->where(array('scId' => $scId,'id' => $value1['id']))->setField($value1);
                    }
                }
            }
            $this->returnJson(array('statu' => 1, 'message' => 'add success'),true);
        }
        if($type == 'teacherList'){
            $subject = M('subject')->where(array('scId' => $scId))->order('subjectid')->select();
            $gradeId = $_GET['gradeId'];
            $data  = M('')->query("SELECT * FROM mks_jw_schedule WHERE scId=$scId and gradeId=$gradeId  order by gradeName");
            $class = M('class')->where(array('grade' => $gradeId,'scId' => $scId))->select();
            $teacher = M('user')->field('name,id')->where(array('scId' => $scId,'roleId' => $this::$teacherRoleId))->select();
            $classHeader = array();
            $teacherName = array();
            foreach($teacher as $key => $value){
                $teacherName[$value['id']] = $value;
            }
            foreach($class as $key => $value){
                $classHeader[$value['classid']] = $value;
                $classHeader[$value['classid']]['teacherName'] = $teacherName[$value['userid']]['name'];
            }
            $return  = array();
            foreach($data as $key => $value){
                $return[$value['gradeName']][$value['className']][] = $value;
            }
            $array = array();
            foreach($return as $key => $value){
                foreach($value as $key1 => $value){
                    $array[] = $value;
                }
            }
            $i = 0;
            $array1 =array();
            foreach($array as $key => $value){
                foreach($subject as $key2 => $value2){
                    $true = 0;
                    foreach($value as $key1 => $value1){
                        if($value2['subjectid'] == $value1['subjectId']){
                            $array1[$i]['data'][] = $value1;
                            $true = 1;
                        }
                    }
                    if(!$true){
                        $array1[$i]['data'][] = array('id' => '','className' => $value1['className'],'subject' => $value2['subjectname'],'techerId' => '','techerName' => '','subjectId' => $value2['subjectid'],'createTime' =>'',
                            'userId' => '','gradeId' =>$value1['gradeId'],'classId' => $value1['classId'],'scId' => $scId,'gradeName' =>$value1['gradeName']
                        );
                    }
                }
                $array1[$i]['className'] = $value1['className'];
                $array1[$i]['gradeId'] = $value1['gradeId'];
                $array1[$i]['classId'] = $value1['classId'];
                $array1[$i]['gradeName'] = $value1['gradeName'];
                $array1[$i]['techerName'] = $classHeader[$value1['classId']]['teacherName'];
                $i++;
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $array1,'suject' => $subject),true);
        }
        if($type == 'getTeacherSubject'){//得到
            $gradeId = $_GET['gradeId'];
            $class = M('class')->where(array('scId' => $scId,'grade' => $gradeId))->order('classname')->select();
            $subjectId = $_GET['subjectId'];
            $data = M('jw_schedule')->where(array('gradeId' => $gradeId,'subjectId' => $subjectId,'scId' => $scId))->order('className')->select();
            $array = array();
            foreach($class as $key => $value){
                $true = 0;
                foreach($data as $key1 => $value1){
                    if($value['classid'] == $value1['classId']){
                        //       $class
                        $array[] = array('classId' => $value1['classId'],'className' => $value1['className'],'techerId' => $value1['techerId'],'techerName' => $value1['techerName']);
                        $true = 1;
                    }
                }
                if(!$true){
                    $array[] = array('classId' => $value['classid'],'className' => $value['classname'],'techerId' => '','techerName' => '');
                }
            }
            $this->returnJson(array('statu' => 1,'data' => $array ,'message' => 'success'),true);
        }
    }
    public function getGradeName(){
    }
    //班级年级管理
    public function classAndgradeGl(){//班级年级管理
        $type = $_GET['type'];
        $scId = $this->get_session('loginCheck',false);
        $userId = $scId['userId'];
        $scId = $scId['scId'];
        if($type == 'createGrade'){
            $code = $_POST['code'];
            $znName = $_POST['znName'];
            $highestgrade = $_POST['highestgrade'];
            $autoupdate = $_POST['autoupdate'];
            $xiao = explode('X',$znName);
            $chu = explode('C',$znName);
            $gao = explode('G',$znName);
            $name = 0;
            if(count($xiao) == 2){
                $year = date('Y');
                $name = $year-$xiao[1]+1;
            }
            if(count($chu) == 2){
                $year = date('Y');
                $name = $year-$chu[1]+7;
            }
            if(count($gao) == 2){
                $year = date('Y');
                $name = $year-$gao[1]+10;
            }
            if(M('grade')->where(array('scId' => $scId,'code' => $code))->find()){
                if(M('grade')->where(array('scId' => $scId,'code' => $code))->setField(
                    array(
                        'code' => $code,
                        'name' => $name,
                        'znName' => $znName
                    )
                )){
                    $this->returnJson(array('statu' => 1,'message' => 'success'),true);
                }
                $this->returnJson(array('statu' => 0,'message' => 'fail'),true);
            }else{
                if(M('grade')->add(
                    array(
                        'code' => $code,
                        'name' => $name,
                        'znName' => $znName,
                        'scId' => $scId,
                        'autoupdate' => $autoupdate,
                        'highestgrade' => $highestgrade,
                        'createTime' => strtotime('Y-m-d H:i:s')
                    )
                )){
                    $this->returnJson(array('statu' => 1,'message' => 'success'),true);
                }
                $this->returnJson(array('statu' => 0,'message' => 'fail'),true);
            }
        }
        if($type == 'getClassList'){
            $gradeId = $_GET['gradeid'];
            $data  = M('class')->where(array('scId' => $scId,'grade' =>$gradeId))->select();
            $classLeavl = M('class_level')->where(array('scId' => $scId))->select();
            $branch = M('class_branch')->where(array('scId' => $scId))->select();
            $major = M('class_major')->where(array('scId' => $scId))->select();
            $this->returnJson(array('classLeavl' => $classLeavl,'data' => $data,'branch' => $branch,'statu' =>1,'major'=> $major),true);
        }
        if($type == 'createOrUpdataClass'){
            $data = $_POST['data'];
            if($data['classid']){
                M('class')->where()->setField($data);
                $this->returnJson(array('statu' => 1,'message' => 'success'),true);
            }else{
                $data['scId'] = $scId;
                M('class')->add($data);
                $this->returnJson(array('statu' => 1,'message' => 'success'),true);
            }
        }
        if($type == 'deleteClass'){
            $classId = $_POST['classid'];
            $i = 1;
            foreach($classId as $key => $value){
                if(M('class')->where(array('scId' => $scId,'classid' =>$value))->delete()){

                }else{
                    $i = 0;
                }
            }
            if($i){
                $this->returnJson(array('statu' => 1,'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0,'message' => 'fail'),true);
        }
    }
    public function classHeadAndGradeHead(){//班级班主任
        $type = $_GET['type'];
        $scId = $this->get_session('loginCheck',false);
        $scId = $scId['scId'];
        if($type == 'getList'){
            $gradeId = $_GET['gradeid'];
            $grade = M('grade')->where(array('scId' => $scId,'gradeid' => $gradeId))->find();
            if($grade['userId']){
                $user = M('user')->where(array('id' => $grade['userId']))->find();
                $userName = $user['name'];
                $gradeRe = array('userName' => $userName,'name' => 'grade','classid' =>'','userId' => $grade['userId']);
            }else{
                $gradeRe = array('userName' => '','name' => 'grade','userId' => '');
            }
            $class = M('class')->where(array('scId' => $scId,'grade' => $gradeId))->select();
            $classRe = array();
            foreach($class as $key => $value){
                if($value['userid']){
                    $user = M('user')->where(array('id' => $value['userid']))->find();
                    $userName = $user['name'];
                    $classRe[] = array('userName' => $userName,'name' => $value['classname'],'classid' => $value['classid'],'userId' => $value['userid']);
                }else{
                    $classRe[] = array('userName' => '','name' => $value['classname'],'classid' => $value['classid'],'userId' => '');
                }
            }
            $classRe[count($classRe)] = $gradeRe;
            $this->returnJson(array('statu' => 1,'messge' => 'success','data' =>$classRe),true);
        }
        if($type == 'create'){
            $data = $_POST['data'];
            $gradeId = $_POST['gradeid'];
            foreach($data as $key => $value){
                if($value['name'] == 'grade'){
                    M('grade')->where(array('gradeid' => $gradeId,'scId' => $scId))->setField(array('userId' => $value['userId']));
                }else{
                    M('class')->where(array('classid' => $value['classid'],'scId' => $scId))->setField(array('userid' => $value['userId']));
                }
            }
            $this->returnJson(array('statu' => 1,'messge' => 'success'),true);
        }
        if($type == 'classHeadAndGradeHeader'){//得到年级主任，班主任一览表
            $grade = M('grade')->where(array('scId' => $scId))->order('name')->select();
            $class = M('class')->where(array('scId' => $scId))->order('classname')->select();
            $array = array();
            $teacher = M('user')->field('name,id')->where(array('scId' => $scId,'roleId' => $this::$teacherRoleId))->select();
            $teacherTr = array();
            $gradeTr = array();
            foreach($teacher as $key => $value){
                $teacherTr[$value['id']] = $value;
            }
            foreach($grade as $key => $value){
                $value['name'] = $this->gradeToZhong($value['name']);
                $value['userid'] = $value['userId'];
                $value['teacherName'] = $teacherTr[$value['userId']]['name'];
                $value['gradeName'] = $value['name'];
                unset($value['name']);
                unset($value['userId']);
                $gradeTr[$value['gradeid']] = $value;
            }
            //print_r($teacherTr);
            foreach($class as $key1 => $value1){
                $value1['teacherName'] = $teacherTr[$value1['userid']]['name'];
                $gradeTr[$value1['grade']]['data'][] = $value1;
            }
            $this->returnJson(array('statu' => 1,'message' => 'success','data' => $gradeTr),true);
        }
    }
    public function achievementPro(){//成绩证明
        $type = $_GET['type'];
        $scId = $this->get_session('loginCheck',false);
        $userRoleId = $scId['roleId'];
        $userId = $scId['userId'];
        $scId = $scId['scId'];
        if($type == 'getGradeClassStudent'){
            $grade = array();
            if($userRoleId == $this::$teacherRoleId){
                $grade = M('jw_schedule')->field('gradeName')->where(array('scId' => $scId,'techerId' => $userId))->group('gradeId')->select();
            }
            $data = M('student_info')->field('userId,name,gradeId,classId,grade,className')->where(array('scId' => $scId))->order('grade,ClassName')->select();
            $array = array();
            foreach($data as $key => $value){
                $array[$value['grade']][$value['className']][] = $value;
            }
            $array1 = array();
            foreach($grade as $key => $value){
                $array1[$value['gradeName']] = $array[$value['gradeName']];
            }
            $array = $array1;
            $return = array();
            $j = 0;
            foreach($array as $key => $value){
                $return[$j]['gradeName'] = $this->gradeToZhong($key);
                $i = 0;
                foreach($value as $key1 => $value1){
                    $return[$j]['data'][$i]['className'] = $key1;
                    foreach($value1 as $key2 => $value2){
                        $return[$j]['data'][$i]['data'][] = $value2;
                    }
                    $i++;
                }
                $j++;
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $return),true);
        }
        if($type == 'getTestList'){
            $gradeId = $_GET['gradeId'];
            $classId = $_GET['classId'];
            $tests = M('examination')->where(array('gradeid' => $gradeId,'scId' => $scId))->select();
            $return = array();
            foreach($tests as $key => $value){
                $panduan = explode(',',$value['class']);
                foreach($panduan as $key1 => $value1){
                    if($value1 == $classId){
                        $return[] = $value;
                    }
                }
            }
            $this->returnJson(array('statu' => 1,'message' => 'success','data' => $return),true);
        }
        if($type == 'getTestGrade'){
            $userId = $_GET['userId'];
            $examinationid = $_GET['examinationid'];
            $examination = $_GET['examination'];
            $sore = M('examination_results')->where(array('examinationid' => $examinationid,'userid' => $userId,'scId' => $scId))->order('subjectid')->select();
            $subject = M('subject')->where(array('scId' => $scId))->select();
            foreach($sore as $key => $value){
                foreach($subject as $key1 => $value1){
                    if($value['subjectid'] == $value1['subjectid']){
                        $sore[$key]['subjectname'] = $value1['subjectname'];
                    }
                }
            }
            $return = array('data' => $sore,'name' => $examination);
            $this->returnJson(array('data' => $return,'statu' => 1,'message' => 'success'),true);
        }
        if($type == 'exportTestGrade'){
            $userId = $_GET['userId'];
            $examinationid = $_GET['examinationid'];
            $examination = $_GET['examination'];
            $sore = M('examination_results')->where(array('examinationid' => $examinationid,'userid' => $userId,'scId' => $scId))->order('subjectid')->select();
            $subject = M('subject')->where(array('scId' => $scId))->select();
            foreach($sore as $key => $value){
                foreach($subject as $key1 => $value1){
                    if($value['subjectid'] == $value1['subjectid']){
                        $sore[$key]['subjectname'] = $value1['subjectname'];
                    }
                }
            }
            $return = array('data' => $sore,'name' => $examination);
            $tr = array(
                0 => array(
                    'en' => 'subjectname',
                    'zh' => '考试',
                ),
                1 => array(
                    'en' => 'results',
                    'zh' => $examination,
                )
            );
            $this->export($sore,$tr);
        }
    }
    public function zdPro(){
        $type = $_GET['type'];
        $scId = $this->get_session('loginCheck',false);
        $scId = $scId['scId'];
        if($type == 'getUser'){
            $userId = $_GET['userId'];
            $school = M('school')->where(array('scId' => $scId))->find();
            $schoolName = $school['scName'];
            $user = M('student_info')->field('name,sex,birthday,grade,className')->where(array('userId' => $userId))->find();
            $gradeName = $this->gradeToZhong($user['grade']);
            $date = date('Y-m-d');
            $zn = array(
                'name' => $user['name'],
                'birthday' => $user['birthday'],
                'className' => $user['className'],
                'date' => $date,
                'gradeName' => $gradeName,
                'schoolName' => $schoolName
            );
            //中文转拼音
            header("Content-Type:text/html;charset=UTF-8");
            date_default_timezone_set("PRC");
            $showapi_appid = 45730;  //替换此值,在官网的"我的应用"中找到相关值
            $showapi_secret = 'bcf80b1f062f4214a336872fe8cd61e0';  //替换此值,在官网的"我的应用"中找到相关值
            $paramArr = array(
                'showapi_appid'=> $showapi_appid,
                'content'=> "江龙"
                //添加其他参数
            );
            //创建参数(包括签名的处理)
            function createParam ($paramArr,$showapi_secret){
                $paraStr = "";
                $signStr = "";
                ksort($paramArr);
                foreach ($paramArr as $key => $val) {
                    if ($key != '' && $val != '') {
                        $signStr .= $key.$val;
                        $paraStr .= $key.'='.urlencode($val).'&';
                    }
                }
                $signStr .= $showapi_secret;//排好序的参数加上secret,进行md5
                $sign = strtolower(md5($signStr));
                $paraStr .= 'showapi_sign='.$sign;//将md5后的值作为参数,便于服务器的效验
                return $paraStr;
            }
            $param = createParam($paramArr,$showapi_secret);
            $url = 'http://route.showapi.com/99-38?'.$param;
            $result = file_get_contents($url);
            $result = json_decode($result,true);
            $englishName = $result['showapi_res_body']['data'];
            $en = array(
                'birthday' => $user['birthday'],
                'className' => $user['className'],
                'name' => $englishName,
                'date' => $date,
                'gradeName' => $user['grade'],
                'schoolName' => $school['enName']
            );
            $this->returnJson(array('statu' => 1,'message' => 'success','data' => array('en' => $en,'zn' => $zn)),true);
        }
    }
    public function printCenter(){

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
    private function gradeToEn($str){
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
        foreach($return as $key => $value){
            if($value == $str){
                return $key;
            }
        }
    }
}