<?php
namespace Home\Controller;
use Think\Controller;
class ExaminationController extends Base {
    private function sortArrByOneField($array, $field, $desc = false){
        $fieldArr = array();
        foreach ($array as $k => $v) {
            $fieldArr[$k] = $v[$field];
        }
        $sort = $desc == false ? SORT_ASC : SORT_DESC;
        array_multisort($fieldArr, $sort, $array);
        return $array;
    }
    private function getExamName($examinationid){
        $getSession = $this->get_session('loginCheck',false);
        $dao=M('examination');
        $where['examinationid']=$examinationid;
        $where['scId']=$getSession['scId'];
        $f=$dao->where($where)->field('examination')->select();
        return $f['0']['examination'];
    }
    private function getArrange($examinationid,$f3=null){
        $dao=M();
        $scId=2;
        $weekday = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
        $sql1="SELECT b.`branch`,s.`date`,s.`id` AS ensubjectid,t.`subjectname`,s.`starttime`,s.`endtime`,b.branchid FROM `mks_examination_subject` AS s,mks_class_branch AS b,mks_subject AS t WHERE s.`examinationid`=".$examinationid." and s.scId=".$scId." AND s.`subject`=t.`subjectid` AND s.`branchid`=b.`branchid` ";
        $f1=$dao->query($sql1);
        foreach($f1 as $k=>$v){
            $data1[$v['branchid']]['branch']=$v['branch'];
            $data1[$v['branchid']]['datelist'][$v['date']]['date']=$v['date']."(".$weekday[date('w',strtotime($v['date']))].")";
            $data1[$v['branchid']]['datelist'][$v['date']]['subjectlist'][$v['ensubjectid']]['subjectname']=$v['subjectname'];
            $data1[$v['branchid']]['datelist'][$v['date']]['subjectlist'][$v['ensubjectid']]['starttime']=$v['starttime'];
            $data1[$v['branchid']]['datelist'][$v['date']]['subjectlist'][$v['ensubjectid']]['endtime']=$v['endtime'];
            $data1[$v['branchid']]['datelist'][$v['date']]['subjectlist'][$v['ensubjectid']]['ensubjectid']=$v['ensubjectid'];
        }
        foreach($data1 as $k=>$v){
            foreach($v['datelist'] as $a=>$b){
                $data1[$k]['datelist'][$a]['subjectlist']=array_values($b['subjectlist']);
            }
            $data1[$k]['datelist']=array_values($data1[$k]['datelist']);
        }
        $data1=array_values($data1);
        $sql2="SELECT r.`id` AS roomid,r.room,b.`branch` FROM `mks_examination_room` AS r,mks_class_branch AS b WHERE r.`branch`=b.`branchid` AND r.`examinationid`=".$examinationid." and r.scId=".$scId;
        $f2=$dao->query($sql2);
        foreach($f2 as $k=>$v){
            $data2[$v['branch']]['branch']=$v['branch'];
            $data2[$v['branch']]['roomlist'][$v['roomid']]['roomid']=$v['roomid'];
            $data2[$v['branch']]['roomlist'][$v['roomid']]['room']=$v['room'];
        }
        foreach($data2 as $k=>$v){
            $arr1['roomid']="巡考";
            $arr1['room']="巡考";
            $arr2['roomid']="总巡考";
            $arr2['room']="总巡考";
            $data2[$k]['roomlist']=array_values($data2[$k]['roomlist']);
            $data2[$k]['roomlist'][]=$arr1;
            $data2[$k]['roomlist'][]=$arr2;
        }
        $sql4="SELECT b.`branch`,s.id AS ensubjectid FROM `mks_examination_subject` AS s,mks_class_branch AS b WHERE s.`examinationid`=".$examinationid." and s.scId=".$scId." AND s.`branchid`=b.`branchid`";
        $f4=$dao->query($sql4);
        foreach($f4 as $k=>$v){
            $data5[$v['branch']][]=$v['ensubjectid'];
        }
        foreach($data2 as $k=>$v){
            foreach($v['roomlist'] as $c=>$d){
                foreach($data5[$k] as $a=>$b){
                    $data2[$k]['roomlist'][$c][$b]=array();
                }
            }
        }
        $data2=array_values($data2);
        if(!$f3){
            $sql3="SELECT u.`name`,s.`ensubjectid`,s.`room` as roomid,u.id as userid FROM `mks_examination_supervision` AS s,mks_user AS u WHERE s.`userid`=u.`id` AND s.`examinationid`=".$examinationid." and s.scId=".$scId;
            $f3=$dao->query($sql3);
        }
        foreach($f3 as $k=>$v){
            $data3[$v['roomid']][$v['ensubjectid']][]=$v;
        }
        foreach($data2 as $k=>$v){
            foreach($v['roomlist'] as $a=>$b){
                foreach($data3[$b['roomid']] as $e=>$f){
                    if(isset($data2[$k]['roomlist'][$a][$e])){
                        $data2[$k]['roomlist'][$a][$e]=$f;
                        unset($data3[$b['roomid']][$e]);
                    }

                }
            }
        }
        $arraa['title']=$data1;
        $arraa['data']=$data2;
        return $arraa;
    }
    /******************************************创建考试*******************************************************/
    public function excreat(){
                        /**********************************可选考试科目及年级及科类列表*************************************/
        $getSession = $this->get_session('loginCheck',false);
        if(I('get.type')=='examcreat'){
            if(I('get.typename')=='grade'){/***************年级**************/
                $scId['scId']=$getSession['scId'];
                $dao=M();
                $f1=$dao->table('mks_grade')->field('gradeid,name')->where($scId)->select();
                $this->ajaxReturn($f1);
            }elseif(I('get.typename')=='template'){/**************模板****************/
                $dao=M();
                $scId=$getSession['scId'];
                $gradeid=I('post.gradeid');
                $sql="SELECT e.`examination`,e.examinationid FROM `mks_examination` AS e WHERE e.release=1 and e.gradeid=".$gradeid." AND e.`scId`=".$scId;
                $data1=$dao->query($sql);
                $this->ajaxReturn($data1);
            }elseif(I('get.typename')=='subject'){/**************科目****************/
                $dao=M();
                $scId=$getSession['scId'];
                $where['scId']=$scId;
                $examinationid=I('post.examinationid');
                $gradeid=I('post.gradeid');
                $f1=$dao->table('mks_subject')->field('subjectid,subjectname,fullcredit')->where($where)->select();
                $sql2="SELECT b.`branch`,b.`branchid` FROM mks_class AS c,mks_class_branch AS b WHERE c.`grade`=".$gradeid." AND b.scId=".$scId." and c.`branch`=b.`branchid` GROUP BY branchid";
                $f2=$dao->query($sql2);
                foreach($f1 as $k=>$v){
                    $f1[$k]['state']=false;
                }
                foreach($f2 as $k=>$v){
                    $arr2['branch']=$v['branch'];
                    $arr2['branchid']=$v['branchid'];
                    $arr2['subjectlist']=$f1;
                    $data[]=$arr2;
                }
                if($examinationid){
                    $sql3="SELECT branchid,subject FROM `mks_examination_subject` WHERE examinationid=".$examinationid." and scId=".$scId;
                    $f3=$dao->query($sql3);
                    foreach($f3 as $k=>$v){
                        $arr3[$v['branchid']][]=$v['subject'];
                    }
                    foreach($data as $k=>$v){
                        foreach($v['subjectlist'] as $a=>$b){
                            foreach($arr3 as $c=>$d){
                                foreach($d as $e=>$g){
                                    if($b['subjectid']==$g){
                                        $data[$k]['subjectlist'][$a]['state']=true;
                                    }
                                }
                            }
                        }
                    }
                }
                $this->ajaxReturn($data);
                $sql="SELECT e.`examination`,e.examinationid FROM `mks_examination` AS e WHERE e.gradeid=".$gradeid." AND e.`scId`=".$scId;
                $data1=$dao->query($sql);
                $this->ajaxReturn($data1);
            }elseif(I('get.typename')=='suexselect'){/***********************选择科目默认总分***************************/
                $subjectid=$_POST['subjectid'];
                $dao=M('subject');
                $where['subjectid'] = array('in',$subjectid);
                $where['scId'] = $getSession['scId'];
                $data=$dao->where($where)->select();
                if($data){
                    foreach($data as $k=>$v){
                        $data1[$k]['subjectid']=$v['subjectid'];
                        $data1[$k]['subjectname']=$v['subjectname'];
                        $data1[$k]['fullcredit']=$v['fullcredit'];
                    }
                }else{
                    $data1=$data;
                }
                $this->ajaxReturn($data1);
            }elseif(I('get.typename')=='clexselect'){/***********************对应年级可选班级列表***************************/
                $dao=M();
                $grade=I('post.gradeid');
                $scId=$getSession['scId'];
                //$where['scId']=I('get.scId');
                $sql="SELECT c.`classid`,c.`classname`,b.`branch` FROM `mks_class` AS c,`mks_class_branch` AS b WHERE c.`branch`=b.`branchid` AND c.grade=".$grade." and c.scId=".$scId;
                $f3=$dao->query($sql);
                if($f3){
                    foreach($f3 as $k=>$v){
                        $data2[$v['branch']][$k]['classid']=$v['classid'];
                        $data2[$v['branch']][$k]['classname']=$v['classname'];
                    }
                    foreach($data2 as $k=>$v){
                        $data3['branch']=$k;
                        $data3['classlist']=array_values($v);
                        $data4[]=$data3;
                    }
                }else{
                    $data4=$f3;
                }
                $this->ajaxReturn($data4);
            }elseif(I('get.typename')=='exinsert'){
                /*****************************保存创建考试****************************************/
                $dao=M();
                $scId=$getSession['scId'];
                M()->startTrans();
                $data['examinationid']=0;
                $data['gradeid']=I('post.gradeid');
                $data['examination']=I('post.examination');
                $data['starttime']=I('post.starttime');
                $data['endtime']=I('post.endtime');
                $data['release']=0;
                $data['class']=I('post.class');
                $data['scId']=$scId;
                $data['createTime']=time();
                $data['lastRecordTime']=time();
                $data['headmaster']=I('post.headmaster');
                $f1=$dao->table('mks_examination')->data($data)->add();
                $class=explode(',',$data['class']);
                $data1=$_POST['data'];//////////////////////////////
                $i=0;
                foreach($data1 as $k=>$v){
                    foreach($v['subjectlist'] as $a=>$b){
                        $data2[$i]['examinationid']=$f1;
                        $data2[$i]['lastRecordTime']=time();
                        $data2[$i]['createTime']=time();
                        $data2[$i]['results']=$b['fullcredit'];
                        $data2[$i]['proportion']=$b['proportion'];
                        $data2[$i]['subject']=$b['subjectid'];
                        $data2[$i]['branchid']=$v['branchid'];
                        $data2[$i]['scId']=$scId;
                        $i++;
                    }
                }
                $f2=$dao->table('mks_examination_subject')->addAll($data2);
                $where['class'] = array('in',$class);
                $where['statu']="是";
                $where['scId']=$scId;
                $where['roleId']=parent::$studentRoleId;
                //$f3=$dao->table('mks_user')->where($where)->select();
                $sql2="SELECT u.`id`,c.`branch` FROM mks_user AS u,mks_class AS c WHERE statu='是' AND u.class IN(".$data['class'].") AND u.scId=".$data['scId']." AND u.roleId=".$where['roleId']." AND c.classid=u.class";
                $f3=$dao->query($sql2);
                foreach($f3 as $k=>$v){
                    $data3[$k]['id']=0;
                    $data3[$k]['userid']=$v['id'];
                    $data3[$k]['branch']=$v['branch'];
                    $data3[$k]['examinationid']=$f1;
                    $data3[$k]['lastRecordTime']=time();
                    $data3[$k]['createTime']=time();
                    $data3[$k]['scId']=$scId;
                }
                $f4=$dao->table('mks_examination_student')->addAll($data3);

                $sql5="SELECT c.`classname`,g.`name`,c.`branch` FROM `mks_grade` AS g,mks_class AS c WHERE c.`grade`=g.`gradeid` AND c.`classid` in(".$data['class'].")";
                $f5=$dao->query($sql5);
                $arrgrade=array('一年级','二年级','三年级','四年级','五年级','六年级','初一','初二','初三','高一','高二','高三');
                foreach($f5 as $k=>$v){
                    $key=$v['name']-1;
                    $arr7[$k]['room']=$arrgrade[$key]."(".$v['classname'].")";
                    $arr7[$k]['branch']=$v['branch'];
                    $arr7[$k]['examinationid']=$f1;
                    $arr7[$k]['lastRecordTime']=time();
                    $arr7[$k]['createTime']=time();
                    $arr7[$k]['scId']=$scId;
                }
                $f6=$dao->table('mks_examination_room')->addAll($arr7);
                if($f1===false || $f2===false || $f3===false || $f4===false || $f5===false || $f6===false){
                    M()->rollback();
                    $arr['return']=false;
                }else{
                    M()->commit();
                    $arr['return']=true;
                }
                $this->ajaxReturn($arr);
            }
        }
    }


/**********************************************考试管理******************************************************/

