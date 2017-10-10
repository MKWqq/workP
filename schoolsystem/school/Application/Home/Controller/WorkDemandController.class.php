<?php
/**
 * Created by PhpStorm.
 * User: hujun
 * Date: 2017/8/9
 * Time: 16:50
 */

namespace Home\Controller;
use Home\Common\BaseProcess;
use Home\Model\ProcessModel;
use Home\Common\Accessory;
class WorkDemandController extends Base
{

    protected $doc;
    protected $car;
    protected $place;
    protected $scId;
    protected $uid;
    protected $user;
    protected $roleId;

    /******************************************公文流转功能****************************************/
    public function __construct()
    {
        parent::__construct();
        $scId = $_SESSION['loginCheck']['data']['scId'];
        $uid = $_SESSION['loginCheck']['data']['userId'];
        $this->roleId=$_SESSION['loginCheck']['data']['roleId'];

  /*     $this->roleId = 22;
        $uid = 1;
        $scId = 2;*/
        $this->scId = $scId;
        $this->uid = $uid;
        $this->user = D('User')->where(array('id' => $this->uid, 'scId' => $this->scId))->find();
        $this->doc = new BaseProcess($scId, $uid, 4, 'Document');
        $this->car = new BaseProcess($scId, $uid, 2, 'CarApplication');
        $this->place = new BaseProcess($scId, $uid, 3, 'PlaceApplication');
    }

    public function getName($kind)
    { //已测试
        $process = new ProcessModel();
        $name = $process->getName($kind, $this->scId);
        $this->ajaxReturn($name);
    }

    //创建公文 //已测试
    public function createDoc()
    {
        $response = array(
            'status' => -1,
            'msg' => ''
        );
        $type = $_POST['type'];
        if (!$type || $type != 'create') {
            $response['msg'] = '没有权限创建';
            $this->ajaxReturn($response);
        } elseif ($type == 'create') {
            $data = $_POST;
            $pname = $data['name'];
            $process = $this->doc->getProcess($this->doc->processType, $pname, $this->scId);
            if (!$process) {
                $response['msg'] = '公文类型不存在';
                $this->ajaxReturn($response);
            }

            // 对上传附件进行封装处理
            $file = $_FILES;
            $upload = false;
            $aName=array();
            if ($file) {
                $aName = array();
                foreach ($file as &$v) {
                    foreach ($v['name'] as &$val) {
                        $aName[] = $val;
                    }
                }
                $subName = 'document';
                $upload = new Accessory($file, $this->scId, $subName);
            }
            $document = array(
                'creator' => $this->user['name'],
                'creatorId' => $this->uid,
                'content' => $data['content'],
                'title' => $data['title'],
                'accessoryName'=>implode(',', $aName),
                'name' => $data['name'],
                'processId' => $process['id'],
                'status' => 0,
                'createTime' => time(),
                'scId' => $this->scId,
            );
            // 保存公文
            $res = $this->doc->create($document, $upload);

            if (!$res['status']) {
                $response['msg'] = $res['msg'];
                $this->ajaxReturn($response);
            }
            //存入流程设置
            $rs = $this->doc->createDetail($res, $process, $this->doc->processType, $this->scId);
            if (!$rs) {
                $response['msg'] = '保存流程失败';
                $this->ajaxReturn($response);
            }
            $response['msg'] = '创建成功';
            $response['status'] = 1;
            $this->ajaxReturn($response);
        }
    }

