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
class StudentsgrowthrecordController extends Base
{
    /**公用的不设置权限*/
    public function getSubjectList()
    {//得到课程列表//公用的怎么写
        $type = $_GET['type'];
        $scId = $this->get_session('loginCheck', false);
        $scId = $scId['scId'];
        if ($type == 'getSubjectList') { //得到课程列表
            $this->returnJson(array('data' => M('subject')->where(array('scId' => $scId))->select(), 'staut' => 1, 'message' => 'success'), true);
        }
        if ($type == 'getGradeList') { //得到年级列表
            $this->returnJson(array('data' => M('grade')->where(array('scId' => $scId))->select(), 'statu' => 1, 'message' => 'success'), true);
        }
        if ($type == 'getClassList') { //得到班级列表
            $this->returnJson(array('data' => M('class')->where(array('scId' => $scId, 'grade' => $_GET['grade']))->select(), 'message' => 'success', 'statu' => 1), true);
        }
        if ($type == 'getTeacherList') { //得到教师列表
            $field = $_GET['sortType'];
            $sort = $_GET['sort'];
            $this->returnJson(array('statu' => 1, 'message' => 'sucess', 'data' => M('user')->field('id,teachingSubjects,name,jobNumber,phone')->where(array('scId' => $scId, 'roleId' => $this::$teacherRoleId))->order("$field $sort")->select()), true);
        }
    }
    public function basicsSet(){//写评语
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'getGradeClassStudent'){//得到年级班级学生
            $grade = array();
            if($userRoleId == $this::$teacherRoleId){
                $grade = M('jw_schedule')->field('gradeName')->where(array('scId' => $scId,'techerId' => $userId))->group('gradeId')->select();
            }else{
                $grade = M('grade')->field('name')->where(array('scId' => $scId))->group('gradeid')->select();
                foreach($grade as $key => $value){
                    $grade[$key]['gradeName'] = $value['name'];
                }
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
        if($type == 'valueSelect'){
            $grade = array();
            if($userRoleId == $this::$teacherRoleId){
                $grade = M('jw_schedule')->field('gradeName')->where(array('scId' => $scId,'techerId' => $userId))->group('gradeId')->select();
            }else{
                $grade = M('grade')->field('name')->where(array('scId' => $scId))->group('gradeid')->select();
                foreach($grade as $key => $value){
                    $grade[$key]['gradeName'] = $value['name'];
                }
            }
            $value = $_GET['value'];
            $data = M('')->query("SELECT userId,name,gradeId,classId,grade,className FROM mks_student_info WHERE `name` LIKE '%$value%' order by grade,className");
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
        if($type == 'createStudentRecord'){//创建学生记录
            $title = $_POST['title'];
            $label = $_POST['label'];
            $content = $_POST['content'];
            $userId = $_POST['userId'];
            $templateId = $_POST['templateId'];
            if(M('student_growth_record')->add(array(
                'title' => $title,
                'label' => $label,
                'content' => $content,
                'userId' => $userId,
                'scId' => $scId,
                'createTime' => strtotime(date('Y-m-d H:i:s')),
                'url' => $_POST['url'],
                'teacherId' => $jbXn['userId'],
                'teacherName' => $jbXn['name']
            ))){
                foreach($templateId as $key => $value){
                    M('student_growth_template')->where(array('templateId' => $value))->setInc('frequency',1);
                }
                $this->returnJson(array('statu' => 1,'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0,'message' => 'fail'),true);
        }
        if($type == 'uploadFile'){//上传文件
            if($url = $this::upload('recordFile', $fileTypes = array('png', 'jpg', 'jpeg'))){
                $this->returnJson(array('statu' => 1,'message' => 'success','url' => $url),true);
            }
            $this->returnJson(array('statu' => 0,'message' => 'fail','url' => ''),true);
        }
        if($type == 'createLabel'){//创建label
            $labelName = $_POST['labelName'];
            if(M('student_growth_label')->add(array(
                'labelName' => $labelName,
                'scId' => $scId,
                'createTime' => strtotime(date('Y-m-d H:i:s')),
                'weight' => 1
            ))){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'deleteLabel'){//删除label
            $labelId = $_POST['labelId'];
            if(M('student_growth_label')->where(array('scId' => $scId,'weight' => 1,'labelId' => $labelId))->delete()){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'getLabel'){//得到larbel
            $data = M('student_growth_label')->where(array('scId' => $scId))->order('weight')->select();
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
        }
        if($type == 'createModel'){//创建评语
            $modelTypeId = $_POST['modelTypeId'];
            $content = $_POST['content'];
            if(M('student_growth_template')->add(array(
                    'modelTypeId' => $modelTypeId,
                    'content' => $content,
                    'frequency' => 0,
                    'scId' => $scId,
                    'lastRecordTime' => strtotime(date('Y-m-d H:i:s')),
                    'createTime' => strtotime(date('Y-m-d H:i:s'))
                )
            )){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'getModelType'){
            $array = array(
                0 => array(
                    'modelTypeId' => 1,
                    'modelTypeName' => '开头'
                ),
                1 => array(
                    'modelTypeId' => 2,
                    'modelTypeName' => '思想'
                ),
                2 => array(
                    'modelTypeId' => 3,
                    'modelTypeName' => '学习'
                ),
                3 => array(
                    'modelTypeId' => 4,
                    'modelTypeName' => '生活'
                ),
                4 => array(
                    'modelTypeId' => 5,
                    'modelTypeName' => '体育'
                ),
                5 => array(
                    'modelTypeId' => 6,
                    'modelTypeName' => '性格'
                ),
                6 => array(
                    'modelTypeId' => 7,
                    'modelTypeName' => '优点'
                ),
                7 => array(
                    'modelTypeId' => 8,
                    'modelTypeName' => '缺点'
                ),
                8 => array(
                    'modelTypeId' => 9,
                    'modelTypeName' => '寄语'
                ),
                9 => array(
                    'modelTypeId' => 10,
                    'modelTypeName' => '其他'
                )
            );
            $this->returnJson(array('statu' => 1,'message' => 'success','data' => $array),true);
        }
        if($type == 'modelList'){//得到模板列表
            $modelTypeId = $_GET['modelTypeId'];
            $data = M('student_growth_template')->where(array('scId' => $scId,'modelTypeId' => $modelTypeId))->order('lastRecordTime desc')->select();
            $this->returnJson(array('statu' => 1,'message' => 'success','data' => $data),true);
        }
        if($type == 'modelToTop'){//置顶模板
            $templateId = $_GET['templateId'];
            if(M('student_growth_template')->where(array('templateId' => $templateId))->setField(array('lastRecordTime' => strtotime(date('Y-m-d H:i:s'))))){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'createModelType'){//创建模板类型
            if(M('student_growth_model_type')->add(array(
                'modelTypeName' => $_POST['modelTypeName'],
                'scId' => $scId,
                'createTime' => strtotime(date('Y-m-d H:i:s'))
            ))){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'getTestList'){ //得到考试列表
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
        if($type == 'getTestGrade'){ //得到各科考试分数
            $userId = $_GET['userId'];
            $examinationid = $_GET['examinationid'];
            $examination = $_GET['examination'];
            $sore = M('examination_results')->where(array('examinationid' => $examinationid,'userid' => $userId,'scId' => $scId))->order('subjectid')->select();
            $subject = M('subject')->where(array('scId' => $scId))->select();
            $classAvg = M('')->query("SELECT avg(results) as soce,subjectid FROM mks_examination_results WHERE examinationid=$examinationid and scId=$scId GROUP BY subjectid");
            $classAvgTr = array();
            $classAll = 0;
            $personAll = 0;
            foreach($classAvg as $key => $value){
                $classAvgTr[$value['subjectid']] = $value;
                $classAll = $value['soce']+$classAll;
            }
            $classAll = round($classAll,2);
            foreach($sore as $key => $value){
                foreach($subject as $key1 => $value1){
                    if($value['subjectid'] == $value1['subjectid']){
                        $sore[$key]['subjectname'] = $value1['subjectname'];
                        $sore[$key]['classAvg'] = round($classAvgTr[$value['subjectid']]['soce'],2);
                        $personAll = $personAll+$value['results'];
                    }
                }
            }
            $class = array();
            $person = array();
            $subject = array();
            foreach($sore as $key => $value){
                $class[$key]['classAvg'] = $value['classAvg'];
                $person[$key]['user'] = $value['results'];
                $subject[$key]['subjectName'] = $value['subjectname'];
            }
            $return = array('data' => array('class' => $class,'person' => $person,'subject' => $subject),'classAll' => $classAll,'userAll' => $personAll);
            $this->returnJson(array('data' => $return,'statu' => 1,'message' => 'success'),true);
        }
        if($type == 'gradeThink'){

        }
    }
    public function myRecord(){//我的成长记录
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'getList'){
            if($this::$jZroleId == $userRoleId){
                $jz = M('user')->field('childId')->where(array('userId' => $userId))->find();
                //M('')
            }else{

            }
        }
    }
    public function studentsRecord(){//学生成长记录
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'getGradeClassStudent'){//得到年级班级学生
            $grade = array();
            if($userRoleId == $this::$teacherRoleId){
                $grade = M('jw_schedule')->field('gradeName')->where(array('scId' => $scId,'techerId' => $userId))->group('gradeId')->select();
            }else{
                $grade = M('grade')->field('name')->where(array('scId' => $scId))->group('gradeid')->select();
                foreach($grade as $key => $value){
                    $grade[$key]['gradeName'] = $value['name'];
                }
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
        if($type == 'getUserList'){//得到用户记录
            $userId = $_GET['userId'];
            $data = M('student_growth_record')->where(array('scId' => $scId,'userId' => $userId))->order('createTime desc')->select();
            $labl = M('student_growth_label')->where(array('scId' => $scId))->select();
            $lablRrue = array();
            foreach($labl as $key => $value){
                $lablRrue[$value['labelId']] = $value;
            }
            foreach($data as $key => $value){
                $la = $value['label'];
                $la = explode(',',$la);
                foreach($la as $key1 => $value1){
                    $data[$key]['la'][] = $lablRrue[$value1];
                }
            }
            $this->returnJson(array('statu' => 1,'message' => 'success','data' => $data),true);
        }
        if($type == 'updataRecord'){
            $data = $_POST['data'];
            $recordId = $data['recordId'];
            if($recordId){
                if(M('student_growth_record')->where(array('recordId' => $recordId))->setField($data) === false){
                    $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
                }
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
    }
    public function agumentLarblSet(){//评语标签
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'createLabel'){
            $labelName = $_POST['labelName'];
            if(M('student_growth_label')->add(array(
                'labelName' => $labelName,
                'scId' => $scId,
                'createTime' => strtotime(date('Y-m-d H:i:s')),
                'weight' => 2
            ))){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'deleteLabel'){//删除label
            $labelId = $_POST['labelId'];
            $i = 0;
            if($labelId){
                foreach($labelId as $key => $value){
                    if(!M('student_growth_label')->where(array('scId' => $scId,'weight' => 2,'labelId' => $value))->delete()){
                        $i = 1;
                    }
                }
                if($i){
                    $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
                }
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'getLabel'){//得到larbel
            $labelId = $_POST['labelId'];
            $data = M('student_growth_label')->where(array('scId' => $scId,'weight' => 2))->select();
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
        }
    }
    public function familyRecord(){
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'getGradeClassStudent'){//得到年级班级学生
            $grade = array();
            if($userRoleId == $this::$teacherRoleId){
                $grade = M('jw_schedule')->field('gradeName')->where(array('scId' => $scId,'techerId' => $userId))->group('gradeId')->select();
            }else{
                $grade = M('grade')->field('name')->where(array('scId' => $scId))->group('gradeid')->select();
                foreach($grade as $key => $value){
                    $grade[$key]['gradeName'] = $value['name'];
                }
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
        if($type == 'create'){//得到年级班级学生
            $userId = $_POST['userId'];
            $examinationid = $_POST['examinationid'];
            $comment = $_POST['comment'];
            if(M('student_growth_family')->add(
                array(
                    'userId' => $userId,
                    'examinationid' =>$examinationid,
                    'comment' => $comment,
                    'scId' => $scId,
                    'createTime' => strtotime(date('Y-m-d H:i:s')),
                    'lastRecordTime' => strtotime(date('Y-m-d H:i:s'))
                )
            )){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'getTestList'){ //得到考试列表
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