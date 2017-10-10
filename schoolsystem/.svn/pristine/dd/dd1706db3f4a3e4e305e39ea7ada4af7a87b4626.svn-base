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
class EqrepairController extends Base
{
    /**公用的不设置权限*/
    public function basicsSet(){//基础设施
        $type = $_GET['type'];
        $scId = $this->get_session('loginCheck', false);
        $scId = $scId['scId'];
        if($type == 'getRepairType'){
            $data = M('repair_type')->where(array('scId' => $scId))->select();
            foreach($data as $key => $value){
                $data[$key]['user'] = unserialize($value['user']);
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
        }
        if($type == 'createRepairType'){
            $repairType = $_POST['repairType'];
            if(M('repair_type')->add(array(
                'repairType' => $repairType,
                'scId' => $scId,
                'createTime' => strtotime(date('Y-m-d H:i:s'))
            ))){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'deleteRepairType'){
            $id = $_POST['id'];
            foreach($id as $key => $value){
                M('repair_type')->where(array('id' => $value))->delete();
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
        }
        if($type == 'updataRepairType'){
            $id = $_POST['id'];
            $user = $_POST['user'];
            $repairType = $_POST['repairType'];
            if(M('repair_type')->where(array('id' => $id))->setField(array(
                'userId' => serialize($user),
                'repairType' => $repairType
            ))){
                $this->returnJson(array('statu' => 1,'message' => 'succeess'),true);
            }
            $this->returnJson(array('statu' => 0,'message' => 'fail'),true);
        }
        if($type == 'getZgList'){
            $student = $this::$studentRoleId;
            $jz = $this::$jZroleId;
            $id = $_GET['id'];
            $user = M('')->query("SELECT name,id,post from mks_user where scId=$scId AND roleId!=$student and roleId!=$jz");
            $type = M('repair_type')->where(array('id' => $id))->find();
            $reUser = unserialize($type['user']);
            foreach($user as $key => $value){
                if(!$value['post']){
                    $user[$key]['post'] = '教师';
                }
            }
            $this->returnJson(array('statu' => 1,'message' => 'success','data' => array('zgList' => $user,'user' => $reUser)),true);
        }
        if($type == 'deleteUser'){
            $id = $_POST['id'];
            $userId = $_POST['userId'];
            $type = M('repair_type')->where(array('id' => $id))->find();
            $reUser = unserialize($type['user']);
            $reUserRe =array();
            foreach($reUser as $key => $value){
                if($value['id'] == $userId){
                }else{
                    $reUserRe[] = $value;
                }
            }
            if(M('repair_type')->where(array('id' => $id))->setField(array('user' => serialize($reUserRe)))){
                $this->returnJson(array('statu' => 1,'message' => 'del  succeess'),true);
            }
            $this->returnJson(array('statu' => 0,'message' => 'del  fail'),true);
        }
        if($type == 'export'){
            $data = M('repair_type')->where(array('scId' => $scId))->select();
            foreach($data as $key => $value){
                $user  = unserialize($value['user']);
                $strName = '';
                foreach($user as $key1 => $value1){
                    $strName = $value1['name'].'  '.$strName;
                }
                $data[$key]['user'] = $strName;
            }
            $tr = array(
                '0' => array(
                    'en' => 'repairType',
                    'zh' => '报修类别'
                ),
                '1' => array(
                    'en' => 'user',
                    'zh' => '维修人员'
                )
            );
            $this->export($data,$tr);
        }
    }
    private function stateToZn($i){
        $array = array(
            1 => '待处理',
            2 => '已维修',
            3 => '维修失败',
            4 => '已验收'
        );
        return $array[$i];
    }
    public function myRepair(){//我的保修单
        $type = $_GET['type'];
        $scId = $this->get_session('loginCheck',false);
        $userId = $scId['userId'];
        $scId = $scId['scId'];
        if($type == 'getRepairList'){
            $repairType = $_GET['repairType'];
            $id = $_GET['id'];
            $state = $_GET['state'];
            $startTime = '2010-09-13 00:00:00';
            $endTime = date('Y-m-d H:i:s');
            if($_GET['startTime']){
                $startTime = $_GET['startTime'];
            }
            if($_GET['endTime']){
                $endTime = $_GET['endTime'];
            }
            if($id == -1){
                $data = M('repair_list')->where(array('scId' => $scId,'userId' => $userId,'state' =>$state,'applyTime' => array(array('gt',$startTime),array('lt',$endTime))))->order('applyTime desc')->select();
            }else{
                $data = M('repair_list')->where(array('repairTypeId' => $id,'scId' => $scId,'userId' => $userId,'state' =>$state,'applyTime' => array(array('gt',$startTime),array('lt',$endTime))))->order('applyTime desc')->select();
            }
            $user = M('repair_type')->where(array('id' => $id))->find();
            $type = $user['repairType'];
            $user = unserialize($user['user']);
            $userName = '';
            foreach($user as $key => $value){
                $userName = $value['name'].' '.$userName;
            }
            foreach($data as $key => $value){
                $zn = 0;
                if($data[$key]['repairReturn'] == 0){
                    $zn = '无';
                }else{
                    $zn = '已反馈';
                }
                $data[$key]['repairUserName'] = $userName;
                $data[$key]['repairType'] = $type;
                $data[$key]['repairReturnZn'] = $zn;
                $data[$key]['stateName'] = $this->stateToZn($data[$key]['state']);
            }
            if($repairType == 'list'){
                $this->returnJson(array('statu' => 1,'message' =>1,'data' => $data),true);
            }
            if($repairType == 'export'){
                $tr = $this->exportTr();
                $this->export($data,$tr);
            }
        }
        if($type == 'getTypeList'){
            $data = M('repair_type')->field('repairType,id')->where(array('scId' => $scId))->select();
            $array = array(
                'repairType' => '全部',
                'id' => -1
            );
            $i = 1;
            $return = array();
            $return[0] =$array;
            foreach($data as $key => $value){
                $return[$i] = $value;
                $i++;
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $return),true);
        }
        if($type == 'createOrUpdataRepairList'){
            $data = $_POST['data'];
            $myRepairId = $data['id'];
            if($myRepairId){
                unset($data['id']);
                if(M('repair_list')->where(array('id' => $myRepairId))->setField($data)){
                    $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
                }
                $this->returnJson(array('statu' => 1, 'message' => 'fail'),true);
            }else{
                $data['repairNumber'] = uniqid();
                $data['applyTime'] = date('Y-m-d H:i:s');
                $data['state'] = 1;
                $data['userId'] =$userId;
                $data['scId'] = $scId;
                if(M('repair_list')->add($data)){
                    $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
                }
                $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
            }
        }
        if($type == 'deleteRepairList'){
            $id = $_POST['id'];
            if(M('repair_list')->where(array('id' => $id))->delete()){
                M('repair_handle')->where(array('repairId' => $id))->delete();
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'check'){
            $id = $_POST['id'];
            if(M('repair_list')->where(array('id' => $id))->setField(array('state' =>4,'repairState' =>3))){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'uploda'){
            if($url = $this->upload('repair',$fileTypes = array('png', 'jpg', 'jpeg'))){
                $this->returnJson(array('statu' => 1,'message' => 'uploda  succeess','url' => $url),true);
            }
            $this->returnJson(array('statu' => 0,'message' => 'uploda  fail','url' => ''),true);
        }
    }
    public function repairList(){//报修空间
        $type = $_GET['type'];
        $scId = $this->get_session('loginCheck',false);
        $userId = $scId['userId'];
        $scId = $scId['scId'];
        if($type == 'getRepairList'){
            $repairType = $_GET['repairType'];
            $id = $_GET['id'];
            $state = $_GET['state'];
            $startTime = '2010-09-13 00:00:00';
            $endTime = date('Y-m-d H:i:s');
            if($_GET['startTime']){
                $startTime = $_GET['startTime'];
            }
            if($_GET['endTime']){
                $endTime = $_GET['endTime'];
            }
            if($id == -1){
                $data = M('repair_list')->where(array('scId' => $scId,'state' =>$state,'applyTime' => array(array('gt',$startTime),array('lt',$endTime))))->order('applyTime desc')->select();
            }else{
                $data = M('repair_list')->where(array('repairTypeId' => $id,'scId' => $scId,'state' =>$state,'applyTime' => array(array('gt',$startTime),array('lt',$endTime))))->order('applyTime desc')->select();
            }
            $user = M('repair_type')->where(array('id' => $id))->find();
            $type = $user['repairType'];
            $user = unserialize($user['user']);
            $userName = '';
            foreach($user as $key => $value){
                $userName = $value['name'].' '.$userName;
            }
            foreach($data as $key => $value){
                $zn = 0;
                if($data[$key]['repairReturn'] == 0){
                    $zn = '无';
                }else{
                    $zn = '已反馈';
                }
                $data[$key]['repairUserName'] = $userName;
                $data[$key]['repairType'] = $type;
                $data[$key]['repairReturnZn'] = $zn;
                $data[$key]['stateName'] = $this->stateToZn($data[$key]['state']);
            }
            if($repairType == 'list'){
                $this->returnJson(array('statu' => 1,'message' =>1,'data' => $data),true);
            }
            if($repairType == 'export'){
                $tr = $this->exportTr();
                $this->export($data,$tr);
            }
        }
        if($type == 'getTypeList'){
            $data = M('repair_type')->field('repairType,id')->where(array('scId' => $scId))->select();
            $array = array(
                'repairType' => '全部',
                'id' => -1
            );
            $i = 1;
            $return = array();
            $return[0] =$array;
            foreach($data as $key => $value){
                $return[$i] = $value;
                $i++;
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $return),true);
        }
    }
    public function repairTask(){//维修任务
        $type = $_GET['type'];
        $scId = $this->get_session('loginCheck',false);
        $userId = $scId['userId'];
        $scId = $scId['scId'];
        $array = array();
        if($type == 'getRepairTaskList'){
            $repairType = $_GET['repairType'];
            $id = $_GET['id'];
            $state = $_GET['state'];
            $startTime = '2010-09-13 00:00:00';
            $endTime = date('Y-m-d H:i:s');
            if($_GET['startTime']){
                $startTime = $_GET['startTime'];
            }
            if($_GET['endTime']){
                $endTime = $_GET['endTime'];
            }
            if($id == -1){
                $data = M('repair_list')->where(array('scId' => $scId,'state' =>$state,'applyTime' => array(array('gt',$startTime),array('lt',$endTime))))->order('applyTime desc')->select();
            }else{
                $data = M('repair_list')->where(array('repairTypeId' => $id,'scId' => $scId,'state' =>$state,'applyTime' => array(array('gt',$startTime),array('lt',$endTime))))->order('applyTime desc')->select();
            }
            foreach($data as $key => $value){
                $user = M('repair_type')->where(array('id' => $value['repairTypeId']))->find();
                $user  = unserialize($user['user']);
                $data[$key]['user'] = $user;
                $userName = '';
                $statu = 0;
                foreach($user as $key1 => $value1){
                    $userName = $value1['name'].' '.$userName;
                    if($userId == $value1['id']){
                        $statu = 1;
                    }
                }
                if($statu){
                    $zn = 0;
                    if($value['repairReturn'] == 0){
                        $zn = '无';
                    }else{
                        $zn = '已反馈';
                    }
                    $value['repairUserName'] = $userName;
                    $value['repairType'] = $type;
                    $value['repairReturnZn'] = $zn;
                    $value['stateName'] = $this->stateToZn($value['state']);
                    $array[] = $value;
                }
            }
            if($repairType == 'list'){
                $this->returnJson(array('statu' => 1,'message' =>1,'data' => $array),true);
            }
            if($repairType == 'export'){
                $tr = $this->exportTr();
                $this->export($array,$tr);
            }
        }
        if($type == 'getTypeList'){
            $data = M('repair_type')->field('repairType,id')->where(array('scId' => $scId))->select();
            $array = array(
                'repairType' => '全部',
                'id' => -1
            );
            $i = 1;
            $return = array();
            $return[0] =$array;
            foreach($data as $key => $value){
                $return[$i] = $value;
                $i++;
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $return),true);
        }
        if($type == 'Orders'){
            $id = $_POST['id'];
            if(M('repair_list')->where(array('id' => $id))->setField(array('repairState' =>1,'receiveUserId'=> $userId,'reciveTime' => date('Y-m-d H:i:s')))){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'handle'){
            $id = $_POST['id'];
            if(M('repair_handle')->add(array(
                'repairId' => $id,
                'state' =>$_POST['state'],
                'method' => $_POST['method'],
                'reason' => $_POST['reason'],
                'replaceType' => $_POST['replaceType'],
                'logo' => $_POST['logo'],
                'createTime' => date('Y-m-d H:i:s'),
                'feedback' => $_POST['feedback'],
                'userId' => $userId
            ))){
                if($_POST['state'] ==1){
                    if(M('repair_list')->where(array('id' => $id))->setField(array('repairState' =>2))){
                        if(M('repair_list')->where(array('id' => $id))->setField(array('state' =>2))){
                            $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
                        }
                    }
                }else{
                    if(M('repair_list')->where(array('id' => $id))->setField(array('repairState' =>2))){
                        if(M('repair_list')->where(array('id' => $id))->setField(array('state' =>3))){
                            $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
                        }
                    }
                }
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }else{
                $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
            }
        }
        if($type == 'upload'){
            if($url = $this->upload('repair',$fileTypes = array('png', 'jpg', 'jpeg'))){
                $this->returnJson(array('statu' => 1,'message' => 'uploda  succeess','url' => $url),true);
            }
            $this->returnJson(array('statu' => 0,'message' => 'uploda  fail','url' => ''),true);
        }
        if($type == 'getRepairList'){
            $id = $_GET['id'];
            $data = M('repair_list')->where(array('id' => $id))->find();
            $user = M('repair_type')->where(array('id' => $id))->find();
            $data['repairType'] = $user['repairType'];
            $this->returnJson(array('statu' => 1,'message' => 'success','data' => $data),true);
        }
    }
    public function repairStatistics(){//维修统计
        $type = $_GET['type'];
        $scId = $this->get_session('loginCheck',false);
        $userId = $scId['userId'];
        $scId = $scId['scId'];
        if($type == 'getList'){
            $startTime = '2010-09-13 00:00:00';
            $endTime = date('Y-m-d H:i:s');
            if($_GET['startTime']){
                $startTime = $_GET['startTime'];
            }
            if($_GET['endTime']){
                $endTime = $_GET['endTime'];
            }
            $typeList = $_GET['typeList'];
            if($typeList == 1){//类别
                $data = M('repair_list')->field('repairTypeId,state,repairState')->where(array('scId' => $scId,'applyTime' => array(array('gt',$startTime),array('lt',$endTime))))->order('applyTime desc')->select();
                $type = M('repair_type')->field('id,repairType')->where(array('scId' => $scId))->select();
                $typeRe = array();
                foreach($type as $key => $value){
                    $typeRe[$value['id']] = $value['repairType'];
                }
                $array = array();
                $allCount = 0;
                $wait = 0;
                $have = 0;
                $haved = 0;
                $check = 0;
                foreach($data as $key => $value){
                    $allCount++;
                    $array[$value['repairTypeId']][$value['repairState']]['count']++;
                    $array[$value['repairTypeId']][$value['repairState']]['type'] = $this->getWxState($value['repairState']);
                    $array[$value['repairTypeId']][$value['repairState']]['repairState'] = $value['repairState'];
                    if($value['repairState'] == 0){
                        $wait++;
                    }
                    if($value['repairState'] == 1){
                        $have++;
                    }
                    if($value['repairState'] == 2){
                        $haved++;
                    }
                    if($value['repairState'] == 3){
                        $check++;
                    }
                }
                $arrayRe = array();
                $i = 0;
                foreach($array as $key => $value){
                    $arrayRe[$i]['type'] = $typeRe[$key];
                    if(isset($value[0])){
                        $arrayRe[$i]['data'][0] = $array[$key][0];
                    }else{
                        $arrayRe[$i]['data'][0] = array(
                            'count' =>0,
                            'type' => $this->getWxState(0),
                            'repairState' => 0
                        );
                    }
                    if(isset($value[1])){
                        $arrayRe[$i]['data'][1] = $array[$key][1];
                    }else{
                        $arrayRe[$i]['data'][1] = array(
                            'count' =>0,
                            'type' => $this->getWxState(1),
                            'repairState' => 1
                        );
                    }
                    if(isset($value[2])){
                        $arrayRe[$i]['data'][2] = $array[$key][2];
                    }else{
                        $arrayRe[$i]['data'][2] = array(
                            'count' =>0,
                            'type' => $this->getWxState(2),
                            'repairState' => 2
                        );
                    }
                    if(isset($value[3])){
                        $arrayRe[$i]['data'][3] = $array[$key][3];
                    }else{
                        $arrayRe[$i]['data'][3] = array(
                            'count' =>0,
                            'type' => $this->getWxState(3),
                            'repairState' => 3
                        );
                    }
                    $i++;
                }
                $count = count($arrayRe);
                $arrayRe[$count]['type'] = '合计';
                $arrayRe[$count]['data'][0] =array('count' => $wait,'type' => '待维修','repairState' => 0);
                $arrayRe[$count]['data'][1] =array('count' => $have,'type' => '维修中','repairState' => 1);
                $arrayRe[$count]['data'][2] =array('count' => $haved,'type' => '已维修','repairState' => 2);
                $arrayRe[$count]['data'][3] =array('count' => $check,'type' => '已验收','repairState' => 3);
                foreach($arrayRe as $key => $value){
                    $count = 0;
                    foreach($value['data'] as $key1 => $value1){
                        $count = $count + $value1['count'];
                    }
                    $arrayRe[$key]['count'] = $count;
                }
                $this->returnJson(array('statu' =>1,'message' =>'success','data' => $arrayRe),true);
            }
            if($typeList == 2){//用户
                $wait = 0;
                $have = 0;
                $haved = 0;
                $check = 0;
                $data = M('repair_list')->field('repairTypeId,state,repairState,receiveUserId')->where(array('scId' => $scId,'applyTime' => array(array('gt',$startTime),array('lt',$endTime))))->order('applyTime desc')->select();
                $type = M('repair_type')->field('id,user')->where(array('scId' => $scId))->select();
                $typeRe = array();
                foreach($type as $key => $value){
                    $user = unserialize($value['user']);
                    foreach($user as $key1 => $value1){
                        $typeRe[$value1['id']] = $value1['name'];
                    }
                }
                $array = array();
                foreach($data as $key => $value){
                    //$array[$value['receiveUserId']][$value['repairState']]['data'][] = $value;
                    $array[$value['receiveUserId']][$value['repairState']]['count']++;
                    $array[$value['receiveUserId']][$value['repairState']]['type'] = $this->getWxState($value['repairState']);
                    $array[$value['receiveUserId']][$value['repairState']]['repairState'] = $value['repairState'];
                    if($value['repairState'] == 0){
                        $wait++;
                    }
                    if($value['repairState'] == 1){
                        $have++;
                    }
                    if($value['repairState'] == 2){
                        $haved++;
                    }
                    if($value['repairState'] == 3){
                        $check++;
                    }
                }
                $i = 0;
                foreach($array as $key => $value){
                    $arrayRe[$i]['type'] = $typeRe[$key];
                    if(isset($value[0])){
                        $arrayRe[$i]['data'][0] = $array[$key][0];
                    }else{
                        $arrayRe[$i]['data'][0] = array(
                            'count' =>0,
                            'type' => $this->getWxState(0),
                            'repairState' => 0
                        );
                    }
                    if(isset($value[1])){
                        $arrayRe[$i]['data'][1] = $array[$key][1];
                    }else{
                        $arrayRe[$i]['data'][1] = array(
                            'count' =>0,
                            'type' => $this->getWxState(1),
                            'repairState' => 1
                        );
                    }
                    if(isset($value[2])){
                        $arrayRe[$i]['data'][2] = $array[$key][2];
                    }else{
                        $arrayRe[$i]['data'][2] = array(
                            'count' =>0,
                            'type' => $this->getWxState(2),
                            'repairState' => 2
                        );
                    }
                    if(isset($value[3])){
                        $arrayRe[$i]['data'][3] = $array[$key][3];
                    }else{
                        $arrayRe[$i]['data'][3] = array(
                            'count' =>0,
                            'type' => $this->getWxState(3),
                            'repairState' => 3
                        );
                    }
                    $i++;
                }
                $count = count($arrayRe);
                $arrayRe[$count]['type'] = '合计';
                $arrayRe[$count]['data'][0] =array('count' => $wait,'type' => '待维修','repairState' => 0);
                $arrayRe[$count]['data'][1] =array('count' => $have,'type' => '维修中','repairState' => 1);
                $arrayRe[$count]['data'][2] =array('count' => $haved,'type' => '已维修','repairState' => 2);
                $arrayRe[$count]['data'][3] =array('count' => $check,'type' => '已验收','repairState' => 3);
                foreach($arrayRe as $key => $value){
                    $count = 0;
                    foreach($value['data'] as $key1 => $value1){
                        $count = $count + $value1['count'];
                    }
                    $arrayRe[$key]['count'] = $count;
                }
                $this->returnJson(array('statu' =>1,'message' =>'success','data' => $arrayRe),true);
            }
        }
    }
    private function getWxState($i){
        $array = array(
            0 => '待维修',
            1 => '维修中',
            2 => '已维修',
            3 => '已验收',
        );
        return $array[$i];
    }
    private function exportTr(){
        $tr = array(
            '0' => array(
                'en' => 'repairNumber',
                'zh' => '保修单号'
            ),
            '1' => array(
                'en' => 'repairName',
                'zh' => '报修物品'
            ),
            '2' => array(
                'en' => 'repairContent',
                'zh' => '报修内容'
            ),
            '3' => array(
                'en' => 'phone',
                'zh' => '联系方式'
            ),
            '4' => array(
                'en' => 'repairType',
                'zh' => '报修类别'
            ),
            '5' => array(
                'en' => 'repairAddress',
                'zh' => '维修地点'
            ),
            '6' => array(
                'en' => 'repairUserName',
                'zh' => '维修人员'
            ),
            '7' => array(
                'en' => 'applyTime',
                'zh' => '申请时间'
            ),
            '8' => array(
                'en' => 'reciveTime',
                'zh' => '接单时间'
            ),
            '9' => array(
                'en' => 'arriveTime',
                'zh' => '到达时间'
            ),
            '10' => array(
                'en' => 'stateName',
                'zh' => '维修状态'
            ),
            '11' => array(
                'en' => 'stateName',
                'zh' => '维修状态'
            ),
            '11' => array(
                'en' => 'repairReturnZn',
                'zh' => '维修反馈'
            )
        );
        return $tr;
    }
}