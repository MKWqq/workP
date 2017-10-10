<?php
/**
 * Created by PhpStorm.
 * User: hujun
 * Date: 2017/8/8
 * Time: 14:19
 */

namespace Home\Controller;

use Home\Model\ProcessModel;
use Home\Common\BaseProcess;

class TeacherLeaveController extends Base
{
    protected $leave;
    protected $scId;
    protected $uid;
    protected $roleId;
    protected $user;


    public function __construct()
    {
        parent::__construct();
        $scId = $_SESSION['loginCheck']['data']['scId'];
        $uid = $_SESSION['loginCheck']['data']['userId'];
        $this->roleId = $_SESSION['loginCheck']['data']['roleId'];

/*        $scId = 2;
        $uid = 1;*/
        $this->scId = $scId;
        $this->uid = $uid;
        $this->leave = new BaseProcess($scId, $uid, 1, 'TeacherLeave');
        $this->user = D('User')->where(array('id' => $this->uid, 'scId' => $this->scId))->find();
    }

    public function getName()
    {
        $process = new ProcessModel();
        $name = $process->getName(1, $this->scId);
        $this->ajaxReturn($name);
    }

    /*新建请假*/ //已测试
    public function create()
    {
        $response = array(
            'msg' => '',
            'status' => 0
        );
        $auth_type = $_POST['type'];
        if ($auth_type == 'create') {
            $data = $_POST;
            //得到相应的流程
            $pname = $data['name'];
            $process = $this->leave->getProcess($this->leave->processType, $pname, $this->scId);
            if (!$process) {
                $response['msg'] = '请假类型不存在或者流程不存在';
                $this->ajaxReturn($response);
            }
            $aname = D('user')->where(array('id' => $this->uid, 'scId' => $this->scId))->getField('name');
            $application = array(
                'title' => $data['title'],
                'name' => $data['name'],
                'startTime' => strtotime($data['startTime']),
                'endTime' => strtotime($data['endTime']),
                'duration' => $data['duration'],
                'reason' => $data['reason'],
                'createTime' => time(),
                'proposerId' => $this->uid,
                'processId' => $process['id'],
                'proposer' => $aname,
                'scId' => $this->scId,
                'status' => 0
            );
            $result = $this->leave->create($application, false);
            if (!$result['status']) {
                $response['msg'] = $result['msg'];
                $this->ajaxReturn($response);
            }
            //存入流程设置
            $rs = $this->leave->createDetail($result, $process, $this->leave->processType, $this->scId);
            if (!$rs) {
                $response['msg'] = '保存流程失败';
                $this->ajaxReturn($response);
            }
            $response['msg'] = '申请成功';
            $response['status'] = 1;
            $this->ajaxReturn($response);
        }
        $response['msg'] = '无权限';
        $this->ajaxReturn($response);
    }

