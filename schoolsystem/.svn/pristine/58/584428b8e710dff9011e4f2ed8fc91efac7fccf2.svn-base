<?php
/**
 * Created by PhpStorm.
 * User: hujun
 * Date: 2017/8/3
 * Time: 10:11
 */

namespace Home\Controller;

use Think\Model;
use Home\Common\Accessory;


class NotificationController extends Base
{
    public $scId;
    public $uid;
    public $user;
    public $roleId;

    public function __construct()
    {
        parent::__construct();
        $this->scId = $_SESSION['loginCheck']['data']['scId'];
        $this->uid = $_SESSION['loginCheck']['data']['userId'];
        $this->roleId = $_SESSION['loginCheck']['data']['roleId'];
        /*
                $this->scId = 2;
                $this->uid = 1;*/
        $this->user = D('User')->where(array('id' => $this->uid, 'scId' => $this->scId))->find();
    }

    /*将通知发给用户*/ //已测试
    public function push($nid, $uids, $draft, $scId)
    {
        if (!$draft) {
            M('Notification')->where("id={$nid}")->save(array('draft' => 0, 'lastRecordTime' => time()));
            $model = M('NotificationUser');
            $data = array(
                'nid' => $nid,
                'uid' => implode(',', $uids),
                'uncheckId' => implode(',', $uids),
                'uname' => '',
                'scId' => $scId
            );
            $rs = $model->add($data);
            return $rs;
        }
        return -1;
    }

    /*查阅通知*/
    public function check($nid)
    {
        $model = M('NotificationUser');

        $model->startTrans();
        $uncheckIds = $model->where("nid={$nid}")->field('uncheckId')->find();
        $uncheckIds = explode(',', $uncheckIds['uncheckId']);
        $uncheckIds = array_merge(array_diff($uncheckIds, array($this->uid)));
        $data = array(
            'uncheckId' => implode(",", $uncheckIds),
        );
        $rs = $model->where("nid={$nid}")->data($data)->save();
        if (!$rs)
            return false;
        $model->commit();
        return true;
    }

    /*新建通知的选择人数*/
    public function getUser($which)
    {
        $users = array();
        if ($which == 1) {
            $user = D('User u')
                ->join('mks_role r ON u.roleId=r.roleId', 'LEFT')
                ->where("u.roleId=14 and u.scId={$this->scId}")
                ->field('u.id,u.name,r.roleName,r.roleNameEn')
                ->select();
            foreach ($user as &$val) {
                if (!isset($users[$val['roleNameEn']]['user']))
                    $users[$val['roleNameEn']]['user'] = array();
                $users[$val['roleNameEn']]['user'][] = $val;
            }
        } else {
            $user = D('User u')
                ->join('mks_role r ON u.roleId=r.roleId', 'LEFT')
                ->where("u.roleId=14 and u.scId={$this->scId}")
                ->field('u.id,u.name,r.roleName,r.roleNameEn')
                ->select();
            foreach ($user as &$val) {
                if (!isset($users[$val['roleNameEn']]['user']))
                    $users[$val['roleNameEn']]['user'] = array();
                $users[$val['roleNameEn']]['user'][] = $val;
            }
        }
        $this->ajaxReturn($users);
    }
    /*新建通知*/ //已测试
    public function create()
    {
        //通知存入
        $response = array(
            'msg' => '',
            'status' => 0
        );
        $type = $_POST['type'];
        if (!$type) {
            $response['msg'] = '无权限';
            $this->ajaxReturn($response);
        }
        if ($type == 'create') {
            $data = $_POST;
            if ($data) {
                $notification = array(
                    'title' => $data['title'],
                    'kind' => $data['kind'],
                    'content' => $data['content'],
                    'creatorId' => $this->uid,
                    'creator' => $this->user['name'],
                    'department' => $this->user['department'],
                    'createTime' => time(),
                    'draft' => 0,
                    'scId' => $this->scId,
                );
                //对上传附件进行处理 测试通过
                $file = $_FILES;
                $accessory = array();
                if ($file) {
                    $aName = array();
                    foreach ($file as &$v) {
                        foreach ($v['name'] as &$val) {
                            $aName[] = $val;
                        }
                    }

                    $notification['accessoryName'] = implode(',', $aName);

                    $subName = 'notification';
                    $upload = new Accessory($file, $this->scId, $subName);
                    $accessory = $upload->upload();
                    //上传失败
                    if (!$accessory['status']) {
                        $response = array(
                            'msg' => $accessory['msg'],
                            'status' => 0
                        );
                        $this->ajaxReturn($response);
                    }
                }
                //上传成功处理
                $notification['accessory'] = implode(',', $accessory['path']);

                if ($data['draft'] == 1) {
                    //是否为草稿
                    $notification['draft'] = 1;
                }

                $rs = M('Notification')->data($notification)->add();
                if (!$rs) {
                    $response['msg'] = '保存数据失败';
                    $this->ajaxReturn($response);
                }
                //将通知发给用户
                $rs = self::push($rs, $data['uids'], $data['draft'], $this->scId);
                if (!$rs) {
                    $response['msg'] = '发送通知给用户失败';
                    $this->ajaxReturn($response);
                }
                $response['msg'] = '操作成功';
                $response['status'] = 1;
            }
        }

        $this->ajaxReturn($response);
    }

