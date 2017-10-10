<?php
/**
 * Created by PhpStorm.
 * User: hujun
 * Date: 2017/8/14
 * Time: 14:10
 */

namespace Home\Controller;


use Think\Controller;

class ClassManageController extends Base
{
    protected $uid;
    protected $scId;
    protected $user;
    protected $roleId;

    public function __construct()
    {
        parent::__construct();
        $this->scId = $_SESSION['loginCheck']['data']['scId'];
        $this->uid = $_SESSION['loginCheck']['data']['userId'];
        $this->roleId = $_SESSION['loginCheck']['data']['roleId'];
/*        $this->scId = 2;
        $this->uid = 1;
        $this->roleId = 22;*/
        $this->user = D('User')->where(array('id' => $this->uid, 'scId' => $this->scId))->find();
    }

    public function common($func, $param = array())
    {
        switch ($func) {
            case 'getClass':
                $this->getClass($param['kind'],$param['class']);
                break;
            default:
                return null;
        }
    }

    //得到所属年级和班级
    function getId()
    {
        $userId = $this->uid;
        $info = D('Class')->where("userid={$userId} and scId={$this->scId}")->field('classid,grade')->select();
        $id = array();
        foreach ($info as &$v) {
            $id[$v['grade']][] = $v['classid'];
        }
        return $id;
    }

    //得到下拉框的值
    function getClass($kind = '', $class = false)
    {

        $where = array(
            'g.scId' => $this->scId
        );

        if ($this->roleId != $this::$adminRoleId) {
            $id = $this->getId();
            $gradeId = array_keys($id);
            $classId = array();
            $where['g.gradeid'] = array('in', $gradeId);
            if ($class) {
                foreach ($id as $k => $t) {
                    foreach ($t as $key => $val) {
                        $classId[] = $val;
                    }
                }
                $where['c.classid'] = array('in', $classId);
            }
        }

        $grade = M('Grade g')
            ->join('mks_class c ON g.gradeid=c.grade and g.scId=c.scId', 'LEFT')
            ->where($where)
            ->field('g.gradeid,g.name,g.scId,c.classid,c.classname,c.number,c.userid')
            ->select();

        $situation = array();
        if (!$grade || empty($grade)) {
            return $situation;
        }
        foreach ($grade as &$v) {
            if (!array_key_exists($v['gradeid'], $situation)) {
                $situation[$v['gradeid']] = array(
                    'name' => $v['name'],
                    'scId' => $v['scId']
                );
                $situation[$v['gradeid']]['class'] = array();
            }
            array_push($situation[$v['gradeid']]['class'],
                array(
                    'classid' => $v['classid'],
                    'classname' => $v['classname'],
                    'number' => $v['number'],
                    'userid' => $v['userid']
                ));
        }
        foreach ($situation as $k => $v) {
            if ($kind == 'exam') {
                $situation[$k]['exam'] = array();
            }
            if (empty($v['class'])) {
                unset($situation[$k]);
            }
        }
        if ($kind == 'exam') {
            $map = array(
                'g.scId' => $this->scId
            );
            if ($this->roleId != $this::$adminRoleId) {
                $map['e.gradeid'] = array('in', $gradeId);
            }
            $examination = M('grade g')
                ->join('mks_examination e ON g.gradeid=e.gradeid and g.scId=e.scId', 'RIGHT')
                ->where($map)
                ->field('g.gradeid,e.examinationid,e.examination,e.headmaster')
                ->select();
            foreach ($examination as &$v) {
                if (array_key_exists($v['gradeid'], $situation)) {
                    array_push($situation[$v['gradeid']]['exam'],
                        array(
                            'examinationid' => $v['examinationid'],
                            'examination' => $v['examination'],
                            'headmaster' => $v['headmaster'],
                        ));
                }
            }
        }

        $this->ajaxReturn($situation);
    }

    //得到学生
    function getStudent($classId)
    {
        $students = D('StudentInfo')->where("classId={$classId} and scId={$this->scId}")->field('id,name')->select();
        return $students;
    }

