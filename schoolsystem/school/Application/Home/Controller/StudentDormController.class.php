<?php
/**
 * Created by PhpStorm.
 * User: hujun
 * Date: 2017/9/26
 * Time: 9:04
 */

namespace Home\Controller;

/*
 * 学会宿舍
 * */
use Home\Common\Accessory;
use Home\Common\Import;

ob_end_clean();

class StudentDormController extends Base
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
   /*     $this->roleId = 22;
        $scId = 2;
        $uId = 1;*/
        $this->scId = $scId;
        $this->uId = $uId;
        $this->user = D('User')->where(array('id' => $this->uId, 'scId' => $this->scId))->find();
    }

    //公共调用接口
    public function common($func, $param = array())
    {
        switch ($func) {
            case 'getManager':
                $this->getManager();
                break;
            case 'getDorm':
                $this->getDorm();
                break;
            case 'getStu':
                $this->getStu();
                break;
            case 'getProcess':
                $this->getProcess($param['planId']);
                break;
            case 'getGrade':
                $this->getGrade();
                break;
            case 'getAssign':
                $this->getAssign($param['planId']);
                break;
            case 'getPlanDorm':
                $this->getPlanDorm($param['planId']);
                break;
            case 'getPlanStu':
                $this->getPlanStu($param['planId']);
                break;
            case 'getExam':
                $this->getExam();
                break;
            case 'getSelDorm':
                $this->getSelDorm($param['planId']);
                break;
            default:
                return null;
        }
    }

    //就读方式审批 //已测试
    public function attendApprove($option = 1)
    {
        $response = array(
            'status' => 0
        );
        $type = $_POST['type'];
        $ids = $_POST['ids'];
        if (isset($type)) {
            $rs = false;
            if ($type == 'inSchool') { //调整为住校
                $rs = D('StudentInfo')->where(array('id' => array('in', $ids)))->save(array('isResSchool' => '住校'));
            } elseif ($type == 'notInSchool') {//调整为走读
                $rs = D('StudentInfo')->where(array('id' => array('in', $ids)))->save(array('isResSchool' => '走读'));
            } else {
                $response['msg'] = '没有权限';
            }
            if (!$rs) {
                $response['msg'] = '操作失败';
            } else {
                $response['status'] = 1;
                $response['msg'] = '操作成功';
            }
            $this->ajaxReturn($response);
        }
        $where = array(
            'si.scId' => $this->scId
        );
        if ($option == 1) { //待审批
            $where['si.isResSchool'] = array('in', array('', '待审批'));
        } elseif ($option == 2) { //住校
            $where['si.isResSchool'] = '住校';
        } elseif ($option == 3) { //走读
            $where['si.isResSchool'] = '走读';
        }
        $data = D('StudentInfo si')
            ->join('mks_school_rollinfo sr ON si.userId=sr.userId', 'LEFT')
            ->join('mks_cen_reg_info cri ON si.userId=cri.userId', 'LEFT')
            ->where($where)
            ->field('si.id,si.name,si.sex,si.grade,si.className,si.phone,si.idCard,
            si.isResSchool,si.remark,sr.regNumber,cri.perAddress,sr.midExam,sr.admCategory')
            ->select();
        if ($data) {
            $response['status'] = 1;
            $response['data'] = $data;
        }
        $this->ajaxReturn($response);

    }

    //宿舍信息管理
    public function dormManage()
    {
        $response = array(
            'status' => ''
        );
        $type = $_POST['type'];
        if (isset($type)) {
            $rs = false;
            if ($type == 'add') { //添加
                $data = $_POST;
                $dorm = array(
                    'number' => $data['number'],
                    'name' => $data['name'],
                    'floor' => $data['floor'],
                    'dormNumber' => $data['dormNumber'],
                    'dormType' => $data['dormType'],
                    'capacity' => $data['capacity'],
                    'scId' => $this->scId,
                    'lastRecordTime' => time(),
                    'createTime' => time(),
                );
                $rs = D('Dorm')->data($dorm)->add();
            } elseif ($type == 'edit') { //编辑
                $data = $_POST;
                $dorm = array(
                    'number' => $data['number'],
                    'name' => $data['name'],
                    'floor' => $data['floor'],
                    'dormNumber' => $data['dormNumber'],
                    'dormType' => $data['dormType'],
                    'capacity' => $data['capacity'],
                    'scId' => $this->scId,
                    'lastRecordTime' => time(),
                    'createTime' => time(),
                );
                $rs = D('Dorm')->where("id={$data['id']}")->data($dorm)->save();
            } elseif ($type == 'del') { //删除
                $stuId = D('Dorm')->where(array('ids' => array('in', $_POST['ids'])))->filed('stuId')->select();
                if (!empty($stuId)) {//更新学生基本信息
                    $stuId = array_map(function ($v) {
                        return explode(',', $v['stuId']);
                    }, $stuId);
                    $change = array(
                        'dorStore' => '',
                        'dorStorey' => '',
                        'dorNumber' => ''
                    );
                    $rs = D('StudentInfo')->where(array('userId' => array('in', $stuId)))
                        ->data($change)->save();
                    if (!$rs) {
                        $response['msg'] = '清空学生信息失败';
                    }
                }
                $rs = D('Dorm')->where(array('ids' => array('in', $_POST['ids'])))->delete();
            } elseif ($type == 'import') { //批量导入
                $file = $_FILES;
                $acc = new Accessory($file, $this->scId, 'excel');
                $rs = $acc->uploadExcel();
                $filename = $rs['path'][0];
                $import = new Import();
                $rs = $import->read($filename);
                $acc->del($filename);
                $data = array_splice($rs, 1);
                $dormList = array();
                foreach ($data as &$v) {
                    $dormList[] = array(
                        'number' => $v[0],
                        'name' => $v[1],
                        'floor' => $v[2],
                        'dormNumber' => $v[3],
                        'dormType' => $v[4],
                        'capacity' => $v[5],
                        'scId' => $this->scId,
                        'lastRecordTime' => time(),
                        'createTime' => time(),
                    );
                }
                $rs = D('Dorm')->addAll($dormList);
            } else {
                $response['msg'] = '没有权限';
            }
            if ($rs) {
                $response['status'] = 1;
                $response['msg'] = '操作成功';
            }
            $this->ajaxReturn($response);
        }
        $data = D('Dorm')
            ->where(array('scId' => $this->scId))
            ->field('id,number,name,floor,dormNumber,dormName,dormType,capacity')
            ->select();
        if ($data) {
            $response['status'] = 1;
            $response['data'] = $data;
        }
        $this->ajaxReturn($data);
    }

    //(设置生活老师)得到生活老师 //已测试
    private function getManager()
    {
        $where = array(
            'post' => array('not in', array('学生', '')),
            'scId' => $this->scId
        );
        $data = D('User')->where($where)->field('id,name,post,department')->select();
        $res = array();
        foreach ($data as $v) {
            if (empty($v['department']))
                $res[$v['post']][] = array(
                    'teaId' => $v['id'],
                    'name' => $v['name']
                );
            else
                $res[$v['post']][$v['department']] = array(
                    'teaId' => $v['id'],
                    'name' => $v['name']
                );
        }
        $this->ajaxReturn($res);
    }

    //得到待选宿舍 //已测试
    private function getDorm()
    {
        $dorm = D('Dorm')->where(array('scId' => $this->scId, 'dormDean' => 0))
            ->field('id,number,name,floor,dormNumber,dormName,teaName,dormType')
            ->select();
        $res = array();
        foreach ($dorm as $k => $v) {
            $temp = $v['number'] . '(' . $v['name'] . ')';
            $res[$temp][$v['floor']][] = array(
                'dormId' => $v['id'],
                'dormNumber' => $v['dormNumber'],
                'dormName' => $v['dormName'],
                'teaName' => $v['teaName'],
                'dormType' => $v['dormType']
            );
        }
        $this->ajaxReturn($res);
    }

    //设置生活老师
    public function setManager()
    {
        $response = array(
            'status' => 0
        );

        //操作
        $type = $_POST['type'];
        if (isset($type)) {
            $rs = false;
            if ($type == 'save') {
                $setting = $_POST['setting'];
                $val = '';
                foreach ($setting as $k => $v) {
                    foreach ($setting['dormId'] as $k1 => $v1) {
                        $val .= '(' . "{$v1}," . "'{$v['teaId']}'," . "'{$v['teaName']}',"
                            . "'{$v['dormDean']}'),";
                    }
                }
                $val = rtrim($val, ',');
                $sql = "insert into mks_dorm (id,teaId,teaName,dormDean)
                          values {$val} on duplicate key update teaId=values(teaId),
                          teaName=values(teaName),dormDean=values(dormDean)";
                $rs = M()->execute($sql);
            } elseif ($type == 'del') {
                $id = $_POST['id'];
                $rs = D('Dorm')->where(array('id' => array('in', $id)))->data(array('teaId' => '', 'teaName' => ''))->save();
            } else {
                $response['msg'] = '没有权限';
                $this->ajaxReturn($response);
            }
            if ($rs) {
                $response['status'] = 1;
                $response['msg'] = '操作成功';
            }
            $this->ajaxReturn($response);
        }

        //展示
        $where = array(
            'teaId' => array('gt', 0),
            'scId' => $this->scId
        );
        $data = D('Dorm')->where($where)->field('id,name,teaId,teaName,dormDean')->select();
        if ($data) {
            $response['status'] = 1;
            $result = array();
            foreach ($data as $k => $v) {
                if ($v['dormDean'] == 1)
                    $result['宿舍主任'] = array(
                        'id' => $v['id'],
                        'teaId' => $v['teaId'],
                        'teaName' => $v['teaName']
                    );
                else {
                    if (!isset($result['生活老师'][$v['teaId']]))
                        $result['生活老师'][$v['teaId']] = array(
                            'teaId' => $v['teaId'],
                            'teaName' => $v['teaName'],
                            'dorm' => array()
                        );
                    $result['生活老师'][$v['teaId']]['dorm'][] = array(
                        'id' => $v['id'],
                        'name' => $v['name']
                    );
                }
            }
            sort($result['生活老师']);
            $response['data'] = $result;
        }
        $this->ajaxReturn($response);
    }

    //(住宿人员管理)待选学生
    private function getStu()
    {
        $data = D('StudentInfo')->where(array('scId' => $this->scId, 'isResSchool' => '住校'))
            ->field('id,userId,grade,className,name,sex,dorNumber')->select();
        $res = array();
        foreach ($data as $k => $v) {
            $res[$v['grade']][$v['className']][] = array(
                'stuId'=>$v['id'],
                'userId' => $v['userId'],
                'name' => $v['name'],
                'sex' => $v['sex'],
                'dorNumber' => $v['dorNumber']
            );
        }
        $this->ajaxReturn($res);
    }

    //住宿人员管理
    public function stuManage($option=1)
    {
        $response = array(
            'status' => 0
        );
        $type = $_POST['type'];
        if (isset($type)) {
            $rs = false;
            if ($type == 'save') {
                $id = $_POST['dormId'];
                $stuId = $_POST['stuId'];
                $stuName = $_POST['stuName'];
                $strId = explode(',', $_POST['stuId']);
                $strName = explode(',', $_POST['stuName']);
                //更新宿舍学生信息
                $map = array(
                    'scId' => $this->scId,
                    'dormDean'=>0,
                    '_string' => "concat(',',stuId,',') regexp concat(',(',replace('{$strId}',',','|'),'),')"
                );
                $modifyData = D('Dorm')->where($map)->field('id,stuId,stuName')->select();
                $val = '';
                $time = time();
                if ($modifyData) {
                    foreach ($modifyData as &$v) {
                        if ($v['id'] == $id) {
                            continue;
                        }
                        $temp_stuId = $v['stuId'];
                        $temp_stuName = $v['stuName'];
                        $diff_stuId = implode(',', array_diff($temp_stuId, $stuId));
                        $diff_stuName = implode(',', array_diff($temp_stuName, $stuName));
                        $val .= '(' . "{$v['id']}," . "'{$diff_stuId}'," . "'{$diff_stuName}'," . "{$time}),";
                    }
                }
                $val .= '(' . "{$id}," . "'{$strId}'," . "'{$strName}'," . "{$time}),";
                $val = rtrim($val, ',');
                $sql = "insert into mks_dorm (id,stuId,stuName,lastRecordTime)
                          values {$val} on duplicate key update stuId=values(stuId),
                          stuName=values(stuName),lastRecordTime=values(lastRecordTime)";
                $rs = M()->execute($sql);
                if (!$rs) {
                    $response['msg'] = '更新宿舍学生信息失败';
                }
                //更新学生基本信息
                $change = array(
                    'dorStore' => $_POST['number'],
                    'dorStorey' => $_POST['floor'],
                    'dorNumber' => $_POST['dormNumber']
                );
                $rs = D('StudentInfo')->where(array('userId' => array('in', $stuId)))
                    ->data($change)->save();
            } elseif ($type == 'clean') {
                $id = $_POST['dormId'];
                $stuId = D('Dorm')->where("id={$id}")->getFiled('stuId');
                if (!empty($stuId)) {//更新学生基本信息
                    $stuId = explode(',', $stuId);
                    $change = array(
                        'dorStore' => '',
                        'dorStorey' => '',
                        'dorNumber' => ''
                    );
                    $rs = D('StudentInfo')->where(array('userId' => array('in', $stuId)))
                        ->data($change)->save();
                    if (!$rs) {
                        $response['msg'] = '清空学生信息失败';
                    }
                }
                //更新宿舍信息
                $rs = D('Dorm')->where("id={$id}")->data(array('stuId' => '', 'stuName' => ''))->save();
            } else {
                $response['msg'] = '没有权限';
                $this->ajaxReturn($response);
            }
            if (!$rs) {
                $response['msg'] = '操作失败';
                $this->ajaxReturn($response);
            }
            $response['msg'] = '操作成功';
            $response['status'] = 1;
            $this->ajaxReturn($response);
        }
        if ($option == 1) { //住宿人员管理
            $dormId= $_POST['dormId'];
            $where = array(
                'id'=>$dormId,
                'dormDean' => 0,
                'scId' => $this->scId
            );
            $foo = D('Dorm')->where($where)->field('id as dormId,dormNumber,teaName,stuId,stuName')
                ->select();
            if (!$foo) {
                $this->ajaxReturn($response);
            }
            $data=array();
            foreach ($foo as $k=>$v) {
                $stuId = empty($v['stuId']) ? array() : explode(',', $v['stuId']);
                $stuName = empty($v['stuName']) ? array() : explode(',', $v['stuName']);
                $data[]=array(
                    'dormId'=>$v['dormId'],
                    'dormNumber'=>$v['dormNumber'],
                    'teaName'=>$v['teaName'],
                    'stu'=>array());
                foreach($stuId as $k1=>$v1){
                    $data[$k]['stu'][]=array(
                        'stuId'=>$stuId[$k1],
                        'stuName'=>$stuName[$k1]
                    );
                }
            }
        } else {//住宿人员明细
            $data = D('Dorm')->where(array('scId' => $this->scId, 'dormDean' => 0))
                ->field('id as dormId,number,name,floor,dormNumber,dormName,dormType,capacity,stuName')
                ->select();
            if (!$data) {
                $this->ajaxReturn($response);
            }
            foreach ($data as &$v) {
                $temp = empty($v['stuName']) ? array() : explode(',', $v['stuName']);
                $v['stuName'] = $temp;
                $v['real'] = count($temp);
            }
        }
        $response['status'] = 1;
        $response['data'] = $data;
        $this->ajaxReturn($data);
    }


    /*********************************************宿舍分配************************************************/
    //各流程变化
    function changeProcess(Array $process, $planId)
    {
        $steps = implode(',', array_keys($process));

        $sql = "UPDATE mks_dorm_process SET status = CASE step ";
        foreach ($process as $step => $status) {
            $sql .= sprintf("WHEN %d THEN %d ", $step, $status);
        }
        $sql .= "END WHERE step in ({$steps}) and scId={$this->scId} and planId={$planId}";

        M('')->execute($sql);
    }

    //得到流程
    private function getProcess($planId)
    {
        $where = array(
            'planId' => $planId,
            'scId' => $this->scId
        );
        $data = D('DormProcess')->where($where)->field('id,name,status')->select();
        $this->ajaxReturn($data);
    }

    //得到年级 //已测试
    private function getGrade()
    {
        $data = D('Grade')->where("scId={$this->scId}")->field('gradeid as id,name')->select();

        $this->ajaxReturn($data);
    }

    //宿舍分配方案 //已测试
    public function dormPlan()
    {
        $response = array(
            'status' => 0
        );
        $type = $_POST['type'];
        if (isset($type)) {
            $rs = false;
            if ($type == 'add') {
                $data = $_POST;
                $plan = array(
                    'name' => $data['name'],
                    'grade' => $data['grade'],
                    'notice' => $data['notice'],
                    'currentStatus' => '新创建',
                    'createTime' => time(),
                    'creator' => $this->user['name'],
                    'creatorId' => $this->uId,
                    'scId' => $this->scId
                );
                $planId = D('DormPlan')->data($plan)->add();
                if (!$planId) {
                    $response['msg'] = '添加失败';
                    $this->ajaxReturn($response);
                }
                $process = array(
                    array('name' => '设置分配人员名单', 'status' => 2, 'step' => 1, 'url' => '',
                        'planId' => $planId, 'scId' => $this->scId),
                    array('name' => '设置分配宿舍信息', 'status' => -1, 'step' => 2, 'url' => '',
                        'planId' => $planId, 'scId' => $this->scId),
                    array('name' => '指定学生到宿舍', 'status' => -1, 'step' => 3, 'url' => '',
                        'planId' => $planId, 'scId' => $this->scId),
                    array('name' => '快速分配宿舍', 'status' => -1, 'step' => 4, 'url' => '',
                        'planId' => $planId, 'scId' => $this->scId),
                    array('name' => '发布宿舍信息', 'status' => -1, 'step' => 5, 'url' => '',
                        'planId' => $planId, 'scId' => $this->scId),
                    array('name' => '手动调整', 'status' => -1, 'step' => 6, 'url' => '',
                        'planId' => $planId, 'scId' => $this->scId),
                    array('name' => '打印报表', 'status' => -1, 'step' => 7, 'url' => '',
                        'planId' => $planId, 'scId' => $this->scId));
                $rs = D('DormProcess')->addAll($process);
                if (!$rs) {
                    $response['msg'] = '添加流程失败';
                    $this->ajaxReturn($response);
                }
                $stu = $this->getList();
                $list = array();
                foreach ($stu as $k => $v) {
                    $list[] = array(
                        'stuId' => $v['stuId'],
                        'userId' => $v['userId'],
                        'stuName' => $v['name'],
                        'planId' => $planId,
                        'scId' => $this->scId,
                        'isAssign' => 0,
                        'sex' => $v['sex'],
                        'grade' => $v['grade'],
                        'class' => $v['className'],
                        'phone' => $v['phone'],
                        'idCard' => $v['idCard'],
                        'remark' => $v['remark'],
                        'regNumber' => $v['regNumber'],
                        'perAddress' => $v['perAddress'],
                        'midExam' => $v['midExam'],
                        'admCategory' => $v['admCategory']
                    );
                }
                $rs = D('DormAssign')->addAll($list);
                if (!$rs) {
                    $response['msg'] = '添加分配人员失败';
                    $this->ajaxReturn($response);
                }
                $rs = D('DormMap')->data(array('planId' => $planId, 'scId' => $this->scId))->add();
            } elseif ($type == 'del') {
                $planId=$_POST['planId'];
                $rs = D('DormPlan')->where("id={$planId}")->delete();
            } elseif ($type == 'clean') { //清空人员
                $planId=$_POST['planId'];
                $rs = D('DormMap')->where("id={$planId}")->save(array(
                    'assignId'=>''
                    ));
            } elseif ($type == 'edit') { //编辑
                $data = $_POST;
                $plan = array(
                    'name' => $data['name'],
                    'grade' => $data['grade'],
                    'notice' => $data['notice'],
                    'lastRecordTime' => time());
                $rs = D('DormPlan')->where("id={$_POST['id']}")->data($plan)->save();
            } else {
                $response['msg'] = '没有权限';
                $this->ajaxReturn($response);
            }
            if (!$rs) {
                $response['msg'] = '操作失败';
                $this->ajaxReturn($response);
            }
            $response['status'] = 1;
            $response['msg'] = '操作成功';
            $this->ajaxReturn($response);
        }
        $data = D('DormPlan p')
            ->join('mks_dorm_map m ON p.id=m.planId','LEFT')
            ->where(array('p.scId' => $this->scId))
            ->field('p.id,p.name,p.grade,p.createTime,p.notice,p.currentStatus,m.assignId,m.dormId')
            ->select();
        if (!$data) {
            $this->ajaxReturn($response);
        }
        foreach ($data as &$v){
            $v['stuNumber']=empty($v['assignId'])?0:count(explode(',',$v['assignId']));
            $v['dormNumber']=empty($v['dormId'])?0:count(explode(',',$v['dormId']));
            unset($v['assignId']);
            unset($v['dormId']);
        }
        $response['data'] = $data;
        $response['status'] = 1;
        $this->ajaxReturn($response);
    }


    private function getList()
    {
        $where = array(
            'si.scId' => $this->scId,
        );
        $where['si.isResSchool'] = '住校';
        $data = D('StudentInfo si')
            ->join('mks_school_rollinfo sr ON si.userId=sr.userId', 'LEFT')
            ->join('mks_cen_reg_info cri ON si.userId=cri.userId', 'LEFT')
            ->where($where)
            ->field('si.id as stuId,si.userId,si.name,si.sex,si.grade,si.className,si.phone,si.idCard,
            si.isResSchool,si.remark,sr.regNumber,cri.perAddress,sr.midExam,sr.admCategory')
            ->select();
        $response = array();
        if ($data) {
            $response = $data;
        }
        return $response;
        //  $this->ajaxReturn($response);
    }

    //(设置分配人员名单)候选名单 //已测试
    private function getAssign($planId)
    {
        $where = array(
            'planId' => $planId,
            'scId' => $this->scId
        );
        $response = array();
        $data = D('DormAssign')->where($where)
            ->field('id,stuName,sex,grade,class,phone,idCard,remark,regNumber,perAddress,midExam,admCategory')
            ->select();
        if (!$data) {
            $this->ajaxReturn($response);
        }
        $response = $data;
        $this->ajaxReturn($response);
    }

    //设置分配人员名单 //已测试
    public function assignList($planId)
    {
        $response['status'] = 0;
        $type = $_POST['type'];
        if (isset($type)) {
            $rs = false;
            if ($type == 'operate') {
                $assignId = $_POST['assignId'];
                $assignId = empty($assignId) ? '' : implode(',', $assignId);
                $rs = D('DormMap')->where(array('planId' => $planId, 'scId' => $this->scId))
                    ->data(array('assignId' => $assignId))->save();
                $process = array(
                    1 => 1, 2 => 2
                );
                $this->changeProcess($process, $planId);
                D('DormPlan')->where(array('id'=>$planId))->data(array('currentStatus'=>'设置分配人员名单'))->save();
            } else {
                $response['msg'] = '没有权限';
                $this->ajaxReturn($response);
            }
            if (!$rs) {
                $response['msg'] = '操作失败';
            } else {
                $response['status'] = 1;
                $response['msg'] = '操作成功';
            }
            $this->ajaxReturn($response);
        }

        $data = array();
        $assignId=D('DormMap')->where(array('planId' => $planId, 'scId' => $this->scId))->getField('assignId');
        if(!empty($assignId)){
            $assignId=explode(',',$assignId);
            $data = D('DormAssign')->where(array('planId' => $planId, 'scId' => $this->scId,'id'=>array('in',$assignId)))
                ->field('id,stuName,sex,grade,class,phone,idCard,remark,regNumber,perAddress,midExam,admCategory')->select();
        }
        if ($data) {
            $response['status'] = 1;
            $response['data'] = $data;
        }
        $this->ajaxReturn($response);
    }

    //设置宿舍分配信息 //已测试
    public function assignDorm($planId)
    {
        $response['status'] = 0;
        $type = $_POST['type'];
        if (isset($type)) {
            $rs = false;
            if ($type == 'operate') {
                $dormId = $_POST['dormId'];
                $dormId = empty($dormId) ? '' : implode(',', $dormId);
                $rs = D('DormMap')->where(array('planId' => $planId, 'scId' => $this->scId))
                    ->data(array('dormId' => $dormId))->save();
                $process = array(
                    2 => 1, 3 => 3, 4 => 2
                );
                $this->changeProcess($process, $planId);
                D('DormPlan')->where(array('id'=>$planId))->data(array('currentStatus'=>'设置分配宿舍信息'))->save();
            } else {
                $response['msg'] = '没有权限';
                $this->ajaxReturn($response);
            }
            if (!$rs) {
                $response['msg'] = '操作失败';
            } else {
                $response['status'] = 1;
                $response['msg'] = '操作成功';
            }
            $this->ajaxReturn($response);
        }

        $dormId = D('DormMap')->where(array('planId' => $planId, 'scId' => $this->scId))->getField('dormId');
        $data=array();
        if (!empty($dormId)) {
            $dormId = explode(',', $dormId);
            $where = array(
                'scId' => $this->scId,
                'id' => array('in', $dormId),
            );
            $data = D('Dorm')
                ->where($where)
                ->field('id,number,name,floor,dormNumber,dormName,dormType,capacity,stuId')
                ->select();
            if ($data) {
                foreach ($data as &$v) {
                    $temp = empty($v['stuId']) ? array() : explode(',', $v['stuId']);
                    $v['stuId'] = count($temp);
                }
            }
        }
        $response['status'] = 1;
        $response['data'] = $data;
        $this->ajaxReturn($response);
    }

    //(指定学生到宿舍)宿舍列表 //已测试
    private function getPlanDorm($planId)
    {
        $dormId = D('DormMap')->where("planId={$planId} and scId={$this->scId}")
            ->getField('dormId');
        $res = array();
        if (!empty($dormId)) {
            $dormId = explode(',', $dormId);
            $dorm = D('Dorm')
                ->where(array('id' => array('in', $dormId)))
                ->field('id,number,name,floor,dormNumber,dormType,capacity')->select();
            foreach ($dorm as $k => $v) {
                $temp = $v['number'] . '(' . $v['name'] . ')';
                $res[$temp][$v['floor']][] = array(
                    'dormId' => $v['id'],
                    'dormNumber' => $v['dormNumber'],
                    'dormName' => $v['dormName'],
                    'teaName' => $v['teaName'],
                    'dormType' => $v['dormType']
                );
            }
        }
        $this->ajaxReturn($res);
    }

    //(指定学生到宿舍)候选名单 //已测试
    private function getPlanStu($planId)
    {
        $where = array(
            'planId' => $planId,
            'scId' => $this->scId
        );
        $response = array();
        $data = D('DormAssign')->where($where)
            ->field('stuId,grade,class,stuName,sex')
            ->select();
        if (!$data) {
            $this->ajaxReturn($response);
        }
        $res = array();
        foreach ($data as $k => $v) {
            $res[$v['grade']][$v['class']][] = array(
                'stuId'=>$v['stuId'],
                'name' => $v['stuName'],
                'sex' => $v['sex'],
            );
        }
        $response = $res;
        $this->ajaxReturn($response);
    }

    //指定学生到宿舍 //已测试
    public function assignStu($planId,$dormId)
    {
        $response['status'] = 0;
        $type = $_POST['type'];
        if (isset($type)) {
            $rs = false;
            if ($type == 'save') {
                $stuId = $_POST['stuId'];
                //$dormId = $_POST['dormId'];
                $change = array(
                    'dormId' => $dormId,
                    'isAssign' => 1
                );
                $rs = D('DormAssign')
                    ->where(array('scId' => $this->scId, 'planId' => $planId, 'stuId' => array('in', $stuId)))
                    ->save($change);
            } elseif ($type == 'clean') {
                //$dormId = $_POST['dormId'];
                $rs = D('DormAssign')
                    ->where(array('scId' => $this->scId, 'planId' => $planId, 'dormId' => $dormId))
                    ->data(array('dormId' => '', 'isAssign' => 0))
                    ->save();
            } else {
                $response['msg'] = '没有权限';
                $this->ajaxReturn($response);
            }
            if (!$rs) {
                $response['msg'] = '操作失败';
            } else {
                $response['status'] = 1;
                $response['msg'] = '操作成功';
            }
            $this->ajaxReturn($response);
        }

        //$dormId = $_POST['dormId'];
        $data = D('DormAssign')
            ->where(array('dormId' => $dormId, 'planId' => $planId, 'scId' => $this->scId))
            ->field('id,stuId,stuName')->select();
        $response['data'] = array();
        if ($data) {
            $response['status'] = 1;
            $response['data'] = $data;
        }
        $this->ajaxReturn($response);
    }

    //(快速分配宿舍)生成分配 //已测试
    /*云青青兮欲雨,水澹澹兮生烟*/
    public function distribute($planId, $scoreOrder, $examId = '', $classOrder, $rule = '')
    {
        $data = D('DormMap')->where("planId={$planId} and scId={$this->scId}")->find();
        if (empty($data['assignId']) || empty($data['dormId']))
            return false;
        $assignId = explode(',', $data['assignId']); //学生id
        $dormId = explode(',', $data['dormId']); //宿舍id
        //分配的所有人员 $stu
        $stu = D('DormAssign')->where(array('id' => array('in', $assignId), 'isAssign' => 0))
            ->field('id,userId,sex,class,grade,midExam as score')->select();
        $totalStu = count($stu);
        //分配的所有宿舍 $dormList
        $tempList = D('Dorm')->where(array('id' => array('in', $dormId),'dormDean'=>0))->field('id,capacity')->select();
        $tempDormId = D('DormAssign')
            ->where(array('dormId' => array('in', $dormId), 'planId' => $planId, 'isAssign' => 1))
            ->field('dormId')->select();
        $tempDormId = array_map(function ($v) {
            return $v['dormId'];
        }, $tempDormId);
        $dormList = array();
        foreach ($tempList as $k => $v) { //将宿舍转为键值对
            $dormList[$v['id']] = array(
                'capacity' => (int)$v['capacity'],
                'stuId' => array()
            );
        }
        $tempId = array_keys($dormList);
        foreach ($tempDormId as $k => $v) { //将指定了宿舍容量排除  //已测试
            if (in_array($v['dormId'], $tempId)) {
                $dormList[$v['dormId']]['capacity'] -= 1;
            }
        }

        if ($scoreOrder != 'random') { //成绩规则随机
            if (!empty($examId)) {  //调用考试
                if ($examId > 0) {//不是中考分数
                    $userId = array_map(function ($v) {
                        return (int)$v['userId'];
                    }, $stu);
                    //  $order='score '.$scoreOrder;
                    $temp_exam = D('ExaminationResults')//考试成绩
                    ->where(array('userid' => array('in', $userId), 'scId' => $this->scId, 'examinationid' => $examId))
                        ->group('userid')
                        // ->order($order)
                        ->field('userid as userId,sum(results) as score')->select();
                    foreach ($temp_exam as $k => $v) {
                        $exam[$v['userId']] = $v['score'];
                    }
                    foreach ($stu as $k1=>$v1) {  //将成绩赋值
                        $stu[$k1]['score'] = empty($exam[$v1['userId']]) ? 0 : $exam[$v1['userId']];
                    }
                }
                if ($scoreOrder == 'asc') {
                    usort($stu, function ($a, $b) {
                        $al = (int)$a['score'];
                        $bl = (int)$b['score'];
                        if ($al == $bl)
                            return 0;
                        return ($al < $bl) ? -1 : 1; //升序
                    });
                } elseif ($scoreOrder == 'desc') {
                    usort($stu, function ($a, $b) {
                        $al = (int)$a['score'];
                        $bl = (int)$b['score'];
                        if ($al == $bl)
                            return 0;
                        return ($al > $bl) ? -1 : 1; //降序
                    });
                }
            }
        }

        //班级规则
        $stuList = array(); //将男女分开后的人员  //已测试
        if ($classOrder != 'random') { //将人员放在不同班级并排序
            foreach ($stu as $k => $v) {  //将性别分开
                $stuList[$v['sex']][$v['grade'] . $v['class']][] = array(
                    'id' => $v['id'],
                    'class' => $v['class'],
                    'score' => $v['score']
                );
            }
            if ($classOrder == 'desc') { //班级降序
                krsort($stuList['男']);
                krsort($stuList['女']);
            } else { //班级升序
                ksort($stuList['男']);
                ksort($stuList['女']);
            }
        } else { //将人员放在同一个班级
            foreach ($stu as $k => $v) {  //将性别分开
                $stuList[$v['sex']][0][] = array(
                    'id' => $v['id'],
                    'class' => $v['class'],
                    'score' => $v['score']
                );
            }
        }

        //将宿舍分配给人员 $dormList stuList
        if (!empty($rule)) { //班级规则分配
            if ($rule != 'remnant') {
                foreach ($stuList as $sex => $class) {
                    foreach ($class as $k => $v) {
                        $total = count($stuList[$sex][$k]); //性别分类下的每个班级的人数
                        foreach ($dormList as $k1 => $v1) {
                            if ($total <= 0)
                                break;
                            //有剩余人数
                            $capacity = (int)$v1['capacity']; //宿舍容纳人数
                            if (count($v1['stuId']) == 0) { //宿舍为空宿舍 不做判断

                            } else { //宿舍不为空 判断性别 判断班级
                                if(count($v1['stuId'])>=$capacity){ //宿舍满员 跳出
                                    continue;
                                }
                                if ($rule == 'notCross') { //班级不交叉 性别不同 班级不同
                                    continue;
                                } elseif ($rule == 'continue') { //班级连续 判断性别
                                    if ($v1['sex'] == $sex) { //性别相同
                                        $capacity = $capacity - count($v1['stuId']);//宿舍剩余人数
                                    }else{ // 性别不同 跳出
                                        continue;
                                    }
                                } else {
                                    return false;
                                }
                            }
                            $total -= $capacity; //分配人数
                            if ($total >= 0) { //学生人数>宿舍人数
                                $temp = array_splice($stuList[$sex][$k], 0, $capacity);
                            } else {
                                $temp = array_splice($stuList[$sex][$k], 0);
                            }
                            //var_dump($temp);
                            foreach ($temp as $k2 => $v2) { //将学生分配给宿舍
                                array_push($dormList[$k1]['stuId'], $v2['id']);
                            }
                            $dormList[$k1]['sex'] = $sex;
                            if ($total <= 0) { //学生分完
                                break;
                            }
                        }
                    }
                }
            } else { //班级剩余成员统一另外分
                foreach ($stuList as $sex => $class) {
                    $remnant = array();
                    foreach ($class as $k => $v) {
                        $total = count($stuList[$sex][$k]); //性别分类下的每个班级的人数
                        foreach ($dormList as $k1 => $v1) {
                            if ($total <= 0)
                                break;
                            //有剩余人数
                            $capacity = (int)$v1['capacity']; //宿舍人数
                            if ($total < $capacity) { //人数为剩余
                                foreach ($stuList[$sex][$k] as $k3 => $v3) {
                                    array_push($remnant[$sex], $v3['id']);
                                }
                                break;
                            }
                            if (count($v1['stuId']) == 0) { //宿舍为空宿舍 不做判断

                            } else { //宿舍不为空 不做判断
                                continue;
                            }
                            $total -= $capacity; //分配人数
                            $temp = array_splice($stuList[$sex][$k], 0, $capacity);

                            foreach ($temp as $k2 => $v2) { //将学生分配给宿舍
                                array_push($dormList[$k1]['stuId'], $v2['id']);
                            }
                            $dormList[$k1]['sex'] = $sex;
                            if ($total <= 0) { //学生分完
                                break;
                            }
                        }
                    }

                    $total_remnant = count($remnant[$sex]);
                    if($total_remnant>0){
                        foreach ($dormList as $k1=>$v1){
                            if ($total_remnant <= 0)
                                break;
                            //有剩余人数
                            $capacity = (int)$v1['capacity']; //宿舍人数
                            if (count($v1['stuId']) == 0) { //宿舍为空宿舍 不做判断

                            } else { //宿舍不为空 不做判断
                                continue;
                            }
                            $total_remnant -= $capacity; //分配人数
                            if ($total_remnant >= 0) { //学生人数>宿舍人数
                                $temp = array_splice($remnant[$sex], 0, $capacity);
                            } else {
                                $temp = array_splice($remnant[$sex], 0);
                            }
                            foreach ($temp as $k2 => $v2) { //将学生分配给宿舍
                                array_push($dormList[$k1]['stuId'], $v2['id']);
                            }
                            $dormList[$k1]['sex'] = $sex;
                            if ($total_remnant <= 0) { //学生分完
                                break;
                            }
                        }
                    }
                }
            }

        } else { //班级规则随机  //已测试
            foreach ($stuList as $sex => $class) {
                foreach ($class as $k => $v) {
                    $total = count($stuList[$sex][$k]); //性别分类下的人数
                    foreach ($dormList as $k1 => $v1) {
                        //有剩余人数
                        if ($total <= 0)
                            break;
                        $capacity = (int)$v1['capacity']; //宿舍人数
                        if (count($v1['stuId']) == 0) { //宿舍为空宿舍
                            $total -= $capacity; //分配人数
                            if ($total >= 0) { //学生人数>宿舍人数
                                $temp = array_splice($stuList[$sex][$k], 0, $capacity);
                            } else {
                                $temp = array_splice($stuList[$sex][$k], 0);
                            }
                            foreach ($temp as $k2 => $v2) { //将学生分配给宿舍
                                array_push($dormList[$k1]['stuId'], $v2['id']);
                            }
                            if ($total <= 0) { //学生分完
                                break;
                            }
                        } else { //宿舍不为空 判断性别 性别不同
                            continue;
                        }
                    }
                }
            }
        }
        return $dormList;
    }

    //(快速分配宿舍)考试列表 //已测试
    private function getExam(){
        $where=array(
            'scId'=>$this->scId
        );
        $data=D('Examination')
            ->where($where)
            ->field('examinationid as examId,examination')->select();
        $response=array();
        if($data){
           $response=$data;
        }
        $this->ajaxReturn($response);
    }

    //快速分配宿舍 //已测试
    public function quickAssign($planId)
    {
        $response=array('status'=>0);
        $type=$_POST['type'];
        if(isset($type)){
            if($type=='quickAssign'){
                $scoreOrder=$_POST['scoreOrder'];
                $examId=$_POST['examId'];
                $classOrder=$_POST['classOrder'];
                $rule=$_POST['rule'];
                $res=$this->distribute($planId,$scoreOrder,$examId,$classOrder,$rule);

                if(!$res){
                    $response['msg']='分配出错';
                    $this->ajaxReturn($response);
                }
                $dormId=array();
                $assignId=array();
                foreach ($res as $k=>$v){
                    $dormId[]=$k;
                    foreach ($v['stuId'] as $k1=>$v1){
                        $assignId[$v1]=$k;
                    }
                }
                $temp_dorm=D('Dorm')->where(array('id'=>array('in',$dormId),'dormDean'=>0))
                    ->field('id,teaName,number,name,floor,dormNumber')->select();
                $dorm=array();
                foreach ($temp_dorm as $k=>$v){
                    $dorm[$v['id']]=$v;
                }
                $assign=D('DormAssign')->where("planId={$planId} and scId={$this->scId}")
                    ->field('id,dormId,stuName,isAssign,sex,grade,class,phone,idCard,perAddress')->select();
                foreach ($assign as &$v){
                    if(!empty($v['isAssign']))
                        $tId=$v['dormId'];
                    else{
                        $tId=$assignId[$v['id']];
                        $v['dormId']=$tId;
                    }
                    $v['teaName']=$dorm[$tId]['teaName'];
                    $v['number']=$dorm[$tId]['number'];
                    $v['name']=$dorm[$tId]['name'];
                    $v['floor']=$dorm[$tId]['floor'];
                    $v['dormNumber']=$dorm[$tId]['dormNumber'];
                }
                $this->ajaxReturn($assign);
            }elseif($type=='save'){
                $assign=$_POST['assign'];
                $val = '';
                foreach ($assign as $k => $v) {
                        $val .= '(' . "{$v['id']}," . "{$v['dormId']},". "{$v['isAssign']}),";
                }
                $val = rtrim($val, ',');
                $sql = "insert into mks_dorm_assign (id,dormId,isAssign)
                          values {$val} on duplicate key update dormId=values(dormId),
                          isAssign=values(isAssign)";
                $rs = M()->execute($sql);
                $response['msg']='操作失败';
                if($rs){
                    $process=array(
                        4=>1,5=>2,6=>3,7=>3
                    );
                    $this->changeProcess($process,$planId);
                    D('DormPlan')->where(array('id'=>$planId))->data(array('currentStatus'=>'快速分配宿舍'))->save();
                    $response['status']=1;
                    $response['msg']='操作成功';
                }
                $this->ajaxReturn($response);
            }
            else{
                $response['msg']='没有权限';
                $this->ajaxReturn($response);
            }
        }

        $map=array(
            'da.dormId'=>array('neq',''),
            'da.planId'=>$planId
        );

        $data=D('DormAssign da')
            ->join('mks_dorm d ON da.dormId=d.id','LEFT')
            ->where($map)
            ->field('da.id,da.dormId,da.stuName,da.isAssign,da.sex,da.grade,da.class,da.phone,da.idCard,da.perAddress,
            d.teaName,d.number,d.name,d.floor,d.dormNumber')
            ->select();
        if($data){
            $response['status']=1;
            $response['data']=$data;
        }
        $this->ajaxReturn($response);
    }

    //发布宿舍信息 //已测试
    public function publish($planId){
        $data = D('DormMap')->where("planId={$planId} and scId={$this->scId}")->find();
        if (empty($data['assignId']) || empty($data['dormId']))
            return false;
        $assignId = explode(',', $data['assignId']); //学生id
        $dormId = explode(',', $data['dormId']); //宿舍id
        $temp_dorm=D('Dorm')->where(array('id'=>array('in',$dormId),'dormDean'=>0))
            ->field('id,teaName,number,name,floor,dormNumber,stuId,stuName')->select();
        $dorm=array();
        $oldId=array();
        foreach ($temp_dorm as $k=>$v){
            $dorm[$v['id']]=$v;
            $temp=empty($v['stuId'])?array():explode(',',$v['stuId']);
            $oldId=array_merge($oldId,array_values($temp));
        }
        $temp_assign=D('DormAssign')->where(array('id'=>array('in',$assignId),'planId'=>$planId))
            ->field('id,stuId,dormId,stuName')->select();
        $assign=array();
        $newId=array();
        $map=array();
        foreach ($temp_assign as $k=>$v){
            if(!empty($v['dormId'])){
                $assign[$v['dormId']]['stuId'][]=$v['stuId'];
                $assign[$v['dormId']]['stuName'][]=$v['stuName'];
            }
            $newId[]=$v['stuId'];
            $map[$v['stuId']]=$v['dormId'];
        }
        //更新宿舍信息
        $dormVal='';
        foreach ($assign as $k => $v) {
            $stuId=implode(',',$v['stuId']);
            $stuName=implode(',',$v['stuName']);
            $dormVal .= '(' . "{$k}," . "'{$stuId}'," . "'{$stuName}'),";
            }
        $dormVal = rtrim($dormVal, ',');
        $sql = "insert into mks_dorm (id,stuId,stuName)
                          values {$dormVal} on duplicate key update stuId=values(stuId),
                          stuName=values(stuName)";
        $rs = M()->execute($sql);
        //更新学生信息
        if($rs){
            $stuVal='';
            $change=array_diff($oldId,$newId);
            foreach ($change as $k => $v) { //原来的清空
                $stuVal .= '(' . "{$v}," . "''," . "'',". "''),";
            }
            foreach ($newId as $k=>$v){
                $dorStore=$dorm[$map[$v]]['number'];
                $dorStorey=$dorm[$map[$v]]['floor'];
                $dorNumber=$dorm[$map[$v]]['dormNumber'];
                $stuVal .= '(' . "{$v}," . "'{$dorStore}'," . "'{$dorStorey}',". "'{$dorNumber}'),";
            }
            $stuVal = rtrim($stuVal, ',');
            $sql = "insert into mks_student_info (id,dorStore,dorStorey,dorNumber)
                          values {$stuVal} on duplicate key update dorStore=values(dorStore),
                          dorStorey=values(dorStorey),dorNumber=values(dorNumber)";

            $rs = M()->execute($sql);
            if($rs)
            D('DormPlan')->where(array('id'=>$planId))->data(array('currentStatus'=>'发布宿舍信息'))->save();
        }
        $response['msg']='成功';
        if(!$rs){
            $response['msg']='失败';
        }
        $this->ajaxReturn($response);
    }

    //(手动调整)宿舍信息列表
    private function getSelDorm($planId){
        $dormId = D('DormMap')->where("planId={$planId} and scId={$this->scId}")
            ->getField('dormId');
        $res = array();
        if (!empty($dormId)) {
            $dormId = explode(',', $dormId);
            $rs = D('Dorm')
                ->where(array('id' => array('in', $dormId),'dormDean'=>0))
                ->field('id,number,dormType')->select();
            if($rs){
                foreach ($rs as $k=>$v){
                    $res[$v['dormType']][]=$v['number'];
                }
            }
        }
        $this->ajaxReturn($res);
    }

    //手动调整
    public function manualAdjust($planId){
        $response=array(
            'status'=>0
        );
        $type=$_POST['type'];
        if($type=='add'){
            $assignId=$_POST['assignId']; //数组
            $dormId=(int)$_POST['dormId'];
            $rs=D('DormAssign')->where(array('planId'=>$planId,'id'=>array('in',$assignId)))
                ->data(array('dormId'=>$dormId))->save();
            if(!$rs){
                $response['msg']='调整失败';
                $this->ajaxReturn($response);
            }
            $response['msg']='调整成功';
            $this->ajaxReturn($response);
        }

        $dormType=$_POST['dormType'];
        $number=$_POST['number'];
        //$where['planId']=$planId;
        if(!empty($dormType)){
            $where['d.dormType']=$dormType;
        }
        if(!empty($number)){
            $where['d.number']=$number;
        }

        $dormId = D('DormMap')->where("planId={$planId} and scId={$this->scId}")
            ->getField('dormId');
        $dormId=explode(',',$dormId);
        $where['d.id']=array('in',$dormId);
        $where['a.planId']=$planId;
        $result=D('Dorm d')
            ->join('mks_dorm_assign a ON d.id=a.dormId','RIGHT')
            ->where($where)
            ->field('d.id as dormId,d.number,d.name,d.floor,d.dormNumber,d.dormType,d.capacity,
            a.id as assignId,a.stuName,a.isAssign,a.sex,a.grade,a.class,a.remark')
            ->select();
        $rs=array();
        foreach ($result as $k=>$v){
            $rs[$v['dormId']][]=$v;
        }
        $response['stu']=$rs;
        //待调整学生名单
        $bar=D('DormAssign')->where(array('planId'=>$planId,'dormId'=>null))
            ->field('id as assignId,stuName,isAssign,sex,grade,class,remark')
            ->select();
        $wStu=array();
        if($bar){
            $wStu=$bar;
        }
        $response['status']=1;
        $response['wStu']=$wStu;
        $this->ajaxReturn($response);
    }

    //打印报表
    public function reportForm($option,$planId){
        if($option==1){//粘贴总名单
            $result=D('DormAssign a')
                ->join('mks_dorm d ON d.id=a.dormId','LEFT')
                ->where(array('a.planId'=>$planId,'a.scId'=>$this->scId))
                ->field('d.number,d.name,d.floor,d.dormNumber,d.dormType,
            a.id as assignId,a.stuName,a.isAssign,a.sex,a.grade,a.class')
                ->select();
            $this->ajaxReturn($result);
        }elseif ($option==2){//宿舍分配总名单
            $result=D('DormAssign a')
                ->join('mks_dorm d ON d.id=a.dormId','LEFT')
                ->where(array('a.planId'=>$planId,'a.scId'=>$this->scId))
                ->field('d.number,d.name,d.floor,d.dormNumber,d.dormType,
            a.id as assignId,a.stuName,a.isAssign,a.sex,a.grade,a.class,a.phone,a.regNumber,
            a.perAddress,a.admCategory')
                ->select();
            $this->ajaxReturn($result);
        }elseif ($option==3){//各宿舍学生名单
            $dormId = D('DormMap')->where("planId={$planId} and scId={$this->scId}")
                ->getField('dormId');
            $where['d.id']=array('in',$dormId);
            $where['a.planId']=$planId;
            $result=D('Dorm d')
                ->join('mks_dorm_assign a ON d.id=a.dormId','RIGHT')
                ->where($where)
                ->field('d.id,d.number,d.name,d.floor,d.dormNumber,d.dormType,d.capacity, 
                d.teaName,a.stuName,a.sex,a.grade,a.class,a.remark')
                ->select();
            $rs=array();
            if($result){
                foreach ($result as $k=>$v){
                    if(!$rs[$v['teaName']][$v['id']]){
                        $rs[$v['teaName']][$v['id']]=array(
                            'number'=>$v['number'],
                            'name'=>$v['name'],
                            'floor'=>$v['floor'],
                            'dormNumber'=>$v['dormNumber'],
                            'dormType'=>$v['dormType'],
                            'capacity'=>$v['capacity'],
                            'stu'=>array()
                        );
                    }
                    $rs[$v['teaName']][$v['id']]['stu'][]=array(
                        'stuName'=>$v['stuName'],
                        'sex'=>$v['sex'],
                        'grade'=>$v['grade'],
                        'class'=>$v['class'],
                        'remark'=>$v['remark'],
                    );
                }
            }
            $this->ajaxReturn($rs);
        }

    }

    public function test(){
        $a=array(array(
            'id'=>143,
            'dormId'=>2,
            'isAssign'=>0,
        ),array(
            'id'=>145,
            'dormId'=>7,
            'isAssign'=>0,
        ),array(
            'id'=>146,
            'dormId'=>9,
            'isAssign'=>0
        ),array(
                'id'=>147,
            'dormId'=>7,
            'isAssign'=>0
        ),array('id'=>148,
            'dormId'=>6,
            'isAssign'=>0,
        ),array(
            'id'=>149,
            'dormId'=>5,
            'isAssign'=>0,
        ),array(
            'id'=>150,
            'dormId'=>8,
            'isAssign'=>0
        ),array(
            'id'=>182,
            'dormId'=>3,
            'isAssign'=>0
        ));
        var_dump(json_encode($a));
        die;
    }
}