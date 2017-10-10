<?php
/**
 * Created by PhpStorm.
 * User: xiaolong
 * Date: 2017/6/22
 * Time: 14:15
 * 排课管理
 */
namespace Home\Controller;
//use Think\Controller;
//use Vendor\PHPExcel\PHPExcel;
class CurriculumController extends Base {
    private $classTable = array();
    private $teacherTable = array();
    private $jxPlanTable = array();
    private $subjectLimit = array(); //科目排课限制
    private $teacherLimitData = array(); //教师限制
    private $hbClass = array(); //合班
    public function pkList(){

    }
    public function getSubjectTeacher(){
        $type = $_GET['type'];
        if($type == 'pkList'){
            $subjectId = $_GET['subjectId'];
            $pkListId = $_GET['pkListId'];
            $session = $this->get_session('loginCheck',false);
            $scId = $session['scId'];
            $list = M('pk_list')->where(array('id' => $pkListId))->find();
            $rangeList = $list['pkRange'];
            $data = M('')->query("SELECT * FROM mks_jw_schedule WHERE gradeId in($rangeList) AND scId=$scId AND subjectId=$subjectId  order BY gradeName");
            $hb = M('pk_hb_set')->where(array('pkListId' => $pkListId,'subjectId' => $subjectId,'scId' => $scId))->select();
            foreach($data as $key => $value){
                foreach($hb as $key1 => $value1){
                    if($value['techerId'] ==  $value1['teacherId'] && $value['subjectId'] ==  $value1['subjectId']){
                        $data11 = unserialize($value1['classSet']);
                        foreach($data11 as $key2 => $value2){
                            if($value['gradeId'] == $value2['gradeId'] && $value['classId'] == $value2['classId'] ){
                                unset($data[$key]);
                            }
                        }
                    }
                }
            }
            $return = array();
            $i = 0;
           foreach($data as $key => $value){
               $return[$i] = $value;
               $i++;
           }
            $this->returnJson(array('statu' => 1,'message' => 'success' ,'data' => $return),true);
        }
    }
    public function getTeacherList(){//得到教师上课列表
        $type = $_GET['type'];
        if($type == 'pkList'){
            $session = $this->get_session('loginCheck',false);
            $scId = $session['scId'];
            $pkListId = $_GET['pkListId'];
            $list = M('pk_list')->where(array('id' => $pkListId))->find();
            $rangeList = explode(',',$list['pkRange']);
            $len = count($rangeList);
            $i = 1;
            $str = '';
            foreach($rangeList as $key => $value){
                $i++;
                if($i<=$len){
                    $str = 'gradeId='.$value.' or '.$str;
                }else{
                    $str = $str.'gradeId='.$value;
                }
            }
            $data  = M('')->query("SELECT * FROM mks_jw_schedule WHERE scId=$scId and ($str) GROUP BY techerName");
            $return  = array();
            foreach($data as $key => $value){
                $return[$value['subjectId']][] = $value;
            }
            $returnData = array();
            foreach($return as $key => $value){
                $returnData[] = $value;
            }
            $returnDataTrue = array();
            foreach($returnData as $key => $value){
                $returnDataTrue[$key]['techerName'] = $returnData[$key][0]['subject'];
                foreach($value as $key1 => $value1){
                    unset($value1['subject']);
                    $returnDataTrue[$key]['data'][] =  $value1;
                }
            }
            $this->returnJson(array('statu' => 1,'message' => 'success','data' => $returnDataTrue),true);
        }
    }
    public function getSubjectList(){//得到课程列表
        $type = $_GET['type'];
        if($type == 'pkList'){
            $session = $this->get_session('loginCheck',false);
            $scId = $session['scId'];
            if($data = M('subject')->where(array('scId' => $scId))->select()){
                $this->returnJson(array('statu' => 1,'message' => 'success','data' => $data),true);
            }else{
                $this->returnJson(array('statu' => 0,'message' => 'fail','data' => ''),true);
            }
        }
    }
        public function deletePkList(){
        $type = $_GET['type'];
        if($type == 'pkDelete'){
            $model = M('pk_list');
            $model->startTrans();
            $id = $_POST['id'];
            M('pk_class_before_plan')->where(array('pkListId' => $id))->delete();
            M('pk_class_time_limit')->where(array('pkListId' => $id))->delete();
            M('pk_limit')->where(array('pkListId' => $id))->delete();
            $true = M('pk_list')->where(array('id' => $id))->delete();
            M('pk_result')->where(array('pkListId' => $id))->delete();
            M('pk_teacher_limit')->where(array('pkListId' => $id))->delete();
            M('pk_time')->where(array('pkListId' => $id))->delete();
        }
        $model->commit();
        if($true){
            $this->returnJson(array('statu' => 1, 'message' => 'delete success'),true);
        }
        $this->returnJson(array('statu' => 0, 'message' => 'delete fail'),true);
    }
    public function getGradeAndClass(){//得到年级班级
        $type = $_GET['type'];
        if($type== 'getList'){
            $session = $this->get_session('loginCheck',false);
            $scId = $session['scId'];
            $pkListId = $_GET['pkListId'];
            $list = M('pk_list')->where(array('id' => $pkListId))->find();
            $rangeList = explode(',',$list['pkRange']);
            $data = array();
            $i = 0;
            foreach($rangeList as $key => $value){
                $grade = M('grade')->where(array('scId' => $scId,'gradeid'=> $value))->find();
                $gradeName = $grade['name'];
                $class = M('class')->where(array('scId' => $scId,'grade'=> $value))->order('classname')->select();
                foreach($class as $key1 => $value1){
                    $class[$key1]['name'] = $class[$key1]['classname'];
                    unset($class[$key1]['classname']);
                    $class[$key1]['gradeId'] = $class[$key1]['grade'];
                    unset($class[$key1]['grade']);
                }
                $data[$i]['name'] = $this->gradeToZhong($gradeName);
                $data[$i]['gradeId'] =  $value;
                $data[$i]['data'] = $class;
                $i++;
            }
            $this->returnJson(array('statu' => 1,'data' => $data,'message' => 'success'),true);
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
    public function pkPlan(){
        $type = $_GET['type'];
        $session = $this->get_session('loginCheck',false);
        $scId = $session['scId'];
        if($type == 'pkList'){
            $data = M('pk_list')->where(array('scId' => $scId))->select();
            $grade = M('grade')->where(array('scId' => $scId ))->select();
            //print_r($grade);
            //print_r($data);
            foreach($data as $key => $value){
                $pkRang = explode(',',$value['pkRange']);
                $name = null;
                //print_r($pkRang);
                $count = count($pkRang);
                $i =1;
                foreach($pkRang as $key1 => $value1){
                    foreach($grade as $key2 => $value2){
                        if($value1 == $value2['gradeid']){
                            if($i==$count){
                                $name=$name.$value2['name'];
                            }else{
                                $name=$name.$value2['name'].',';
                            }

                        }
                    }
                    $i++;
                }
                $data[$key]['name'] = $name;
            }
            $this->returnJson(array('statu' =>1,'message' => 'success','data' =>$data),true);
        }
        if($type == 'getPkRang'){
            $data = M('grade')->where(array('scId' => $scId))->select();
            $this->returnJson($data,true);
        }
        if($type == 'pkCreate'){
            $data = array(
                'pkPlanName' => $_POST['pkPlanName'],
                'pkRange' => $_POST['pkRange'],
                'startTime' => $_POST['startTime'],
                'endTime' => $_POST['endTime'],
                'createTime' =>  date('Y-m-d H:i:s'),
                'ifStartUp' =>  1,
                'scId' => $scId
            );
            if($pkListId = M('pk_list')->add($data)){
                /*$this::createPlanGo($scId =2, $pk_week_limit = array(
                    '0' => array(
                        1,1,1,1,1,0,0
                    ),
                    '1' => array(
                        1,1,1,1,1,0,0
                    ),
                    '2' => array(
                        0,0,0,0,0,0,0
                    )
                ),4,4,2,$pkListId,$_POST['pkRange']);
                $pk_class_time_limit = 9;
                $setClass = unserialize($pk_class_time_limit['ClassSet']);
                $pk_day_jie_limit = $setClass['day'];
                $pk_week_limit = $setClass['week'];
                $timeType = $setClass['section'];
                $morningCount = 4;//$timeType['morningCount']; //默认早上课数
                $noongCount = 4;//$timeType['noon']; //默认下午课数
                $nightCount = 2;//$timeType['night']; //默认晚上课数
                /*M('pk_time')->add(
                    array(
                        'pkListId' => $pkListId,
                        'scId' => $scId,
                        'createTime' => strtotime('Y-m-d H:i:s'),
                        'ClassSet' =>array(
                            'section' => array(
                                'morningCount' => 4,
                                'noon' => 4,
                                'night' =>1
                                ),
                            'week' =>array(
                                '0' => array(
                                    1,1,1,1,1,0,0
                                ),
                                '1' => array(
                                    1,1,1,1,1,0,0
                                ),
                                '2' => array(
                                    0,0,0,0,0,0,0
                                ),
                            ),
                            'day' => array('')
                    )
                ));*/
                $this->returnJson(array('statu' => 1, 'message' => 'add success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'add fail'),true);
        }
    }
    public function createPkPlan(){//排课时间
        $type = $_GET['type'];
        $session = $this->get_session('loginCheck',false);
        $scId = $session['scId'];
        if($type == 'pkTimeList'){//得到排课时间设置
            $pkListId = $_GET['pkListId'];
            if($data = M('pk_time')->where(array('pkListId' => $pkListId))->find()){
                $this->returnJson(array(
                    'statu' =>1,
                    'id' => $data['id'],
                    'pkListId' => $data['pkListId'],
                    'data' => unserialize($data['ClassSet']),
                ),true);
            }else{
                $this->returnJson(array(
                    'statu' =>0,
                    'id' => '',
                    'pkListId' => $pkListId,
                    'data' => '',
                ),true);
            }
        }
        if($type == 'timeSet'){ //创建学习时间
            $data = $_POST['data'];
            $pkListId = $_POST['pkListId'];
            if(M('pk_time')->where(array('pkListId' => $pkListId,'scId' => $scId))->find()){
                if( M('pk_time')->where(array('pkListId' => $pkListId,'scId' => $scId))->setField(array(
                    'ClassSet' => serialize($data)
                ))) {
                    $pkList = M('pk_list')->where(array('scId' => $scId, 'id' => $pkListId))->find();
                    $this::createPlanGo($scId =2, $pk_week_limit = $data['week'], $data['section']['morningCount'],$data['section']['noon'],$data['section']['night'],$pkListId,$pkList['pkRange']);
                    $this->returnJson(array('statu' => 1, 'message' => 'add success'),true);
                }else{
                    $this->returnJson(array('statu' => 0, 'message' => 'add fail'),true);
                }
            }else{
                /*$data = array(
                    'week' =>array(
                        '0' => array(
                            1,1,1,1,1,0,0
                        ),
                        '1' => array(
                            1,1,1,1,1,0,0
                        ),
                        '2' => array(
                            1,1,1,1,1,0,0
                        )
                    ),
                    'section'=>array(
                        'morningCount' => 4,
                        'noon' => 4,
                        'night' =>1
                    ),
                    'day' =>array(
                        '0' => array('startTime' => '9:00','endTime' => '9:40'),
                        '1' => array('startTime' => '10:00','endTime' => '10:40'),
                        '2' => array('startTime' => '11:00','endTime' => '11:40'),
                        '3' => array('startTime' => '14:00','endTime' => '14:40'),
                        '4' => array('startTime' => '15:00','endTime' => '15:40'),
                        '5' => array('startTime' => '16:00','endTime' => '16:40'),
                        '6' => array('startTime' => '17:00','endTime' => '17:40'),
                        '7' => array('startTime' => '19:00','endTime' => '19:40'),
                        '8' => array('startTime' => '20:00','endTime' => '20:40'),
                    )
                );*/
                if( M('pk_time')->add(array(
                    'pkListId' => $pkListId,
                    'ClassSet' => serialize($data),
                    'scId' => $scId,
                    'createTime' => strtotime(date('Y-m-d'))
                ))) {
                    $pkList = M('pk_list')->where(array('scId' => $scId, 'id' => $pkListId))->find();
                    $this::createPlanGo($scId =$scId, $pk_week_limit = $data['week'], $data['section']['morningCount'],$data['section']['noon'],$data['section']['night'],$pkListId,$pkList['pkRange']);
                    /*$this::createPlanGo($scId =2, $pk_week_limit = array(
                        '0' => array(
                            1,1,1,1,1,0,0
                        ),
                        '1' => array(
                            1,1,1,1,1,0,0
                        ),
                        '2' => array(
                            0,0,0,0,0,0,0
                        )
                    ),$morningCount = 4,$noongCount = 4,$nightCount =2,$pkListId=1,$grade=1);*/
                    $this->returnJson(array('statu' => 1, 'message' => 'add success'),true);
                }
            }
            $this->returnJson(array('statu' => 0, 'message' => 'add fail'),true);
        }
    }
    public function createPkTime(){
        $type = $_GET['type'];
        $data = $_GET['data'];
        $session = $this->get_session('loginCheck',false);
        $scId = $session['scId'];
        if($type== 'createPkTime'){
            $pkListId = $_GET['pkListId'];
            $array = array(
                'pkListId' => $pkListId,
                'scId' =>$scId,
                'weekSet' => serialize($data),
                'createTime' => strtotime(date('Y-m-d'))
            );
            if(M('pk_list')->add($array)){
                $this->returnJson(array('statu' => 1, 'message' => 'add success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'add fail'),true);
        }

    }
    public function jxPlan(){//创建教学计划
        $type = $_GET['type'];
        $session = $this->get_session('loginCheck',false);
        $scId = $session['scId'];
        if($type == 'createJxPlan'){//创建教学计划表
            $data = $_POST['data'];
            if(M('pk_jx_plan')->where(array('pkListId' => $_POST['pkListId'],'scId' =>$scId))->find()){
                if(M('pk_jx_plan')->where(array('pkListId' => $_POST['pkListId'],'scId' =>$scId))->setField(array(
                    'classSet' => serialize($data)
                ))){
                    $this->returnJson(array('statu' => 1, 'message' => 'updata success'),true);
                }else{
                    $this->returnJson(array('statu' => 0, 'message' => 'updata success'),true);
                }
            }
            $array = array(
                'scId' => $scId,
                'pkListId' => $_POST['pkListId'],
                'classSet' => serialize($data),
                'createTime' => strtotime(date('Y-m-d'))
            );
            if(M('pk_jx_plan')->add($array)){
                $this->returnJson(array('statu' => 1, 'message' => 'add success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'add fail'),true);
        }
        if($type == 'jsPlanList'){//得到教学计划表
            $pkListId = $_GET['pkListId'];
            $subject = M('subject')->where(array('scId' => $scId))->order('subjectid')->select();
            if( $return = M('pk_jx_plan')->where(array('pkListId' => $pkListId))->find()){
                $dataReturn = unserialize($return['classSet']);
                $this->returnJson(array('statu' => 1,'message' => 'success','subject' => $subject,'data' => $dataReturn), true);
            }
            //
            $session = $this->get_session('loginCheck',false);
            $scId = $session['scId'];
            $list = M('pk_list')->where(array('id' => $pkListId))->find();
            $rangeList = explode(',',$list['pkRange']);
            $len = count($rangeList);
            $i = 1;
            $str = '';
            foreach($rangeList as $key => $value){
                $i++;
                if($i<=$len){
                    $str = 'gradeId='.$value.' or '.$str;
                }else{
                    $str = $str.'gradeId='.$value;
                }
            }
            $data  = M('')->query("SELECT * FROM mks_jw_schedule WHERE scId=$scId and ($str) order by gradeName");
            $return  = array();
            foreach($data as $key => $value){
                $value['count'] = 0;
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
                        $array1[$i]['data'][] = array('id' => '','className' => '','subject' => $value2['subjectname'],'techerId' => '','techerName' => '','subjectId' => $value2['subjectid'],'createTime' =>'',
                            'userId' => '','gradeId' =>'','classId' => '','scId' => '','gradeName' =>'','count' =>0
                        );
                    }
                }
                $array1[$i]['className'] = $value1['className'];
                $array1[$i]['gradeId'] = $value1['gradeId'];
                $array1[$i]['classId'] = $value1['classId'];
                $array1[$i]['gradeName'] = $value1['gradeName'];
                $i++;
            }
            /*echo "<div><span style='width: 60px; display: inline-block'>班级</span>";
            foreach($subject as $key => $value){
                $subjectName = $value['subjectname'];
                echo "<span style='width: 60px; display: inline-block'>$subjectName</span><span style='width: 60px; display: inline-block'>节数</span>";
            }
            echo "</div>";
            foreach($array as $key => $value){
                $gradeName = $value[0]['gradeName'];
                $className = $value[0]['className'];
                echo "<div>";
                echo "<span style='width: 60px; display: inline-block'>$gradeName.'级'.$className.'班'.</span>";
                foreach($subject as $key2 => $value2){
                    $true = 0;
                    foreach($value as $key1 => $value1) {
                        if ($value1['subjectId'] == $value2['subjectid']){
                            $true = 1;
                            $count = $value1['count'];
                            $subjectName = $value1['subject'];
                            $teacherName = $value1['techerName'];
                            echo "<span style='width: 60px; display: inline-block'>$teacherName</span><span style='width: 60px; display: inline-block'>$count</span>";
                        }
                    }
                    if(!$true){
                        echo "<span style='width: 60px; display: inline-block'></span><span style='width: 60px; display: inline-block'></span>";
                    }
                }
                echo "</div>";

            }*/
            $this->returnJson(array('statu' => 1,'message' => 'success','subject' => $subject,'data' => $array1),true);
        }
    }
    public function limitCreateList(){//排课限制.
        $type = $_GET['type'];
        $session = $this->get_session('loginCheck',false);
        $scId = $session['scId'];
        if($type == 'classSkTimeLimitList'){//得到班级上课限制列表
            $pkListId = $_GET['pkListId'];
            $array = array();
            if( $data = M('pk_class_time_limit')->where(array('pkListId' => $pkListId,'scId' =>$scId,'gradeId' => $_GET['gradeId'],'classId' => $_GET['classId']))->find()){
                $data['classSet'] = unserialize($data['classSet']);
                $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
            }else{
                $data = M('pk_default_limit')->where(array('pkListId' => $pkListId,'scId' =>$scId))->find();
                $data['classSet'] = unserialize($data['classSet']);
                $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
            }
            //print_r(array('statu' => 1, 'message' => 'success','data' => $data));
            $this->returnJson(array('statu' => 0, 'message' => 'fail','data' => ''),true);
        }
        if($type == 'classSkTimeLimit'){//创建班级上课时间限制
            $data = $_POST['data'];
            $pkListId = $_POST['pkListId'];
            $array = array(
                'scId' => $scId,
                'pkListId' => $pkListId,
                'classSet' => serialize($data),
                'className' => $_POST['className'],
                'gradeName' =>(int)$this->gradeToEn($_POST['gradeName']),
                'classId' => $_POST['classId'],
                'gradeId' => $_POST['gradeId'],
                'createTime' => strtotime(date('Y-m-d'))
            );
            M('pk_class_time_limit')->where(array('pkListId' => $pkListId,'gradeId' => $_POST['gradeId'],'classId' => $_POST['classId']))->delete();
            if(M('pk_class_time_limit')->add($array)){
                $this->returnJson(array('statu' => 1, 'message' => 'add success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'add fail'),true);
        }
        if($type == 'subjectSkTimeList'){//得到课程上课时间列表
            $pkListId = $_GET['pkListId'];
            $array = array();
            if( $data = M('pk_curriculum_limit')->where(array('pkListId' => $pkListId,'curriculumId' => $_GET['curriculumId'],'scId' =>$scId,'gradeId' => $_GET['gradeId'],'classId' => $_GET['classId']))->find()){
                $data['classSet'] = unserialize($data['classSet']);
                $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
            }
            if($data = M('pk_class_time_limit')->where(array('pkListId' => $pkListId,'scId' =>$scId,'gradeId' => $_GET['gradeId'],'classId' => $_GET['classId']))->find()){
                $data['classSet'] = unserialize($data['classSet']);
                $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
            }
            if($data =  M('pk_default_limit')->where(array('pkListId' => $pkListId,'scId' =>$scId))->find()){
                $data['classSet'] = unserialize($data['classSet']);
                $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
            }
            //print_r(array('statu' => 1, 'message' => 'success','data' => $data));
            $this->returnJson(array('statu' => 0, 'message' => 'fail','data' => ''),true);
        }
        if($type == 'subjectSkTimeLimit'){//创建课程上课时间限制
            $pkListId = $_POST['pkListId'];
            $data = $_POST['data'];
            $array = array(
                'scId' => $scId,
                'pkListId' => $pkListId,
                'classSet' => serialize($data),
                'className' => $_POST['className'],
                'gradeName' => (int)$this->gradeToEn($_POST['gradeName']),
                'classId' => $_POST['classId'],
                'gradeId' => $_POST['gradeId'],
                'createTime' => strtotime(date('Y-m-d')),
                'curriculumName' => $_POST['curriculumName'],
                'curriculumId' => $_POST['curriculumId']
            );
            M('pk_curriculum_limit')->where(array('pkListId' => $pkListId,'curriculumId' =>$_POST['curriculumId'],'gradeId' => $_POST['gradeId'],'classId' => $_POST['classId']))->delete();
            if(M('pk_curriculum_limit')->add($array)){
                $this->returnJson(array('statu' => 1, 'message' => 'add success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'add fail'),true);
        }
        if($type == 'getTeacherListLimit'){//得到教师上课时间限制
            $pkListId = $_GET['pkListId'];
            $array = array();
            if( $data = M('pk_teacher_limit')->where(array('pkListId' => $pkListId,'teacherId' => $_GET['teacherId'],'scId' =>$scId))->find()){
                $data['classSet'] = unserialize($data['classSet']);
                $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
            }
            if($data =  M('pk_default_limit')->where(array('pkListId' => $pkListId,'scId' =>$scId))->find()){
                $data['classSet'] = unserialize($data['classSet']);
                $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
            }
            //print_r(array('statu' => 1, 'message' => 'success','data' => $data));
            $this->returnJson(array('statu' => 0, 'message' => 'fail','data' => ''),true);
        }
        if($type == 'jsSkTimeLimit'){//教师上课时间限制
            $pkListId = $_POST['pkListId'];
            $data = $_POST['data'];
            $array = array(
                'scId' => $scId,
                'pkListId' => $pkListId,
                'classSet' => serialize($data),
                'createTime' => strtotime(date('Y-m-d')),
                'teacherName' => $_POST['teacherName'],
                'teacherId' => $_POST['teacherId']
            );
            M('pk_teacher_limit')->where(array('scId' => $scId, 'pkListId' => $pkListId,'teacherId' => $_POST['teacherId']))->delete();
            if(M('pk_teacher_limit')->add($array)){
                $this->returnJson(array('statu' => 1, 'message' => 'add success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'add fail'),true);
        }
        if($type == 'getArrangementList'){//得到预先安排课表设置
            $pkListId = $_GET['pkListId'];
            $array = array();
            $teacher = M('jw_schedule')->field('techerId,techerName')->where(array('classId' => $_GET['classId'],'subjectId' => $_GET['subjectId'] ,'gradeId' => $_GET['gradeId'],'scId' => $scId))->find();
            if( $data = M('pk_class_before_plan')->where(array('pkListId' => $pkListId,'scId' =>$scId,'gradeId' => $_GET['gradeId'],'classId' => $_GET['classId']))->find()){
                $data['classSet'] = unserialize($data['classSet']);
                $data['teacherName'] = $teacher['techerName'];
                $data['techerId'] = $teacher['techerId'];
                $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
            }
            $return  = array();
            if( $data = M('pk_class_time_limit')->where(array('pkListId' => $pkListId,'scId' =>$scId,'gradeId' => $_GET['gradeId'],'classId' => $_GET['classId']))->find()){
                $return = unserialize($data['classSet']);
                $arrayData = array();
                foreach($return as $key => $value){
                    foreach($value as $key1 => $value1){
                        $arrayData['classSet'][$key][$key1] = array(
                            'subject' => '',
                            'subjectId' => '',
                            'statu' => $value1,
                            'techerName' =>'',
                            'techerId' => ''
                        );
                    }
                }
                $arrayData['techerId'] =  $teacher['techerId'];
                $arrayData['teacherName'] =  $teacher['techerName'];
                $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $arrayData),true);
            }
            /*if($data = M('pk_curriculum_limit')->where(array('pkListId' => $pkListId,'scId' =>$scId,'gradeId' => $_GET['gradeId'],'classId' => $_GET['classId']))->select()){
                foreach($data as $key => $value){
                    $classSet = unserialize($value['classSet']);
                    foreach($classSet as $key1 => $value1){
                        foreach($value1 as $key2 => $value2){
                            if($value2 == 2){
                                $return[$key1][$key2] = $value2;
                            }
                        }
                    }
                }
            }*/
            /*if(count($return)>1){
                $this->returnJson($return,true);
            }*/
            $data = M('pk_default_limit')->where(array('pkListId' => $pkListId,'scId' =>$scId))->find();
            $data['classSet'] = unserialize($data['classSet']);
            $return =  $data['classSet'];
            $arrayData = array();
            foreach($return as $key => $value){
                foreach($value as $key1 => $value1){
                    $arrayData['classSet'][$key][$key1] = array(
                        'subject' => '',
                        'subjectId' => '',
                        'statu' => $value1,
                        'techerName' =>'',
                        'techerId' => ''
                    );
                }
            }
            $arrayData['techerId'] =  $teacher['techerId'];
            $arrayData['teacherName'] =  $teacher['techerName'];
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $arrayData),true);
            //print_r(array('statu' => 1, 'message' => 'success','data' => $data));
        }
        if($type == 'kcArrangement'){//课程预先安排创建
            $data = $_POST['data'];
            $pkListId = $_POST['pkListId'];
            $array = array(
                'scId' => $scId,
                'pkListId' => $pkListId,
                'classSet' => serialize($data),
                'className' => $_POST['className'],
                'gradeName' => (int)$this->gradeToEn($_POST['gradeName']),
                'classId' => $_POST['classId'],
                'gradeId' => $_POST['gradeId'],
                'createTime' => strtotime(date('Y-m-d'))
            );
            M('pk_class_before_plan')->where(array('pkListId' => $pkListId,'gradeId' => $_POST['gradeId'],'classId' => $_POST['classId']))->delete();
            if(M('pk_class_before_plan')->add($array)){
                $this->returnJson(array('statu' => 1, 'message' => 'add success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'add fail'),true);
        }
        if($type == 'getHbKcSet'){//得到合班课程设置
            $pkListId = $_GET['pkListId'];
            $data = M('pk_hb_set')->where(array('scId' => $scId,'pkListId' => $pkListId))->select();
            foreach($data as $key => $value){
                $data[$key]['classSet'] = unserialize($value['classSet']);
            }
            $this->returnJson(array('data' => $data,'message' => 'success' ,'statu' => 1),true);
        }
        if($type == 'createHbKcSet'){//合班课程设置
            $pkListId = $_POST['pkListId'];
            $array = array(
                'scId' => $scId,
                'pkListId' => $pkListId,
                'teacherId' => $_POST['teacherId'],
                'teacherName' => $_POST['teacherName'],
                'subjectName' => $_POST['subjectName'],
                'subjectId' => $_POST['subjectId'],
                'classSet' => serialize($_POST['data']),
                'createTime' => strtotime(date('Y-m-d'))
            );
            if(M('pk_hb_set')->add($array)){
                $this->returnJson(array('message' => 'add success' ,'statu' => 1),true);
            }
            $this->returnJson(array('message' => 'add fail' ,'statu' => 0),true);
        }
        if($type == 'delHb'){//删除合班限制
            $id = $_POST['id'];
            echo 'dfs';
            if(M('pk_hb_set')->where(array('id' => $id,'scId' => $scId))->delete()){
                $this->returnJson(array('message' => 'del success' ,'statu' => 1),true);
            }
            $this->returnJson(array('message' => 'del fail' ,'statu' => 0),true);
        }
    }
    public function createPlanGo($scId =2, $pk_week_limit = array(
        '0' => array(
            1,1,1,1,1,0,0
        ),
        '1' => array(
            1,1,1,1,1,0,0
        ),
        '2' => array(
            0,0,0,0,0,0,0
        )
    ),$morningCount = 4,$noongCount = 4,$nightCount =2,$pkListId=1,$grade=1){
        $morningCount = 4;//$timeType['morningCount']; //默认早上课数
        $noongCount = 4;//$timeType['noon']; //默认下午课数
        $nightCount = 2;//$timeType['night']; //默认晚上课数
        $data = array();
        foreach($pk_week_limit as $key => $value){
            foreach($value as $key1 => $value1){
                if($key == 0){
                    //$data[$key1]['']
                    $trueOrfalse = 0;
                    if($value1 == 1){
                        $trueOrfalse = 1;
                    }
                    for($i = 0 ; $i<$morningCount; $i++){
                        $data[$key1][$i] = $trueOrfalse;
                    }
                }
                if($key == 1){
                    //$data[$key1]['']
                    $trueOrfalse = 0;
                    if($value1 == 1){
                        $trueOrfalse = 1;
                    }
                    for($i = 0,$j = $morningCount; $i<$noongCount; $i++,$j++){
                        $data[$key1][$j] = $trueOrfalse;
                    }
                }
                if($key == 2){
                    //$data[$key1]['']
                    $trueOrfalse = 0;
                    if($value1 == 1){
                        $trueOrfalse = 1;
                    }
                    for($i = 0,$j = $noongCount+$morningCount; $i<$nightCount; $i++,$j++){
                        $data[$key1][$j] = $trueOrfalse;
                    }
                }
            }
        }
        $array = array();
        for($j = 0; $j<count($data[0]);$j++){
            for($i = 0; $i<7; $i++){
                $array[$j][$i] = $data[$i][$j];
            }
        }
        M('pk_default_limit')->add(array(
            'pkListId' => $pkListId,
            'classSet' => serialize($array),
            'createTime' => strtotime(date('Y-m-d')),
            'scId' => $scId
        ));
        /*foreach($rangeList as $key => $value){
            $grade = M('grade')->where(array('gradeid' => $value,'scId' => $scId))->find();
            $gradeName = $grade['name'];
            if($cheack = M('class')->where(array('grade' => $value,'scId' => $scId))->select()){
                foreach($cheack as $key1 => $value1){
                    M('pk_class_time_limit')->add(
                        $array = array(
                            'scId' => $scId,
                            'pkListId' => $pkListId,
                            'classSet' => serialize($data),
                            'classId' => $value1['classid'],
                            'className' => $value1['classname'],
                            'gradeId' => $value,
                            'gradeName' => $gradeName,
                            'createTime' => strtotime(date('Y-m-d')),
                        )
                    );
                }
            }
        }*/
    }
    public function createPlan(){
        //默认限号时间
        $pk_class_time_limit = array();
        $setClass = unserialize($pk_class_time_limit['ClassSet']);
        $pk_day_jie_limit = $setClass['day'];
        $pk_week_limit = $setClass['week'];
        $timeType = $setClass['section'];
        $morningCount = 4;//$timeType['morningCount']; //默认早上课数
        $noongCount = 4;//$timeType['noon']; //默认下午课数
        $nightCount = 2;//$timeType['night']; //默认晚上课数
        $data = array();
        $pk_week_limit = array( //默认周
            '0' => array(
                1,1,1,1,1,0,0
            ),
               '1' => array(
            1,1,1,1,1,0,0
        ),
               '2' => array(
            0,0,0,0,0,0,0
        )
        );
        foreach($pk_week_limit as $key => $value){
            foreach($value as $key1 => $value1){
                if($key == 0){
                    //$data[$key1]['']
                    $trueOrfalse = 0;
                    if($value1 == 1){
                        $trueOrfalse = 1;
                    }
                    for($i = 0 ; $i<$morningCount; $i++){
                        $data[$key1][$i] = $trueOrfalse;
                    }
                }
                if($key == 1){
                    //$data[$key1]['']
                    $trueOrfalse = 0;
                    if($value1 == 1){
                        $trueOrfalse = 1;
                    }
                    for($i = 0,$j = $morningCount; $i<$noongCount; $i++,$j++){
                        $data[$key1][$j] = $trueOrfalse;
                    }
                }
                if($key == 2){
                    //$data[$key1]['']
                    $trueOrfalse = 0;
                    if($value1 == 1){
                        $trueOrfalse = 1;
                    }
                    for($i = 0,$j = $noongCount+$morningCount; $i<$nightCount; $i++,$j++){
                        $data[$key1][$j] = $trueOrfalse;
                    }
                }
            }
        }
        //M('')
        $pkListId = $_GET['pkListId'];
        $array = array(
           // 'scId' => $scId,
            'pkListId' => $pkListId,
            'classSet' => serialize($data),
            'className' => $_GET['className'],
            'gradeName' => $_GET['gradeName'],
            'createTime' => strtotime(date('Y-m-d')),
            'curriculum' => $_GET['curriculum'],
            'curriculumId' => $_GET['curriculumId']
        );
        if(M('pk_class_time_limit')->add($array)){
            $this->returnJson(array('statu' => 1, 'message' => 'add success'),true);
        }
        $this->returnJson(array('statu' => 0, 'message' => 'add fail'),true);
        M('pk_class_time_limit')->add(

        );
        exit(0);
        //计划教学初始设置
        /*M('jw_schedule')->where(array('className'));
        $pkListId = $_GET['pkListId'];
        $pk_list = M('pk_list')->where(array('id' => $pkListId))->find();
        $range = $pk_list['pkRange'];
        $rangeList = explode(',','1,2,3');
        $returnData = array();
        foreach($rangeList as $key => $value){
            $returnData[] = M('')->query("SELECT subject,techerId,techerName,grade,className FROM mks_jw_schedule where grade=$value ORDER BY className");
        }
        $returnDataTrue = array();
        foreach($returnData as $key => $value){
            foreach($value as $key1 => $value1){
                $value1['section'] = 0;
                $returnDataTrue[$value1['grade']][$value1['className']][] = $value1;
            }
        }
        $return = array();
        //print_r($returnDataTrue);
        foreach($returnDataTrue as $key => $value){
            foreach($value as $key1 => $value1){
                $return[] = $value1;
            }
        }
        $session = $this->get_session('loginCheck',false);
        $scId = $session['scId'];
        M('pk_jx_plan')->add(array(
          'scId' => $scId,
          'pkListId' => 1,
          'classSet' => serialize($return),
          'createTime' => strtotime(date('Y-m-d'))
      ));
        $Data = M('pk_jx_plan')->where(array('pkListId' =>1 ))->find();
        print_r(unserialize($Data['classSet']));*/
    }
    //动态规划法排课开始
    public function pkStart(){
        $pkListId = $_GET['pkListId'];
        $pkList = M('pk_list')->where(array('id' => $pkListId))->find();
        $scId = $pkList['scId'];
        $rangeList = explode(',',$pkList['pkRange']);
        $jbLimit = M('pk_default_limit')->where(array('pkListId' => $pkListId,'scId' =>$scId))->find();
        $classLimit = M('pk_class_time_limit')->where(array('pkListId' => $pkListId))->select();
        $pk_class_before_plan = M('pk_class_before_plan')->where(array('pkListId' => $pkListId))->select();
        $curriculum_limit = M('pk_curriculum_limit')->where(array('pkListId' => $pkListId))->select();
        $pk_teacher_limit = M('pk_teacher_limit')->where(array('pkListId' => $pkListId))->select();
        $pk_jh_limit = M('pk_jx_plan')->where(array('pkListId' => $pkListId))->find();
        $pk_time = M('pk_time')->where(array('pkListId' => $pkListId))->find();
        //
        $data = array();
        $i = 0;
        foreach($rangeList as $key => $value){
            $grade = M('grade')->where(array('scId' => $scId,'gradeid'=> $value))->find();
            $gradeName = $grade['name'];
            $class = M('class')->where(array('scId' => $scId,'grade'=> $value))->order('classname')->select();
            $data[$i]['gradeName'] = $gradeName;
            $data[$i]['gradeId'] =  $value;
            $data[$i]['data'] = $class;
            $i++;
        }
        foreach($data as $key => $value){
            if(is_array($value['data'])){
                foreach($value['data'] as $key1 => $value1){

                }
            }
        }
    }
    //预先排课生成初步班级教室课程表
    private function pkAlgorithm($gradeId,$gradeName,$classId,$className,$jbLimit,$classLimit,$pk_class_before_plan,$curriculum_limit,$pk_teacher_limit){
        $pk_class_before_plan_data = array();
        $pk_class_before_plan_check = 0;
        foreach($pk_class_before_plan as $key => $value){
            if($value['gradeId'] == $gradeId && $value['classId'] == $classId){
                $pk_class_before_plan_data = $value;
                $pk_class_before_plan_check = 1;
            }
        }
        $teacherClassTable = array();
        $classTable = array();
        if($pk_class_before_plan_check){
            foreach($pk_class_before_plan_data as $key => $value){

            }
        }
    }
    //预先排课生成教师数组表，生成班级数组表
    public function createArrayClassAndTeacher(){
        $pkListId = $_GET['pkListId'];
        $pkList = M('pk_list')->where(array('id' => $pkListId))->find();
        $scId = $pkList['scId'];
        $rangeList = explode(',',$pkList['pkRange']);
        $i = 0;
        foreach($rangeList as $key => $value){
            $grade = M('grade')->where(array('scId' => $scId,'gradeid'=> $value))->find();
            $gradeName = $grade['name'];
            $class = M('class')->where(array('scId' => $scId,'grade'=> $value))->order('classname')->select();
            $data[$i]['gradeName'] = $gradeName;
            $data[$i]['gradeId'] =  $value;
            $data[$i]['data'] = $class;
            $i++;
        }
        $allClass = array();
        foreach($data as $key => $value){
            if(is_array($value['data'])){
                foreach($value['data'] as $key1 => $value1){
                    $value1['gradeName'] = $value['gradeName'];
                    unset($value1['createTime']);
                    unset($value1['number']);
                    unset($value1['branch']);
                    unset($value1['levelid']);
                    unset($value1['major']);
                    unset($value1['scId']);
                    unset($value1['lastRecordTime']);
                    unset($value1['userid']);
                    $allClass[] = $value1;
                }
            }
        }
        $allTeacher = array();
        $dataTeacher = M('pk_jx_plan')->where(array('pkListId' => $pkListId))->find();
        $dataTeacher = $dataTeacher['classSet'];
        $this::createClassKcTable($allClass,15);
    }
    public function test(){
        //$this::createClassKcTable(15);
    }
    //创建班级,教师,教学计划,临时课程表
    public function createClassKcAandTeacherTable($pkListId){
        $session = $this->get_session('loginCheck',false);
        $scId = $session['scId'];
        $data = M('pk_default_limit')->where(array('pkListId' => $pkListId))->find();
        $limit = unserialize($data['classSet']);
        $this->classTable = $this-> pkRang($pkListId,1);
        $classTable = array();
        foreach($this->classTable as $key => $value){
            $value['data'] = $limit;
            $classTable[$value['gradeId']][$value['classId']] = $value;
        }
        $this->classTable = $classTable;
        unset($classTable);
        $list = M('pk_list')->where(array('id' => $pkListId))->find();
        $rangeList = $list['pkRange'];
        $this->teacherTable = M('')->query("SELECT techerId,techerName FROM mks_jw_schedule WHERE gradeId in($rangeList) AND scId=$scId  GROUP BY techerId");
        $teacherTable = array();
        foreach($this->teacherTable as $key => $value){
            $value['data'] = $limit;
            $teacherTable[$value['techerId']] = $value;
        }
        $this->teacherTable = $teacherTable;
        $this->jxPlanTable = $this->getJxPlanTable($pkListId);
    }
    public function testyx($pkListId){
        $data = M('pk_class_before_plan')->where(array('pkListId' => $pkListId))->select();
        print_r(unserialize($data[0]['classSet']));
    }
    //教师限制排课，科目限制排课，合班处理
    public function subjectTeacherHbHanle($pkListId){
        $this->subjectLimit = $this->getLimitTeacerAndclass($pkListId); //科目排课限制
        $this->teacherLimitData = $this->teacherLimit($pkListId);//教师限制
        $this->hbClass = $this->hbToData($this->hb($pkListId));//合班
        foreach($this->teacherLimitData as $key => $value){
            if($this->teacherTable[$value['teacherId']]['data'][$value['y'][$value['x']]] == 1){
                $this->teacherTable[$value['teacherId']]['data'][$value['y'][$value['x']]] = 0;
            }
        }
        foreach($this->subjectLimit as $key => $value){
            if($this->classTable[$value['gradeId']][$value['classId']]['data'][$value['y']][$value['x']] == 1){
                $jxjh = $this->jxPlanTable[$value['gradeId']][$value['classId']]['data'];
                sort($jxjh);
                $this->sjJxJh($jxjh,$value['curriculumId'],$value['y'],$value['x']);
            }
        }
        foreach($this->hbClass as $key => $value){
            $hbData = $value['data'];
            $this->hejxHand($hbData);
        }
        //print_r($this->teacherLimitData);
        //print_r($this->classTable);
    }
    //合班教学处理
    private function hejxHand($hbData){
        $class = array();
        if(isset($this->classTable[$hbData[0]['gradeId']][$hbData[0]['classId']]['data'])){
            $class = $this->classTable[$hbData[0]['gradeId']][$hbData[0]['classId']]['data'];
            $y = count($class);
            $x = 0;
            foreach($class[0] as $key => $value){
                if($value == 1){
                    $x++;
                }
            }
        }
        $jxJh = array();
        foreach($hbData as $key => $value){
            $jxJh[] = $this->jxPlanTable[$value['gradeId']][$value['classId']]['data'][$value['subjectId']];
        }
        $this->hbSjJxJh($jxJh,$y,$x);
    }
    private function hbSjJxJh($jxJh,$y,$x){
        //print_r($jxJh);
        $count = $jxJh[0]['count'];
        for($i = 0; $i<$count; $i++){
            while(1){
                $yy = rand(0,$y-1);
                $xx = rand(0,$x-1);
                $trueOrFalse = 1;
                foreach($jxJh as $key => $value) {
                    if ($this->classTable[$value['gradeId']][$value['classId']]['data'][$yy][$xx] != 1) {
                        $trueOrFalse = 0;
                    }
                    if ($this->teacherTable[$value['techerId']]['data'][$yy][$xx] != 1) {
                        $trueOrFalse = 0;
                    }
                }
                if($trueOrFalse == 1){
                    $this->updataTeacherClassJxTable($jxJh,$xx,$yy);
                    break;
                }
            }
        }
    }
    //得到随机教学计划
    private function sjJxJh($jxjh,$subjectId,$y,$x){
        while(1){
            $sj = rand(0,count($jxjh)-1);
            $trueOrFalse = 1;
            if(isset($jxjh[$sj]['subjectId'])){
                if($subjectId == $jxjh[$sj]['subjectId']){
                    $trueOrFalse = 0;
                }
            }
            if($jxjh[$sj]['count']<=0){
                $trueOrFalse = 0;
            }
            if(isset($this->teacherTable[$jxjh[$sj]['techerId']]['data'][$y][$x])){
                if($this->teacherTable[$jxjh[$sj]['techerId']]['data'][$y][$x] != 1){
                    $trueOrFalse = 0;
                }
            }
            foreach($this->subjectLimit as $key => $value){
                if($value['curriculumId'] == $jxjh[$sj]['subjectId'] && $y == $value['y'] && $x == $value['x'] && $value['gradeId'] == $jxjh[$sj]['gradeId'] && $value['classId'] == $jxjh[$sj]['classId']){
                    $trueOrFalse = 0;
                }
            }
            foreach($this->hbClass as $key => $value){
                if($value['subjectId'] == $jxjh[$sj]['subjectId'] && $value['teacherId'] == $jxjh[$sj]['techerId']){
                    foreach($value['data'] as $key1 => $value1){
                        if($value1['gradeId'] == $jxjh[$sj]['gradeId'] && $value1['classId'] == $jxjh[$sj]['classId']){
                            $trueOrFalse = 0;
                        }
                    }
                }
            }
            if($trueOrFalse == 1){
                $updata[] = $jxjh[$sj];
                $this->updataTeacherClassJxTable($updata,$x,$y);
                break;
            }
        }
    }
    //开始排课
    public function startPktoGo(){
        $pkListId = $_GET['pkListId'];
        $this->createClassKcAandTeacherTable($pkListId);//创建班级教师教学计划临时课表
        $this->classLimitHandle($pkListId);   //班级限制操；
        $this->yxPk($pkListId);   //预先排课处理
        $this->subjectTeacherHbHanle($pkListId);
        $i = 0;
        foreach($this->classTable as $key => $value){
            foreach($value as $key1 => $value1){
                foreach($value as $key2 => $value2){
                    $jxJh = $this->jxPlanTable[$key][$key1]['data'];
                    $class = $value1['data'];
                    $this->pkHandle($class,$jxJh);
                }
            }
        }
        print_r($this->classTable);
    }
    private function pkHandle($class,$jxJh){
        foreach($class as $key => $value){
            foreach($value as $key1 => $value1){
                if($value1 == 1){
                    while(1){
                        foreach($jxJh as $key2 => $value2){
                            if($value2['count'] <= 0){
                                unset($jxJh[$key2]);
                            }
                            if(!$value2['gradeId']){
                                unset($jxJh[$key2]);
                            }
                        }
                        if(count($jxJh) == 0){
                            break;
                        }
                        $jxJhCell = array_rand($jxJh,1);
                        $data = $jxJh[$jxJhCell];
                        //print_r($data);
                        //print_r($this->teacherTable[$data['techerId']]['data']);
                        if($this->teacherTable[$data['techerId']]['data'][$key][$key1] == 1){
                            $jxJh[$jxJhCell]['count']--;
                            $updata = array();
                            $updata[] = $data;
                            $this->updataTeacherClassJxTable($updata,$key1,$key);
                            break;
                        }
                    }
                }
            }
        }
    }
    private function pdPkTrueOrFalse($class,$jxJh){
        $jxJhSort = array();
        $i =0;
        foreach($jxJh['data'] as $key => $value){
            $jxJhSort[] = $value;
        }
        foreach($class['data'] as $key => $value){
            foreach($value as $key1 => $value1){
                if($value1 == 0){

                }
                if($value1 == 1){
                    /*foreach($jxJhSort as $key => $value){
                        $newJxJh = $jxJhSort;

                    }*/
                    $this->handle($jxJhSort,$key,$key1,$key);
                }
            }
        }
    }
    private function handle($jxJhSort,$key,$key1,$keyEnd){
        $maxStart = count($jxJhSort)-1;
        $jxJhCell = $this->cellJxPlan($jxJhSort,$keyEnd,0,$maxStart);
        if(!$jxJhCell){
            return 1;
        }
        $x = $key1;
        $y = $key;
        //判断是否合班教学
        //print_r($jxJhCell);
        //print_r($this->hbClass);
        $hbReturn = $this->pkHeban($jxJhCell);
        //print_r($this->hbClass);
        //print_r($this->jxPlanTable);
        if($hbReturn){
            foreach($hbReturn as $key3 => $value3){
                $jxJhCellArray[] = $this->jxPlanTable[$value3['gradeId']][$value3['classId']]['data'][$value3['subjectId']];
                foreach($jxJhCellArray as $key4 => $value4){
                    if($value4['count']<=0){
                         $this->handle($jxJhSort,$key,$key1,$keyEnd++);
                    }
                    if(!$this->classKpTrueOrFalse($value4,$x,$y)){
                         $this->handle($jxJhSort,$key,$key1,$keyEnd++);
                    }
                    if(!$this->teacherTrueOrfalse($value4,$x,$y)){
                         $this->handle($jxJhSort,$key,$key1,$keyEnd++);
                    }
                }
            }
        }else{
            if($this->classKpTrueOrFalse($jxJhCell,$x,$y)){//课程上课时间限制
                if($this->teacherTrueOrfalse($jxJhCell,$x,$y)){
                    $cell[] = $jxJhCell;
                    $this->updataTeacherClassJxTable($cell,$x,$y);
                }
            }
        }
    }
    private function updataTeacherClassJxTable($jxJhCell,$x,$y){
        foreach($jxJhCell as $key => $value){
            if(isset($this->classTable[$value['gradeId']][$value['classId']]['data'][$y][$x])){
                $this->classTable[$value['gradeId']][$value['classId']]['data'][$y][$x] =  array(
                    'subjectName' => $value['subject'],
                    'subjectId' => $value['subjectId'],
                    'statu' => 5,
                    'teacherName' => $value['techerName'],
                    'teacherId' => $value['techerId']
                );
            }
            if(isset($this->teacherTable[$value['techerId']]['data'][$y][$x])){
                $this->teacherTable[$value['teacherId']]['data'][$y][$x] = array(
                    'subjectName' => $value['subject'],
                    'subjectId' => $value['subjectId'],
                    'statu' => 5,
                    'gradeId' => $value['gradeId'],
                    'gradeName' => $value['gradeName'],
                    'classId' => $value['classId'],
                    'className' => $value['className'],
                );
            }
            if(isset($this->jxPlanTable[$value['gradeId']][$value['classId']]['data'][$value['subjectId']]['count'])){
                $this->jxPlanTable[$value['gradeId']][$value['classId']]['data'][$value['subjectId']]['count']--;
            }
        }
    }
    //教师限制
    private function teacherTrueOrfalse($jxJhCell,$x,$y){
        foreach($this->teacherLimitData as $key => $value){
            if($jxJhCell['techerId'] == $value['teacherId'] && $value['x'] == $x && $value['y'] == $y){
                return 0;
            }
        }
        return 1;
    }
    //课程限制
    private function classKpTrueOrFalse($hbReturn,$x,$y){
        if($hbReturn['statu'] == 0){
            foreach($this->subjectLimit as $key => $value){
                if($value['classId'] == $hbReturn['data']['classId'] && $value['gradeId'] == $hbReturn['data']['gradeId'] && $value['curriculumId'] == $hbReturn['data']['subjectId'] && $x == $value['x'] && $y == $value['y']){
                    return 0;
                }
            }
            return 1;
        }
    }
    private function pkHebanHandel(){

    }
    //得到教学计划
    private function cellJxPlan($jxJh,$key,$start,$maxStart){
        if(isset($jxJh[$key])){
            if($jxJh[$key]['count']<=0){
                $key++;
                if($key>$maxStart){
                    $key = 0;
                }
                if($start++>$maxStart){
                    return 0;
                }
                $this->cellJxPlan($jxJh,$key,$start++,$maxStart);
            }else{
                return $jxJh[$key];
            }
        }else{
            $key = $maxStart;
            $this->cellJxPlan($jxJh,$key,$start++,$maxStart);
        }
    }
    //排课合班判断
    private function pkHeban($jxJhCell){
        foreach($this->hbClass as $key2 => $value){
            if($value['subjectId'] == $jxJhCell['subjectId'] && $value['teacherId'] == $jxJhCell['techerId']){
                foreach($value['data'] as $key3 => $value3){
                    if($value3['gradeId'] == $jxJhCell['gradeId'] && $value3['classId'] == $jxJhCell['classId']){
                        unset($this->hbClass[$key2]);
                        return array(
                            'statu' => 1,
                            'data' => $value['data']
                        );
                    }
                }
                return 0;
                break;
            }
        }
        return 0;
    }
    //得到教学计划表
    public function getJxPlanTable($pkListId){
        $data = M('pk_jx_plan')->where(array('pkListId' => $pkListId))->find();
        $data = unserialize($data['classSet']);
        $return = array();
        foreach($data as $key => $value){
            foreach($value['data'] as $key2 => $value2){
                $return[$value['gradeId']][$value['classId']]['data'][$value2['subjectId']] = $value2;
            }
            $return[$value['gradeId']][$value['classId']]['className'] = $value['className'];
            $return[$value['gradeId']][$value['classId']]['gradeName'] = $value['gradeName'];
        }
        return $return;
    }
    //班级不排课处理
    private function classLimitHandle($pkListId){
        $data = $this->classLimit($pkListId);
        foreach($data as $key => $value) {
            if(isset( $this->classTable[$value['gradeId']][$value['classId']]['data'][$value['y']][$value['x']])){
                $this->classTable[$value['gradeId']][$value['classId']]['data'][$value['y']][$value['x']] = 0;
            }
        }
    }
    //自动排课预先排课处理
    private function yxPk($pkListId){
        $this->hbClass = $this->hbToData($this->hb($pkListId));//合班
        $data = $this->prvPk($pkListId);
        $count = count($data);
        $dataHb =array();
        foreach($data as $key => $value){
            foreach($this->hbClass as $key1 => $value1){
                if($value['subjectId'] == $value1['subjectId'] && $value['teacherId'] == $value1['teacherId']){
                    $true0rFalse = 0;
                    foreach($value1['data'] as $key2 => $value2){
                        if($value2['classId'] == $value['classId'] && $value2['gradeId'] == $value['gradeId']){
                            $true0rFalse = 1;
                        }
                    }
                    if($true0rFalse){
                        unset($data[$key]);
                        foreach($value1['data'] as $key3 => $value3){
                            $value['className'] = $value3['className'];
                            $value['gradeName'] = $value3['gradeName'];
                            $value['classId'] = $value3['classId'];
                            $value['gradeId'] = $value3['gradeId'];
                            $dataHb[] = $value;
                        }
                    }
                }
            }
        }
        $data = array_merge($data,$dataHb);
        foreach($data as $key => $value){
            $this->classTable[$value['gradeId']][$value['classId']]['data'][$value['y']][$value['x']] =  array(
                'subjectName' => $value['subjectName'],
                'subjectId' => $value['subjectId'],
                'statu' => $value['statu'],
                'teacherName' => $value['teacherName'],
                'teacherId' => $value['teacherId']
            );
            if($value['teacherId']){
                $this->teacherTable[$value['teacherId']]['data'][$value['y']][$value['x']] = array(
                    'subjectName' => $value['subjectName'],
                    'subjectId' => $value['subjectId'],
                    'statu' => $value['statu'],
                    'gradeId' => $value['gradeId'],
                    'gradeName' => $value['gradeName'],
                    'classId' => $value['classId'],
                    'className' => $value['className'],
                );
            }
            if($value['subjectId']){
                $this->jxPlanTable[$value['gradeId']][$value['classId']]['data'][$value['subjectId']]['count']--;
            }
        }
    }
    //得到自动排课
    public function zdPk(){
        $type = $_GET['type'];
        if($type == 'getZdPkList'){
            $pkListId = $_GET['pkListId'];
            $classLimit = $this->classLimit($pkListId);
            $classLimitReturn = $this->kcTimeToZn($classLimit,'class');
            $subjectLimit = $this->getLimitTeacerAndclass($pkListId);
            $subjectLimitReturn = $this->kcTimeToZn($subjectLimit,'subject');
            $pkRange = $this->pkRang($pkListId,0);
            $pkRange = $this->njToGoZn($pkRange);
            $weekAndCount = $this->weekJie($pkListId);
            $weekAndCount[]['days'] = $weekAndCount['days'];
            $weekAndCount[]['count'] = $weekAndCount['count'];
            $teacherLimit = $this->teacherLimit($pkListId);
            $teacherLimit = $this->kcTimeToZn($teacherLimit,'teacher');
            $yP = $this->prvPk($pkListId);
            $yP = $this->kmYpk($yP);
            $hbClass = $this->hb($pkListId);
            $hbClass = $this->getHbPx($hbClass);
            $this->returnJson(array('classSet' => array(
                'classLimit' => $classLimitReturn,
                'subjectLimitReturn' => $subjectLimitReturn,
                'pkRange' => $pkRange,
                'weekAndCount' => $weekAndCount,
                'teacherLimit' => $teacherLimit,
                'yP' =>$yP,
                'hbClass' => $hbClass
            ),'message' => 'success','statu' => 1),true);
        }
    }
    //合班课程班级转化
    private function hbToData($data){
        foreach($data as $key => $value){
            $data[$key]['data'] = unserialize($value['data']);
        }
        return $data;
    }
    private function kmYpk($data){
        $array = array();
        $arrayRE = array();
        foreach($data as $key => $value){
            $arrayRE[$value['gradeId']][$value['classId']][] = $value;
        }
        $arrRel = array();
        $i = 0;
        foreach($arrayRE as $key => $value){
            foreach($value as $key1 => $value1){
                $arrRel[$i]['name'] = $this->toWeekArray($value1[0]['gradeName'],'year').$value1[0]['className'];
                foreach($value1 as $key2 => $value2){
                    $arrRel[$i]['data'][] =  $value2['subjectName'].'('.$this->toWeekArray($value2['x'],'wk').$this->toWeekArray($value2['y'],'js').')';
                }
            }
        }
        return $arrRel;
    }
    private function getHbPx($hbClass){
        $array = array();
        $i = 0;
        foreach($hbClass as $key => $value){
            $data = unserialize($value['data']);
            $array[$i]['subject'] = $value['subjectName'];
            foreach($data as $key1 => $value1){
                $array[$i]['data'][] = $this->toWeekArray($value1['gradeName'],'year').$value1['className'].'班（'.$value1['techerName'].')';
            }
        }
        return $array;
    }
    private function njToGoZn($pkRange){
        $str = array();
        foreach($pkRange as $key => $value){
            $str[] = $this::toWeekArray($value,'year').'    ';
        }
        return $str;
    }
    private function kcTimeToZn($data,$str){
        $return = array();
        if($str == 'class'){
            foreach($data as $key => $value){
                $value['gradeId'];
                $grade = $this->toWeekArray($value['gradeId'],'year');
                $week = $this->toWeekArray($value['x'],'wk');
                $js = $this->toWeekArray($value['y'],'js');
                $class = $value['className'];
                $return[] = $grade.$class.'('.$week.$js.')';
            }
        }
        if($str == 'teacher'){
            foreach($data as $key => $value){
                $value['gradeId'];
                $week = $this->toWeekArray($value['x'],'wk');
                $js = $this->toWeekArray($value['y'],'js');
                $teacher = $value['teacherName'];
                $return[] =$teacher.'('.$week.$js.')';
            }
        }
        if($str == 'subject'){
            $i = 0;
            foreach($data as $key => $value){
                $value['gradeId'];
                $grade = $this->toWeekArray($value['gradeId'],'year');
                $week = $this->toWeekArray($value['x'],'wk');
                $js = $this->toWeekArray($value['y'],'js');
                $class = $value['className'];
                $return[$i]['data'] = $grade.$class.'('.$week.$js.')';
                $return[$i]['curriculumName'] = $value['curriculumName'];
                $i++;
            }
        }
        return $return;
    }
    private function toWeekArray($i,$str){
        $return = array();
        if($str == 'year'){
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
        }
        if($str == 'wk'){
            $return = array(
                '0' => '周一',
                '1' => '周二',
                '2' => '周三',
                '3' => '周四',
                '4' => '周五',
                '5' => '周六',
                '6' => '周末',
            );
        }
        if($str == 'js'){
            $return = array(
                '0' => '第一节',
                '1' => '第二节',
                '2' => '第三节',
                '3' => '第四节',
                '4' => '第五节',
                '5' => '第六节',
                '6' => '第七节',
                '7' => '第八节',
                '8' => '第九节',
                '9' => '第十节',
                '10' => '第十一节',
                '11' => '第十二节',
                '12' => '第十三节',
                '13' => '第十四节',
                '14' => '第十五节',
                '15' => '第十六节',
                '16' => '第十七节',
            );
        }
        return $return[$i];
    }
    //班级不排课
    public function classLimit($pkListId){
        $classLimitLimit = array();
        $classLimit = M('pk_class_time_limit')->where(array('pkListId' => $pkListId))->select();
        foreach($classLimit as $key => $value){
            $data = unserialize($value['classSet']);
            foreach($data as $key1 => $value1){
                foreach($value1 as $key2  => $value2){
                    if($value2 == 2){
                        $classLimitLimit[] = array(
                            'gradeId' => $value['gradeId'],
                            'classId' => $value['classId'],
                            'className' => $value['className'],
                            'gradeName' => $value['gradeName'],
                            'y' => $key1,  //代表纵坐标
                            'x' => $key2   //代表横坐标，x=0相当于星期一，x=1相当于星期二
                        );
                    }
                }
            }
        }
        return $classLimitLimit;
    }
    //科目不排课
    private function getLimitTeacerAndclass($pkListId){
        $subjectLimitLimit = array();
        $classLimit = M('pk_curriculum_limit')->where(array('pkListId' => $pkListId))->select();
        foreach($classLimit as $key => $value){
            $data = unserialize($value['classSet']);
            foreach($data as $key1 => $value1){
                foreach($value1 as $key2  => $value2){
                    if($value2 == 3){
                        $subjectLimitLimit[] = array(
                            'className' => $value['className'],
                            'gradeName' => $value['gradeName'],
                            'classId' => $value['classId'],
                            'gradeId' => $value['gradeId'],
                            'curriculumName' => $value['curriculumName'],
                            'curriculumId' => $value['curriculumId'],
                            'y' => $key1,  //代表纵坐标
                            'x' => $key2   //代表横坐标，x=0相当于星期一，x=1相当于星期二
                        );
                    }
                }
            }
        }
        return $subjectLimitLimit;
    }
    //教师不排课
    private function teacherLimit($pkListId){
        $teacherLimitLimit = array();
        $classLimit = M('pk_teacher_limit')->where(array('pkListId' => $pkListId))->select();
        foreach($classLimit as $key => $value){
            $data = unserialize($value['classSet']);
            foreach($data as $key1 => $value1){
                foreach($value1 as $key2  => $value2){
                    if($value2 == 4){
                        $teacherLimitLimit[] = array(
                            'teacherId' => $value['teacherId'],
                            'teacherName' => $value['teacherName'],
                            'y' => $key1,  //代表纵坐标
                            'x' => $key2   //代表横坐标，x=0相当于星期一，x=1相当于星期二
                        );
                    }
                }
            }
        }
        return $teacherLimitLimit;
    }
    //排课范围
    public function pkRang($pkListId,$true){ //true 0 为年级1为班级加年级
        $pkList = M('pk_list')->where(array('id' => $pkListId))->find();
        $scId = $pkList['scId'];
        $rangeList = explode(',',$pkList['pkRange']);
        $i = 0;
        $data = array();
        foreach($rangeList as $key => $value){
            $grade = M('grade')->where(array('scId' => $scId,'gradeid'=> $value))->find();
            $gradeName = $grade['name'];
            if($true){
                $class = M('class')->where(array('scId' => $scId,'grade'=> $value))->order('classname')->select();
                foreach($class as $key1 => $value1){
                    unset($value1['major']);
                    unset($value1['levelid']);
                    unset($value1['branch']);
                    unset($value1['number']);
                    unset($value1['scId']);
                    unset($value1['lastRecordTime']);
                    unset($value1['createTime']);
                    unset($value1['grade']);
                    unset($value1['userid']);
                    $value1['classId'] =  $value1['classid'];
                    unset($value1['classid']);
                    $value1['className'] =  $value1['classname'];
                    unset($value1['classname']);
                    $value1['gradeName'] = $gradeName;
                    $value1['gradeId'] = $value;
                    $data[] = $value1;
                }
            }else{
                $data[] = $gradeName;
            }
            $i++;
        }
        return $data;
    }
    //课程预排
    private function prvPk($pkListId){
        $preGradeClassPk = array();
        $preClass = M('pk_class_before_plan')->where(array('pkListId' => $pkListId))->select();
        foreach($preClass as $key => $value){
            $data = unserialize($value['classSet']);
            foreach($data as $key1 => $value1){
                foreach($value1 as $key2 => $value2){
                    if(is_array($value2)){
                        if($value2['statu'] == 5){
                            $preGradeClassPk[] = array(
                                'subjectName' => $value2['subject'],
                                'subjectId' =>$value2['subjectId'],
                                'statu' => $value2['statu'],
                                'teacherName' =>$value2['teacherName'],
                                'teacherId' => $value2['teacherId'],
                                'className' => $value['className'],
                                'gradeName' => $value['gradeName'],
                                'classId' => $value['classId'],
                                'gradeId' => $value['gradeId'],
                                'y' => $key1,  //代表纵坐标
                                'x' => $key2   //代表横坐标，x=0相当于星期一，x=1相当于星期二
                            );
                        }
                    }
                }
            }
        }
        return $preGradeClassPk;
    }
    //周课时
    public function weekJie($pkListId){
        $pkList = M('pk_time')->where(array('pkListId' => $pkListId))->find();
        $data = unserialize($pkList['ClassSet']);
        $maxDay = 0;
        foreach($data['week'] as $key => $value){
            $i = 0;
            foreach($value as $key1 => $value1){
                if($value1 == 1){
                   $i++;
                }
            }
            if($i>$maxDay){
                $maxDay = $i;
            }
        }
        $count = 0;
        foreach($data['section'] as $key => $value){
            $count = $count + $value;
        }
        return array('days' => $maxDay,'count' =>$maxDay*$count );
    }
    //合班
    private function hb($pkListId){
        $hbClass = M('pk_hb_set')->where(array('pkListId' => $pkListId))->select();
        $return = array();
        $i = 0;
        foreach($hbClass as $key => $value){
            $return[$i]['subjectId'] = $value['subjectId'];
            $return[$i]['teacherId'] = $value['teacherId'];
            $return[$i]['teacherName'] = $value['teacherName'];
            $return[$i]['subjectName'] = $value['subjectName'];
            $return[$i]['data'] = $value['classSet'];
            $i++;
        }
        return $return;
    }
    //判断教师课程是否已经排课
    private function pdTeacherPk($X,$Y,$class,$grade){
        $teacherTable ='';
    }
    //判断课程节数是否可拍
    private function pdClassCount(){

    }
    private function Jb($jie){
        $return = array(
            0 => '语文',
            1 => '英语',
            2 => '数学',
            3 => '物理',
            4 => '政治',
            5 => '化学',
            6 => '历史',
            7 => '生物',
            8 => '地理',
            9 => '音乐',
            10 => '美术',
            11 => '科技'
        );
    }
    //public
    //得到教师，和教师所交课程
    public function getTeacherAndSubject(){
        $type = $_GET['type'];
        $gradeId = $_GET['gradeId'];
        $classId = $_GET['classId'];
        if($type == 'pkList'){
            $session = $this->get_session('loginCheck',false);
            $scId = $session['scId'];
            $pkListId = $_GET['pkListId'];
            $data  = M('')->query("SELECT * FROM mks_jw_schedule WHERE scId=$scId and gradeId=$gradeId AND classId = $classId GROUP BY techerName");
            $this->returnJson(array('statu' => 1,'message' => 'success','data' => $data),true);
        }
    }
    //教学计划默认
    public function classTimeSeting(){
        M('jw_schedule')->where(array('className'));
        $pkListId = $_GET['pkListId'];
        $pk_list = M('pk_list')->where(array('id' => $pkListId))->find();
        $range = $pk_list['pkRange'];
        $rangeList = explode(',','1,2,3');
        $returnData = array();
        foreach($rangeList as $key => $value){
            $returnData[] = M('')->query("SELECT subject,techerId,techerName,grade,className FROM mks_jw_schedule where grade=$value ORDER BY className");
        }
        $returnDataTrue = array();
        foreach($returnData as $key => $value){
            foreach($value as $key1 => $value1){
                $value1['section'] = 0;
                $returnDataTrue[$value1['grade']][$value1['className']][] = $value1;
            }
        }
        $return = array();
        //print_r($returnDataTrue);
        foreach($returnDataTrue as $key => $value){
            foreach($value as $key1 => $value1){
                $return[] = $value1;
            }
        }
        $session = $this->get_session('loginCheck',false);
        $scId = $session['scId'];
        M('pk_jx_plan')->add(array(
            'scId' => $scId,
            'pkListId' => 1,
            'classSet' => serialize($return),
            'createTime' => strtotime(date('Y-m-d'))
        ));
        $Data = M('pk_jx_plan')->where(array('pkListId' =>1 ))->find();
        print_r(unserialize($Data['classSet']));
    }
    //
    public function getTest(){
        $data = M('pk_default_limit')->where(array('pkListId' => 15))->find();
        $data = unserialize($data['classSet']);
        for($j = 0; $j<count($data[]);$j++){
            for($i = 0; $i<7; $i++){
                echo $data[$i][$j];
            }
        }
    }
}