    public function exmanagement(){
        $getSession = $this->get_session('loginCheck',false);
        if(I('get.type')=='interface'){/******************考试管理界面*********************/
            if(I('get.typename')=='exselect'){/********************************考试列表********************************/
                $dao=M();
                $scId=$getSession['scId'];
                $sql="SELECT g.name,g.gradeid,e.examinationid,e.examination,e.release FROM mks_grade AS g,mks_examination AS e WHERE e.gradeid=g.gradeid and e.scId=".$scId;
                $data=$dao->query($sql);
                $where['scId']=$scId;
                $f1=$dao->query("SELECT COUNT(*) as num,examinationid FROM `mks_examination_number` WHERE scid=".$scId." GROUP BY examinationid");
                $f2=$dao->query("SELECT COUNT(*) as num,examinationid FROM `mks_examination_results` WHERE scid=".$scId." GROUP BY examinationid");
                foreach($f1 as $k=>$v){
                    $data1[$v['examinationid']]=$v['num'];
                }
                foreach($f2 as $k=>$v){
                    $data2[$v['examinationid']]=$v['num'];
                }
                if($data){
                    foreach($data as $k=>$v){
                        $arr[$v['name']]['name']=$v['name'];
                        $arr[$v['name']]['gradeid']=$v['gradeid'];
                        $arr1['examinationid']=$v['examinationid'];
                        $arr1['examination']=$v['examination'];
                        if($data1[$v['examinationid']]){
                            $arr1['number']=true;
                        }else{
                            $arr1['number']=false;
                        }
                        if($data2[$v['examinationid']]){
                            $arr1['import']=true;
                        }else{
                            $arr1['import']=false;
                        }
                        if($data1[$v['examinationid']]){
                            $arr1['number']=true;
                        }else{
                            $arr1['number']=false;
                        }
                        if($v['release']){
                            $arr1['release']=true;
                        }else{
                            $arr1['release']=false;
                        }
                        $arr[$v['name']]['ex'][]=$arr1;
                    }
                    $i=0;
                    foreach($arr as $k=>$v){
                        $arrn[$i]=$v;
                        $i++;
                    }
                }else{
                    $data=null;
                    $arrn=$data;
                }
                $this->ajaxReturn($arrn);
            }
        }elseif(I('get.type')=='exsubject'){/***************各科目考试时间*************************/
            if(I('get.typename')=='exsfind'){/***************考试科目查询*****************/
                $dao=M();
                $dao1=M('subject');
                $examinationid=I('post.examinationid');
                $scId=$getSession['scId'];
                $field=I('post.field');
                $order=I("post.order");
                if($order=='descing'){
                    $order='desc';
                }else{
                    $order='asc';
                }
                /*$limit=I("post.limit");
                $page=I('post.page');
                if(!$page){
                    $page=1;
                }
                if(!$limit){
                    $limit=2;
                }
                $limitstart=($page-1)*$limit;*/
                if(!$field){
                    $field='id';
                }
                if($field=='branch'){
                    $field='b.'.$field;
                }else{
                    $field='e.'.$field;
                }
                //$sql="SELECT e.id,e.subject,e.date,e.starttime,e.endtime,b.`branch` FROM `mks_examination_subject` AS e,`mks_class_branch` AS b WHERE e.`branchid`=b.`branchid` AND e.examinationid=".$examinationid." order by b.branch";
                $sql="SELECT e.id,e.subject,e.date,e.starttime,e.endtime,b.`branch` FROM `mks_examination_subject` AS e,`mks_class_branch` AS b WHERE e.`branchid`=b.`branchid` AND e.scId=".$scId." AND e.examinationid=".$examinationid." order by ".$field." ".$order;
                $data=$dao->query($sql);
                //$sql2="SELECT COUNT(e.`id`) FROM `mks_examination_subject` AS e,`mks_class_branch` AS b WHERE e.`branchid`=b.`branchid` AND e.examinationid=".$examinationid;
                //$data2=$dao->query($sql2);
                //$limitall=$data2['0']['COUNT(e.`id`)'];
                //$pageall=ceil($limitall/$limit);
                if($data){
                    foreach($data as $k=>$v){
                        $data[$k]['branch']=$v['branch'];
                        if(is_numeric($v['subject'])){
                            $where['subjectid']=$v['subject'];
                            $subject=$dao1->where($where)->select();
                            $data[$k]['subject']=$subject['0']['subjectname'];
                            $data[$k]['subjectid']=$v['subject'];
                        }
                        $data[$k]['subject']=$data[$k]['subject'];
                    }
                }
                if(empty($data)){
                    $arr=null;
                }
                if($data===false){
                    $arr=false;
                }
                $arr=$data;
                /*$arr['page']['pageall']=$pageall;
                $arr['page']['page']=$page;
                $arr['page']['count']=$limitall;*/
                $this->ajaxReturn($arr);
            }elseif(I('get.typename')=='exsupdate'){/********************************修改各科目考试时间*****************************/
                $dao=M('examination_subject');
                //$data=json_decode(urldecode($_GET['data']),true);
                //foreach($data as $k=>$v){
                    /*$m['return']=true;
                    $data1['id']=$v['id'];
                    $data2['date']=$v['date'];
                    $data2['starttime']=$v['starttime'];
                    $data2['endtime']=$v['endtime'];
                    $data2['lastRecordTime']=time();*/
                    if($_POST['id']){
                        $data1['id']=$_POST['id'];
                    }elseif($_POST['subjectid'] && $_POST['examinationid']){
                        $data1['subject'] =$_POST['subjectid'];
                        $data1['examinationid'] =$_POST['examinationid'];
                    }
                    $data1['scId']=$getSession['scId'];
                    $data2['date']=$_POST['date'];
                    $data2['starttime']=$_POST['starttime'];
                    $data2['endtime']=$_POST['endtime'];
                    $data2['lastRecordTime']=time();
                    $f=$dao->where($data1)->save($data2);
                    if($f===false){
                        $m['return']=false;
                    }else{
                        $m['return']=true;
                    }
                //}
                 $this->ajaxReturn($m);
            }elseif(I('get.typename')=='exsexport') {
                /***************考试科目考试时间导出*****************/
                $dao = M();
                $dao1 = M('subject');
                $examinationid = I('get.examinationid');
                $scId=$getSession['scId'];
                $sql = "SELECT e.subject,e.date,e.starttime,e.endtime,b.`branch` FROM `mks_examination_subject` AS e,`mks_class_branch` AS b WHERE e.`branchid`=b.`branchid` AND e.examinationid=" . $examinationid . " and e.scId=".$scId." order by b.branch";
                $data = $dao->query($sql);
                if ($data) {
                    foreach ($data as $k => $v) {
                        $data[$k]['branch'] = $v['branch'];
                        if (is_numeric($v['subject'])) {
                            $where['subjectid'] = $v['subject'];
                            $subject = $dao1->where($where)->select();
                            $data[$k]['subject'] = $subject['0']['subjectname'];
                        }
                        $data[$k]['subject'] = $data[$k]['subject'];
                    }
                }
                vendor("PHPExcel.PHPExcel");
                $objPHPExcel = new \PHPExcel();
                // Set properties
                $objPHPExcel->getProperties()->setCreator("cdn");
                $objPHPExcel->getProperties()->setLastModifiedBy("cdn");
                $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
                $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
                $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

// Add some data
                $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->setTitle('CDN');
                $objPHPExcel->getActiveSheet()->SetCellValue('A1', '科类');
                $objPHPExcel->getActiveSheet()->SetCellValue('B1', '科目');
                $objPHPExcel->getActiveSheet()->SetCellValue('C1', '考试日期');
                $objPHPExcel->getActiveSheet()->SetCellValue('D1', '开考时间');
                $objPHPExcel->getActiveSheet()->SetCellValue('E1', '结束时间');
                $objPHPExcel->getActiveSheet()->SetCellValue('F1', '考试时长（分钟）');
                $i = 2;
                foreach ($data as $k => $v) {
                    $num = $i++;
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $num, $v['branch']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $num, $v['subject']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $num, $v['date']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $num, $v['starttime']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $num, $v['endtime']);
                    $data1 = $v['date'] . " " . $v['starttime'];
                    $data2 = $v['date'] . " " . $v['endtime'];
                    $time1 = strtotime($data1);
                    $time2 = strtotime($data2);
                    $time = ($time2 - $time1) / 60;
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $num, $time);
                }
// Save Excel 2007 file
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                ob_end_clean();
                header("Content-Disposition:attachment;filename=tableExport.xls");
                header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');

                //print_r($data);
            }
        }elseif(I('get.type')=='confirm'){/***************学生参考确认*****************/
            if(I('get.typename')=='attendselect'){/************************学生参考确认情况查询********************************/
                $dao=M();
                $examinationid=I('post.examinationid');
                $dao1=M('subject');
                $scId=2;//$getSession['scId'];
                $screen=I('post.screen');
                if($screen){
                    $st="where a.branch like '%".$screen."%' or a.className like '%".$screen."%' or a.all like '%".$screen."%' or a.reported like '%".$screen."%' or a.unreported like '%".$screen."%' or a.participate like '%".$screen."%' or a.unparticipate like '%".$screen."%'";
                }

                $field=I('post.field');
                $order=I("post.order");
                if($order=='descing'){
                    $order='desc';
                }else{
                    $order='asc';
                }
                $limit=I("post.limit");
                $page=I('post.page');
                if(!$page){
                    $page=1;
                }
                if(!$field){
                    $field='branch,className';
                }
                if(!$limit){
                    $limit=2;
                }
                $limitstart=($page-1)*$limit;
                //$sql="select u.className,u.class,u.`name`,e.`reported`,e.`participate` FROM `mks_examination_student` AS e,`mks_user` AS u WHERE e.`userid`=u.`id` AND u.scId='".$scId."' AND e.`examinationid`='".$examinationid."' AND u.`roleId`=15 AND u.statu='是'";
                $sql="select * from (SELECT b.branch,u.className,COUNT(u.`name`) AS `all`,u.class,COUNT(e.`reported`='是' OR NULL) AS reported,COUNT(e.`reported`='否' OR NULL) AS unreported,COUNT(e.`participate`='是' OR NULL) AS participate,COUNT(e.`participate`='否' OR NULL) AS unparticipate FROM `mks_examination_student` AS e,`mks_user` AS u,mks_class_branch as b WHERE e.`userid`=u.`id` and e.scId=".$scId." and b.branchid=e.branch AND e.`examinationid`='".$examinationid."' GROUP BY u.`class`) as a $st order by a.".$field." ".$order." limit ".$limitstart.",".$limit;//查询相关数据并分页排序
                $sql1="select count(*) from (SELECT b.branch,u.className,COUNT(u.`name`) AS `all`,u.class,COUNT(e.`reported`='是' OR NULL) AS reported,COUNT(e.`reported`='否' OR NULL) AS unreported,COUNT(e.`participate`='是' OR NULL) AS participate,COUNT(e.`participate`='否' OR NULL) AS unparticipate FROM `mks_examination_student` AS e,`mks_user` AS u,mks_class_branch as b WHERE e.`userid`=u.`id` and e.scId=".$scId." and b.branchid=e.branch AND e.`examinationid`='".$examinationid."' GROUP BY u.`class`) as a $st";//总班级数
                //SELECT * FROM (SELECT u.className,u.class,COUNT(e.`reported`='是' OR NULL) AS reported,COUNT(e.`reported`='否' OR NULL) AS unreported,COUNT(e.`participate`='是' OR NULL) AS participate,COUNT(e.`participate`='否' OR NULL) AS unparticipate FROM `mks_examination_student` AS e,`mks_user` AS u WHERE e.`userid`=u.`id` AND e.`examinationid`='123' GROUP BY u.`class`) AS a WHERE a.reported=1//做模糊查询时用的sql

                $f=$dao->query($sql);
                $f1=$dao->query($sql1);

                //print_r($f);
                //exit;
                /*$data=array();
                foreach($f as $k=>$v){
                    if(!$data[$v['className']]['all']){
                        $data[$v['className']]['all']=0;
                    }
                    if(!$data[$v['className']]['participate']){
                        $data[$v['className']]['participate']=0;
                    }
                    if(!$data[$v['className']]['unparticipate']){
                        $data[$v['className']]['unparticipate']=0;
                    }
                    if(!$data[$v['className']]['reported']){
                        $data[$v['className']]['reported']=0;
                    }
                    if(!$data[$v['className']]['unreported']){
                        $data[$v['className']]['unreported']=0;
                    }
                    if($v['participate']=='是'){
                        $data[$v['className']]['participate']++;
                    }else{
                        $data[$v['className']]['unparticipate']++;
                    }
                    if($v['reported']=='是'){
                        $data[$v['className']]['reported']++;
                    }else{
                        $data[$v['className']]['unreported']++;
                    }
                    $data[$v['className']]['all']++;
                    $data[$v['className']]['class']=$v['class'];
                }*/
                //$al=explode(',',$f1['0']['class']);
                $i=0;
                if(empty($f)){
                    $data3['data']=null;
                }
                foreach($f as $k=>$v){
                    $data1[$i]=$v;
                    unset($data1[$i]['class']);
                    //$data1[$i]['className']=$k;
                    $sql="select u.name from mks_class as c,mks_user as u where c.classid=".$v['class']." and c.userid=u.id";
                    $data2=$dao->query($sql);
                    $data1[$i]['teacher']=$data2['0']['name'];
                    $data3['data'][$i]=$data1[$i];
                    $i++;
                }
                $data3['page']['page']=$page;
                $data3['page']['pageall']=ceil($f1['0']['count(*)']/$limit);
                $data3['page']['count']=$f1['0']['count(*)'];
                /*if($order=='ascending' || !$order){
                    $order=false;
                }else{
                    $order=true;
                }
                $data2=$this->sortArrByOneField($data1,$field,$order);
                $li1=$limitstart;
                $li2=$limitstart+$limit;
                for($i=$li1;$i<$li2;$i++){
                    if($data2[$i]){
                        $data3[]=$data2[$i];
                    }
                }
                foreach($data3 as $k=>$v){
                    $data3[$k]['teacher']=urlencode($v['teacher']);
                }
                $pageall=ceil(count($data2)/$limit);
                $data3['page']['page']=$page;
                $data3['page']['$pageall']=$pageall;*/
                $this->ajaxReturn($data3);
            }elseif(I('get.typename')=='exclass'){/*******************************学生参考确认班级查询（修改时查询）**********************************************/
                $dao1=M('examination');
                $examinationid['examinationid']=I('post.examinationid');
                $examinationid['scId']=$getSession['scId'];
                $data=$dao1->where($examinationid)->select();
                $class=explode(',',$data['0']['class']);
                $where['classid'] = array('in',$class);
                $where['scId'] =$getSession['scId'];
                $dao2=M('class');
                $data2=$dao2->where($where)->field('classid,classname')->select();
                foreach($data2 as $k=>$v){
                    $data2[$k]['classname']=$v['classname'];
                }
                $this->ajaxReturn($data2);
            }elseif(I('get.typename')=='attend'){/*******************************学生参考确认查询（修改时查询）**********************************************/
                $dao=M();
                $scId=$getSession['scId'];//$getSession['scId'];
                $classid=I('post.classid');
                $examinationid=I('post.examinationid');
                $screen=I('post.screen');
                $field=I('post.field');
                $order=I("post.order");
                if($order=='descing'){
                    $order='desc';
                }else{
                    $order='asc';
                }
                $limit=I("post.limit");
                $page=I('post.page');
                if(!$page){
                    $page=1;
                }
                if(!$limit){
                    $limit=2;
                }
                $limitstart=($page-1)*$limit;
                if(!$field){
                    $field='u.id';
                }else{
                    if($field=='participate' || $field=='reported'){
                        $field='s.'.$field;
                    }else{
                        $field='u.'.$field;
                    }
                }
                if($screen){
                    $st="and (u.className like '%".$screen."%' or u.serialNumber like '%".$screen."%' or u.sex like '%".$screen."%' or u.name like '%".$screen."%' or s.`participate` like '%".$screen."%' or s.`reported` like '%".$screen."%')";
                }
                $roleId=parent::$studentRoleId;
                $sql="select s.id,u.`className`,u.serialNumber,u.`sex`,u.`name`,s.`participate`,s.`reported` from `mks_examination_student` as s,mks_user as u where s.scId=".$scId." and u.`class` in(".$classid.") and u.`roleId`=".$roleId." and u.statu='是' and s.userid=u.`id` and s.examinationid=".$examinationid." $st order by ".$field." ".$order." limit ".$limitstart.",".$limit;
                $sql2="select count(s.id) from `mks_examination_student` as s,mks_user as u where s.scId=".$scId." and u.`class` in(".$classid.") and u.`roleId`=".$roleId." and u.statu='是' and s.userid=u.`id` and s.examinationid=".$examinationid." $st";
                //exit;
                $data=$dao->query($sql);
                $data2=$dao->query($sql2);
                if(!$data){

                }
                $pageall=ceil($data2['0']['count(s.id)']/$limit);
                foreach($data as $k=>$v){
                    $data[$k]['id']=$v['id'];
                    $data[$k]['className']=$v['className'];
                    $data[$k]['serialNumber']=$v['serialNumber'];
                    $data[$k]['sex']=$v['sex'];
                    $data[$k]['name']=$v['name'];
                    $data[$k]['participate']=$v['participate'];
                    $data[$k]['reported']=$v['reported'];
                    $data1['data'][$k]=$data[$k];
                }
                if($data){
                    $data1['page']['page']=$page;
                    $data1['page']['pageall']=$pageall;
                    $data1['page']['count']=$data2['0']['count(s.id)'];
                }elseif(empty($data)){
                    $data1['data']=null;
                }

                $this->ajaxReturn($data1);
            }elseif(I('get.typename')=='attendupdate'){/********************学生参考确认（修改)****************************************/
                $dao=M('examination_student');
                $data=$_POST['data'];
                //$where['examinationid']=I('get.examinationid');
                foreach($data as $k=>$v){
                    $where['id']=$v['id'];
                    $where['scId']=$getSession['scId'];
                    $data1['reported']=$v['reported'];
                    $data1['participate']=$v['participate'];
                    $f=$dao->where($where)->save($data1);
                }
                if($f===false){
                    $arr['return']=false;
                }else{
                    $arr['return']=true;
                }
                $this->ajaxReturn($arr);
            }elseif(I('get.typename')=='participateupdate') {
                /********************学生参考确认（全部参考，全部不参考，全部上报，全部不上报)****************************************/
                $field = I('post.field');
                $where['examinationid'] = I('post.examinationid');
                $where['scId']=$getSession['scId'];
                $dao = M('examination_student');
                if ($field == 'reported') {
                    $data['reported'] = '是';
                } elseif ($field == 'unreported') {
                    $data['reported'] = '否';
                } elseif ($field == 'participate') {
                    $data['participate'] = '是';
                } elseif ($field == 'unparticipate') {
                    $data['participate'] = '否';
                }
                $f = $dao->where($where)->save($data);
                if ($f === false) {
                    $arr['return'] = false;
                } else {
                    $arr['return'] = true;
                }
                $this->ajaxReturn($arr);
            }
        }elseif(I('get.type')=='examroom'){/*******************************考场分配*******************************/
            if(I('get.typename')=='roomselect'){/*******************************考场列表*******************************/
                $where['examinationid']=I('post.examinationid');

                $scId['scId']=$getSession['scId'];
                $where['scId']=$scId['scId'];
                $dao=M('examination_room');

                $field=I('post.field');
                $order=I("post.order");
                if($order=='descing'){
                    $order='desc';
                }else{
                    $order='asc';
                }
                $limit=I("post.limit");
                $page=I('post.page');
                if(!$page){
                    $page=1;
                }
                if(!$limit){
                    $limit=1;
                }
                $limitstart=($page-1)*$limit;
                if(!$field){
                    $field='id';
                }
                $order="".$field." ".$order."";
                $f=$dao->where($where)->field('id,branch,room,seats,columns,status')->order($order)->page($page,$limit)->select();
                $f2=$dao->where($where)->count();
                $pageall=ceil($f2/$limit);
                $daon=M('class_branch');
                $fn=$daon->where($scId)->field('branch,branchid')->select();
                //$arrgrade=array('一年级','二年级','三年级','四年级','五年级','六年级','七年级','八年级','九年级','十年级','十一年级','十二年级');
                foreach($fn as $k=>$v){
                    $fn[$k]['branch']=$v['branch'];
                }
                $dao2=M('examination_student');
                //$where['participate']=1;
                $sql="SELECT COUNT(s.branch) as num,b.branch FROM `mks_examination_student` AS s,`mks_class_branch` AS b WHERE s.examinationid='".$where['examinationid']."' AND s.participate='是' AND s.`branch`=b.`branchid` GROUP BY s.branch";
                $arra=$dao2->query($sql);
                $sql2="SELECT COUNT(s.room) as num,b.branch,SUM(s.`seats`) as numb FROM `mks_examination_room` AS s,`mks_class_branch` AS b WHERE s.examinationid='".$where['examinationid']."' AND s.`branch`=b.`branchid` GROUP BY s.branch";
                $arrb=$dao2->query($sql2);
                $all=0;
                foreach($arra as $k=>$v){
                    $all+=$v['num'];
                    $arrmc['date'][$k]['branch']=$v['branch'];
                    $arrmc['date'][$k]['num']=$v['num'];
                }
                $key=count($arra);
                $arra[$key]['branch']='all';
                $arrmc['all']=$all;
                $allc=0;
                $alld=0;
                foreach($arrb as $k=>$v){
                    $allc+=$v['num'];
                    $alld+=$v['numb'];
                    $arrb[$k]['branch']=$v['branch'];
                }
                foreach($arrb as $k=>$v){
                    $arrcb['data'][$k]['branch']=$v['branch'];
                    $arrcb['data'][$k]['num']=$v['num'];
                    $arrdv['data'][$k]['branch']=$v['branch'];
                    $arrdv['data'][$k]['num']=$v['numb'];
                }
                $key=count($arrc);
                $arrc[$key]['branch']='all';
                $arrcb['all']=$allc;

                $key=count($arrd);
                $arrd[$key]['branch']='all';
                $arrdv['all']=$alld;

                //$dao1=M('');
                //$sql1="SELECT class FROM `mks_examination` WHERE `examinationid`=".$where['examinationid'];
                //$f1=$dao1->query($sql1);
                /*if(!$f){
                    $sql2="SELECT c.`classname`,g.`name`,c.`branch` FROM `mks_grade` AS g,mks_class AS c WHERE c.`grade`=g.`gradeid` AND c.`classid` in(".$f1['0']['class'].")";
                    $f2=$dao1->query($sql2);
                        foreach($f2 as $k=>$v){
                            $key=$v['name']-1;
                            $arr2['roomlist'][$k]['room']=urlencode($arrgrade[$key]."(".$v['classname'].")");
                            //$arr2['roomlist'][$k]['seats']='';
                            $arr2['roomlist'][$k]['columns']='';
                            $arr2['roomlist'][$k]['status']=0;
                            $arr2['roomlist'][$k]['seat']='';
                            $arr2['roomlist'][$k]['branch']=urlencode($v['branch']);
                        }
                        $arr2['branchlist']=$fn;
                        $arr2['attend']=$arra;
                    //$arr2['situation']['students']=$f3;
                    echo urldecode(json_encode($arr2));
                }else{*/
                    foreach($f as $k=>$v){
                        foreach($fn as $y=>$z){
                            if($v['branch']==$z['branchid']){
                                $v['branch']=urldecode($z['branch']);
                            }
                        }
                        foreach($v as $m=>$n){
                            $arrm['roomlist'][$k][$m]=$n;
                        }
                    }
                    $arrm['branchlist']=$fn;
                    $arrm['attend']=$arrmc;
                    $arrm['room']=$arrcb;
                    $arrm['seats']=$arrdv;
                    $arrm['page']['page']=$page;
                    $arrm['page']['pageall']=$pageall;
                    $arrm['page']['count']=$f2;
                    //$arrm['situation']['students']=$f3;
                    $this->ajaxReturn($arrm);
                //}
            }elseif(I('get.typename')=='exroom'){/************************************可用的考场模板****************************************/
                $dao=M('examination_room');
                $gradeid=I('post.gradeid');
                $sql="SELECT e.examinationid,e.`examination` FROM `mks_examination_room` AS r,`mks_examination` AS e WHERE e.`examinationid`=r.`examinationid` AND e.`gradeid`=".$gradeid." GROUP BY e.examinationid";
                $data=$dao->query($sql);
                if(empty($data)){
                    $data=null;
                }
                $this->ajaxReturn($data);
            }elseif(I('get.typename')=='roomupin'){/********************************修改添加考场信息*************************************/
                $dao=M('examination_room');
                $examinationid=I('post.examinationid');
                $scId=$getSession['scId'];
                //$data=json_decode(urldecode($_GET['data']),true);
                $f3=true;
                //foreach($data as $k=>$v){
                    //$data[$k]['examinationid']=$examinationid;
                    if($_POST['id']){
                        $id['id']=$_POST['id'];
                        $id['scId']=$scId;
                        $datam['branch']=$_POST['branchid'];
                        $datam['room']=$_POST['room'];
                        $datam['seats']=$_POST['seats'];
                        $datam['status']=0;
                        $datam['columns']=$_POST['columns'];
                        $datam['lastRecordTime']=time();
                        $f2=$dao->where($id)->save($datam);
                        if($f2===false){
                            $f3=false;
                        }
                    }else{
                        $datam['branch']=$_POST['branchid'];
                        $datam['scId']=$scId;
                        $datam['room']=$_POST['room'];
                        $datam['seats']=$_POST['seats'];
                        $datam['columns']=$_POST['columns'];
                        $datam['lastRecordTime']=time();
                        $datam['createTime']=time();
                        $datam['examinationid']=$examinationid;
                        $f1=$dao->data($datam)->add();
                    }
                //}
                if($f1===false){
                    $f3=false;
                }
                $arr['return']=$f3;
                $this->ajaxReturn($arr);
            }elseif(I('get.typename')=='roomseatfind'){/***********************当前考场座位布局**********************/
                $id['roomid']=I('post.id');
                $id['scId']=$getSession['scId'];
                $dao=M('examination_seat');
                $f=$dao->where($id)->field('seatRow,seatCol,seatNumber')->select();
                $this->ajaxReturn($f);
            }elseif(I('get.typename')=='roomseatup'){/****************************保存当前考场设置的座位布局****************/
                M()->startTrans();
                $id=$_POST['id'];
                $roomid=I('post.roomid');
                $where['roomid']=array('in',$id);
                $scId=$getSession['scId'];
                $where1['id']=array('in',$id);
                $where1['scId']=$scId;
                $where['examinationid']=I('post.examinationid');
                $where['scId']=$scId;
                $where2['id']=$roomid;
                //$seat2=json_decode($_POST['seat']);
                $seat=$_POST['seat'];
                foreach($id as $a=>$b){
                    foreach($seat as $k=>$v){
                        $seat[$k]['examinationid']=I('post.examinationid');
                        $seat[$k]['roomid']=$b;
                        $seat[$k]['scId']=$scId;
                        $seatall[]=$seat[$k];
                    }
                }
                $dao1=M('examination_room');
                $f5=$dao1->field('seats,columns')->where($where2)->select();
                $dao=M('examination_seat');
                $f1=$dao->where($where)->delete();
                $f2=$dao->addAll($seatall);

                $seat1['lastRecordTime']=time();
                $seat1['status']=1;
                $seat1['seats']=$f5['0']['seats'];
                $seat1['columns']=$f5['0']['columns'];
                $f=$dao1->where($where1)->data($seat1)->save();
                if($f1===false || $f===false || $f2===false || $f5===false){
                    $arrj['return']=false;
                    M()->rollback();
                }else{
                    M()->commit();
                    $arrj['return']=true;
                }
                $this->ajaxReturn($arrj);
            }elseif(I('get.typename')=='seatroom'){/************************座位布局中可选的考场***************/
                $dao=M('examination_room');
                $scId=$getSession['scId'];
                $where['examinationid']=I('post.examinationid');
                $where['scId']=$scId;
                $f=$dao->where($where)->field('room,id')->select();
                foreach($f as $k=>$v){
                    $f[$k]['room']=$v['room'];
                }
                $this->ajaxReturn($f);
            }elseif(I('get.typename')=='roomseatupall'){/***********************************同步并修改考场座位布局***********************************/
                M()->startTrans();
                $dao=M('examination_room');
                $scId=$getSession['scId'];
                $id['id']=I('post.id');
                $id['scId']=$scId;
                $idall=I('post.idall');
                $f1=$dao->field('seats,columns')->where($id)->select();
                $f1['0']['status']=1;
                $f1['0']['lastRecordTime']=time();
                $ida=explode(',',$idall);
                $dao3=M('examination_seat');
                $where3['roomid']=$id['id'];
                $where3['scId']=$scId;
                $f3=$dao3->where($where3)->field('seatRow,seatCol,seatNumber,scId,examinationid')->select();
                foreach($ida as $k=>$v){
                    foreach($f3 as $m=>$n){
                        $n['roomid']=$v;
                        $arr[]=$n;
                    }
                }
                $where6['roomid']=array('in',$ida);
                $where6['scId']=$scId;
                $f5=$dao3->where($where6)->delete();
                $f4=$dao3->addAll($arr);
                $where5['id']=array('in',$ida);
                $where5['scId']=$scId;
                $f2=$dao->where($where5)->save($f1['0']);
                if($f1===false || $f2===false || $f3===false || $f4===false || $f5===false){
                    $arrj['return']=false;
                    M()->rollback();
                }else{
                    M()->commit();
                    $arrj['return']=true;
                }
                echo json_encode($arrj);
            }elseif(I('get.typename')=='roomdel'){/***********************************删除考场***********************************/
                M()->startTrans();
                $scId=$getSession['scId'];
                $dao1=M('examination_room');
                $dao2=M('examination_seat');
                //$id=json_decode($_GET['id'],true);
                $id=explode(',',I('post.id'));
                $where1['id']=array('in',$id);
                $where1['scId']=$scId;
                $where2['roomid']=array('in',$id);
                $where2['scId']=$scId;
                $f1=$dao1->where($where1)->delete();
                $f2=$dao2->where($where2)->delete();
                if($f1===false || $f2===false){
                    M()->rollback();
                    $arr['return']=false;
                }else{
                    M()->commit();
                    $arr['return']=true;
                }
                $this->ajaxReturn($arr);
            }
        }elseif(I('get.type')=='exnumber'){/**************考号设置************/
            if(I('get.typename')=='exnumberfind'){/*****************考号查询*********************/
                $gradeid=I('post.gradeid');
                $program=I('post.program');
                $examinationid=I('post.examinationid');
                $screen=I('post.screen');
                $scId=2;//$getSession['scId'];
                $find=I('post.find');
                $where['gradeId']=I('post.gradeid');
                $where1['examinationid']=I('post.examinationid');
                $where1['scId']=$scId;
                $where['scId']=$scId;
                $where['roleId']=parent::$studentRoleId;
                $where['statu']="是";
                $limit=I('post.limit');
                if(!$limit){
                    $limit=2;
                }
                $page=I('post.page');
                if(!$page){
                    $page=1;
                }
                if($screen){
                    if($find=="考号调用"){
                        $st=" and u.name like '%".$screen."%'";
                    }else{
                        $st=" and name like '%".$screen."%'";
                    }
                }
                $limitstart=($page-1)*$limit;
                $field=I('post.field');
                if(!$field){
                    if($find=="考号调用"){
                        $field='className,u.serialNumber';
                    }else{
                        $field='className,serialNumber';
                    }
                }
                $order=I("post.order");
                if($order=='descing'){
                    $order='desc';
                }else{
                    $order='asc';
                }
                $dao1=M('examination_number');
                $dao2=M('user');
                $dao3=M('examination_student');
                //$sql1="SELECT u.`name`,u.`className`,u.`serialNumber`,u.`id`,n.`number` FROM mks_user AS u,mks_examination_number AS n WHERE u.id=n.`userid` AND u.`roleId`=15 AND n.`program`=".$program." and n.gradeid=".$gradeid;
                //$f1=$dao1->query($sql1);
                if($find=="考号调用"){
                    $sql2="SELECT u.name,u.className,u.serialNumber,u.id FROM mks_user as u,mks_examination_student as s where u.id=s.userid and s.scId=".$scId." and s.participate='是' and s.examinationid=".$examinationid.$st." order by u.".$field." ".$order." limit ".$limitstart.",".$limit;
                    $sql5="SELECT count(*) as num FROM mks_user as u,mks_examination_student as s where u.id=s.userid and s.scId=".$scId." and s.participate='是' and s.examinationid=".$examinationid.$st;
                }else{
                    $sql2="SELECT name,className,serialNumber,id FROM mks_user where gradeId=".$gradeid." and scId=".$scId." and `roleId`=".$where['roleId'].$st." and statu='是' order by ".$field." ".$order." limit ".$limitstart.",".$limit;
                    $sql5="SELECT count(*) as num FROM mks_user where gradeId=".$gradeid." and scId=".$scId." and `roleId`=".$where['roleId'].$st." and statu='是'";
                }
                $f2=$dao2->query($sql2);
                $f6=$dao2->query($sql5);
                if(empty($f2)){
                    $data['data']=null;
                }
                foreach($f2 as $k=>$v){
                    if($program=="本次考试"){
                        $sql1="select id,number from mks_examination_number where userid=".$v['id']." and scId=".$scId." and program='".$program."' and examinationid=".$examinationid;
                    }else{
                        $sql1="select id,number from mks_examination_number where userid=".$v['id']." and scId=".$scId." and program='".$program."'";
                    }
                    $f1=$dao1->query($sql1);
                    $f2[$k]['name']=$v['name'];
                    $f2[$k]['className']=$v['className'];
                    $f2[$k]['number']=$f1['0']['number'];
                    $f2[$k]['id']=$f1['0']['id'];
                    $f2[$k]['userid']=$v['id'];
                    $data['data'][$k]=$f2[$k];
                }
                if($find=="考号调用"){
                    $where1['participate']='是';
                    $f3=$dao3->where($where1)->count();
                    $sql3="SELECT COUNT(*) as num FROM `mks_examination_student` AS s,`mks_examination_number` AS n WHERE s.`participate`='是' AND n.`program`='".$program."' AND s.`examinationid`=".$examinationid." AND s.`userid`=n.`userid` and s.scId=".$scId." AND n.`number`!=''";
                    $f5=$dao1->query($sql3);
                    $f4=$f5['0']['num'];
                }else{
                    $f3=$dao2->where($where)->count();
                    unset($where1['examinationid']);
                    $where1['program']=$program;
                    $where1['number']=array('neq','');;
                    $f4=$dao1->where($where1)->count();
                }
                $data['page']['page']=$page;
                $data['page']['pageall']=ceil($f6['0']['num']/$limit);
                $data['page']['count']=$f6['0']['num'];
                $data['num']['student']=$f3;
                $data['num']['number']=$f4;
                $this->ajaxReturn($data);
            }elseif(I('get.typename')=='exnumberinsert') {/***************************考号管理生成考号*********************************/
                $prefix = I('post.prefix');
                $rule = I('post.rule');
                $where['scId'] =$getSession['scId'];
                $where['gradeId'] = I('post.gradeid');
                $where['roleId'] = parent::$studentRoleId;
                $where['statu'] = "是";
                $where1['gradeid'] = I('post.gradeid');
                $where1['program'] = I('post.program');
                $program = I('post.program');
                $dao1 = M('user');
                $f1 = $dao1->where($where)->field('id,className,serialNumber,number')->select();
                $dao2 = M('examination_number');
                $f2 = $dao2->where($where1)->delete();
                if($f2 !== false) {
                    if ($rule == 1) {
                        foreach ($f1 as $k => $v) {
                            $data[$k]['userid'] = $v['id'];
                            $data[$k]['gradeid'] = I('post.gradeid');
                            $data[$k]['program'] = $program;
                            $data[$k]['number'] = $prefix . $v['number'];
                            $data[$k]['scId'] =$getSession['scId'];
                            $data[$k]['lastRecordTime'] = time();
                            $data[$k]['createTime'] = time();
                        }
                    } elseif ($rule == 2) {
                        foreach ($f1 as $k => $v) {
                            $data[$k]['userid'] = $v['id'];
                            $data[$k]['gradeid'] = I('post.gradeid');
                            $data[$k]['program'] = $program;
                            $data[$k]['number'] = $prefix . $v['className'] . $v['serialNumber'];
                            $data[$k]['scId'] =$getSession['scId'];
                            $data[$k]['lastRecordTime'] = time();
                            $data[$k]['createTime'] = time();
                        }
                    } elseif ($rule == 3) {
                        foreach ($f1 as $k => $v) {
                            $data[$k]['userid'] = $v['id'];
                            $data[$k]['gradeid'] = I('post.gradeid');
                            $data[$k]['program'] = $program;
                            $data[$k]['number'] = $v['className'] . $v['serialNumber'];
                            $data[$k]['scId'] =$getSession['scId'];
                            $data[$k]['lastRecordTime'] = time();
                            $data[$k]['createTime'] = time();
                        }
                    }
                    $f3 = $dao2->addAll($data);
                    if($f3===false){
                        $arrm['return']=false;
                    }else{
                        $arrm['return']=true;
                    }
                    $this->ajaxReturn($arrm);
                }
            }elseif(I('get.typename')=='exnumberupin'){/************************考号管理修改添加考号******************************/
                $where1['id'] = I('post.id');
                $where1['scId'] = $getSession['scId'];
                $data1['number']=I('post.number');
                $data1['lastRecordTime']=time();
                $data2['program'] = I('post.program');
                $data2['gradeid'] = I('post.gradeid');
                $data2['scId'] = $getSession['scId'];
                $data2['number'] = I('post.number');
                $data2['userid'] = I('post.userid');
                $data2['lastRecordTime'] = time();
                $data2['createTime'] = time();
                $dao=M("examination_number");
                if($where1['id']){
                    $f1=$dao->where($where1)->save($data1);
                }else{
                    $f1=$dao->data($data2)->add();
                }
                if($f1===false){
                    $arr['return']=false;
                }else{
                    $arr['return']=true;
                }
                $this->ajaxReturn($arr);
            }elseif(I('get.typename')=='exnumberdel'){/******************清空考号******************/
                $where1['gradeid']=I('post.gradeid');
                $where1['program']=I('post.program');
                $dao=M("examination_number");
                $f=$dao->where($where1)->delete();
                if($f===false){
                    $arr['return']=false;
                }else{
                    $arr['return']=true;
                }
                $this->ajaxReturn($arr);
            }elseif(I('get.typename')=='exnumberexport'){/****************导出考号模板********************/
                $http = new \Org\Net\Http;
                //ob_end_clean();
                //$filename = "./Public/upload/exam/numberTemplate.xls";
                header('Location: http://localhost/school/Public/upload/exam/numberTemplate.xls');
                //$showname=" 导入学生考号模板.xls";
                $http->download($filename, $showname);

            }elseif(I('get.typename')=='export'){/****************导出考号********************/
                //if(){}
                $scId=$getSession['scId'];
                $dao=M();
                $program=I('get.program');
                $examinationid=I('get.examinationid');
                $gradeid=I('get.gradeid');
                if($program=='本次考试'){
                    $program='本次考试考号';
                    $sql1="SELECT u.name,u.className,u.serialNumber,s.number FROM mks_user AS u,mks_examination_number AS s WHERE u.id=s.userid AND s.scId=".$scId." AND s.examinationid=".$examinationid." order by u.className,u.serialNumber";
                }else{
                    $sql1="SELECT u.name,u.className,u.serialNumber,s.number FROM mks_user AS u,mks_examination_number AS s WHERE u.id=s.userid AND s.scId=".$scId." AND s.gradeid=".$gradeid." and program='".$program."' order by u.className,u.serialNumber";
                }

                $data=$dao->query($sql1);

                vendor("PHPExcel.PHPExcel");
                $objPHPExcel = new \PHPExcel();
                // Set properties
                //$objPHPExcel->getProperties()->setCreator("cdn");
                //$objPHPExcel->getProperties()->setLastModifiedBy("cdn");
                $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
                $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
                $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

// Add some data
                $objPHPExcel->setActiveSheetIndex(0);
                //$objPHPExcel->getActiveSheet()->setTitle('CDN');
                $objPHPExcel->getActiveSheet()->SetCellValue('A1', '班级');
                $objPHPExcel->getActiveSheet()->SetCellValue('B1', '班级座号');
                $objPHPExcel->getActiveSheet()->SetCellValue('C1', '学生姓名');
                $objPHPExcel->getActiveSheet()->SetCellValue('D1', $program);
                $i = 2;
                foreach ($data as $k => $v) {
                    $num = $i++;
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $num, $v['className']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $num, $v['serialNumber']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $num, $v['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $num, $v['number']);
                }
// Save Excel 2007 file
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                ob_end_clean();
                header("Content-Disposition:attachment;filename=tableExport.xls");
                header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');




            }elseif(I('get.typename')=='exnumbereimport'){/****************导入学生考号********************/
                if (!empty($_FILES)) {
                    $upload = new \Think\Upload();
                    $upload->maxSize   =     3145728 ;// 设置附件上传大小
                    $upload->exts      =     array('xlsx', 'xls');// 设置附件上传类型
                    $upload->rootPath  =     './'; // 设置附件上传根目录
                    $upload->savePath  =     'Public/upload/exam/'; // 设置附件上传（子）目录
                    $upload->replace  =     true; // 设置附件是否替换
                    //$upload->savePath  =     'cdr/'; // 设置附件上传（子）目录
                    $upload->saveName = 'numberInformation';
                    $upload->autoSub = false;
                    $info   =   $upload->uploadOne($_FILES['photo']);
                    if(!$info) {// 上传错误提示错误信息
                        $arr['result']=false;
                        return $arr;
                    }
                    $string =$_FILES['photo']['name'];
                    $arraym = explode('.',$string);
                    $exs=$arraym[count($arraym)-1];
                    vendor("PHPExcel.PHPExcel");
                    //$objPHPExcel = new \PHPExcel();
                    if($exs=='xls') {
                        $reader = \PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
                        $PHPExcel = $reader->load("./Public/upload/exam/numberInformation.xls"); // 载入excel文件
                    }else{
                        $reader = \PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
                        $PHPExcel = $reader->load("./Public/upload/exam/numberInformation.xlsx"); // 载入excel文件
                    }
                    $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
                    $highestRow = $sheet->getHighestRow(); // 取得总行数
                    $highestColumm = $sheet->getHighestColumn(); // 取得总列数
                    $row = 1;
                    for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
                        $value = $sheet->getCell($column . $row)->getValue();
                        if ($value == '') {
                            continue;
                        }
                        $value=strtr($value,array(' '=>''));
                        $dataset[$column] = $value;//表头字段
                        //echo $column.$row.":".$sheet->getCell($column.$row)->getValue()."<br />";
                    }
                    $dataset1 = array();
                    for ($row = 2; $row <= $highestRow; $row++) {//行数是以第1行开始
                        for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
                            $value = $sheet->getCell($column . $row)->getValue();
                            if ($value === '') {
                                continue;
                            }
                            $dataset1[$column] = $value;
                            //echo $column.$row.":".$sheet->getCell($column.$row)->getValue()."<br />";
                        }
                        if (empty($dataset1)) {
                            continue;
                        }
                        $dataset2[] = $dataset1;
                    }
                    $array = array();
                    foreach ($dataset2 as $k => $v) {
                        foreach ($v as $m => $n) {
                            foreach ($dataset as $o => $p) {
                                if ($m == $o &&$p!='序号') {
                                    $array[$p] = $n;
                                    break;
                                }
                            }
                        }
                        $array1[]=$array;
                    }
                    if($exs=='xls') {
                        unlink('./Public/upload/exam/numberInformation.xls');
                    }else{
                        unlink('./Public/upload/exam/numberInformation.xlsx');
                    }
                    $dao1 = M('user');
                    $where['scId'] = $getSession['scId'];
                    $where['gradeId'] = I('post.gradeid');

                    $where['roleId'] = parent::$studentRoleId;
                    $where['statu'] = "是";
                    $f1 = $dao1->where($where)->field('id,className,name')->select();
                    foreach($array1 as $k=>$v){
                        $data[$v['班级']][$v['姓名']]=$v['考号'];
                    }
                    foreach($f1 as $k=>$v){
                        $fn[$k]['number']=$data[$v['className']][$v['name']];
                        $fn[$k]['userid']=$v['id'];
                        $fn[$k]['program']=I('post.program');
                        $fn[$k]['gradeid']=I('post.gradeid');
                        $fn[$k]['scId']=$getSession['scId'];
                        $fn[$k]['lastRecordTime']=time();
                        $fn[$k]['createTime']=time();
                    }
                    $where1['scId'] = $getSession['scId'];
                    $where1['gradeid'] = I('post.gradeid');
                    $where1['program']=I('post.program');
                    $dao2=M('examination_number');
                    $f2=$dao2->where($where1)->delete();
                    if($f2!==false){
                        $f3=$dao2->addAll($fn);
                    }
                    if($f3===false){
                        $arr['return']=false;
                    }else{
                        $arr['return']=true;
                    }
                    $this->ajaxReturn($arr);
                }else{
                    $arr['result']=false;
                    $this->ajaxReturn($arr);
                }
            }elseif(I('get.typename')=='examnumberin'){/*********************调用考号生成本次考试考号*********************/
                $scId=$getSession['scId'];
                $where1['gradeid']=I('post.gradeid');
                $where1['program']=I('post.program');
                $where1['scId']=$scId;
                $where2['examinationid']=I('post.examinationid');
                $where2['scId']=$scId;
                $where3['examinationid']=I('post.examinationid');
                $where3['scId']=$scId;
                $where2['participate']="是";
                $dao1=M('');
                M()->startTrans();
                $f1=$dao1->table('mks_examination_number')->field('userid,number')->where($where1)->select();
                $f2=$dao1->table('mks_examination_student')->field('userid')->where($where2)->select();
                $f3=$dao1->table('mks_examination_number')->where($where3)->delete();
                foreach($f1 as $k=>$v){
                    $arr[$v['userid']]=$v['number'];
                }
                foreach($f2 as $k=>$v){
                    $f2[$k]['number']=$arr[$v['userid']];
                    $f2[$k]['gradeid']=I('post.gradeid');
                    $f2[$k]['program']="本次考试";
                    $f2[$k]['scId']=$getSession['scId'];
                    $f2[$k]['examinationid']=I('post.examinationid');
                    $f2[$k]['lastRecordTime']=time();
                    $f2[$k]['createTime']=time();
                }
                $f4=$dao1->table('mks_examination_number')->addAll($f2);
                if($f1===false || $f2===false || $f3===false || $f4===false){
                    M()->rollback();
                    $a['return']=false;
                }else{
                    M()->commit();
                    $a['return']=true;
                }
                $this->ajaxReturn($a);
            }
        }elseif(I('get.type')=='invigilatortask') {
            /*******************************监考任务****************************/
            if (I('get.typename') == 'examteacher') {
                /********************************监考任务查询*************************************/
                $data['examinationid'] = I('post.examinationid');
                $data['status'] = 1;
                $dao = M('examination_room');
                $f = $dao->where($data)->count();
                if ($f) {
                    $arrall['room'] = true;
                } else {
                    $arrall['room'] = false;
                }
                $dao1=M('user');
                $roleId1=parent::$studentRoleId;
                $roleId2=parent::$jZroleId;
                $where1['roleId']=array('neq',$roleId1);
                $where1['roleId']=array('neq',$roleId2);
                $scId=$getSession['scId'];
                $where1['scId']=$scId;
                $f1=$dao1->field('id,name,grade,class,teachingSubjects,roleId')->where($where1)->select();
                $dao2=M('examination_teacher');
                $where2['examinationid']=I('post.examinationid');
                $where2['scId']=$scId;
                $f2=$dao2->where($where2)->field('id,userid,invigilator,visits,totalinspection,arrange')->select();
                $dao3=M('');
                $sql3="SELECT c.`classid`,b.`branch`,c.userid FROM mks_class AS c,mks_class_branch AS b WHERE c.`branch`=b.`branchid` and scId=".$scId;
                $f3=$dao3->query($sql3);
                foreach($f3 as $k=>$v){
                    $data3[$v['classid']]=$v['branch'];
                }
                foreach($f3 as $k=>$v){
                    $data2[$v['userid']]=true;
                }
                foreach($f1 as $k=>$v){
                    $arr1[$k]['branch']=$data3[$v['class']];
                    $arr1[$k]['name']=$v['name'];
                    $arr1[$k]['grade']=$v['grade'];
                    $arr1[$k]['teachingSubjects']=$v['teachingSubjects'];
                    $arr1[$k]['userid']=$v['id'];
                    if($v['roleId']!=parent::$teacherRoleId){
                        $arrj[$v['id']]=true;
                    }else{
                        $arrj[$v['id']]=false;
                    }
                }
                $arrall['teacher']=$arr1;
                foreach($arr1 as $k=>$v){
                    $data1[$v['userid']]['branch']=$v['branch'];
                    $data1[$v['userid']]['name']=$v['name'];
                    $data1[$v['userid']]['grade']=$v['grade'];
                    $data1[$v['userid']]['teachingSubjects']=$v['teachingSubjects'];
                }
                foreach($f2 as $k=>$v){
                    $f2[$k]['branch']=$data1[$v['userid']]['branch'];
                    $f2[$k]['name']=$data1[$v['userid']]['name'];
                    $f2[$k]['teachingSubjects']=$data1[$v['userid']]['teachingSubjects'];
                    $f2[$k]['headmaster']=$data2[$v['userid']];
                    $f2[$k]['staff']=$arrj[$v['userid']];
                    unset($f2[$k]['userid']);

                }
                $arrall['exam']=$f2;
                $dao4=M('examination_subject');
                $sql4="SELECT * FROM `mks_examination_subject` WHERE examinationid=".$data['examinationid']." and scId=".$scId." GROUP BY date,starttime";
                $f4=$dao4->query($sql4);
                $n4=count($f4);
                $arr4['invigilatorall']=$n4*$f;
                $sql5="SELECT SUM(invigilator) AS invigilator,SUM(visits) AS visits,SUM(totalinspection) AS totalinspection,SUM(arrange) AS arrangeall,AVG(arrange) AS arrange FROM `mks_examination_teacher` WHERE examinationid=".I('post.examinationid')." GROUP BY examinationid";
                $f5=$dao2->query($sql5);
                $arr4['invigilator']=$f5['0']['invigilator'];
                $arr4['visits']=$f5['0']['visits'];
                $arr4['totalinspection']=$f5['0']['totalinspection'];
                $arr4['arrangeall']=$f5['0']['arrangeall'];
                $arr4['arrange']=round($f5['0']['arrange'],2);
                $arrall['all']=$arr4;
                $this->ajaxReturn($arrall);
            }elseif(I('get.typename') == 'exteacherinsert'){/**************监考任务添加***************/
                $data['examinationid']=I('post.examinationid');
                $data['userid']=I('post.userid');
                $data['lastRecordTime']=time();
                $data['createTime']=time();
                $data['scId']=$getSession['scId'];
                $dao=M('examination_teacher');
                $f=$dao->data($data)->add();
                if($f===false){
                    $arr['return']=false;
                }else{
                    $arr['return']=true;
                }
                $this->ajaxReturn($arr);
            }elseif(I('get.typename') == 'exteacherup'){/*****************监考任务修改*******************/
                $where['id']=I('post.id');
                $where['scId']=$getSession['scId'];
                $data['invigilator']=I('post.invigilator');
                $data['visits']=I('post.visits');
                $data['totalinspection']=I('post.totalinspection');
                $data['arrange']=I('post.totalinspection')+I('post.visits')+I('post.examinations');
                $data['lastRecordTime']=time();
                $dao=M('examination_teacher');
                $f=$dao->where($where)->save($data);
                if($f===false){
                    $arr['return']=false;
                }else{
                    $arr['return']=true;
                }
                $this->ajaxReturn($arr);
            }elseif(I('get.typename') == 'exteacherdel'){/*****************监考任务删除*****************/
                $where['id']=I('post.id');
                $where['scId']=$getSession['scId'];
                $dao=M('examination_teacher');
                $f=$dao->where($where)->delete();
                if($f===false){
                    $arr['return']=false;
                }else{
                    $arr['return']=true;
                }
                $this->ajaxReturn($arr);
            }
        }elseif(I('get.type')=='arrange'){/*************************考生安排查询************************/
            if(I('get.typename')=='arrangefind'){
                $where1['examinationid']=I('post.examinationid');
                $scId=$getSession['scId'];
                $where1['scId']=$scId;
                $where2['gradeId']=I('post.gradeid');
                $where2['scId']=$scId;
                $dao1=M('examination_arrange');
                $f1=$dao1->where($where1)->select();
                $sqln="SELECT r.`userId`,r.isResSchool FROM mks_grade AS g,`mks_school_rollinfo` AS r WHERE g.`name`=r.`grade` AND gradeid=".$where2['gradeId'];
                $fn=$dao1->query($sqln);
                foreach($fn as $k=>$v){
                    $arrn[$v['userId']]=$v['isResSchool'];
                }
                if($f1===null){
                    $this->ajaxReturn($f1);
                }else{
                    $dao2=M('');
                    $field=I('post.field');
                    $screen=I('post.screen');
                    $sqle="SELECT r.examinationid as id,e.`examination` FROM `mks_examination_results` AS r,mks_examination AS e WHERE e.scid=".$scId." AND e.`examinationid`=r.`examinationid` GROUP BY r.examinationid";
                    $examlist=$dao2->query($sqle);
                    if($screen){
                        $st="and (u.className like '%".$screen."%' or u.serialNumber like '%".$screen."%' or u.sex like '%".$screen."%' or u.name like '%".$screen."%' or a.`seatnumber` like '%".$screen."%' or b.`branch` like '%".$screen."%' or n.`number` like '%".$screen."%')";
                    }
                    if($field=='className' || $field== 'serialNumber' || $field=="mame"){
                        $field='u.'.$field;
                    }elseif($field=='room' || $field== 'seatnumber'){
                        if($field=='room'){
                            $field='roomid';
                        }
                        $field='a.'.$field;
                    }elseif($field=='branch'){
                        $field='b.'.$field;
                    }elseif($field=='number'){
                        $field='n.'.$field;
                    }elseif(!$field){
                        $field="u.className,u.serialNumber";
                    }
                    $order=I("post.order");
                    if($order=='descing'){
                        $order='desc';
                    }else{
                        $order='asc';
                    }
                    $limit=I("post.limit");
                    if(!$limit){
                        $limit=2;
                    }
                    $page=I('post.page');
                    if(!$page){
                        $page=1;
                    }
                    $limitstart=($page-1)*$limit;

                    $examinationid=I('post.examinationid');
                    $sql2="SELECT u.className,u.serialNumber,u.name,a.roomid,a.seatnumber,b.branch,n.number,u.id FROM `mks_examination_arrange` AS a,mks_user AS u,`mks_class_branch` AS b,`mks_examination_number` AS n WHERE a.userid=u.id AND a.branchid=b.branchid AND a.examinationid=n.examinationid AND a.userid=n.userid AND a.examinationid=".$examinationid." and u.scId=".$scId." $st order by ".$field." ".$order." limit ".$limitstart.",".$limit;

                    $sql3="SELECT count(*) as num FROM `mks_examination_arrange` AS a,mks_user AS u,`mks_class_branch` AS b,`mks_examination_number` AS n WHERE a.userid=u.id AND a.branchid=b.branchid AND a.examinationid=n.examinationid AND a.userid=n.userid AND a.examinationid=".$examinationid." and u.scId=".$scId." $st";
                    $f2=$dao2->query($sql2);
                    $count1=$dao2->query($sql3);
                    $count=$count1['0']['num'];
                    $dao3=M('examination_room');
                    $f3=$dao3->field('id,room')->where($where1)->select();
                    foreach($f3 as $k=>$v){
                        $data1[$v['id']]=$v['room'];
                    }
                    if(empty($f2)){
                        $data2['data']=null;
                    }
                    foreach($f2 as $k=>$v){
                        $data2['data'][$k]['className']=$v['className'];
                        $data2['data'][$k]['serialNumber']=$v['serialNumber'];
                        $data2['data'][$k]['name']=$v['name'];
                        $data2['data'][$k]['room']=$data1[$v['roomid']];
                        $data2['data'][$k]['seatnumber']=$v['seatnumber'];
                        $data2['data'][$k]['branch']=$v['branch'];
                        $data2['data'][$k]['number']=$v['number'];
                        if(!$arrn[$v['id']]){
                            $data2['data'][$k]['isResSchool']='否';
                        }else{
                            $data2['data'][$k]['isResSchool']=$arrn[$v['id']];
                        }
                    }
                    $data2['page']['pageall']=ceil($count/$limit);
                    $data2['page']['page']=$page;
                    $data2['page']['count']=$count;
                    $data2['examlist']=$examlist;
                    $this->ajaxReturn($data2);
                }
            }elseif(I('get.typename')=='arrangeinsert'){/********************考生安排生成排位*******************/
                $mode=I('post.mode');
                $scId=$getSession['scId'];
                $gradeid=I('post.gradeid');
                $where1['examinationid']=I('post.examinationid');
                $isResSchool=I('post.isResSchool');
                $where1['scId']=$scId;
                $dao1=M('examination_arrange');
                $f1=$dao1->where($where1)->delete();
                if($f1!==false){
                    if($mode=='按座位号随机排序'){
                        $dao=M();
                        $sql="SELECT `userid`,`branch` FROM `mks_examination_student` WHERE `participate`='是' AND `examinationid`=".I('post.examinationid')." and scId=".$scId;
                        $f=$dao->query($sql);
                        foreach($f as $k=>$v){
                            $arr['userid']=$v['userid'];
                            $arr['branchid']=$v['branch'];
                            $arr['examinationid']=I('post.examinationid');
                            $arr['scId']=$scId;
                            $arr['roomid']=null;
                            $arr['seatnumber']=null;
                            $arr['lastRecordTime']=time();
                            $arr['createTime']=time();
                            $arr1[$v['branch']][]=$arr;
                        }
                        foreach($arr1 as $k=>$v){
                            shuffle($arr1[$k]);
                        }
                    }elseif($mode=='按座位号顺序'){
                        $dao=M();
                        $sql1="SELECT s.`userid`,s.`branch`,u.class,u.serialNumber FROM `mks_examination_student` AS s,mks_user AS u WHERE s.`participate`='是' AND u.`id`=s.`userid` AND s.`examinationid`=".I('post.examinationid')." and u.scId=".$scId." order by s.branch,u.className,u.serialNumber asc";
                        $f1=$dao->query($sql1);
                        foreach($f1 as $k=>$v){
                            $arr['userid']=$v['userid'];
                            $arr['branchid']=$v['branch'];
                            $arr['examinationid']=I('post.examinationid');
                            $arr['roomid']=null;
                            $arr['seatnumber']=null;
                            $arr['scId']=$scId;
                            $arr['lastRecordTime']=time();
                            $arr['createTime']=time();
                            $arr1[$v['branch']][]=$arr;
                        }
                    }elseif($mode=='按总分降序排序'){
                        $dao=M();
                        $id=I('post.id');
                        $sql1="SELECT SUM(results) as num,userid FROM `mks_examination_results` WHERE examinationid=".$id." GROUP BY userid";
                        $f1=$dao->query($sql1);
                        foreach($f1 as $k=>$v){
                            $arr11[$v['num']]=$v['userid'];
                        }
                        $sql2="SELECT `userid`,`branch` FROM `mks_examination_student` WHERE `participate`='是' AND `examinationid`=".I('post.examinationid')." and scId=".$scId;
                        $f2=$dao->query($sql2);
                        ksort($arr11);
                        foreach($arr11 as $k=>$v){
                            foreach($f2 as $a=>$b){
                                if($v==$b['userid']){
                                    unset($f2[$a]);
                                    array_unshift($f2,$b);
                                }
                            }
                        }
                        $arrf=array_values($f2);
                        foreach($arrf as $k=>$v){
                                $arr['userid']=$v['userid'];
                                $arr['branchid']=$v['branch'];
                                $arr['examinationid']=I('post.examinationid');
                                $arr['roomid']=null;
                                $arr['seatnumber']=null;
                                $arr['scId']=$scId;
                                $arr['lastRecordTime']=time();
                                $arr['createTime']=time();
                                $arr1[$v['branch']][]=$arr;

                        }
                    }
                    if($isResSchool=='是'){
                        $sqln="SELECT r.`userId`,r.isResSchool FROM mks_grade AS g,`mks_school_rollinfo` AS r WHERE g.`name`=r.`grade` AND gradeid=".$gradeid;
                        $fn=$dao->query($sqln);
                        foreach($fn as $k=>$v){
                            $arrn[$v['userId']]=$v['isResSchool'];
                        }
                        foreach($arr1 as $k=>$v){
                            foreach($v as $a=>$b){
                                if($arrn[$b['userid']]=='是'){
                                    unset($arr1[$k][$a]);
                                    array_push($arr1[$k],$b);
                                }
                            }
                            $arr1[$k]=array_values($arr1[$k]);
                        }
                    }
                    $dao2=M('examination_room');
                    $f2=$dao2->field('id,branch,seats')->where($where1)->select();
                    foreach($f2 as $k=>$v){
                        $arr3['id']=$v['id'];
                        $arr3['seats']=$v['seats'];
                        $arr2[$v['branch']][]=$arr3;
                    }
                    foreach($arr2 as $k=>$v){
                        $numstart=0;
                        foreach($v as $m=>$n){
                            $numend=$numstart+$n['seats'];
                            $z=1;
                            for($i=$numstart;$i<$numend;$i++){
                                if($arr1[$k][$i]){
                                    $arr1[$k][$i]['roomid']=$n['id'];
                                    $arr1[$k][$i]['seatnumber']=$z;
                                    $z++;
                                }
                            }
                            $numstart=$numstart+$n['seats'];
                        }
                    }
                    //exit;
                    $arro['return']=true;
                    $dao3=M("examination_arrange");
                    foreach($arr1 as $k=>$v){
                        $f=$dao3->addAll($v);
                        if($f===false){
                            $arro['return']=false;
                        }
                    }
                }else{
                    $arro['return']=false;
                }
                $this->ajaxReturn($arro);
            }
        }elseif(I('get.type')=='invigilatorarrange'){/*******************监考安排**********************/
            if(I('get.typename')=='generate'){/***********生成监考安排*************/
                $mode=I('post.mode');
                $dao=M();
                $dao1=M('examination_subject');
                $scId=2;
                $dao2=M('examination_room');
                $dao3=M('examination_teacher');
                $sqla='select u.`name`,t.`userid` from `mks_examination_teacher` as t,mks_user as u where u.id=t.`userid` and t.scId='.$scId.' and examinationid='.I('post.examinationid');
                $fa=$dao3->query($sqla);
                if(empty($fa['0'])){
                    $arrj['arrange']=false;
                }else{
                    foreach($fa as $k=>$v){
                        $arrfa[$v['userid']]=$v['name'];
                    }
                    $sql1="SELECT e.id,e.branchid,e.date,e.starttime,e.endtime,s.subjectname FROM `mks_examination_subject` AS e,mks_subject AS s WHERE e.subject=s.subjectid AND e.examinationid=".I('post.examinationid');
                    $f1=$dao->query($sql1);//考试科目，时间，日期，科类
                    $where['examinationid']=I('post.examinationid');
                    $where['scId']=$scId;
                    $where2['examinationid']=I('post.examinationid');
                    $where2['status']=1;
                    $f2=$dao2->where($where2)->field('branch,room,id')->select();//考场科类，考场
                    $count=count($f2);
                    foreach($f2 as $k=>$v){
                        $arr1[$v['branch']][]=$v['id'];
                    }
                    foreach($f1 as $k=>$v){
                        $time=$v['date'].'-'.$v['starttime']."-".$v['endtime'];
                        foreach($arr1[$v['branchid']] as $m=>$n){
                            $arr2[$time][$v['id']][]=$n;
                        }
                    }
                    foreach($f1 as $k=>$v){
                        $arr5[$v['id']]=$v['subjectname'];
                    }
                    //print_r($arr5);
                    //exit;
                    $sql3="SELECT t.userid,t.invigilator,t.visits,t.totalinspection,u.`teachingSubjects` FROM `mks_examination_teacher` AS t,mks_user AS u WHERE t.`userid`=u.`id` AND t.examinationid=".I('post.examinationid');
                    $f3=$dao3->query($sql3);
                    $key5=0;
                    foreach($f3 as $k=>$v){
                        if($v['invigilator']){
                            //$arrinvigilator[$v['userid']]=$v['invigilator'];
                            $key5=$key5+$v['invigilator'];
                            $arz['invigilator']=$v['invigilator'];
                            $arz['userid']=$v['userid'];
                            $arz['teachingSubjects']=$v['teachingSubjects'];
                            $arrinvigilator[]=$arz;//监考
                        }
                        if($v['visits']){
                            $arrvisits[$v['userid']]=$v['visits'];//巡考
                        }
                        if($v['totalinspection']){
                            $arrtotalinspection[$v['userid']]=$v['totalinspection'];//总巡考
                        }
                    }
                    $dao9=M('examination_subject');
                    $sql9="SELECT * FROM `mks_examination_subject` WHERE examinationid=".$where['examinationid']." and scId=".$scId." GROUP BY date,starttime";
                    $f9=$dao9->query($sql9);
                    $n9=count($f9);
                    $datab['examinationid'] = I('post.examinationid');
                    $datab['status'] = 1;
                    $dao10 = M('examination_room');
                    $f = $dao10->where($datab)->count();
                    $key1=count($f3);
                    $key2=$n9*$f;
                    $key2=count($f2);
                    $key3=$key5/$key2;
                    if($key3>=2){
                        $key3=2;
                    }else{
                        $key3=1;
                    }
                    if($mode=='不限制'){
                        foreach($arr2 as $k=>$v){//考试日期
                            foreach($arrvisits as $a=>$b){
                                if($arrvisits[$a]){
                                    $arr8['ensubjectid']='';
                                    $arr8['roomid']='巡考';
                                    $arr8['userid']=$a;
                                    $arr8['name']=$arrfa[$a];
                                    $arrvisits[$a]=$arrvisits[$a]-1;
                                    break;
                                    //$e++;
                                }else{
                                    $arr8=array();
                                    continue;
                                }
                            }
                            foreach($arrtotalinspection as $a=>$b){
                                if($arrtotalinspection[$a]){
                                    $arr9['ensubjectid']='';
                                    $arr9['roomid']='总巡考';
                                    $arr9['userid']=$a;
                                    $arr9['name']=$arrfa[$a];
                                    $arrtotalinspection[$a]=$arrtotalinspection[$a]-1;
                                    break;
                                    //$e++;
                                }else{
                                    $arr9=array();
                                    continue;
                                }
                            }
                            $arrn=$arrinvigilator;
                            $i=0;
                            foreach($v as $c=>$d){//科目
                                if(!empty($arr8)){
                                    $arr8['ensubjectid']=$c;
                                    $arr4[]=$arr8;
                                }
                                if(!empty($arr9)){
                                    $arr9['ensubjectid']=$c;
                                    $arr4[]=$arr9;
                                }
                                foreach($d as $a=>$b){//考场
                                    $z=0;//控制监考人数
                                    for($l=$i;$l<$key1;$l++){//老师
                                        if($arrinvigilator[$l]['invigilator']){
                                            if($z==$key3){
                                                break;
                                            }else{
                                                $arr3['ensubjectid']=$c;
                                                $arr3['roomid']=$b;
                                                $arr3['userid']=$arrinvigilator[$l]['userid'];
                                                $arr3['name']=$arrfa[$arrinvigilator[$l]['userid']];
                                                $arr4[]=$arr3;
                                                $arrinvigilator[$l]['invigilator']=$arrinvigilator[$l]['invigilator']-1;
                                                $z++;
                                            }
                                        }
                                        $i=$l+1;
                                    }
                                }
                            }
                        }
                    }elseif($mode=='本学科教师不要监考本学科考试'){
                        foreach($arr2 as $k=>$v){//考试日期
                            foreach($arrvisits as $a=>$b){
                                if($arrvisits[$a]){
                                    $arr8['ensubjectid']='';
                                    $arr8['roomid']='巡考';
                                    $arr8['userid']=$a;
                                    $arr8['name']=$arrfa[$a];
                                    $arrvisits[$a]=$arrvisits[$a]-1;
                                    break;
                                    //$e++;
                                }else{
                                    $arr8=array();
                                    continue;
                                }
                            }
                            foreach($arrtotalinspection as $a=>$b){
                                if($arrtotalinspection[$a]){
                                    $arr9['ensubjectid']='';
                                    $arr9['roomid']='总巡考';
                                    $arr9['userid']=$a;
                                    $arr9['name']=$arrfa[$a];
                                    $arrtotalinspection[$a]=$arrtotalinspection[$a]-1;
                                    break;
                                    //$e++;
                                }else{
                                    $arr9=array();
                                    continue;
                                }
                            }
                            $arrn=$arrinvigilator;
                            $i=0;
                            foreach($v as $c=>$d){//科目
                                if(!empty($arr8)){
                                    $arr8['ensubjectid']=$c;
                                    $arr4[]=$arr8;
                                }
                                if(!empty($arr9)){
                                    $arr9['ensubjectid']=$c;
                                    $arr4[]=$arr9;
                                }
                                $arrk=$arrn;
                                foreach($arrk as $f=>$g){
                                    if($arr5[$c]==$g['teachingSubjects']){
                                        unset($arrk[$f]);
                                    }
                                }
                                foreach($d as $a=>$b){//考场
                                    $z=0;//控制监考人数
                                    for($l=$i;$l<$key1;$l++){//老师
                                        if($arrk[$l]['invigilator']){
                                            if($z==$key3){
                                                break;
                                            }else{
                                                $arr3['ensubjectid']=$c;
                                                $arr3['roomid']=$b;
                                                $arr3['userid']=$arrk[$l]['userid'];
                                                $arr3['name']=$arrfa[$arrk[$l]['userid']];
                                                $arr4[]=$arr3;
                                                unset($arrn[$l]);
                                                $arrinvigilator[$l]['invigilator']=$arrinvigilator[$l]['invigilator']-1;
                                                $z++;
                                            }
                                        }
                                        $i=$l+1;
                                    }
                                }
                            }
                        }
                    }elseif($mode=='本学科教师要监考本学科考试'){
                        foreach($arr2 as $k=>$v){//考试日期
                            foreach($arrvisits as $a=>$b){
                                if($arrvisits[$a]){
                                    $arr8['ensubjectid']='';
                                    $arr8['roomid']='巡考';
                                    $arr8['userid']=$a;
                                    $arr8['name']=$arrfa[$a];
                                    $arrvisits[$a]=$arrvisits[$a]-1;
                                    break;
                                    //$e++;
                                }else{
                                    continue;
                                }
                            }
                            foreach($arrtotalinspection as $a=>$b){
                                if($arrtotalinspection[$a]){
                                    $arr9['ensubjectid']='';
                                    $arr9['roomid']='总巡考';
                                    $arr9['userid']=$a;
                                    $arr9['name']=$arrfa[$a];
                                    $arrtotalinspection[$a]=$arrtotalinspection[$a]-1;
                                    break;
                                    //$e++;
                                }else{
                                    continue;
                                }
                            }
                            $arrn=$arrinvigilator;
                            $i=0;
                            foreach($v as $c=>$d){//科目
                                if(!empty($arr8)){
                                    $arr8['ensubjectid']=$c;
                                    $arr4[]=$arr8;
                                    $arr8=array();
                                }
                                if(!empty($arr9)){
                                    $arr9['ensubjectid']=$c;
                                    $arr4[]=$arr9;
                                    $arr9=array();
                                }
                                $arrk=$arrn;
                                foreach($arrk as $f=>$g){
                                    if($arr5[$c]!=$g['teachingSubjects']){
                                        unset($arrk[$f]);
                                    }
                                }
                                foreach($d as $a=>$b){//考场
                                    $z=0;//控制监考人数
                                    for($l=$i;$l<$key1;$l++){//老师
                                        if($arrk[$l]['invigilator']){
                                            if($z==$key3){
                                                break;
                                            }else{
                                                $arr3['ensubjectid']=$c;
                                                $arr3['roomid']=$b;
                                                $arr3['userid']=$arrk[$l]['userid'];
                                                $arr3['name']=$arrfa[$arrk[$l]['userid']];
                                                $arr4[]=$arr3;
                                                unset($arrn[$l]);
                                                $arrinvigilator[$l]['invigilator']=$arrinvigilator[$l]['invigilator']-1;
                                                $z++;
                                            }
                                        }
                                        $i=$l+1;
                                    }
                                }
                            }
                        }
                    }
                    $are=$this->getArrange($where['examinationid'],$arr4);
                    $this->ajaxReturn($are);
                }
            }elseif(I('get.typename')=="find"){/************************监考安排展示****************************/
                $examinationid=I('post.examinationid');
                $are=$this->getArrange($examinationid);
                $this->ajaxReturn($are);
            }elseif(I('get.typename')=="save"){/***************监考安排保存***********/
                $data=$_POST['data'];
                $scId=2;
                $examinationid=I('post.examinationid');
                $arr['return']=true;
                //{"userid":"122","roomid":"140","ensubjectid":"512","id":"428"}
                foreach($data as $k=>$v){
                    $where['scId']=$scId;
                    $where['id']=$v['id'];
                    $data['room']=$v['roomid'];
                    $data['ensubjectid']=$v['ensubjectid'];
                    //$data['userid']=$v['userid'];
                    $f=$dao->where($where)->save($data);
                    if($f===false){
                        $arr['return']=false;
                    }

                }
                $this->ajaxReturn($arr);
            }elseif(I('get.typename')=='export'){
                $examinationid=I('post.examinationid');
                $branch=I('post.branch');
                $are=$this->getArrange($examinationid);
                foreach($are['title'] as $k=>$v){
                    if($v['branch']==$branch){
                        $title=$v['datelist'];
                    }else{
                        continue;
                    }
                }
                vendor("PHPExcel.PHPExcel");
                $objPHPExcel = new \PHPExcel();
                // Set properties
                //$objPHPExcel->getProperties()->setCreator("cdn");
                //$objPHPExcel->getProperties()->setLastModifiedBy("cdn");
                $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
                $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
                $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

// Add some data
                $objPHPExcel->setActiveSheetIndex(0);
                //$objPHPExcel->getActiveSheet()->setTitle('CDN');
                $objPHPExcel->getActiveSheet()->SetCellValue('A1', '考场');
                $objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
                $objPHPExcel->getActiveSheet()->SetCellValue('B1', '科目');
                $objPHPExcel->getActiveSheet()->SetCellValue('B1', '科目');
                /*$n=1;
                foreach($arr6['scorenamelist'] as $k=>$v){
                    $st='name'.$n;
                    if(){}
                }*/
                $objPHPExcel->getActiveSheet()->SetCellValue('C1', $arr6['scorenamelist']['name1']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D1', $arr6['scorenamelist']['name2']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E1', $arr6['scorenamelist']['name3']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F1', $arr6['scorenamelist']['name4']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G1', $arr6['scorenamelist']['name5']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H1', $arr6['scorenamelist']['name6']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I1', $arr6['scorenamelist']['name7']);
                $i = 2;
                foreach ($arr6['data'] as $k => $v) {
                    $num = $i++;
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $num, $v['branch']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $num, $v['subject']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $num, $v['score1']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $num, $v['score2']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $num, $v['score3']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $num, $v['score4']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $num, $v['score5']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $num, $v['score6']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $num, $v['score7']);
                }
// Save Excel 2007 file
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                ob_end_clean();
                header("Content-Disposition:attachment;filename=tableExport.xls");
                header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');




            }
        }











        elseif(I('get.type')=='resultin'){/**********************导入成绩********************/
            if(I('get.typename')=='resultfind'){/*************************各科目成绩导入情况查询*******************************/
                $examinationid=I('post.examinationid');
                $scId=$getSession['scId'];
                $dao1=M('examination_subject');
                $where1['examinationid']=$examinationid;
                $where2['examinationid']=$examinationid;
                $where2['participate']='是';
                $where1['scId']=$scId;
                $where2['scId']=$scId;
                $dao2=M('examination_student');
                $dao3=M('examination_results');
                $sql6="SELECT branch,COUNT(branch) AS num FROM `mks_examination_student` WHERE examinationid=".$examinationid." and scId=".$scId." GROUP BY branch";
                $f6=$dao2->query($sql6);
                foreach($f6 as $k=>$v){;
                    $m6[$v['branch']]=$v['num'];
                }
                $f1=$dao1->field('branchid,subject')->where($where1)->select();
                foreach($f1 as $k=>$v){
                    $arr1[$v['branchid']][$v['subject']]=0;
                }
                $sql2="SELECT branch,COUNT(userid) as num FROM mks_examination_student WHERE participate='是' AND examinationid=".$examinationid." and scId=".$scId." GROUP BY branch";
                $f2=$dao2->query($sql2);
                foreach($f2 as $k=>$v){
                    $arr2[$v['branch']]=$v['num'];
                }
                $sql3="SELECT COUNT(userid) AS num,subjectid,branchid FROM `mks_examination_results` WHERE examinationid=".$examinationid." and scId=".$scId." group by branchid,subjectid";
                $f3=$dao3->query($sql3);
                foreach($f3 as $k=>$v){
                    $arr3[$v['branchid']][$v['subjectid']]=$v["num"];
                }
                foreach($arr1 as $k=>$v){
                    foreach($v as $m=>$n){
                        $arr1[$k][$m]=$arr3[$k][$m];
                    }
                }
                $where['scId']=$scId;
                $dao4=M('class_branch');
                $dao5=M('subject');
                $f4=$dao4->where($where)->field("branchid,branch")->select();
                foreach($f4 as $k=>$v){
                    $arr4[$v['branchid']]=$v['branch'];
                }

                $f5=$dao5->where($where)->field("subjectid,subjectname")->select();
                foreach($f5 as $k=>$v){
                    $arr5[$v['subjectid']]=$v['subjectname'];
                }
                foreach($arr1 as $k=>$v){
                    $i=0;
                    foreach($v as $m=>$n){
                        if(!$n){
                            $n=0;
                        }
                        $arr6['branchlist'][]=$arr4[$k];
                        $arr6[$arr4[$k]][$i]['input']=$n;
                        $arr6[$arr4[$k]][$i]['uninput']=$m6[$k]-$n;
                        $arr6[$arr4[$k]][$i]['all']=$m6[$k];
                        $arr6[$arr4[$k]][$i]['ratio']=(round($n/$m6[$k],2)*100).'%';
                        $arr6[$arr4[$k]][$i]['branchid']=$k;
                        $arr6[$arr4[$k]][$i]['subjectid']=$m;
                        $arr6[$arr4[$k]][$i]['subject']=$arr5[$m];
                        $i++;
                    }
                }
                $array=array_flip($arr6['branchlist']);
                $arr6['branchlist']=array_keys($array);
                $this->ajaxReturn($arr6);
            }elseif(I('get.typename')=='resultinfind'){/********************成绩查询****************/
                $where1['examinationid']=I('post.examinationid');
                $scId=$getSession['scId'];
                $where2['gradeId']=I('post.gradeid');
                $where1['scId']=$scId;
                $where2['scId']=$scId;
                $dao1=M('examination_arrange');
                $screen=I('post.screen');
                if($screen){
                    $st="and (u.className like '%".$screen."%' or u.serialNumber like '%".$screen."%' or u.name like '%".$screen."%' or a.`seatnumber` like '%".$screen."%' or n.`number` like '%".$screen."%')";
                }
                $dao2 = M('');
                $field = I('post.field');
                $order = I("post.order");
                if ($field == 'className' || $field == 'serialNumber' || $field == "mame") {
                    $field = 'u.' . $field;
                } elseif ($field == 'room' || $field == 'seatnumber') {
                    if ($field == 'room') {
                        $field = 'roomid';
                    }
                    $field = 'a.' . $field;
                } elseif ($field == 'number') {
                    $field = 'n.' . $field;
                } elseif (!$field) {
                    $field = "u.className,u.serialNumber";
                }elseif($field=='班级+班级序号'){
                    $field="u.className,u.serialNumber";
                }elseif($field=="考试+考试座号"){
                    $field="a.roomid,a.seatnumber";
                }
                $order=I('post.order');
                if($order=='descing'){
                    $order='desc';
                }else{
                    $order='asc';
                }
                $limit = I("post.limit");
                if(!$limit){
                    $limit=2;
                }
                $page = I('post.page');
                if(!$page){
                    $page=1;
                }
                $limitstart = ($page - 1) * $limit;
                $dao6=M('examination_student');
                $where3['examinationid']=I('post.examinationid');
                $where3['participate']='是';
                $where3['branch']=I('post.branchid');
                //$count = $dao6->where($where3)->count();
                $examinationid = I('post.examinationid');
                $sql2 ="SELECT u.className,u.serialNumber,u.name,u.id,a.roomid,a.seatnumber,n.number FROM `mks_examination_arrange` AS a,mks_user AS u,`mks_examination_number` AS n WHERE a.userid=u.id AND a.branchid=".I('post.branchid')." and a.scId=".$scId." AND a.examinationid=n.examinationid AND a.userid=n.userid AND a.examinationid=" . $examinationid . " $st order by " . $field . " " . $order . " limit " . $limitstart . "," . $limit;
                $sql3="SELECT count(*) as num FROM `mks_examination_arrange` AS a,mks_user AS u,`mks_examination_number` AS n WHERE a.userid=u.id AND a.branchid=".I('post.branchid')." and a.scId=".$scId." AND a.examinationid=n.examinationid AND a.userid=n.userid AND a.examinationid=" . $examinationid . " $st order by " . $field . " " . $order;
                $f2 = $dao2->query($sql2);
                $count1=$dao2->query($sql3);
                $count=$count1['0']['num'];
                $dao3 = M('examination_room');
                $f3 = $dao3->field('id,room')->where($where1)->select();
                foreach ($f3 as $k => $v) {
                    $data1[$v['id']] = $v['room'];
                }
                $dao5=M("examination_results");
                $where1['subjectid']=I('post.subjectid');
                $where7['examinationid']=I('post.examinationid');
                $where7['scId']=$scId;
                $where7['subject']=I('post.subjectid');
                $where7['branchid']=I('post.branchid');
                $dao7=M('examination_subject');
                $f7=$dao7->field('proportion,results')->where($where7)->select();
                //echo json_encode($f7);
                if(empty($f2)){
                    $data2['data']=null;
                }
                foreach ($f2 as $k => $v) {
                    $data2['data'][$k]['className'] = $v['className'];
                    $data2['data'][$k]['serialNumber'] = $v['serialNumber'];
                    $data2['data'][$k]['name'] = $v['name'];
                    $data2['data'][$k]['room'] = $data1[$v['roomid']];
                    $data2['data'][$k]['seatnumber'] = $v['seatnumber'];
                    $data2['data'][$k]['number'] = $v['number'];
                    $data2['data'][$k]['userid'] = $v['id'];
                    $where1['userid']=$v['id'];
                    $f5=$dao5->where($where1)->field('id,results')->select();
                    $data2['data'][$k]['results'] = $f5['0']['results'];
                    $data2['data'][$k]['id'] = $f5['0']['id'];
                }
                $data2['value']['results']=$f7['0']['results'];
                $data2['value']['proportion']=$f7['0']['proportion'];
                $data2['page']['pageall'] = ceil($count / $limit);
                $data2['page']['page'] = $page;
                $data2['page']['count'] = $count;
                $this->ajaxReturn($data2);
            }elseif(I('get.typename')=='resultupin'){/***********修改添加成绩************/
                $where['id']=I('post.id');
                $scId=$getSession['scId'];
                $where['scId']=$scId;
                $userid=I('post.userid');
                $examinationid=I('post.examinationid');
                $subjectid=I('post.subjectid');
                $branchid=I('post.branchid');
                $results=I('post.results');
                $dao=M('examination_results');
                if($where['id']){
                    $data['results']=$results;
                    $data['lastRecordTime']=time();
                    $f=$dao->where($where)->data($data)->save();
                }else{
                    $data['results']=$results;
                    $data['userid']=$userid;
                    $data['examinationid']=$examinationid;
                    $data['subjectid']=$subjectid;
                    $data['branchid']=$branchid;
                    $data['lastRecordTime']=time();
                    $data['createTime']=time();
                    $data['scId']=$scId;
                    $f=$dao->where($where)->add($data);
                }
                if($f===false){
                    $data1['return']=false;
                }else{
                    $data1['return']=true;
                }
                $this->ajaxReturn($data1);
            }elseif(I('get.typename')=='delall'){/*******************清空**********************/
                $scId=$getSession['scId'];
                $examinationid=I('post.examinationid');
                $subjectid=I('post.subjectid');
                $branchid=I('post.branchid');
                $where['examinationid']=$examinationid;
                $where['subjectid']=$subjectid;
                $where['branchid']=$branchid;
                $where['scId']=$scId;
                $dao=M('examination_results');
                $f=$dao->where($where)->delete();
                if($f===false){
                    $data1['return']=false;
                }else{
                    $data1['return']=true;
                }
                $this->ajaxReturn($data1);
            }elseif(I('get.typename')=='import'){
                if (!empty($_FILES)) {
                    $scId=2;//$getSession['scId'];
                    $upload = new \Think\Upload();
                    $upload->maxSize   =     3145728 ;// 设置附件上传大小
                    $upload->exts      =     array('xlsx', 'xls');// 设置附件上传类型
                    $upload->rootPath  =     './'; // 设置附件上传根目录
                    $upload->savePath  =     'Public/upload/exam/'; // 设置附件上传（子）目录
                    $upload->replace  =     true; // 设置附件是否替换
                    //$upload->savePath  =     'cdr/'; // 设置附件上传（子）目录
                    $upload->saveName = 'numberInformation';
                    $upload->autoSub = false;
                    $info   =   $upload->uploadOne($_FILES['photo']);
                    if(!$info) {// 上传错误提示错误信息
                        $arr['result']=false;
                        return $arr;
                    }
                    vendor("PHPExcel.PHPExcel");
                    //$objPHPExcel = new \PHPExcel();
                    $string =$_FILES['photo']['name'];
                    $arraym = explode('.',$string);
                    $exs=$arraym[count($arraym)-1];
                    vendor("PHPExcel.PHPExcel");
                    //$objPHPExcel = new \PHPExcel();
                    if($exs=='xls') {
                        $reader = \PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
                        $PHPExcel = $reader->load("./Public/upload/exam/numberInformation.xls"); // 载入excel文件
                    }else{
                        $reader = \PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
                        $PHPExcel = $reader->load("./Public/upload/exam/numberInformation.xlsx"); // 载入excel文件
                    }
                    $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
                    $highestRow = $sheet->getHighestRow(); // 取得总行数
                    $highestColumm = $sheet->getHighestColumn(); // 取得总列数
                    $row = 1;
                    for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
                        $value = $sheet->getCell($column . $row)->getValue();
                        if ($value == '') {
                            continue;
                        }
                        $value=strtr($value,array(' '=>''));
                        $dataset[$column] = $value;//表头字段
                        //echo $column.$row.":".$sheet->getCell($column.$row)->getValue()."<br />";
                    }
                    $dataset1 = array();
                    for ($row = 2; $row <= $highestRow; $row++) {//行数是以第1行开始
                        for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
                            $value = $sheet->getCell($column . $row)->getValue();
                            if ($value === '') {
                                continue;
                            }
                            $dataset1[$column] = $value;
                            //echo $column.$row.":".$sheet->getCell($column.$row)->getValue()."<br />";
                        }
                        if (empty($dataset1)) {
                            continue;
                        }
                        $dataset2[] = $dataset1;
                    }
                    $array = array();
                    foreach ($dataset2 as $k => $v) {
                        foreach ($v as $m => $n) {
                            foreach ($dataset as $o => $p) {
                                if ($m == $o &&$p!='序号') {
                                    $array[$p] = $n;
                                    break;
                                }
                            }
                        }
                        $array1[]=$array;
                    }
                    if($exs=='xls') {
                        unlink('./Public/upload/exam/numberInformation.xls');
                    }else{
                        unlink('./Public/upload/exam/numberInformation.xlsx');
                    }
                    $subjectid=I('post.subjectid');
                    $examinationid=I('post.examinationid');
                    $branchid=I('post.branchid');
                    $dao1 = M('');
                    $sql1="SELECT u.`id`,u.`className`,u.`name` FROM `mks_examination_student` AS s,mks_user AS u WHERE u.scId=".$scId." and s.`userid`=u.`id` AND s.`participate`='是' AND s.`examinationid`=".$examinationid." and s.branch=".$branchid;

                    $f1=$dao1->query($sql1);
                    foreach($array1 as $k=>$v){
                        $data[$v['班级']][$v['姓名']]=$v['成绩'];
                    }
                    foreach($f1 as $k=>$v){
                        $fn[$k]['results']=$data[$v['className']][$v['name']];
                        $fn[$k]['userid']=$v['id'];
                        $fn[$k]['subjectid']=$subjectid;
                        $fn[$k]['examinationid']=$examinationid;
                        $fn[$k]['branchid']=$branchid;
                        $fn[$k]['lastRecordTime']=time();
                        $fn[$k]['createTime']=time();
                        $fn[$k]['scId']=$scId;
                    }
                    $where1['subjectid'] =$subjectid;
                    $where1['examinationid'] =$examinationid;
                    $where1['branchid']=$branchid;
                    $where1['scId']=$scId;
                    $dao2=M('examination_results');
                    $f2=$dao2->where($where1)->delete();
                    if($f2!==false){
                        $f3=$dao2->addAll($fn);
                    }
                    if($f3===false){
                        $arr['return']=false;
                    }else{
                        $arr['return']=true;
                    }
                    $this->ajaxReturn($arr);
                }else{
                    $arr['result']=false;
                    $this->ajaxReturn($arr);
                }
            }
        }elseif(I('get.type')=='joinalone'){/*********************************学生单独参考**************************************/
            if(I('get.typename')=='select'){/**************************单独参考学生查询************************/
                $examinationid=I('post.examinationid');
                $scId=$getSession['scId'];
                $screen=I('post.screen');
                if($screen){
                    $st="and (grade like '%".$screen."%' or className like '%".$screen."%' or serialNumber like '%".$screen."%' or name like '%".$screen."%')";
                }
                $gradeid=I('post.gradeid');
                $dao1=M('user');
                $where1['gradeId']=$gradeid;
                $where1['roleId']=parent::$studentRoleId;
                $where1['scId']=$scId;
                $field=I('post.field');
                if(!$field){
                    $field='className,serialNumber';
                }
                $order=I('post.order');
                if($order=='descing'){
                    $order='desc';
                }else{
                    $order='asc';
                }
                $str=$field." ".$order;
                $sql1="select id,grade,className,serialNumber,name from mks_user where gradeId=".$gradeid." and roleId=".$where1['roleId']." and scId=".$scId." $st order by ".$field." ".$order;
                //$f1=$dao1->where($where1)->field('id,grade,className,serialNumber,name')->order($str)->select();
                $f1=$dao1->query($sql1);
                foreach($f1 as $k=>$v){
                    $arr1[$v['id']]=$v;
                }
                $dao2=M('examination_student');
                $where2['examinationid']=$examinationid;
                $where2['scId']=$scId;
                $f2=$dao2->field('userid,participate')->where($where2)->select();
                foreach($f2 as $k=>$v){
                    $arr2[$v['userid']]=$v['participate'];
                }
                foreach($arr1 as $k=>$v){
                    if($arr2[$k]!='是'){
                        $arr3[]=$v;
                    }
                }
                $this->ajaxReturn($arr3);
            }elseif(I('get.typename')=='insert'){/***********************参加考试***************************/
                $examinationid=I('post.examinationid');
                $userid=I('post.id');
                $program=I('post.program');
                $gradeid=I('post.gradeid');
                $scId=$getSession['scId'];
                $dao1=M();
                $sql1="SELECT u.`id` as userid,c.`branch` FROM mks_user AS u,mks_class AS c WHERE u.scId=".$scId." and u.id=".$userid." AND u.`class`=c.`classid`";
                $f1=$dao1->query($sql1);
                $dao2=M('examination_number');
                $where2['program']=$program;
                $where2['userid']=$userid;
                $where2['scId']=$scId;
                $arr['return']=false;
                $f2=$dao2->where($where2)->field('userid,number')->select();
                if($f1!==false && $f2!==false){
                    $dao3=M('examination_student');
                    $where3['examinationid']=$examinationid;
                    $where3['userid']=$userid;
                    $where3['scId']=$scId;
                    $f3=$dao3->where($where3)->delete();
                    if($f3!==false){
                        $f1['0']['examinationid']=$examinationid;
                        $f1['0']['lastRecordTime']=time();
                        $f1['0']['createTime']=time();
                        $f1['0']['reported']='是';
                        $f1['0']['participate']='是';
                        $f1['0']['scId']=$scId;
                        $f4=$dao3->addAll($f1);
                        if($f4!==false){
                            $f2['0']['gradeid']=$gradeid;
                            $f2['0']['program']='本次考试';
                            $f2['0']['examinationid']=$examinationid;
                            $f2['0']['lastRecordTime']=time();
                            $f2['0']['createTime']=time();
                            $f2['0']['scId']=$scId;
                            $dao5=M('examination_number');
                            $f5=$dao5->addAll($f2);
                        }
                    }
                }
                if($f5){
                    $arr['return']=true;
                }
                $this->ajaxReturn($arr);
            }
        }elseif(I('get.type')=='release'){/***************************发布成绩*********************************/
            if(I('get.typename')=='find'){/**********************成绩导入情况查询*******************/
                $examinationid=I('post.examinationid');
                $dao1=M('examination_subject');
                $scId=$getSession['scId'];
                $where1['examinationid']=$examinationid;
                $where1['scId']=$scId;
                $where2['examinationid']=$examinationid;
                $where2['scId']=$scId;
                $where2['participate']='是';
                $dao2=M('examination_student');
                $dao3=M('examination_results');
                $sql6="SELECT branch,COUNT(branch) AS num FROM `mks_examination_student` WHERE examinationid=".$examinationid." and scId=".$scId." GROUP BY branch";
                $f6=$dao2->query($sql6);
                foreach($f6 as $k=>$v){
                    $m6[$v['branch']]=$v['num'];
                }
                $f1=$dao1->field('branchid,subject')->where($where1)->select();
                foreach($f1 as $k=>$v){
                    $arr1[$v['branchid']][$v['subject']]=0;
                }
                $sql2="SELECT branch,COUNT(userid) as num FROM mks_examination_student WHERE participate='是' and scId=".$scId." AND examinationid=".$examinationid." GROUP BY branch";
                $f2=$dao2->query($sql2);
                foreach($f2 as $k=>$v){
                    $arr2[$v['branch']]=$v['num'];
                }
                $sql3="SELECT COUNT(userid) AS num,subjectid,branchid FROM `mks_examination_results` WHERE examinationid=".$examinationid." and scId=".$scId." group by branchid,subjectid";
                $f3=$dao3->query($sql3);
                foreach($f3 as $k=>$v){
                    $arr3[$v['branchid']][$v['subjectid']]=$v["num"];
                }
                foreach($arr1 as $k=>$v){
                    foreach($v as $m=>$n){
                        $arr1[$k][$m]=$arr3[$k][$m];
                    }
                }
                $where['scId']=$scId;
                $dao4=M('class_branch');
                $dao5=M('subject');
                $f4=$dao4->where($where)->field("branchid,branch")->select();
                foreach($f4 as $k=>$v){
                    $arr4[$v['branchid']]=$v['branch'];
                }
                $f5=$dao5->where($where)->field("subjectid,subjectname")->select();
                foreach($f5 as $k=>$v){
                    $arr5[$v['subjectid']]=$v['subjectname'];
                }

                foreach($arr1 as $k=>$v){
                    foreach($v as $m=>$n){
                        if(!$n){
                            $n=0;
                        }
                        $arrp['branch']=$arr4[$k];
                        $arrp['sunbject']=$arr5[$m];
                        $arrp['input']=$n;
                        $arrp['uninput']=$m6[$k]-$n;
                        $arrp['all']=$m6[$k];
                        $arrp['ratio']=(round($n/$m6[$k],2)*100).'%';
                        //$arrp['subjectid']=$m;
                        $arr6['data'][]=$arrp;
                    }
                }
                $dao9=M('examination');
                $where9['examinationid']=$examinationid;
                $where9['scId']=$scId;
                $f9=$dao9->where($where9)->field('release,ranking')->select();
                $arr6['state']=$f9['0'];
                $this->ajaxReturn($arr6);
            }elseif(I('get.typename')=='do'){/**********************发布成绩************************/
                $examinationid=I('post.examinationid');
                $release=I('post.release');
                $ranking=I('post.ranking');
                $where['examinationid']=$examinationid;
                $where['scId']=$getSession['scId'];
                $dao=M('examination');
                $data['release']=$release;
                $data['ranking']=$ranking;
                $data['lastRecordTime']=time();
                $f=$dao->where($where)->data($data)->save();
                if($f===false){
                    $arr['return']=false;
                }else{
                    $arr['return']=true;
                }
                $this->ajaxReturn($arr);
            }
        }elseif(I('get.type')=="score"){/******************考试划线*************************/
            if(I('get.typename')=="scorefind"){/*****************考试划线查询********************/
                $examinationid=I('post.examinationid');
                $scId=$getSession['scId'];
                $field=I('post.field');
                $order=I('post.order');
                if(!$field){
                    $field='branchid';
                }elseif($field=='branch'){
                    $field='branchid';
                }elseif($field=='subject'){
                    $field='ensubjectid';
                }
                if($order=='descing'){
                    $order='desc';
                }else{
                    $order='asc';
                }
                $where1['scId']=$scId;
                $str=$field." ".$order;
                $dao1=M('examination_subject');
                $where['examinationid']=$examinationid;
                $where['scId']=$scId;
                $dao2=M('examination_score');
                $f2=$dao2->where($where)->count();
                if($f2==0){
                    $f1=$dao1->field('subject,branchid')->where($where)->select();
                    foreach($f1 as $k=>$v){
                        $arr1[$v['branchid']][]=$v['subject'];
                    }
                    foreach($arr1 as $k=>$v){
                        $arr1[$k][]='总分';
                    }
                    foreach($arr1 as $k=>$v){
                        foreach($v as $m=>$n){
                            $arr2['branchid']=$k;
                            $arr2['ensubjectid']=$n;
                            $arr2['score1']=null;
                            $arr2['name1']='线一';
                            $arr2['score2']=null;
                            $arr2['name2']='线二';
                            $arr2['score3']=null;
                            $arr2['name3']='线三';
                            $arr2['score4']=null;
                            $arr2['name4']='线四';
                            $arr2['score5']=null;
                            $arr2['name5']='线五';
                            $arr2['score6']=null;
                            $arr2['name6']='线六';
                            $arr2['lastRecordTime']=time();
                            $arr2['createTime']=time();
                            $arr2['examinationid']=$examinationid;
                            $arr2['scId']=$scId;
                            $arr3[]=$arr2;
                        }
                    }
                    $f3=$dao2->addAll($arr3);
                }
                $f4=$dao2->where($where)->field('id,branchid as branch,ensubjectid as subject,score1,score2,score3,score4,score5,score6')->order($str)->select();
                $f7=$dao2->where($where)->field('name1,name2,name3,name4,name5,name6')->limit(1)->select();
                $dao3=M('subject');
                $dao4=M('class_branch');
                $f5=$dao3->where($where1)->field('subjectid,subjectname')->select();
                $f6=$dao4->where($where1)->field('branchid,branch')->select();
                foreach($f5 as $k=>$v){
                    $arr4[$v['subjectid']]=$v['subjectname'];
                }
                foreach($f6 as $k=>$v){
                    $arr5[$v['branchid']]=$v['branch'];
                }
                foreach($f4 as $k=>$v){
                    $arr7['branchid']=$v['branch'];
                    $arr7['branchname']=$arr5[$v['branch']];
                    $arr8[$v['branch']]=$arr7;
                    $f4[$k]['branch']=$arr5[$v['branch']];
                    if(is_numeric($v['subject'])){
                        $f4[$k]['subject']=$arr4[$v['subject']];
                    }
                }
                $arr6['data']=$f4;
                $arr6['scorenamelist']=$f7['0'];
                $arr6['branchlist']=array_values($arr8);
                $this->ajaxReturn($arr6);
            }elseif(I('get.typename')=='scorename'){/******************划线名称设置**********************/
                $data1=$_POST;
                $examinationid=$data1['examinationid'];
                $scId=$getSession['scId'];
                $where['examinationid']=$examinationid;
                $where['scId']=$scId;
                $dao=M('examination_score');
                $data['name1']=$data1['name1'];
                $data['name2']=$data1['name2'];
                $data['name3']=$data1['name3'];
                $data['name4']=$data1['name4'];
                $data['name5']=$data1['name5'];
                $data['name6']=$data1['name6'];
                $i=1;
                foreach($data as $k=>$v){
                    if($v==''){
                        $strn='score'.$i;
                        $data[$strn]=null;
                    }
                    $i++;
                }
                $f1=$dao->where($where)->data($data)->save();
                if($f1===false){
                    $arr['return']=false;
                }else{
                    $arr['return']=true;
                }
                $this->ajaxReturn($arr);
            }elseif(I('get.typename')=='scoreupdate'){/***************修改划线人数***************/
                $data1=$_POST;
                $scId=$getSession['scId'];
                $examinationid=$data1['examinationid'];
                $id=$data1['id'];
                $branchid=$data1['branchid'];
                $data['score1']=$data1['score1'];
                $data['score2']=$data1['score2'];
                $data['score3']=$data1['score3'];
                $data['score4']=$data1['score4'];
                $data['score5']=$data1['score5'];
                $data['score6']=$data1['score6'];
                if($branchid && $examinationid){
                    $dao1=M();
                    $sql1="SELECT subjectid,results FROM `mks_examination_results` WHERE examinationid=".$examinationid." AND branchid=".$branchid." ORDER BY results DESC";
                    $f1=$dao1->query($sql1);
                    $sql2="SELECT SUM(results) AS results FROM `mks_examination_results` WHERE examinationid=".$examinationid." AND branchid=".$branchid." group by userid ORDER BY results DESC";
                    $f2=$dao1->query($sql2);
                    foreach($f1 as $k=>$v){
                        $arr1[$v['subjectid']][]=$v['results'];
                    }
                    $where1['examinationid']=$examinationid;
                    $where1['branchid']=$branchid;
                    foreach($arr1 as $k=>$v){
                        $z=0;
                        $where1['ensubjectid']=$k;
                        foreach($data as $a=>$b){
                            if($b){
                                $z+=$b;
                                $s=$z-1;
                                if($s>count($arr1[$k])){
                                    $data1[$a]=$v[count($arr1[$k])-1];
                                }else{
                                    $data1[$a]=$v[$s];
                                }
                            }
                        }
                        $dao=M('examination_score');
                        $data['lastRecordTime']=time();
                        $f1=$dao->where($where1)->data($data1)->save();
                    }
                    $where1['ensubjectid']='总分';
                    $z=0;
                    foreach($data as $a=>$b){
                        if($b){
                            $z+=$b;
                            $s=$z-1;
                            if($s>count($f2)){
                                $data1[$a]=$f2[count($f2)-1]['results'];
                            }else{
                                $data1[$a]=$f2[$s]['results'];
                            }
                        }
                    }
                    $f1=$dao->where($where1)->data($data1)->save();
                }elseif($id){
                    $where1['id']=$id;
                    $where1['scId']=$scId;
                    $dao=M('examination_score');
                    $data['lastRecordTime']=time();
                    $f1=$dao->where($where1)->data($data)->save();
                }
                if($f1===false){
                    $arr['return']=false;
                }else{
                    $arr['return']=true;
                }
                $this->ajaxReturn($arr);
            }elseif(I('get.typename')=='scoredel'){/**********************清空划线**************************/
                $data1=$_POST;
                $scId=$getSession['scId'];
                $examinationid=$data1['examinationid'];
                $where['examinationid']=$examinationid;
                $where['scId']=$scId;
                $dao=M('examination_score');
                $f1=$dao->where($where)->delete();
                if($f1===false){
                    $arr['return']=false;
                }else{
                    $arr['return']=true;
                }
                $this->ajaxReturn($arr);
            }elseif(I('get.typename')=='scoreexport'){/*********************导出************************/
                $examinationid=I('get.examinationid');
                $dao2=M('examination_score');
                $where1['scId']=$getSession['scId'];
                $where['examinationid']=$examinationid;
                $where['scId']=$getSession['scId'];
                $f4=$dao2->where($where)->field('branchid as branch,ensubjectid as subject,score1,score2,score3,score4,score5,score6')->select();
                $f7=$dao2->where($where)->field('name1,name2,name3,name4,name5,name6')->limit(1)->select();
                $dao3=M('subject');
                $dao4=M('class_branch');
                $f5=$dao3->where($where1)->field('subjectid,subjectname')->select();
                $f6=$dao4->where($where1)->field('branchid,branch')->select();
                foreach($f5 as $k=>$v){
                    $arr4[$v['subjectid']]=$v['subjectname'];
                }
                foreach($f6 as $k=>$v){
                    $arr5[$v['branchid']]=$v['branch'];
                }
                foreach($f4 as $k=>$v){
                    $f4[$k]['branch']=$arr5[$v['branch']];
                    if(is_numeric($v['subject'])){
                        $f4[$k]['subject']=$arr4[$v['subject']];
                    }
                }
                $arr6['data']=$f4;
                $arr6['scorenamelist']=$f7['0'];
                vendor("PHPExcel.PHPExcel");
                $objPHPExcel = new \PHPExcel();
                // Set properties
                //$objPHPExcel->getProperties()->setCreator("cdn");
                //$objPHPExcel->getProperties()->setLastModifiedBy("cdn");
                $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
                $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
                $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

// Add some data
                $objPHPExcel->setActiveSheetIndex(0);
                //$objPHPExcel->getActiveSheet()->setTitle('CDN');
                $objPHPExcel->getActiveSheet()->SetCellValue('A1', '科类');
                $objPHPExcel->getActiveSheet()->SetCellValue('B1', '科目');
                /*$n=1;
                foreach($arr6['scorenamelist'] as $k=>$v){
                    $st='name'.$n;
                    if(){}
                }*/
                $objPHPExcel->getActiveSheet()->SetCellValue('C1', $arr6['scorenamelist']['name1']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D1', $arr6['scorenamelist']['name2']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E1', $arr6['scorenamelist']['name3']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F1', $arr6['scorenamelist']['name4']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G1', $arr6['scorenamelist']['name5']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H1', $arr6['scorenamelist']['name6']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I1', $arr6['scorenamelist']['name7']);
                $i = 2;
                foreach ($arr6['data'] as $k => $v) {
                    $num = $i++;
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $num, $v['branch']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $num, $v['subject']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $num, $v['score1']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $num, $v['score2']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $num, $v['score3']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $num, $v['score4']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $num, $v['score5']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $num, $v['score6']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $num, $v['score7']);
                }
// Save Excel 2007 file
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                ob_end_clean();
                header("Content-Disposition:attachment;filename=tableExport.xls");
                header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
            }elseif(I('get.typename')=='ratiofind'){/****************分数率设置查询*******************/
                $examinationid=I('post.examinationid');
                $scId=$getSession['scId'];
                $field=I('post.field');
                $order=I('post.order');
                if(!$field){
                    $field='branchid';
                }elseif($field=='branch'){
                    $field='branchid';
                }elseif($field=='subject'){
                    $field='ensubjectid';
                }
                if($order=='descing'){
                    $order='desc';
                }else{
                    $order='asc';
                }
                $where1['scId']=$scId;
                $where['scId']=$scId;
                $str=$field." ".$order;
                $dao1=M('examination_subject');
                $where['examinationid']=$examinationid;
                $dao2=M('examination_rate');
                $f2=$dao2->where($where)->count();
                if($f2==0){
                    $f1=$dao1->field('subject,branchid,results')->where($where)->select();
                    foreach($f1 as $k=>$v){
                        $arr1[$v['branchid']][]=$v['subject'];
                        $arr9[$v['branchid']][$v['subject']]=$v['results'];
                        if(isset($arr10[$v['branchid']])){
                            $arr10[$v['branchid']]+=$v['results'];
                        }else{
                            $arr10[$v['branchid']]=$v['results'];
                        }
                    }
                    foreach($arr1 as $k=>$v){
                        $arr1[$k][]='总分';
                    }
                    foreach($arr1 as $k=>$v){
                        foreach($v as $m=>$n){
                            $arr2['branchid']=$k;
                            $arr2['ensubjectid']=$n;
                            $arr2['lastRecordTime']=time();
                            $arr2['createTime']=time();
                            $arr2['examinationid']=$examinationid;
                            $arr2['scId']=$scId;
                            if(is_numeric($n)){
                                $arr2['excellent']=$arr9[$k][$n]*8/10;
                                $arr2['pass']=$arr9[$k][$n]*6/10;
                                $arr2['lowscore']=$arr9[$k][$n]*3/10;
                                $arr2['fullscore']=$arr9[$k][$n];
                            }else{
                                $arr2['excellent']=$arr10[$k]*8/10;
                                $arr2['pass']=$arr10[$k]*6/10;
                                $arr2['lowscore']=$arr10[$k]*3/10;
                                $arr2['fullscore']=$arr10[$k];
                            }
                            $arr3[]=$arr2;
                        }
                    }
                    $f3=$dao2->addAll($arr3);
                }
                $f4=$dao2->where($where)->field('id,branchid as branch,ensubjectid as subject,fullscore,excellent,pass,lowscore')->order($str)->select();
                $dao3=M('subject');
                $dao4=M('class_branch');
                $f5=$dao3->where($where1)->field('subjectid,subjectname')->select();
                $f6=$dao4->where($where1)->field('branchid,branch')->select();
                $f7=$f1=$dao1->field('subject,branchid,results')->where($where)->select();
                foreach($f5 as $k=>$v){
                    $arr4[$v['subjectid']]=$v['subjectname'];
                }
                foreach($f6 as $k=>$v){
                    $arr5[$v['branchid']]=$v['branch'];
                }
                foreach($f4 as $k=>$v){
                    $f4[$k]['branch']=$arr5[$v['branch']];
                    if(is_numeric($v['subject'])){
                        $f4[$k]['subject']=$arr4[$v['subject']];
                    }
                }
                $arr6=$f4;
                $this->ajaxReturn($arr6);
            }elseif(I('get.typename')=='ratioup'){/***********************快速设置*************************/
                $data1=$_POST;
                $scId=$getSession['scId'];
                $examinationid=$data1['examinationid'];
                $id=$data1['id'];
                $dao=M('examination_rate');
                $where['examinationid']=$examinationid;
                $where['scId']=$scId;
                $f=$dao->where($where)->field('id,fullscore')->select();
                if($examinationid&&!$id){
                    foreach($f as $k=>$v){
                        $where1['id']=$v['id'];
                        $data['excellent']=$v['fullscore']*$data1['excellent']/100;
                        $data['pass']=$v['fullscore']*$data1['pass']/100;
                        $data['lowscore']=$v['fullscore']*$data1['lowscore']/100;
                        $data['lastRecordTime']=time();
                        $f1=$dao->where($where1)->data($data)->save();
                    }
                }elseif($id){
                    $where1['id']=$id;
                    $data['excellent']=$data1['excellent'];
                    $data['pass']=$data1['pass'];
                    $data['lowscore']=$data1['lowscore'];
                    $data['lowscore']=$v['fullscore']*$data1['lowscore']/100;
                    $f1=$dao->where($where1)->data($data)->save();
                }
                if($f1===false){
                    $arr['return']=false;
                }else{
                    $arr['return']=true;
                }
                $this->ajaxReturn($arr);
            }elseif(I('get.typename')=='ratiodel'){/*******************清空*********************/
                $data1=$_POST;
                $scId=$getSession['scId'];
                $examinationid=$data1['examinationid'];
                $where['examinationid']=$examinationid;
                $where['scId']=$scId;
                $dao=M('examination_rate');
                $f1=$dao->where($where)->delete();
                if($f1===false){
                    $arr['return']=false;
                }else{
                    $arr['return']=true;
                }
                $this->ajaxReturn($arr);
            }elseif(I('get.typename')=='ratioexport'){/********************导出****************/
                $examinationid=I('get.examinationid');
                $dao2=M('examination_rate');
                $where1['scId']=$getSession['scId'];
                $where['scId']=$getSession['scId'];
                $where['examinationid']=$examinationid;
                $f4=$dao2->where($where)->field('branchid as branch,ensubjectid as subject,fullscore,excellent,pass,lowscore')->select();
                $dao3=M('subject');
                $dao4=M('class_branch');
                $f5=$dao3->where($where1)->field('subjectid,subjectname')->select();
                $f6=$dao4->where($where1)->field('branchid,branch')->select();
                foreach($f5 as $k=>$v){
                    $arr4[$v['subjectid']]=$v['subjectname'];
                }
                foreach($f6 as $k=>$v){
                    $arr5[$v['branchid']]=$v['branch'];
                }
                foreach($f4 as $k=>$v){
                    $f4[$k]['branch']=$arr5[$v['branch']];
                    if(is_numeric($v['subject'])){
                        $f4[$k]['subject']=$arr4[$v['subject']];
                    }
                }
                $arr6=$f4;
                vendor("PHPExcel.PHPExcel");
                $objPHPExcel = new \PHPExcel();
                // Set properties
                //$objPHPExcel->getProperties()->setCreator("cdn");
                //$objPHPExcel->getProperties()->setLastModifiedBy("cdn");
                $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
                $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
                $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

// Add some data
                $objPHPExcel->setActiveSheetIndex(0);
                //$objPHPExcel->getActiveSheet()->setTitle('CDN');
                $objPHPExcel->getActiveSheet()->SetCellValue('A1', '科类');
                $objPHPExcel->getActiveSheet()->SetCellValue('B1', '科目');
                $objPHPExcel->getActiveSheet()->SetCellValue('C1', '满分');
                $objPHPExcel->getActiveSheet()->SetCellValue('D1', '优秀');
                $objPHPExcel->getActiveSheet()->SetCellValue('E1', '及格');
                $objPHPExcel->getActiveSheet()->SetCellValue('F1', '低分');
                $i = 2;
                foreach ($arr6 as $k => $v) {
                    $num = $i++;
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $num, $v['branch']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $num, $v['subject']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $num, $v['fullscore']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $num, $v['excellent']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $num, $v['pass']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $num, $v['lowscore']);
                }