    //公文流转记录 // 已测试
    public function logDoc()
    {
        $response = array(
            'status' => -1,
            'msg' => '',
            'data' => ''
        );

        $type = $_POST['type'];
        $proposerId = $this->uid;


        if ($this->roleId != $this::$adminRoleId) {
            $ids = $this->doc->model->where("creatorId={$proposerId} and scId={$this->scId}")->field('id')->select();
            if (!empty($ids)) {
                $ids = array_map(function ($v) {
                    return (int)$v['id'];
                }, $ids);
                $rs = $this->doc->aotuOverdue($ids, $this->doc->processType, 'proposer', $this->scId);//将申请的过期未审批的置为过期
            }
        } else {
            $rs = $this->doc->aotuOverdue('', $this->doc->processType, 'admin', $this->scId);// 将申请的过期未审批的置为过期
        }
        if ($rs) {
            $where = array('id' => array('in', $rs));
            $this->doc->model->where($where)->data(array('status' => 2))->save();
        }

        $docId = $_POST['id'];
        if ($type == 'edit') {//已测试
            //附加是否修改
            $file = $_FILES;
            $accessory = new Accessory($file, $this->scId, 'document');
            $doc = $this->doc->model->where("id={$docId}")->find();
            $preFile = explode(',', $doc['accessoryName']);
            if (empty($doc['accessory']))
                $preFile = array();
            //附件是否增减
            $upload = $_POST['upload'];
            $aName = $_POST['aName'];
            $nextFile = $accessory->update($preFile, $upload,$this->scId.'/document');

            if (isset($nextFile['status'])) {
                $response['msg'] = $nextFile['msg'];
                $this->ajaxReturn($response);
            }
            $newdoc = array(
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'accessory' => implode(',', $nextFile),
                'accessoryName'=>implode(',', $aName),
                'lastRecordTime' => time()
            );
            $rs = $this->doc->model->where("id={$docId}")->data($newdoc)->save();
            if (!$rs) {
                $response['mag'] = '编辑失败';
                $this->ajaxReturn($response);
            }
            $response['msg'] = '编辑成功';
            $response['status'] = 1;
            $this->ajaxReturn($response);
        } elseif ($type == 'del') {//已测试
            $detailId = $_POST['detailId'];
            $con = array('id' => array('in', $docId));
            $rs = $this->doc->model->where($con)->delete();
            $result = $this->doc->detailModel->where(array(
                    'id' => array('in', $detailId),
                    'scId' => $this->scId,
                    'processType' => $this->doc->processType
                )
            )->delete();
            if (!$rs || !$result) {
                $response['msg'] = '删除出错';
                $this->ajaxReturn($response);
            }
            $response['msg'] = '删除成功';
            $response['status'] = 1;
            $this->ajaxReturn($response);
        } elseif ($type == 'download') {
            $filename = M('Document')->where("id={$docId}")->field('accessory,accessoryName')->find();
            if ($filename) {
                $a = new Accessory('', $this->scId, 'document');
                $filename = explode(',', $filename['accessory']);
                $aName=explode(',', $filename['accessoryName']);
                $a->download($filename,$aName);
            } else {
                $response['msg'] = '无文件';
                $this->ajaxReturn($response);
            }
        }
        //得到公文记录
        $where = " doc.scId={$this->scId} ";
        $where .=" and det.processType={$this->doc->processType}";
        if ($this->roleId != 'admin') {
            $where .= " and doc.creatorId={$this->uid} ";
        }
        $startTime = strtotime($_POST['startTime']);
        $endTime = strtotime($_POST['endTime']);
        if ($startTime && $endTime) {
            $where .= " and createTime between {$startTime} and {$endTime} ";
        }
        $order = $_POST['order'];
        $page=empty($_POST['page'])?1:(int)$_POST['page'];
        $count=empty($_POST['count'])?10:(int)$_POST['count'];
        $pre_page=($page-1)*$count;
        $limit_page="$pre_page,$count";
        if (!$order) {
            $order = 'DESC';
        }
        $doc_sql = "select doc.*,det.id as detailId,det.approveId,det.approver,det.opinion,det.result 
                  from mks_document doc LEFT JOIN mks_process_detail det ON doc.id=det.relationId 
                  where" . $where . "order by doc.createTime " . $order." limit {$limit_page}";
        $model = M('');
        $docLog = $model->query($doc_sql);

        if ($docLog) {
            $total= (int)M('Document doc')->join('mks_process_detail det ON doc.id=det.relationId','LEFT')
                ->where($where)->count();
            $response['total']=$total;
            $response['maxPage']=ceil($total/$count)>0?1:ceil($total/$count);
            $response['status'] = 1;
            $response['data'] = $docLog;
        }
        $this->ajaxReturn($response);
    }

