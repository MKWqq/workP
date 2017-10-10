<?php
/**
 * Created by PhpStorm.
 * User: hujun
 * Date: 2017/7/6
 * Time: 14:41
 */

namespace Home\Model;


use Think\Model;

class ProcessDetailModel extends Model
{
    public function createDetail($res,$process,$type,$scId)
    {
        // 保存具体流程
        $detail = array(
            'relationId' => $res['status'],
            'approveId' =>  json_encode($process['process']['approveId']),
            'limitation' => json_encode($process['process']['time']),
            'nextId' => $process['process']['approveId'][0][0],
            'currentStep'=>1,
            'processType'=>$type,
            'parentId' => 0,
            'status' => 0,
            'scId'=>$scId
        );

        // 过期时间线处理
        $limit = $process['process']['limit'][0];
        if ($limit > 1) {
            $detail['timeLine'] = 0;
        } else {
            $detail['timeLine'] = time() + $process['process']['time'][0];
        }
        $rs = $this->data($detail)->add();
        if ($rs) {
            return $rs;
        } else {
            return -1;
        }
    }


    //自动过期
    public function aotuOverdue($id, $type, $kind, $scId)
    {
        $flag = false;
        //判断是查看记录 还是审批
        if ($kind == 'proposer') {
            $where = array(
                'relationId' => array('in', $id)
            );
        } elseif ($kind == 'approver') {
            $where = array(
                'nextId' => $id
            );
        }elseif($kind=='admin'){
            $where=array();
        }

        $where['processType'] = $type;
        $where['status'] = 0;
        $where['scId'] = $scId;

        $currentTime = time();
        $update = array(
            'status' => 2
        );
        $data = $this->where($where)->select();

        if ($data) {
            foreach ($data as &$v) {
                //过期处理
                $timeLine = $v['timeLine'];
                if ($timeLine < $currentTime && $timeLine > 0) {
                    $result = $this->where("id={$v['id']}")->data($update)->save();
                    if ($result) {
                        $flag[] = $v['relationId'];
                    }
                }
            }
        }
        return $flag;
    }


    //通过或拒绝申请或取消申请
    public function operate($id, $type, $sort, $scId, $uid, $opinion,$name)
    {
        //id—>本条数据->count(result)->当前环节->step
        $flag = false;

        $detail = $this->where("relationId={$id} and scId={$scId} 
        and processType={$type}")->find();

        if ((int)$detail['nextId'] === 0) {
            return $flag;
        }

        if ((int)$detail['nextId'] != $uid) {
            return $flag;
        }

        if ((int)$detail['status'] == 2) {
            return $flag;
        }

        $approveId = json_decode($detail['approveId'], true);
        $approver = json_decode($detail['approver'], true);
        $limitation = json_decode($detail['limitation'], true);
        $result = json_decode($detail['result'], true);
        $opinions = json_decode($detail['opinion'], true);
        $approveTime = json_decode($detail['approveTime'], true);
        if (!empty($detail['alreadyId']))
            $alreadyId = explode(',', $detail['alreadyId']);
        $step = (int)$detail['currentStep'];//当前的审批的环节
        $newstep = $step;
        $timeLine = $detail['timeLine'];

        //审批通过 //已测试
        if ($sort == 1) {
            $allStep = count($approveId);
            if ($allStep == $step) {//最后一次审批
                $lastId = end($approveId[$step - 1]);
                if ((int)$detail['nextId'] == $lastId) {
                    $status = 1;
                    $nextId = 0;
                    $timeLine=0;
                }
            } else {
                $status = 0;
                $minorStep = count($approveId[$step - 1]);
                $key = array_keys($approveId[$step - 1], (int)$detail['nextId']);
                $key = $key[0] + 1;
                if ($minorStep > $key) {
                    $nextId = $approveId[$step - 1][$key];
                } else {//当前审批处于环节最后一次审批
                    $newstep = $step + 1;
                    $nextId = $approveId[$step][0];
                    $timeLine = $limitation[$step] > 0 ? time() + $limitation[$step] : null;
                }
            }
            $result[$step - 1][] = 1;
            $approver[$step - 1][] = $name;
            $opinions[$step - 1][] = $opinion;
            $approveTime[$step - 1][] = time();
            $alreadyId[] = $uid;
            $update = array(
                'status' => $status,
                'nextId' => $nextId,
                'parentId' => $uid,
                'alreadyId' => implode(',', $alreadyId),
                'currentStep' => $newstep,
                'result' => json_encode($result),
                'approver' => json_encode($approver),
                'opinion' => json_encode($opinions),
                'approveTime' => json_encode($approveTime),
                'timeLine' => $timeLine
            );
        } elseif ($sort == 2) {//审批拒绝 //已测试
            $status = -1;
            $result[$step - 1][] = $status;
            $approver[$step - 1][] = $name;
            $opinions[$step - 1][] = $opinion;
            $approveTime[$step - 1][] = time();
            $alreadyId[] = $uid;
            $update = array(
                'status' => -1,
                'nextId' => 0,//将下一审批人置为0
                'parentId' => $uid,
                'alreadyId' => implode(',', $alreadyId),
                'result' => json_encode( $result),
                'approver' => json_encode($approver),
                'opinion' => json_encode($opinions),
                'approveTime' => json_encode($approveTime),
                'timeLine' => 0
            );

        } else {//取消申请
            $status = 3;
            $update = array(
                'status' => $status,
            );
        }
        $rs = $this->where("relationId={$id} and scId={$scId} and processType={$type}")->data($update)->save();
        if ($rs) {
            if ($status != 0) {
                $flag = array();
                $flag['id'] = $id;
                $flag['status'] = $status;
            } else {
                $flag = $rs;
            }

        }
        return $flag;
    }

}