<?php
/**
 * Created by PhpStorm.
 * User: hujun
 * Date: 2017/9/1
 * Time: 16:31
 */

namespace Home\Model;


use Think\Model;

class EvaluateProcessModel extends Model
{
    public function addEvaluateProcess($evaluateId,$scId){
        $flag=false;
        $process=array(
            array('name'=>'修改考评方案','status'=>-1,'step'=>1,'url'=>'','evaluateId'=>$evaluateId,'scId'=>$scId),
            array('name'=>'评委分组','status'=>-1,'step'=>2,'url'=>'','evaluateId'=>$evaluateId,'scId'=>$scId),
            array('name'=>'设置考评分组','status'=>-1,'step'=>3,'url'=>'','evaluateId'=>$evaluateId,'scId'=>$scId),
            array('name'=>'添加被评人员','status'=>-1,'step'=>4,'url'=>'','evaluateId'=>$evaluateId,'scId'=>$scId),
            array('name'=>'添加评委','status'=>-1,'step'=>5,'url'=>'','evaluateId'=>$evaluateId,'scId'=>$scId),
            array('name'=>'评委打分','status'=>0,'step'=>6,'url'=>'','evaluateId'=>$evaluateId,'scId'=>$scId),
            array('name'=>'统计分析','status'=>-1,'step'=>7,'url'=>'','evaluateId'=>$evaluateId,'scId'=>$scId),
            array('name'=>'比对名单统计','status'=>3,'step'=>8,'url'=>'','evaluateId'=>$evaluateId,'scId'=>$scId),
            array('name'=>'考评进度跟踪','status'=>3,'step'=>9,'url'=>'','evaluateId'=>$evaluateId,'scId'=>$scId)
        );
        $rs=$this->addAll($process);
        if($rs)
            $flag=true;
        return $flag;
    }
}