    //公文流转审批 // 已测试
    public function approveDoc($whether)
    {

        $response = array(
            'msg' => '',
            'status' => -1,
            'data' => ''
        );

        $uid = $this->uid;
        if ($this->roleId != $this::$adminRoleId) {
            $rs = $this->doc->aotuOverdue($uid, $this->doc->processType, 'approver', $this->scId);// 将申请的过期未审批的置为过期
        } else {
            $rs = $this->doc->aotuOverdue('', $this->doc->processType, 'admin', $this->scId);
        }
        if ($rs) {
            $where['id'] = array('in', $rs);
            $this->doc->model->where($where)->data(array('status' => 2))->save();
        }

        // 通过或拒绝审批
        $docId = $_POST['docId'];
        $operate = $_POST['type'];
        $opinion = $_POST['opinion'];
        if ($docId && $operate) {
            if ($operate == 'pass') {
                $operate = 1;
            } elseif ($operate == 'reject') {
                $operate = 2;
            }
            $result = $this->doc->operate($docId, $this->doc->processType, $operate, $this->scId, $this->uid, $opinion, $this->user['name']);
            if ($result) {
                $response['msg'] = '操作成功';
                if ($result['status'] != 0)
                    $this->doc->model->where("id={$result['id']}")->data(array('status' => $result['status']))->save();
                $response['status'] = 1;
                $this->ajaxReturn($response);
            } else {
                $response['msg'] = '操作失败';
                $response['status'] = -1;
                $this->ajaxReturn($response);
            }
        }


        //搜索 //@todo
        $stime = $_POST['startTime'];
        $etime = $_POST['endTime'];
        $page=empty($_POST['page'])?0:(int)$_POST['page'];
        $count=empty($_POST['count'])?10:(int)$_POST['count'];
        $pre_page=($page-1)*$count;
        $limit_page="$pre_page,$count";
        if ($this->roleId != $this::$adminRoleId) {
            if ($whether == 1) {
                $map = array(
                    'status' => 0,
                    'scId' => $this->scId,
                    'nextId' => $uid,
                    'processType' => $this->doc->processType
                );
            } elseif ($whether == 2) {
                $map = array(
                    '_string' => "FIND_IN_SET($uid,alreadyId)",
                    'scId' => $this->scId,
                    'processType' => $this->doc->processType
                );
            }

            $detailData = $this->doc->detailModel->where($map)
                ->field("id as detailId,relationId,approver,parentId,result,opinion")
                ->limit($limit_page)->select();
            if (empty($detailData)) {
                $response['data'] = '';
                $response['status'] = 1;
                $this->ajaxReturn($response);
            }
            $relationIds = array_map(function ($v) {
                return $v['relationId'];
            }, $detailData);
            $condition = array(
                'scId' => $this->scId,
                'id' => array('in', $relationIds),
            );

            if (!empty($stime) && !empty($etime)) {
                $condition['createTime'] = array('between', array($stime, $etime));
            }
            $docData = $this->doc->model->where($condition)->select();

        } //管理员
        else {
            $condition = array(
                'scId' => $this->scId
            );
            if ($whether == 1) {
                $condition['status'] = 0;
            } elseif ($whether == 2) {
                $condition['status'] = array('neq' => 0);
            }
            if (!empty($stime) && !empty($etime)) {
                $condition['createTime'] = array('between', array($stime, $etime));
            }
            $docData = $this->doc->model->where($condition)->limit($limit_page)->select();

            if (empty($docData)) {
                $response['data'] = '';
                $response['status'] = 1;
                $this->ajaxReturn($response);
            }
            $relationIds = array_map(function ($v) {
                return $v['id'];
            }, $docData);
            $map = array(
                'scId' => $this->scId,
                'relationId' => array('in', $relationIds),
                'processType' => $this->doc->processType
            );
            $detailData = $this->doc->detailModel->where($map)->field("id as detailId,relationId,approver,parentId,result,opinion")->select();
        }

        foreach ($relationIds as $k => $val) {
            $mergeData[$val] = array_map(function ($v) {
                return $v;
            }, $detailData[$k]);
        }


        foreach ($docData as $k => $v) {//将对应的审批详情合并
            if (array_key_exists($v['id'], $mergeData)) {
                $docData[$k] = array_merge($docData[$k], $mergeData[$v['id']]);
            }
            continue;
        }

        if ($docData) {
            $response['data'] = $docData;
            $response['status'] = 1;
        }
        $this->ajaxReturn($response);
    }