    /*查看通知*/ //已测试
    public function lists()
    {
        $response = array(
            'msg' => '',
            'status' => 0,
            'data' => ''
        );

        $type = $_REQUEST['type'];
        $ids = $_POST['ids'];
        if ($type == 'del') {
            $res = self::del($ids);
            if (!$res) {
                $response['msg'] = '删除失败';
                $this->ajaxReturn($response);
            }
            $response['status'] = 1;
            $response['msg'] = '删除成功';
            $this->ajaxReturn($response);
        } elseif ($type == 'check') {
            $nid = $_POST['nid'];
            $rs = $this->check($nid);
            if (!$rs)
                $this->ajaxReturn($response);
            $response['status'] = 1;
            $response['msg'] = '成功';
            $this->ajaxReturn($response);
        } elseif ($type == 'download') {
            $nid = $_REQUEST['nid'];
            $filename = M('Notification')->where("id={$nid}")->field('accessory,accessoryName')->find();
            if ($filename) {
                $a = new Accessory('', $this->scId, 'notification');
                $filename = explode(',', $filename['accessory']);
                $aName=explode(',',$filename['accessoryName']);
                $a->download($filename,$aName);
                die;
            } else {
                $response['msg'] = '无文件';
                $this->ajaxReturn($response);
            }
        }


        $page = empty($_POST['page']) ? 1 : (int)$_POST['page'];
        $count = empty($_POST['count']) ? 10 : (int)$_POST['count'];
        $pre_page = ($page - 1) * $count;
        $limit_page = "$pre_page,$count";
        $total = 0;
        $order = $_POST['order'];
        $order1 = '';
        $order2 = '';
        if (!$order) {
            $order1 = 'n.createTime DESC';
            $order2 = 'createTime DESC';
        } else {
            foreach ($order as $k => $v) {
                if (!empty($v)) {
                    $order1 .= 'n.' . $k . ' ' . $v . ',';
                    $order1 .= $k . ' ' . $v . ',';
                }
            }
            if (!empty($order1))
                $order1 = rtrim($order1, ',');
            else
                $order1 = 'n.createTime DESC';
            if (!empty($order2))
                $order2 = rtrim($order2, ',');
            else
                $order2 = 'createTime DESC';
        }

        if ($this->roleId != 'admin') {
            $uid = $this->uid;
            $map['_string'] = "FIND_IN_SET($uid,uid)";
            $nids = M('NotificationUser')->where($map)->field('nid')->select();
            $nids = array_map(function ($v) {
                return (int)$v['nid'];
            }, $nids);
            $nids = implode(',', $nids);

            $data = '';
            if (!empty($nids)) {
                $where = '';
                $key = $_POST['key'];
                if (!empty($key))
                    $where .= " and (n.title like '%{$key}%' or n.creator like '%{$key}%' or n.department like '%{$key}%')";
                $sql = "select n.*,if(EXISTS(select nu.nid from mks_notification_user nu WHERE
              FIND_IN_SET($uid,nu.uncheckId) AND nu.nid =n.id),'未查阅','已查阅') as status 
              from mks_notification n where n.id in ({$nids})" . $where . " order by {$order1} limit {$limit_page}";
                $model = new Model();
                $data = $model->query($sql);
                foreach ($data as $k => $v) {
                    $data[$k]['accessory'] = explode(',', $v['accessory']);
                }
                //$total_sql= "select count(id) as total from mks_notification where id in ({$nids})" . $where ;
                $total = M('Notification n')->where("n.id in ({$nids})" . $where)->count();
                $total = (int)$total;
            }
            //$data  = json_encode($data,true);
            if ($data) {
                $response['total'] = $total;
                $response['maxPage'] = ceil($total / $count) > 0 ? 1 : ceil($total / $count);
                $response['data'] = $data;
                $response['status'] = 1;
            }
        } else {
            $map = array(
                'scId' => $this->scId
            );
            $key = $_POST['key'];
            if (!empty($key))
                $where['_string'] = "(title like %{$key}% or creator like %{$key}% or department like %{$key}%)";
            $data = M('Notification')->where($map)->order($order2)->limit($limit_page)->select();
            foreach ($data as $k => $v) {
                $data[$k]['accessory'] = explode(',', $v['accessoryName']);
            }
            $total = M('Notification')->where($map)->count();
            $total = (int)$total;
            if ($data) {
                $response['total'] = $total;
                $response['maxPage'] = ceil($total / $count) > 0 ? 1 : ceil($total / $count);
                $response['data'] = $data;
                $response['status'] = 1;
            }
        }
        $this->ajaxReturn($response);
    }

    /*发布记录*/
    public function log()
    {
        $response = array(
            'msg' => '',
            'status' => -1,
            'data' => ''
        );
        $ids = $_POST['ids'];
        $type = $_POST['type'];
        if ($type == 'del') {
            $result = self::del($ids);
            $response['msg'] = $result['msg'];
            if (!$result['status']) {
                $this->ajaxReturn($response);
            }
            $response['status'] = 1;
            $response['msg'] = '删除成功';
            $this->ajaxReturn($response);
        }
        $uid = $this->uid;
        $scId = $this->scId;
        $model = M();
        $where = '';
        $page = empty($_POST['page']) ? 1 : (int)$_POST['page'];
        $count = empty($_POST['count']) ? 10 : (int)$_POST['count'];
        $pre_page = ($page - 1) * $count;
        $limit_page = "$pre_page,$count";
        $total = 0;

        $order = 'n.createTime desc';
        $limit = $_POST['order'];
        if (!empty($limit))
            $order = 'n.' . $limit;

        if ($this->roleId != 'admin') {
            $data = $model->table('mks_notification n,mks_notification_user nu')->
            where("n.creatorId={$uid} and n.id=nu.nid and n.scId={$scId}" . $where)->field("n.id,n.title,n.kind,n.createTime,n.draft,
        nu.uncheckId,nu.uid")->order($order)->limit($limit_page)->select();
            $total = (int)$model->table('mks_notification n,mks_notification_user nu')->
            where("n.creatorId={$uid} and n.id=nu.nid and n.scId={$scId}" . $where)->count();
        } else {
            $data = $model->table('mks_notification n,mks_notification_user nu')->
            where("n.id=nu.nid and n.scId={$scId}" . $where)->field("n.id,n.title,n.kind,n.createTime,n.draft,
        nu.uncheckId,nu.uid")->order($order)->limit($limit_page)->select();
            $total = (int)$model->table('mks_notification n,mks_notification_user nu')->
            where("n.id=nu.nid and n.scId={$scId}" . $where)->count();
        }

        // 未查阅名单

        foreach ($data as &$v) {
            $unchecks = explode(',', $v['uncheckId']);
            $uncheck = array_map(function ($v) {
                return (int)$v;
            }, $unchecks);
            $allchecks = explode(',', $v['uid']);
            $allcheck = array_map(function ($v) {
                return (int)$v;
            }, $allchecks);
            $v['ratio'] = count($uncheck) . '/' . count($allcheck);
            if (!$uncheck) {
                continue;
            }
            if (count($uncheck) == count($allcheck))
                $list = array();
            else
                $list = $model->table('mks_user u,mks_role r')->
                where("u.id in ({$v['uncheckId']}) and u.roleId = r.roleId and u.scId=$scId")->field("u.name,u.class,u.grade,r.roleName")->select();
            $v['list'] = $list;
        }
        $response['total'] = $total;
        $response['maxPage'] = ceil($total / $count) > 0 ? 1 : ceil($total / $count);
        $response['data'] = $data;
        $response['status'] = 1;
        $this->ajaxReturn($response);
    }


    /*删除通知*/ //已测试
    function del($ids)
    {
        $map = array(
            'id' => array('in', $ids)
        );

        $paths = M('Notification')->where($map)->field('accessory')->select();
        $re = M('NotificationUser')->where(array('nid' => array('in', $ids)))->delete();
        $rs = M('Notification')->where($map)->delete();
        if (!$rs || !$re) {
            return false;
        }
        $paths = array_map(function ($v) {
            return explode(',', $v['accessory']);
        }, $paths);
        $i = 0;
        $path = array();
        foreach ($paths as $k => $t) {
            foreach ($t as &$v) {
                if (empty($v))
                    continue;
                $path[$i] = $v;
                $i++;
            }
        }
        $accessory = new Accessory('', $this->scId, 'notification');
        $accessory->del($path);
        return true;

    }

}