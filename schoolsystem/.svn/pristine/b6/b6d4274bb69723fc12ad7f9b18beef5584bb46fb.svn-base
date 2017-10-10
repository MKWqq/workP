<?php
/**
 * author:hujun
 * Date: 2017/8/01
 * Time: 9:51
 */

namespace Home\Common;
use Home\Common\Accessory;
/*
 * $processType
 * 1 教师请假 2 用车申请 3 场地申请 4 公文管理 5 订餐申请
 * */

class BaseProcess
{
    protected $scId;
    protected $creator;
    public $processType;
    public  $detailModel;
    public $model;

    public function __construct($scId,$creator,$processType,$model)
    {
        $this->scId=$scId;
        $this->creator=$creator;
        $this->processType=$processType;
        $this->detailModel=D('ProcessDetail');
        $this->processModel=D('Process');
        $this->model=D($model);
    }

    public function create($data,Accessory $object)
    {
        if($object) {
            $accessory = $object->upload();
            if(!$accessory['status']){
                return $accessory;}
            else{
                $data['accessory'] = implode(',', $accessory['path']);
            }
        }
        $rs=$this->model->add($data);
        $res['status']=$rs;
        if(!$rs)
            $res['msg']='保存申请失败';
        return $res;
    }

    public function createDetail($res,$process,$type,$scId)
    {
        $rs = $this->detailModel->createDetail($res,$process,$type,$scId);
        return $rs;
    }

    //自动过期
    public function aotuOverdue($id,$type ,$kind,$scId)
    {
        $flag=$this->detailModel->aotuOverdue($id,$type,$kind,$scId);
        return $flag;
    }


    //通过或拒绝申请或取消申请
    public function operate($id,$type,$sort,$scId,$uid,$opinion='',$name)
    {
        $rs=$this->detailModel->operate($id,$type,$sort,$scId,$uid,$opinion,$name);
        return $rs;
    }

    //将流程的环节以数组格式返回
    public function getProcess($ptype,$pname,$scId)
    {
        $rs=$this->processModel->getProcess($ptype,$pname,$scId);
        return $rs;
    }

    //得到具体的审批情况
    public function getDetail($id,$scId,$type){
        $rs=$this->detailModel->getDetail($id,$scId,$type);
        return $rs;
    }
}