    /******************************************用车申请功能****************************************/
    //新建用车申请 //已测试
    public function createCar()
    {
        $response = array(
            'status' => -1,
            'msg' => ''
        );
        $type = $_POST['type'];
        if (!$type || $type != 'create') {
            $response['msg'] = '没有权限提交申请';
            $this->ajaxReturn($response);
        } elseif ($type == 'create') {
            $data = $_POST;
            $pname = $data['name'];
            $process = $this->car->getProcess($this->car->processType, $pname, $this->scId);
            if (!$process) {
                $response['msg'] = '用车申请类型不存在';
                $this->ajaxReturn($response);
            }

            $application = array(
                'title' => $data['title'],
                'name' => $data['name'],
                'carType' => $data['carType'],
                'carOwner' => $data['carOwner'],
                'users' => $data['users'],
                'destination' => $data['destination'],
                'proposer' => $this->user['name'],
                'proposerId' => $this->uid,
                'contactMan' => $data['contactMan'],
                'telephone' => $data['telephone'],
                'startTime' => strtotime($data['startTime']),
                'endTime' => strtotime($data['endTime']),
                'duration' => $data['duration'],
                'reason' => $data['reason'],
                'processId' => $process['id'],
                'status' => 0,
                'createTime' => time(),
                'scId' => $this->scId,
            );

            // 保存申请
            $res = $this->car->create($application, false);

            if (!$res['status']) {
                $response['msg'] = $res['msg'];
                $this->ajaxReturn($response);
            }
            //存入流程设置
            $rs = $this->car->createDetail($res, $process, $this->car->processType, $this->scId);
            if (!$rs) {
                $response['msg'] = '保存流程失败';
                $this->ajaxReturn($response);
            }
            $response['msg'] = '提交成功';
            $response['status'] = 1;
            $this->ajaxReturn($response);
        }
    }

    //用车申请记录 // 已测试
    public function logCar()
    {
        $response = array(
            'status' => -1,
            'msg' => '',
            'data' => ''
        );

        $type = $_POST['type'];
        $proposerId = $this->uid;

        if ($this->roleId != $this::$adminRoleId) {
            $ids = $this->car->model->where("proposerId={$proposerId} and scId={$this->scId}")->field('id')->select();
            if (!empty($ids)) {
                $ids = array_map(function ($v) {
                    return (int)$v['id'];
                }, $ids);
                $rs = $this->car->aotuOverdue($ids, $this->car->processType, 'proposer', $this->scId);//将申请的过期未审批的置为过期
            }
        } else {
            $rs = $this->car->aotuOverdue('', $this->car->processType, 'admin', $this->scId);// 将申请的过期未审批的置为过期
        }
        if ($rs) {
            $where = array('id' => array('in', $rs));
            $this->car->model->where($where)->data(array('status' => 2))->save();
        }

        $carId = $_POST['id'];
        if ($type == 'del') {//已测试
            $con=array('id'=>array('in',$carId));
            $rs = $this->car->model->where($con)->delete();
            $result = $this->car->detailModel->where(array(
                'relationId' => array('in',$carId),
                'processType' => $this->car->processType,
                'scId' => $this->scId))->delete();
            if (!$rs || !$result) {
                $response['msg'] = '删除出错';
                $this->ajaxReturn($response);
            }
            $response['msg'] = '删除成功';
            $response['status'] = 1;
            $this->ajaxReturn($response);
        }

        //得到申请记录
        $map = array(
            'scId' => $this->scId
        );
        $page=empty($_POST['page'])?1:(int)$_POST['page'];
        $count=empty($_POST['count'])?10:(int)$_POST['count'];
        $pre_page=($page-1)*$count;
        $limit_page="$pre_page,$count";
        if ($this->roleId != 'admin') {
            $map['proposerId'] = $this->uid;
        }
        $startTime = strtotime($_POST['startTime']);
        $endTime = strtotime($_POST['endTime']);

        if (!empty($startTime) && !empty($endTime)) {
            $map['createTime'] = array('between', array($startTime, $endTime));
        }

        $order = $_POST['order'];
        if (!$order) {
            $order = 'DESC';
        }
        $carLog = $this->car->model->where($map)->order("createTime {$order}")->limit($limit_page)->select();

        if ($carLog) {
            $total= (int)$this->car->model->where($map)->count();
            $response['total']=$total;
            $response['maxPage']=ceil($total/$count)>0?1:ceil($total/$count);
            $response['status'] = 1;
            $response['data'] = $carLog;
        }
        $this->ajaxReturn($response);
    }

