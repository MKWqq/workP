<?php
namespace Home\Controller;
use Think\Controller;
class BcinformationController extends Base {
    private function import($fiel){
        if (!empty($fiel)) {
            $name=$this->randomkeys(5).time();
            $upload = new \Think\Upload();
            $upload->maxSize = 2097152;// 设置附件上传大小
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath = './'; // 设置附件上传根目录
            $upload->savePath = 'Public/upload/logo/'; // 设置附件上传（子）目录
            $upload->replace = true; // 设置附件是否替换
            //$upload->savePath  =     'cdr/'; // 设置附件上传（子）目录
            $upload->saveName = $name;
            $upload->autoSub = false;
            $info = $upload->uploadOne($fiel['photo']);
            if (!$info) {// 上传错误提示错误信息
                return false;
            }else{
                $string =$_FILES['photo']['name'];
                $arraym = explode('.',$string);
                $exs=$arraym[count($arraym)-1];
                return $name.'.'.$exs;
            }
        }else{
            return false;
        }
    }
    private function randomkeys($length){
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        $key='';
        for($i=0;$i<$length;$i++) {
            $key .= $pattern{mt_rand(0,35)};    //生成php随机数
        }
        return $key;
    }
    private function logodel($logo){
        $f=unlink('.'.parent::$uploadUrl.'logo/'.$logo);
        return $f;
    }
/********************************************************************************************************学校信息**********************************************************************************************/
    public function schoolinformation(){
        $getSession = $this->get_session('loginCheck',false);
        $urlHeader='http://localhost/';
        if (I('get.type') == 'schoolfind') {
            /************************学校信息展示**********************************/
            $dao = M('school');
            $where['scId'] = $getSession['scId'];
            $f = $dao->field('scName,enName,telephone,mail,province,city,area,ministries,type,logo')->where($where)->select();
            foreach ($f as $k => $v) {
                foreach ($v as $m => $n) {
                    $value[$m] = $n;
                }
            }
            $value['logo']=$urlHeader."school".parent::$uploadUrl.'logo/'.$value['logo'];
            $this->ajaxReturn($value);
        }elseif(I('get.type') == 'schoolupdate') {
            /********************学校信息修改*********************/
            $id['scId'] = $getSession['scId'];
            $arr['scName'] = I('post.scName');
            $arr['telephone'] = I('post.telephone');
            $arr['mail'] = I('post.mail');
            $arr['province'] = I('post.province');
            $arr['city'] = I('post.city');
            $arr['area'] = I('post.area');
            $arr['ministries'] = I('post.ministries');
            $arr['type'] = I('post.type');
            $arr['lastRecordTime'] = time();
            $dao = M('school');
            $m['return'] = true;
            $f = $dao->where($id)->save($arr);
            if ($f === false) {
                $m['return'] = false;
            }
            $this->ajaxReturn($m);
        }elseif (I('get.type') == 'schoolinsert') {
            /********************新建学校*********************/
            if (!empty($_FILES)){
                $a=$this->import($_FILES);
                $re['return']=false;
                if($a){
                    $arr['scName'] = I('post.scName');
                    $arr['logo'] = $a;
                    $arr['telephone'] = I('post.telephone');
                    $arr['mail'] = I('post.mail');
                    $arr['province'] = I('post.province');
                    $arr['city'] = I('post.city');
                    $arr['area'] = I('post.area');
                    $arr['ministries'] = I('post.ministries');
                    $arr['type'] = I('post.type');
                    $arr['lastRecordTime'] = time();
                    $arr['createTime'] = time();
                    $dao = M('school');
                    $m['return'] = true;
                    $f = $dao->data($arr)->add();
                    if($f!==false){
                        $re['return']=true;
                    }
                }
            }
            $this->ajaxReturn($re);
        }elseif (I('get.type') == 'schoollogo') {/********************学校logo修改*********************/
            $scId=$getSession['scId'];
            $re['return']=false;
            if (!empty($_FILES)){
                $a=$this->import($_FILES);
                if($a){
                    $dao = M('school');
                    $where['scId']=$scId;
                    $f1=$dao->where($where)->field('logo')->select();
                    $logo=$f1['0']['logo'];
                    $arr['lastRecordTime'] = time();
                    $arr['logo']=$a;
                    $this->logodel($logo);
                    $f=$dao->where($where)->save($arr);
                    if($f!==false){
                        $re['return']=true;
                    }
                }
            }
            $this->ajaxReturn($re);
        }
    }
    /********************************************************************************************************年级信息**********************************************************************************************/
    public function grade(){
        $getSession = $this->get_session('loginCheck',false);
        if (I('get.type') == 'gradefind') {/*****************************年级信息查找*********************************/
            $table="grade";
            $field=I('post.field');
            if(!$field){
                $field='gradeid';
            }
            $order=I("post.order");
            if($order=='descing'){
                $order='desc';
            }else{
                $order='asc';
            }
            $dao=M($table);
            $where['scId']=$getSession['scId'];
            $f=$dao->field('gradeid,code,name')->where($where)->order($field.' '.$order)->select();
            $this->ajaxReturn($f);
        }elseif(I('get.type') == 'gradedelete'){/*****************************年级信息删除*********************************/
            $table='grade';
            $dao=M($table);
            $where['scId']=$getSession['scId'];
            $where['gradeid']=I('post.gradeid');
            $m['return']=true;
            $f=$dao->where($where)->delete();
            if($f===false){
                $m['return']=false;
            }
            $this->ajaxReturn($m);
        }
    }

