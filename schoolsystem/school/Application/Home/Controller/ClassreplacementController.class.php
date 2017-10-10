<?php
/**
 * Created by PhpStorm.
 * User: xiaolong
 * Date: 2017/6/22
 * Time: 14:15
 * 排课管理
 */
namespace Home\Controller;
//use Think\Controller;
//use Vendor\PHPExcel\PHPExcel;
class ClassreplacementController extends Base {
    private $classTable = array();
    private $teacherTable = array();
    private $jxPlanTable = array();
    private $subjectLimit = array(); //科目排课限制
    private $teacherLimitData = array(); //教师限制
    private $hbClass = array(); //合班
    public function pkList(){

    }
}