    //用车申请审批
    public function approveCar($whether)
    {
        $response = array(
            'msg' => '',
            'status' => -1,
            'data' => ''
        );

        $uid = $this->uid;
        if ($this->roleId != $this::$adminRoleId) {
            $rs = $this->car->aotuOverdue($uid, $this->car->processType, 'approver', $this->scId);// 将申请的过期未审批的置为过期
        } else {
            $rs = $this->car->aotuOverdue('', $this->car->processType, 'admin', $this->scId);
        }
        if ($rs) {
            $where['id'] = array('in', $rs);
            $this->car->model->where($where)->data(array('status' => 2))->save();
        }

        // 通过或拒绝审批
        $carId = $_POST['carId'];
        $operate = $_POST['type'];
        $opinion = $_POST['opinion'];
        if ($carId && $operate) {
            if ($operate == 'pass') {
                $operate = 1;
            } elseif ($operate == 'reject') {
                $operate = 2;
            }
            $result = $this->car->operate($carId, $this->car->processType, $operate, $this->scId, $this->uid, $opinion, $this->user['name']);
            if ($result) {
                $response['msg'] = '操作成功';
                if ($result['status'] != 0)
                    $this->car->model->where("id={$result['id']}")->data(array('status' => $result['status']))->save();
                $response['status'] = 1;
                $this->ajaxReturn($response);
            } else {
                $response['msg'] = '操作失败';
                $response['status'] = -1;
                $this->ajaxReturn($response);
            }
        }

        $page=empty($_POST['page'])?1:(int)$_POST['page'];
        $count=empty($_POST['count'])?10:(int)$_POST['count'];
        $pre_page=($page-1)*$count;
        $limit_page="$pre_page,$count";
        //搜索 //@todo
        $stime = $_POST['startTime'];
        $etime = $_POST['endTime'];
        if ($this->roleId != $this::$adminRoleId) {
            if ($whether == 1) {
                $map = array(
                    'status' => 0,
                    'scId' => $this->scId,
                    'nextId' => $uid,
                    'processType' => $this->car->processType
                );
            } elseif ($whether == 2) {
                $map = array(
                    '_string' => "FIND_IN_SET($uid,alreadyId)",
                    'scId' => $this->scId,
                    'processType' => $this->car->processType
                );
            }

            $detailData = $this->car->detailModel->where($map)->field("id as detailId,relationId,approver,parentId,result,opinion")
                ->limit($limit_page)->select();
            if (empty($detailData)) {
                $response['data'] = '';
                $response['status'] = 1;
                $this->ajaxReturn($response);
            }
            $relationIds = array_map(function ($v) {
                return $v['relationId'];
            }, $detailData);
            $condition = array(
                'scId' => $this->scId,
                'id' => array('in', $relationIds),
            );

            if (!empty($stime) && !empty($etime)) {
                $condition['createTime'] = array('between', array($stime, $etime));
            }
            $docData = $this->car->model->where($condition)->select();

        } //管理员
        else {
            $condition = array(
                'scId' => $this->scId
            );
            if ($whether == 1) {
                $condition['status'] = 0;
            } elseif ($whether == 2) {
                $condition['status'] = array('neq' => 0);
            }
            if (!empty($stime) && !empty($etime)) {
                $condition['createTime'] = array('between', array($stime, $etime));
            }
            $docData = $this->car->model->where($condition)->limit($limit_page)->select();

            if (empty($docData)) {
                $response['data'] = '';
                $response['status'] = 1;
                $this->ajaxReturn($response);
            }
            $relationIds = array_map(function ($v) {
                return $v['id'];
            }, $docData);
            $map = array(
                'scId' => $this->scId,
                'relationId' => array('in', $relationIds),
                'processType' => $this->car->processType
            );
            $detailData = $this->car->detailModel->where($map)->field("id as detailId,relationId,approver,parentId,result,opinion")->select();
        }

        foreach ($relationIds as $k => $val) {
            $mergeData[$val] = array_map(function ($v) {
                return $v;
            }, $detailData[$k]);
        }

        foreach ($docData as $k => $v) {//将对应的审批详情合并
            if (array_key_exists($v['id'], $mergeData)) {
                $docData[$k] = array_merge($docData[$k], $mergeData[$v['id']]);
            }
            continue;
        }

        if ($docData) {
            $response['data'] = $docData;
            $response['status'] = 1;
        }
        $this->ajaxReturn($response);
    }


