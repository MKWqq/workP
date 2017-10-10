<?php
/**
 * Created by PhpStorm.
 * User: hujun
 * Date: 2017/8/16
 * Time: 16:19
 */

namespace Home\Model;


use Think\Model;

class BranchProcessModel extends Model
{
    //添加流程
    //删除流程
    //创建一个分班分科方案的所有的流程
    public function addPlanProcess($planId,$scId){
        $flag=false;
        $process=array(
            array('name'=>'修改分班方案','status'=>1,'step'=>1,'url'=>'','planId'=>$planId,'scId'=>$scId),
            array('name'=>'分班学生管理','status'=>2,'step'=>2,'url'=>'','planId'=>$planId,'scId'=>$scId),
            array('name'=>'分班成绩依据','status'=>-1,'step'=>3,'url'=>'','planId'=>$planId,'scId'=>$scId),
            array('name'=>'填报志愿设置','status'=>2,'step'=>4,'url'=>'','planId'=>$planId,'scId'=>$scId),
            array('name'=>'成绩统计设置','status'=>-1,'step'=>5,'url'=>'','planId'=>$planId,'scId'=>$scId),
            array('name'=>'合成成绩统计','status'=>-1,'step'=>6,'url'=>'','planId'=>$planId,'scId'=>$scId),
            array('name'=>'学生填报志愿','status'=>0,'step'=>7,'url'=>'','planId'=>$planId,'scId'=>$scId),
            array('name'=>'学生志愿调整','status'=>-1,'step'=>8,'url'=>'','planId'=>$planId,'scId'=>$scId),
            array('name'=>'学生志愿统计','status'=>-1,'step'=>9,'url'=>'','planId'=>$planId,'scId'=>$scId),
            array('name'=>'未报志愿学生名单','status'=>-1,'step'=>10,'url'=>'','planId'=>$planId,'scId'=>$scId),
            array('name'=>'志愿确认签名单','status'=>-1,'step'=>11,'url'=>'','planId'=>$planId,'scId'=>$scId),
            array('name'=>'拟分班级设置','status'=>-1,'step'=>12,'url'=>'','planId'=>$planId,'scId'=>$scId),
            array('name'=>'指定学生到班','status'=>-1,'step'=>13,'url'=>'','planId'=>$planId,'scId'=>$scId),
            array('name'=>'快速分班','status'=>-1,'step'=>14,'url'=>'','planId'=>$planId,'scId'=>$scId),
            array('name'=>'手动调整','status'=>-1,'step'=>15,'url'=>'','planId'=>$planId,'scId'=>$scId),
            array('name'=>'打印报表','status'=>-1,'step'=>16,'url'=>'','planId'=>$planId,'scId'=>$scId),
            array('name'=>'发布分班结果','status'=>-1,'step'=>17,'url'=>'','planId'=>$planId,'scId'=>$scId),
            array('name'=>'同步分科分班数据','status'=>-1,'step'=>18,'url'=>'','planId'=>$planId,'scId'=>$scId),
        );
        $rs=$this->addAll($process);
        if($rs)
            $flag=true;
        return $flag;
    }

    //得到一个方案的所有流程情况
    public function getAllProcess($planId){
        $where=array(
            'planId'=>$planId
        );
        $data=$this->where($where)->select();
        return $data;
    }

    //得到一个具体的流程的情况
    public function  getOneProcess(){

    }


}