// Save Excel 2007 file
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                ob_end_clean();
                header("Content-Disposition:attachment;filename=tableExport.xls");
                header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
            }elseif(I('get.typename')=='levelfind'){/*********************等级设置查询********************/
                $examinationid=I('post.examinationid');
                $scId=$getSession['scId'];
                $field=I('post.field');
                $order=I('post.order');
                if(!$field){
                    $field='branchid';
                }elseif($field=='branch'){
                    $field='branchid';
                }elseif($field=='subjectid'){
                    $field='ensubject';
                }
                if($order=='descing'){
                    $order='desc';
                }else{
                    $order='asc';
                }
                $where1['scId']=$scId;
                $where['scId']=$scId;
                $str=$field." ".$order;
                $where['examinationid']=$examinationid;
                $dao2=M('examination_level');
                $f4=$dao2->where($where)->field('id,branchid as branch,ensubjectid as subject,score1,score2,score3,score4,score5,score6,score7,score8,score9,score10,score11,score12,enable')->order($str)->select();
                $f7=$dao2->where($where)->field('name1,name2,name3,name4,name5,name6,name7,name8,name9,name10,name11,name12')->limit(1)->select();
                $dao3=M('subject');
                $dao4=M('class_branch');
                $f5=$dao3->where($where1)->field('subjectid,subjectname')->select();
                $f6=$dao4->where($where1)->field('branchid,branch')->select();
                foreach($f5 as $k=>$v){
                    $arr4[$v['subjectid']]=$v['subjectname'];
                }
                foreach($f6 as $k=>$v){
                    $arr5[$v['branchid']]=$v['branch'];
                }
                foreach($f4 as $k=>$v){
                    $f4[$k]['branch']=$arr5[$v['branch']];
                    if(is_numeric($v['subject'])){
                        $f4[$k]['subject']=$arr4[$v['subject']];
                    }
                }
                $arr6['data']=$f4;
                $arr6['namelist']=$f7['0'];
                $this->ajaxReturn($arr6);
            }elseif(I('get.typename')=='levelinsert'){/******************快速设置***************/
                $examinationid=I('post.examinationid');
                $where1['scId']=$getSession['scId'];
                $where['scId']=$getSession['scId'];
                $dat1=$_POST;
                $dao1=M('examination_subject');
                $where['examinationid']=$examinationid;
                $dao2=M('examination_level');
                $f1=$dao1->field('subject,branchid,results')->where($where)->select();
                $f2=$dao2->where($where)->delete();
                if($f2!==false){
                    foreach($f1 as $k=>$v){
                        $arr1[$v['branchid']][]=$v['subject'];
                        $arr9[$v['branchid']][$v['subject']]=$v['results'];
                        if(isset($arr10[$v['branchid']])){
                            $arr10[$v['branchid']]+=$v['results'];
                        }else{
                            $arr10[$v['branchid']]=$v['results'];
                        }
                    }
                    foreach($arr1 as $k=>$v){
                        $arr1[$k][]='总分';
                    }
                    if(!$dat1['ratio1']){
                        $dat1['ratio1']=90;
                    }
                    if(!$dat1['ratio2']){
                        $dat1['ratio2']=80;
                    }
                    if(!$dat1['ratio3']){
                        $dat1['ratio3']=70;
                    }
                    if(!$dat1['ratio4']){
                        $dat1['ratio4']=60;
                    }
                    if(!$dat1['ratio5']){
                        $dat1['ratio5']=55;
                    }
                    if(!$dat1['ratio6']){
                        $dat1['ratio6']=50;
                    }
                    if(!$dat1['ratio7']){
                        $dat1['ratio7']=45;
                    }
                    if(!$dat1['ratio8']){
                        $dat1['ratio8']=40;
                    }
                    if(!$dat1['ratio9']){
                        $dat1['ratio9']=35;
                    }
                    if(!$dat1['ratio10']){
                        $dat1['ratio10']=20;
                    }
                    if(!$dat1['ratio11']){
                        $dat1['ratio11']=15;
                    }
                    if(!$dat1['ratio12']){
                        $dat1['ratio12']=10;
                    }
                    foreach($arr1 as $k=>$v) {
                        foreach ($v as $m => $n) {
                            $arr2['branchid'] = $k;
                            $arr2['ensubjectid'] = $n;
                            $arr2['lastRecordTime'] = time();
                            $arr2['createTime'] = time();
                            $arr2['examinationid'] = $examinationid;
                            if (is_numeric($n)) {
                                $result=$arr9[$k][$n];
                            }else{
                                $result=$arr10[$k];
                            }
                            if($dat1['name1']){
                                $arr2['score1'] = $result * $dat1['ratio1'] / 100;
                                $arr2['name1'] = $dat1['name1'];
                            }
                            if($dat1['name2']){
                                $arr2['score2'] = $result * $dat1['ratio2'] / 100;
                                $arr2['name2'] = $dat1['name2'];
                            }
                            if($dat1['name3']){
                                $arr2['score3'] = $result * $dat1['ratio3'] / 100;
                                $arr2['name3'] = $dat1['name3'];
                            }
                            if($dat1['name4']){
                                $arr2['score4'] = $result * $dat1['ratio4'] / 100;
                                $arr2['name4'] = $dat1['name4'];
                            }
                            if($dat1['name5']){
                                $arr2['score5'] = $result * $dat1['ratio5'] / 100;
                                $arr2['name5'] = $dat1['name5'];
                            }
                            if($dat1['name6']){
                                $arr2['score6'] = $result * $dat1['ratio6'] / 100;
                                $arr2['name6'] = $dat1['name6'];
                            }
                            if($dat1['name7']){
                                $arr2['score7'] = $result * $dat1['ratio7'] / 100;
                                $arr2['name7'] = $dat1['name7'];
                            }
                            if($dat1['name8']){
                                $arr2['score8'] = $result * $dat1['ratio8'] / 100;
                                $arr2['name8'] = $dat1['name8'];
                            }
                            if($dat1['name9']){
                                $arr2['score9'] = $result * $dat1['ratio9'] / 100;
                                $arr2['name9'] = $dat1['name9'];
                            }
                            if($dat1['name10']){
                                $arr2['score10'] = $result * $dat1['ratio10'] / 100;
                                $arr2['name10'] = $dat1['name10'];
                            }
                            if($dat1['name11']){
                                $arr2['score11'] = $result * $dat1['ratio11'] / 100;
                                $arr2['name11'] = $dat1['name11'];
                            }
                            if($dat1['name12']){
                                $arr2['score12'] = $result * $dat1['ratio12'] / 100;
                                $arr2['name12'] = $dat1['name12'];
                            }
                            $arr3[] = $arr2;
                        }
                    }
                    $f11=$dao2->addAll($arr3);
                    if($f11===false){
                        $arrj['return']=false;
                    }else{
                        $arrj['return']=true;
                    }
                }else{
                    $arrj['return']=false;
                }
                $this->ajaxReturn($arrj);
            }elseif(I('get.typename')=='leveldel'){/******************清空***************/
                $examinationid=I('post.examinationid');
                $where['scId']=$getSession['scId'];
                $where['examinationid']=$examinationid;
                $dao2=M('examination_level');
                $f2=$dao2->where($where)->delete();
                if($f2===false){
                    $arrj['return']=false;
                }else{
                    $arrj['return']=true;
                }
                $this->ajaxReturn($arrj);
            }elseif(I('get.typename')=='levelupdate'){/******************修改***************/
                $da1=$_POST;
                $where['id']=$da1['id'];
                $where['scId']=$getSession['scId'];
                $data['enable']=$da1['enable'];
                $data['score1']=$da1['score1'];
                $data['score2']=$da1['score2'];
                $data['score3']=$da1['score3'];
                $data['score4']=$da1['score4'];
                $data['score5']=$da1['score5'];
                $data['score6']=$da1['score6'];
                $data['score7']=$da1['score7'];
                $data['score8']=$da1['score8'];
                $data['score9']=$da1['score9'];
                $data['score10']=$da1['score10'];
                $data['score11']=$da1['score11'];
                $data['score12']=$da1['score12'];
                $dao=M('examination_level');
                $f=$dao->where($where)->data($data)->save();
                if($f===false){
                    $arrj['return']=false;
                }else{
                    $arrj['return']=true;
                }
                $this->ajaxReturn($arrj);
            }elseif(I('get.typename')=='levelexport'){/*********************导出************************/
                $examinationid=I('get.examinationid');
                $dao2=M('examination_level');
                $where1['scId']=$getSession['scId'];
                $where['scId']=$getSession['scId'];
                $where['examinationid']=$examinationid;
                $f4=$dao2->where($where)->field('branchid as branch,ensubjectid as subject,score1,score2,score3,score4,score5,score6,score7,score8,score9,score10,score11,score12')->select();
                $f7=$dao2->where($where)->field('name1,name2,name3,name4,name5,name6,name7,name8,name9,name10,name11,name12')->limit(1)->select();
                $dao3=M('subject');
                $dao4=M('class_branch');
                $f5=$dao3->where($where1)->field('subjectid,subjectname')->select();
                $f6=$dao4->where($where1)->field('branchid,branch')->select();
                foreach($f5 as $k=>$v){
                    $arr4[$v['subjectid']]=$v['subjectname'];
                }
                foreach($f6 as $k=>$v){
                    $arr5[$v['branchid']]=$v['branch'];
                }
                foreach($f4 as $k=>$v){
                    $f4[$k]['branch']=$arr5[$v['branch']];
                    if(is_numeric($v['subject'])){
                        $f4[$k]['subject']=$arr4[$v['subject']];
                    }
                }
                $arr6['data']=$f4;
                $arr6['scorenamelist']=$f7['0'];
                vendor("PHPExcel.PHPExcel");
                $objPHPExcel = new \PHPExcel();
                // Set properties
                //$objPHPExcel->getProperties()->setCreator("cdn");
                //$objPHPExcel->getProperties()->setLastModifiedBy("cdn");
                $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
                $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
                $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

// Add some data
                $objPHPExcel->setActiveSheetIndex(0);
                //$objPHPExcel->getActiveSheet()->setTitle('CDN');
                $objPHPExcel->getActiveSheet()->SetCellValue('A1', '科类');
                $objPHPExcel->getActiveSheet()->SetCellValue('B1', '科目');
                /*$n=1;
                foreach($arr6['scorenamelist'] as $k=>$v){
                    $st='name'.$n;
                    if(){}
                }*/
                $objPHPExcel->getActiveSheet()->SetCellValue('C1', $arr6['scorenamelist']['name1']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D1', $arr6['scorenamelist']['name2']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E1', $arr6['scorenamelist']['name3']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F1', $arr6['scorenamelist']['name4']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G1', $arr6['scorenamelist']['name5']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H1', $arr6['scorenamelist']['name6']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I1', $arr6['scorenamelist']['name7']);
                $objPHPExcel->getActiveSheet()->SetCellValue('J1', $arr6['scorenamelist']['name8']);
                $objPHPExcel->getActiveSheet()->SetCellValue('K1', $arr6['scorenamelist']['name9']);
                $objPHPExcel->getActiveSheet()->SetCellValue('L1', $arr6['scorenamelist']['name10']);
                $objPHPExcel->getActiveSheet()->SetCellValue('M1', $arr6['scorenamelist']['name11']);
                $objPHPExcel->getActiveSheet()->SetCellValue('N1', $arr6['scorenamelist']['name12']);
                $i = 2;
                foreach ($arr6['data'] as $k => $v) {
                    $num = $i++;
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $num, $v['branch']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $num, $v['subject']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $num, $v['score1']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $num, $v['score2']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $num, $v['score3']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $num, $v['score4']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $num, $v['score5']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $num, $v['score6']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $num, $v['score7']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $num, $v['score8']);
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $num, $v['score9']);
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $num, $v['score10']);
                    $objPHPExcel->getActiveSheet()->setCellValue('M' . $num, $v['score11']);
                    $objPHPExcel->getActiveSheet()->setCellValue('N' . $num, $v['score12']);
                }
