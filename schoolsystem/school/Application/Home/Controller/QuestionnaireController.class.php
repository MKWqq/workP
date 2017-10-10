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
class QuestionnaireController extends Base
{
    public function questionnaireRecord(){//问卷记录
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        $userName = $jbXn['name'];
        if($type == 'getList'){
            $data = M('question_list')->field('questionId,questionName,createTime,state,userNum,browser,fillProportion,fillAvgTime')->where(array('scId' => $scId))->select();
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
        }
        if($type == 'delete'){
            $questionId = $_POST['questionId'];
            if(M('question_list')->where(array('questionId' => $questionId,'scId' => $scId))->delete()){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'startOrEnd'){
            $questionId = $_POST['questionId'];
            $qu = M('question_list')->field('state')->where(array('scId' => $scId,'questionId' => $questionId))->find();
            if($qu['state'] == 1){
                if(M('question_list')->where(array('questionId' => $questionId,'scId' => $scId))->setField(array('state' => 0))){
                    $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
                }
                $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
            }else{
                if(M('question_list')->where(array('questionId' => $questionId,'scId' => $scId))->setField(array('state' => 1,'releaseId' => $userId,'releaseName' => $userName,'releaseTime' => date('Y-m-d H:i:s')))){
                    $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
                }
                $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
            }
        }
        if($type == 'getUpdata'){
            $questionId = $_GET['questionId'];
            $content = M('question_list')->field('content,questionName,explain,user')->where(array('scId' => $scId,'questionId' => $questionId))->find();
            $paper = unserialize($content['content']);
            $user = unserialize($content['user']);
            $return = array(
                'content' => $paper,
                'user' => $user,
                'explain' => $content['explain'],
                'questionName' =>  $content['questionName']
            );
            $this->returnJson($return,true);
        }
        if($type == 'preview'){
            $questionId = $_GET['questionId'];
            $content = M('question_list')->field('content,questionName,explain')->where(array('scId' => $scId,'questionId' => $questionId))->find();
            $paper = unserialize($content['content']);
            $user = unserialize($content['user']);
            $return = array(
                'content' => $paper,
                'explain' => $content['explain'],
                'questionName' =>  $content['questionName']
            );
            M('question_list')->where(array('scId' => $scId,'questionId' => $questionId))->setInc('browser',1);
            $this->returnJson(array('statu' => 0, 'message' => 'fail','data' => $return),true);
        }
        if($type == 'export') {
            $questionId = $_GET['questionId'];
            $content = M('question_list')->field('content,questionName,explain,user')->where(array('scId' => $scId,'questionId' => $questionId))->find();
            $title = $content['questionName'];
            $paper = unserialize($content['content']);
            $fileName = 'question' . $questionId;
            echo "/Public/upload/questionnaire/$fileName.doc";
            $myFile = fopen("./Public/upload/questionnaire/$fileName.doc", "w") or die("Unable to open file!");
            fwrite($myFile, $title . "\n");
            fwrite($myFile, "\n");
            fwrite($myFile, "\n");
            foreach ($paper as $key => $value) {
                if ($value['type'] == 1) {
                    fwrite($myFile, $value['serialNum'] . ':' . $value['oneTitle'] . '[单选题]' . "\n");
                    foreach ($value['answer'] as $key1 => $value1) {
                        fwrite($myFile, $value1 . "\n");
                    }
                    fwrite($myFile, "\n");
                    fwrite($myFile, "\n");
                }
                if ($value['type'] == 2) {
                    fwrite($myFile, $value['serialNum'] . ':' . $value['oneTitle'] . '[多选题]' . "\n");
                    foreach ($value['answer'] as $key1 => $value1) {
                        fwrite($myFile, $value1 . "\n");
                    }
                    fwrite($myFile, "\n");
                    fwrite($myFile, "\n");
                }
                if ($value['type'] == 3) {
                    fwrite($myFile, $value['serialNum'] . ':' . $value['oneTitle'] . '[填空题]' . "\n");
                    fwrite($myFile, "\n");
                    fwrite($myFile, "\n");
                }
                if ($value['type'] == 4) {
                    fwrite($myFile, $value['serialNum'] . ':' . $value['oneTitle'] . '[分数题]' . "\n");
                    fwrite($myFile, "\n");
                    fwrite($myFile, "\n");
                }
            }
            fclose($myFile);
            $downType = $_GET['downType'];
            $url = $this::$downUrl;
            header("Location: $url/Public/upload/questionnaire/$fileName.doc");
        }
        if($type == 'updata'){
            $questionId = $_POST['questionId'];
            $questionName = $_POST['questionName'];
            $content = $_POST['content'];
            $user = $_POST['user'];
            $explain = $_POST['explain'];
            $data = array(
                'questionName' => $questionName,
                'userNum' =>count($user),
                'content' => serialize($content),
                'explain' => $explain,
                'user' => serialize($user)
            );
            if(M('question_list')->where(array('scId' => $scId,'questionId' => $questionId))->setField($data)){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'getCheack'){

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
    public function fillTask(){
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'getFillTaskList'){
            $list = M('question_list')->field('questionId,questionName,explain,user,releaseId,releaseName,releaseTime')->where(array('scId' => $scId))->select();
            $userList = array();
            foreach($list as $key => $value){
                $data = unserialize($list[$key]['user']);
                foreach($data as $key1 => $value1){
                    if($value1['id'] == $userId){
                        if($value1['ifFill'] == 0){
                            $value['ifFill'] = '未提交';
                        }else{
                            $value['ifFill'] = '已提交';
                        }
                        unset($value['user']);
                        $userList[] = $value;
                    }
                }
            }
            $this->returnJson($userList,true);
        }
        if($type == 'fillTaskCreateOrUpdata'){
             $answer = array(
               0 =>array(
                    'serialNum' => 1,
                    'type' => 1,
                    'answer' =>0,
               ),
               1 =>array(
                   'serialNum' => 2,
                   'type' => 1,
                   'answer' =>0,
               ),
               2 =>array(
                   'serialNum' => 3,
                   'type' => 2,
                   'answer' =>'2,3',
               ),
               3 =>array(
                   'serialNum' => 4,
                   'type' => 3,
                   'answer' =>2,
               ),
               4 =>array(
                'serialNum' => 5,
                'type' => 4,
                'answer' =>'网络层,数据链路层,物理层,传输层,应用层',
                )
            );
            //$answer = $_POST['anwser'];
            $questionId = $_GET['questionId'];
            $fillTimes = $_GET['fillTimes'];
            $list = M('question_list')->field('content,questionName,explain,user')->where(array('scId' => $scId,'questionId' => $questionId))->find();
            $user = unserialize($list['user']);
            foreach($user as $key => $value){
                if($value['id'] == $userId){
                    $user[$key]['ifFill'] = 1;
                    $user[$key]['fillTime'] = date('Y-m-d H:i;s');
                    $user[$key]['fillTimes'] = $fillTimes;
                    $user[$key]['anwser'] = $answer;
                }
            }
            $user = serialize($user);
            M('question_list')->where(array('scId' => $scId,'questionId' => $questionId))->setField(array('user' => $user));
        }
        if($type == 'fillTask'){
            $questionId = $_GET['questionId'];
            $content = M('question_list')->field('content,questionName,explain,user')->where(array('scId' => $scId,'questionId' => $questionId))->find();
            $paper = unserialize($content['content']);
            $user = unserialize($content['user']);
            foreach($user as $key => $value){
                if($value['id'] == $userId){
                    if($value['ifFill'] == 0){
                        $value['anwser'] = array();
                    }
                    $user = $value;
                }
            }
            $return = array(
                'content' => $paper,
                'explain' => $content['explain'],
                'questionName' =>  $content['questionName'],
                'user' => $user
            );
            print_r($return);
        }
        if($type == 'fillTaskLook'){
            $questionId = $_GET['questionId'];
            $content = M('question_list')->field('content,questionName,explain')->where(array('scId' => $scId,'questionId' => $questionId))->find();
            $paper = unserialize($content['content']);
            $user = unserialize($content['user']);
            $return = array(
                'content' => $paper,
                'explain' => $content['explain'],
                'questionName' =>  $content['questionName']
            );
            $this->returnJson($return,true);
        }
    }
    public function Statistics(){
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $userName = $jbXn['name'];
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'getQuList'){
            $list = M('question_list')->field('questionId,questionName')->where(array('scId' => $scId))->select();
            print_r($list);
        }
        if($type == 'getWd'){
            $questionId = $_GET['questionId'];
            $role = M('role')->where(array('scId' => array(array('eq',0),array('eq',$scId),'or')))->select();
            $content = M('question_list')->field('user')->where(array('scId' => $scId,'questionId' => $questionId))->find();
            $user  = unserialize($content['user']);
            $roleUser = array();
            $roleRe = array();
            foreach($role as $key => $value){
                $roleRe[$value['roleId']] = $value['roleName'];
            }
            foreach($user as $key => $value){
                $roleUser[$value['roleId']]['grade0rclass'] = $roleRe[$value['roleId']];
                if($value['roleId'] == $this::$studentRoleId || $value['roleId'] == $this::$jZroleId ){
                    $roleUser[$value['roleId']]['data'][$value['grade']]['grade0rclass'] =    $this->gradeToZhong($value['grade']);
                    //$roleUser[$value['roleId']]['data'][$value['grade']]['grade0rclass'] =    $this->gradeToZhong($value['grade']);
                    $roleUser[$value['roleId']]['data'][$value['grade']]['data'][$value['className']]['grade0rclass'] = $value['className'];
                    unset($value['anwser']);
                    unset($value['fillTimes']);
                    $roleUser[$value['roleId']]['data'][$value['grade']]['data'][$value['className']]['data'][] = $value;
                }else{
                    unset($value['anwser']);
                    unset($value['fillTimes']);
                    $roleUser[$value['roleId']]['data'][] = $value;
                }
            }
            $return = array();
            $i = 0;
            foreach($roleUser as $key => $value){
                if($key == $this::$studentRoleId || $key == $this::$jZroleId ) {
                    $return[$i]['grade0rclass'] = $value['grade0rclass'];
                    $j = 0;
                    foreach($value['data'] as $key1 => $value1){
                        $return[$i]['data'][$j]['grade0rclass'] = $value1['grade0rclass'];
                        $z =0;
                        foreach($value1['data'] as $key2 => $value2){
                            $return[$i]['data'][$j]['data'][$z] = $value2;
                            $z++;
                        }
                        $j++;
                    }
                }else{
                    $return[$i] = $value;
                }
                $i++;
            }
            print_r($return);
        }
        if($type == 'select'){
            $questionId = $_GET['questionId'];
            $serialNum = $_GET['serialNum'];
            $answer = $_GET['answer'];
            $list = M('question_list')->field('user,content')->where(array('scId' => $scId,'questionId' => $questionId))->find();
            $content = unserialize($list['content']);
            $user = unserialize($list['user']);
            $return = array();
            if($serialNum){
                foreach($user as $key => $value){
                    if($value['ifFill']){
                        foreach($value['anwser'] as $key1 => $value1){
                            if($value1['serialNum'] == $serialNum){
                                $ex = explode(',',$value1['answer']);
                                foreach($ex as $key2 => $value2){
                                    $value1['answer'] = $value2;
                                    $return[] = $value1;
                                }
                                break;
                            }
                        }
                    }
                }
                $returnData = array();
                foreach($content as $key => $value){
                    if($value['serialNum'] == $serialNum){
                        $content = $value;
                        break;
                    }
                }
                $all = 0;
                $answer = explode(',',$answer);
                foreach($return as $key => $value){
                    foreach($answer as $key1 => $value1){
                        if($value1 == $value['answer']){
                            $all++;
                            if(isset($returnData[$value['answer']])){
                                $returnData[$value['answer']]['count']++;
                            }else{
                                $returnData[$value['answer']]['count'] = 1;
                            }
                        }
                    }
                }
                foreach($returnData as $key => $value){
                    $returnData[$key]['percentage'] = (round($value['count']/$all,4)*100).'%';
                    $returnData[$key]['title'] = $content['answer'][$key];
                }
                sort($returnData);
                $returnRel[] = array('data' => $returnData,'oneTitle' => $content['oneTitle']);
                print_r($returnRel);
            }else{
                foreach($user as $key => $value){
                    if($value['ifFill']){
                        foreach($value['anwser'] as $key1 => $value1){
                            if($value1['type'] == 1 || $value1['type'] == 2){
                                $ex = explode(',',$value1['answer']);
                                foreach($ex as $key2 => $value2){
                                    $value1['answer'] = $value2;
                                    $return[$value1['serialNum']][] = $value1;
                                }
                            }
                        }
                    }
                }
                $returnData = array();
                $all = 0;
                $answer = explode(',',$answer);
                foreach($return as $key => $value){
                    foreach($value as $key3 => $value3){
                        if(isset($returnData[$key][$value3['answer']])){
                            $returnData[$key][$value3['answer']]['count']++;
                        }else{
                            $returnData[$key][$value3['answer']]['count'] = 1;
                        }
                        $returnData[$key]['all']++;
                    }
                }
                $contentre = array();
                foreach($content as $key => $value){
                    $contentre[$value['serialNum']] = $value;
                }
                $returnList = array();
                $i = 0;
                foreach($returnData as $key => $value){
                    $j = 0;
                    foreach($value as $key1 => $value1){
                        if($key1 !== 'all'){
                            $returnList[$i]['data'][$j]['percentage'] = (round($value1['count']/$value['all'],4)*100).'%';
                            $returnList[$i]['data'][$j]['title'] = $content[$key]['answer'][$key1];
                            $j++;
                        }
                    }
                    $returnList[$i]['oneTitle'] = $content[$key]['oneTitle'];
                    $i++;
                }
                print_r($returnList);
            }
        }
        if($type == 'getQuestion'){
            $questionId = $_GET['questionId'];
            $list = M('question_list')->field('content')->where(array('scId' => $scId,'questionId' => $questionId))->find();
            $content = unserialize($list['content']);
            $return = array();
            foreach($content as $key => $value){
                if($value['type'] == 1 || $value['type'] == 2 ){
                    $return[] = $value;
                }
            }
            print_r($return);
        }
    }
    public function createQuestion(){
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $userName = $jbXn['name'];
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'getUserList'){
            $role = M('role')->where(array('scId' => array(array('eq',0),array('eq',$scId),'or')))->select();
            $studentRole = $this::$studentRoleId;
            $jzRole = $this::$jZroleId;
            $adminRole = $this::$adminRoleId;
            $user = M('')->query("select id,name,roleId,class,grade,gradeId,className from mks_user where scId= $scId AND roleId!=$adminRole");
            $roleUser = array();
            $roleRe = array();
            foreach($role as $key => $value){
                $roleRe[$value['roleId']] = $value['roleName'];
            }
            foreach($user as $key => $value){
                $roleUser[$value['roleId']]['grade0rclass'] = $roleRe[$value['roleId']];
                if($value['roleId'] == $this::$studentRoleId || $value['roleId'] == $this::$jZroleId ){
                    $roleUser[$value['roleId']]['data'][$value['grade']]['grade0rclass'] =    $this->gradeToZhong($value['grade']);
                    $roleUser[$value['roleId']]['data'][$value['grade']]['data'][$value['className']]['grade0rclass'] = $value['className'];
                    $roleUser[$value['roleId']]['data'][$value['grade']]['data'][$value['className']]['data'][] = $value;
                }else{
                    $roleUser[$value['roleId']]['data'][] = $value;
                }
            }
            //print_r($roleUser);
            $return = array();
            $i = 0;
            foreach($roleUser as $key => $value){
                if($key == $this::$studentRoleId || $key == $this::$jZroleId ) {
                    $return[$i]['grade0rclass'] = $value['grade0rclass'];
                    $j = 0;
                   foreach($value['data'] as $key1 => $value1){
                       $return[$i]['data'][$j]['grade0rclass'] = $value1['grade0rclass'];
                       $z =0;
                       foreach($value1['data'] as $key2 => $value2){
                           $return[$i]['data'][$j]['data'][$z] = $value2;
                           $z++;
                       }
                       $j++;
                   }
                }else{
                    $return[$i] = $value;
                }
                $i++;
            }
            print_r($return);
            //$this->returnJson(array('statu' => 1, 'message' => 'success','data' => $return),true);
        }
        if($type == 'create'){
            $content = array(
                0 => array(
                    'oneTitle' => '今天星期几',
                    'type' => 1,
                    'serialNum' => 1,
                    'answer' => array(
                        0 => '2017-09-26',
                        1 => '2017-09-27',
                        2 => '2017-09-28',
                        3 => '2017-09-29',
                    ),
                ),
                1 => array(
                    'oneTitle' => '我的名字是睡？',
                    'type' => 1,
                    'serialNum' => 2,
                    'answer' => array(
                        0 => '张志超',
                        1 => '江龙',
                        2 => '胡俊',
                        3 => '张瑾',
                    ),
                ),
                2 => array(
                    'oneTitle' => '下面哪些是迈科人？',
                    'type' => 2,
                    'serialNum' => 3,
                    'answer' => array(
                        0 => '张志超',
                        1 => '江龙',
                        2 => '胡俊',
                        3 => '张瑾',
                        3 => '王五',
                    ),
                ),
                3 => array(
                    'oneTitle' => '1+2=（）？',
                    'type' => 3,
                    'serialNum' => 4,
                ),
                4 => array(
                    'oneTitle' => '谈谈计算机网络层级结构？',
                    'type' => 4,
                    'serialNum' => 5,
                ),
                5 => array(
                    'oneTitle' => '段落说明',
                    'type' => 5,
                ),
            );//$_POST['content'];
            $user = array(
                0 => array(
                    'id' => 18,
                    'name' => '小江',
                    'roleId' => 14,
                    'class' => null,
                    'grade' => null,
                    'gradeId' => null,
                    'ifFill' => 0,
                    'fillTime' => 0,
                    'className' => null
                ),
                1 => array(
                    'id' => 63,
                    'name' => '王七',
                    'roleId' => 14,
                    'class' => null,
                    'grade' => null,
                    'gradeId' => null,
                    'className' => null,
                    'fillTime' => 0,
                    'ifFill' => 0
                ),
                2 => array(
                    'id' => 92,
                    'name' => '李四ha 0116',
                    'roleId' => 14,
                    'class' => null,
                    'grade' => null,
                    'gradeId' => null,
                    'fillTime' => 0,
                    'ifFill' => 0,
                    'className' => null
                ),
                3 => array(
                    'id' => 791,
                    'name' => '张志超',
                    'roleId' => 15,
                    'class' => 7,
                    'grade' => 1,
                    'gradeId' => 1,
                    'fillTime' => 0,
                    'ifFill' => 0,
                    'className' => 1
                ),
                4 => array(
                    'id' => 803,
                    'name' => '江龙',
                    'roleId' => 15,
                    'class' => 7,
                    'grade' => 1,
                    'fillTime' => 0,
                    'ifFill' => 0,
                    'gradeId' => 1,
                    'className' => 1
                ),
                5 => array(
                    'id' => 795,
                    'name' => '杨程',
                    'roleId' => 15,
                    'class' => 8,
                    'grade' => 1,
                    'gradeId' => 1,
                    'ifFill' => 0,
                    'fillTime' => 0,
                    'className' => 2
                ),
                6 => array(
                    'id' => 793,
                    'name' => '胡俊',
                    'roleId' => 15,
                    'class' => 8,
                    'grade' => 1,
                    'fillTime' => 0,
                    'ifFill' => 0,
                    'gradeId' => 1,
                    'className' => 2
                ),
            );//$_POST['user'];
            $questionName = $_POST['questionName'];
            $explain = $_POST['explain'];
            $data = array(
                'questionName' => $questionName,
                'createTime' => date('Y-m-d H:i;s'),
                'state' => 1,
                'userNum' =>count($user),
                'browser' => 0,
                'fillProportion' => 0,
                'fillAvgTime' => 0,
                'content' => serialize($content),
                'scId' => $scId,
                'explain' => $explain,
                'releaseName' => $userName,
                'releaseId' => $userId,
                'releaseTime' => date('Y-m-d H:i;s'),
                'user' => serialize($user)
            );
            if(M('question_list')->add($data)){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
    }
}