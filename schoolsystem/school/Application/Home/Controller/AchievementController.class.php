<?php
namespace Home\Controller;
use Think\Controller;
class AchievementController extends Base {
    private function comparison($userid,$branchid,$classid,$examinationid){
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $dao=M();
        $sql1="SELECT t.`subjectid`,t.`subjectname` FROM mks_examination_subject AS s,mks_subject AS t WHERE s.`subject`=t.`subjectid` AND s.`examinationid`=".$examinationid." and s.scId=".$scId." and s.branchid=".$branchid." order by t.subjectid desc";//考试科目
        $f1=$dao->query($sql1);
        $sql2="SELECT userid,subjectid,results FROM `mks_examination_results` WHERE examinationid=".$examinationid." AND branchid=".$branchid." ORDER BY subjectid desc,results desc";//考试成绩用于排年级名次及成绩返回
        $f2=$dao->query($sql2);
        $sql4="SELECT userid,SUM(results) AS `sum` FROM `mks_examination_results` WHERE examinationid=".$examinationid." AND branchid=".$branchid." AND scId=".$scId." GROUP BY userid ORDER BY `sum` DESC";//用于排总成绩的年级名次及成绩
        $f4=$dao->query($sql4);
        $sql6="SELECT SUM(r.results) AS `sum`,r.`userid` FROM `mks_examination_results` AS r,mks_user AS u WHERE r.`userid`=u.`id` AND r.scId=".$scId." AND r.`examinationid`=".$examinationid." AND u.`class`=".$classid." GROUP BY r.`userid` ORDER BY `sum` DESC";//用于排总成绩的班级名次
        $f6=$dao->query($sql6);
        foreach($f6 as $k=>$v){
            $arr6[$v['userid']]=$k+1;
        }
        foreach($f2 as $k=>$v){
            unset($v['userid']);
            unset($v['subjectid']);
            $arr3[$f2[$k]['userid']][$f2[$k]['subjectid']]=$v['results'];
        }
        foreach($f4 as $k=>$v){
            $data4[$v['userid']]=$k+1;
        }
        $array['subjectlist']=$f1;
        $array['classscore']=$arr3[$userid];
        $array['gradeRanking']['total']=$data4[$userid];
        $array['classRanking']['total']=$arr6[$userid];
        return $array;
    }
    private function acfind($examinationid,$branchid,$classid,$subjectid){
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $dao=M();
        $sql1="SELECT t.`subjectid`,t.`subjectname` FROM mks_examination_subject AS s,mks_subject AS t WHERE s.`subject`=t.`subjectid` AND s.`examinationid`=".$examinationid." and s.scId=".$scId." and s.branchid=".$branchid." and t.subjectid in(".$subjectid.") order by t.subjectid desc";
        $f1=$dao->query($sql1);
        $sql2="SELECT s.userid,u.`name`,u.`serialNumber`,u.`className`,u.class as classid FROM `mks_examination_student` AS s,mks_user AS u WHERE s.`userid`=u.`id` and s.scId=".$scId." AND s.`examinationid`=".$examinationid." AND s.`participate`='是' AND u.`class` IN(".$classid.") order by u.`className`,u.`serialNumber`";
        $f2=$dao->query($sql2);
        $sql3="SELECT userid,subjectid,results FROM `mks_examination_results` WHERE examinationid=".$examinationid." AND branchid=".$branchid." and subjectid in(".$subjectid.") ORDER BY subjectid desc,results desc";
        $f3=$dao->query($sql3);
        $sql4="SELECT userid,SUM(results) AS `sum` FROM `mks_examination_results` WHERE examinationid=".$examinationid." AND branchid=".$branchid." AND scId=".$scId." GROUP BY userid ORDER BY `sum` DESC";
        $f4=$dao->query($sql4);
        $sql5="SELECT SUM(r.results) AS `sum`,r.`userid`,u.`class` FROM `mks_examination_results` AS r,mks_user AS u WHERE r.`userid`=u.`id` AND r.scId=".$scId." AND r.`examinationid`=".$examinationid." AND u.`class` IN(".$classid.") AND r.`branchid`=".$branchid." GROUP BY r.`userid` ORDER BY u.`class` DESC,`sum` DESC";
        $f5=$dao->query($sql5);
        foreach($f5 as $k=>$v){
            $data5[$v['class']][]=$v['userid'];
        }
        foreach($data5 as $k=>$v){
            foreach($v as $a=>$b){
                $aa=$a+1;
                $data6[$b]=$aa;
            }
        }
        foreach($f4 as $k=>$v){
            $data4[$v['userid']]=$k+1;
            $data3[$v['userid']]=$v['sum'];
        }
        foreach($f3 as $k=>$v){
            unset($v['userid']);
            unset($v['subjectid']);
            $arr3[$f3[$k]['userid']][$f3[$k]['subjectid']]=$v['results'];
        }
        foreach($f3 as $k=>$v){
            $data[$v['subjectid']][]=$v['userid'];
        }
        foreach($data as $k=>$v){
            foreach($v as $a=>$b){
                $aa=$a+1;
                $data1[$k][$b]=$aa;
            }
        }
        foreach($f2 as $k=>$v){
            $i=1;
            foreach($arr3[$v['userid']] as $a=>$b){
                $f2[$k][$a]['results']=$b;
                $f2[$k][$a]['ranking']=$data1[$a][$v['userid']];
                $i++;
            }
            $f2[$k]['totalScore']=$data3[$v['userid']];
            $f2[$k]['gradeRanking']=$data4[$v['userid']];
            $f2[$k]['classRanking']=$data6[$v['userid']];
        }
        $arr['subject']=$f1;
        $arr['student']=$f2;
        return $arr;
    }
    private function getExport($header,$data){
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
        $a=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $l=0;
        foreach($header as $k=>$v){
            $st=$a[$l];
            $objPHPExcel->getActiveSheet()->SetCellValue($st.'1',$v);
            $l++;
        }
        $i = 2;
        foreach ($data as $k => $v) {
            $num = $i++;
            $l=0;
            foreach($v as $c=>$b){
                $st=$a[$l];
                $objPHPExcel->getActiveSheet()->setCellValue($st . $num, $b);
                $l++;
            }
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
    private function findgrade(){/***********************年级列表****************/
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;//$getSession['scId'];
        $where['scId']=$scId;
        $dao=M('grade');
        $roleId=$getSession['roleId'];
        $arrgrade=array('一年级','二年级','三年级','四年级','五年级','六年级','初一','初二','初三','高一','高二','高三');
        if($roleId==$this::$teacherRoleId){
            $userid=$getSession['id'];
            $userid=18;
            $sql1="SELECT g.`gradeid`,g.`name` FROM `mks_jw_schedule` AS j,mks_grade AS g WHERE j.techerId=".$userid." AND j.`gradeId`=g.`gradeid` and j.scId=".$scId;
            $f1=$dao->query($sql1);
            $sql2="SELECT g.`gradeid`,g.`name` FROM `mks_class` AS c,mks_grade AS g WHERE c.`userid`=".$userid." and c.scId=".$scId." AND c.`grade`=g.`gradeid`";
            $f2=$dao->query($sql2);
            $sql3="SELECT gradeid,`name` FROM mks_grade WHERE userId=".$userid." AND scId=".$scId;
            $f3=$dao->query($sql3);
            foreach($f1 as $k=>$v){
                $f[$v['gradeid']]=$v;
            }
            foreach($f2 as $k=>$v){
                $f[$v['gradeid']]=$v;
            }
            foreach($f3 as $k=>$v){
                $f[$v['gradeid']]=$v;
            }
        }else{
            $f=$dao->where($where)->field('gradeid,name')->select();
        }
        foreach($f as $k=>$v){
            $key=$v['name']+1;
            $f[$k]['name']=$arrgrade[$key];
        }
        $this->ajaxReturn($f);
    }
    private function findexam($gradeid){/*******************考试查询*****************/
        $getSession = $this->get_session('loginCheck',false);
        $where['gradeid'] = $gradeid;
        $where['scId'] =2;// $getSession['scId'];
        $dao = M('examination');
        $f = $dao->where($where)->field('examinationid,examination,starttime,endtime,release')->select();
        foreach ($f as $k => $v) {
            $data[$k]['examinationid'] = $v['examinationid'];
            $data[$k]['examination'] = $v['examination'];
        }
        $this->ajaxReturn($data);
    }
    private function findsubject($examinationid,$branchid){
        $scId=2;
        $dao=M();
        $sql1="SELECT t.`subjectid`,t.`subjectname` FROM mks_examination_subject AS s,mks_subject AS t WHERE s.`subject`=t.`subjectid` AND s.`examinationid`=".$examinationid." and s.scId=".$scId." and s.branchid=".$branchid." order by t.subjectid";
        $f1=$dao->query($sql1);
        return $f1;
    }
    private function findclass($examinationid){/*******************对应考试的科类班级查询*****************/
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $sql1="SELECT class FROM `mks_examination` WHERE examinationid=".$examinationid." and scId=".$scId;
        $dao=M();
        $f1=$dao->query($sql1);
        $sql2="SELECT b.`branch`,b.branchid,c.`classid`,c.`classname` FROM mks_class AS c,mks_class_branch AS b WHERE c.`branch`=b.`branchid` and c.scId=".$scId." AND c.`classid` IN(".$f1['0']['class'].") order by c.classname";
        $f2=$dao->query($sql2);
        foreach($f2 as $k=>$v){
            $arr1['clsssid']=$v['classid'];
            $arr1['clsssname']=$v['classname'];
            $arr2[$v['branch']]['branch']=$v['branch'];
            $arr2[$v['branch']]['branchid']=$v['branchid'];
            $arr2[$v['branch']]['classlist'][]=$arr1;
        }
        $arr2=array_values($arr2);
        $this->ajaxReturn($arr2);
    }
    private function findClassAll($gradeid){/*******************对应年级的科类班级查询*****************/
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $dao=M();
        $sql2="SELECT b.`branch`,b.branchid,c.`classid`,c.`classname` FROM mks_class AS c,mks_class_branch AS b WHERE c.scId=".$scId." and c.`branch`=b.`branchid` AND c.grade=".$gradeid." order by c.classname";
        $f2=$dao->query($sql2);
        foreach($f2 as $k=>$v){
            $arr1['clsssid']=$v['classid'];
            $arr1['clsssname']=$v['classname'];
            $arr2[$v['branch']]['branch']=$v['branch'];
            $arr2[$v['branch']]['branchid']=$v['branchid'];
            $arr2[$v['branch']]['classlist'][]=$arr1;
        }
        $arr2=array_values($arr2);
        $this->ajaxReturn($arr2);
    }
    private function findbranch($examinationid){/*******************科类查询*****************/
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $sql1="SELECT class FROM `mks_examination` WHERE examinationid=".$examinationid." and scId=".$scId;
        $dao=M();
        $f1=$dao->query($sql1);
        $sql2="SELECT b.`branch`,b.branchid FROM mks_class AS c,mks_class_branch AS b WHERE c.`branch`=b.`branchid` AND c.`classid` IN(".$f1['0']['class'].")";

        $f2=$dao->query($sql2);
        foreach($f2 as $k=>$v){
            $arr[$v['branchid']]['branch']=$v['branch'];
            $arr[$v['branchid']]['branchid']=$v['branchid'];
        }
        $arr=array_values($arr);
        $this->ajaxReturn($arr);
    }
    private function getSubjectStatistics($examinationid,$statistics){
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $dao=M();
        $sql2="SELECT class FROM `mks_examination` WHERE examinationid=".$examinationid." and scId=".$scId;
        $f2=$dao->query($sql2);
        $class=$f2['0']['class'];
        if($statistics){
            $order='b.`branch`,s.`subjectname`,u.`className`';
            $sql1="SELECT b.`branch`,b.branchid,s.`subjectname`,u.`className`,u.`class` AS classid,r.`subjectid`,COUNT(r.userid) AS `join`,AVG(r.`results`) AS `avg`,MAX(r.`results`) AS `max`,MIN(r.`results`) AS `min`,SUM(CASE WHEN r.`results`>=e.`excellent` THEN 1 ELSE 0 END ) AS excellent,SUM(CASE WHEN (r.`results`<=e.`excellent` AND r.`results`>=e.`pass`) THEN 1 ELSE 0 END ) AS pass,SUM(CASE WHEN r.`results`<=e.`lowscore` THEN 1 ELSE 0 END ) AS lowscore FROM `mks_examination_results` AS r,mks_user AS u,mks_class_branch AS b,mks_subject AS s,`mks_examination_rate` AS e WHERE r.`subjectid`=s.`subjectid` AND r.`branchid`=b.`branchid` AND r.`examinationid`=".$examinationid." AND r.`examinationid`=e.`examinationid` and r.scId=".$scId." AND r.`subjectid`=e.`ensubjectid` AND r.`branchid`=e.`branchid` AND r.`userid`=u.`id` AND u.`class` IN(".$class.") GROUP BY b.`branchid`,r.`subjectid`";//年级统计
        }else{
            $order='s.`subjectname`,b.`branch`,u.`className`';
            $sql1="SELECT s.`subjectname`,u.`className`,u.`class` AS classid,r.`subjectid`,COUNT(r.userid) AS `join`,AVG(r.`results`) AS `avg`,MAX(r.`results`) AS `max`,MIN(r.`results`) AS `min`,SUM(CASE WHEN r.`results`>=e.`excellent` THEN 1 ELSE 0 END ) AS excellent,SUM(CASE WHEN (r.`results`<=e.`excellent` AND r.`results`>=e.`pass`) THEN 1 ELSE 0 END ) AS pass,SUM(CASE WHEN r.`results`<=e.`lowscore` THEN 1 ELSE 0 END ) AS lowscore FROM `mks_examination_results` AS r,mks_user AS u,mks_class_branch AS b,mks_subject AS s,`mks_examination_rate` AS e WHERE r.`subjectid`=s.`subjectid` AND r.`branchid`=b.`branchid` AND r.`examinationid`=".$examinationid." AND r.`examinationid`=e.`examinationid` AND r.`subjectid`=e.`ensubjectid` and r.scId=".$scId." AND r.`branchid`=e.`branchid` AND r.`userid`=u.`id` AND u.`class` IN(".$class.") GROUP BY r.`subjectid`";//年级统计
        }
        $sql3="SELECT b.`branch`,b.branchid,s.`subjectname`,u.`className`,u.`class` AS classid,r.`subjectid`,COUNT(r.userid) AS `join`,AVG(r.`results`) AS `avg`,MAX(r.`results`) AS `max`,MIN(r.`results`) AS `min`,SUM(CASE WHEN r.`results`>=e.`excellent` THEN 1 ELSE 0 END ) AS excellent,SUM(CASE WHEN (r.`results`< e.`excellent` AND r.`results`>=e.`pass`) THEN 1 ELSE 0 END ) AS pass,SUM(CASE WHEN r.`results`<=e.`lowscore` THEN 1 ELSE 0 END ) AS lowscore FROM `mks_examination_results` AS r,mks_user AS u,mks_class_branch AS b,mks_subject AS s,`mks_examination_rate` AS e WHERE r.`subjectid`=s.`subjectid` AND r.`branchid`=b.`branchid` AND r.`examinationid`=".$examinationid." AND r.`examinationid`=e.`examinationid` and r.scId=".$scId." AND r.`subjectid`=e.`ensubjectid` AND r.`branchid`=e.`branchid` AND r.`userid`=u.`id` AND u.`class` IN(".$class.") GROUP BY u.`class`,r.`subjectid` ORDER BY ".$order;//班统计
        $f3=$dao->query($sql3);
        $sql4="SELECT j.`techerName`,j.`classId`,j.`subjectId` FROM `mks_examination` AS e,`mks_jw_schedule` AS j WHERE e.`gradeid`=j.`gradeId` and e.scId=".$scId." AND e.`examinationid`=".$examinationid;
        $f4=$dao->query($sql4);
        foreach($f4 as $k=>$v){
            $arr4[$v['subjectId']][$v['classId']]=$v['techerName'];
        }
        $f1=$dao->query($sql1);
        if($statistics){
            foreach($f1 as $k=>$v){
                $excellentPercent=($v['excellent']/$v['join'])*100;
                $passPercent=($v['pass']/$v['join'])*100;
                $lowscorePercent=($v['lowscore']/$v['join'])*100;
                $data6[$v['branchid']][$v['subjectid']]['branch']=$v['branch'];
                $data6[$v['branchid']][$v['subjectid']]['subjectname']=$v['subjectname'];
                $data6[$v['branchid']][$v['subjectid']]['className']='全年级';
                $data6[$v['branchid']][$v['subjectid']]['join']=$v['join'];
                $data6[$v['branchid']][$v['subjectid']]['avg']=round($v['avg'],2);
                $data6[$v['branchid']][$v['subjectid']]['ranking']=null;
                $data6[$v['branchid']][$v['subjectid']]['max']=$v['max'];
                $data6[$v['branchid']][$v['subjectid']]['min']=$v['min'];
                $data6[$v['branchid']][$v['subjectid']]['excellent']=$v['excellent'];
                $data6[$v['branchid']][$v['subjectid']]['excellentPercent']=round($excellentPercent,2);
                $data6[$v['branchid']][$v['subjectid']]['pass']=$v['pass'];
                $data6[$v['branchid']][$v['subjectid']]['passPercent']=round($passPercent,2);
                $data6[$v['branchid']][$v['subjectid']]['lowscore']=$v['lowscore'];
                $data6[$v['branchid']][$v['subjectid']]['lowscorePercent']=round($lowscorePercent,2);
                $data6[$v['branchid']][$v['subjectid']]['teacher']=null;
            }
            foreach($f3 as $k=>$v){
                $arr1[$v['branchid']][$v['subjectid']][$v['classid']]=$v['avg'];
            }

            foreach($arr1 as $k=>$v){
                foreach($v as $c=>$d){
                    arsort($arr1[$k][$c]);
                    foreach($arr1[$k][$c] as $a=>$b){
                        $arr2[$c][$k][]=$a;
                    }
                }
            }
            foreach($arr2 as $k=>$v){
                $i=0;
                foreach($v as $a=>$b){
                    foreach($b as $c=>$d){
                        $arr3[$k][$d]=$c+1+$i;
                    }
                    $i=$c+1;
                }
            }
            //print_r($arr3);
            //exit;
        }else{
            foreach($f1 as $k=>$v){
                $excellentPercent=($v['excellent']/$v['join'])*100;
                $passPercent=($v['pass']/$v['join'])*100;
                $lowscorePercent=($v['lowscore']/$v['join'])*100;
                $data6[$v['subjectid']]['branch']=null;
                $data6[$v['subjectid']]['subjectname']=$v['subjectname'];
                $data6[$v['subjectid']]['className']='全年级';
                $data6[$v['subjectid']]['join']=$v['join'];
                $data6[$v['subjectid']]['avg']=round($v['avg'],2);
                $data6[$v['subjectid']]['ranking']=null;
                $data6[$v['subjectid']]['max']=$v['max'];
                $data6[$v['subjectid']]['min']=$v['min'];
                $data6[$v['subjectid']]['excellent']=$v['excellent'];
                $data6[$v['subjectid']]['excellentPercent']=round($excellentPercent,2);
                $data6[$v['subjectid']]['pass']=$v['pass'];
                $data6[$v['subjectid']]['passPercent']=round($passPercent,2);
                $data6[$v['subjectid']]['lowscore']=$v['lowscore'];
                $data6[$v['subjectid']]['lowscorePercent']=round($lowscorePercent,2);
                $data6[$v['subjectid']]['teacher']=null;
            }
            foreach($f3 as $k=>$v){
                $arr1[$v['subjectid']][$v['classid']]=$v['avg'];
            }
            foreach($arr1 as $k=>$v){
                arsort($arr1[$k]);
                foreach($arr1[$k] as $a=>$b){
                    $arr2[$k][]=$a;
                }
            }
            foreach($arr2 as $k=>$v){
                foreach($v as $a=>$b){
                    $arr3[$k][$b]=$a+1;
                }
            }
        }
        foreach($f3 as $k=>$v){
            $excellentPercent=($v['excellent']/$v['join'])*100;
            $passPercent=($v['pass']/$v['join'])*100;
            $lowscorePercent=($v['lowscore']/$v['join'])*100;
            $data1['branch']=$v['branch'];
            $data1['subjectname']=$v['subjectname'];
            $data1['className']=$v['className'];
            $data1['join']=$v['join'];
            $data1['avg']=round($v['avg'],2);
            $data1['ranking']=$arr3[$v['subjectid']][$v['classid']];
            $data1['max']=$v['max'];
            $data1['min']=$v['min'];
            $data1['excellent']=$v['excellent'];
            $data1['excellentPercent']=round($excellentPercent,2);
            $data1['pass']=$v['pass'];
            $data1['passPercent']=round($passPercent,2);
            $data1['lowscore']=$v['lowscore'];
            $data1['lowscorePercent']=round($lowscorePercent,2);
            $data1['teacher']=$arr4[$v['subjectid']][$v['classid']];
            $data2[]=$data1;
            $k2=$k+1;
            if($f3[$k]['subjectid']!=$f3[$k2]['subjectid']){
                if($statistics){
                    $data2[]=$data6[$v['branchid']][$v['subjectid']];
                }else{
                    $data2[]=$data6[$v['subjectid']];
                }
            }
        }
        return $data2;
    }
    private function getSubsection($examinationid,$section,$branchid){
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $roleId=$this::$teacherRoleId;
        $dao=M();
        $sql1="SELECT j.classid,j.className,COUNT(j.userid) AS `join`,AVG(j.results) AS `avg`,j.classid as ranking,MAX(j.results) AS `max`,MIN(j.results) AS `min`,SUM(CASE WHEN (j.`results`>=".$section['0']['from']." AND j.`results`<=".$section['0']['to'].") THEN 1 ELSE 0 END) AS section1,SUM(CASE WHEN (j.`results`>=".$section['1']['from']." AND j.`results`<=".$section['1']['to'].") THEN 1 ELSE 0 END) AS section2,SUM(CASE WHEN (j.`results`>=".$section['2']['from']." AND j.`results`<=".$section['2']['to'].") THEN 1 ELSE 0 END) AS section3,SUM(CASE WHEN (j.`results`>=".$section['3']['from']." AND j.`results`<=".$section['3']['to'].") THEN 1 ELSE 0 END) AS section4,SUM(CASE WHEN (j.`results`>=".$section['4']['from']." AND j.`results`<=".$section['4']['to'].") THEN 1 ELSE 0 END) AS section5,SUM(CASE WHEN (j.`results`>=".$section['5']['from']." AND j.`results`<=".$section['5']['to'].") THEN 1 ELSE 0 END) AS section6,SUM(CASE WHEN (j.`results`>=".$section['6']['from']." AND j.`results`<=".$section['6']['to'].") THEN 1 ELSE 0 END) AS section7,j.teacher FROM (SELECT r.`userid`,SUM(r.`results`) AS results,u.`class` AS classid,u.`className`,c.`userid` AS teacher FROM `mks_examination_results` AS r,mks_user AS u,mks_class AS c WHERE r.examinationid=".$examinationid." and r.scId=".$scId." and c.`classid`=u.`class` AND r.`userid`=u.`id` AND r.`branchid`=".$branchid." GROUP BY u.`class`,r.`userid`) AS j GROUP BY j.classid order by j.className";
        $f1=$dao->query($sql1);
        $sql2="SELECT id,name FROM mks_user WHERE roleId=".$roleId." AND scId=".$scId;
        $f2=$dao->query($sql2);
        foreach($f2 as $k=>$v){
            $teacher[$v['id']]=$v['name'];
        }
        foreach($f1 as $k=>$v){
            $data1[$v['classid']]=$v['avg'];
        }
        $i=1;
        foreach($data1 as $k=>$v){
            $data1[$k]=$i;
            $i++;
        }
        foreach($f1 as $k=>$v){
            unset($f1[$k]['classid']);
            $f1[$k]['ranking']=$data1[$v['classid']];
            $f1[$k]['teacher']=$teacher[$v['teacher']];
        }
        return $f1;
    }
    private function getAvg($examinationid,$branchid){
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $dao=M();
        $roleId=$this::$teacherRoleId;
        $subject=$this->findsubject($examinationid,$branchid);
        $sql1="SELECT sum(r.results) as resultsall,count(r.userid) as stuall,u.`className`,r.subjectid,u.class,AVG(r.`results`) AS `avg`,s.`subjectname`,c.`userid` AS teacher FROM `mks_examination_results` AS r,mks_user AS u,mks_class AS c,mks_subject AS s WHERE r.`subjectid`=s.`subjectid` AND u.`class`=c.`classid` AND r.`examinationid`=".$examinationid." AND r.`branchid`=".$branchid." AND r.`scId`=".$scId." AND r.`userid`=u.`id` GROUP BY r.`subjectid`,u.`class` ORDER BY r.`subjectid`,`avg` DESC";

        $f1=$dao->query($sql1);
        foreach($f1 as $k=>$v){
            $data1[$v['subjectid']][]=$v['class'];
        }
        foreach($data1 as $k=>$v){
            foreach($v as $a=>$b){
                $arr1[$b][$k]=$a+1;
            }
        }
        $sql2="SELECT id,name FROM mks_user WHERE roleId=".$roleId." AND scId=".$scId;
        $f2=$dao->query($sql2);
        foreach($f2 as $k=>$v){
            $data2[$v['id']]=$v['name'];
        }
        $sql3="SELECT j.class,SUM(j.`avg`) AS `sum`,j.stuall,j.resultsall FROM(SELECT count(r.userid) as stuall,u.class,AVG(r.`results`) AS `avg`,sum(r.results) as resultsall FROM `mks_examination_results` AS r,mks_user AS u,mks_class AS c WHERE u.`class`=c.`classid` AND r.`examinationid`=".$examinationid." AND r.`branchid`=".$branchid." AND r.`scId`=".$scId." AND r.`userid`=u.`id` GROUP BY r.`subjectid`,u.`class` ORDER BY r.`subjectid`,`avg` DESC) AS j GROUP BY j.class ORDER BY `sum` DESC";
        $f3=$dao->query($sql3);
        $resultsall=0;
        $stuall=0;
        foreach($f3 as $k=>$v){
            $data3[$v['class']]['totalRanking']=$k+1;
            $data3[$v['class']]['totalResults']=round($v['sum'],2);
            $resultsall+=$v['resultsall'];
            $stuall+=$v['stuall'];
        }
        $totalResults=round($resultsall/$stuall,2);
        $arrd=array();
        foreach($f1 as $k=>$v){
            $arra[$v['className']]['className']=$v['className'];
            $arra[$v['className']]['teacher']=$data2[$v['teacher']];
            $arra[$v['className']]['totalResults']=$data3[$v['class']]['totalResults'];
            $arra[$v['className']]['totalRanking']=$data3[$v['class']]['totalRanking'];
            $arra[$v['className']][$v['subjectid']]['resutls']=round($v['avg'],2);
            $arra[$v['className']][$v['subjectid']]['ranking']=$arr1[$v['class']][$v['subjectid']];
            if(!$arrd[$v['subjectid']]['resultsall']){
                $arrd[$v['subjectid']]['resultsall']=$v['resultsall'];
                $arrd[$v['subjectid']]['stuall']=$v['stuall'];
            }else{
                $arrd[$v['subjectid']]['resultsall']+=$v['resultsall'];
                $arrd[$v['subjectid']]['stuall']+=$v['stuall'];
            }
        }
        $arra['全年级']['className']='全年级';
        $arra['全年级']['teacher']=null;
        $arra['全年级']['totalResults']=0;
        $arra['全年级']['totalRanking']=null;
        foreach($arrd as $k=>$v){
            $arra['全年级'][$k]['resutls']=round($v['resultsall']/$v['stuall'],2);
            $arra['全年级'][$k]['totalRanking']=null;
            $arra['全年级']['totalResults']+=$arra['全年级'][$k]['resutls'];
        }
        foreach($arra as $k=>$v){
            $arrb[$k]["className"]=$v['className'];
            $arrb[$k]["totalResults"]=$v['totalResults'];
            $arrb[$k]["totalRanking"]=$v['totalRanking'];
            foreach($subject as $a=>$b){
                if(empty($arra[$k][$b['subjectid']])){
                    $arrb[$k][$b['subjectid']]['resutls']=null;
                    $arrb[$k][$b['subjectid']]['ranking']=null;
                }else{
                    $arrb[$k][$b['subjectid']]['resutls']=$v[$b['subjectid']]['resutls'];
                    $arrb[$k][$b['subjectid']]['ranking']=$v[$b['subjectid']]['ranking'];
                }
            }
            $arrb[$k]["teacher"]=$v['teacher'];
        }
        ksort($arrb);
        $arrb=array_values($arrb);
        $data['subjectlist']=$subject;;
        $data['data']=$arrb;
        return $data;
    }
    private function getTeacher($class,$subjectid){
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $dao=M();
        $sql="SELECT techerName FROM `mks_jw_schedule` WHERE subjectid=".$subjectid." AND classId=".$class." and scId=".$scId;
        $arr=$dao->query($sql);
        return $arr['0']['techerName'];
    }
    private function getHeadmaster($userid){
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $dao=M();
        $sql="SELECT name FROM `mks_user` WHERE id=".$userid." and scId=".$scId;
        $arr=$dao->query($sql);
        return $arr['0']['name'];
    }
    private function getRankingSubject($subjectid,$branchid,$examinationid,$rank1,$rank2,$rank3,$rank4,$rank5,$rank6){
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $dao=M();
        $sql1="SELECT subjectname,class,className,sum(rank) as `sum`,count(userid) as `join`,avg(rank) as `avg`,
            SUM(CASE WHEN rank<=".$rank1." THEN 1 ELSE 0 END ) AS rank1,
            SUM(CASE WHEN rank<=".$rank2." THEN 1 ELSE 0 END ) AS rank2,
            SUM(CASE WHEN rank<=".$rank3." THEN 1 ELSE 0 END ) AS rank3,
            SUM(CASE WHEN rank<=".$rank4." THEN 1 ELSE 0 END ) AS rank4,
            SUM(CASE WHEN rank<=".$rank5." THEN 1 ELSE 0 END ) AS rank5,
            SUM(CASE WHEN rank<=".$rank6." THEN 1 ELSE 0 END ) AS rank6 FROM (
            SELECT r.userid,su.subjectname,r.results,u.class,u.className,
            @curRank := IF(@preRank = results, @curRank, @incRank) AS rank,
            @incRank := @incRank + 1,
            @preRank := results
            FROM (SELECT @curRank := 0, @preRank := NULL, @incRank := 1) t,`mks_examination_results` r,mks_subject as su,mks_user u WHERE r.examinationid=".$examinationid." and r.scId=".$scId." AND r.subjectid=".$subjectid." and r.subjectid=su.subjectid AND r.branchid=".$branchid." AND r.userid=u.id
            ORDER BY results DESC) h GROUP BY class order by className";
        $f1=$dao->query($sql1);
        $rank1=0;
        $rank2=0;
        $rank3=0;
        $rank4=0;
        $rank5=0;
        $rank6=0;
        $sumall=0;
        $joinall=0;
        foreach($f1 as $k=>$v){
            $rank1+=$v['rank1'];
            $rank2+=$v['rank2'];
            $rank3+=$v['rank3'];
            $rank4+=$v['rank4'];
            $rank5+=$v['rank5'];
            $rank6+=$v['rank6'];
            $sumall+=$v['sum'];
            $joinall+=$v['join'];
            unset($f1[$k]['sum']);
            unset($f1[$k]['class']);
            $f1[$k]['avg']=round($v['avg'],2);
            $f1[$k]['teacherName']=$this->getTeacher($v['class'],$subjectid);
        }
        $arr['subjectname']=$f1['0']['subjectname'];
        $arr['className']='全年级';
        $arr['join']=$joinall;
        $arr['avg']=round($sumall/$joinall,2);
        $arr['rank1']=$rank1;
        $arr['rank2']=$rank2;
        $arr['rank3']=$rank3;
        $arr['rank4']=$rank4;
        $arr['rank5']=$rank5;
        $arr['rank6']=$rank6;
        $arr['teacherName']=null;
        $f1[]=$arr;
        return $f1;
    }
    private function getSum($branchid,$examinationid,$rank1,$rank2,$rank3,$rank4,$rank5,$rank6){
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $dao=M();
        $sql1="SELECT subjectname,className,SUM(rank) AS `sum`,COUNT(userid) AS `join`,AVG(rank) AS `avg`,
            SUM(CASE WHEN rank<=".$rank1." THEN 1 ELSE 0 END ) AS rank1,
            SUM(CASE WHEN rank<=".$rank2." THEN 1 ELSE 0 END ) AS rank2,
            SUM(CASE WHEN rank<=".$rank3." THEN 1 ELSE 0 END ) AS rank3,
            SUM(CASE WHEN rank<=".$rank4." THEN 1 ELSE 0 END ) AS rank4,
            SUM(CASE WHEN rank<=".$rank5." THEN 1 ELSE 0 END ) AS rank5,
            SUM(CASE WHEN rank<=".$rank6." THEN 1 ELSE 0 END ) AS rank6,teacherName FROM (
               SELECT subjectname,userid,results,class,className,teacherName,
            @curRank := IF(@preRank = results, @curRank, @incRank) AS rank,
            @incRank := @incRank + 1,
            @preRank := results
            FROM (SELECT @curRank := 0, @preRank := NULL, @incRank := 1) t,(SELECT r.subjectid as subjectname,r.userid,SUM(r.results) AS results,u.class,u.className,a.userid AS teacherName
            FROM `mks_examination_results` r,mks_class AS a,mks_user u
            WHERE r.examinationid=".$examinationid." and r.scId=".$scId." AND r.branchid=".$branchid." AND r.userid=u.id AND a.classid=u.class GROUP BY r.userid
            ORDER BY results DESC)z ORDER BY results DESC) h GROUP BY class ORDER BY className";
        $f1=$dao->query($sql1);
        $rank1=0;
        $rank2=0;
        $rank3=0;
        $rank4=0;
        $rank5=0;
        $rank6=0;
        $sumall=0;
        $joinall=0;
        foreach($f1 as $k=>$v){
            $rank1+=$v['rank1'];
            $rank2+=$v['rank2'];
            $rank3+=$v['rank3'];
            $rank4+=$v['rank4'];
            $rank5+=$v['rank5'];
            $rank6+=$v['rank6'];
            $sumall+=$v['sum'];
            $joinall+=$v['join'];
            unset($f1[$k]['sum']);
            unset($f1[$k]['class']);
            $f1[$k]['subjectname']='总分';
            $f1[$k]['teacherName']=$this->getHeadmaster($v['teacherName']);
            $f1[$k]['avg']=round($v['avg'],2);
        }
        $arr['subjectname']=$f1['0']['subjectname'];
        $arr['className']='全年级';
        $arr['join']=$joinall;
        $arr['avg']=round($sumall/$joinall,2);
        $arr['rank1']=$rank1;
        $arr['rank2']=$rank2;
        $arr['rank3']=$rank3;
        $arr['rank4']=$rank4;
        $arr['rank5']=$rank5;
        $arr['rank6']=$rank6;
        $arr['teacherName']=null;
        $f1[]=$arr;
        return $f1;
    }
    private function getContrastResultAll($examinationid1,$examinationid2,$branchid,$class){
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $dao = M();
        $subject1 = $this->findsubject($examinationid1, $branchid);
        $subject2 = $this->findsubject($examinationid2, $branchid);
        foreach ($subject1 as $k => $v) {
            $subject[$v['subjectid']] = $v;
        }
        foreach ($subject2 as $k => $v) {
            $subjectb[$v['subjectid']] = $v;
        }
        $subjecto='';
        foreach($subject as $k=>$v){
            if(!$subjectb[$k]){
                unset($subject[$k]);
            }else{
                $subjecto=$subjecto.$k.',';
            }
        }
        $subjecto=rtrim($subjecto,',');
        $subject = array_values($subject);
        if(empty($subject)){
            $arr=false;
            $this->ajaxReturn($arr);
        }else{
            $arr1=$this->getContrastResult($examinationid1,$class,$subjecto);
            $arr2=$this->getContrastResult($examinationid2,$class,$subjecto);
        }
        $sql1="SELECT u.`className`,u.`class`,u.`serialNumber`,u.`name`,r.userid FROM `mks_examination_results` AS r,mks_user AS u WHERE r.`examinationid`=".$examinationid1." and r.scId=".$scId." AND r.`userid`=u.`id` AND u.`class` IN(".$class.") GROUP BY r.`userid` ORDER BY u.className,u.serialNumber";
        $f1=$dao->query($sql1);
        $aaa['ranking']=null;
        $aaa['results']=null;
        foreach($f1 as $k=>$v){
            $data1[$v['userid']]['className']=$v['className'];
            $data1[$v['userid']]['serialNumber']=$v['serialNumber'];
            $data1[$v['userid']]['name']=$v['name'];
            if($arr1['all'][$v['userid']]){
                $data1[$v['userid']]['exam'][$examinationid1]['总分']=$arr1['all'][$v['userid']];
            }else{
                $data1[$v['userid']]['exam'][$examinationid1]['总分']=$aaa;
            }
            if($arr2['all'][$v['userid']]){
                $data1[$v['userid']]['exam'][$examinationid2]['总分']=$arr2['all'][$v['userid']];
                if($arr1['all'][$v['userid']]){
                    $data1[$v['userid']]['exam'][$examinationid2]['总分']['progress']=$arr2['all'][$v['userid']]['ranking']-$arr1['all'][$v['userid']]['ranking'];
                }else{
                    $data1[$v['userid']]['exam'][$examinationid2]['总分']['progress']==null;
                }
            }else{
                $data1[$v['userid']]['exam'][$examinationid2]['总分']=$aaa;
                $data1[$v['userid']]['exam'][$examinationid2]['总分']['progress']=null;
            }
            foreach($subject as $a=>$b){
                if($arr1['sub'][$b['subjectid']][$v['userid']]){
                    $data1[$v['userid']]['exam'][$examinationid1][$b['subjectid']]=$arr1['sub'][$b['subjectid']][$v['userid']];
                }else{
                    $data1[$v['userid']]['exam'][$examinationid1][$b['subjectid']]=$aaa;
                }
                if($arr2['sub'][$b['subjectid']][$v['userid']]){
                    $data1[$v['userid']]['exam'][$examinationid2][$b['subjectid']]=$arr2['sub'][$b['subjectid']][$v['userid']];
                }else{
                    $data1[$v['userid']]['exam'][$examinationid2][$b['subjectid']]=$aaa;
                }
            }
        }
        foreach($data1 as $k=>$v){
            $data1[$k]['exam']=array_values($data1[$k]['exam']);
        }
        $data1=array_values($data1);
        $arrr['subjectlist']=$subject;
        $arrr['data']=$data1;
        return $arrr;
    }
    private function getContrastResult($examinationid1,$class,$subjecto){
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $dao=M();
        $sql1 = "SELECT u.`class`,r.`results`,r.`subjectid`,r.userid FROM `mks_examination_results` AS r,mks_user AS u WHERE r.`examinationid`=" . $examinationid1 . " and r.scId=".$scId." AND r.`userid`=u.`id` AND u.`class` IN(" . $class . ") and r.subjectid in(".$subjecto.") ORDER BY r.`results` DESC";
        $f1 = $dao->query($sql1);
        foreach ($f1 as $k => $v) {
            $arr['userid'] = $v['userid'];
            $arr['results'] = $v['results'];
            $arr1[$v['subjectid']][] = $arr;
        }
        $ru = null;
        $key = 1;
        foreach ($arr1 as $k => $v) {
            foreach ($v as $a => $b) {
                if ($ru == $b['results']) {
                    $key = $key;
                } else {
                    $key = $a + 1;
                }
                $arra[$k][$b['userid']]['ranking'] = $key;
                $arra[$k][$b['userid']]['results'] = $b['results'];
                $ru = $b['results'];
            }
        }
        $sql2 = "SELECT r.userid,u.`class`,SUM(r.`results`) AS `sum` FROM `mks_examination_results` AS r,mks_user AS u WHERE r.`examinationid`=" . $examinationid1 . " and r.scId=".$scId." AND r.`userid`=u.`id` AND u.`class` IN(" . $class . ") GROUP BY r.`userid` ORDER BY `sum` DESC";
        $f2 = $dao->query($sql2);
        foreach ($f2 as $k => $v) {
            $arr['userid'] = $v['userid'];
            $arr['results'] = $v['sum'];
            $arr2[] = $arr;
            $arr3[$v['userid']]=$v;
        }
        $ru = null;
        $key = 1;
        foreach ($arr2 as $k => $v) {
            if ($ru == $v['results']) {
                $key = $key;
            } else {
                $key = $k+1;
            }
            $arrb[$v['userid']]['ranking']= $key;
            $arrb[$v['userid']]['results']= $v['results'];
            $ru = $v['results'];
        }
        $arrp['sub']=$arra;
        $arrp['all']=$arrb;
        return $arrp;
    }
    private function getContrastRank($branchid,$examinationid1,$examinationid2,$rank1,$rank2,$rank3,$rank4,$rank5,$rank6){
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $arr1=$this->getSum($branchid,$examinationid1,$rank1,$rank2,$rank3,$rank4,$rank5,$rank6);
        $arr2=$this->getSum($branchid,$examinationid2,$rank1,$rank2,$rank3,$rank4,$rank5,$rank6);
        foreach($arr1 as $k=>$v){
            unset($v['teacherName']);
            $arr[]=$v;
        }
        foreach($arr2 as $k=>$v){
            unset($v['teacherName']);
            $arra[$v['subjectname']][$v['className']]=$v;
        }
        $subject1 = $this->findsubject($examinationid1, $branchid);
        $subject2 = $this->findsubject($examinationid2, $branchid);
        foreach ($subject1 as $k => $v) {
            $subject[$v['subjectid']] = $v;
        }
        foreach ($subject2 as $k => $v) {
            $subjectb[$v['subjectid']] = $v;
        }
        foreach($subject as $k=>$v){
            if(!$subjectb[$k]){
                unset($subject[$k]);
            }
        }
        foreach($subject as $k=>$v){
            $arr1=$this->getRankingSubject($v['subjectid'],$branchid,$examinationid1,$rank1,$rank2,$rank3,$rank4,$rank5,$rank6);
            foreach($arr1 as $k=>$v){
                unset($v['teacherName']);
                $arr[]=$v;
            }
        }
        foreach($subject as $k=>$v){
            $arr1=$this->getRankingSubject($v['subjectid'],$branchid,$examinationid2,$rank1,$rank2,$rank3,$rank4,$rank5,$rank6);
            foreach($arr1 as $a=>$b){
                unset($b['teacherName']);
                $arra[$b['subjectname']][$b['className']]=$v;
            }
        }
        foreach($arr as $k=>$v){
            $arr[$k]['avga']=$arra[$v['subjectname']][$v['className']]['avg'];
            $arr[$k]['shortavg']=$arra[$v['subjectname']][$v['className']]['avg']-$v['avg'];
            $arr[$k]['ranka']=$arra[$v['subjectname']][$v['className']]['rank1'];
            $arr[$k]['shortrank1']=$arra[$v['subjectname']][$v['className']]['rank1']-$v['rank1'];
            $arr[$k]['rankb']=$arra[$v['subjectname']][$v['className']]['rank2'];
            $arr[$k]['shortrank2']=$arra[$v['subjectname']][$v['className']]['rank2']-$v['rank2'];
            $arr[$k]['rankc']=$arra[$v['subjectname']][$v['className']]['rank3'];
            $arr[$k]['shortrank3']=$arra[$v['subjectname']][$v['className']]['rank3']-$v['rank3'];
            $arr[$k]['rankd']=$arra[$v['subjectname']][$v['className']]['rank4'];
            $arr[$k]['shortrank4']=$arra[$v['subjectname']][$v['className']]['rank4']-$v['rank4'];
            $arr[$k]['ranke']=$arra[$v['subjectname']][$v['className']]['rank5'];
            $arr[$k]['shortrank5']=$arra[$v['subjectname']][$v['className']]['rank5']-$v['rank5'];
            $arr[$k]['rankf']=$arra[$v['subjectname']][$v['className']]['rank6'];
            $arr[$k]['shortrank6']=$arra[$v['subjectname']][$v['className']]['rank6']-$v['rank6'];
        }
        return $arr;
    }
    private function getContrastSubjectAvg($examinationid1,$branchid,$subjectid){
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $dao=M();
        $sq11="SELECT subjectname,className,result,`join`,`sum`,
            @curRank := IF(@preRank = result, @curRank, @incRank) AS rank,
            @incRank := @incRank + 1,
            @preRank := result
            FROM (SELECT @curRank := 0, @preRank := NULL, @incRank := 1) t,
            (SELECT su.subjectname,AVG(r.results) AS result,u.class,u.className,COUNT(r.userid) AS `join`,SUM(r.`results`) AS `sum`
            FROM `mks_examination_results` r,mks_subject AS su,mks_user u
            WHERE r.examinationid=".$examinationid1." and r.scId=".$scId." AND r.subjectid=".$subjectid." AND r.subjectid=su.subjectid AND r.branchid=".$branchid." AND r.userid=u.id GROUP BY u.class
            ORDER BY result DESC) AS z ORDER BY result DESC";
        $f1=$dao->query($sq11);
        $sum=0;
        $join=0;
        foreach($f1 as $k=>$v){
            unset($f1[$k]['@incRank := @incRank + 1']);
            unset($f1[$k]['@preRank := result']);
            unset($f1[$k]['sum']);
            $sum+=$v['sum'];
            $join+=$v['join'];
        }
        $arr['subjectname']=$f1['0']['subjectname'];
        $arr['className']='全年级';
        $arr['result']=round($sum/$join,2);
        $arr['join']=$join;
        $arr['rank']=null;
        $f1[]=$arr;
        foreach($f1 as $k=>$v){
            $arr1[$v['className']]=$v;
        }
        asort($arr1);
        return $arr1;
    }
    private function getContrastsum($examinationid1,$branchid){
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $dao=M();
        $sq11="SELECT class as subjectname,className,result,`join`,`sum`,
            @curRank := IF(@preRank = result, @curRank, @incRank) AS rank,
            @incRank := @incRank + 1,
            @preRank := result
            FROM (SELECT @curRank := 0, @preRank := NULL, @incRank := 1) t,
            (SELECT class,className,COUNT(userid) AS `join`,AVG(`sum`) AS result,SUM(`sum`) AS `sum` FROM(
            SELECT u.class,u.className,userid,SUM(r.`results`) AS `sum`
            FROM `mks_examination_results` r,mks_subject AS su,mks_user u
            WHERE r.examinationid=".$examinationid1." and r.scId=".$scId." AND r.subjectid=su.subjectid AND r.branchid=".$branchid." AND r.userid=u.id GROUP BY u.class,r.userid
            ORDER BY `sum` DESC) j GROUP BY class ORDER BY result DESC) AS z ORDER BY result DESC";
        $f1=$dao->query($sq11);
        $sum=0;
        $join=0;
        foreach($f1 as $k=>$v){
            unset($f1[$k]['@incRank := @incRank + 1']);
            unset($f1[$k]['@preRank := result']);
            unset($f1[$k]['sum']);
            $f1[$k]['subjectname']='总分';
            $sum+=$v['sum'];
            $join+=$v['join'];
        }
        $arr['subjectname']=$f1['0']['subjectname'];
        $arr['className']='全年级';
        $arr['result']=round($sum/$join,2);
        $arr['join']=$join;
        $arr['rank']=null;
        $f1[]=$arr;
        foreach($f1 as $k=>$v){
            $arr1[$v['className']]=$v;
        }
        asort($arr1);
        return $arr1;
    }
    private function getContrastAvg($examinationid1,$examinationid2,$branchid){
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $subject1 = $this->findsubject($examinationid1, $branchid);
        $subject2 = $this->findsubject($examinationid2, $branchid);

        foreach ($subject1 as $k => $v) {
            $subject[$v['subjectid']] = $v;
        }
        foreach ($subject2 as $k => $v) {
            $subjectb[$v['subjectid']] = $v;
        }
        foreach($subject as $k=>$v){
            if(!$subjectb[$k]){
                unset($subject[$k]);
            }
        }
        $arr1=$this->getContrastsum($examinationid1,$branchid);
        foreach($arr1 as $k=>$v){
            $arr[]=$v;
        }
        foreach($subject as $k=>$v){
            $arr1=$this->getContrastSubjectAvg($examinationid1,$branchid,$v['subjectid']);
            foreach($arr1 as $a=>$b){
                $arr[]=$b;
            }
        }
        $arr2=$this->getContrastsum($examinationid2,$branchid);
        foreach($arr2 as $k=>$v){
            $arra[$v['subjectname']][$v['className']]=$v;
        }
        foreach($subject as $k=>$v){
            $arr2=$this->getContrastSubjectAvg($examinationid1,$branchid,$v['subjectid']);
            foreach($arr2 as $a=>$b){
                $arra[$b['subjectname']][$b['className']]=$b;
            }
        }
        foreach($arr as $k=>$v){
            $arrc[$v['subjectname']][$v['className']]['subjectname']=$v['subjectname'];
            $arrc[$v['subjectname']][$v['className']]['className']=$v['className'];
            $arrc[$v['subjectname']][$v['className']]['join']=$v['join'];
            $arrc[$v['subjectname']][$v['className']]['result']=round($v['result'],2);
            $arrc[$v['subjectname']][$v['className']]['rank']=$v['rank'];
            $arrc[$v['subjectname']][$v['className']]['result1']=round($arra[$v['subjectname']][$v['className']]['result'],2);
            $arrc[$v['subjectname']][$v['className']]['coefficient']='';
            $arrc[$v['subjectname']][$v['className']]['targetresult']='';
            $arrc[$v['subjectname']][$v['className']]['retreat']='';
            $arrc[$v['subjectname']][$v['className']]['targetrank1']=$arra[$v['subjectname']][$v['className']]['rank'];
            $arrc[$v['subjectname']][$v['className']]['retreatrank']=$arra[$v['subjectname']][$v['className']]['rank']-$v['rank'];
        }
        foreach($arrc as $k=>$v){
            foreach($v as $a=>$b){
                $arrc[$k][$a]['coefficient']=round($b['result1']/$arrc[$k]['全年级']['result1'],2);
                $arrc[$k][$a]['targetresult']=round($arrc[$k]['全年级']['result']*$arrc[$k][$a]['coefficient'],2);
                $arrc[$k][$a]['retreat']=round($arrc[$k][$a]['result']-$arrc[$k][$a]['targetresult'],2);
                $arrn[]=$arrc[$k][$a];
            }
        }

        return $arrn;
    }
    private function getTotalOnline($examinationid){
        $getSession = $this->get_session('loginCheck',false);
        $scId=2;
        $dao=M();
        $sql1="SELECT COUNT(id) AS `count` FROM `mks_examination_score` WHERE examinationid=".$examinationid." AND (score1!='' OR score2!='' OR score3!='' OR score4!='' OR score5!='' OR score6!='')";//查询是否划线
        $f1=$dao->query($sql1);
        if($f1['0']){
            $sql1="SELECT r.branchid,b.branch FROM `mks_examination_results` AS r,mks_class_branch as b WHERE r.examinationid=".$examinationid." and r.scId=".$scId." and r.branchid=b.branchid GROUP BY r.branchid";//查询考试科类
            $f1=$dao->query($sql1);
            $sql="SELECT id,`name` FROM `mks_user` WHERE roleId=".$this::$teacherRoleId." AND scId=".$scId;//查询班主任
            $f=$dao->query($sql);
            foreach($f as $k=>$v){
                $da[$v['id']]=$v['name'];
            }
            $sql5="SELECT u.`name` FROM mks_examination AS e,mks_grade AS g,mks_user AS u WHERE e.`examinationid`=".$examinationid." AND e.`gradeid`=g.`gradeid` AND g.`userId`=u.`id` and e.scId=".$scId;
            $f5=$dao->query($sql5);
            foreach($f1 as $k=>$v){
                $sql2="SELECT score1,score2,score3,score4,score5,score6,name1,name2,name3,name4,name5,name6 FROM `mks_examination_score` AS s WHERE s.branchid=".$v['branchid']." and s.scId=".$scId." AND s.examinationid=".$examinationid." AND s.ensubjectid='总分'";//查询分数线
                $f2=$dao->query($sql2)['0'];

                for($i=1;$i<=6;$i++){
                    $name='name'.$i;
                    $score='score'.$i;
                    if($f2[$score]){
                        $arr['lineName']=$f2[$name];
                        $arr['lineIndex']=$score;
                        $arr3['lineIndex']=$score;
                        $arr3['score']=$f2[$score];
                        $arr1[]=$arr;
                        $arr2[]=$arr3;
                    }
                }
                $data['lineList']=$arr1;
                $arr1=array();
                $str='';
                foreach($arr2 as $a=>$b){
                    if($arr2[$a-1]['score']){
                        $str.="SUM(CASE WHEN (`results`< ".$arr2[$a-1]['score']." AND `results`>=".$b['score'].") THEN 1 ELSE 0 END ) as ".$b['lineIndex'].",";
                    }else{
                        $str.="SUM(CASE WHEN (`results`>=".$b['score'].") THEN 1 ELSE 0 END ) as ".$b['lineIndex'].",";
                    }
                }
                $arr2=array();
                $str=rtrim($str,',');
                $sql4="SELECT `branchid` as branch,`className`,COUNT(`userid`) AS `join`,".$str.",teacher FROM (SELECT SUM(r.results) AS `results`,r.userid,r.`branchid`,u.`className`,u.class,c.userid AS teacher FROM `mks_examination_results` AS r,mks_user AS u,mks_class as c WHERE u.`class`=c.`classid` and r.`examinationid`=".$examinationid." and r.scId=".$scId." AND r.`branchid`=".$v['branchid']." AND r.`userid`=u.`id` GROUP BY r.userid) AS h GROUP BY class";
                $f4=$dao->query($sql4);
                $join=0;
                $aa=array();
                foreach($f4 as $a=>$b) {
                    $data1[$a]['branch']=$v['branch'];
                    $data1[$a]['className']=$b['className'];
                    $data1[$a]['join']=$b['join'];
                    $join+=$b['join'];
                    foreach($b as $c=>$d){
                        if(substr($c,0,5)=='score'){
                            if($aa[$c]){
                                $aa[$c]+=$b[$c];
                            }else{
                                $aa[$c]=$b[$c];
                            }
                            $data1[$a][$c]=$b[$c];
                            $data1[$a][$c."proportion"]=($f4[$a][$c]/$f4[$a]['join'])*100;
                        }
                    }
                    $data1[$a]['teacher']=$da[$b['teacher']];
                    $data['data'][]=$data1[$a];
                }
                $data2['branch']=$v['branch'];
                $data2['className']='全年级';
                $data2['join']=$join;
                foreach($aa as $a=>$b){
                    $data2[$a]=$b;
                    $data2[$a."proportion"]=$b/$join*100;
                }
                $data2['teacher']=$f5['0']['name'];
                $data['data'][]=$data2;
            }
            return $data;
        }else{
            $arrrr=false;
            return $arrrr;
        }
    }
    private function getPersonal($examinationid,$userid,$branchid,$classid){
        $scId=2;
        $dao=M();
        $sql1="SELECT t.`subjectid`,t.`subjectname` FROM mks_examination_subject AS s,mks_subject AS t WHERE s.`subject`=t.`subjectid` AND s.`examinationid`=".$examinationid." and s.scId=".$scId." and s.branchid=".$branchid." order by t.subjectid desc";//考试科目
        $f1=$dao->query($sql1);
        $sql2="SELECT userid,subjectid,results FROM `mks_examination_results` WHERE examinationid=".$examinationid." AND branchid=".$branchid." ORDER BY subjectid desc,results desc";//考试成绩用于排年级名次及成绩返回
        $f2=$dao->query($sql2);
        $sql4="SELECT userid,SUM(results) AS `sum` FROM `mks_examination_results` WHERE examinationid=".$examinationid." AND branchid=".$branchid." AND scId=".$scId." GROUP BY userid ORDER BY `sum` DESC";//用于排总成绩的年级名次及成绩
        $f4=$dao->query($sql4);
        $sql5="SELECT AVG(r.`results`) AS `avg`,r.`subjectid` FROM `mks_examination_results` AS r,mks_user AS u WHERE u.`class`=".$classid." AND u.id=r.`userid` AND r.`examinationid`=".$examinationid." AND r.`scId`=".$scId." GROUP BY r.`subjectid`";//班级平均成绩
        $f5=$dao->query($sql5);
        $sql6="SELECT SUM(r.results) AS `sum`,r.`userid` FROM `mks_examination_results` AS r,mks_user AS u WHERE r.`userid`=u.`id` AND r.scId=".$scId." AND r.`examinationid`=".$examinationid." AND u.`class`=".$classid." GROUP BY r.`userid` ORDER BY `sum` DESC";//用于排总成绩的班级名次
        $f6=$dao->query($sql6);
        $sql7="SELECT r.`userid`,r.`subjectid` FROM `mks_examination_results` AS r,mks_user AS u WHERE r.`userid`=u.`id` AND r.scId=".$scId." AND r.`examinationid`=".$examinationid." AND u.`class`=".$classid." ORDER BY r.`subjectid` DESC,r.`results` DESC";//用于排总成绩的班级名次
        $f7=$dao->query($sql7);
        foreach($f6 as $k=>$v){
            $arr6[$v['userid']]=$k+1;
        }
        foreach($f7 as $k=>$v){
            $arr7[$v['subjectid']][]=$v['userid'];
        }
        foreach($arr7 as $k=>$v){
            foreach($v as $a=>$b){
                $aa=$a+1;
                if($b==$userid){
                    $data7[$k]=$aa;
                }else{
                    continue;
                }
            }
        }
        foreach($f2 as $k=>$v){
            unset($v['userid']);
            unset($v['subjectid']);
            $arr3[$f2[$k]['userid']][$f2[$k]['subjectid']]=$v['results'];
        }
        foreach($f2 as $k=>$v){
            $data[$v['subjectid']][]=$v['userid'];
        }
        foreach($data as $k=>$v){
            foreach($v as $a=>$b){
                $aa=$a+1;
                if($b==$userid){
                    $data1[$k]=$aa;
                }else{
                    continue;
                }
            }
        }
        foreach($f4 as $k=>$v){
            $data4[$v['userid']]=$k+1;
            $data3[$v['userid']]=$v['sum'];
        }
        $total=0;
        foreach($f5 as $k=>$v){
            $arr5[$v['subjectid']]=$v['avg']+0;
            $total+=$v['avg'];
        }
        $array['subjectlist']=$f1;
        $array['classscore']=$arr3[$userid];
        $array['classscore']['total']=$data3[$userid];
        $array['gradeRanking']=$data1;
        $array['gradeRanking']['total']=$data4[$userid];
        $array['classRanking']=$data7;
        $array['classRanking']['total']=$arr6[$userid];
        $array['classavg']=$arr5;
        $array['classavg']['total']=$total;
        return $array;
    }
    public function achievementFind(){/**********成绩查询*****/
        $getSession = $this->get_session('loginCheck',false);
        if(I('get.type')=='findgrade'){/***********************年级列表****************/
            $this->findgrade();
        }elseif(I('get.type')=='findexam') {/*******************考试查询*****************/
            $gradeid=I('post.gradeid');
            $this->findexam($gradeid);
        }elseif(I('get.type')=='findclass') {/*******************科类班级查询*****************/
            $examinationid=I('post.examinationid');
            $this->findclass($examinationid);
        }elseif(I('get.type')=='subjectfind'){/****************考试科目查询****************/
            $examinationid=I('post.examinationid');
            $branchid=I('post.branchid');
            $arr=$this->findsubject($examinationid,$branchid);
            $this->ajaxReturn($arr);
        }elseif(I('get.type')=='acfind'){/****************成绩查询*****************/
            $examinationid=I('post.examinationid');
            $branchid=I('post.branchid');
            $classid=I('post.classid');
            $subjectid=I('post.subjectid');
            $arr=$this->acfind($examinationid,$branchid,$classid,$subjectid);
            $this->ajaxReturn($arr);
        }elseif(I('get.type')=='personalfind'){/************************学生个人成绩*****************/
            $examinationid=I('post.examinationid');
            $userid=I('post.userid');
            $branchid=I('post.branchid');
            $classid=I('post.classid');
            $array=$this->getPersonal($examinationid,$userid,$branchid,$classid);
            $this->ajaxReturn($array);
        }elseif(I('get.type')=='comparison'){/****************成绩对比******************/
            $examinationid=json_decode($_POST['examinationid'],true);
            $userid=I('post.userid');
            $branchid=I('post.branchid');
            $classid=I('post.classid');
            foreach($examinationid as $k=>$v){
                $arr=$this->comparison($userid,$branchid,$classid,$v['examinationid']);
                $arr1[$v['examination']]['score']=$arr['classscore'];
                $arr1[$v['examination']]['gradeRanking']=$arr['gradeRanking']['total'];
                $arr1[$v['examination']]['classRanking']=$arr['classRanking']['total'];
                foreach($arr['subjectlist'] as $a=>$b){
                    $arr2[]=$b;
                }
            }
            $arr3=array();
            $i=0;
            foreach($arr2 as $k=>$v){
                if(!in_array($v, $arr3)) {
                    $arr3[$i]=$v;
                    $i++;
                }
            }
            $arrp['subjectlist']=$arr3;
            $arrp['data']=$arr1;
            $this->ajaxReturn($arrp);
        }elseif(I('get.type')=='scoreexport'){/****************成绩导出******************/
            $examinationid=I('get.examinationid');
            $branchid=I('get.branchid');
            $classid=I('get.classid');
            $subjectid=I('get.subjectid');
            $ranking=I('get.ranking');
            $arr=$this->acfind($examinationid,$branchid,$classid,$subjectid);
            $arr1=array('姓名','班级','座号');
            foreach($arr['subject'] as $k=>$v){
                $key=$k+3;
                $arr1[$key]=$v['subjectname'];
                $arr2[]=$v['subjectid'];
            }
            $sum=count($arr2);
            array_push($arr1,"总分","班名次","级名次");
            foreach($arr['student'] as $k=>$v){
                $arr3[]=$v['name'];
                $arr3[]=$v['className'];
                $arr3[]=$v['serialNumber'];
                if($ranking){
                    foreach($arr2 as $a=>$b){
                        $arr3[]=$v[$b]['results']."|".$v[$b]['ranking'];
                    }
                }else{
                    foreach($arr2 as $a=>$b){
                        $arr3[]=$v[$b]['results'];
                    }
                }
                $arr3[]=$v['totalScore'];
                $arr3[]=$v['classRanking'];
                $arr3[]=$v['gradeRanking'];
                $arr4[]=$arr3;
                $arr3=array();
            }
            $this->getExport($arr1,$arr4);
        }
    }
    public function statistics(){/***************成绩统计*****************/
        if(I('get.type')=='findgrade'){/***********************年级列表****************/
            $this->findgrade();
        }elseif(I('get.type')=='findexam') {/*******************考试查询*****************/
            $gradeid=I('post.gradeid');
            $this->findexam($gradeid);
        }elseif(I('get.type')=='findbranch') {/*******************科类查询*****************/
            $examinationid=I('post.examinationid');
            $this->findbranch($examinationid);
        }
        if(I('get.type')=='subject'){/*********************学科统计*******************/
            $examinationid=I('post.examinationid');
            $statistics=I('post.statistics');
            $arr=$this->getSubjectStatistics($examinationid,$statistics);
            $this->ajaxReturn($arr);
        }elseif(I('get.type')=='subjectexport'){/*********************学科统计导出*******************/
            $examinationid=I('get.examinationid');
            $statistics=I('get.statistics');
            $arr=$this->getSubjectStatistics($examinationid,$statistics);
            $header=array('科类','科目','班级','参考人数','均分','排名','最高分','最低分','优秀数','优秀率%','及格数','及格率%','低分数','低分率%','教师');
            $this->getExport($header,$arr);
        }
        if(I('get.type')=='ranking'){/**************************名次统计*******************/
            //$sql1="SELECT u.`className`,r.`userid`,SUM(r.`results`) AS sum1 FROM `mks_examination_results` AS r,mks_user AS u WHERE r.`examinationid`=192 AND r.`branchid`=2 AND r.`userid`=u.`id` GROUP BY r.`userid` ORDER BY sum1 DESC";
            $examinationid=I('post.examinationid');
            $branchid=I('post.branchid');
            $rank1=I('post.rank1');
            $rank2=I('post.rank2');
            $rank3=I('post.rank3');
            $rank4=I('post.rank4');
            $rank5=I('post.rank5');
            $rank6=I('post.rank6');
            $arr1=$this->getSum($branchid,$examinationid,$rank1,$rank2,$rank3,$rank4,$rank5,$rank6);
            foreach($arr1 as $k=>$v){
                $arr[]=$v;
            }
            $subject=$this->findsubject($examinationid,$branchid);
            foreach($subject as $k=>$v){
                $arr1=$this->getRankingSubject($v['subjectid'],$branchid,$examinationid,$rank1,$rank2,$rank3,$rank4,$rank5,$rank6);
                foreach($arr1 as $k=>$v){
                    $arr[]=$v;
                }
            }
            $this->ajaxReturn($arr);
        }elseif(I('get.type')=='rankingexport'){/**************************名次统计导出*******************/
            $examinationid=I('get.examinationid');
            $branchid=I('get.branchid');
            $rank1=I('get.rank1');
            $rank2=I('get.rank2');
            $rank3=I('get.rank3');
            $rank4=I('get.rank4');
            $rank5=I('get.rank5');
            $rank6=I('get.rank6');
            $arr1=$this->getSum($branchid,$examinationid,$rank1,$rank2,$rank3,$rank4,$rank5,$rank6);
            foreach($arr1 as $k=>$v){
                $arr[]=$v;
            }
            $subject=$this->findsubject($examinationid,$branchid);
            foreach($subject as $k=>$v){
                $arr1=$this->getRankingSubject($v['subjectid'],$branchid,$examinationid,$rank1,$rank2,$rank3,$rank4,$rank5,$rank6);
                foreach($arr1 as $k=>$v){
                    $arr[]=$v;
                }
            }
            $header=array('科目','班级','参考人数','平均名次','前'.$rank1.'名','前'.$rank2.'名','前'.$rank3.'名','前'.$rank4.'名','前'.$rank5.'名','前'.$rank6.'名','教师');
            $this->getExport($header,$arr);
        }
        if(I('get.type')=='subsection'){/*******************分段统计****************/
            $examinationid=I('post.examinationid');
            $section=json_decode($_POST['section'],true);
            $branchid=I('post.branchid');
            $data=$this->getSubsection($examinationid,$section,$branchid);
            $this->ajaxReturn($data);
        }elseif(I('get.type')=='subsectionexport'){/*******************分段统计导出****************/
            $examinationid=I('get.examinationid');
            $section=json_decode($_GET['section'],true);
            $branchid=I('get.branchid');
            $data=$this->getSubsection($examinationid,$section,$branchid);
            $header=array('班级','参考人数','平均分','名次','最高分','最低分',$section['0']['from']."-".$section['0']['to'],$section['1']['from']."-".$section['1']['to'],$section['2']['from']."-".$section['2']['to'],$section['3']['from']."-".$section['3']['to'],$section['4']['from']."-".$section['4']['to'],$section['5']['from']."-".$section['5']['to'],$section['6']['from']."-".$section['6']['to'],'班主任');
            $this->getExport($header,$data);
        }
        if(I('get.type')=='avg'){/********************均分总表********************/
            $examinationid=I('post.examinationid');
            $branchid=I('post.branchid');
            $arr=$this->getAvg($examinationid,$branchid);
            $this->ajaxReturn($arr);
        }elseif(I('get.type')=='avgexport'){/********************均分总表导出********************/
            $examinationid=I('get.examinationid');
            $branchid=I('get.branchid');
            $arr=$this->getAvg($examinationid,$branchid);
            if(I('get.ranking')){
                foreach($arr['data'] as $k=>$v){
                    unset($arr['data'][$k]['totalRanking']);
                    if($arr['data'][$k]['className']=='全年级'){
                        $arr['data'][$k]['totalResults']=$v['totalResults'];
                        foreach($v as $a=>$b){
                            if($a!='className'&&$a!='totalResults'&&$a!='totalRanking'&&$a!='teacher'){
                                $arr['data'][$k][$a]=$b['resutls'];
                            }
                        }
                    }else{
                        $arr['data'][$k]['totalResults']=$v['totalResults'].'|'.$v['totalRanking'];
                        foreach($v as $a=>$b){
                            if($a!='className'&&$a!='totalResults'&&$a!='totalRanking'&&$a!='teacher'){
                                $arr['data'][$k][$a]=$b['resutls']."|".$b['ranking'];
                            }
                        }
                    }
                }
            }else{
                foreach($arr['data'] as $k=>$v){
                    $arr['data'][$k]['totalResults']=$v['totalResults'];
                    unset($arr['data'][$k]['totalRanking']);
                    foreach($v as $a=>$b){
                        if($a!='className'&&$a!='totalResults'&&$a!='totalRanking'&&$a!='teacher'){
                            $arr['data'][$k][$a]=$b['resutls'];
                        }
                    }
                }
            }
            $header=array('班级','总分');
            foreach($arr['subjectlist'] as $k=>$v){
                $header[]=$v['subjectname'];
            }
            $header[]='班主任';
            $this->getExport($header,$arr['data']);
        }
    }
    public function contrast(){/***************两次对比***************/
        $getSession = $this->get_session('loginCheck',false);
        if(I('get.type')=='findgrade'){/***********************年级列表****************/
            $this->findgrade();
        }elseif(I('get.type')=='findexam') {/*******************考试查询*****************/
            $gradeid=I('post.gradeid');
            $this->findexam($gradeid);
        }elseif(I('get.type')=='findclass') {/*******************科类班级查询*****************/
            $gradeid = I('post.gradeid');
            $this->findClassAll($gradeid);
        }
        if(I('get.type')=='result') {/*******************成绩对比*******************/
            $examinationid1 = I('post.examinationid1');
            $examinationid2 = I('post.examinationid2');
            $class = $_POST['class'];
            $branchid = I('post.branchid');
            $arr=$this->getContrastResultAll($examinationid1,$examinationid2,$branchid,$class);
            $this->ajaxReturn($arr);
        }elseif(I('get.type')=='resultexport'){/*******************成绩对比导出*******************/
            $examinationid1 = I('post.examinationid1');
            $examinationid2 = I('post.examinationid2');
            $class = $_POST['class'];
            $branchid = I('post.branchid');
            $arr=$this->getContrastResultAll($examinationid1,$examinationid2,$branchid,$class);
            $header=array('');
        }
        if(I('get.type')=='rank'){/*******************名次对比*******************/
            $examinationid1=I('post.examinationid1');
            $examinationid2=I('post.examinationid2');
            $branchid=I('post.branchid');
            $rank1=I('post.rank1');
            $rank2=I('post.rank2');
            $rank3=I('post.rank3');
            $rank4=I('post.rank4');
            $rank5=I('post.rank5');
            $rank6=I('post.rank6');
            $arr=$this->getContrastRank($branchid,$examinationid1,$examinationid2,$rank1,$rank2,$rank3,$rank4,$rank5,$rank6);
            $this->ajaxReturn($arr);
        }elseif(I('get.type')=='rankexport'){/*******************名次对比导出*******************/
            $examinationid1=I('get.examinationid1');
            $examinationid2=I('get.examinationid2');
            $branchid=I('get.branchid');
            $rank1=I('get.rank1');
            $rank2=I('get.rank2');
            $rank3=I('get.rank3');
            $rank4=I('get.rank4');
            $rank5=I('get.rank5');
            $rank6=I('get.rank6');
            $arr=$this->getContrastRank($branchid,$examinationid1,$examinationid2,$rank1,$rank2,$rank3,$rank4,$rank5,$rank6);
            $header=array('科目','班级','对比人数','本次平均名次','对比平均名次','差值','本次前'.$rank1.'名','对比前'.$rank1.'名','差值','本次前'.$rank2.'名','对比前'.$rank2.'名','差值','本次前'.$rank3.'名','对比前'.$rank3.'名','差值','本次前'.$rank4.'名','对比前'.$rank4.'名','差值','本次前'.$rank5.'名','对比前'.$rank5.'名','差值','本次前'.$rank6.'名','对比前'.$rank6.'名','差值');
            foreach($arr as $k=>$v){
                $arr1[$k]['subjectname']=$v['subjectname'];
                $arr1[$k]['className']=$v['className'];
                $arr1[$k]['join']=$v['join'];
                $arr1[$k]['avg']=$v['avg'];
                $arr1[$k]['avga']=$v['avga'];
                $arr1[$k]['shortavg']=$v['shortavg'];
                $arr1[$k]['rank1']=$v['rank1'];
                $arr1[$k]['ranka']=$v['ranka'];
                $arr1[$k]['shortrank1']=$v['shortrank1'];
                $arr1[$k]['rank2']=$v['rank2'];
                $arr1[$k]['rankb']=$v['rankb'];
                $arr1[$k]['shortrank2']=$v['shortrank2'];
                $arr1[$k]['rank3']=$v['rank3'];
                $arr1[$k]['rankc']=$v['rankc'];
                $arr1[$k]['shortrank3']=$v['shortrank3'];
                $arr1[$k]['rank4']=$v['rank4'];
                $arr1[$k]['rankd']=$v['rankd'];
                $arr1[$k]['shortrank4']=$v['shortrank4'];
                $arr1[$k]['rank5']=$v['rank5'];
                $arr1[$k]['ranke']=$v['ranke'];
                $arr1[$k]['shortrank5']=$v['shortrank5'];
                $arr1[$k]['rank6']=$v['rank6'];
                $arr1[$k]['rankf']=$v['rankf'];
                $arr1[$k]['shortrank6']=$v['shortrank6'];
            }
            $this->getExport($header,$arr1);
        }
        if(I('get.type')=='avg'){
            $examinationid1=I('post.examinationid1');
            $examinationid2=I('post.examinationid2');
            $branchid=I('post.branchid');
            $arr=$this->getContrastAvg($examinationid1,$examinationid2,$branchid);
            print_r($arr);
        }elseif(I('get.type')=='avgexport'){
            $examinationid1=I('get.examinationid1');
            $examinationid2=I('get.examinationid2');
            $branchid=I('get.branchid');
            $arr=$this->getContrastAvg($examinationid1,$examinationid2,$branchid);
            $header=array('科目','班级','参考人数','本次平均分','本次名次','对比平均分','目标系数','目标均分','均分进退','对比名次','名次进退');
            $this->getExport($header,$arr);
        }
    }
    public function score(){/*******************模拟上线*******************/
        if(I('get.type')=='findgrade'){/***********************年级列表****************/
            $this->findgrade();
        }elseif(I('get.type')=='findexam') {/*******************考试查询*****************/
            $gradeid=I('post.gradeid');
            $this->findexam($gradeid);
        }
        if(I('get.type')=='totalscore'){/********************总分上线**************************/
            $examinationid=I('post.examinationid');
            $arr=$this->getTotalOnline($examinationid);
            $this->ajaxReturn($arr);
        }elseif(I('get.type')=='totalscoreexport'){/********************总分上线导出*******************/
            $examinationid=I('get.examinationid');
            $arr=$this->getTotalOnline($examinationid);
            $header=array('科类','班级','考生数');
            foreach($arr['lineList'] as $k=>$v){
                $header[]=$v['lineName'];
                $header[]=$v['lineName'].'率';
            }
            $header[]='班主任/年级主任';
            $this->getExport($header,$arr['data']);
        }
        if(I('get.type')=='singlescore'){

        }
    }
    public function personal(){/**********************学生个人成绩*************************/
        if(I('get.type')=='user'){/***********************学生信息*********************/
            $getSession = $this->get_session('loginCheck',false);
            $id=$getSession['id'];
            $id=70;
            $scId=2;
            $dao=M();
            $sql1="select u.`grade`,u.`className`,u.`name`,e.`examination`,e.`examinationid`,u.class as classid,c.branch as branchid from mks_user as u,mks_examination as e,`mks_examination_results` as r,mks_class as c where u.id=".$id." and u.class=c.classid and e.release=1 and r.`userid`=u.`id` and r.`examinationid`=e.`examinationid` and u.scId=".$scId." group by r.`examinationid`";
            $f1=$dao->query($sql1);
            foreach($f1 as $k=>$v){
                $arr['grade']=$v['grade'];
                $arr['className']=$v['className'];
                $arr['name']=$v['name'];
                $arr1['examination']=$v['examination'];
                $arr1['examinationid']=$v['examinationid'];
                $arr['examinationlist'][]=$arr1;
                $arr['branchid']=$v['branchid'];
                $arr['classid']=$v['classid'];
            }
            print_r($arr);
        }elseif(I('get.type')=='scorequery'){/******************成绩查询*********************/
            $getSession = $this->get_session('loginCheck',false);
            $userid=$getSession['id'];
            $userid=70;
            $examinationid=I('post.examinationid');
            $branchid=I('post.branchid');
            $classid=I('post.classid');
            $array=$this->getPersonal($examinationid,$userid,$branchid,$classid);
            $this->ajaxReturn($array);
        }elseif(I('get.type')=='contrast'){/***********************成绩对比************************/
            $getSession = $this->get_session('loginCheck',false);
            $examinationid=json_decode($_POST['examinationid'],true);
            $userid=$getSession['id'];
            $userid=70;
            $branchid=I('post.branchid');
            $classid=I('post.classid');
            foreach($examinationid as $k=>$v){
                $arr=$this->comparison($userid,$branchid,$classid,$v['examinationid']);
                $arr1[$v['examination']]['score']=$arr['classscore'];
                $arr1[$v['examination']]['gradeRanking']=$arr['gradeRanking']['total'];
                $arr1[$v['examination']]['classRanking']=$arr['classRanking']['total'];
                foreach($arr['subjectlist'] as $a=>$b){
                    $arr2[]=$b;
                }
            }
            $arr3=array();
            $i=0;
            foreach($arr2 as $k=>$v){
                if(!in_array($v, $arr3)) {
                    $arr3[$i]=$v;
                    $i++;
                }
            }
            $arrp['subjectlist']=$arr3;
            $arrp['data']=$arr1;
            $this->ajaxReturn($arrp);
        }
    }
}