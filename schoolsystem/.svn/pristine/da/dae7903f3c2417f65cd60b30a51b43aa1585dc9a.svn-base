<?php
/**
 * Created by PhpStorm.
 * User: hujun
 * Date: 2017/9/1
 * Time: 14:23
 */

namespace Home\Controller;


use Home\Model\EvaluateProcessModel;

ob_end_clean();

//教师考评功能
class TeacherEvaluateController extends Base
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
     /*   $this->roleId = 22;
        $scId = 2;
        $uid = 1;*/
        $this->scId = $scId;
        $this->uid = $uid;
        $this->user = D('User')->where(array('id' => $this->uid, 'scId' => $this->scId))->find();
    }

    /*************************************管理员操作*******************************************/
    //各流程变化 //已测试
    function changeProcess(Array $process, $evaluateId)
    {
        $steps = implode(',', array_keys($process));

        $sql = "UPDATE mks_evaluate_process SET status = CASE step ";
        foreach ($process as $step => $status) {
            $sql .= sprintf("WHEN %d THEN %d ", $step, $status);
        }
        $sql .= "END WHERE step in ({$steps}) and scId={$this->scId} and evaluateId={$evaluateId}";

        M('')->execute($sql);
    }

    //创建考评方案    //已测试
    public function createEvaluate()
    {
        $response = array(
            'status' => 0,
            'msg' => ''
        );
        $type = $_POST['type'];
        if (!isset($type)) {
            $response['msg'] = '没有权限创建';
            $this->ajaxReturn($response);
        } else {
            if ($type == 'create') {
                $data = $_POST;
                $evaluate = array(
                    'name' => $data['name'],
                    'startTime' => strtotime($data['startTime']),
                    'endTime' => strtotime($data['endTime']),
                    'creator' => $this->user['name'],
                    'creatorId' => $this->uid,
                    'publish' => 0,
                    'createTime' => time(),
                    'scId' => $this->scId,
                );
                // 保存方案
                $rsId = D('EvaluateTeacher')->data($evaluate)->add();
                if (!$rsId) {
                    $response['msg'] = '保存方案失败';
                    $this->ajaxReturn($response);
                }
                $ep = new EvaluateProcessModel();
                //存入流程设置
                $rs = $ep->addEvaluateProcess($rsId, $this->scId);
                if (!$rs) {
                    $response['msg'] = '保存流程失败';
                    $this->ajaxReturn($response);
                }
                $response['msg'] = '创建成功';
                $response['status'] = 1;
                $process = array(
                    1 => 1, 2 => 2
                );
                $this->changeProcess($process, $rsId);
            } else {
                $response['msg'] = '没有权限创建';
            }
            $this->ajaxReturn($response);
        }
    }

    //得到所有考评    //已测试
    public function getAllEvaluate()
    {
        $evaluate = D('EvaluateTeacher')
            ->where("creatorId={$this->uid}")
            ->field('id,name,startTime,endTime')
            ->select();
        $this->ajaxReturn($evaluate);
    }

    //考评管理  //已测试
    public function manageEvaluate($id)
    {
        $response = array(
            'msg' => '',
            'status' => 0,
            'data' => ''
        );
        $process = D('EvaluateProcess')
            ->where("evaluateId={$id} and scId={$this->scId}")
            ->field('id,name,status,url')
            ->select();
        if ($process) {
            $response['data'] = $process;
            $response['status'] = 1;
        }
        $this->ajaxReturn($response);
    }

    //修改考评方案    //已测试
    public function changeEvaluate($id)
    {
        $response = array(
            'msg' => '',
            'status' => 0,
            'data' => ''
        );
        $type = $_POST['type'];
        if (!isset($type)) {
            $evaluate = D('EvaluateTeacher')
                ->where("id={$id}")
                ->field('id,name,startTime,endTime')
                ->find();
            if ($response) {
                $response['status'] = 1;
                $response['data'] = $evaluate;
            }
        } elseif ($type == 'save') {
            $data = $_POST;
            $evaluate = array(
                'name' => $data['name'],
                'startTime' => strtotime($data['startTime']),
                'endTime' => strtotime($data['endTime']),
            );
            $rs = D('EvaluateTeacher')->where("id={$id}")->data($evaluate)->save();
            if ($rs) {
                $response['status'] = 1;
                $response['msg'] = '修改成功';
            }
        }
        $this->ajaxReturn($response);
    }

    //候选评委名单    //已测试
    public function judgeLists()
    {
        $response = array('status' => 1);
        $post = array('老师', '职工');
        $where = array(
            'scId' => $this->scId,
            'post' => array('in', $post)
        );
        $field = 'id,name,post,department';
        $res = array();
        $data = D('User')->where($where)->field($field)->select();
        if ($data) {
            foreach ($data as &$v) {
                if (!isset($res[$v['post']][$v['department']]))
                    $res[$v['post']][$v['department']] = array();
                $res[$v['post']][$v['department']][] = array(
                    'id' => $v['id'],
                    'name' => $v['name']
                );
            }
        }
        $response['data'] = $res;
        $this->ajaxReturn($response);
    }

    //判断评委是否已在分组中
    public function judgeExist($id, $userId, $judgeId = '', $sort)
    {
        $response = array(
            'status' => 1,
            'msg' => '不存在'
        );
        $where = array(
            'evaluateId' => $id,
            'scId' => $this->scId
        );
        if ($sort == 'save') {
            $where['id'] = array('neq', $judgeId);
        }
        $where['_string'] = "FIND_IN_SET({$userId},judgeId)";
        $rs = D('EvaluateJudge')->where($where)->select();

        if ($rs) {
            if (!empty($rs)) {
                $response['status'] = 1;
                $response['msg'] = '存在';
            }
        }
        $this->ajaxReturn($response);
    }

    //评委分组  //已测试
    public function judgeEvaluate($id)
    {
        $response = array('msg' => '', 'status' => 0, 'data' => '');
        $type = $_POST['type'];
        if (!empty($type)) {
            $judge = array(
                'name' => $_POST['name'],
                'max' => $_POST['max'],
                'min' => $_POST['min'],
                'scId' => $this->scId,
                'judge' => json_encode($_POST['judge']),//@todo
                'evaluateId' => $id
            );
            $judges = array_map(function ($v) {
                return $v['id'];
            }, $_POST['judge']);//todo
            $judge['judgeId'] = implode(',', $judges);
            if ($type == 'save') {
                $judeId = $_POST['judgeId'];
                $rs = D('EvaluateJudge')->where("id={$judeId}")->data($judge)->save();
            } elseif ($type == 'add') {
                $rs = D('EvaluateJudge')->data($judge)->add();
                if ($rs) {
                    $process = array(
                        2 => 1, 3 => 2
                    );
                    $this->changeProcess($process, $id);
                }
            } elseif ($type == 'del') {
                $judeId = $_POST['judgeId'];
                $rs = D('EvaluateJudge')->where("id={$judeId}")->delete();
            } else {
                $response['msg'] = '无权限';
            }
            if (!$rs) {
                $response['msg'] = '操作失败';
            } else {
                $response['status'] = 1;
                $response['msg'] = '操作成功';
            }
            $this->ajaxReturn($response);
        }

        $judge = D('EvaluateJudge')->where("evaluateId={$id}")->field('id,name,max,min,judge')->select();
        if ($judge) {
            foreach ($judge as $k => $v) {
                $judge[$k]['judge'] = json_decode($v['judge'], true);
            }
            $response['data'] = $judge;
        }
        $response['status'] = 1;
        $this->ajaxReturn($response);
    }

    //得到评委分组   //已测试
    public function getJudgeGroup($id, $sort = 1)
    {
        $where = array(
            'evaluateId' => $id,
            'scId' => $this->scId
        );
        $res = array();
        $data = D('EvaluateJudge')->where($where)->field('id,name')->select();
        if ($sort == 2) {
            return $data;
        }
        $this->ajaxReturn($data);
    }

    //设置考评分组    //已测试
    public function groupOfEvaluate($id)
    {
        $response = array('msg' => '', 'status' => 0, 'data' => '');
        $type = $_POST['type'];
        if (!empty($type)) {
            if ($type == 'save') {
                $groups = $_POST['group'];//@todo
                $val = '';
                foreach ($groups as &$v) {
                    $ratio = json_encode($v['judgeWeight']);
                    $val .= '(' . "'{$v['id']}'" . ',' . "'{$v['name']}'" . ',' . "'{$ratio}'" . ',' . "'{$id}'" . ','
                        . "'{$this->scId}'" . '),';
                }
                $val = rtrim($val, ',');
                $sql = "insert into mks_evaluate_group (id,name,judgeWeight,evaluateId,scId)
            values {$val} on duplicate key update name=values(name),judgeWeight=values(judgeWeight),evaluateId=values(evaluateId),
            scId=values(scId)";
                $rs = D('EvaluateGroup')->execute($sql);
                if ($rs) {
                    $process = array(
                        3 => 1, 4 => 2, 5 => 2
                    );
                    $this->changeProcess($process, $id);
                }
            } elseif ($type == 'del') {
                $groupId = $_POST['groupId'];
                $rs = D('EvaluateGroup')->where("id={$groupId}")->delete();
            } else {
                $response['msg'] = '无权限';
            }
            if (!$rs) {
                $response['msg'] = '操作失败';
            } else {
                $response['status'] = 1;
                $response['msg'] = '操作成功';
            }
            $this->ajaxReturn($response);
        }

        $group = D('EvaluateGroup')->where("evaluateId={$id}")->field('id,name,judgeWeight')->select();

        if ($group) {
            $temp = $this->getJudgeGroup($id, 2);
            $weigh = array();
            foreach ($temp as $k => $v) {
                $weigh[$v['id']] = $v['name'];
            }
            foreach ($group as $k => $v) {
                $judgeWeight = json_decode($v['judgeWeight'], true);
                $group[$k]['judgeWeight'] = array();
                foreach ($judgeWeight as $key => $val) {
                    array_push($group[$k]['judgeWeight'], array(
                            'name' => $weigh[$key],
                            'value' => $val
                        )
                    );
                }
            }
            $response['data'] = $group;
            $response['status'] = 1;
        }
        $this->ajaxReturn($response);
    }

    //待选被评人员   //已测试
    public function personnelLists($flag = 1)
    {
        $response = array('status' => 1);
        $post = array('老师', '职工');
        $where = array(
            'scId' => $this->scId,
            'post' => array('in', $post)
        );
        $field = 'id,name,post,department';
        $res = array();
        $data = D('User')->where($where)->field($field)->select();
        if ($data) {
            foreach ($data as &$v) {
                if (!isset($res[$v['post']][$v['department']]))
                    $res[$v['post']][$v['department']] = array();
                $res[$v['post']][$v['department']][] = array(
                    'id' => $v['id'],
                    'name' => $v['name']
                );
            }
        }
        if ($flag == 2) {
            return $res;
        }
        $response['data'] = $res;
        $this->ajaxReturn($response);
    }

    //添加被评人员    //已测试
    public function addPersonnel($id)
    {
        $response = array(
            'msg' => '',
            'status' => 0,
            'data' => ''
        );
        $type = $_POST['type'];
        if (!empty($type)) {
            if ($type == 'save') {
                $groupId = $_POST['groupId'];
                $personnel = array(
                    'personnel' => json_encode($_POST['personnel']),//@todo
                );
                $personnelId = array_map(function ($v) {
                    return $v['id'];
                }, $_POST['personnel']);//todo
                $personnel['personnelId'] = implode(',', $personnelId);
                $rs = D('EvaluateGroup')->where("id={$groupId}")->data($personnel)->save();
                if ($rs) {
                    $process = array(
                        4 => 1
                    );
                    $this->changeProcess($process, $id);
                }
                if (!$rs) {
                    $response['msg'] = '操作失败';
                } else {
                    $response['msg'] = '操作成功';
                    $response['status'] = 1;
                }
            } else {
                $response['msg'] = '无权限';
            }
            $this->ajaxReturn($response);
        }
        $data = D('EvaluateGroup')
            ->where("evaluateId={$id}")->field('id,name,personnel')
            ->select();
        if ($data) {
            foreach ($data as $k => $v) {
                $data[$k]['personnel'] = json_decode($v['personnel'], true);
            }
            $response['status'] = 1;
            $response['data'] = $data;
        }
        $this->ajaxReturn($response);
    }

    //评委名单  //已测试
    public function judgesLists($id)
    {
        $response = array('status' => 1);
        $res = array();
        $data = D('EvaluateJudge')
            ->where(array('evaluateId' => $id, 'scId' => $this->scId))
            ->field('name,judge')
            ->select();
        if ($data) {
            foreach ($data as &$v) {
                $res[] = array(
                    'name' => $v['name'],
                    'judge' => json_decode($v['judge'], true)
                );
            }
        }
        $response['data'] = $res;
        $this->ajaxReturn($response);
    }

    //添加评委  //已测试
    public function addJudge($id)
    {
        $response = array(
            'msg' => '',
            'status' => 0,
            'data' => ''
        );
        $type = $_POST['type'];
        if (!empty($type)) {
            if ($type == 'save') {
                $groupId = $_POST['groupId'];
                $judge = array(
                    'judge' => json_encode($_POST['judge']),//@todo
                );
                $judgeId = array_map(function ($v) {
                    return $v['id'];
                }, $_POST['judge']);//todo
                $judge['judgeId'] = implode(',', $judgeId);
                $rs = D('EvaluateGroup')->where("id={$groupId}")->data($judge)->save();
                if ($rs) {
                    $process = array(
                        5 => 1, 7 => 2
                    );
                    $this->changeProcess($process, $id);
                }
                if (!$rs) {
                    $response['msg'] = '操作失败';
                } else {
                    $response['msg'] = '操作成功';
                    $response['status'] = 1;
                }
            } else {
                $response['msg'] = '无权限';
            }
            $this->ajaxReturn($response);
        }
        $data = D('EvaluateGroup')
            ->where("evaluateId={$id}")->field('id,name,judge')
            ->select();
        if ($data) {
            foreach ($data as $k => $v) {
                $data[$k]['judge'] = json_decode($v['judge'], true);
            }
            $response['status'] = 1;
            $response['data'] = $data;
        }
        $this->ajaxReturn($response);
    }

    //比对名单统计 @todo
    public function comparisonLists($id)
    {
        //被考评的所有人
        $data = D('EvaluateGroup')->where(array('evaluateId' => $id, 'scId' => $this->scId))->field('judge,personnel')->select();
        $per = array();
        $judge = array();
        foreach ($data as &$v) {
            $per = array_merge($per, json_decode($v['personnel'], true));
            $judge = array_merge($judge, json_decode($v['judge'], true));
        }
        $perIds = array_map(function ($v) {
            return $v['id'];
        }, $per);
        $field = 'id,name';
        $post = array('老师', '职工');
        $where = array(
            'scId' => $this->scId,
            'post' => array('in', $post),
            'id' => array('not in', $perIds)
        );
        $notPer = D('User')->where($where)->field($field)->select();
        $response['status'] = 1;
        $response['notPer'] = $notPer;
        $response['per'] = $per;
        $response['judge'] = $judge;
        $this->ajaxReturn($response);
    }

    //考评进度跟踪
    public function trackProgress($id)
    {
        $response = array(
            'msg' => '',
            'status' => 0,
            'data' => ''
        );
        $data = D('EvaluateGroup')->where(array('evaluateId' => $id, 'scId' => $this->scId))->field('judgedId,judge')->select();
        if ($data) {
            $yetId = array();
            $not = array();
            $yet = array();
            foreach ($data as &$v) {
                $judge = json_decode($v['judge'], true);
                $temp = json_decode($v['judgedId'], true);
                foreach ($temp as $key => $val) {
                    foreach ($val as &$i) {
                        $yetId[] = $i;
                    }
                }
                foreach ($judge as $k1 => $v1) {
                    if (in_array($v1['id'], $yetId))
                        $yet[] = $v1;
                    else
                        $not[] = $v1;
                }
            }
            $response['status'] = 1;
            $response['yet'] = $yet;
            $response['not'] = $not;
        }
        $this->ajaxReturn($response);
    }

    //统计分析
    public function statisticsEva($id)
    {
        $response = array(
            'msg' => '',
            'status' => 0,
            'data' => ''
        );
        $uId = $this->uid;
        $map = array(
            'evaluateId' => $id,
            'scId' => $this->scId
        );
        if ($this->roleId != $this::$adminRoleId) {
            $map['_string'] = "FIND_IN_SET({$uId},personnelId)";
        }

        $personnel = D('EvaluateGroup')->where($map)->field('id,name,judge,personnel,score')->select();

        if (!empty($personnel)) {
            $response['status'] = 1;
            $data = array();
            foreach ($personnel as $k => $v) {
                $score = json_decode($v['score'], true);
                $person = json_decode($v['personnel'], true);
                $showPer = array();
                if ($this->roleId != $this::$adminRoleId) {
                    foreach ($person as $key => $val) {
                        if ($this->uid == $val['id'])
                            $showPer = $person[$key];
                    }
                } else {
                    $showPer = $person;
                }
                foreach ($showPer as $index => $per) {
                    $showPer[$index]['score'] = $score[$per['id']];
                }
                $data[] = array(
                    'id' => $v['id'],
                    'name' => $v['name'],
                    'personnel' => $showPer,
                );
            }
            $response['data'] = $data;
        }
        $this->ajaxReturn($response);


    }

    //考评记录
    public function evaluateLog()
    {
        $response = array(
            'status' => 0,
            'msg' => ''
        );
        $type = $_POST['type'];
        if (isset($type)) {
            $rs = false;
            $id = $_POST['logId'];
            if ($type == 'publish') {
                $status=$_POST['status'];
                $rs=D('EvaluateTeacher')->where(array('id' => $id))->data(array('publish'=>$status))->save();
            } elseif ($type == 'del') {
                $map = array(
                    'evaluateId' => $id,
                    'scId' => $this->scId
                );
                $rs = D('EvaluateTeacher')->where(array('id' => $id))->delete();
                D('EvaluateProcess')->where($map)->delete();
                D('EvaluateJudge')->where($map)->delete();
                D('EvaluateGroup')->where($map)->delete();
            } else {
                $response['msg'] = '没有权限';
                $this->ajaxReturn($response);
            }
            if (!$rs) {
                $response['msg'] = '操作失败';
            } else {
                $response['msg'] = '操作成功';
                $response['status'] = 1;
            }
            $this->ajaxReturn($response);
        }
        $where = array(
            'scId' => $this->scId
        );
        $data = D('EvaluateTeacher')->where($where)->field('id,name,startTime,endTime,publish,createTime')->select();
        if ($data) {
            $response['data'] = $data;
            $response['status'] = 1;
        }
        $this->ajaxReturn($response);
    }

    /*************************************评委操作*******************************************/
    //评委打分     //已测试
    public function judgeMark($id)
    {
        $response = array(
            'msg' => '',
            'status' => 0,
            'data' => ''
        );
        $uId = $this->uid;
        // $uId=18;
        $map = array(
            '_string' => "FIND_IN_SET({$uId},judgeId)",
            'evaluateId' => $id,
            'scId' => $this->scId
        );
        $personnels = D('evaluateGroup')->where($map)
            ->field('id,name,personnel,personnelId,judgeWeight,judgeScore,totalScore,score,judgedId')->select();
        if (empty($personnels)) {
            $response['status'] = 1;
            $response['msg'] = '你不属于此评教方案的评委';
            $this->ajaxReturn($response);
        }
        $plan = D('evaluateTeacher')->where(array('id' => $id))->find();
        if ($plan['startTime'] > time() || $plan['endTime'] < time()) {
            $response['status'] = 1;
            $response['msg'] = '不在考评时间之内';
            $this->ajaxReturn($response);
        }
        //找到评委组
        $type = $_POST['type'];
        if (isset($type)) {         //pass
            if ($type == 'submit') {
                //得到已经评过的分数
                $gId = $_POST['groupId'];
                $personnel = D('evaluateGroup')->where("id={$gId}")
                    ->field('id,name,personnel,personnelId,judgeWeight,judgeScore,totalScore,score,judgedId')->find();
                $judge = D('evaluateJudge')->where($map)->field('id,name,max,min,judgeId')->find();
                $judgeScore = json_decode($personnel['judgeScore'], true);
                $totalScore = json_decode($personnel['totalScore'], true);
                $score = array();
                $judgeWeight = json_decode($personnel['judgeWeight'], true);
                $judgedId = json_decode($personnel['judgedId'], true);
                //得到当前评委所在的评委组的权重
                $weight = $judgeWeight[$judge['id']];
                //得到所在评委组评委过的评委人数
                $foo = count($judgedId[$judge['id']]);
                $new_score = $_POST['score'];//@todo
                foreach ($new_score as $pId => $s) {
                    $judgeScore[$uId][$pId] = $s;
                    $temp = $totalScore[$judge['name']][$pId];
                    foreach ($s as $k => $v) {
                        $temp[$k] = round(($temp[$k] * $foo + $v) / ($foo + 1), 0) * $weight;
                    }
                    $totalScore[$judge['name']][$pId] = $temp;
                }
                $judgedId[$judge['id']][] = $uId;
                foreach ($totalScore as $jid => $p) {
                    foreach ($p as $k => $v) {
                        foreach ($v as $key => $val) {
                            $score[$k][$key] += $val;
                        }
                    }
                }
                $data = array(
                    'judgedId' => json_encode($judgedId),
                    'judgeScore' => json_encode($judgeScore),
                    'score' => json_encode($score),
                    'totalScore' => json_encode($totalScore),
                );
                $rs = D('EvaluateGroup')->where("id={$gId} and evaluateId={$id}")->data($data)->save();
                if ($rs) {
                    $response['msg'] = '提交成功';
                    $response['status'] = 1;
                } else {
                    $response['msg'] = '提交失败';
                }
            } else {
                $response['msg'] = '没权限';
            }
            $this->ajaxReturn($response);
        }
        $data = array();
        foreach ($personnels as &$v) {
            $judgeScore = json_decode($v['judgeScore'], true);
            $person = json_decode($v['personnel'], true);
            $showPer = $person;
            if (!array_key_exists($uId, $judgeScore)) {
                foreach ($showPer as $key => $val) {
                    $showPer[$key]['score'] = null;
                }
            } else {
                foreach ($showPer as $key => $v1) {
                    $showPer[$key]['score'] = $judgeScore[$uId][$showPer[$key]['id']];
                }
            }
            $data[] = array(
                'id' => $v['id'],
                'name' => $v['name'],
                'personnel' => $showPer,
            );
        }

        $response['status'] = 1;
        $response['data'] = $data;

        $this->ajaxReturn($response);
    }

}