<?php
/**
 * Created by PhpStorm.
 * User: hujun
 * Date: 2017/9/15
 * Time: 9:53
 */

namespace Home\Controller;

use Home\Common\Accessory;

/*
 * 档案管理
 * */

class FileManageController extends Base
{
    protected $roleId;
    protected $scId;
    protected $uId;
    protected $user;

    public function __construct()
    {
        parent::__construct();
                $this->scId = $_SESSION['loginCheck']['data']['scId'];
                $this->uId = $_SESSION['loginCheck']['data']['userId'];
                $this->roleId = $_SESSION['loginCheck']['data']['roleId'];

     /*   $this->roleId = 22;
        $uid = 2;
        $scId = 2;*/
        $this->scId = $scId;
        $this->uId = $uid;
        $this->user = D('User')->where(array('id' => $this->uId, 'scId' => $this->scId))->find();
    }

    //公共调用接口
    public function common($func, $param = array())
    {
        switch ($func) {
            case 'getApprover':  //候选审批人
                $this->getApprover();
                break;
            case 'getOwner': //得到档案所有人
                $this->getOwner();
                break;
            case 'getTag': //得到所有标签
                $this->getTag();
                break;
            case 'getAccessory': //得到附加的信息
                $this->getAccessory($param['fileId']);
                break;
            default:
                return null;
        }
    }

    //标签设置 //已测试
    public function tagSetting()
    {
        $response = array(
            'status' => 0,
            'msg' => ''
        );

        $type = $_POST['type'];
        if (isset($type)) {
            $rs = false;
            if ($type == 'addGenre') {
                $genreName = $_POST['genreName'];
                $con = array(
                    'scId' => $this->scId,
                    'genreName' => $genreName
                );
                $rs = D('FileTag')->where($con)->find();
                if (!$rs) {
                    $genre = array(
                        'genreName' => $genreName,
                        'scId' => $this->scId,
                        'creator' => $this->user['name'],
                        'creatorId' => $this->uId,
                        'lastRecordTime' => time()
                    );
                    $rs = D('FileTag')->data($genre)->add();
                }
            } elseif ($type == 'saveGenre') {
                $id = $_POST['id'];
                $genreName = $_POST['genreName'];
                $rs = D('FileTag')->where("id={$id}")->data(array('genreName' => $genreName))->save();
            } elseif ($type == 'changeTag') {
                $tag = $_POST['tag'];
                if (count($tag) == count(array_unique($tag))) { //判断是否有重复值
                    $id = $_POST['id'];
                    $rs = D('FileTag')->where("id={$id}")->data(array('tag' => json_encode($tag)))->save();
                }
            } elseif ($type == 'delGenre') {
                $id = $_POST['id'];
                $rs = D('FileTag')->where("id={$id}")->delete();
            } else {
                $response['msg'] = '没有权限';
                $this->ajaxReturn($response);
            }
            if ($rs) {
                $response['msg'] = '操作成功';
                $response['status'] = 1;
            } else {
                $response['msg'] = '已存在';
            }
            $this->ajaxReturn($response);
        }
        $where = array(
            'scId' => $this->scId
        );

        $data = D('FileTag')->where($where)->field('id,genreName,tag')->select();
        if ($data) {
            foreach ($data as &$v) {
                $v['tag'] = json_decode($v['tag'], true);
            }
            $response['status'] = 1;
            $response['data'] = $data;
        }
        $this->ajaxReturn($response);
    }

    //得到候选审批人
    private function getApprover()
    {
        $where = array(
            'post' => array('in', array('教师', '校长', '教务处主任', '学生处主任', '副校长', '职工')),// @todo
            'scId' => $this->scId
        );
        $data = D('User')
            ->where($where)
            ->field('id,name,post,department')
            ->select();
        $approver = array();
        foreach ($data as &$v) {
            if (empty($v['department']))
                $approver[$v['post']][] = array(
                    'id' => $v['id'],
                    'name' => $v['name']
                );
            else
                $approver[$v['post']][$v['department']][] = array(
                    'id' => $v['id'],
                    'name' => $v['name']
                );
        }
        $this->ajaxReturn($approver);
    }

    //得到档案所有人
    private function getOwner()
    {
        $where = array(
            'post' => array('in', array('教师', '校长', '教务处主任', '学生处主任', '副校长', '职工')),// @todo
            'scId' => $this->scId
        );//@ todo
        $data = D('User')
            ->where($where)
            ->field('id,name,post,department')
            ->select();
        $this->ajaxReturn($data);
    }

