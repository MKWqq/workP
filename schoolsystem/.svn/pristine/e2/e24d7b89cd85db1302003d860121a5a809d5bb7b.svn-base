<?php
/**
 * Created by PhpStorm.
 * User: hujun
 * Date: 2017/8/3
 * Time: 11:54
 */

namespace Home\Controller;


class ProcessController extends Base
{
    private $uid;
    private $scId;

    public function __construct()
    {
        parent::__construct();
        $this->scId = $_SESSION['loginCheck']['data']['scId'];
        $this->uid = $_SESSION['loginCheck']['data']['userId'];
        /*$this->uid = 1;
        $this->scId = 2;*/
    }

    /*创建流程*/ //已测试
    public function create($kind, $step, $name, $process)
    {
        $response = array(
            'msg' => '无权限',
            'status' => 0
        );

        $auth_type = $_POST['type'];
        if ($auth_type == 'create') {
            $data = array(
                'kind' => (int)$kind,
                'name' => $name,
                'step' => (int)$step,
                'process' => $process,
                'scId' => $this->scId,
                'createTime' => time(),
                'creator' => $this->uid,
            );
            $map = array('kind' => $kind,
                'name' => $name,
                'scId' => $this->scId);
            $rs = D('Process')->where($map)->find();

            if ($rs) {
                $response['msg'] = '此流程已存在';
                $this->ajaxReturn($response);
            }
            $result = M('Process')->data($data)->add();
            if ($result) {
                $response['msg'] = '操作成功';
                $response['status'] = 1;
                $this->ajaxReturn($response);
            }
        }


        $this->ajaxReturn($response);
    }

    /*流程管理*/ //已测试
    public function manage()
    {
        //编辑流程
        $response = array(
            'msg' => '',
            'status' => 0,
            'data'=>''
        );

        $operate = $_POST['type'];
        if($operate){
            $pid = $_POST['processId']; //@todo 传过来的id可能是多选的id now是单个id
            if($pid){
                if ($operate == 'edit') {
                    $data = array(
                        'kind' => (int)$_POST['kind'],
                        'step' => (int)$_POST['step'],
                        'name' => $_POST['name'],
                        'process' => $_POST['process'],
                    );
                    $result = M('Process')->where("id={$pid}")->save($data);
                    if ($result) {
                        $response['msg'] = '编辑成功';
                        $response['status'] = 1;
                    } else {
                        $response['msg'] = '编辑出错';
                    }
                } //删除流程
                elseif ($operate == 'del') {
                    $where = array(
                        'id' => array('in', $pid),
                    );
                    $result = M('Process')->where($where)->delete();
                    if ($result) {
                        $response['msg'] = '删除成功';
                        $response['status'] = 1;
                    } else {
                        $response['msg'] = '删除出错';
                    }
                } else {
                    $response['msg'] = '没有此操作';
                }
            }
        }
        $data=D('Process')->where("scId={$this->scId}")->field('id,kind,name,step,scId')->select();
        $response['data']=$data;
        $this->ajaxReturn($response);
    }

    /*审批人列表*/ //@todo
    public  function approverLists(){

    }

}