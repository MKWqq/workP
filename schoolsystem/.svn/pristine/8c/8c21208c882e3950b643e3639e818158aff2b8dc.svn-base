<?php
/**
 * Created by PhpStorm.
 * User: xiaolong
 * Date: 2017/6/22
 * Time: 14:15
 * 用户管理
 */
namespace Home\Controller;
//use Think\Controller;
//use Vendor\PHPExcel\PHPExcel;
class UserController extends Base {
    public function login(){
        //vendor('PHPExcel','');
    }
    public function test(){
       echo  $this->InitialPassword();
    }
    public function uploadUserLogo() //上次图片logo
    {
        $type = $_GET['type'];
        if ($type = 'uploadLogo'){
            $userId = $_POST['userId'];
            $url = $this::upload('userLogo', $fileTypes = array('png', 'jpg', 'jpeg'));
            if($url){
                M('student_info')->where(array('userId' => $userId))->setField(array('logo' => $url));
                M('user')->where(array('userId' => $userId))->setField(array('logo' => $url));
                $this->returnJson(array('statu' => 1, 'message' => 'success', 'url' => urlencode($url)), true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail','url' => ''),true);
        }
    }
    public function exportStudent(){

    }
    public function exportExcel(){
        $type = $_GET['type'];
        $return = $this->get_session('loginCheck',false);
        if($type == 'jbXi'){
            $data = $this::exportExcelData('mks_student_info',$return['scId']);
            $tr = $this::getTr('mks_student_info');
            $this->export($data,$tr);
        }
        if($type == 'xjXi'){//学籍信息
            $data =$this::exportExcelData('mks_school_rollinfo',$return['scId']);
            $tr = $this::getTr('mks_school_rollinfo');
            $this->export($data,$tr);
        }
        if($type == 'hjXi'){//户籍
            $data =$this::exportExcelData('mks_cen_reg_info',$return['scId']);
            $tr = $this::getTr('mks_cen_reg_info');
            $this->export($data,$tr);
        }
        if($type == 'jzXi'){//家长
            $data = $this::exportExcelData('mks_parents_info',$return['scId']);
            $tr = $this::getTr('mks_parents_info');
            $this->export($data,$tr);
        }
        if($type == 'xfXi'){//学费信息
            $data = $this::exportExcelData('mks_tuition_info',$return['scId']);
            $tr = $this::getTr('mks_tuition_info');
            $this->export($data,$tr);
        }
        if($type == 'qtXi'){//其他信息
            $data = $this::exportExcelData('mks_other_info',$return['scId']);
            $tr = $this::getTr('mks_other_info');
            $this->export($data,$tr);
        }
    }
    public function exportTeacherOrZg(){
        $type = $_GET['type'];
        $return = $this->get_session('loginCheck',false);
        if($type == 'teacher'){
            $data = M('user')->where(array('scId' => $return['scId'],'roleId' => $this::$teacherRoleId))->select();
            $this::export($data, $this::getTr('js'));
        }
        if($type == 'worker'){
            $scId = $return['scId'];
            $teacherRoleId = $this::$teacherRoleId;
            $data = M('')->query("SELECT * FROM mks_user WHERE post!='' AND roleId!= $teacherRoleId AND scId=$scId");
            $this::export($data,$this::getTr('zg'));
        }
    }
    private function exportExcelData($table,$scId){
        $grade = $_GET['grade'];
        $class = $_GET['class'];
        $class = explode(',',$class);
        $str = '';
        $len = count($class);
        $i = 1;
        foreach($class as $key => $value){
            $i++;
            if($i<=$len){
                $str = 'className='.$value.' or '.$str;
            }else{
                $str = $str.'className='.$value;
            }
        }
        $sql = "SELECT * FROM $table WHERE scId=$scId and grade=$grade and  ($str)";
        $data = M()->query($sql);
        return $data;
    }
    /*用户登录*/
    public function doLogin(){
        $account = addslashes($_POST['account']);
        $password = addslashes($_POST['password']);
        $return = $this->checkLogin($account,$password);
        if($return['statu']){
            $modelName = $return['scId'].'school'.$return['roleId'];
            $model = json_decode($this->redis_operation($modelName,0,0,3),true);
            //echo $this->redis_operation($modelName,0,0,3);
            //print_r(json_decode($this->redis_operation($modelName,0,0,3),true));
            $allModel = M('model')->select();
            $allTe = array();
            foreach($allModel as $key => $value){
                $allTe[$value['modelId']] = $value['url'];
            }
            $modelRe = array();
            foreach($model as $key => $value){
                if(!$value['hidden']){
                    $value['url'] = $allTe[$value['modelId']];
                    $modelRe[] = $value;
                }
            }
            $return['model'] = $modelRe;
            $this->returnJson($return,true);
        }
    }
    private function dg($model){//递归
        while(isset($model[0])){
            foreach($model as $key => $vlaue){

            }
        }
    }
    public function loginOut(){
        $this->clear_session('loginCheck');
        $this->returnJson(array('statu' => 1 ,'success' => 'login out success'),true);
    }
    public function doRegister(){

    }
    //角色开始
    public function role(){
        $this->assign('model',$this->getModelListshow(0,0));
        //print_r($this->getModelListshow(0,0));
        $this->display();
    }
    //返回一级导航
    public function getOneNav(){
        $this->returnJson(M('model')->where(array('level' => 1))->select(),true);
    }
    //
    public function getModelListGo(){
        $return = $this->get_session('loginCheck',false);
        $roleId = $_GET['roleId'];
        $modelName = $return['scId'].'school'.$roleId;
        $modelId = $_GET['modelId'];
        $allModel = M('model')->select();
        $model = json_decode($this->redis_operation($modelName,0,0,3),true);
        //$return['allModel'] = $allModel;
        $return['userModel'] = $model;
        $return['oneModel'] = $this->getModelListPaiXu($modelId,$allModel);
        $count = count($return['oneModel']);
        foreach($allModel as $key => $value){
            if($value['modelId'] == $modelId){
                $return['oneModel'][$count] = $value;
                break;
            }
        }
        foreach($return['oneModel'] as $key => $value){
            $true =0;
            foreach($return['userModel'] as $key1 => $value1){
                if($value['modelId'] == $value1['modelId']){
                    $return['oneModel'][$key]['statu'] = 1;
                    $true = 1;
                    break;
                }
            }
            if(!$true){
                $return['oneModel'][$key]['statu'] = 0;
            }
            $return['oneModel'][$key]['ifHave'] = false;
        }
        //print_r($return['oneModel']);
        $returngo = $this::getModelListReturn(-1,$return['oneModel']);
        //print_r($returngo);
        $this->returnJson($returngo,true);
    }
    //递归得到当前modelId下面的所有数组
    private function getModelListPaiXu($modelId,$allModel){
        global  $dataReturn;
        foreach($allModel as $key => $value){
            if($value['parentId'] == $modelId){
                $dataReturn[] = $value;
                $this::getModelListPaiXu($value['modelId'],$allModel);
            }
        }
        return $dataReturn;
    }
    //创建角色接口
    public function createRole(){
        $scId = $this->get_session('loginCheck',false);
        $scId = $scId['scId'];
        if(isset($_POST['roleName'])){
            $reg = M('role')->add(array('roleName' => addslashes($_POST['roleName']),'scId' => $scId,'createTime' => date('Y-m-d H:i:s')));
            if($reg){
                $this->returnJson(array('statu' => 1, 'message' => 'add success'),true);
            }
            else{
                $this->returnJson(array('statu' => 0, 'message' => 'add fail'),true);
            }
        }
    }
    //得到角色表
    public function getRoleList(){
        $scId = $this->get_session('loginCheck',false);
        $scId = $scId['scId'];
        $this->returnJson(M('role')->where(array('scId' => array(array('eq',0),array('eq',$scId),'or')))->select(),1);
    }
    public function model(){
        $this->display();
    }
    //角色结束
    //model开始
    //创建权限
    public function getRoleListUser(){
        $type = $_GET['type'];
        if($type = 'list'){
            $scId = $this->get_session('loginCheck',false);
            $scId = $scId['scId'];
            $data = M('role')->where(array('scId' => array(array('eq',0),array('eq',$scId),'or')))->select();
            foreach($data as $key => $value){
                if($value['roleId'] == $this::$teacherRoleId || $value['roleId'] == $this::$studentRoleId  || $value['roleId'] == $this::$jzRoleId){
                    unset($data[$key]);
                }
            }
            $array = array();
            foreach($data as $key => $value){
                $array[] = $value;
            }

            $this->returnJson(array('data' =>$array,'statu' =>1,'message' => 1),1);
        }
    }
    public function  createModel(){
        if($modelName = $_POST['oneNav']){
            M('model')->add(array('modelName' => addslashes($modelName),'createTime' => date('Y-m-d H:i:s'),'parentId' => 0 ,'level' => 1));
        }
        if(isset($_POST['towNav']) &&isset($_POST['towNavTo']) ){
            $modelName = $_POST['towNav'];
            $bt = $_POST['towNavTo'];
            M('model')->add(array('modelName' => addslashes($modelName),'createTime' => date('Y-m-d H:i:s'),'parentId' => addslashes($bt),'level' => 2,'userId' => session('userId')));
        }
        if(isset($_POST['threeNav'])&& isset($_POST['threeNavTo'])&& isset($_POST['threecontroller']) && isset($_POST['threefunction'])){
            $function = $_POST['threefunction'];
            $modelName = $_POST['threeNav'];
            $bt = $_POST['threeNavTo'];
            $controller = $_POST['threecontroller'];
            M('model')->add(array('modelName' => addslashes($modelName),'level' => 3,'createTime' => date('Y-m-d H:i:s'),'controller' => $controller,'function' => $function,'userId' => session('userId'),'parentId' => addslashes($bt)));
        }
        if(isset($_POST['fourNav'])&& isset($_POST['fourNavTo'])&&isset($_POST['fourcontroller']) && isset($_POST['fourfunction'])){
            $modelName = addslashes($_POST['fourNav']);
            $bt = addslashes($_POST['fourNavTo']);
            $controller = addslashes($_POST['fourcontroller']);
            $function = addslashes($_POST['fourfunction']);
            M('model')->add(array('modelName' => addslashes($modelName),'level' => 4,'createTime' => date('Y-m-d H:i:s'),'controller' => $controller,'userId' => session('userId'),'function' => $function,'parentId' => addslashes($bt)));
        }
        if(isset($_POST['fiveNav']) && isset($_POST['fiveNavTo']) && isset($_POST['fivetype'])){
            $modelName = $_POST['fiveNav'];
            $bt = $_POST['fiveNavTo'];
            $type = $_POST['fivetype'];
            $parent = M('model')->field('controller,function')->where(array('modelId' => $bt))->find();
            M('model')->add(array('controller' => $parent['controller'],'level' => 5,'function' => $parent['function'],'userId' => session('userId'),'modelName' => addslashes($modelName),'type' => $type,'createTime' => date('Y-m-d H:i:s'),'parentId' => addslashes($bt) ));
        }
        $data = M('model')->select();
        $dataRetrun = array();
        foreach($data as $key => $value){
            $dataRetrun[] = array(
                'modelId' => $value['modelId'],
                'modelName' => $value['modelName'],
                'controller' => $value['controller'],
                'function' => $value['function'],
                'createTime' => $value['createTime'],
                'userId' => $value['userId'],
                'parentId' => $value['parentId'],
                'type' => $value['type'],
                'level' => $value['level'],
                'scId' => $value['scId'],
                'hidden' => $value['hidden']
            );
        }
        $scId = $this->get_session('loginCheck',false);
        $qxModelName = $scId['scId'].'school'.$this::$adminRoleId;
        $modelRetrun = $scId['scId'].'school'.$this::$adminRoleId.'returndata';
        $modelTetrunData = $this->getModelListReturn(-1,$dataRetrun);
        $this->redis_operation($qxModelName,json_encode($dataRetrun),0,2);
        $this->redis_operation($modelRetrun,json_encode($modelTetrunData),0,2);
    }
    //得到所有权限组
    public function getModelList(){
        $this->returnJson($this->getModelListReturn(0,0),true);
    }
    //得到子model
    public function getChildModel(){
        $modelId = $_POST['modelId'];
        $data = M('model')->where(array('parentId' => $modelId))->select();
        $this->returnJson($data,true);
    }
    private function getModelListshow($roleId,$data){
        $scId = $this->get_session('loginCheck',false);
        $scId = $scId['scId'];
        $oneNav = array();
        if($roleId == 0 || $roleId == $this::$adminRoleId){
            $oneNav = M('model')->select();
        }
        if($roleId>=1 && $roleId!=$this::$adminRoleId){
            $oneNav = M()->query("SELECT mks_model.controller as controller,mks_model.modelName as modelName, mks_model.`function` as function,mks_model.modelId as modelId,mks_model.type as type,mks_model.parentId as parentId,mks_model.`level` as level FROM mks_role_model JOIN mks_model ON mks_role_model.modelId = mks_model.modelId where roleId = $roleId");
            $modelName = 'school'.$roleId;
        }
        if($roleId == -1){
            $oneNav = $data;
        }
        $data = array();
        foreach($oneNav as $key => $value){
            if($value['level'] == 1){
                $data[] = $value;
                unset($oneNav[$key]);
            }
        }
        foreach($oneNav as $key => $value){
            if($value['level'] == 2){
                foreach($data as $key1 => $value1){
                    if($value1['modelId'] == $value['parentId']){
                        $data[$key1][] = $value;
                        unset($oneNav[$key]);
                    }
                }
            }
        }
        foreach($oneNav as $key => $value){
            if($value['level'] == 3){
                foreach($data as $key1 => $value1){
                    foreach($value1 as $key2 => $value2){
                        if($value2['modelId'] == $value['parentId']){
                            $data[$key1][$key2][] = $value;
                            unset($oneNav[$key]);
                        }
                    }
                }
            }
        }
        foreach($oneNav as $key => $value){
            if($value['level'] == 4){
                foreach($data as $key1 => $value1){
                    foreach($value1 as $key2 => $value2){
                        foreach($value2 as $key3 => $value3) {
                            if ($value3['modelId'] == $value['parentId']) {
                                $data[$key1][$key2][$key3][] = $value;
                                unset($oneNav[$key]);
                            }
                        }
                    }
                }
            }
        }
        foreach($oneNav as $key => $value){
            if($value['level'] == 5){
                foreach($data as $key1 => $value1){
                    foreach($value1 as $key2 => $value2){
                        foreach($value2 as $key3 => $value3) {
                            foreach($value3 as $key4 => $value4) {
                                if ($value4['modelId'] == $value['parentId']) {
                                    $data[$key1][$key2][$key3][$key4][] = $value;
                                    unset($oneNav[$key]);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $data;
        //print_r($data);
        //$this->returnJson($data,1);
    }
    //分离出不同角色的规范权限组
    private function getModelListReturn($roleId,$data){
        $scId = $this->get_session('loginCheck',false);
        $scId = $scId['scId'];
        $oneNav = array();
        if($roleId == 0 || $roleId == $this::$adminRoleId){
            $oneNav = M('model')->select();
        }
        if($roleId>=1 && $roleId!=$this::$adminRoleId){
            $oneNav = M()->query("SELECT mks_model.controller as controller,mks_model.modelName as modelName, mks_model.`function` as function,mks_model.modelId as modelId,mks_model.type as type,mks_model.parentId as parentId,mks_model.`level` as level FROM mks_role_model JOIN mks_model ON mks_role_model.modelId = mks_model.modelId where roleId = $roleId and scId=$scId");
            $modelName = 'school'.$roleId;
        }
        if($roleId == -1){
            $oneNav = $data;
        }
        $data = array();
        foreach($oneNav as $key => $value){
            if($value['level'] == 1){
                $data[] = $value;
            }
        }
        foreach($oneNav as $key => $value){
            if($value['level'] == 2){
                foreach($data as $key1 => $value1){
                    if($value1['modelId'] == $value['parentId']){
                        $data[$key1]['child'][] = $value;
                    }
                }
            }
        }
        foreach($oneNav as $key => $value){
            if($value['level'] == 3){
                foreach($data as $key1 => $value1){
                    foreach($value1['child'] as $key2 => $value2){
                        if($value2['modelId'] == $value['parentId']){
                            $data[$key1]['child'][$key2]['child'][] = $value;
                        }
                    }
                }
            }
        }
        foreach($oneNav as $key => $value){
            if($value['level'] == 4){
                foreach($data as $key1 => $value1){
                    foreach($value1['child'] as $key2 => $value2){
                        foreach($value2['child'] as $key3 => $value3) {
                            if ($value3['modelId'] == $value['parentId']) {
                                $data[$key1]['child'][$key2]['child'][$key3]['child'][] = $value;
                            }
                        }
                    }
                }
            }
        }
        foreach($oneNav as $key => $value){
            if($value['level'] == 5){
                foreach($data as $key1 => $value1){
                    foreach($value1['child'] as $key2 => $value2){
                        foreach($value2['child'] as $key3 => $value3) {
                            foreach($value3['child'] as $key4 => $value4) {
                                if ($value4['modelId'] == $value['parentId']) {
                                    $data[$key1]['child'][$key2]['child'][$key3]['child'][$key4]['child'][] = $value;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $data;
        //print_r($data);
        //$this->returnJson($data,1);
    }
    //找到分级的nav
    public function searchNav(){
        $this->returnJson(M('model')->where(array('level' => $_POST['level']))->select(),1);
    }
    //model结束


    //跟新角色权限
    private function updateRoleModel($roleId){
        $modelName = 'school'.$roleId;
        $data = $this->getModelListReturn($roleId,0);
        if($this->redis_operation($modelName,json_encode($data),0,2)){
            return true;
        }
    }
    //得到叫色权限Id
    public function  getRoleModelList(){
        $roleId = addslashes($_POST['roleId']);
        $scId = $this->get_session('loginCheck',false);
        $data = M('role_model')->field('modelId')->where(array('roleId' => $roleId,'scId' => $scId['scId']))->select();
        $this->returnJson($data,1);
    }
    public function createRoleModelGo(){
        $scId = $this->get_session('loginCheck',false);
        $modelId = $_POST['modelId'];
        $roleId = $_POST['roleId'];
        if(M('role_model')->where(array('roleId' => $roleId,'scId' => $scId['scId'],'modelId' =>$modelId))->find()){
            M('role_model')->where(array('roleId' => $roleId,'scId' => $scId['scId'],'modelId' =>$modelId))->delete();
            $qxModelName = $scId['scId'].'school'.$roleId;
            $newModel = M('role_model')->where(array('roleId' => $roleId,'scId' => $scId['scId']))->select();
            $this->redis_operation($qxModelName,json_encode($newModel),0,2);
            $this->returnJson(array('statu' => 1, 'message' => 'delete success'),true);
        }else{
            if(M('role_model')->add(array('roleId' => $roleId,'scId'=> $scId['scId'],'modelId' => $modelId,'createTime' => date('Y-m-d H:i:s')))){
                $qxModelName = $scId['scId'].'school'.$roleId;
                $newModel = M('role_model')->where(array('roleId' => $roleId,'scId' => $scId['scId']))->select();
                $this->redis_operation($qxModelName,json_encode($newModel),0,2);
                $this->returnJson(array('statu' =>1,'message' => 'add success'),true);
            }else{
                $this->returnJson(array('statu' =>0,'message' => 'add fail'),true);
            }
        }
    }
    private function getClass($scId){
        $class = M('class')->where(array('scId' => $scId))->select();
        $grade= M('grade')->where(array('scId' => $scId))->select();
        $classre = array();
        $gradeRe = array();
        foreach($grade as $key => $value){
            $gradeRe[$value['gradeid']] = $value['name'];
        }
        foreach($class as $key => $value){
            $gradeName = $gradeRe[$value['grade']];
            $classre[$gradeName][$value['classname']] = array(
                'classId' => $value['classid'],
                'gradeId' => $value['grade']
            );
        }
        return $classre;
    }
    //创建用户权限
    public function createRoleModel(){
        if(isset($_POST['roleId'])&& isset($_POST['list'])){
            $list = $_POST['list'];
            $roleId = addslashes($_POST['roleId']);
            $scId = $this->get_session('loginCheck',false);
            $model = M('role_model');
            $model->startTrans();
            $re1 = $model->where(array('roleId' => $roleId,'scId' => $scId['scId']))->delete();
            foreach($list as $key => $value){
                $re2 = $model->add(array('roleId' => (int)$roleId,'scId' => $scId['scId'],'modelId' => (int)$value,'createTime' => date('Y-m-d H:i:s')));
            }
            $modelAll = M('model')->select();
            $qxModel = array();
            foreach($list as $key1 => $value1){
                foreach($modelAll as $key => $value){
                    if($value1 == $value['modelId']){
                        $qxModel[] = array(
                            'modelId' => $value['modelId'],
                            'modelName' => $value['modelName'],
                            'controller' => $value['controller'],
                            'function' => $value['function'],
                            'createTime' => $value['createTime'],
                            'userId' => $value['userId'],
                            'parentId' => $value['parentId'],
                            'type' => $value['type'],
                            'level' => $value['level'],
                            'scId' => $value['scId'],
                            'hidden' => $value['hidden']
                        );
                        break;
                    }
                }
            }
            $modelNameRetrun = $scId['scId'].'school'.$roleId.'returndata';
            $qxModelName = $scId['scId'].'school'.$roleId;
            $model_return = $this->getModelListReturn(-1,$qxModel);
            $this->redis_operation($modelNameRetrun,json_encode($model_return),0,2);
            $this->redis_operation($qxModelName,json_encode($qxModel),0,2);
            if($re2){
                $model->commit();
                if($this->updateRoleModel($roleId)){
                    $this->returnJson(array('statu' => 1,'message' => 'success'),true);
                }else{
                    $this->returnJson(array('statu' => 0,'message' => 'fail'),true);
                }
            }else{
                $model->rollback();
                $this->returnJson(array('statu' => 0,'message' => 'fail'),true);
            }
        }
    }
    //modelrole结束
    //是否操作成功判断
    private function successOrtrue($reg,$success,$fail){
        if($reg){
            return $success;
        }
        return $fail;
    }
    //递归求导航
    private function diGui($modelId,$parentId){

    }
    private function studentXi($scId,$model){
        if(isset($_GET['sort']) &&isset($_GET['value']) ){
            $value = $_GET['value'];
            $sort = $_GET['sort'];
            if($sort=='ascending'){
                $sort = 'asc';
            }
            if($sort == 'descending'){
                $sort = 'desc';
            }
            $sortType = $_GET['sortType'];
            $return = $this->pageListSql($scId,$model,1," and (name like '%$value%' OR className like '%$value%')",1," order by $sortType $sort");
            $dataReturn = $this->returnJson($return,true);
        }
        if(!isset($_GET['sort']) &&isset($_GET['value']) ){
            $value = $_GET['value'];
            $return = $this->pageListSql($scId,$model,1," and (name like '%$value%' OR className like '%$value%')");
            $dataReturn = $this->returnJson($return,true);
        }
        if(isset($_GET['sort']) && !isset($_GET['value']) ){
            $sort = $_GET['sort'];
            if($sort=='ascending'){
                $sort = 'asc';
            }
            if($sort == 'descending'){
                $sort = 'desc';
            }
            $sortType = $_GET['sortType'];
            $return = $this->pageListSql($scId,$model,0,'',1," order by $sortType $sort");
            $dataReturn = $this->returnJson($return,true);
        }
        $dataReturn = $this->pageListSql($scId,$model);
        return $dataReturn;
    }
    private function getWorkPage($scId,$table,$valueData = 0,$strLike ='',$sort = 0,$sortString =''){
        $teacherRole = $this::$teacherRoleId;
        $jz = $this::$jZroleId;
        $studentRole = $this::$studentRoleId;
        $adminRole = $this::$adminRoleId;
        if($valueData == 0 && $sort==0){
            $allcount = "SELECT count(id) as count FROM $table WHERE roleId!=$teacherRole AND roleId!=$studentRole AND roleId!=$adminRole AND roleId!=$jz AND scId=$scId";
        }
        if($valueData!=0 && $sort!=0){
            $allcount = "SELECT count('id') as count FROM $table WHERE roleId!=$teacherRole AND roleId!=$studentRole AND roleId!=$adminRole AND roleId!=$jz AND scId=$scId ".$strLike.$sortString;
        }
        if($valueData!=0 && $sort==0){
            $allcount = "SELECT count('id') as count FROM $table WHERE roleId!=$teacherRole AND roleId!=$studentRole AND roleId!=$adminRole AND roleId!=$jz AND scId=$scId ".$strLike;
        }
        if($valueData==0 && $sort!=0){
            $allcount = "SELECT count('id') as count FROM $table WHERE roleId!=$teacherRole AND roleId!=$studentRole AND roleId!=$adminRole AND roleId!=$jz AND scId=$scId  $sortString";
        }
        $allList = M('user')->query($allcount);
        $allList = $allList[0]['count'];
        $pagesize = $_GET['pageSize'];
        $maxpage = ceil($allList/$pagesize);
        $page = $_GET['page'];
        if($page <= 1){
            $page = 1;
        } else if($page>=$maxpage){
            $page = $maxpage;
        } else{
            $page = $_GET['page'];
        }
        if($maxpage==0){
            $maxpage =1;
        }
        $startpage = ($page-1)*$pagesize;
        if($valueData == 0 && $sort==0){
            $userSql = "SELECT id,roleId,name,phone,sex,jobNumber,politics,post FROM mks_user WHERE roleId!=$teacherRole AND roleId!=$studentRole AND roleId!=$adminRole AND roleId!=$jz AND scId=$scId limit $startpage,$pagesize";
        }
        if($valueData!=0 && $sort!=0){
            $userSql = "SELECT * FROM $table WHERE scId=$scId and roleId!=$teacherRole AND roleId!=$studentRole AND roleId!=$jz AND roleId!=$adminRole  $strLike $sortString LIMIT $startpage,$pagesize";
        }
        if($valueData!=0 && $sort==0){
            $userSql = "SELECT * FROM $table WHERE scId=$scId and roleId!=$teacherRole AND roleId!=$studentRole AND roleId!=$jz AND roleId!=$adminRole  $strLike LIMIT $startpage,$pagesize";
        }
        if($valueData==0 && $sort!=0){
            $userSql = "SELECT * FROM $table WHERE scId=$scId and roleId!=$teacherRole AND roleId!=$studentRole AND roleId!=$jz AND roleId!=$adminRole   $sortString LIMIT $startpage,$pagesize";
        }
        /*foreach($data as $key => $value){
            $data[$key]['maxpage'] = $maxpage;
            $data[$key]['page'] = $page;
        }*/
        $data['data'] =  M('user')->query($userSql);
        $data['maxpage'] = $maxpage;
        $data['page'] = $page;
        $data['count'] = (int)$allList;
        //$data['maxpage']['maxpage'] = $maxpage;
        // $data['page']['page'] = $page;
        return $data;
    }
    private function getWorkerPassword($scId,$table,$valueData = 0,$strLike ='',$sort = 0,$sortString =''){
        $teacherRole = $this::$teacherRoleId;
        $jz = $this::$jZroleId;
        $studentRole = $this::$studentRoleId;
        $adminRole = $this::$adminRoleId;
        if($valueData == 0 && $sort==0){
            $allcount = "SELECT count(id) as count FROM $table WHERE roleId!=$teacherRole AND roleId!=$studentRole AND roleId!=$adminRole AND roleId!=$jz AND scId=$scId";
        }
        if($valueData!=0 && $sort!=0){
            $allcount = "SELECT count('id') as count FROM $table WHERE roleId!=$teacherRole AND roleId!=$studentRole AND roleId!=$adminRole AND roleId!=$jz AND scId=$scId ".$strLike.$sortString;
        }
        if($valueData!=0 && $sort==0){
            $allcount = "SELECT count('id') as count FROM $table WHERE roleId!=$teacherRole AND roleId!=$studentRole AND roleId!=$adminRole AND roleId!=$jz AND scId=$scId ".$strLike;
        }
        if($valueData==0 && $sort!=0){
            $allcount = "SELECT count('id') as count FROM $table WHERE roleId!=$teacherRole AND roleId!=$studentRole AND roleId!=$adminRole AND roleId!=$jz AND scId=$scId  $sortString";
        }
        $allList = M('user')->query($allcount);
        $allList = $allList[0]['count'];
        $pagesize = $_GET['pageSize'];
        $maxpage = ceil($allList/$pagesize);
        $page = $_GET['page'];
        if($page <= 1){
            $page = 1;
        } else if($page>=$maxpage){
            $page = $maxpage;
        } else{
            $page = $_GET['page'];
        }
        if($maxpage==0){
            $maxpage =1;
        }
        $startpage = ($page-1)*$pagesize;
        if($valueData == 0 && $sort==0){
            $userSql = "SELECT id,account,InitialPassword,name,phone,state,post FROM mks_user WHERE roleId!=$teacherRole AND roleId!=$studentRole AND roleId!=$adminRole AND roleId!=$jz AND scId=$scId limit $startpage,$pagesize";
        }
        if($valueData!=0 && $sort!=0){
            $userSql = "SELECT id,account,InitialPassword,name,phone,state,post FROM $table WHERE scId=$scId and roleId!=$teacherRole AND roleId!=$studentRole AND roleId!=$jz AND roleId!=$adminRole  $strLike $sortString LIMIT $startpage,$pagesize";
        }
        if($valueData!=0 && $sort==0){
            $userSql = "SELECT id,account,InitialPassword,name,phone,state,post FROM $table WHERE scId=$scId and roleId!=$teacherRole AND roleId!=$studentRole AND roleId!=$jz AND roleId!=$adminRole  $strLike LIMIT $startpage,$pagesize";
        }
        if($valueData==0 && $sort!=0){
            $userSql = "SELECT id,account,InitialPassword,name,phone,state,post FROM $table WHERE scId=$scId and roleId!=$teacherRole AND roleId!=$studentRole AND roleId!=$jz AND roleId!=$adminRole   $sortString LIMIT $startpage,$pagesize";
        }
        /*foreach($data as $key => $value){
            $data[$key]['maxpage'] = $maxpage;
            $data[$key]['page'] = $page;
        }*/
        $data['data'] =  M('user')->query($userSql);
        $data['maxpage'] = $maxpage;
        $data['page'] = $page;
        $data['count'] = (int)$allList;
        $data['tr'] = array(
            '0' => array(
                'en' => 'account',
                'zh' => '用户名'
            ),
            '1' => array(
                'en' => 'InitialPassword',
                'zh' => '初始密码'
            ),  '2' => array(
                'en' => 'name',
                'zh' => '名字'
            ), '3' => array(
                'en' => 'phone',
                'zh' => '手机'
            ), '4' => array(
                'en' => 'state',
                'zh' => '使用状态'
            ), '5' => array(
                'en' => 'post',
                'zh' => '岗位'
            )
        );
        //$data['maxpage']['maxpage'] = $maxpage;
        // $data['page']['page'] = $page;
        return $data;
    }
    private function  pageListPassword($scId,$table,$roleId,$valueData = 0,$strLike ='',$sort = 0,$sortString =''){
        $i = 1;
        //获取当前页数
        $teacherRoleId = $roleId;
        if($valueData == 0 && $sort==0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and roleId = $teacherRoleId";
        }
        if($valueData!=0 && $sort!=0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and roleId = $teacherRoleId  ".$strLike.$sortString;
        }
        if($valueData!=0 && $sort==0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and roleId = $teacherRoleId   ".$strLike;
        }
        if($valueData==0 && $sort!=0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and roleId = $teacherRoleId  $sortString";
        }
        $allList = M('user')->query($allcount);
        $allList = $allList[0]['count'];
        $pagesize = $_GET['pageSize'];
        $maxpage = ceil($allList/$pagesize);
        $page = $_GET['page'];
        if($page <= 1){
            $page = 1;
        } else if($page>=$maxpage){
            $page = $maxpage;
        } else{
            $page = $_GET['page'];
        }
        if($maxpage==0){
            $maxpage =1;
        }
        $startpage = ($page-1)*$pagesize;
        if($valueData == 0 && $sort==0){
            $userSql = "SELECT id,account,InitialPassword,name,phone,state FROM $table WHERE scId=$scId and roleId = $teacherRoleId  LIMIT $startpage,$pagesize";
        }
        if($valueData!=0 && $sort!=0){
            $userSql = "SELECT id,account,InitialPassword,name,phone,state FROM $table WHERE scId=$scId and roleId = $teacherRoleId  $strLike $sortString LIMIT $startpage,$pagesize";
        }
        if($valueData!=0 && $sort==0){
            $userSql = "SELECT id,account,InitialPassword,name,phone,state FROM $table WHERE scId=$scId and roleId = $teacherRoleId  $strLike LIMIT $startpage,$pagesize";
        }
        if($valueData==0 && $sort!=0){
            $userSql = "SELECT id,account,InitialPassword,name,phone,state FROM $table WHERE scId=$scId and roleId = $teacherRoleId   $sortString LIMIT $startpage,$pagesize";
        }
        /*foreach($data as $key => $value){
            $data[$key]['maxpage'] = $maxpage;
            $data[$key]['page'] = $page;
        }*/
        $data['data'] =  M('user')->query($userSql);
        $data['maxpage'] = $maxpage;
        $data['count'] = (int)$allList;
        $data['page'] = $page;
        $data['tr'] = array(
            '0' => array(
                'en' => 'account',
                'zh' => '用户名'
            ),
            '1' => array(
                'en' => 'InitialPassword',
                'zh' => '初始密码'
            ),  '2' => array(
                'en' => 'name',
                'zh' => '名字'
            ), '3' => array(
                'en' => 'phone',
                'zh' => '手机'
            ), '4' => array(
                'en' => 'state',
                'zh' => '使用状态'
            )
        );
        //$data['maxpage']['maxpage'] = $maxpage;
        // $data['page']['page'] = $page;
        return $data;
    }
    private function  studentPageListPassword($scId,$table,$roleId,$valueData = 0,$strLike ='',$sort = 0,$sortString =''){
        $i = 1;
        //获取当前页数
        $teacherRoleId = $roleId;
        if($valueData == 0 && $sort==0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and roleId = $teacherRoleId";
        }
        if($valueData!=0 && $sort!=0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and roleId = $teacherRoleId  ".$strLike.$sortString;
        }
        if($valueData!=0 && $sort==0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and roleId = $teacherRoleId   ".$strLike;
        }
        if($valueData==0 && $sort!=0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and roleId = $teacherRoleId  $sortString";
        }
        $allList = M('user')->query($allcount);
        $allList = $allList[0]['count'];
        $pagesize = $_GET['pageSize'];
        $maxpage = ceil($allList/$pagesize);
        $page = $_GET['page'];
        if($page <= 1){
            $page = 1;
        } else if($page>=$maxpage){
            $page = $maxpage;
        } else{
            $page = $_GET['page'];
        }
        if($maxpage==0){
            $maxpage =1;
        }
        $startpage = ($page-1)*$pagesize;
        if($valueData == 0 && $sort==0){
            $userSql = "SELECT id,grade,className,account,InitialPassword,name,phone,state FROM $table WHERE scId=$scId and roleId = $teacherRoleId  LIMIT $startpage,$pagesize";
        }
        if($valueData!=0 && $sort!=0){
            $userSql = "SELECT id,grade,className,account,InitialPassword,name,phone,state FROM $table WHERE scId=$scId and roleId = $teacherRoleId  $strLike $sortString LIMIT $startpage,$pagesize";
        }
        if($valueData!=0 && $sort==0){
            $userSql = "SELECT id,grade,className,account,InitialPassword,name,phone,state FROM $table WHERE scId=$scId and roleId = $teacherRoleId  $strLike LIMIT $startpage,$pagesize";
        }
        if($valueData==0 && $sort!=0){
            $userSql = "SELECT id,grade,className,account,InitialPassword,name,phone,state FROM $table WHERE scId=$scId and roleId = $teacherRoleId   $sortString LIMIT $startpage,$pagesize";
        }
        /*foreach($data as $key => $value){
            $data[$key]['maxpage'] = $maxpage;
            $data[$key]['page'] = $page;
        }*/
        $data['data'] =  M('user')->query($userSql);
        $data['maxpage'] = $maxpage;
        $data['count'] = (int)$allList;
        $data['page'] = $page;
        $data['tr'] = array(
            '0' => array(
                'en' => 'grade',
                'zh' => '年级'
            ),
            '1' => array(
                'en' => 'className',
                'zh' => '班级'
            ),  '2' => array(
                'en' => 'name',
                'zh' => '名字'
            ),
            '3' => array(
                'en' => 'account',
                'zh' => '学生用户名'
            ),
            '4' => array(
                'en' => 'InitialPassword',
                'zh' => '初始密码'
            ),
            '5' => array(
                'en' => 'phone',
                'zh' => '手机'
            ),
            '6' => array(
                'en' => 'state',
                'zh' => '使用状态'
            )
        );
        //$data['maxpage']['maxpage'] = $maxpage;
        // $data['page']['page'] = $page;
        return $data;
    }
    private function  jZPageListPassword($scId,$table,$roleId,$valueData = 0,$strLike ='',$sort = 0,$sortString =''){
        $i = 1;
        //获取当前页数
        $teacherRoleId = $roleId;
        if($valueData == 0 && $sort==0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and roleId = $teacherRoleId";
        }
        if($valueData!=0 && $sort!=0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and roleId = $teacherRoleId  ".$strLike.$sortString;
        }
        if($valueData!=0 && $sort==0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and roleId = $teacherRoleId   ".$strLike;
        }
        if($valueData==0 && $sort!=0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and roleId = $teacherRoleId  $sortString";
        }
        $allList = M('user')->query($allcount);
        $allList = $allList[0]['count'];
        $pagesize = $_GET['pageSize'];
        $maxpage = ceil($allList/$pagesize);
        $page = $_GET['page'];
        if($page <= 1){
            $page = 1;
        } else if($page>=$maxpage){
            $page = $maxpage;
        } else{
            $page = $_GET['page'];
        }
        if($maxpage==0){
            $maxpage =1;
        }
        $startpage = ($page-1)*$pagesize;
        if($valueData == 0 && $sort==0){
            $userSql = "SELECT id,grade,className,account,InitialPassword,name,phone,childName,state FROM $table WHERE scId=$scId and roleId = $teacherRoleId  LIMIT $startpage,$pagesize";
        }
        if($valueData!=0 && $sort!=0){
            $userSql = "SELECT id,grade,className,account,InitialPassword,name,phone,childName,state FROM $table WHERE scId=$scId and roleId = $teacherRoleId  $strLike $sortString LIMIT $startpage,$pagesize";
        }
        if($valueData!=0 && $sort==0){
            $userSql = "SELECT id,grade,className,account,InitialPassword,name,phone,childName,state FROM $table WHERE scId=$scId and roleId = $teacherRoleId  $strLike LIMIT $startpage,$pagesize";
        }
        if($valueData==0 && $sort!=0){
            $userSql = "SELECT id,grade,className,account,InitialPassword,name,phone,childName,state FROM $table WHERE scId=$scId and roleId = $teacherRoleId   $sortString LIMIT $startpage,$pagesize";
        }
        /*foreach($data as $key => $value){
            $data[$key]['maxpage'] = $maxpage;
            $data[$key]['page'] = $page;
        }*/
        $data['data'] =  M('user')->query($userSql);
        $data['maxpage'] = $maxpage;
        $data['count'] = (int)$allList;
        $data['page'] = $page;
        $data['tr'] = array(
            '0' => array(
                'en' => 'grade',
                'zh' => '年级'
            ),
            '1' => array(
                'en' => 'className',
                'zh' => '班级'
            ),  '2' => array(
                'en' => 'childName',
                'zh' => '学生姓名'
            ),
            '3' => array(
                'en' => 'account',
                'zh' => '家长用户名'
            ),
            '4' => array(
                'en' => 'InitialPassword',
                'zh' => '初始密码'
            ),
            '5' => array(
                'en' => 'name',
                'zh' => '家长姓名'
            ),
            '6' => array(
                'en' => 'phone',
                'zh' => '手机'
            ),
            '7' => array(
                'en' => 'state',
                'zh' => '使用状态'
            )
        );
        //$data['maxpage']['maxpage'] = $maxpage;
        // $data['page']['page'] = $page;
        return $data;
    }
    public function userPassword(){
        $type = $_GET['type'];
        $session = $this->get_session('loginCheck',false);
        $scId = $session['scId'];
        $userRoleId = $session['roleId'];
        if($type == 'getUserType'){
            $array = array(
                0 => array(
                    'name' => '职工',
                    'nameId' => 1
                ),
                 1 => array(
                'name' => '教师',
                'nameId' => 2
                ),
                 2 => array(
                'name' => '学生',
                'nameId' => 3
                ),
                 3 => array(
                'name' => '家长',
                'nameId' => 4
               )
            );
            $this->returnJson(array('statu' => 1,'message' => 'success','data' => $array),true);
        }
        if($type == 'getList'){
            $nameId = $_GET['nameId'];
            if($nameId == 1){
                if($_GET['sort']&&$_GET['value'] ){
                    $value = $_GET['value'];
                    $sort = $_GET['sort'];
                    if($sort=='ascending'){
                        $sort = 'asc';
                    }
                    if($sort == 'descending'){
                        $sort = 'desc';
                    }
                    $sortType = $_GET['sortType'];
                    $return = $this->getWorkerPassword($scId,'mks_user',1," and (name like '%$value%' OR post like '%$value%')",1," order by $sortType $sort");
                    $this->returnJson($return,true);
                }
                if(!$_GET['sort'] &&$_GET['value'] ){
                    $value = $_GET['value'];
                    $return = $this->getWorkerPassword($scId,'mks_user',1," and (name like '%$value%' OR post like '%$value%')");
                    $this->returnJson($return,true);
                }
                if($_GET['sort']&& !$_GET['value'] ){
                    $sort = $_GET['sort'];
                    if($sort=='ascending'){
                        $sort = 'asc';
                    }
                    if($sort == 'descending'){
                        $sort = 'desc';
                    }
                    $sortType = $_GET['sortType'];
                    $return = $this->getWorkerPassword($scId,'mks_user',0,'',1," order by $sortType $sort");
                    $this->returnJson($return,true);
                }
                $return = $this->getWorkerPassword($scId,'mks_user');
                $this->returnJson($return,true);
            }
            if($nameId == 2){
                if($_GET['sort'] &&$_GET['value']){
                    $value = $_GET['value'];
                    $sort = $_GET['sort'];
                    if($sort=='ascending'){
                        $sort = 'asc';
                    }
                    if($sort == 'descending'){
                        $sort = 'desc';
                    }
                    $sortType = $_GET['sortType'];
                    $return = $this->pageListPassword($scId,'mks_user',$this::$teacherRoleId,1," and (name like '%$value%' OR account like '%$value%')",1," order by $sortType $sort");
                    $this->returnJson($return,true);
                }
                if(!$_GET['sort'] &&$_GET['value'] ){
                    $value = $_GET['value'];
                    $return = $this->pageListPassword($scId,'mks_user',$this::$teacherRoleId,1," and (name like '%$value%' OR account like '%$value%')");
                    $this->returnJson($return,true);
                }
                if($_GET['sort'] && !$_GET['value'] ){
                    $sort = $_GET['sort'];
                    if($sort=='ascending'){
                        $sort = 'asc';
                    }
                    if($sort == 'descending'){
                        $sort = 'desc';
                    }
                    $sortType = $_GET['sortType'];
                    $return = $this->pageListPassword($scId,'mks_user',$this::$teacherRoleId,0,'',1," order by $sortType $sort");
                    $this->returnJson($return,true);
                }
                $return = $this->pageListPassword($scId,'mks_user',$this::$teacherRoleId);
                $this->returnJson($return,true);
            }
            if($nameId == 3){
                if($_GET['sort'] &&$_GET['value']){
                    $value = $_GET['value'];
                    $sort = $_GET['sort'];
                    if($sort=='ascending'){
                        $sort = 'asc';
                    }
                    if($sort == 'descending'){
                        $sort = 'desc';
                    }
                    $sortType = $_GET['sortType'];
                    $return = $this->studentPageListPassword($scId,'mks_user',$this::$studentRoleId,1," and (name like '%$value%' OR account like '%$value%')",1," order by $sortType $sort");
                    $this->returnJson($return,true);
                }
                if(!$_GET['sort'] &&$_GET['value'] ){
                    $value = $_GET['value'];
                    $return = $this->studentPageListPassword($scId,'mks_user',$this::$studentRoleId,1," and (name like '%$value%' OR account like '%$value%')");
                    $this->returnJson($return,true);
                }
                if($_GET['sort'] && !$_GET['value'] ){
                    $sort = $_GET['sort'];
                    if($sort=='ascending'){
                        $sort = 'asc';
                    }
                    if($sort == 'descending'){
                        $sort = 'desc';
                    }
                    $sortType = $_GET['sortType'];
                    $return = $this->studentPageListPassword($scId,'mks_user',$this::$studentRoleId,0,'',1," order by $sortType $sort");
                    $this->returnJson($return,true);
                }
                $return = $this->studentPageListPassword($scId,'mks_user',$this::$studentRoleId);
                $this->returnJson($return,true);
            }
            if($nameId == 4){
                if($_GET['sort'] &&$_GET['value']){
                    $value = $_GET['value'];
                    $sort = $_GET['sort'];
                    if($sort=='ascending'){
                        $sort = 'asc';
                    }
                    if($sort == 'descending'){
                        $sort = 'desc';
                    }
                    $sortType = $_GET['sortType'];
                    $return = $this->jZPageListPassword($scId,'mks_user',$this::$jZroleId,1," and (name like '%$value%' OR childName like '%$value%')",1," order by $sortType $sort");
                    $this->returnJson($return,true);
                }
                if(!$_GET['sort'] &&$_GET['value'] ){
                    $value = $_GET['value'];
                    $return = $this->jZPageListPassword($scId,'mks_user',$this::$jZroleId,1," and (name like '%$value%' OR childName like '%$value%')");
                    $this->returnJson($return,true);
                }
                if($_GET['sort'] && !$_GET['value'] ){
                    $sort = $_GET['sort'];
                    if($sort=='ascending'){
                        $sort = 'asc';
                    }
                    if($sort == 'descending'){
                        $sort = 'desc';
                    }
                    $sortType = $_GET['sortType'];
                    $return = $this->jZPageListPassword($scId,'mks_user',$this::$jZroleId,0,'',1," order by $sortType $sort");
                    $this->returnJson($return,true);
                }
                $return = $this->jZPageListPassword($scId,'mks_user',$this::$jZroleId);
                $this->returnJson($return,true);
            }
        }
        if($type == 'export'){
            $nameId = $_GET['nameId'];
            if($nameId == 1){
                $teacherRole = $this::$teacherRoleId;
                $jz = $this::$jZroleId;
                $studentRole = $this::$studentRoleId;
                $adminRole = $this::$adminRoleId;
                $userSql = "SELECT id,account,InitialPassword,name,phone,state,post FROM mks_user WHERE roleId!=$teacherRole AND roleId!=$studentRole AND roleId!=$adminRole AND roleId!=$jz AND scId=$scId";
                $data = M('')->query($userSql);
                $tr = array(
                    '0' => array(
                        'en' => 'account',
                        'zh' => '用户名'
                    ),
                    '1' => array(
                        'en' => 'InitialPassword',
                        'zh' => '初始密码'
                    ),  '2' => array(
                        'en' => 'name',
                        'zh' => '名字'
                    ), '3' => array(
                        'en' => 'phone',
                        'zh' => '手机'
                    ), '4' => array(
                        'en' => 'post',
                        'zh' => '岗位'
                    )
                );
                $this->export($data,$tr);
            }
            if($nameId == 2){
                $teacherRoleId = $this::$teacherRoleId;
                $userSql = "SELECT id,account,InitialPassword,name,phone,state FROM mks_user WHERE scId=$scId and roleId = $teacherRoleId";
                $data = M('')->query($userSql);
                $tr = array(
                    '0' => array(
                        'en' => 'account',
                        'zh' => '用户名'
                    ),
                    '1' => array(
                        'en' => 'InitialPassword',
                        'zh' => '初始密码'
                    ),  '2' => array(
                        'en' => 'name',
                        'zh' => '名字'
                    ), '3' => array(
                        'en' => 'phone',
                        'zh' => '手机'
                    )
                );
                $this->export($data,$tr);
            }
            if($nameId == 3){
                $studentRole = $this::$studentRoleId;
                $userSql = "SELECT id,grade,className,account,InitialPassword,name,phone,state FROM mks_user WHERE scId=$scId and roleId = $studentRole order BY grade,className";
                $data = M('')->query($userSql);
                $tr = array(
                    '0' => array(
                        'en' => 'grade',
                        'zh' => '年级'
                    ),
                    '1' => array(
                        'en' => 'className',
                        'zh' => '班级'
                    ),  '2' => array(
                        'en' => 'name',
                        'zh' => '名字'
                    ),
                    '3' => array(
                        'en' => 'account',
                        'zh' => '学生用户名'
                    ),
                      '4' => array(
                    'en' => 'InitialPassword',
                    'zh' => '初始密码'
                    ),
                      '5' => array(
                    'en' => 'phone',
                    'zh' => '手机'
                    )
                );
                $this->export($data,$tr);
            }
            if($nameId == 4){
                $jZroleId = $this::$jZroleId;
                $userSql = "SELECT id,grade,className,account,InitialPassword,name,phone,childName FROM mks_user WHERE scId=$scId and roleId = $jZroleId";
                $data = M('')->query($userSql);
                $tr = array(
                    '0' => array(
                        'en' => 'grade',
                        'zh' => '年级'
                    ),
                    '1' => array(
                        'en' => 'className',
                        'zh' => '班级'
                    ),  '2' => array(
                        'en' => 'childName',
                        'zh' => '学生姓名'
                    ),
                    '3' => array(
                        'en' => 'account',
                        'zh' => '家长用户名'
                    ),
                    '4' => array(
                        'en' => 'InitialPassword',
                        'zh' => '初始密码'
                    ),
                    '5' => array(
                        'en' => 'name',
                        'zh' => '家长姓名'
                    ),
                    '6' => array(
                        'en' => 'phone',
                        'zh' => '手机'
                    )
                );
                $this->export($data,$tr);
            }
        }
        if($type == 'updataPassword'){
            $id = $_GET['id'];
            $password = $this->InitialPassword();
            if(M('user')->where(array('id' => $id))->setField(array(
                'password' => $this->create_password($password,self::$password_key,self::$password_key1),
                'InitialPassword' => $password
            ))){
                $this->returnJson(array('statu' => 1,'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0,'message' => 'fail'),true);
        }
        if($type == 'stopUse'){
            $id = $_GET['id'];
            $user = M('user')->where(array('id' => $id))->find();
            $state = 0;
            if($user['state']){
                $state = 0;
            }else{
                $state = 1;
            }
            if(M('user')->where(array('id' => $id))->setField(array(
                'state' => $state
            ))){
                $this->returnJson(array('statu' => 1,'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0,'message' => 'fail'),true);
        }
    }
    public function userGl(){
        //$phpexcel = new \PHPExcel();
        $type = $_GET['type'];
        //$roleId = $_GET['roleId'];
        //$roleName = $_GET['roleName'];
        $session = $this->get_session('loginCheck',false);
        $scId = $session['scId'];
        $userRoleId = $session['roleId'];
        if(isset($_GET['roleId'])){
            $roleId = $_GET['roleId'];
            $roleNameEn = M('role')->field('roleNameEn')->where(array('roleId' => $roleId))->find();
            $roleNameEn = $roleNameEn['roleNameEn'];
        }
        if($type == 'teacherList'){
            //每一页显示的数据条数
            if($_GET['sort'] &&$_GET['value']){
                $value = $_GET['value'];
                $sort = $_GET['sort'];
                if($sort=='ascending'){
                    $sort = 'asc';
                }
                if($sort == 'descending'){
                    $sort = 'desc';
                }
                $sortType = $_GET['sortType'];
                $return = $this->pageList($scId,'mks_user',$this::$teacherRoleId,1," and (name like '%$value%' OR teachingSubjects like '%$value%')",1," order by $sortType $sort");
                $this->returnJson($return,true);
            }
            if(!$_GET['sort'] &&$_GET['value'] ){
                $value = $_GET['value'];
                $return = $this->pageList($scId,'mks_user',$this::$teacherRoleId,1," and (name like '%$value%' OR teachingSubjects like '%$value%')");
                $this->returnJson($return,true);
            }
            if($_GET['sort'] && !$_GET['value'] ){
                $sort = $_GET['sort'];
                if($sort=='ascending'){
                    $sort = 'asc';
                }
                if($sort == 'descending'){
                    $sort = 'desc';
                }
                $sortType = $_GET['sortType'];
                $return = $this->pageList($scId,'mks_user',$this::$teacherRoleId,0,'',1," order by $sortType $sort");
                $this->returnJson($return,true);
            }
            $return = $this->pageList($scId,'mks_user',$this::$teacherRoleId);
            $this->returnJson($return,true);
        }
        if($type == 'studentPersonalData'){
            $userId =$_GET['userId'];
            $data = array(
                'student_info' =>   M('student_info')->where(array('userId' => $userId))->find(),
                'cen_reg_info' => M('cen_reg_info')->where(array('userId' => $userId))->find(),
                'school_rollinfo' =>  M('school_rollinfo')->where(array('userId' => $userId))->find(),
                'parents_info'=> M('parents_info')->where(array('userId' => $userId))->find(),
                'other_info' =>  M('other_info')->where(array('userId' => $userId))->find(),
                'tuition_info' =>  M('tuition_info')->where(array('userId' => $userId))->find(),
                'statu' => 1,
                'message' =>  'success',
            );
            $this->returnJson($data,true);
        }
        if($type == 'studentPersonalUpdata'){
            $ListType = $_POST['ListType'];
            $table = '';
            if($ListType == 'jbXi'){
                $table = 'student_info';
            }
            if($ListType == 'xjXi'){//学籍信息
                $table = 'school_rollinfo';
            }
            if($ListType == 'hjXi'){//户籍
                $table = 'cen_reg_info';
            }
            if($ListType == 'jzXi'){//家长
                $table = 'parents_info';
            }
            if($ListType == 'xfXi'){//学费信息
                $table = 'tuition_info';
            }
            if($ListType == 'qtXi'){//其他信息
                $table = 'other_info';
            }
            if(!isset($_POST['updataData'])){
                $this->returnJson(array('statu' => 0, 'message' => 'updata fail'),true);
            }
            $data = $_POST['updataData'];
            $userId = $data['userId'];
            if(M($table)->where(array('userId' => $userId))->setField($data)){
                $this->returnJson(array('statu' => 1, 'message' => 'updata success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'updata fail'),true);
        }
        if($type == 'personData'){
            $session = $this->get_session('loginCheck',false);
            $scId = $session['scId'];
            $userRoleId = $session['roleId'];
            if($this::$studentRoleId == $userRoleId){

            }
        }
        if($type == 'workerList'){
            if($_GET['sort']&&$_GET['value'] ){
                $value = $_GET['value'];
                $sort = $_GET['sort'];
                if($sort=='ascending'){
                    $sort = 'asc';
                }
                if($sort == 'descending'){
                    $sort = 'desc';
                }
                $sortType = $_GET['sortType'];
                $return = $this->getWorkPage($scId,'mks_user',1," and (name like '%$value%' OR post like '%$value%')",1," order by $sortType $sort");
                $this->returnJson($return,true);
            }
            if(!$_GET['sort'] &&$_GET['value'] ){
                $value = $_GET['value'];
                $return = $this->getWorkPage($scId,'mks_user',1," and (name like '%$value%' OR post like '%$value%')");
                $this->returnJson($return,true);
            }
            if($_GET['sort']&& !$_GET['value'] ){
                $sort = $_GET['sort'];
                if($sort=='ascending'){
                    $sort = 'asc';
                }
                if($sort == 'descending'){
                    $sort = 'desc';
                }
                $sortType = $_GET['sortType'];
                $return = $this->getWorkPage($scId,'mks_user',0,'',1," order by $sortType $sort");
                $this->returnJson($return,true);
            }
            $return = $this->getWorkPage($scId,'mks_user');
            $this->returnJson($return,true);
        }
        if($type == 'download'){
            $downType = $_GET['downType'];
            $url = $this::$downUrl;
            if($downType == 'student'){
                //$this::download($this::$uploadUrl.'downloadexcel','student.xlsx');
                header("Location: $url/Public/upload/downloadexcel/student.xlsx");
            }if($downType == 'teacher'){
                //$this::download($this::$uploadUrl.'downloadexcel','teacher.xlsx');
                header("Location: $url/Public/upload/downloadexcel/teacher.xls");
            }if($downType == 'worker'){
                header("Location: $url/Public/upload/downloadexcel/worker.xlsx");
            }
        }
        if($type == 'studentStatistics'){
            $grade = $_GET['grade'];
            $orderBy = $_GET['orderBy'];
            $sort = $_GET['sort'];
            $pagesize = $this::$pageSize;
            $sqlWoman = "SELECT count(userId) as count,className,sum(isLeave) as isLeave,sum(isTempStudy) as  isTempStudy,sum(isSubor) as  isSubor FROM mks_school_rollinfo where grade = $grade GROUP BY className ORDER BY $orderBy $sort";
            $sqlMan = "SELECT count(userId) as count,className  FROM mks_school_rollinfo where sex='女' AND grade = 1 GROUP BY className";
            $dataWoman = M('')->query($sqlWoman);
            $dataMan = M('')->query($sqlMan);
            foreach($dataWoman as $key => $value){
                foreach($dataMan as $key1 => $value1){
                    if($value['className'] == $value1['className']){
                        $dataWoman[$key]['man'] = $value['count'] - $value1['count'];
                        $dataWoman[$key]['woman'] = $value1['count'];
                    }
                }
                if(!isset($dataWoman[$key]['man'])){
                    $dataWoman[$key]['man'] = $value['count'];
                    $dataWoman[$key]['woman'] = 0;
                }
            }
            $allList = count($dataWoman);
            $maxpage = ceil($allList/$pagesize);
            $page = $_GET['page'];
            if($page <= 1){
                $page = 1;
            } else if($page>=$maxpage){
                $page = $maxpage;
            } else{
                $page = $_GET['page'];
            }
            if($maxpage==0){
                $maxpage =1;
            }
            $startcell = ($page - 1)*$pagesize;
            $endcell = $page*$pagesize;
            $return = array();
            $i = 0;
            foreach($dataWoman as $key => $value){
                if($i< $pagesize && $i>= $startcell){
                    $return[] = $value;
                }
                $i++;
            }
            $returnData = array();
            $returnData['data'] = $return;
            $returnData['page'] = $page;
            $returnData['maxpage'] = $maxpage;
            $this::returnJson($returnData,true);
        }
        if($type == 'studentList'){
            $ListType = $_GET['ListType'];
            /*$studentRole = $this::$studentRoleId;
            $grade = $_GET['grade'];
            $class = $_GET['class'];
            //echo $class;
            //$user = M('user')->where(array('grade' => $grade))
            $str = '';
            $len = count($class);
            $i = 1;
            foreach($class as $key => $value){
                $i++;
                if($i<=$len){
                    $str = 'className='.$value.' or '.$str;
                }else{
                    $str = $str.'className='.$value;
                }
            }
            $allcount = "SELECT count('id') as count FROM mks_user WHERE scId=$scId and grade=$grade and  ($str)";
            //$userSql = "SELECT id,name,grade,className FROM mks_user WHERE scId=$scId and grade=$grade and  ($str)";
            $allList = M('user')->query($allcount);
            $allList = $allList[0]['count'];
            $pagesize = $this::$pageSize;
            $maxpage = ceil($allList/$pagesize);
            //获取当前页数
            $page = $_GET['page'];
            if($page <= 1){
                $page = 1;
            } else if($page>=$maxpage){
                $page = $maxpage;
            } else{
                $page = $_GET['page'];
            }
            if($maxpage==0){
                $maxpage =1;
            }
            $startpage = ($page-1)*$pagesize;
            $userSql = "SELECT id,name,grade,className FROM mks_user WHERE scId=$scId and grade=$grade and  ($str) limit $startpage,$pagesize";
            $data = M('user')->query($userSql);
            $datacount = M('user')->query($allcount);
            $return = array();
            */
            if($ListType == 'jbXi'){
                $this->returnJson($this::studentXi($scId,'mks_student_info'),true);
            }
            if($ListType == 'xjXi'){//学籍信息
                $this->returnJson($this::studentXi($scId,'mks_school_rollinfo'),true);
            }
            if($ListType == 'hjXi'){//户籍
                $this->returnJson($this::studentXi($scId,'mks_cen_reg_info'),true);
            }
            if($ListType == 'jzXi'){//家长
                $this->returnJson($this::studentXi($scId,'mks_parents_info'),true);
            }
            if($ListType == 'xfXi'){//学费信息
                $this->returnJson($this::studentXi($scId,'mks_tuition_info'),true);
            }
            if($ListType == 'qtXi'){//其他信息
                $this->returnJson($this::studentXi($scId,'mks_other_info'),true);
            }
        }
        if($type == 'deleteStaff'){//删除职工
            $delUserid = $_POST['userId'];
            if(!is_array($delUserid)){
                $delUserid = (array)$delUserid;
            }
            foreach($delUserid as $key => $value){
                if($roleId != $this::$adminRoleId){
                    M('user')->where(array('id' =>$value))->delete();
                }
            }
            $this->returnJson(array('statu' => 1,'message' => 'delete success'),true);
        }
        if($type == 'deleteTethe'){//删除教师
            $delUserid = $_POST['userId'];
            if(!is_array($delUserid)){
                $delUserid = (array)$delUserid;
            }
            foreach($delUserid as $key => $value){
                M('user')->where(array('id' =>$value,'roleId' => $this::$teacherRoleId))->delete();
            }
            $this->returnJson(array('statu' => 1,'message' => 'delete success'),true);
        }
        if($type == 'deleteStudent'){//删除学生
            $delUserid = $_POST['userId'];
            if(!is_array($delUserid)){
                $delUserid = (array)$delUserid;
            }
            foreach($delUserid as $key => $value){
                M('user')->where(array('id' =>$value,'roleId' => $this::$studentRoleId))->delete();
                M('student_info')->where(array('userId' =>$value))->delete();
                M('school_rollinfo')->where(array('userId' =>$value))->delete();
                M('parents_info')->where(array('userId' =>$value))->delete();
                M('tuition_info')->where(array('userId' =>$value))->delete();
                M('other_info')->where(array('userId' =>$value))->delete();
            }
            $this->returnJson(array('statu' => 1,'message' => 'delete success'),true);
        }
        $createTime = strtotime(date('Y-m-d H:i:s'));
        $prefix = M('school')->field('prefix')->where(array('scId' => $scId))->find();
        $prefix = $prefix['prefix'];
        $maxNumber = M('user')->where(array('scId' => $scId))->max('number');
        if(!$maxNumber){
            $maxNumber = (int)date('Y').'000000';
        }else{
            $maxNumber++;
        }
        //$password = $this->create_password($password,self::$password_key,self::$password_key1);
        if($type == 'export'){
            define('MAX_SIZE_FILE_UPLOAD', '10000000' );
            header('content-type:text/html;charset=utf-8');
            //$verifyToken = md5('unique_salt' . $_POST['timestamp']);
            if (!empty($_FILES)/* && $_POST['token'] == $verifyToken*/){
                $tempFile = $_FILES['userFile']['tmp_name'];
                $targetPath = dirname(dirname(dirname(dirname(__FILE__))));
                $targetPath = $targetPath.'\Public\upload\\'.$scId.'\\';
                if(!file_exists($targetPath)){
                    mkdir($targetPath);
                }
                //$targetFile = $targetPath.$_FILES['userFile']['name'];
                //Validate the file type
                $fileTypes = array('xlsx','doc','xls'); // File extensions
                $fileParts = pathinfo($_FILES['userFile']['name']);
                $flieExtension = $fileParts['extension'];
                $targetFile = $targetPath.md5(uniqid('gsfdg')).'.'.$flieExtension;
                if (in_array($flieExtension,$fileTypes)){
                    if(move_uploaded_file($tempFile,$targetFile)){
                        vendor('PHPExcel.PHPExcel');
                        //vendor('PHPExcel.PHPExcel.IOFactory');
                        //vendor('PHPExcel.PHPExcel.Reader.IOFactory');
                        //vendor('PHPExcel.PHPExcel.Reader.Excel2007');
                        $objReader = 0;
                        if($flieExtension == 'xls'){
                            $objReader = new \PHPExcel_Reader_Excel5();
                        }
                        if($flieExtension == 'xlsx'){
                            $objReader = new \PHPExcel_Reader_Excel2007();
                        }
                        $objPHPExcel = $objReader->load($targetFile); //Excel 路径
                        $sheet = $objPHPExcel->getSheet(0);
                        $highestRow = $sheet->getHighestRow(); // 取得总行数
                        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
                        $strs=array();//USER表信息；
                        $hujixinxi = array();//户籍信息
                        $b = 0;
                        $getSession = $this->get_session('loginCheck',false);
                        $qxModelName = $getSession['scId'].'school'.$getSession['roleId'];
                        $userModelList = json_decode($this->redis_operation($qxModelName,0,0,3),true);
                        $roleNameEn = $_GET['roleNameEn'];
                        if($roleNameEn == 'xs'){
                            $trueorfalse = 0;
                            foreach($userModelList as $key => $value){
                                if($value['modelName'] == '批量导入学生'){
                                    $trueorfalse =1;
                                    break;
                                }
                            }
                            if($getSession['roleId'] == $this::$adminRoleId){
                                $trueorfalse =1;
                            }
                            if(!$trueorfalse){
                                $this->returnJson(array('statu' => 0,'message' => 'No permissions'),true);
                            }
                            for ($j=1;$j<=$highestRow;$j++){
                                $i = 0;
                                for($k='A';$k<=$highestColumn;$k++){//从A列读取数据
                                    //实测在excel中，如果某单元格的值包含了||||||导入的数据会为空
                                    $i++;
                                    if($k == 'A'){
                                        $strs[$b]['className'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'B'){
                                        $strs[$b]['name'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'C'){
                                        $strs[$b]['sex'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'D'){
                                        $strs[$b]['phone'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'E'){
                                        $strs[$b]['major'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'F'){
                                        $strs[$b]['statu'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'G'){
                                        $strs[$b]['hkAddress'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'H'){
                                        $strs[$b]['hklx'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'I'){
                                        $strs[$b]['birth'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'J'){
                                        $strs[$b]['idCard'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }if($k == 'K'){
                                        $strs[$b]['grade'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'L'){
                                        $strs[$b]['ifExtern'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                }
                                $password = $this->InitialPassword();
                                $maxNumber++;
                                $strs[$b]['account'] = $prefix. $maxNumber;
                                $strs[$b]['password'] =  $this->create_password($password,self::$password_key,self::$password_key1);
                                $strs[$b]['InitialPassword'] = $password;
                                $strs[$b]['roleId'] = $this::$studentRoleId;
                                $strs[$b]['createTime'] = $createTime;
                                $strs[$b]['scId'] = $scId;
                                $strs[$b]['scPrefix'] = $prefix;
                                $strs[$b]['number'] = $maxNumber;
                                $b++;
                                $maxNumber++;
                            }
                            unset($strs[0]);
                        }
                        else if($roleNameEn == 'js'){
                            $trueorfalse = 0;
                            foreach($userModelList as $key => $value){
                                if($value['modelName'] == '批量导入教师'){
                                    $trueorfalse =1;
                                    break;
                                }
                            }
                            if($getSession['roleId'] == $this::$adminRoleId){
                                $trueorfalse =1;
                            }
                            if(!$trueorfalse){
                                $this->returnJson(array('statu' => 0,'message' => 'No permissions'),true);
                            }
                            for ($j=1;$j<=$highestRow;$j++){//从第一行开始读取  数据
                                $i = 0;
                                for($k='A';$k<=$highestColumn;$k++){//从A列读取数据
                                    //实测在excel中，如果某单元格的值包含了||||||导入的数据会为空
                                    $i++;
                                    if($k == 'A'){
                                        $strs[$b]['name'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'B'){
                                        $strs[$b]['sex'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'C'){
                                        $strs[$b]['teachingSubjects'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'D'){
                                        $strs[$b]['politics'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'E'){
                                        $strs[$b]['phone'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'F'){
                                        $strs[$b]['jobNumber'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                }
                                $password = $this->InitialPassword();
                                $strs[$b]['account'] = $prefix. $maxNumber;
                                $strs[$b]['password'] =  $this->create_password($password,self::$password_key,self::$password_key1);
                                $strs[$b]['roleId'] = $this::$teacherRoleId;
                                $strs[$b]['InitialPassword'] = $password;
                                $strs[$b]['createTime'] = $createTime;
                                $strs[$b]['scId'] = $scId;
                                $strs[$b]['scPrefix'] = $prefix;
                                $strs[$b]['number'] = $maxNumber;
                                $strs[$b]['post'] = '教师';
                                $b++;
                                $maxNumber++;
                            }
                            unset($strs[0]);
                        }else{
                            $trueorfalse = 0;
                            foreach($userModelList as $key => $value){
                                if($value['modelName'] == '批量导入职工'){
                                    $trueorfalse =1;
                                    break;
                                }
                            }
                            if($getSession['roleId'] == $this::$adminRoleId){
                                $trueorfalse =1;
                            }
                            if(!$trueorfalse){
                                $this->returnJson(array('statu' => 0,'message' => 'No permissions'),true);
                            }
                            for ($j=1;$j<=$highestRow;$j++){
                                $i = 0;
                                for($k='A';$k<=$highestColumn;$k++){//从A列读取数据
                                    //实测在excel中，如果某单元格的值包含了||||||导入的数据会为空
                                    $i++;
                                    if($k == 'A'){
                                        $strs[$b]['name'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'B'){
                                        $strs[$b]['sex'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'C'){
                                        $strs[$b]['post'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'D'){
                                        $strs[$b]['phone'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'E'){
                                        $strs[$b]['politics'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                    if($k == 'F'){
                                        $strs[$b]['jobNumber'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                    }
                                }
                                $password = $this->InitialPassword();
                                $strs[$b]['account'] = $prefix. $maxNumber;
                                $strs[$b]['password'] =  $this->create_password($password,self::$password_key,self::$password_key1);
                                $strs[$b]['InitialPassword'] = $password;
                                $strs[$b]['createTime'] = $createTime;
                                $strs[$b]['scId'] = $scId;
                                $strs[$b]['scPrefix'] = $prefix;
                                $strs[$b]['number'] = $maxNumber;
                                $role = M('role')->where(array('scId' => $scId,'roleName' => $strs[$b]['post']))->find();
                                $strs[$b]['roleId'] = $role['roleId'];
                                $b++;
                                $maxNumber++;
                            }
                            unset($strs[0]);
                        }
                        $class = $this->getClass($scId);
                        foreach($strs as $key => $value){
                            $value['gradeId'] = $class[$value['grade']][$value['className']]['gradeId'];
                            $value['class'] = $class[$value['grade']][$value['className']]['classId'];
                            $id = M('user')->add($value);
                            if($roleNameEn == 'xs'){
                                $password = $this->InitialPassword();
                                M('user')->add(array(
                                    'className' => $value['className'],
                                    'grade' => $value['grade'],
                                    'name' => $value['name'].'家长',
                                    'number' => $value['number']-1,
                                    'scPrefix' => $value['scPrefix'],
                                    'scId' => $value['scId'],
                                    'roleId' => $this::$jZroleId,
                                    'password' => $this->create_password($password,self::$password_key,self::$password_key1),
                                    'InitialPassword' => $password,
                                    'account' => $prefix.($value['number']-1),
                                    'statu' => 1,
                                    'childId' => $id,
                                    'childName' => $value['name'],
                                    'gradeId' => $class[$value['grade']][$value['className']]['gradeId'],
                                    'class' => $class[$value['grade']][$value['className']]['classId'],
                                    'createTime' => $createTime
                                ));
                                M('student_info')->add(array(
                                    'userId' => $id,
                                    'scId' => $value['scId'],
                                    'gradeId' => $class[$value['grade']][$value['className']]['gradeId'],
                                    'classId' => $class[$value['grade']][$value['className']]['classId'],
                                    'name' => $value['name'],
                                    'className' =>  $value['className'],
                                    'grade' =>  $value['grade'],
                                    'idCard' =>  $value['idCard'],
                                    'createTime' =>  $value['createTime'],
                                    'phone' =>  $value['phone'],
                                    'sex' =>  $value['sex'],
                                    'isResSchool' =>  $value['ifExtern'],
                                ));
                                M('cen_reg_info')->add(array(
                                    'userId' => $id,
                                    'scId' => $value['scId'],
                                    'name' => $value['name'],
                                    'className' =>  $value['className'],
                                    'grade' =>  $value['grade'],
                                    'createTime' =>  $value['createTime'],
                                    'cenRegType' =>  $value['hklx'],
                                    'nativePlace' =>  $value['hkAddress'],
                                ));
                                M('school_rollinfo')->add(array(
                                    'userId' => $id,
                                    'scId' => $value['scId'],
                                    'name' => $value['name'],
                                    'className' =>  $value['className'],
                                    'grade' =>  $value['grade'],
                                    'createTime' =>  $value['createTime'],
                                ));
                                M('parents_info')->add(array(
                                    'userId' => $id,
                                    'scId' => $value['scId'],
                                    'name' => $value['name'],
                                    'className' =>  $value['className'],
                                    'grade' =>  $value['grade'],
                                    'createTime' =>  $value['createTime'],
                                ));
                                M('other_info')->add(array(
                                    'userId' => $id,
                                    'scId' => $value['scId'],
                                    'name' => $value['name'],
                                    'className' =>  $value['className'],
                                    'grade' =>  $value['grade'],
                                    'createTime' =>  $value['createTime'],
                                ));
                                M('tuition_info')->add(array(
                                    'userId' => $id,
                                    'scId' => $value['scId'],
                                    'name' => $value['name'],
                                    'className' =>  $value['className'],
                                    'grade' =>  $value['grade'],
                                    'createTime' =>  $value['createTime'],
                                ));
                            }
                        }
                        if($id){
                            $this->returnJson(array('statu' => 1, 'message' => 'export success'),true);
                        }
                        else  $this->returnJson(array('statu' => 0, 'message' => 'export fail'),true);
                    }
                }
            }
            $this->returnJson(array('statu' => 101,'message' => 'upload file fail'),true);

        }
        if($type == 'addStudent'){//创建学生
            $class = $this->getClass($scId);
            $password = $this->InitialPassword();
            $number = $maxNumber;
            $return = M('user')->add(array(
                'phone' => $_POST['phone'],
                'className' => $_POST['className'],
                'sex' => $_POST['sex'],
                'idCard' => $_POST['idCard'],
                'hklx' => $_POST['hklx'],
                'hkAddress' => $_POST['hkAddress'],
                'className' => $_POST['className'],
                'name' => $_POST['name'],
                'statu' => $_POST['statu'],
                'major' => $_POST['major'],
                'idCard' => $_POST['idCard'],
                'grade' => $_POST['grade'],
                'ifExtern' => $_POST['ifExtern'],
                'birth' => $_POST['birth'],
                'grade' => $_POST['grade'],
                'gradeId' => $class[$_POST['grade']][$_POST['className']]['gradeId'],
                'class' => $class[$_POST['grade']][$_POST['className']]['classId'],
                'number' => $number,
                'scPrefix' => $prefix,
                'scId' => $scId,
                'roleId' => $this::$studentRoleId,
                'password' => $this->create_password($password,self::$password_key,self::$password_key1),
                'InitialPassword' => $password,
                'account' => $prefix.$number,
                'statu' => 1,
                'createTime' => $createTime
            ));
            if($return){
                $password = $this->InitialPassword();
                M('user')->add(
                    array(
                        'statu' => $_POST['statu'],
                        'grade' => $_POST['grade'],
                        'childId' => $return,
                        'childName' => $_POST['name'],
                        'className' => $_POST['className'],
                        'name' => $_POST['name'].'家长',
                        'gradeId' => $class[$_POST['grade']][$_POST['className']]['gradeId'],
                        'class' => $class[$_POST['grade']][$_POST['className']]['classId'],
                        'number' => $number+1,
                        'scPrefix' => $prefix,
                        'scId' => $scId,
                        'roleId' => $this::$jZroleId,
                        'password' => $this->create_password($password,self::$password_key,self::$password_key1),
                        'InitialPassword' => $password,
                        'account' => $prefix.($number+1),
                        'statu' => 1,
                        'createTime' => $createTime
                    )
                );
                M('student_info')->add(array(
                    'userId' => $return,
                    'scId' => $scId,
                    'name' => $_POST['name'],
                    'className' =>  $_POST['className'],
                    'grade' =>   $_POST['grade'],
                    'idCard' =>  $_POST['idCard'],
                    'gradeId' => $class[$_POST['grade']][$_POST['className']]['gradeId'],
                    'classId' => $class[$_POST['grade']][$_POST['className']]['classId'],
                    'createTime' => $createTime,
                    'phone' =>  $_POST['phone'],
                    'sex' =>  $_POST['sex'],
                ));
                M('cen_reg_info')->add(array(
                    'userId' => $return,
                    'scId' => $scId,
                    'name' => $_POST['name'],
                    'className' => $_POST['className'],
                    'grade' =>  $_POST['grade'],
                    'createTime' =>  $createTime,
                    'cenRegType' =>  $_POST['hklx'],
                    'nativePlace' =>  $_POST['hkAddress'],
                ));
                M('school_rollinfo')->add(array(
                    'userId' => $return,
                    'scId' => $scId,
                    'name' => $_POST['name'],
                    'className' => $_POST['className'],
                    'grade' =>  $_POST['grade'],
                    'createTime' =>  $createTime,
                    'isResSchool' => $_POST['ifExtern'],
                ));
                M('parents_info')->add(array(
                    'userId' => $return,
                    'scId' => $scId,
                    'name' => $_POST['name'],
                    'className' => $_POST['className'],
                    'grade' =>  $_POST['grade'],
                    'createTime' =>  $createTime,
                ));
                M('other_info')->add(array(
                    'userId' => $return,
                    'scId' => $scId,
                    'name' => $_POST['name'],
                    'className' => $_POST['className'],
                    'grade' =>  $_POST['grade'],
                    'createTime' =>  $createTime,
                ));
                M('tuition_info')->add(array(
                    'userId' => $return,
                    'scId' => $scId,
                    'name' => $_POST['name'],
                    'className' => $_POST['className'],
                    'grade' =>  $_POST['grade'],
                    'createTime' =>  $createTime,
                ));
                $this->returnJson(array('statu' => 1,'message' => 'add  succeess'),true);
            }
            $this->returnJson(array('statu' => 0,'message' => 'add  fail'),true);
        }
        if($type == 'addTeather'){//创建老师
            $number = $maxNumber;
            $password = $this->InitialPassword();
            $return = M('user')->add(array(
                'phone' => $_POST['phone'],
                'sex' => $_POST['sex'],
                'name' => $_POST['name'],
                'teachingSubjects' => $_POST['teachingSubjects'],
                'jobNumber' => $_POST['jobNumber'],
                'politics' => $_POST['politics'],
                'department' => $_POST['department'],
                'departmentId' => $_POST['departmentId'],
                'number' => $number,
                'post' => '教师',
                'scPrefix' => $prefix,
                'scId' => $scId,
                'roleId' => $this::$teacherRoleId,
                'password' => $this->create_password($password,self::$password_key,self::$password_key1),
                'account' => $prefix.$number,
                'InitialPassword' => $password,
                'statu' => 1,
                'createTime' => $createTime
            ));
            if($return){
                $this->returnJson(array('statu' => 1,'message' => 'add  succeess'),true);
            }
            $this->returnJson(array('statu' => 0,'message' => 'add  fail'),true);
        }
        if($type == 'addStaff'){//创建员工
            $number = $maxNumber;
            if($roleId != $this::$adminRoleId){
                $password = $this->InitialPassword();
                $return = M('user')->add(array(
                    'phone' => $_POST['phone'],
                    'sex' => $_POST['sex'],
                    'name' => $_POST['name'],
                    'post' => $_POST['post'],
                    'jobNumber' => $_POST['jobNumber'],
                    'politics' => $_POST['politics'],
                    //'department' => $_POST['department'],
                    //'departmentId' => $_POST['departmentId'],
                    'number' => $number,
                    'scPrefix' => $prefix,
                    'scId' => $scId,
                    'roleId' => $_POST['roleId'],
                    'password' => $this->create_password($password,self::$password_key,self::$password_key1),
                    'account' => $prefix.$number,
                    'statu' => 1,
                    'InitialPassword' => $password,
                    'createTime' => $createTime
                ));
                if($return){
                    $this->returnJson(array('statu' => 1,'message' => 'add  succeess'),true);
                }
                $this->returnJson(array('statu' => 0,'message' => 'add  fail'),true);
            }
            $this->returnJson(array('statu' => 0,'message' => 'no permissions'),true);
        }
        if($type == 'updataStudent'){
            $userId = $_POST['userId'];
            $updataType = $_POST['updataType'];
            $userData = $_POST['userData'];
            $data = array(

            );
            if($updataType == 'list'){
                M('user')-> where(array('userId' => $userData['userId'],'roleId' => $this::$studentRoleId))->setField($userData['data']);
            }
            /*if($updataType == 'one'){
                $userData = json_decode($_POST['userData'],true);
                M('user')-> where(array('userId' => $userData['userId']))->setField($userData['data']);
            }
            M('user')->save(array(
                'phone' => $_POST['phone'],
                'className' => $_POST['className'],
                'sex' => $_POST['sex'],
                'idCard' => $_POST['idCard'],
                'hklx' => $_POST['hklx'],
                'hkAddress' => $_POST['hkAddress'],
                'className' => $_POST['className'],
                'statu' => $_POST['statu'],
                'major' => $_POST['major'],
                'idCard' => $_POST['idCard'],
                'grade' => $_POST['grade'],
                'ifExtern' => $_POST['ifExtern'],
                'birth' => $_POST['birth'],
                'grade' => $_POST['grade'],
                'name' => $_POST['name'],
                'number' => $number,
                'prefix' => $prefix,
                'scId' => $scId,
                'roleId' => $roleId,
                'name' => $_POST['name'],
                'password' => $this->create_password($_POST['password'],self::$password_key,self::$password_key1),
                'account' => $prefix.$number,
                'statu' => 1,
                'createTime' => $createTime
            ));*/
        }
        if($type == 'updataTeacher'){
            $userData = $_POST['userData'];
            unset($userData['roleId']);
            unset($userData['account']);
            unset($userData['password']);
            if(M('user')-> where(array('id' => $userData['id']))->setField($userData) !== false){
                $this->returnJson(array('statu' => 1,'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0,'message' => 'fail'),true);
        }
        if($type == 'updataZg'){
            $userData = $_POST['userData'];
            unset($userData['roleId']);
            unset($userData['account']);
            unset($userData['password']);
            if(M('user')-> where(array('id' => $userData['id']))->setField($userData)){
                $this->returnJson(array('statu' => 1,'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0,'message' => 'fail'),true);
        }
    }
    private function exportUserXi($flieExtension,$targetFile,$roleNameEn,$prefix,$maxNumber,$createTime,$scId,$roleId){
        $this->pageList($this::$pageSize,M('user'),array('roleId' => $this::$teacherRoleId,'scId' => $scId),'id,roleId,name,phone,sex,teachingSubjects,jobNumber,politics',array('roleId' => $this::$teacherRoleId,'scId' => $scId));
    }
    private function  pageList($scId,$table,$roleId,$valueData = 0,$strLike ='',$sort = 0,$sortString =''){
        $i = 1;
        //获取当前页数
        $teacherRoleId = $roleId;
        if($valueData == 0 && $sort==0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and roleId = $teacherRoleId";
        }
        if($valueData!=0 && $sort!=0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and roleId = $teacherRoleId  ".$strLike.$sortString;
        }
        if($valueData!=0 && $sort==0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and roleId = $teacherRoleId   ".$strLike;
        }
        if($valueData==0 && $sort!=0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and roleId = $teacherRoleId  $sortString";
        }
        $allList = M('user')->query($allcount);
        $allList = $allList[0]['count'];
        $pagesize = $_GET['pageSize'];
        $maxpage = ceil($allList/$pagesize);
        $page = $_GET['page'];
        if($page <= 1){
            $page = 1;
        } else if($page>=$maxpage){
            $page = $maxpage;
        } else{
            $page = $_GET['page'];
        }
        if($maxpage==0){
            $maxpage =1;
        }
        $startpage = ($page-1)*$pagesize;
        if($valueData == 0 && $sort==0){
            $userSql = "SELECT * FROM $table WHERE scId=$scId and roleId = $teacherRoleId  LIMIT $startpage,$pagesize";
        }
        if($valueData!=0 && $sort!=0){
            $userSql = "SELECT * FROM $table WHERE scId=$scId and roleId = $teacherRoleId  $strLike $sortString LIMIT $startpage,$pagesize";
        }
        if($valueData!=0 && $sort==0){
            $userSql = "SELECT * FROM $table WHERE scId=$scId and roleId = $teacherRoleId  $strLike LIMIT $startpage,$pagesize";
        }
        if($valueData==0 && $sort!=0){
            $userSql = "SELECT * FROM $table WHERE scId=$scId and roleId = $teacherRoleId   $sortString LIMIT $startpage,$pagesize";
        }
        /*foreach($data as $key => $value){
            $data[$key]['maxpage'] = $maxpage;
            $data[$key]['page'] = $page;
        }*/
        $data['data'] =  M('user')->query($userSql);
        $data['maxpage'] = $maxpage;
        $data['count'] = (int)$allList;
        $data['page'] = $page;
        //$data['maxpage']['maxpage'] = $maxpage;
        // $data['page']['page'] = $page;
        return $data;
    }
    private function download($file_dir,$file_name){
        $file = fopen ( $file_dir.$file_name, "r" );
        Header ( "Content-type: application/octet-stream" );
        Header ( "Accept-Ranges: bytes" );
        Header ( "Content-Length: " . filesize ( $file_dir . $file_name ) );
        Header ( "Content-Disposition: attachment; filename=" . $file_name );
        echo fread ( $file, filesize ( $file_dir . $file_name ) );
        fclose ( $file );
    }
    private function pageListSql($scId,$table,$valueData = 0,$strLike ='',$sort = 0,$sortString =''){
        $grade = $_GET['grade'];
        $class = $_GET['class'];
        //echo $class;
        //$user = M('user')->where(array('grade' => $grade))
        $str = '';
        $len = count($class);
        $i = 1;
        foreach($class as $key => $value){
            $i++;
            if($i<=$len){
                $str = 'className='.$value.' or '.$str;
            }else{
                $str = $str.'className='.$value;
            }
        }
        //获取当前页数
        if($valueData == 0 && $sort==0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and grade=$grade and  ($str)";
        }
        if($valueData!=0 && $sort!=0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and grade=$grade and  ($str)".$strLike.$sortString;
        }
        if($valueData!=0 && $sort==0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and grade=$grade and  ($str)".$strLike;
        }
        if($valueData==0 && $sort!=0){
            $allcount = "SELECT count('id') as count FROM $table WHERE scId=$scId and grade=$grade and  ($str)  $sortString";
        }
        $allList = M('user')->query($allcount);
        $allList = $allList[0]['count'];
        $pagesize = $_GET['pageSize'];
        $maxpage = ceil($allList/$pagesize);
        $page = $_GET['page'];
        if($page <= 1){
            $page = 1;
        } else if($page>=$maxpage){
            $page = $maxpage;
        } else{
            $page = $_GET['page'];
        }
        if($maxpage==0){
            $maxpage =1;
        }
        $startpage = ($page-1)*$pagesize;
        if($valueData == 0 && $sort==0){
            $userSql = "SELECT * FROM $table WHERE scId=$scId and grade=$grade and  ($str) LIMIT $startpage,$pagesize";
        }
        if($valueData!=0 && $sort!=0){
            $userSql = "SELECT * FROM $table WHERE scId=$scId and grade=$grade and  ($str) $strLike $sortString LIMIT $startpage,$pagesize";
        }
        if($valueData!=0 && $sort==0){
            $userSql = "SELECT * FROM $table WHERE scId=$scId and grade=$grade and  ($str) $strLike LIMIT $startpage,$pagesize";
        }
        if($valueData==0 && $sort!=0){
            $userSql = "SELECT * FROM $table WHERE scId=$scId and grade=$grade and  ($str)   $sortString LIMIT $startpage,$pagesize";
        }
        /*foreach($data as $key => $value){
            $data[$key]['maxpage'] = $maxpage;
            $data[$key]['page'] = $page;
        }*/
        $data['tr'] = $this::getTr($table);
        $data['data'] =  M('')->query($userSql);
        $data['maxpage'] = $maxpage;
        $data['page'] = $page;
        //$data['maxpage']['maxpage'] = $maxpage;
        // $data['page']['page'] = $page;
        return $data;
    }
    public function getGrade(){
        $session = $this->get_session('loginCheck',false);
        $scId = $session['scId'];
        $userRoleId = $session['roleId'];
        $type = $_GET['type'];
        $userId = $session['userId'];
        if($type == 'getGradeList'){
            $getSession = $this->get_session('loginCheck',false);
            $qxModelName = $getSession['scId'].'school'.$getSession['roleId'];
            $userModelList = $this->redis_operation($qxModelName,0,0,3);
            $userModelList = json_decode($userModelList,true);
            foreach($userModelList as $key => $value){
                if($value['modelName'] == '所有学生资料查看'){
                    $data = M('')->query("SELECT name,gradeid FROM mks_grade where scId=$scId ORDER BY name");
                    $this->returnJson($data,true);
                }
                if($value['modelName'] == '部分学生资料查看'){
                    $grade= M('user')->field('grade')->where(array('id' => $userId ))->find();
                    $return = M('grade')->field('name,gradeid')->where(array('name' => $grade['grade'],'scId' => $scId))->find();
                    $this->returnJson(array('0' => $return),true);
                }
                if($userRoleId == $this::$adminRoleId){
                    $data = M('')->query("SELECT name,gradeid FROM mks_grade where scId=$scId ORDER BY name");
                    $this->returnJson($data,true);
                }
            }
        }
        if($type == 'getClass'){
            $grade = $_GET['gradeid'];
            $class = M('class')->field('classname,classid')->where(array('grade' => $grade ,'scId' => $scId))->select();
            $this->returnJson($class,true);
        }
        if($type == 'getSelectType'){
            $data  = array(
                '0' => array('name' => '学生基本信息','ListType' => 'jbXi'),
                '1' => array('name' => '学生学籍信息','ListType' => 'xjXi'),
                '2' => array('name' => '学生户籍信息','ListType' => 'hjXi'),
                '3' => array('name' => '学生家长信息','ListType' => 'jzXi'),
                '4' => array('name' => '学生学费信息','ListType' => 'xfXi'),
                '5' => array('name' => '学生其他信息','ListType' => 'qtXi'),
            );
            $this->returnJson($data,true);
        }
    }
    public function getTr($table){
        if($table == 'mks_student_info'){
            return $arrayTr = array(
                '0' => array(
                    'en' => 'name',
                    'zh' => '姓名'
                ),
                '1' => array(
                    'en' => 'sex',
                    'zh' => '性别'
                ), '2' => array(
                    'en' => 'birthday',
                    'zh' => '出生日期'
                ), '3' => array(
                    'en' => 'className',
                    'zh' => '班级'
                ),  '4' => array(
                    'en' => 'serialNumber',
                    'zh' => '班级座号'
                ), '5' => array(
                    'en' => 'height',
                    'zh' => '身高'
                ), '6' => array(
                    'en' => 'idCard',
                    'zh' => '身份证号'
                ), '7' => array(
                    'en' => 'country',
                    'zh' => '国籍'
                ), '8' => array(
                    'en' => 'nation',
                    'zh' => '民族'
                ), '9' => array(
                    'en' => 'leagueTime',
                    'zh' => '入团时间'
                ),
                '10' => array(
                    'en' => 'enrolTime',
                    'zh' => '入学时间'
                ),
                '11' => array(
                    'en' => 'enrolWay',
                    'zh' => '入学方式'
                ),
                '12' => array(
                    'en' => 'isResSchool',
                    'zh' => '就读方式'
                ),
                '13' => array(
                    'en' => 'phone',
                    'zh' => '手机号码'
                ),
                '14' => array(
                    'en' => 'nowHomePath',
                    'zh' => '现住地址'
                ),
                '15' => array(
                    'en' => 'nowHomePostcode',
                    'zh' => '现住地址邮编'
                ),
                '16' => array(
                    'en' => 'political',
                    'zh' => '政治面貌'
                ),
                '17' => array(
                    'en' => 'dorNumber',
                    'zh' => '宿舍号'
                ),
                '18' => array(
                    'en' => 'studentCard',
                    'zh' => '学生卡号'
                )
            );
        }
        if($table == 'mks_school_rollinfo'){ //学籍信息
            return $arrayTr = array(
                '0' => array(
                    'en' => 'className',
                    'zh' => '班级'
                ),
                '1' => array(
                    'en' => 'name',
                    'zh' => '姓名'
                ),
                '2' => array(
                    'en' => 'isTempStudy',
                    'zh' => '是否借读'
                ), '3' => array(
                    'en' => 'isLeave',
                    'zh' => '是否休学'
                ), '4' => array(
                    'en' => 'isSubor',
                    'zh' => '是否靠挂'
                ),  '5' => array(
                    'en' => 'stream',
                    'zh' => '科类'
                ), '6' => array(
                    'en' => 'major',
                    'zh' => '专业'
                ), '7' => array(
                    'en' => 'studentCode',
                    'zh' => '国家学号'
                ), '8' => array(
                    'en' => 'admCategory',
                    'zh' => '录取类别'
                ), '9' => array(
                    'en' => 'eleSchool',
                    'zh' => '小学学校'
                ), '10' => array(
                    'en' => 'secSchool',
                    'zh' => '中学学校'
                ),
                '11' => array(
                    'en' => 'midExam',
                    'zh' => '中考分数'
                ),  '12' => array(
                    'en' => 'isResSchool',
                    'zh' => '是否在校'
                ),
            );
        }
        if($table == 'mks_cen_reg_info'){//户籍返回
            return $arrayTr = array(
                '0' => array(
                    'en' => 'name',
                    'zh' => '姓名'
                ),
                '1' => array(
                    'en' => 'className',
                    'zh' => '班级'
                ),  '2' => array(
                    'en' => 'perAddress',
                    'zh' => '户口所在地'
                ), '3' => array(
                    'en' => 'cenRegType',
                    'zh' => '户籍类型'
                ), '4' => array(
                    'en' => 'cenRegNature',
                    'zh' => '户口性质'
                ), '5' => array(
                    'en' => 'perAddressCode',
                    'zh' => '户口所在地代码'
                ), '6' => array(
                    'en' => 'originCode',
                    'zh' => '生源地代码'
                )
            );
        }
        if($table == 'mks_parents_info'){//家长信息
            return $arrayTr = array(
                '0' => array(
                    'en' => 'name',
                    'zh' => '姓名'
                ),
                '1' => array(
                    'en' => 'jzName1',
                    'zh' => '家长1姓名'
                ),  '2' => array(
                    'en' => 'elation1',
                    'zh' => '家长1关系'
                ), '3' => array(
                    'en' => 'jzPhone1',
                    'zh' => '家长1电话'
                ), '4' => array(
                    'en' => 'jzWorkUnit1',
                    'zh' => '家长1工作单位'
                ), '5' => array(
                    'en' => 'jzPost1',
                    'zh' => '家长1职位'
                ), '6' => array(
                    'en' => 'isGuardian1',
                    'zh' => '家长1是否是监护人'
                ), '7' => array(
                    'en' => 'jzCardType1',
                    'zh' => '家长1身份证类型'
                ),
                '8' => array(
                    'en' => 'jzIdCard1',
                    'zh' => '家长1身份证号'
                ),
                '9' => array(
                    'en' => 'jzNation1',
                    'zh' => '家长1民族'
                ),
                '10' => array(
                    'en' => 'jzNation1',
                    'zh' => '家长1户口所在地'
                ),
                '11' => array(
                    'en' => 'jzName2',
                    'zh' => '家长2姓名'
                ),  '12' => array(
                    'en' => 'elation2',
                    'zh' => '家长2关系'
                ), '13' => array(
                    'en' => 'jzPhone2',
                    'zh' => '家长2电话'
                ), '14' => array(
                    'en' => 'jzWorkUnit2',
                    'zh' => '家长2工作单位'
                ), '15' => array(
                    'en' => 'jzPost2',
                    'zh' => '家长2职位'
                ), '16' => array(
                    'en' => 'isGuardian2',
                    'zh' => '家长2是否是监护人'
                ), '17' => array(
                    'en' => 'jzCardType2',
                    'zh' => '家长2身份证类型'
                ),
                '18' => array(
                    'en' => 'jzIdCard2',
                    'zh' => '家长2身份证号'
                ),
                '19' => array(
                    'en' => 'jzNation2',
                    'zh' => '家长2民族'
                ),
                '20' => array(
                    'en' => 'jzNation2',
                    'zh' => '家长2户口所在地'
                ),
            );
        }
        if($table == 'mks_tuition_info'){//学费信息
            return $arrayTr = array(
                '0' => array(
                    'en' => 'name',
                    'zh' => '姓名'
                ),
                '1' => array(
                    'en' => 'className',
                    'zh' => '班级'
                ),  '2' => array(
                    'en' => 'openBank',
                    'zh' => '开户银行'
                ), '3' => array(
                    'en' => 'bankAccount',
                    'zh' => '开户银行账号'
                ), '4' => array(
                    'en' => 'accountHolder',
                    'zh' => '银行卡持有人'
                )
            );
        }
        if($table == 'mks_other_info') {//学生其他信息
            return $arrayTr = array(
                '0' => array(
                    'en' => 'className',
                    'zh' => '班级'
                ),
                '1' => array(
                    'en' => 'name',
                    'zh' => '姓名'
                ),
                '2' => array(
                    'en' => 'isSingleton',
                    'zh' => '是否是独生子女'
                ), '3' => array(
                    'en' => 'isPreschool',
                    'zh' => '是否受过学前教育'
                ), '4' => array(
                    'en' => 'isBehChild',
                    'zh' => '是否是留守儿童'
                ), '5' => array(
                    'en' => 'isTraChild',
                    'zh' => '是否进城务工人员随迁子女'
                ), '6' => array(
                    'en' => 'isOrphan',
                    'zh' => '是否孤儿'
                ), '7' => array(
                    'en' => 'isMartyrChild',
                    'zh' => '是否烈士或优抚子女'
                ), '8' => array(
                    'en' => 'disPerType',
                    'zh' => '残疾人类型'
                ), '9' => array(
                    'en' => 'trafficMode',
                    'zh' => '上下学交通方式'
                ), '10' => array(
                    'en' => 'distance',
                    'zh' => '上下学交通距离'
                ),
                '11' => array(
                    'en' => 'isTakeSchoolBus',
                    'zh' => '是否需要乘坐校车'
                ), '12' => array(
                    'en' => 'workerNumber',
                    'zh' => '社工证号'
                ),
                '13' => array(
                    'en' => 'healthStatus',
                    'zh' => '健康状况'
                ), '14' => array(
                    'en' => 'mailAddress',
                    'zh' => '通信地址'
                ),
                '15' => array(
                    'en' => 'isSubsidy',
                    'zh' => '是否享受一补'
                ), '16' => array(
                    'en' => 'isApplyFund',
                    'zh' => '是否需要资助'
                ),
                '17' => array(
                    'en' => 'bloodType',
                    'zh' => '是血型'
                ), '18' => array(
                    'en' => 'studentSource',
                    'zh' => '学生来源'
                ),
                '19' => array(
                    'en' => 'Email',
                    'zh' => '电子邮箱'
                ), '20' => array(
                    'en' => 'businessPage',
                    'zh' => '主页地址'
                ),
                '21' => array(
                    'en' => 'isGovBuyDegree',
                    'zh' => '是否政府购买学位'
                )
            );
        }
        if($table == 'zg'){//户籍返回
            return $arrayTr = array(
                '0' => array(
                    'en' => 'name',
                    'zh' => '姓名'
                ),
                '1' => array(
                    'en' => 'sex',
                    'zh' => '性别'
                ),  '2' => array(
                    'en' => 'post',
                    'zh' => '岗位'
                ), '3' => array(
                    'en' => 'politics',
                    'zh' => '政治面貌'
                ), '4' => array(
                    'en' => 'phone',
                    'zh' => '手机号码'
                )
            );
        }
        if($table == 'js'){//户籍返回
            return $arrayTr = array(
                '0' => array(
                    'en' => 'name',
                    'zh' => '姓名'
                ),
                '1' => array(
                    'en' => 'sex',
                    'zh' => '性别'
                ),  '2' => array(
                    'en' => 'teachingSubjects',
                    'zh' => '任教科目'
                ), '3' => array(
                    'en' => 'politics',
                    'zh' => '政治面貌'
                ), '4' => array(
                    'en' => 'phone',
                    'zh' => '手机号码'
                )
            );
        }
    }
}