    /*****************************************座位调整*************************************************/
    public function seatLayout($view = '')
    {
        $group = $_POST['group'];
        $response = array(
            'status' => '',
            'msg' => '',
        );
        $classId = $_POST['classId'];
        $type = $_POST['type'];
        $rs = D('SeatLayout')->where("scId={$this->scId} and classId={$classId}")->field('id,layout,arrange')->find();

        if (isset($type)) {
            $res = false;
            if ($type == 'layoutSave') {
                $layout = json_encode($_POST['layout']); //@todo
                if (empty($rs['layout'])) {
                    $data = array(
                        'layout' => $layout,
                        'classId' => $classId,
                        'class' => $_POST['class'],
                        'grade' => $_POST['grade'],
                        'userId' => $_POST['userId'],
                        'scId' => $this->scId,
                        'createTime' => time(),
                        'creator' => $this->user['name'],
                        'creatorId' => $this->uid
                    );
                    $res = D('SeatLayout')->data($data)->add();
                } else {
                    $id = $_POST['id'];
                    $data = array(
                        'layout' => $layout,
                        'arrange' => '',
                        'lastRecordTime' => time()
                    );
                    $res = D('SeatLayout')->where("id={$id}")->data($data)->save();
                }
            } elseif ($type == 'arrangeSave') {
                $id = $_POST['id'];
                $data = array(
                    'arrange' =>json_encode($_POST['arrange']) ,//@todo
                    'lastRecordTime' => time()
                );
                $res = D('SeatLayout')->where("id={$id}")->data($data)->save();
            } elseif ($type == 'produceArr') {//生成座位表
                $examId = isset($_POST['examId']) ? $_POST['examId'] : null;
                $order = $_POST['order'];//排序
                $acc = $_POST['according'];//排序依据 score height number
                $sex = $_POST['sex'];//性别规则 random together part
                $layout=$rs['layout'];

                if(empty($layout)){
                    $response['msg']='没有座位布局';
                    $this->ajaxReturn($response);
                }
                $layout=json_decode($layout,true);
                $res = $this->seatArrange($order, $acc, $sex, $classId, $examId,$layout);
                if(!$res){
                    $response['msg']='生成座位表出错';
                }else{
                    $response['status']=1;
                    $response['data']=$res;
                }
                $this->ajaxReturn($response);
            } else {
                $response['msg'] = '没有权限';
                $this->ajaxReturn($response);
            }
            if ($res) {
                $response['msg'] = '操作成功';
                $response['status'] = 1;
            }
            $this->ajaxReturn($response);
        }


        if ($view == 'arrange') {
            if ($rs) {
                $response['id'] = $rs['id'];
                $layout = json_decode($rs['layout'], true);
                $arr = json_decode($rs['arrange'], true);
                $arrange = array();
                foreach ($layout as $g => $l) {
                    foreach ($l as $k => $v) {
                        $arrange[$g][$l][] = array(
                            'seat' => $v,
                            'id' => $arr[$v]['id'],
                            'name' => $arr[$v]['name']
                        );
                    }
                }
                $response['arrange'] = $arrange;
            }
            $response['status'] = 1;
        } else {
            if (!$rs) {
                $students = $this->getStudent($classId);
                if ($students) {
                    $total = count($students);
                    $response['status'] = 1;
                    $response['total'] = $total;
                }
            } else {
                $response['id'] = $rs['id'];
                $layout = json_decode($rs['layout'], true);
                $response['layout'] = $layout;
                $response['status'] = 1;
            }
        }
        $this->ajaxReturn($response);
    }

