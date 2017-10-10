<?php
namespace Home\Controller;
use Think\Controller;
use Think\Db;
ini_set("session.cookie_httponly", 1);
class Base extends Controller
{
    protected static $secret_key = '0c39b20bc693807f7180aa05f2ea1bf2';
    protected static $public_key = '696916a74513dfdb4fdbad90c6f13768';
    protected static $password_key = '1f3463992c3f7389e658e7762fcde904';
    protected static $password_key1 = 'ffaju3af2lf0giw8qacl*faf32!fdasf8*ff+58-';
    protected static $adminRoleId = 22;/*设置管理员Id*/
    protected static $uploadUrl = '/Public/upload/';
    protected static $jZroleId = 13;
    protected  static $InitialPassword = 123456;
    protected  static $teacherRoleId = 14;
    protected  static $studentRoleId = 15;
    protected  static $pageSize = 10;
    protected static $downUrl = 'http://localhost/school';
    //protected  static $jzRoleId = 33;
    /*登录后权限的验证*/
    function __construct(){
        parent::__construct();
        $token_check = 0;
        $controller = CONTROLLER_NAME;
        $function = ACTION_NAME;
        $type = $_GET['type'];
        if(ACTION_NAME == 'doLogin'){
            return 1;
        }
        if($getSession = $this->get_session('loginCheck',false)){
            $qxModelName = $getSession['scId'].'school'.$getSession['roleId'];
            $userModelList = json_decode($this->redis_operation($qxModelName,0,0,3),true);
            /*$modelList = json_decode($this->redis_operation('school_model_list',0,0,3),true);
            $modelId = 0;
            foreach($modelList as $key => $value){
                if($value['controller'] == $controller && $value['function'] == $function && $value['type'] == $type){
                    $modelId = $value['modelId'];
                }
            }*/
            foreach($userModelList as $key => $value){
                if($value['controller'] == $controller && $value['function'] == $function && $value['type'] == $type){
                    return true;
                }
            }
            if($getSession['roleId'] == $this::$adminRoleId){
                return true;
            }
            //$this->returnJson(array('statu' => 0,'message' => 'No permissions'),true);
            //  exit(0);
        }
        //$this->returnJson(array('statu' => 0,'message' => 'need validation'),true);
        //exit(0);
        //return false;
    }
    /*初始密码*/
    public function InitialPassword(){
        $password = '';
        for($i = 0 ; $i<6 ; $i++){
            $password = $password.rand(0,9);
        }
        return $password;
    }
    /*登录验证*/
    public function create_token($account,$password){
        $check = self::check_password($account,$password,self::$password_key,self::$password_key1);
        if($check){
            $rel_token = self::get_token($account,$password,self::$secret_key,self::$public_key);
            self::redis_operation($rel_token,1,900,2);
            return $rel_token;
        }
        return false;
    }
    public function check_token($token){
        if(1){
            return true;
        }
        return false;
    }
    /*操作redis*/
    public function redis_operation($name,$value,$time,$type){
        $redis = $this->get_redis();
        if($type == 1){
            $redis->set($name,$value);
            $redis->expire($name,$time);
            return true;
        }
        if($type == 2){
            $redis->set($name,$value);
            return true;
        }
        if($type == 3){
            if($data = $redis->get($name)){
                return $data;
            }
        }
        $redis->close();
    }
    /*连接redis*/
    private function get_redis(){
        $redis = new \Redis();
        $redis->connect('171.221.202.190', 6379);
        $redis->auth('mysql2012');
        return $redis;
    }
    /**/
    private function get_token($account,$password,$secret,$public){
        $token = md5($account.time());
        $token1 = md5($token.$password.$public);
        return md5($token1.$secret.uniqid());
    }
    /*验证登录*/
    private function check_password($account,$password){
        $mysql_password = M('user')->where(array('account' => $account,'state' => 1))->find();
        $password = self::create_password($password,self::$password_key,self::$password_key1);
        if($password == $mysql_password['password']){
            $scId = $mysql_password['scId'];
            /*添加角色，权限模块*/
            $modelName = $scId.'school'.$mysql_password['roleId'];
            $model = json_decode($this->redis_operation($modelName,0,0,3),true);
            /*找到对应的学校*/
            $school = M('school')->where(array('scId' => $scId))->find();
            $school_rel = array(
                'scName' => $school['scName'],
                'scId' => $school['scId'],
                'mail' => $school['mail'],
                'telephone' => $school['telephone'],
                'province' => $school['province'],
                'city' => $school['city'],
                'ministries' => $school['ministries'],
                'type' => $school['type'],
                'logo' => $school['logo'],
                'lastRecordTime' => $school['lastRecordTime'],
                'createTime' => $school['createTime'],
                'prefix' => $school['prefix'],
            );
            $user = array(
                'userId' => $mysql_password['id'],
                'account' => $mysql_password['account'],
                'roleId' => $mysql_password['roleId'],
                'name' => $mysql_password['name'],
                'scId' => $mysql_password['scId'],
                'className' => $mysql_password['className'],
                'sex' => $mysql_password['sex'],
                'idCard' => $mysql_password['idCard'],
                'major' =>$mysql_password['major'],
                'logo' => $mysql_password['logo'],
                'teachingSubjects' => $mysql_password['teachingSubjects'],
                'post' => $mysql_password['post'],
                'politics' => $mysql_password['politics'],
                'hkAddress' => $mysql_password['hkAddress'],
                'hklx' => $mysql_password['hklx'],
                'grade' => $mysql_password['grade'],
                'birth' => $mysql_password['birth'],
                'department' => $mysql_password['department']
            );
            //self::set_session('checkFrom','true',1800);
            self::set_session('loginCheck',array('roleId' => $mysql_password['roleId'],'name' =>$mysql_password['name'] ,'scId' => $scId,'userId' => $mysql_password['id']),3600,false);
            return array('user' => $user,'school' => $school_rel,'statu' => 1,'message' => 'login success','roleId' =>$mysql_password['roleId'],'scId' => $scId );
        }else{
            $this->returnJson(array('statu' => 0,'message' => 'login fail'),true);
            return false;
        }
    }
    protected function checkLogin($account,$password){
        return self::check_password($account,$password);
    }
    /*加密密码*/
    protected function create_password($password,$password_key,$password_key1){
        $passwordone = md5($password);
        $passwordtow = md5($passwordone.$password_key);
        return md5($passwordtow.$password_key1);
    }
    /* 验证session 设置session*/
    public function set_session($name,$data,$expire = 5000,$type){
        $session_data = array();
        $session_data['data'] = $data;
        if($type){
            $session_data['expire'] = time()+$expire;
        }
        $_SESSION[$name] = $session_data;
    }
    /*得到session*/
    public function get_session($name,$type){
        if(isset($_SESSION[$name])){
            if($type){
                if($_SESSION[$name]['expire']>time()){
                    return $_SESSION[$name]['data'];
                }else{
                    self::clear_session($name);
                }
            }else{
                return $_SESSION[$name]['data'];
            }
        }
        return false;
    }
    public  function clear_session($name){
        unset($_SESSION[$name]);
        return true;
    }
    /*检测错误*/
    private function check_data($time,$sessionname,$count){
        /*if(self::get_session($sessionname)){
            if(self::get_session($sessionname)>=$count){
                return false;
            }
            $_SESSION[$sessionname]['data']++;
            return true;
        }
        else{
            self::set_session($sessionname,1,$time);
            return true;
        }*/
    }
    /*验证自身的session，验证来源*/
    private function check_from(){
        if($_SESSION['from_app']){
            return true;
        }
        else{
            return false;
        }
    }
    private function getValue(){

    }
    /* 返回值，安卓,web*/
    public function returnJson($data,$true){
        if($true){
            ob_end_clean();
            $this->ajaxReturn($data);
            exit(0);
        }else{

        }
    }
    /*protected function urlencode_base($data){
        $returnData = array();
        foreach($data as $key => $value){
            foreach($value as $key1 => $value1){
                $returnData[$key][$key1] = urldecode($value1);
            }
        }
        return $returnData;
    }*/
    //上传文件处理
    protected function upload($fileTarName,$fileTypes){
        define('MAX_SIZE_FILE_UPLOAD', '10000000' );
        header('content-type:text/html;charset=utf-8');
        //$verifyToken = md5('unique_salt' . $_POST['timestamp']);
        $targetPath = dirname(dirname(dirname(dirname(__FILE__))));
        $targetPath = $targetPath.'\Public\upload\\'.'image'.'\\';
        if (!empty($_FILES)/* && $_POST['token'] == $verifyToken*/){
            $return = $this->get_session('loginCheck',false);
            $userId = $return['userId'];
            $tempFile = $_FILES['userFile']['tmp_name'];
            $targetPath = dirname(dirname(dirname(dirname(__FILE__))));
            $targetPath = $targetPath.'\Public\upload\\'.$fileTarName.'\\';
            if(!file_exists($targetPath)){
                mkdir($targetPath);
            }
            $fileNameRetrun = md5(uniqid().'df'.$userId);
            //$targetFile = $targetPath.$_FILES['userFile']['name'];
            //Validate the file type
            //$fileTypes = array('xlsx','doc','xls'); // File extensions
            $fileParts = pathinfo($_FILES['userFile']['name']);
            $flieExtension = $fileParts['extension'];
            $targetFile = $targetPath.$fileNameRetrun.'.'.$flieExtension;
            if (in_array($flieExtension,$fileTypes)){
                //print_r($_FILES);
                if(move_uploaded_file($tempFile,$targetFile)){
                    //echo $targetFile;
                    return "http://localhost/school/Public/upload/$fileTarName/$fileNameRetrun.$flieExtension";
                }
                return false;
            }
            return false;
        }
        return false;
    }
    public function export($data,$tr){
        $array = array();
        $i = 1;
        foreach($tr as $key => $value){
            $array[0][$value['en']] = $value['zh'];
        }
        foreach($data as $key => $value){
            foreach($tr as $key1 => $value1){
                $array[$i][$value1['en']] = $value[$value1['en']];
            }
            $i++;
        }
        $data = $array;
        vendor('PHPExcel.PHPExcel');
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("jianglong")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        $objPHPExcel->setActiveSheetIndex(0);
        $getobj1 = $objPHPExcel->getActiveSheet();
        $getobj1->getDefaultRowDimension()->setRowHeight(20);
        $j = 1;
        $i=1;
        foreach($data[0] as $key =>$value){
            $getobj1->getColumnDimension(chr(64 + $i))->setWidth(12);//设置宽度
            $i++;
        }
        foreach($data as $key => $value){
            $i = 1;
            foreach($value as $key1 => $value1){
                $getobj1->setCellValue(chr(64 + $i).$j,$value1);
                $i++;
            }
            $j++;
        }
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $excelname = date('Y-m-d');
        $excelname = "export.xls";
        ob_end_clean();
        // Redirect output to a client’s web browser (Excel5)
        //header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$excelname.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

    }
}