    /*****************************************场地申请功能*****************************************/
    //场地配置设置    //已测试
    public function placeOutfit()
    {
        $response = array(
            'msg' => '',
            'status' => -1,
            'data' => ''
        );
        $type = $_POST['type'];
        if ($type == 'create') {
            $outfit = array(
                'name' => $_POST['name'],
                'option' => implode(',', $_POST['option']),
                'scId' => $this->scId
            );
            $rs = M('PlaceOutfit')->data($outfit)->add();
            if (!$rs) {
                $response['msg'] = '添加配置错误';
                $response['status'] = -1;
                $this->ajaxReturn($response);
            }
            $response['msg'] = '添加成功';
        } elseif ($type == 'del') {
            $ids = $_POST['ids'];
            if (!empty($ids)) {
                $map = array(
                    'id' => array('in', $ids)
                );
                $rs = M('PlaceOutfit')->where($map)->delete();
                if (!$rs) {
                    $response['msg'] = '删除配置错误';
                    $response['status'] = -1;
                    $this->ajaxReturn($response);
                }
                $response['msg'] = '删除成功';
            }
        } else {
            $response['status'] = -1;
            $response['msg'] = '没有权限操作';
            $this->ajaxReturn($response);
        }
        $response['status'] = 1;
        $data = M('PlaceOutfit')->where("scId={$this->scId}")->select();
        if ($data) {
            $response['data'] = $data;
        }
        $this->ajaxReturn($response);
    }

    //场地管理 //@todo
    public function placeManage()
    {
        //@todo 文件路径
        $response = array(
            'msg' => '',
            'status' => -1,
            'data' => ''
        );
        $type = $_POST['type'];
        if ($type == 'create') {
            $data = $_POST;
            $outfit = array(
                'buildingName' => $data['buildingName'],
                'buildingNumber' => $data['buildingNumber'],
                'floor' => $data['floor'],
                'room' => $data['room'],
                'name' => $data['name'],
                'status' => (int)$data['status'],
                'scId' => $this->scId
            );
            $rs = M('Place')->data($outfit)->add();
            if (!$rs) {
                $response['msg'] = '添加场地错误';
                $response['status'] = -1;
                $this->ajaxReturn($response);
            }
            $response['msg'] = '添加成功';
            $response['status'] = 1;
            $this->ajaxReturn($response);
        } elseif ($type == 'del') {
            $ids = $_POST['ids'];
            if (!empty($ids)) {
                $map = array(
                    'id' => array('in', $ids)
                );
                $rs = M('Place')->where($map)->delete();
                if (!$rs) {
                    $response['msg'] = '删除场地错误';
                    $response['status'] = -1;
                    $this->ajaxReturn($response);
                }
                $response['msg'] = '删除成功';
                $response['status'] = 1;
                $this->ajaxReturn($response);
            }
        } else {
            $response['status'] = -1;
            $response['msg'] = '没有权限操作';
            $this->ajaxReturn($response);
        }
        $data = M('Place')->where("scId={$this->scId}")->select();
        if ($data) {
            $response['status'] = 1;
            $response['data'] = $data;
        }
        $this->ajaxReturn($response);
    }

    //场地申请 //已测试
    public function createPlace()
    {
        $response = array(
            'msg' => '',
            'status' => 0,
            'data' => ''
        );
        $type = $_POST['type'];
        if ($type == 'create') {
            $data = $_POST;
            $pname = $data['name'];
            $process = $this->doc->getProcess($this->place->processType, $pname, $this->scId);
            $occupyTime = $_POST['occupyTime'];
            $application = array(
                'placeId' => $_POST['id'],
                'title' => $_POST['title'],
                'address' => $_POST['address'],
                'name' => $_POST['name'],
                'occupyTime' => implode(',', $_POST['occupyTime']),
                'principal' => $_POST['principal'],
                'proposerId' => $this->uid,
                'proposer' => $this->user['name'],
                'telephone' => $_POST['telephone'],
                'outfit' => implode(',', $_POST['outfit']),
                'explain' => $_POST['explain'],
                'createTime' => time(),
                'processId' => $process['id'],
                'status' => 0,
                'scId' => $this->scId
            );
            $application['occupyDate'] = array();
            if (!empty($occupyTime)) {
                $temp = array();
                foreach ($occupyTime as &$v) {
                    $temp[] = strstr($v, '&', true);
                }
                $application['occupyDate'] = implode(',', $temp);
            }

            // 保存公文
            $res = $this->place->create($application, false);

            if (!$res['status']) {
                $response['msg'] = $res['msg'];
                $this->ajaxReturn($response);
            }
            //存入流程设置
            $rs = $this->place->createDetail($res, $process, $this->place->processType, $this->scId);
            if (!$rs) {
                $response['msg'] = '保存流程失败';
                $this->ajaxReturn($response);
            }
            $response['msg'] = '创建成功';
            $response['status'] = 1;
        }
        $date = strtotime($_POST['date']);
        $date = date('Y-m-d', $date);
        $time_pre = strtotime($date);

        $map = array(
            'p.status' => 1,
            'p.scId' => $this->scId,
        );
        $model = M('Place p');
        $place = $model->join("mks_place_application a ON p.id=a.placeId"/* AND
        (FIND_IN_SET('{$date}',a.occupyDate))"*/, 'LEFT')->where($map)
            ->field("p.*,group_concat(a.occupyTime) as occupyTime")->group('p.id')->select();
        foreach ($place as $k => $v) {
            if (!empty($v['occupyTime'])) {
                $temp = array();
                $h = explode(',', $v['occupyTime']);
                foreach ($h as &$val) {
                    $time_next = strtotime(strstr($val, '&', true));
                    if ($time_next >= $time_pre) {
                        $temp[] = $val;
                    }
                }
                $place[$k]['occupyTime'] = $temp;
            }
        }
        $response['data'] = $place;
        $this->ajaxReturn($response);
    }