    //得到标签
    private function getTag()
    {
        $where = array(
            'scId' => $this->scId
        );
        $data = D('FileTag')->where($where)->field('id,genreName,tag')->select();
        $response = array();
        if ($data) {
            foreach ($data as &$v) {
                $v['tag'] = json_decode($v['tag'], true);
            }
            $response = $data;
        }
        $this->ajaxReturn($response);
    }

    //得到附件
    public function getAccessory($fileId)
    {
        $data = D('FileAccessory')->where("fileId={$fileId}")->field('id as accId,accessory,accessoryName')->select();
        $response = array();
        if ($data) {
            $response = $data;
        }
        $this->ajaxReturn($response);
    }

    //档案记录
    public function fileRecord($option = '')
    {
        $response = array(
            'status' => 0,
            'msg' => ''
        );

        $type = $_POST['type'];
        if (isset($type)) {
            if ($type == 'addFile') { //新增档案 //已测试
                $data = $_POST;
                $file = array(
                    'name' => $data['name'],
                    'identity' => 'DA' . date('YmdHis', time()),
                    'ownerId' => implode(',', $data['ownerId']),
                    'owner' => implode(',', $data['owner']),
                    'tag' => implode(',',$data['tag']),
                    // 'tag' => $data['tag'], //@ todo
                    'time' => strtotime($data['time']),
                    'remark' => $data['remark'],
                    //'status' => 0,
                    'creator' => $this->user['name'],
                    'creatorId' => $this->uId,
                    'createTime' => time(),
                    'scId' => $this->scId,
                );
                $rs = D('File')->data($file)->add();
                //添加对应审批流程
                if ($rs) {
                    $newId = $rs;
                    $process = array(
                        'fileId' => $rs,
                        'status' => 0,
                        'admin' => 0
                    );
                    $rs = D('FileProcess')->data($process)->add();
                    if ($rs) {
                        //对上传附件进行处理 测试通过
                        $uploadFile = $_FILES;
                        $accessory = array();
                        $aName = array();
                        if ($uploadFile) {
                            foreach ($uploadFile as &$v) {
                                foreach ($v['name'] as &$val) {
                                    $aName[] = $val;
                                }
                            }
                            $subName = 'record';
                            $upload = new Accessory($uploadFile, $this->scId, $subName);
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
                        $time = time();
                        $uId = $this->uId;
                        $scId = $this->scId;
                        $path = $accessory['path'];
                        $val = '';
                        for ($i = 0; $i < count($path); $i++) {
                            $val .= '(' . "'{$path[$i]}'," . "'{$aName[$i]}'," . "{$scId}," . "{$time},"
                                . "{$uId}," . "{$newId}" . '),';
                        }
                        $val = rtrim($val, ',');
                        $sql = "insert into mks_file_accessory (accessory,accessoryName,scId,lastRecordTime,userId,fileId)
                          values {$val}";
                        $rs = M()->execute($sql);
                    }
                }
            } elseif ($type == 'downloadAcc') { //下载附件 //已测试
                $accId = $_POST['accId'];
                $this->operateAccessory('download', $accId, '');
            } elseif ($type == 'preview') { //@todo 预览
                $accId = $_POST['accId'];
                $response = $this->operateAccessory('preview', $accId);
            } elseif ($type == 'uploadAcc') { //上传单个附件 //已测试
                $file = $_FILES;
                $aName = array();
                foreach ($file as &$v) {
                    foreach ($v['name'] as &$val) {
                        $aName[] = $val;
                    }
                }
                $fileId = $_POST['fileId'];
                $accessory = $this->operateAccessory('upload', '', $file);
                //上传失败
                if (!$accessory['status']) {
                    $response = array(
                        'msg' => $accessory['msg'],
                        'status' => 0
                    );
                    $this->ajaxReturn($response);
                }
                // 存路径和文件名
                $new = array(
                    'accessory' => $accessory['path'][0],
                    'accessoryName' => $aName[0],
                    'scId' => $this->scId,
                    'lastRecordTime' => time(),
                    'userId' => $this->uId,
                    'fileId' => $fileId
                );
                $rs = D('FileAccessory')->data($new)->add();
            } elseif ($type == 'delAcc') { //删除单个附件 //已测试
                $accId = $_POST['accId'];
                $rs = $this->operateAccessory('del', $accId, '');
                if ($rs) {
                    $rs = D('FileAccessory')->where("id={$accId}")->delete();
                }
            } elseif ($type == 'reName') { //附件重命名 //已测试
                $accId = $_POST['accId'];
                $rs = D('FileAccessory')->where("id={$accId}")->data(array('accessoryName' => $_POST['aName']))->save();
            } elseif ($type == 'editFile') { //编辑档案 //已测试
                $fileId = $_POST['fileId'];
                $data = $_POST;
                $file = array(
                    'name' => $data['name'],
                    'ownerId' => implode(',', $data['ownerId']),
                    'owner' => implode(',', $data['owner']),
                    // 'tag' => json_encode($data['tag']),//@todo
                    'tag' => implode(',',$data['tag']),
                    'time' => strtotime($data['time']),
                    'remark' => $data['remark'],
                );
                $rs = D('File')->where("id={$fileId}")->data($file)->save();
            } elseif ($type == 'delFile') { //删除档案 //已测试
                $fileId = $_POST['fileIds'];//数组
                $where = array(
                    'id' => array('in', $fileId),
                    'scId' => $this->scId
                );
                $rs = D('File')->where($where)->delete();

                if ($rs) {
                    $rs = D('FileProcess')->where(array('fileId' => array('in', $fileId)))->delete();
                    if ($rs)
                        $accId = D('FileAccessory')->where(array('fileId' => array('in', $fileId)))->field('accessory')->select();
                    if (!empty($accId)) {
                        $path = array_map(function ($v) {
                            return $v['accessory'];
                        }, $accId);
                        $accessory = new Accessory('', $this->scId, 'record');
                        $accessory->del($path);
                        $rs = D('FileAccessory')->where(array('fileId' => array('in', $fileId)))->delete();
                    }
                }
            } else {
                $response['msg'] = '没有权限';
                $this->ajaxReturn($response);
            }
            if ($rs) {
                $response['status'] = 1;
                $response['msg'] = '操作成功';
            } else {
                $response['msg'] = '操作失败';
            }
            $this->ajaxReturn($response);
        }

        if ($option !=2) {//待处理
            $map = array(
                'f.scId' => $this->scId,
                'f.status' => array('in', array(0, 2))
            );
            if ($this->roleId != $this::$adminRoleId) {
                $map['f.creatorId'] = $this->uId;
            }

        } else {//已通过
            $map = array(
                'f.scId' => $this->scId,
                'fp.status' => 0
            );
            if ($this->roleId != $this::$adminRoleId) {
                $map['f.creatorId'] = $this->uId;
            }
            if (isset($_POST['startTime']) && isset($_POST['endTime'])) {
                $map['f.time'] = array('between', array($_POST['startTime'], $_POST['endTime']));
            }
            if (isset($_POST['inTag'])) {
                $str = implode(',', $_POST['inTag']);
                $map['_string'] = "concat(',',f.tag,',') regexp concat(',(',replace('{$str}',',','|'),'),')";
            }
        }
        $data = D('File f')
            ->join('mks_file_process fp ON f.id=fp.fileId')
            //->join('mks_file_accessory fa ON f.id=fa.fileId','LEFT')
            ->where($map)
            ->field('f.id as fileId,f.name,f.identity,f.tag,f.owner,f.time,f.remark,
             fp.situation,fp.status,fp.admin')
            ->order('f.createTime desc')
            ->select();
        if ($data) {
            foreach ($data as &$v) {
                $v['tag'] = explode(',',$v['tag']);
                $v['situation'] = json_decode($v['situation'], true);
                if($v['admin']>0){
                    $v['situation']=array($v['admin']=>$v['situation'][$v['admin']]);
                }
            }
            $response['data'] = $data;
            $response['status'] = 1;
        }
        $this->ajaxReturn($response);
    }

    /*
     * @param $type 字符 具体的操作
     * @param $id  整型 附件id
     * @param $file 文件 上传的文件
     * */
    //对单个附件进行操作 //@todo 预览
    private function operateAccessory($type, $id = '', $file = '')
    {
        $response = array();
        if ($type == 'download') { //下载
            $accessory = new Accessory($file, $this->scId, 'record');
            $info = D('FileAccessory')->where("id={$id}")->field('accessory,accessoryName')->find();
            $accessory->download(array($info['accessory']), array($info['accessoryName']), true);
            die;
        } elseif ($type == 'del') { //删除
            $accessory = new Accessory($file, $this->scId, 'record');
            $info = D('FileAccessory')->where("id={$id}")->field('accessory,accessoryName')->find();
            $response = $accessory->del($info['accessory']);
            return $response;
        } elseif ($type == 'upload') { //上传
            $accessory = new Accessory($file, $this->scId, 'record');
            $response = $accessory->upload();
            return $response;
        } elseif ($type == 'preview') {
            /*     $info = D('FileAccessory')->where("id={$id}")->field('accessory')->find();
                 $str="https://view.officeapps.live.com/op/view.aspx?src=";
                 $str.=urlencode("https://171.221.202.190:11111/api/school/Public/Uploads/".$info['accessory']);*/

        }
    }

    /*@param $uId 审批人id
     *@param $option 审批
     * */
    //对档案审批 //已测试
    private function approve($fileId, $option, $opinion = '')
    {
        $rs = false;
        $uId = $this->uId;

        $where=array(
            'fileId'=>$fileId,
            'status'=>0
        );
        if($this->roleId != $this::$adminRoleId)
            $where['_string']="FIND_IN_SET($uId,yetId)";
        $info = D('FileProcess')->where($where)->field('situation,yetId,approvedId')->find();
        if(empty($info))
            return $rs;
        $situation = json_decode($info['situation'], true);
        $yetId = empty($info['yetId'])?array():explode(',', $info['yetId']);
        $approvedId = empty($info['approvedId'])?array():explode(',', $info['approvedId']);

        if ($this->roleId != $this::$adminRoleId) {
            $admin = 0;
            $offset = 0;
            foreach ($yetId as $k => $v) {
                if ($this->uId == $v) {
                    $offset = $k;
                    break;
                }
            }
            $temp=array_splice($yetId, $offset, 1);
            $approvedId[] = $temp[0];
            $situation[$uId]['opinion'] = $opinion;
            if ($option == 'pass') {
                $situation[$uId]['result'] = '通过';
                if (count($yetId) > 0) {
                    $status = 0;
                } else {
                    $status = 1;
                }
            } else {
                $status = 2;
                $situation[$uId]['result'] = '拒绝';
            }
        } else {
            $situation[$uId] = array(
                'name' => '超级管理员',
                'opinion' => $opinion
            );
            $approvedId[] = $uId;
            $admin = $uId;
            if ($option == 'pass') {
                $status = 1;
                $situation[$uId]['result'] = '通过';
            } else {
                $status = 2;
                $situation[$uId]['result'] = '拒绝';
            }
        }
        $change = array(
            'situation' => json_encode($situation),
            'yetId' => implode(',',$yetId),
            'approvedId'=>implode(',',$approvedId),
            'admin' => $admin,
            'status' => $status
        );

        $rs = D('FileProcess')->where("fileId={$fileId}")->data($change)->save();
        return $rs;
    }

    //档案审批
    public function fileApprove($option='')
    {
        $response = array(
            'status' => 0,
            'msg' => ''
        );
        $type = $_POST['type'];
        if (isset($type)) {
            if ($type == 'addApprover') { //添加审批人 已测试
                $approver = $_POST['approver'];
                $fileId=$_POST['fileIds'];
                $situation=array();
                $yetId=array();
                foreach ($approver as $k => $v) {
                    $situation[$k] = array(
                        'name' => $v,
                        'result' => 0,
                        'opinion' => null
                    );
                    $yetId[] = $k;
                }
                $change = array(
                    'situation' =>json_encode($situation),
                    'yetId' => implode(',',$yetId)
                );
                $rs = D('FileProcess')->where(array('fileId'=>array('in',$fileId)))->data($change)->save();
            } elseif ($type == 'approve') { //审批
                $operate = $_POST['operate'];
                $opinion = $_POST['opinion'];
                $fileId = $_POST['fileId'];
                $rs = $this->approve($fileId, $operate, $opinion);
            } elseif ($type == 'downloadAcc') { //下载附件 //已测试
                $accId = $_POST['accId'];
                $this->operateAccessory('download', $accId, '');
            } elseif ($type == 'preview') { //@todo 预览
                $accId = $_POST['accId'];
                $response = $this->operateAccessory('preview', $accId);
            } elseif ($type == 'uploadAcc') { //上传单个附件 //已测试
                $file = $_FILES;
                $aName = array();
                foreach ($file as &$v) {
                    foreach ($v['name'] as &$val) {
                        $aName[] = $val;
                    }
                }
                $fileId = $_POST['fileId'];
                $accessory = $this->operateAccessory('upload', '', $file);
                //上传失败
                if (!$accessory['status']) {
                    $response = array(
                        'msg' => $accessory['msg'],
                        'status' => 0
                    );
                    $this->ajaxReturn($response);
                }
                // 存路径和文件名
                $new = array(
                    'accessory' => $accessory['path'][0],
                    'accessoryName' => $aName[0],
                    'scId' => $this->scId,
                    'lastRecordTime' => time(),
                    'userId' => $this->uId,
                    'fileId' => $fileId
                );
                $rs = D('FileAccessory')->data($new)->add();
            } elseif ($type == 'delAcc') { //删除单个附件 //已测试
                $accId = $_POST['accId'];
                $rs = $this->operateAccessory('del', $accId, '');
                if ($rs) {
                    $rs = D('FileAccessory')->where("id={$accId}")->delete();
                }
            } elseif ($type == 'reName') { //附件重命名 //已测试
                $accId = $_POST['accId'];
                $rs = D('FileAccessory')->where("id={$accId}")->data(array('accessoryName' => $_POST['aName']))->save();
            } elseif ($type == 'editFile') { //编辑档案 //已测试
                $fileId = $_POST['fileId'];
                $data = $_POST;
                $file = array(
                    'name' => $data['name'],
                    'ownerId' => implode(',', $data['ownerId']),
                    'owner' => implode(',', $data['owner']),
                    // 'tag' => json_encode($data['tag']),//@todo
                    'tag' => implode(',',$data['tag']),
                    'time' => strtotime($data['time']),
                    'remark' => $data['remark'],
                );
                $rs = D('File')->where("id={$fileId}")->data($file)->save();
            } else {
                $response['msg'] = '没有权限';
                $this->ajaxReturn($response);
            }
            if ($rs) {
                $response['status'] = 1;
                $response['msg'] = '操作成功';
            } else {
                $response['msg'] = '操作失败';
            }
            $this->ajaxReturn($response);
        }
        if ($option != 2) {//待审批
            $map = array(
                'f.scId' => $this->scId,
                'fp.status' => 0,
            );
            if ($this->roleId != $this::$adminRoleId) {
                $map['_string'] = "FIND_IN_SET({$this->uId},yetId)";
            }
        } else {//已审批
            $map = array(
                'f.scId' => $this->scId,
                'fp.status' => array('in', array(1, 2))
            );
            if ($this->roleId != $this::$adminRoleId) {
                $map['_string'] = "FIND_IN_SET($this->uId,fp.approvedId)";
            }
            if (isset($_POST['startTime']) && isset($_POST['endTime'])) {
                $map['f.time'] = array('between', array($_POST['startTime'], $_POST['endTime']));
            }
            if (isset($_POST['inTag'])) {
                $str = implode(',', $_POST['inTag']);
                $map['_string'] = "concat(',',f.tag,',') regexp concat(',(',replace('{$str}',',','|'),'),')";
            }
        }

        $data = D('File f')
            ->join('mks_file_process fp ON f.id=fp.fileId')
            ->where($map)
            ->field('f.id as fileId,f.name,f.identity,f.tag,f.owner,f.time,f.remark,
            fp.situation,fp.status,fp.admin')
            ->order('f.createTime desc')
            ->select();

        if ($data) {
            foreach ($data as &$v) {
                $v['tag'] = explode(',',$v['tag']);
                $v['situation'] = json_decode($v['situation'], true);
                if($v['admin']>0){
                    $v['situation']=array($v['admin']=>$v['situation'][$v['admin']]);
                }
            }
            $response['data'] = $data;
            $response['status'] = 1;
        }
        $this->ajaxReturn($response);

    }

    //档案统计
    public function fileStatistics()
    {
        $response = array(
            'status' => 0,
            'msg' => ''
        );
        $tag = $_POST['tag'];

        $vdoing_row = $tag[0];
        $vdoing_line = $tag[1];
        $map = array(
            'scId' => $this->scId,
        );
        $count = array();
        if (isset($_POST['startTime']) && isset($_POST['endTime']))
            $map['time'] = array('between', array($_POST['startTime'], $_POST['endTime']));
        foreach ($vdoing_row as $k => $vr) {
            foreach ($vdoing_line as &$vl) {
                $str = $vr .','.$vl;
                $map['_string'] = "concat(',',tag,',') regexp concat(',(',replace('{$str}',',','|'),'),')";
                $rs = D('File')->where($map)->count();
                if (!$rs)
                    $this->ajaxReturn($response);
                $count[$k][] = $rs;
            }
        }
        $response['status'] = 1;
        $response['data'] = $count;
        $this->ajaxReturn($response);
    }


}