    /*请假记录*/ //已测试
    public function lists()
    {

        $response = array(
            'msg' => '',
            'status' => -1
        );

        $proposerId = $this->uid;
        $operate = $_POST['type'];
        if ($this->roleId != 'admin') {
            $ids = $this->leave->model->where(array(
                'proposerId' => $proposerId,
                'scId' => $this->scId,
                'status' => 0
            ))->field('id')->select();
            if (!empty($ids)) {
                $ids = array_map(function ($v) {
                    return (int)$v['id'];
                }, $ids);
                $rs = $this->leave->aotuOverdue($ids, 1, 'proposer', $this->scId);//将申请的过期未审批的置为过期
            }
        } else {
            $rs = $this->leave->aotuOverdue('', 1, 'admin', $this->scId);//将申请的过期未审批的置为过期
        }
        if ($rs) {
            $map['id'] = array('in', $rs);
            $this->leave->model->where($map)->data(array('status' => 2))->save();
        }


        //@todo 取消申请
        if ($operate == 'cancel') {
            $id = $_POST['id'];
            $rscancel = $this->leave->detailModel->operate($id, 1, 3, $this->scId, $this->uid, $this->user['name']);
            $rsdraw = $this->leave->model->where("id={$id}")->data(array(
                'status' => 3,
                'cancelTime' => time()
            ))->save();
            if (!is_array($rscancel) || !$rsdraw) {
                $response['msg'] = '取消失败';
                $this->ajaxReturn($response);
            }
            $response['msg'] = '取消成功';
            $response['status'] = 1;
            $this->ajaxReturn($response);
        }


        if ($this->roleId != $this::$adminRoleId) {
            $where['t.proposerId'] = $proposerId;
        }
        $where['t.scId'] = $this->scId;
        $where['pd.processType'] = $this->leave->processType;
        $where['pd.scId'] = $this->scId;

        $page = empty($_POST['page']) ? 1 : (int)$_POST['page'];
        $count = empty($_POST['count']) ? 10 : (int)$_POST['count'];
        $pre_page = ($page - 1) * $count;
        $limit_page = "$pre_page,$count";
        $total = 0;

        $stime = strtotime($_POST['startTime']);
        $etime = strtotime($_POST['endTime']) + 86399;
        if ($stime && $etime) {
            $where['t.createTime'] = array('between', array($stime, $etime));
        }

        $order = 't.createTime desc';
        $limit = $_POST['order'];
        if (!empty($limit))
            $order = 't.' . $limit;

        $key=$_POST['key'];
        if (!empty($key))
            $where['_string'] ="(title like '%{$key}%' or name like '{$key}' )";

        $data = D('TeacherLeave t')
            ->join('mks_process_detail pd ON t.id=pd.relationId', 'LEFT')
            ->where($where)->field('t.*,pd.approveId,pd.approver,pd.result,pd.opinion')
            ->order($order)
            ->limit($limit_page)
            ->select();

        if ($data) {
            $total = (int)D('TeacherLeave t')
                ->join('mks_process_detail pd ON t.id=pd.relationId', 'LEFT')
                ->where($where)->count();
            $response['total'] = $total;
            $response['maxPage'] = ceil($total / $count) > 0 ? 1 : ceil($total / $count);
            $response['data'] = $data;
            $response['status'] = 1;
        }
        $this->ajaxReturn($response);
    }

    /*请假审批*/ //已测试
    public function approve($whether)
    {
        $response = array(
            'msg' => '',
            'status' => -1,
            'data' => ''
        );
        $uid = $this->uid;
        if ($this->roleId != 'admin') {
            $rs = $this->leave->aotuOverdue($uid, 1, 'approver', $this->scId);// 将申请的过期未审批的置为过期
        } else {
            $rs = $this->leave->aotuOverdue('', 1, 'admin', $this->scId);
        }
        if ($rs) {
            $where['id'] = array('in', $rs);
            $this->leave->model->where($where)->data(array('status' => 2))->save();
        }


        // 通过或拒绝审批
        $id = $_POST['id'];
        $operate = $_POST['type'];
        $opinion = $_POST['opinion'];
        if ($id && $operate) {
            if ($operate == 'pass') {
                $operate = 1;
            } elseif ($operate == 'reject') {
                $operate = 2;
            }
            $result = $this->leave->operate($id, 1, $operate, $this->scId, $this->uid, $opinion, $this->user['name']);

            if ($result) {
                $response['msg'] = '操作成功';
                if ($result['status'] != 0)
                    $this->leave->model->where("id={$result['id']}")->data(array('status' => $result['status']))->save();
                $response['status'] = 1;
                $this->ajaxReturn($response);
            } else {
                $response['msg'] = '操作失败';
                $response['status'] = -1;
                $this->ajaxReturn($response);
            }
        }

        if ($this->roleId != $this::$adminRoleId) {
            if ($whether == 1) {
                $map = array(
                    'status' => 0,
                    'scId' => $this->scId,
                    'nextId' => $uid,
                    'processType' => 1
                );
            } elseif ($whether == 2) {
                $map = array(
                    '_string' => "FIND_IN_SET($uid,alreadyId)",
                    'scId' => $this->scId,
                    'processType' => 1
                );
            }

            $data = $this->leave->detailModel->where($map)->field('relationId')->select();
            if (empty($data)) {
                $response['data'] = '';
                $response['status'] = 1;
                $this->ajaxReturn($response);
            }
            $relationIds = array_map(function ($v) {
                return $v['relationId'];
            }, $data);


            $condition = array(
                'scId' => $this->scId,
                'id' => array('in', $relationIds),
            );
        } else {
            $condition['scId'] = $this->scId;
            $condition['status'] = $whether > 1 ? array('neq' => 0) : 0;
        }


        //搜索 //@todo
        $key = $_POST['key'];
        if ($key) {
            $condition['_string']="(title like '%{$key}%' or reason like '%{$key}%' or name like '{$key}' )";
        }
        $stime = strtotime($_POST['startTime']);
        $etime = strtotime($_POST['endTime']) + 86399;
        if ($stime && $etime) {
            $condition['createTime'] = array('between', array($stime, $etime));
        }
        $order = 'createTime desc';
        $limit = $_POST['order'];
        if (!empty($limit))
            $order = $limit;

        $page = empty($_POST['page']) ? 1 : (int)$_POST['page'];
        $count = empty($_POST['count']) ? 10 : (int)$_POST['count'];
        $pre_page = ($page - 1) * $count;
        $limit_page = "$pre_page,$count";
        $total = 0;
        $data = $this->leave->model->where($condition)->order($order)->limit($limit_page)->select();
        if ($data) {
            $total = (int)$this->leave->model->where($condition)->count();
            $response['total'] = $total;
            $response['maxPage'] = ceil($total / $count) > 0 ? 1 : ceil($total / $count);
            $response['data'] = $data;
            $response['status'] = 1;
        }
        $this->ajaxReturn($response);
    }