    /********************************************************************************************************科目信息**********************************************************************************************/
    public function subject(){
        $getSession = $this->get_session('loginCheck',false);
        if(I('get.type')=='subjectfind'){/*****************************科目信息查找*********************************/
            $table="subject";
            $dao=M($table);
            $field=I('post.field');
            if(!$field){
                $field='subjectid';
            }
            $order=I("post.order");
            if($order=='descing'){
                $order='desc';
            }else{
                $order='asc';
            }
            $where['scId']=$getSession['scId'];
            $f=$dao->field('subjectid,subjectname,fullcredit')->where($where)->order($field.' '.$order)->select();
            $this->ajaxReturn($f);
        }elseif(I('get.type')=='subjectupdate'){/*****************************科目信息修改添加*********************************/
            $table='subject';
            $scId=$getSession['scId'];
            $mm=json_decode(urldecode($_POST['data']),true);
            $dao=M($table);
            $m['return']=true;
            foreach($mm as $k=>$v){
                if($v['subjectid']){
                    $where['subjectid']=$v['subjectid'];
                    $where['scId']=$scId;
                    $data['subjectname']=$v['subjectname'];
                    $data['fullcredit']=$v['fullcredit'];
                    $data['lastRecordTime'] = time();
                    $f=$dao->where($where)->save($data);
                    if($f===false){
                        $m['return']=false;
                    }
                }else{
                    $data['scId']=$scId;
                    $data['subjectname']=$v['subjectname'];
                    $data['fullcredit']=$v['fullcredit'];
                    $data['lastRecordTime'] = time();
                    $data['createTime'] = time();
                    $f=$dao->data($data)->add();
                    if($f===false){
                        $m['return']=false;
                    }
                }
            }
            $this->ajaxReturn($m);
        }elseif(I('get.type')=='subjectdel'){/*****************************科目信息删除*********************************/
            $table='subject';
            $where['subjectid']=I('post.subjectid');
            $where['scId']=$getSession['scId'];
            $dao=M($table);
            $m['return']=true;
            $f=$dao->where($where)->delete();
            if($f===false){
                $m['return']=false;
            }
            $this->ajaxReturn($m);
        }
    }
    /********************************************************************************************************专业信息**********************************************************************************************/
    public function major(){
        $getSession = $this->get_session('loginCheck',false);
        if(I('get.type')=='majorselect'){/*****************************专业信息查找*********************************/
            $dao=M();
            $field=I('post.field');
            if($field=='majorname'){
                $field='m'.$field;
            }else{
                $field='b.branch';
            }
            $order=I("post.order");
            if($order=='descing'){
                $order='desc';
            }else{
                $order='asc';
            }
            $scId=$getSession['scId'];
            $sql="SELECT m.majorid,m.majorname,b.branch FROM mks_class_major AS m,mks_class_branch AS b WHERE m.branch=b.branchid AND m.scId=".$scId." order by ".$field.' '.$order;
            $f=$dao->query($sql);
            $sql2="select branch,branchid from mks_class_branch WHERE scId=".$scId;
            $f2=$dao->query($sql2);
            $arr['branchlist']=$f2;
            $arr['data']=$f;
            $this->ajaxReturn($arr);
        }elseif(I('get.type')=='majorupdate'){/*****************************专业信息修改添加*********************************/
            $table='class_major';
            $scId=$getSession['scId'];
            $mm=json_decode(urldecode($_POST['data']),true);
            $dao=M($table);
            $m['return']=true;
            foreach($mm as $k=>$v){
                if($v['majorid']){
                    $where['majorid']=$v['majorid'];
                    $where['scId']=$scId;
                    $data['majorname']=$v['majorname'];
                    $data['branch']=$v['branchid'];
                    $data['lastRecordTime'] = time();
                    $f=$dao->where($where)->save($data);
                    if($f===false){
                        $m['return']=false;
                    }
                }else{
                    $data['scId']=$scId;
                    $data['majorname']=$v['majorname'];
                    $data['branch']=$v['branchid'];
                    $data['lastRecordTime'] = time();
                    $data['createTime'] = time();
                    $f=$dao->data($data)->add();
                    if($f===false){
                        $m['return']=false;
                    }
                }
            }
            $this->ajaxReturn($m);
        }elseif(I('get.type')=='majordelete'){/*****************************专业信息删除*********************************/
            $table='class_major';
            $where['majorid']=I('post.majorid');
            $where['scId']=$getSession['scId'];
            $dao=M($table);
            $m['return']=true;
            $f=$dao->where($where)->delete();
            if($f===false){
                $m['return']=false;
            }
            $this->ajaxReturn($m);
        }
    }
    /********************************************************************************************************科类信息**********************************************************************************************/
    public function branch(){
        $getSession = $this->get_session('loginCheck',false);
        if(I('get.type')=='branchselect'){/*****************************科类信息查找*********************************/
            $table="class_branch";
            $dao=M($table);
            $where['scId']=$getSession['scId'];
            $order=I("post.order");
            if($order=='descing'){
                $order='desc';
            }else{
                $order='asc';
            }
            $field='branch';
            $f=$dao->where($where)->field('branchid,branch')->order($field.' '.$order)->select();
            $this->ajaxReturn($f);
        }elseif(I('get.type')=='branchupdate'){/*****************************科类信息修改添加*********************************/
            $table='class_branch';
            $scId=$getSession['scId'];
            $mm=json_decode(urldecode($_POST['data']),true);
            $dao=M($table);
            $m['return']=true;
            foreach($mm as $k=>$v){
                if($v['branchid']){
                    $where['branchid']=$v['branchid'];
                    $where['scId']=$scId;
                    $data['branch']=$v['branch'];
                    $data['lastRecordTime'] = time();
                    $f=$dao->where($where)->save($data);
                    if($f===false){
                        $m['return']=false;
                    }
                }else{
                    $data['scId']=$scId;
                    $data['branch']=$v['branch'];
                    $data['lastRecordTime'] = time();
                    $data['createTime'] = time();
                    $f=$dao->data($data)->add();
                    if($f===false){
                        $m['return']=false;
                    }
                }
            }
            $this->ajaxReturn($m);
        }elseif(I('get.type')=='branchdel'){/*****************************科类信息删除*********************************/
            $table='class_major';
            $where['branchid']=I('post.branchid');
            $where['scId']=$getSession['scId'];
            $dao=M($table);
            $m['return']=true;
            $f=$dao->where($where)->delete();
            if($f===false){
                $m['return']=false;
            }
            $this->ajaxReturn($m);
        }
    }
    /********************************************************************************************************班级级别信息**********************************************************************************************/
    public function level(){
        $getSession = $this->get_session('loginCheck',false);
        if(I('get.type')=='levelselect'){/*****************************班级级别信息查找*********************************/
            $table="class_level";
            $dao=M($table);
            $where['scId']=$getSession['scId'];
            $order=I("post.order");
            if($order=='descing'){
                $order='desc';
            }else{
                $order='asc';
            }
            $field='levelname';
            $f=$dao->where($where)->field('levelid,levelname')->order($field.' '.$order)->select();
            $this->ajaxReturn($f);
        }elseif(I('get.type')=='levelupdate'){/*****************************班级级别修改添加*********************************/
            $table='class_level';
            $scId=$getSession['scId'];
            $mm=json_decode(urldecode($_POST['data']),true);
            $dao=M($table);
            $m['return']=true;
            foreach($mm as $k=>$v){
                if($v['levelid']){
                    $where['levelid']=$v['levelid'];
                    $where['scId']=$scId;
                    $data['levelname']=$v['levelname'];
                    $data['lastRecordTime'] = time();
                    $f=$dao->where($where)->save($data);
                    if($f===false){
                        $m['return']=false;
                    }
                }else{
                    $data['scId']=$scId;
                    $data['levelname']=$v['levelname'];
                    $data['lastRecordTime'] = time();
                    $data['createTime'] = time();
                    $f=$dao->data($data)->add();
                    if($f===false){
                        $m['return']=false;
                    }
                }
            }
            $this->ajaxReturn($m);
        }elseif(I('get.type')=='leveldel'){/*****************************班级级别删除*********************************/
            $table='class_level';
            $where['levelid']=I('post.levelid');
            $where['scId']=$getSession['scId'];
            $dao=M($table);
            $m['return']=true;
            $f=$dao->where($where)->delete();
            if($f===false){
                $m['return']=false;
            }
            $this->ajaxReturn($m);
        }
    }