    //场地申请记录
    public function logPlace()
    {
        $response = array(
            'status' => -1,
            'msg' => '',
            'data' => ''
        );

        $type = $_POST['type'];
        $proposerId = $this->uid;


        if ($this->roleId != $this::$adminRoleId) {
            $ids = $this->place->model->where("proposerId={$proposerId} and scId={$this->scId}")->field('id')->select();
            if (!empty($ids)) {
                $ids = array_map(function ($v) {
                    return (int)$v['id'];
                }, $ids);
                $rs = $this->place->aotuOverdue($ids, $this->place->processType, 'proposer', $this->scId);//将申请的过期未审批的置为过期
            }
        } else {
            $rs = $this->place->aotuOverdue('', $this->place->processType, 'admin', $this->scId);// 将申请的过期未审批的置为过期
        }
        if ($rs) {
            $where = array('id' => array('in', $rs));
            $this->place->model->where($where)->data(array('status' => 2))->save();
        }

        $placeIds = $_POST['ids'];
        if ($type == 'del') {//已测试
            $condition = array('id' => array('in', $placeIds));
            $rs = $this->place->model->where($condition)->delete();
            $result = $this->place->detailModel->where(array(
                'relationId' => array('in', $placeIds),
                'scId' => $this->scId,
                'processType' => $this->place->processType,
            ))->delete();
            if (!$rs || !$result) {
                $response['msg'] = '删除出错';
                $this->ajaxReturn($response);
            }
            $response['status'] = 1;
            $response['msg'] = '删除成功';
            $this->ajaxReturn($response);
        }
        //得到公文记录
        $page=empty($_POST['page'])?1:(int)$_POST['page'];
        $count=empty($_POST['count'])?10:(int)$_POST['count'];
        $pre_page=($page-1)*$count;
        $limit_page="$pre_page,$count";

        $where = array(
            'scId' => $this->scId);
        if ($this->roleId != $this::$adminRoleId) {
            $where['proposerId'] = $this->uid;
        }
        $startTime = strtotime($_POST['startTime']);
        $endTime = strtotime($_POST['endTime']);
        if ($startTime && $endTime) {
            $where['createTime'] = array('between', array($startTime, $endTime));
        }
        $order = $_POST['order'];
        if (!$order) {
            $order = 'DESC';
        }
        $placeLog = $this->place->model->where($where)->order("createTime {$order}")->limit($limit_page)->select();
        if ($placeLog) {
            $total= (int)$this->place->model->where($where)->count();
            $response['status'] = 1;
            $response['total']=$total;
            $response['maxPage']=ceil($total/$count)>0?1:ceil($total/$count);
            $response['data'] = $placeLog;
        }
        $this->ajaxReturn($response);
    }