// Save Excel 2007 file
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                ob_end_clean();
                header("Content-Disposition:attachment;filename=tableExport.xls");
                header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
            }
        }elseif(I('get.type')=='report'){/****************考务报表打印****************/
            if(I('get.typename')=='arrange'){/***********************考场安排情况*********************/
                $dao=M('examination_room');
                $where['examinationid']=I('post.examinationid');
                $where['scId']=$getSession['scId'];
                $f['data']=$dao->where($where)->field('room,seats,columns')->select();
                $f['examname']=$this->getExamName(I('post.examinationid'));
                $this->ajaxReturn($f);
            }elseif(I('get.typename')=='roomseat'){/***********************考场布局表*****************************/
                $dao1=M('examination_room');
                $dao2=M('examination_seat');
                $dao3=M('examination_arrange');
                $dao4=M('user');
                $dao5=M('examination_number');
                $examinationid=I('post.examinationid');
                $scId=$getSession['scId'];
                $gradeid=I('post.gradeid');
                $where['examinationid']=$examinationid;
                $where['scId']=$scId;
                $f1=$dao1->where($where)->field('id,room')->select();
                $f2=$dao2->where($where)->field('seatRow,seatCol,seatNumber,roomid')->select();
                $f3=$dao3->where($where)->field('userid,roomid,seatnumber')->select();
                $f5=$dao5->where($where)->field('userid,number')->select();
                $where1['gradeId']=$gradeid;
                $where1['scId']=$scId;
                $f4=$dao4->where($where1)->field('id,name')->select();
                foreach($f4 as $k=>$v){
                    $arr4[$v['id']]=$v['name'];
                }
                foreach($f5 as $k=>$v){
                    $arr5[$v['userid']]=$v['number'];
                }
                foreach($f3 as $k=>$v){
                    $arr3[$v['roomid']][$v['seatnumber']]['name']=$arr4[$v['userid']];
                    $arr3[$v['roomid']][$v['seatnumber']]['number']=$arr5[$v['userid']];
                }
                if(I('post.value')=='roomseat'){//考场布局表(考场粘贴)
                    foreach($f2 as $k=>$v){
                        $arr['seatRow']=$v['seatRow'];
                        $arr['seatCol']=$v['seatCol'];
                        $arr['seatNumber']=$v['seatNumber'];
                        $arr['name']=$arr3[$v['roomid']][$v['seatNumber']]['name'];
                        $arr['number']=$arr3[$v['roomid']][$v['seatNumber']]['number'];
                        $arr1[$v['roomid']][]=$arr;
                    }
                }elseif(I('post.value')=='seat'){//座签表(座位粘贴)
                    foreach($f2 as $k=>$v){
                        //$arr['seatRow']=$v['seatRow'];
                        //$arr['seatCol']=$v['seatCol'];
                        $arr['seatNumber']=$v['seatNumber'];
                        $arr['name']=$arr3[$v['roomid']][$v['seatNumber']]['name'];
                        $arr['number']=$arr3[$v['roomid']][$v['seatNumber']]['number'];
                        $arr1[$v['roomid']][]=$arr;
                    }
                }
                foreach($f1 as $k=>$v){
                    $arr2[$v['id']]['room']=$v['room'];
                    $arr2[$v['id']]['seat']=$arr1[$v['id']];
                }
                $data['examname']=$this->getExamName($examinationid);
                $data['data']=array_values($arr2);
                $this->ajaxReturn($data);
            }elseif(I('get.typename')=='classroom'){/*****************分班考场安排表*******************/
                $scId=$getSession['scId'];
                $where1['examinationid']=I('post.examinationid');
                $where1['scId']=$scId;
                $where2['gradeId']=I('post.gradeid');
                $where2['scId']=$scId;
                $dao1=M('examination_arrange');
                $f1=$dao1->where($where1)->select();
                if(I('post.value')=='class'){
                    $field='u.className,u.serialNumber asc';
                }elseif(I('post.value')=='room'){
                    $field='a.roomid,a.seatnumber asc';
                }
                if($f1===null){
                    $this->ajaxReturn($f1);
                }else {
                    $dao2 = M('');
                    $examinationid = I('post.examinationid');
                    $sql2 = "SELECT u.class,u.className,u.serialNumber,u.name,a.roomid,a.seatnumber,b.branch,n.number FROM `mks_examination_arrange` AS a,mks_user AS u,`mks_class_branch` AS b,`mks_examination_number` AS n WHERE a.userid=u.id AND a.branchid=b.branchid AND a.examinationid=n.examinationid AND a.userid=n.userid and u.scId=".$scId." AND a.examinationid=" . $examinationid . " order by ".$field;
                    $f2 = $dao2->query($sql2);
                    $dao3 = M('examination_room');
                    $f3 = $dao3->field('id,room')->where($where1)->select();

                    foreach ($f3 as $k => $v) {
                        $data1[$v['id']] = $v['room'];
                    }
                    if(I('post.value')=='class'){//分班考场安排表(发给班主任)
                        foreach ($f2 as $k => $v) {
                            $data2[$v['class']]['className'] = $v['className'];
                            $data2[$v['class']]['data'][$k]['serialNumber'] = $v['serialNumber'];
                            $data2[$v['class']]['data'][$k]['name'] = $v['name'];
                            $data2[$v['class']]['data'][$k]['room'] = $data1[$v['roomid']];
                            $data2[$v['class']]['data'][$k]['seatnumber'] = $v['seatnumber'];
                            $data2[$v['class']]['data'][$k]['number'] = $v['number'];
                        }
                    }elseif(I('post.value')=='room'){//考试安排表(发给监考员)
                        foreach ($f2 as $k => $v) {
                            $data2[$v['class']]['room'] = $data1[$v['roomid']];
                            $data2[$v['class']]['value'][$k]['serialNumber'] = $v['serialNumber'];
                            $data2[$v['class']]['value'][$k]['name'] = $v['name'];
                            $data2[$v['class']]['value'][$k]['className'] = $v['className'];
                            $data2[$v['class']]['value'][$k]['seatnumber'] = $v['seatnumber'];
                            $data2[$v['class']]['value'][$k]['number'] = $v['number'];
                        }
                    }
                    $data['examname']=$this->getExamName($examinationid);
                    $data['data']=array_values($data2);
                    $this->ajaxReturn($data);
                }
            }elseif(I('get.typename')=='roomcard'){/**********考场台卡***********/
                $examinationid=I('post.examinationid');
                $scId=$getSession['scId'];
                $where['examinationid']=$examinationid;
                $where['scId']=$scId;
                $dao=M('examination_room');
                $f=$dao->where($where)->field('room')->select();
                $data['examname']=$this->getExamName($examinationid);
                $data['room']=$f;
                $this->ajaxReturn($data);
            }elseif(I('get.typename')=='invigilatorsub'){/*************考试科目****************/
                $dao1=M();
                $scId=$getSession['scId'];
                $examinationid=I('post.examinationid');
                $sql1="SELECT s.`subjectname`,s.`subjectid` FROM `mks_examination_subject` AS e,`mks_subject` AS s WHERE e.subject=s.subjectid and e.scId=".$scId." AND e.`examinationid`=".$examinationid." GROUP BY s.`subjectid`";
                $f1['data']=$dao1->query($sql1);
                $f1['examname']=$this->getExamName($examinationid);
                $this->ajaxReturn($f1);
            }elseif(I('get.typename')=='invigilatorsign'){/**************监考签到******************/
                $dao1=M();
                $scId=$getSession['scId'];
                $subjectid=I('post.subjectid');
                $examinationid=I('post.examinationid');
                $sql1="SELECT s.`room`,u.`name` FROM mks_examination_subject AS e,`mks_examination_supervision` AS s,mks_user AS u WHERE u.`id`=s.`userid` AND e.`id`=s.`ensubjectid` AND s.scId=".$scId." AND e.`subject`=".$subjectid." AND s.examinationid=".$examinationid;
                $f1['data']=$dao1->query($sql1);
                $sql2="SELECT id,room FROM `mks_examination_room` WHERE examinationid=".$examinationid." AND scId=".$scId;
                $f2=$dao1->query($sql2);
                foreach($f2 as $k=>$v){
                    $data[$v['id']]=$v['room'];
                }
                foreach($f1['data'] as $k=>$v){
                    if(is_numeric($v['room'])){
                        $f1['data'][$k]['room']=$data[$v['room']];
                    }
                }
                $f1['examname']=$this->getExamName($examinationid);
                $this->ajaxReturn($f1);
            }elseif(I('get.typename')=='kaowu'){/*************考务会签到****************/
                $dao1=M();
                $scId=$getSession['scId'];
                $examinationid=I('post.examinationid');
                $sql1="SELECT u.`name`,u.`phone` FROM `mks_examination_supervision` AS s,`mks_user` AS u WHERE s.`examinationid`=".$examinationid." and s.scId=".$scId." AND s.`userid`=u.`id` GROUP BY s.`userid`";
                $f1['data']=$dao1->query($sql1);
                $f1['examname']=$this->getExamName($examinationid);
                $this->ajaxReturn($f1);
            }elseif(I('get.typename')=='jiankaotongji'){/******************************监考任务安排统计表******************/
                $dao1=M();
                $examinationid=I('post.examinationid');
                $scId=$getSession['scId'];
                $sql1="SELECT u.name,s.ensubjectid,s.`room`,s.`userid`,t.`date`,t.`starttime`,t.`endtime` FROM `mks_examination_supervision` AS s,`mks_examination_subject` AS t,mks_user as u WHERE u.id=s.userid AND s.examinationid=".$examinationid." and s.scId=".$scId." AND s.`ensubjectid`=t.`id`";
                $f1=$dao1->query($sql1);
                $invigilator=0;
                $visits=0;
                $totalinspection=0;
                foreach($f1 as $k=>$v){
                    $data[$v['userid']]['name']=$v['name'];
                    if($data[$v['userid']]['time']){
                        $data[$v['userid']]['time']+=strtotime($v['date']." ".$v['endtime'])-strtotime($v['date']." ".$v['starttime']);
                    }else{
                        $data[$v['userid']]['time']=strtotime($v['date']." ".$v['endtime'])-strtotime($v['date']." ".$v['starttime']);
                    }
                    if($v['room']=='巡考'){
                        if($data[$v['userid']]['visits']){
                            $data[$v['userid']]['visits']++;
                        }else{
                            $data[$v['userid']]['visits']=1;
                        }
                    }elseif($v['room']=='总巡考'){
                        if($data[$v['userid']]['totalinspection']){
                            $data[$v['userid']]['totalinspection']++;
                        }else{
                            $data[$v['userid']]['totalinspection']=1;
                        }
                    }elseif(is_numeric($v['room'])){
                        if($data[$v['userid']]['invigilator']){
                            $data[$v['userid']]['invigilator']++;
                        }else{
                            $data[$v['userid']]['invigilator']=1;
                        }
                    }
                }
                foreach($data as $k=>$v){
                    $arrn['invigilator']=$v['invigilator'];
                    $arrn['visits']=$v['visits'];
                    $arrn['totalinspection']=$v['totalinspection'];
                    $arrn['all']=$arrn['invigilator']+$arrn['visits']+$arrn['totalinspection'];
                    $arrn['time']=$v['time']/3600;
                    $arrn['timeaverage']=$arrn['time']/$arrn['all'];
                    $arrn['name']=$v['name'];
                    $data2['data'][]=$arrn;
                }
                $data2['examname']=$this->getExamName($examinationid);
                $this->ajaxReturn($data2);
            }elseif(I('get.typename')=='xueshengmingdan'){/*************上报学生名单和不上报学生名单*****************/
                $dao1=M();
                $examinationid=I('post.examinationid');
                $reported=I('post.reported');
                $scId=$getSession['scId'];
                $sql1="SELECT n.`number`,u.`name`,u.`sex`,u.hklx,b.branch,u.id FROM `mks_examination_student` AS s,`mks_examination_number` AS n,mks_user AS u,mks_class_branch AS b WHERE s.branch=b.branchid and s.`userid`=n.`userid` AND s.`userid`=u.`id` AND s.`examinationid`=".$examinationid." AND n.`examinationid`=".$examinationid." AND s.`reported`='".$reported."' and s.scId=".$scId;
                $f1=$dao1->query($sql1);
                $dao2=M('school');
                $where['scId']=$scId;
                $f2=$dao2->where($where)->field('scName')->select();
                $sql3="SELECT SUM(results) AS results,userid FROM `mks_examination_results` WHERE examinationid=".$examinationid." AND scId=".$scId." GROUP BY userid";
                $f3=$dao1->query($sql3);
                foreach($f3 as $k=>$v){
                    $data1[$v['userid']]=$v['results'];
                }
                foreach($f1 as $k=>$v){
                    $f1[$k]['scool']=$f2['0']['scName'];
                    $f1[$k]['results']=$data1[$v['id']];
                    unset($f1[$k]['id']);
                }
                $data2['data']=$f1;
                $data2['examname']=$this->getExamName($examinationid);
                $this->ajaxReturn($data2);
            }elseif(I('get.typename')=='bucankaoxuesheng'){/*************不参考学生名单*****************/
                $dao1=M();
                $scId=$getSession['scId'];
                $examinationid=I('post.examinationid');
                $sql1="SELECT u.`className`,u.`name` FROM `mks_examination_student` AS s,mks_user AS u WHERE s.`participate`='否' AND s.`userid`=u.`id` AND s.`examinationid`=".$examinationid." AND s.`scId`=".$scId;
                $f1['data']=$dao1->query($sql1);
                $f1['examname']=$this->getExamName($examinationid);
                $this->ajaxReturn($f1);
            }elseif(I('get.typename')=='jiankaozuoweika'){/*************监考座位卡*****************/
                $dao1=M();
                $scId=$getSession['scId'];
                $examinationid=I('post.examinationid');
                $sql1="SELECT u.`name` FROM `mks_examination_supervision` AS s,mks_user AS u WHERE s.`userid`=u.`id` AND s.`examinationid`=".$examinationid." AND s.`scId`=".$scId." GROUP BY s.`userid`";
                $f1['data']=$dao1->query($sql1);
                $f1['examname']=$this->getExamName($examinationid);
                $this->ajaxReturn($f1);
            }elseif(I('get.typename')=='zongmingce'){/*************总名册*****************/
                $dao=M();
                $examinationid=I('post.examinationid');
                $gradeid=I('post.gradeid');
                $scId=2;//$getSession['scId'];
                $sql1="SELECT n.`number`,u.`grade`,u.`className`,u.`name`,r.`room`,a.`seatnumber`,u.`idCard`,b.`branch`,u.class,u.id FROM `mks_examination_student` AS s,mks_user AS u,mks_examination_number AS n,mks_class_branch AS b,`mks_examination_arrange` AS a,mks_examination_room AS r WHERE s.`examinationid`=n.`examinationid` AND s.`examinationid`=a.`examinationid` AND s.`userid`=a.`userid` AND a.`roomid`=r.`id` AND s.`participate`='是' AND s.`userid`=u.`id` AND s.`userid`=n.`userid` AND s.`branch`=b.`branchid` AND s.`examinationid`=".$examinationid." and s.scId=".$scId;
                $sql2="SELECT s.`subjectId`,s.`classId`,s.`techerName`,t.`branchid` FROM `mks_jw_schedule` AS s,`mks_examination_subject` AS t WHERE s.scId=".$scId." AND s.gradeId=1 AND t.`examinationid`=149 AND t.`subject`=s.`subjectId`";
                $sql3="SELECT u.`className`,u.`class`,t.`subject`,j.`subjectname` FROM `mks_examination_subject` AS t,`mks_examination_student` AS s,mks_user AS u,mks_subject AS j WHERE j.`subjectid`=t.`subject` AND t.`examinationid`=s.`examinationid` AND s.`examinationid`=149 AND s.`userid`=u.`id` AND s.`branch`=t.`branchid` GROUP BY u.`class`,t.`subject`";
                $sql4="select scName from mks_school where scId=".$scId;
                $sql5="SELECT r.userId,r.regNumber FROM `mks_school_rollinfo` AS r,mks_user AS u WHERE r.scId=".$scId." AND u.gradeId=".$gradeid." AND u.`grade`=r.`grade`";

                $f1=$dao->query($sql1);
                $f2=$dao->query($sql2);
                $f3=$dao->query($sql3);
                $f4=$dao->query($sql4);
                $f5=$dao->query($sql5);
                echo $sql1;
                exit;
                foreach($f5 as $k=>$v){
                    $arr6[$v['userId']]=$v['regNumber'];
                }
                foreach($f3 as $k=>$v){
                    $arr5[$v['class']][$v['subject']]['subject']=$v['subjectname'];
                }
                //print_r($f1);
                //exit;
                //print_r($f1);
                //echo "<br>";
                //print_r($f2);
                foreach($f2 as $k=>$v){
                    $arr2[$v['classId']][$v['subjectId']]=$v['techerName'];
                }
                foreach($arr5 as $k=>$v){
                    foreach($v as $a=>$b){
                        $arr5[$k][$a]['teacher']=$arr2[$k][$a];
                    }
                }
                foreach($f1 as $k=>$v){
                    $f1[$k]['scName']=$f4['0']['scName'];
                    $arr4[$v['class']]['subjectlist']=array_values($arr5[$v['class']]);
                    unset($f1[$k]['class']);
                    $arr4[$v['class']]['students'][]=$f1[$k];
                }

                foreach($arr4 as $k=>$v){
                    foreach($v['students'] as $a=>$b){
                        $arr4[$k]['students'][$a]['regNumber']=$arr6[$b['id']];
                        unset($arr4[$k]['students'][$a]['id']);
                    }
                }
                $data=array_values($arr4);
                $this->ajaxReturn($data);
            }
        }
    }
    public function previousexam(){/**********************历次考试*********************/
        $getSession = $this->get_session('loginCheck',false);
        if(I('get.type')=='exam'){
            if(I('get.typename')=='findgrade'){/***********************年级列表****************/
                $where['scId']=$getSession['scId'];
                $arrgrade=array('一年级','二年级','三年级','四年级','五年级','六年级','初一','初二','初三','高一','高二','高三');
                $dao=M('grade');
                $f=$dao->where($where)->field('gradeid,name')->select();
                foreach($f as $k=>$v){
                    $key=$v['name']+1;
                    $f[$k]['name']=$arrgrade[$key];
                }
                $this->ajaxReturn($f);
            }elseif(I('get.typename')=='findexam') {/*******************考试查询*****************/
                $where['gradeid'] = I('post.gradeid');
                $where['scId'] =$getSession['scId'];
                $dao = M('examination');
                $f = $dao->where($where)->field('examinationid,examination,starttime,endtime,release')->select();
                foreach ($f as $k => $v) {
                    $data[$k]['examinationid'] = $v['examinationid'];
                    $data[$k]['examination'] = $v['examination'];
                    $data[$k]['date'] = $v['starttime'] . "-----" . $v['endtime'];
                    $data[$k]['release'] = $v['release'];
                }
                $this->ajaxReturn($data);
            }elseif(I('get.typename')=='examup'){/**************修改考试名****************/
                $where['examinationid'] = I('post.examinationid');
                $data['examination'] = I('post.examination');
                $data['lastRecordTime'] = time();
                $dao = M('examination');
                $f= $dao->where($where)->data($data)->save();
                if($f===false){
                    $arrj['return']=false;
                }else{
                    $arrj['return']=true;
                }
                $this->ajaxReturn($arrj);
            }elseif(I('get.typename')=='examdel'){/*******************删除考试*********************/
                $where['examinationid'] = I('post.examinationid');
                $where['scId'] =$getSession['scId'];
                $dao=M();
                M()->startTrans();
                $f2=$dao->where($where)->table('mks_examination_arrange')->delete();
                $f3=$dao->where($where)->table('mks_examination_level')->delete();
                $f4=$dao->where($where)->table('mks_examination_number')->delete();
                $f5=$dao->where($where)->table('mks_examination_rate')->delete();
                $f6=$dao->where($where)->table('mks_examination_results')->delete();
                $f13=$dao->where($where)->table('mks_examination_seat')->delete();

                $f8=$dao->where($where)->table('mks_examination_score')->delete();
                $f9=$dao->where($where)->table('mks_examination_student')->delete();
                $f10=$dao->where($where)->table('mks_examination_subject')->delete();
                $f11=$dao->where($where)->table('mks_examination_supervision')->delete();
                $f12=$dao->where($where)->table('mks_examination_teacher')->delete();
                $f7=$dao->where($where)->table('mks_examination_room')->delete();
                $f1=$dao->where($where)->table('mks_examination')->delete();
                //$f12=$dao->table()->delete();
                if($f1===false || $f2===false || $f3===false || $f4===false || $f5===false || $f6===false || $f7===false || $f8===false || $f9===false || $f10===false || $f11===false || $f12===false || $f13===false){
                    M()->rollback();
                    $a['return']=false;
                }else{
                    M()->commit();
                    $a['return']=true;
                }
                $this->ajaxReturn($a);
            }
        }
    }
}