    /********************************************************************************************************学年学期**********************************************************************************************/
    public function schoolyear(){
        $getSession = $this->get_session('loginCheck',false);
        if(I('get.type')=='schoolyearselect'){/*****************************学年学期信息查找*********************************/
            $table="school_year";
            $dao=M($table);
            $where['scId']=$getSession['scId'];
            $f=$dao->where($where)->field('yearid,yearname,startime,endtime,term,lastRecordTime')->select();
            foreach($f as $k=>$v){
                $f[$k]['lastRecordTime']=date('Y-m-d H-i-s',$v['lastRecordTime']);
                $startime=strtotime($v['startime']);
                $endtime=strtotime($v['endtime']);
                $time=time();
                if($startime<$time && $endtime>$time){
                    $f[$k]['atPresent']=true;
                }else{
                    $f[$k]['atPresent']=false;
                }
            }
            $this->ajaxReturn($f);
        }elseif(I('get.type')=='yearupdate'){/*****************************学年学期修改添加*********************************/
            $table='school_year';
            $scId=$getSession['scId'];
            $dao=M($table);
            $m['return']=true;
            $yearid=I('post.yearid');
            if($yearid){
                $where['yearid']=$yearid;
                $where['scId']=$scId;
                $data['yearname']=I('post.yearname');
                $data['term']=I('post.term');
                $data['startime']=I('post.startime');
                $data['endtime']=I('post.endtime');
                $data['lastRecordTime'] = time();
                $f=$dao->where($where)->save($data);
                if($f===false){
                    $m['return']=false;
                }
            }else{
                $data['scId']=$scId;
                $data['yearname']=I('post.yearname');
                $data['term']=I('post.term');
                $data['startime']=I('post.startime');
                $data['endtime']=I('post.endtime');
                $data['lastRecordTime'] = time();
                $data['createTime'] = time();
                $f=$dao->data($data)->add();
                if($f===false){
                    $m['return']=false;
                }
            }
            $this->ajaxReturn($m);
        }elseif(I('get.type')=='yeardel'){/*****************************学年学期删除*********************************/
            $table='school_year';
            $where['yearid']=I('post.yearid');
            $where['scId']=$getSession['scId'];
            $dao=M($table);
            $m['return']=true;
            $f=$dao->where($where)->delete();
            if($f===false){
                $m['return']=false;
            }
            $this->ajaxReturn($m);
        }
    }
    /********************************************************************************************************部门信息**********************************************************************************************/
    public function department(){
        $getSession = $this->get_session('loginCheck',false);
        if(I('get.type')=='departmentselect'){/*****************************部门信息查找*********************************/
            $table="department";
            $dao=M($table);
            $where['scId']=$getSession['scId'];
            $f=$dao->where($where)->field('departmentId,departmentName,parentId,level')->select();
            $this->ajaxReturn($f);
        }elseif(I('get.type')=='departmentupdate'){/*****************************部门信息修改添加*********************************/
            $table='department';
            $scId=$getSession['scId'];
            $mm=json_decode(urldecode($_POST['data']),true);
            $dao=M($table);
            $m['return']=true;
            foreach($mm as $k=>$v){
                if($v['departmentId']){
                    $where['departmentId']=$v['departmentId'];
                    $where['scId']=$scId;
                    $data['departmentName']=$v['departmentName'];
                    $data['lastRecordTime'] = time();
                    $f=$dao->where($where)->save($data);
                    if($f===false){
                        $m['return']=false;
                    }
                }else{
                    $data['scId']=$scId;
                    $data['departmentName']=$v['departmentName'];
                    $data['parentId']=$v['parentId'];
                    $data['level']=$v['level'];
                    $data['lastRecordTime'] = time();
                    $data['createTime'] = time();
                    $f=$dao->data($data)->add();
                    if($f===false){
                        $m['return']=false;
                    }
                }
            }
            $this->ajaxReturn($m);
        }elseif(I('get.type')=='departmentdel'){/*****************************部门删除*********************************/
            $table='department';
            $where['yearid']=I('post.yearid');
            $where['scId']=$getSession['scId'];
            $dao=M($table);
            $m['return']=true;
            $f=$dao->where($where)->delete();
            if($f===false){
                $m['return']=false;
            }
            $this->ajaxReturn($m);
        }
    }

}