    //场地申请审批
    public function approvePlace($whether)
    {
        $response = array(
            'msg' => '',
            'status' => -1,
            'data' => ''
        );

        $uid = $this->uid;
        if ($this->roleId != $this::$adminRoleId) {
            $rs = $this->place->aotuOverdue($uid, $this->place->processType, 'approver', $this->scId);// 将申请的过期未审批的置为过期
        } else {
            $rs = $this->place->aotuOverdue('', $this->place->processType, 'admin', $this->scId);
        }
        if ($rs) {
            $where['id'] = array('in', $rs);
            $this->place->model->where($where)->data(array('status' => 2))->save();
        }

        // 通过或拒绝审批
        $placeId = $_POST['placeId'];
        $operate = $_POST['type'];
        $opinion = $_POST['opinion'];
        if ($placeId && $operate) {
            if ($operate == 'pass') {
                $operate = 1;
            } elseif ($operate == 'reject') {
                $operate = 2;
            }
            $result = $this->place->operate($placeId, $this->place->processType,
                $operate, $this->scId, $this->uid, $opinion, $this->user['name']);
            if ($result) {
                $response['msg'] = '操作成功';
                if ($result['status'] != 0)
                    $this->place->model->where("id={$result['id']}")->data(array('status' => $result['status']))->save();
                $response['status'] = 1;
                $this->ajaxReturn($response);
            } else {
                $response['msg'] = '操作失败';
                $response['status'] = -1;
                $this->ajaxReturn($response);
            }
        }

        $page=empty($_POST['page'])?1:(int)$_POST['page'];
        $count=empty($_POST['count'])?10:(int)$_POST['count'];
        $pre_page=($page-1)*$count;
        $limit_page="$pre_page,$count";
        //搜索 //@todo
        $stime = $_POST['startTime'];
        $etime = $_POST['endTime'];
        if ($this->roleId != $this::$adminRoleId) {
            if ($whether == 1) {
                $map = array(
                    'status' => 0,
                    'scId' => $this->scId,
                    'nextId' => $uid,
                    'processType' => $this->place->processType
                );
            } elseif ($whether == 2) {
                $map = array(
                    '_string' => "FIND_IN_SET($uid,alreadyId)",
                    'scId' => $this->scId,
                    'processType' => $this->place->processType
                );
            }

            $detailData = $this->place->detailModel->where($map)
                ->field("id as detailId,relationId,approver,parentId,result,opinion")
                ->limit($limit_page)->select();
            $total=(int)$this->place->detailModel->where($map)->count();
            if (empty($detailData)) {
                $response['data'] = '';
                $response['status'] = 1;
                $this->ajaxReturn($response);
            }
            $relationIds = array_map(function ($v) {
                return $v['relationId'];
            }, $detailData);
            $condition = array(
                'scId' => $this->scId,
                'id' => array('in', $relationIds),
            );

            if (!empty($stime) && !empty($etime)) {
                $condition['createTime'] = array('between', array($stime, $etime));
            }
            $docData = $this->place->model->where($condition)->select();

        } //管理员
        else {
            $condition = array(
                'scId' => $this->scId
            );
            if ($whether == 1) {
                $condition['status'] = 0;
            } elseif ($whether == 2) {
                $condition['status'] = array('neq' => 0);
            }
            if (!empty($stime) && !empty($etime)) {
                $condition['createTime'] = array('between', array($stime, $etime));
            }
            $docData = $this->place->model->where($condition)->limit($limit_page)->select();
            $total=(int)$this->place->model->where($condition)->count();
            if (empty($docData)) {
                $response['data'] = '';
                $response['status'] = 1;
                $this->ajaxReturn($response);
            }
            $relationIds = array_map(function ($v) {
                return $v['id'];
            }, $docData);
            $map = array(
                'scId' => $this->scId,
                'relationId' => array('in', $relationIds),
                'processType' => $this->place->processType
            );
            $detailData = $this->place->detailModel->where($map)->field("id as detailId,relationId,approver,parentId,result,opinion")->select();
        }

        foreach ($relationIds as $k => $val) {
            $mergeData[$val] = array_map(function ($v) {
                return $v;
            }, $detailData[$k]);
        }

        foreach ($docData as $k => $v) {//将对应的审批详情合并
            if (array_key_exists($v['id'], $mergeData)) {
                $docData[$k] = array_merge($docData[$k], $mergeData[$v['id']]);
            }
            continue;
        }

        if ($docData) {
            $response['total']=$total;
            $response['maxPage']=ceil($total/$count)>0?1:ceil($total/$count);
            $response['data'] = $docData;
            $response['status'] = 1;
        }
        $this->ajaxReturn($response);
    }
}