    /*请假统计*/
    public function statistics()
    {

        $map = array(
            'scId' => $this->scId
        );
        $page = empty($_POST['page']) ? 1 : (int)$_POST['page'];
        $count = empty($_POST['count']) ? 10 : (int)$_POST['count'];
        $pre_page = ($page - 1) * $count;
        $limit_page = "$pre_page,$count";

        $key = $_POST['key'];
        $stime = strtotime($_POST['startTime']);
        $etime = strtotime($_POST['endTime']) + 86399;
        if ($stime && $etime) {
            $map['createTime'] = array('between', array($stime, $etime));
        }

        $order = 'createTime desc';
        $limit = $_POST['order'];
        if (!empty($limit))
            $order = $limit;

        if (!empty($key)) {
            $map['_string'] ="(proposer like '%{$key}%')";
        }
        $data['data'] = $this->leave->model->where($map)->field('id,proposerId,proposer,count(id) as times,sum(duration) as totalDays')
            ->group('proposerId')->order($order)->limit($limit_page)->select();
        $total = $this->leave->model->where($map)->field('count(*)')->group('proposerId')->select();
        $total = count($total);
        $data['total'] = $total;
        $data['maxPage'] = ceil($total / $count) > 0 ? 1 : ceil($total / $count);
        $data['status'] = 1;
        $this->ajaxReturn($data);
    }

    /*请假明细*/
    public function detail()
    {
        $response = array(
            'msg' => '',
            'status' => -1,
            'data' => ''
        );
        $map = array(
            't.scId' => $this->scId,
            'pd.processType' => $this->leave->processType,
            'pd.scId'=> $this->scId
        );
        $page = empty($_POST['page']) ? 1 : (int)$_POST['page'];
        $count = empty($_POST['count']) ? 10 : (int)$_POST['count'];
        $pre_page = ($page - 1) * $count;
        $limit_page = "$pre_page,$count";

        $key = $_POST['key'];

        if (!empty($key)) {
            $map['_string'] ="(t.title like '%{$key}% or t.name like '%{$key}%' or t.reason like '%{$key}%'')";
        }
        $stime = strtotime($_POST['startTime']);
        $etime = strtotime($_POST['endTime']) + 86399;
        if ($stime && $etime) {
            $map['t.createTime'] = array('between', array($stime, $etime));
        }
        $order = 't.createTime desc';
        $limit = $_POST['order'];
        if (!empty($limit))
            $order ='t.'. $limit;

        $data=D('TeacherLeave t')
            ->join('mks_process_detail pd ON t.id=pd.relationId','LEFT')
            ->where($map)
            ->field('t.id,t.title,t.proposer,t.name,t.startTime,t.duration,t.reason,t.status,pd.approver,pd.result,pd.opinion')
            ->order($order)
            ->limit($limit_page)
            ->select();

        if ($data) {
            foreach ($data as $k=>$v){
                $data[$k]['approver']=json_decode($v['approver'],true);
                $data[$k]['result']=json_decode($v['result'],true);
                $data[$k]['opinion']=json_decode($v['opinion'],true);
            }

            $response['data']=$data;
            $total = (int)$this->leave->model->where($map)->count();
            $response['total'] = $total;
            $response['status'] = 1;
            $response['maxPage'] = ceil($total / $count) > 0 ? 1 : ceil($total / $count);
            $this->ajaxReturn($response);
        }
        $this->ajaxReturn($response);
    }

}