    //生成座位安排
    function seatArrange($order, $acc, $sex, $classId, $examId,$layout=array())
    {
        $arrange = array();
        $students = D('StudentInfo')
            ->where("scId={$this->scId} and classId={$classId}")
            ->field('userId,name,serialNumber,sex,height')
            ->select();

        if(!$students)
            return false;
        $temp_stu = array();
        if($acc=='score'){  //成绩
            $userId=array_map(function($v){
                return $v['userId'];
            },$students);
            $where=array(
                'scId'=>$this->scId,
                'userid'=>array('in',$userId),
                'examinationid'=>$examId
            );
            $score=D('ExaminationResults')->where($where)
                ->group('userid')->field('userid as userId,sum(results) as score')->select();
            if(!$score)
                return false;
            $temp=array();
            foreach ($score as &$v){
                $temp[$v['userId']]=$v['score'];
            }

            foreach ($students as &$v){
                $temp_stu[]=array(
                    'userId'=>$v['userId'],
                    'name'=>$v['name'],
                    'sex'=>$v['sex'],
                    'order'=>$temp[$v['userId']]
                );
            }
        }elseif($acc=='height'){//身高
            foreach ($students as &$v){
                $temp_stu[]=array(
                    'userId'=>$v['userId'],
                    'name'=>$v['name'],
                    'sex'=>$v['sex'],
                    'order'=>(int)$v['height']
                );
            }
        }else{  //序号
            foreach ($students as &$v){
                $temp_stu[]=array(
                    'userId'=>$v['userId'],
                    'name'=>$v['name'],
                    'sex'=>$v['sex'],
                    'order'=>(int)$v['serialNumber']
                );
            }
        }

        if ($order == 'asc') {
            usort($temp_stu, function ($a, $b) {
                $al = (int)$a['order'];
                $bl = (int)$b['order'];
                if ($al == $bl)
                    return 0;
                return ($al < $bl) ? -1 : 1; //升序
            });
        } else {
            usort($temp_stu, function ($a, $b) {
                $al = (int)$a['order'];
                $bl = (int)$b['order'];
                if ($al == $bl)
                    return 0;
                return ($al > $bl) ? -1 : 1; //降序
            });
        }

        $new_temp=array();
        $male=array();
        $female=array();
        if($sex=='random'){
            $new_temp=$temp_stu;
        }else{
            foreach ($temp_stu as &$v){
                if($v['sex']=='男'){
                    $male[]=$v;
                }else{
                    $female[]=$v;
                }
            }
            $female=array_reverse($female);
            $temp_stu=array_merge($male,$female);
            if($sex=='part'){//不同桌
                do{
                    foreach ($layout as $key=>$val){
                        $line=count($val);
                        if($line>count($temp_stu)){
                            $temp=array_splice($temp_stu,0);
                        }else{
                            if(($key+1)%2==0){
                                $temp=array_splice($temp_stu,0,$line);
                            }else{
                                $temp=array_splice($temp_stu,-$line);
                            }
                        }
                        $new_temp=array_merge($new_temp,$temp);
                    }
                }while(count($temp_stu)>1);
            }elseif ($sex=='together'){//同桌
                do{
                    foreach ($layout as $key=>$val){
                        $line=count($val);
                        for($i=1;$i<=$line;$i++){
                            if($i%2==0){
                                $temp=array_splice($temp_stu,0,1);
                            }else{
                                $temp=array_splice($temp_stu,-1);
                            }
                            $new_temp=array_merge($new_temp,$temp);
                            if(count($temp_stu)<1)
                                break;
                        }
                    }
                }while(count($temp_stu)>1);
            }
        }
        return $new_temp;
    }

    public function test()
    {
        $param = array(
            1 => array(
                1 => array(1, 19, 17, 25, 33, 41, 49),
                2 => array(2, 10, 18, 26, 34, 42, 50)
            ),
            2 => array(
                1 => array(3, 11, 19, 27, 35, 43, 51),
                2 => array(4, 12, 20, 28, 36, 44, 52)
            ),
            3 => array(
                1 => array(5, 13, 21, 29, 37, 45, 53),
                2 => array(6, 14, 22, 30, 38, 46)
            ),
            4 => array(
                1 => array(7, 15, 23, 31, 39, 47),
                2 => array(8, 16, 24, 32, 40, 48)
            ),

        );
        var_dump($param);
    }

}
