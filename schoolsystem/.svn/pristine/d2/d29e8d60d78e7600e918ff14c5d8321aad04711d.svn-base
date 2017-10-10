<?php
/**
 * Created by PhpStorm.
 * User: xiaolong
 * Date: 2017/6/22
 * Time: 14:15
 * 教务管理
 */
namespace Home\Controller;
//use Think\Controller;
//use Vendor\PHPExcel\PHPExcel;
class AssetsController extends Base
{
    public function assetsType(){//资产分类
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'getAssetsType'){
            $data = M('assets_type')->where(array('scId' => $scId))->select();
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
        }
        if($type == 'delete'){
            $data = M('assets_type')->where(array('scId' => $scId))->select();
            $this->deleteTree($_POST['assetsTypeId'],$data,$scId);
            M('assets_type')->where(array('scId' => $scId,'assetsTypeId' =>$_POST['assetsTypeId']))->delete();
            $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
        }
        if($type == 'create'){
            $assetsTypeParentId = $_POST['assetsTypeId'];
            $leavel = $_POST['leavel'];
            $assetsTypeName = $_POST['assetsTypeName'];
            if(M('assets_type')->add(array(
                'createTime' => date('Y-m-d H:i:s'),
                'assetsTypeName' => $assetsTypeName,
                'scId' => $scId,
                'assetsTypeParentId' => $assetsTypeParentId,
                'leavel' => $leavel++
            ))){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'success'),true);
        }
        if($type == 'updata'){
            $assetsTypeId = $_POST['assetsTypeId'];
            $assetsTypeName = $_POST['assetsTypeName'];
            if(M('assets_type')->where(array('scId' => $scId,'assetsTypeId' => $assetsTypeId))->setField(array(
                'assetsTypeName' => $assetsTypeName,
            ))){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'userType'){
            $data = M('assets_type')->where(array('scId' => $scId))->select();
            $assetsTypeId = $_POST['assetsTypeId'];
            $array = M('assets_type')->where(array('scId' => $scId,'assetsTypeId' => $assetsTypeId))->find();
            $userType = 0;
            if($array['ifUser'] == 0){
                $userType = 1;
            }
            $this->userTree($assetsTypeId,$data,$scId,$userType);
            if($userType){
                M('assets_type')->where(array('scId' => $scId,'assetsTypeId' =>$assetsTypeId))->setField(array('ifUser' =>1));
            }else{
                M('assets_type')->where(array('scId' => $scId,'assetsTypeId' =>$assetsTypeId))->setField(array('ifUser' =>0));
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
        }
    }
    private function userTree($assetsTypeId,$data,$scId,$userType){
        foreach($data as $key => $value){
            if($assetsTypeId == $value['assetsTypeParentId']){
                if($userType){
                    M('assets_type')->where(array('scId' => $scId,'assetsTypeId' => $value['assetsTypeId']))->setField(array('ifUser' =>1));
                }else{
                    M('assets_type')->where(array('scId' => $scId,'assetsTypeId' => $value['assetsTypeId']))->setField(array('ifUser' =>0));
                }
                $this->userTree($value['assetsTypeId'],$data,$scId,$userType);
            }
        }
        return true;
    }
    private function deleteTree($assetsTypeId,$data,$scId){
        foreach($data as $key => $value){
            if($assetsTypeId == $value['assetsTypeParentId']){
                M('assets_type')->where(array('scId' => $scId,'assetsTypeId' => $value['assetsTypeId']))->delete();
                $this->deleteTree($value['assetsTypeId'],$data,$scId);
            }
        }
        return true;
    }
    public function approverSet(){//审批设置
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'getAssetsType'){
            $data = M('assets_type')->where(array('scId' => $scId,'ifUser' =>1))->select();
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
        }
        if($type == 'getApproverUser'){
            $role = M('role')->where(array('scId' => array(array('eq',0),array('eq',$scId),'or')))->select();
            $user = M('user')->field('id,name,roleId')->where(array(''))->select();
            $studentRole = $this::$studentRoleId;
            $jzRole = $this::$jZroleId;
            $adminRole = $this::$adminRoleId;
            $user = M('')->query("select id,name,roleId from mks_user where scId= $scId AND roleId!=$studentRole AND roleId!=$jzRole AND roleId!=$adminRole");
            $roleUser = array();
            $roleRe = array();
            foreach($role as $key => $value){
                $roleRe[$value['roleId']] = $value['roleName'];
            }
            foreach($user as $key => $value){
                $roleUser[$value['roleId']]['roleName'] = $roleRe[$value['roleId']];
                $roleUser[$value['roleId']]['data'][] = $value;
            }
            $return = array();
            foreach($roleUser as $key => $value){
                $return[] = $value;
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $return),true);
        }
        if($type == 'createApproverUser'){
            $id  = $_POST['id'];
            $assetsTypeId = $_POST['assetsTypeId'];
            $ifApprov = $_POST['ifApprov'];
            if(M('assets_type')->where(array('scId' => $scId,'assetsTypeId' =>$assetsTypeId))->setField(array('ifApprov' =>$ifApprov,'approver' => $id))){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'getApproverUserList'){
            $assetsTypeId = $_GET['assetsTypeId'];
            $type = M('assets_type')->where(array('scId' => $scId,'assetsTypeId' =>$assetsTypeId))->find();
            $userIdList = $type['approver'];
            $user = M('')->query("select id,name from mks_user WHERE  scId= $scId AND id IN($userIdList)");
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $user),true);
        }
    }
    public function batchImport(){//批量导入
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'import'){
            define('MAX_SIZE_FILE_UPLOAD', '10000000' );
            header('content-type:text/html;charset=utf-8');
            if (!empty($_FILES)/* && $_POST['token'] == $verifyToken*/) {
                $tempFile = $_FILES['userFile']['tmp_name'];
                $targetPath = dirname(dirname(dirname(dirname(__FILE__))));
                $targetPath = $targetPath . '\Public\upload\\' .'assets'. '\\';
                if (!file_exists($targetPath)) {
                    mkdir($targetPath);
                }
                $fileTypes = array('xlsx', 'doc', 'xls'); // File extensions
                $fileParts = pathinfo($_FILES['userFile']['name']);
                $flieExtension = $fileParts['extension'];
                $targetFile = $targetPath . md5(uniqid('gsfdg')) . '.' . $flieExtension;
                if (in_array($flieExtension, $fileTypes)) {
                    if (move_uploaded_file($tempFile, $targetFile)) {
                        vendor('PHPExcel.PHPExcel');
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
                        $b = 0;
                        $max = M('assets_list')->where(array('scId' => $scId))->max('assetsId');
                        for ($j=1;$j<=$highestRow;$j++){
                            $i = 0;
                            for($k='A';$k<=$highestColumn;$k++){//从A列读取数据
                                //实测在excel中，如果某单元格的值包含了||||||导入的数据会为空
                                $i++;
                                if($k == 'A'){
                                    $strs[$b]['assetsName'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                }
                                if($k == 'B'){
                                    $strs[$b]['assetsTypeId'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                }
                                if($k == 'C'){
                                    $strs[$b]['spec'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                }
                                if($k == 'D'){
                                    $strs[$b]['brandModel'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                }
                                if($k == 'E'){
                                    $strs[$b]['supplier'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                }
                                if($k == 'F'){
                                    $strs[$b]['unit'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                }
                                if($k == 'G'){
                                    $strs[$b]['onePrice'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                }
                                if($k == 'H'){
                                    $strs[$b]['num'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                }
                                if($k == 'I'){
                                    $strs[$b]['storageLocation'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                }
                                if($k == 'J'){
                                    $strs[$b]['remarks'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                }if($k == 'K'){
                                    $strs[$b]['approver'] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                                }if($k == 'L'){
                                    $strs[$b]['inStorageTime'] = gmdate("Y-m-d H:i:s",\PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue()));
                                }
                            }
                            $strs[$b]['createTime'] = date('Y-m-d H:i:s');
                            $strs[$b]['scId'] = $scId;
                            $num = 10000;
                            $max++;
                            $num = $num+$max;
                            $strs[$b]['assetsNumber'] = date('Y').date('m').date('d').$num;
                            $b++;
                        }
                        unset($strs[0]);
                        foreach($strs as $key => $value){
                            M('assets_list')->add($value);
                        }
                        $this->returnJson(array('message' => 'success','statu' => 1),true);
                    }
                    $this->returnJson(array('message' => 'upload fail','statu' => 0),true);
                }
                $this->returnJson(array('message' => '上传格式不对','statu' => 0),true);
            }
            $this->returnJson(array('message' => 'have on fail','statu' => 0),true);
        }
        if($type == 'downloadModel'){
            $url = $this::$downUrl;
            header("Location: $url/Public/upload/downloadexcel/assets.xlsx");
        }
        if($type == 'export'){
            $data = M('assets_list')->where(array('scId' => $scId))->select();
            $tr = array(
                '0' => array(
                    'en' => 'assetsName',
                    'zh' => '资产名称'
                ),
                '1' => array(
                    'en' => 'assetsTypeId',
                    'zh' => '分类代码'
                ),  '2' => array(
                    'en' => 'spec',
                    'zh' => '规格'
                ), '3' => array(
                    'en' => 'brandModel',
                    'zh' => '品牌型号'
                ), '4' => array(
                    'en' => 'supplier',
                    'zh' => '供应商'
                ), '5' => array(
                    'en' => 'unit',
                    'zh' => '单位'
                ), '6' => array(
                    'en' => 'onePrice',
                    'zh' => '单价'
                ), '7' => array(
                    'en' => 'num',
                    'zh' => '数量'
                ),
                '8' => array(
                    'en' => 'storageLocation',
                    'zh' => '存放地址'
                ),
                '9' => array(
                    'en' => 'approver',
                    'zh' => '责任人'
                ),
                '10' => array(
                    'en' => 'userAddress',
                    'zh' => '使用地址'
                ),
                '11' => array(
                    'en' => 'assetsNumber',
                    'zh' => '资产编号'
                ),

            );
            $this::export($data,$tr);
        }
    }
    public function assetStoreroom(){//资产入库
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'create'){
            $max = M('assets_list')->max('assetsId');
            $max = $max+2;
            $str = 10000+$max;
            $data = array(
                'assetsName' => $_POST['assetsName'],
                'assetsTypeId' => $_POST['assetsTypeId'],
                'supplier' => $_POST['supplier'],
                'num' => $_POST['num'],
                'unit' => $_POST['unit'],
                'brandModel' => $_POST['brandModel'],
                'spec' => $_POST['spec'],
                'onePrice' => $_POST['onePrice'],
                'createTime' =>date('Y-m-d H:i:s'),
                'storageLocation' => $_POST['storageLocation'],
                'remarks' => $_POST['remarks'],
                'scId' => $scId,
                'inStorageTime' => $_POST['inStorageTime'],
                'assetsNumber' => date('Y').date('m').date('d').$str,
            );
            if(M('assets_list')->add($data)){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'getAssetsType'){
            $data = M('assets_type')->where(array('scId' => $scId,'ifUser' =>1))->select();
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
        }
        if($type == 'export'){
            $data = M('assets_list')->where(array('scId' => $scId))->select();
            $type = M('assets_type')->where(array('scId' => $scId))->select();
            $typeRe = array();
            foreach($type as $key => $value){
                $typeRe[$value['assetsTypeId']] = $value['assetsTypeName'];
            }
            foreach($data as $key => $value){
                $data[$key]['assetsTypeName'] = $typeRe[$value['assetsTypeId']];
            }
            $tr = array(
                '0' => array(
                    'en' => 'assetsName',
                    'zh' => '资产名称'
                ),
                '1' => array(
                    'en' => 'assetsNumber',
                    'zh' => '资产编号'
                ),
                '2' => array(
                    'en' => 'assetsTypeName',
                    'zh' => '资产分类'
                ),
                '3' => array(
                    'en' => 'assetsTypeId',
                    'zh' => '分类代码'
                ),
                '4' => array(
                    'en' => 'inStorageTime',
                    'zh' => '入库日期'
                ),
                '5' => array(
                    'en' => 'createTime',
                    'zh' => '创建时间'
                ),
                '6' => array(
                    'en' => 'supplier',
                    'zh' => '供应商'
                ),
                '7' => array(
                    'en' => 'spec',
                    'zh' => '规格'
                ),
                '8' => array(
                    'en' => 'unit',
                    'zh' => '单位'
                ),
                '9' => array(
                    'en' => 'brandModel',
                    'zh' => '品牌型号'
                ),
                '10' => array(
                    'en' => 'onePrice',
                    'zh' => '单价'
                ),
                '11' => array(
                    'en' => 'num',
                    'zh' => '数量'
                ),
                '12' => array(
                    'en' => 'storageLocation',
                    'zh' => '存放地址'
                ),
                '14' => array(
                    'en' => 'remarks',
                    'zh' => '备注'
                ),
            );
            $this->export($data,$tr);
        }
        if($type == 'getAssetsList'){
            $data = M('assets_list')->where(array('scId' => $scId,'state' =>1))->select();
            $type = M('assets_type')->where(array('scId' => $scId))->select();
            $typeRe = array();
            foreach($type as $key => $value){
                $typeRe[$value['assetsTypeId']] = $value['assetsTypeName'];
            }
            foreach($data as $key => $value){
                $data[$key]['assetsTypeName'] = $typeRe[$value['assetsTypeId']];
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
        }
        if($type == 'delete'){
            $assetsId = $_POST['assetsId'];
            $i = 0;
            foreach($assetsId as $key =>$value){
                if(M('assets_list')->where(array('scId' => $scId,'assetsId' => $value))->delete()){
                    $i++;
                }
            }
            if($i == count($assetsId)){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'updata'){
            $data = $_POST['data'];
            $assetsId = $data['assetsId'];
            unset($data['assetsId']);
            unset($data['assetsTypeName']);
            if($data){
                if(M('assets_list')->where(array('scId' => $scId,'assetsId' =>$assetsId))->setField($data) === false){
                    $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
                }
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
    }
    private function getApper($assetsTypeId,$data,$scId){
        global $arr;
            foreach($data as $key => $value){
                if($assetsTypeId == $value['assetsTypeId']){
                    if($value['approver']){
                        $arr[] = $value;
                    }
                    $this->getApper($value['assetsTypeParentId'],$data,$scId);
                }
            }
        return $arr;
    }
    public function assetBrrowAndRetrun(){//资产借还
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        if($type == 'getAssetsType'){
            $data = M('assets_type')->where(array('scId' => $scId,'ifUser' =>1))->select();
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
        }
        if($type == 'getList'){
            $assetsTypeId = $_GET['assetsTypeId'];
            $data = M('assets_list')->where(array('scId' => $scId,'outStatu' =>0,'state' => 1))->select();
            $type = M('assets_type')->where(array('scId' => $scId))->select();
            $typeRe = array();
            foreach($type as $key => $value){
                $typeRe[$value['assetsTypeId']] = $value;
            }
            $typeReturn = $this->getAll($assetsTypeId,$type,$scId);
            $count = count($typeReturn);
            if(count($typeReturn)>0){
                $typeReturn[$count] = $typeRe[$assetsTypeId];
            }else{
                $typeReturn[$assetsTypeId] = $typeRe[$assetsTypeId];
            }
            $dateRe = array();
            foreach($data as $key => $value){
                if(isset($typeReturn[$value['assetsTypeId']])){
                    $value['assetsTypeName'] =  $typeRe[$value['assetsTypeId']]['assetsTypeName'];
                    $dateRe[] = $value;
                }else{

                }
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $dateRe),true);
        }
        if($type == 'addExport'){
            $assetsTypeId = $_GET['assetsTypeId'];
            $data = M('assets_list')->where(array('scId' => $scId,'outStatu' =>0,'state' => 1))->select();
            $type = M('assets_type')->where(array('scId' => $scId))->select();
            $typeRe = array();
            foreach($type as $key => $value){
                $typeRe[$value['assetsTypeId']] = $value;
            }
            $typeReturn = $this->getAll($assetsTypeId,$type,$scId);
            $count = count($typeReturn);
            if(count($typeReturn)>0){
                $typeReturn[$count] = $typeRe[$assetsTypeId];
            }else{
                $typeReturn[$assetsTypeId] = $typeRe[$assetsTypeId];
            }
            $dateRe = array();
            foreach($data as $key => $value){
                if(isset($typeReturn[$value['assetsTypeId']])){
                    if($value['ifRecive']){
                        $value['ifRecive'] = '已领用';
                    }else{
                        $value['ifRecive'] = '未领用';
                    }
                    $value['assetsTypeName'] =  $typeRe[$value['assetsTypeId']]['assetsTypeName'];
                    $dateRe[] = $value;
                }else{

                }
            }
            $tr = array(
                '0' => array(
                    'en' => 'assetsName',
                    'zh' => '资产名称'
                ),
                '1' => array(
                    'en' => 'assetsNumber',
                    'zh' => '资产编号'
                ),
                '2' => array(
                    'en' => 'gbCode',
                    'zh' => '国际代码'
                ),
                '3' => array(
                    'en' => 'onePrice',
                    'zh' => '单价'
                ),
                '4' => array(
                    'en' => 'storageLocation',
                    'zh' => '存放地址'
                ),
                '5' => array(
                    'en' => 'spec',
                    'zh' => '规格'
                ),
                '6' => array(
                    'en' => 'brandModel',
                    'zh' => '品牌型号'
                ),
                '7' => array(
                    'en' => 'supplier',
                    'zh' => '供应商'
                ),
                '8' => array(
                    'en' => 'unit',
                    'zh' => '单位'
                ),
                '9' => array(
                    'en' => 'remarks',
                    'zh' => '备注'
                ),
                '10' => array(
                    'en' => 'ifRecive',
                    'zh' => '领取状态'
                )
            );
            $this->export($dateRe, $tr);
        }
        if($type == 'returnRecord'){
            $outData = M('assets_revice')->where("scId = $scId and backStatu = 1 or backStatu=2 ")->select();
            $listData = M('assets_list')->where(array('scId' => $scId))->select();
            $listDataRe = array();
            foreach($listData as $key => $value){
                $listDataRe[$value['assetsId']] = $value;
            }
            foreach($outData as $key => $value){
                $outData[$key]['assetsName'] = $listDataRe[$value['assetsId']]['assetsName'];
                $outData[$key]['assetsNumber'] = $listDataRe[$value['assetsId']]['assetsNumber'];
                $outData[$key]['assetsTypeId'] = $listDataRe[$value['assetsId']]['assetsTypeId'];
                $outData[$key]['onePrice'] = $listDataRe[$value['assetsId']]['onePrice'];
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $outData),true);
        }
        if($type == 'exportReurnCecord'){
            $outData = M('assets_revice')->where("scId = $scId and backStatu = 1 or backStatu=2 ")->select();
            $listData = M('assets_list')->where(array('scId' => $scId))->select();
            $listDataRe = array();
            foreach($listData as $key => $value){
                $listDataRe[$value['assetsId']] = $value;
            }
            foreach($outData as $key => $value){
                $outData[$key]['assetsName'] = $listDataRe[$value['assetsId']]['assetsName'];
                $outData[$key]['assetsNumber'] = $listDataRe[$value['assetsId']]['assetsNumber'];
                $outData[$key]['assetsTypeId'] = $listDataRe[$value['assetsId']]['assetsTypeId'];
                $outData[$key]['onePrice'] = $listDataRe[$value['assetsId']]['onePrice'];
            }
            $tr = array(
                '0' => array(
                    'en' => 'assetsName',
                    'zh' => '资产名称'
                ),
                '1' => array(
                    'en' => 'assetsNumber',
                    'zh' => '资产编号'
                ),
                '2' => array(
                    'en' => 'assetsTypeId',
                    'zh' => '分类代码'
                ),
                '3' => array(
                    'en' => 'onePrice',
                    'zh' => '单价'
                ),
                '4' => array(
                    'en' => 'backTime',
                    'zh' => '归还日期'
                ),
                '5' => array(
                    'en' => 'createTime',
                    'zh' => '创建日期'
                ),
                '6' => array(
                    'en' => 'backUserId',
                    'zh' => '归还人'
                ),
                '7' => array(
                    'en' => 'createUserName',
                    'zh' => '创建人'
                ),
                '8' => array(
                    'en' => 'explain',
                    'zh' => '说明'
                ),
            );
            $this->export($outData, $tr);
        }
        if($type == 'brrowRecord'){
            $outData = M('assets_revice')->where(array('scId' => $scId))->select();
            $listData = M('assets_list')->where(array('scId' => $scId))->select();
            $listDataRe = array();
            foreach($listData as $key => $value){
                $listDataRe[$value['assetsId']] = $value;
            }
            foreach($outData as $key => $value){
                $outData[$key]['assetsName'] = $listDataRe[$value['assetsId']]['assetsName'];
                $outData[$key]['assetsNumber'] = $listDataRe[$value['assetsId']]['assetsNumber'];
                $outData[$key]['assetsTypeId'] = $listDataRe[$value['assetsId']]['assetsTypeId'];
                $outData[$key]['onePrice'] = $listDataRe[$value['assetsId']]['onePrice'];
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $outData),true);
        }
        if($type == 'updataBrrow'){
            $reciveId= $_POST['reciveId'];
            $reciveTime = $_POST['reciveTime'];
            if(M('assets_revice')->where(array('reciveId' => $reciveId,'scId' => $scId))->setField(array('reciveTime' => $reciveTime))){
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'return'){
            $reciveId = $_GET['reciveId'];
            $backUserId = $_GET['backUserId'];
            $backUserName = $_GET['backUserName'];
            $backTime = $_GET['backTime'];
            $backExplain = $_GET['backExplain'];
            foreach($reciveId as $key => $value){
                if(M('assets_revice')->where(array('scId' => $scId,'reciveId' => $value))->setField(
                    array('backStatu' => 1,'backUserId' => $backUserId,'backUserName' => $backUserName,'backTime' => $backTime,'backExplain' => $backExplain)
                )){
                    $userUser = M('assets_revice')->where(array('scId' => $scId,'reciveId' => $value))->find();
                    $assets = M('assets_list')->where(array('scId' => $scId,'assetsId' => $userUser['assetsId']))->find();
                    M('assets_approve')->add(array(
                        'approveName' =>$userUser['userName'].'还'.$assets['assetsName'],
                        'eventId' => $value,
                        'scId' => $scId,
                        'businessTime' =>$userUser['reciveTime'],
                        'createTime' =>date('Y-m-d H:i:s'),
                        'eventType' => 2,
                    ));
                    //$assetsId = M('assets_revice')->field('assetsId')->where(array('scId' => $scId,'reciveId' => $value))->find();
                    //$assetsId = $assetsId['assetsId'];
                    //M('assets_list')->where(array('scId' => $scId,'assetsId' => $assetsId))->setField(array('ifRecive' => 0));
                }
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
        }
        if($type =='revoke'){
            $reciveId = $_GET['reciveId'];
            foreach($reciveId as $key => $value){
                if(M('assets_revice')->where(array('scId' => $scId,'reciveId' => $value))->setField(array('resetStatu' => 1))){
                    $assetsId = M('assets_revice')->field('assetsId')->where(array('scId' => $scId,'reciveId' => $value))->find();
                    $assetsId = $assetsId['assetsId'];
                    M('assets_list')->where(array('scId' => $scId,'assetsId' => $assetsId))->setField(array('ifRecive' => 0));
                    M('assets_approve')->where(array('scId' => $scId,'eventId' => $value,'eventType' => 1))->delete();
                }
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
        }
        if($type =='export'){
            $outData = M('assets_revice')->where(array('scId' => $scId))->select();
            $listData = M('assets_list')->where(array('scId' => $scId))->select();
            $listDataRe = array();
            foreach($listData as $key => $value){
                $listDataRe[$value['assetsId']] = $value;
            }
            foreach($outData as $key => $value){
                $outData[$key]['assetsName'] = $listDataRe[$value['assetsId']]['assetsName'];
                $outData[$key]['assetsNumber'] = $listDataRe[$value['assetsId']]['assetsNumber'];
                $outData[$key]['assetsTypeId'] = $listDataRe[$value['assetsId']]['assetsTypeId'];
                $outData[$key]['onePrice'] = $listDataRe[$value['assetsId']]['onePrice'];
                $outData[$key]['state'] = '';
                if($value['resetStatu']){
                    $outData[$key]['state'] = '已撤销';
                }else{
                    $outData[$key]['state'] = '未撤销';
                }
                if($value['backStatu']){
                    $outData[$key]['state'] = $outData[$key]['state'].',已归还';
                }else{
                    $outData[$key]['state'] = $outData[$key]['state'].',未归还';
                }
            }
            $tr = array(
                '0' => array(
                    'en' => 'assetsName',
                    'zh' => '资产名称'
                ),
                '1' => array(
                    'en' => 'assetsNumber',
                    'zh' => '资产编号'
                ),
                '2' => array(
                    'en' => 'assetsTypeId',
                    'zh' => '分类代码'
                ),
                '3' => array(
                    'en' => 'onePrice',
                    'zh' => '单价'
                ),
                '4' => array(
                    'en' => 'reciveTime',
                    'zh' => '领用日期'
                ),
                '5' => array(
                    'en' => 'createTime',
                    'zh' => '创建日期'
                ),
                '6' => array(
                    'en' => 'userName',
                    'zh' => '领用人'
                ),
                '7' => array(
                    'en' => 'createUserName',
                    'zh' => '创建人'
                ),
                '8' => array(
                    'en' => 'unit',
                    'zh' => '单位'
                ),
                '9' => array(
                    'en' => 'useAddress',
                    'zh' => '使用地址'
                ),
                '10' => array(
                    'en' => 'explain',
                    'zh' => '说明'
                ),
                '11' => array(
                'en' => 'state',
                'zh' => '状态'
            )
            );
            $this->export($outData, $tr);
        }
        if($type == 'createBrrow'){
            $userName = $jbXn['name'];
            $assetsId = $_POST['assetsId'];
            $assets = M('assets_list')->where(array('assetsId' => $assetsId,'scId' => $scId))->find();
            $type =M('assets_type')->where(array('scId' => $scId,'ifUser' =>1))->select();
            $typeRe = array();
            foreach($type as $key => $value){
                $typeRe[$value['assetsTypeId']] = $value;
            }
            $nowType = $typeRe[$assets['assetsTypeId']];
            if($nowType['ifApprov'] == 0){
                $data = array(
                    'assetsId' => $assetsId,
                    'reciveTime' => $_POST['reciveTime'],
                    'createTime' => date('Y-m-d H:i:s'),
                    'scId' => $scId,
                    'userId' => $_POST['userId'],
                    'userName' => $_POST['userName'],
                    'explain' => $_POST['explain'],
                    'useAddress' => $_POST['useAddress'],
                    'scId' => $scId,
                    'createUserId' => $userId,
                    'approveStatu' => 1,
                    'createUserName' => $userName
                );
                if($idd = (M('assets_revice')->add($data))){
                    M('assets_list')->where(array('assetsId' => $assetsId,'scId' => $scId))->setField(array('ifRecive' => 1));
                    $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
                }
                $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
            }
            else{
                if($nowType['approver']){
                    $appType = $nowType;
                }else{
                    $appType = $this->getApper($nowType['assetsTypeParentId'],$type,$scId);
                    if($appType){
                        $appType = $appType[0];
                    }
                }
                if($appType){
                    $data = array(
                        'assetsId' => $assetsId,
                        'reciveTime' => $_POST['reciveTime'],
                        'createTime' => date('Y-m-d H:i:s'),
                        'scId' => $scId,
                        'userId' => $_POST['userId'],
                        'userName' => $_POST['userName'],
                        'explain' => $_POST['explain'],
                        'useAddress' => $_POST['useAddress'],
                        'scId' => $scId,
                        'createUserId' => $userId,
                        'approver' => $appType['approver'],
                        'approveStatu' => 0,
                        'createUserName' => $userName
                    );
                    if(($idd =M('assets_revice')->add($data))){
                        M('assets_approve')->add(array(
                            'approveName' => $_POST['userName'].'借'.$assets['assetsName'],
                            'eventId' => $idd,
                            'scId' => $scId,
                            'businessTime' => $_POST['reciveTime'],
                            'createTime' =>date('Y-m-d H:i:s'),
                            'eventType' => 1,
                        ));
                        $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
                    }
                    $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
                }else {
                    $data = array(
                        'assetsId' => $assetsId,
                        'reciveTime' => $_POST['reciveTime'],
                        'createTime' => date('Y-m-d H:i:s'),
                        'scId' => $scId,
                        'userId' => $_POST['userId'],
                        'userName' => $_POST['userName'],
                        'explain' => $_POST['explain'],
                        'useAddress' => $_POST['useAddress'],
                        'scId' => $scId,
                        'createUserId' => $userId,
                        'approveStatu' => 0,
                        'createUserName' => $userName
                    );
                    if(($idd =M('assets_revice')->add($data))){
                        M('assets_approve')->add(array(
                            'approveName' => $_POST['userName'].'借'.$assets['assetsName'],
                            'eventId' => $idd,
                            'scId' => $scId,
                            'businessTime' => $_POST['reciveTime'],
                            'createTime' =>date('Y-m-d H:i:s'),
                            'eventType' => 1,
                        ));
                        $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
                    }
                    $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
                }
            }
        }
    }
    private function getAll($assetsTypeId,$data,$scId){
        global $arr;
        foreach($data as $key => $value){
            if($assetsTypeId == $value['assetsTypeParentId']){
                $arr[$value['assetsTypeId']] = $value;
                $this->getAll($value['assetsTypeId'],$data,$scId);
            }
        }
        return $arr;
    }
    public function assetOut(){//资产出库
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        $userName = $jbXn['name'];
        if($type == 'getAssetsList'){
            $assetsTypeId = $_GET['assetsTypeId'];
            $data = M('assets_list')->where(array('scId' => $scId,'outStatu' =>0,'state' => 1))->select();
            $type = M('assets_type')->where(array('scId' => $scId))->select();
            $typeRe = array();
            foreach($type as $key => $value){
                $typeRe[$value['assetsTypeId']] = $value;
            }
            $typeReturn = $this->getAll($assetsTypeId,$type,$scId);
            $count = count($typeReturn);
            if(count($typeReturn)>0){
                $typeReturn[$count] = $typeRe[$assetsTypeId];
            }else{
                $typeReturn[$assetsTypeId] = $typeRe[$assetsTypeId];
            }
            $dateRe = array();
            foreach($data as $key => $value){
                if(isset($typeReturn[$value['assetsTypeId']])){
                    $value['assetsTypeName'] =  $typeRe[$value['assetsTypeId']]['assetsTypeName'];
                    $dateRe[] = $value;
                }else{

                }
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $dateRe),true);
        }
        if ($type == 'getAssetsType') {
            $data = M('assets_type')->where(array('scId' => $scId, 'ifUser' => 1))->select();
            $this->returnJson(array('statu' => 1, 'message' => 'success', 'data' => $data), true);
        }
        if($type == 'exportAdd'){
            $assetsTypeId = $_GET['assetsTypeId'];
            $data = M('assets_list')->where(array('scId' => $scId,'outStatu' =>0))->select();
            $type = M('assets_type')->where(array('scId' => $scId))->select();
            $typeRe = array();
            foreach($type as $key => $value){
                $typeRe[$value['assetsTypeId']] = $value;
            }
            $typeReturn = $this->getAll($assetsTypeId,$type,$scId);
            $count = count($typeReturn);
            if(count($typeReturn)>0){
                $typeReturn[$count] = $typeRe[$assetsTypeId];
            }else{
                $typeReturn[$assetsTypeId] = $typeRe[$assetsTypeId];
            }
            $dateRe = array();
            foreach($data as $key => $value){
                if(isset($typeReturn[$value['assetsTypeId']])){
                    if($value['ifRecive']){
                        $value['ifRecive'] = '已领用';
                    }else{
                        $value['ifRecive'] = '未领用';
                    }
                    $value['assetsTypeName'] =  $typeRe[$value['assetsTypeId']]['assetsTypeName'];
                    $dateRe[] = $value;
                }else{

                }
            }
            $tr = array(
                '0' => array(
                    'en' => 'assetsName',
                    'zh' => '资产名称'
                ),
                '1' => array(
                    'en' => 'assetsNumber',
                    'zh' => '资产编号'
                ),
                '2' => array(
                    'en' => 'assetsTypeId',
                    'zh' => '分类代码'
                ),
                '3' => array(
                    'en' => 'onePrice',
                    'zh' => '单价'
                ),
                '4' => array(
                    'en' => 'storageLocation',
                    'zh' => '存放地址'
                ),
                '5' => array(
                    'en' => 'spec',
                    'zh' => '规格'
                ),
                '6' => array(
                    'en' => 'brandModel',
                    'zh' => '品牌型号'
                ),
                '7' => array(
                    'en' => 'supplier',
                    'zh' => '供应商'
                ),
                '8' => array(
                    'en' => 'unit',
                    'zh' => '单位'
                ),
                '9' => array(
                    'en' => 'remarks',
                    'zh' => '备注'
                ),
                '10' => array(
                    'en' => 'ifRecive',
                    'zh' => '领取状态'
                )
            );
            $this->export($dateRe, $tr);
        }

        if($type =='createOut'){
            $assetsId = $_POST['assetsId'];
            $data = array(
                'assetsId' => $assetsId,
                'approver' => $_POST['approver'],
                'approverId' => $_POST['approverId'],
                'explain' => $_POST['explain'],
                'outTime' => $_POST['outTime'],
                'useAddress' => $_POST['useAddress'],
                'approveTime' => date('Y-m-d H:i:s'),
                'scId' => $scId,
                'outStatu' => 1,
                'approveStatu' =>1,
                'createUserId' => $userId,
                'createUserName' =>$userName
            );
            if(M('assets_out')->add($data)){
                M('assets_list')->where(array('scId' => $scId,'assetsId' => $assetsId))->setField(array('outStatu' => 1));
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'getOutRecord'){
            $outData = M('assets_out')->where(array('scId' => $scId))->select();
            $listData = M('assets_list')->where(array('scId' => $scId))->select();
            $listDataRe = array();
            foreach($listData as $key => $value){
                $listDataRe[$value['assetsId']] = $value;
            }
            foreach($outData as $key => $value){
                $outData[$key]['assetsName'] = $listDataRe[$value['assetsId']]['assetsName'];
                $outData[$key]['assetsNumber'] = $listDataRe[$value['assetsId']]['assetsNumber'];
                $outData[$key]['assetsTypeId'] = $listDataRe[$value['assetsId']]['assetsTypeId'];
                $outData[$key]['onePrice'] = $listDataRe[$value['assetsId']]['onePrice'];
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $outData),true);
        }
        if($type =='revoke'){
            $assetOutId = $_GET['assetOutId'];
            foreach($assetOutId as $key => $value){
                if(M('assets_out')->where(array('scId' => $scId,'assetOutId' => $value))->setField(array('ifRevoKe' => 1))){
                    $assetsId = M('assets_out')->field('assetsId')->where(array('scId' => $scId,'assetOutId' => $value))->find();
                    $assetsId = $assetsId['assetsId'];
                    M('assets_list')->where(array('scId' => $scId,'assetsId' => $assetsId))->setField(array('outStatu' => 0));
                }
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
        }
        if($type =='destroy'){
            $assetOutId = $_GET['assetOutId'];
            foreach($assetOutId as $key => $value){
                if(M('assets_out')->where(array('scId' => $scId,'assetOutId' => $value))->setField(array('ifDestroy' => 1))){
                    $assetsId = M('assets_out')->field('assetsId')->where(array('scId' => $scId,'assetOutId' => $value))->find();
                    $assetsId = $assetsId['assetsId'];
                    M('assets_list')->where(array('scId' => $scId,'assetsId' => $assetsId))->setField(array('state' => 0));
                }
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
        }
        if ($type == 'export') {
            $outData = M('assets_out')->where(array('scId' => $scId))->select();
            $listData = M('assets_list')->where(array('scId' => $scId))->select();
            $listDataRe = array();
            foreach($listData as $key => $value){
                $listDataRe[$value['assetsId']] = $value;
            }
            foreach($outData as $key => $value){
                if($outData[$key]['ifRevoKe'] == 0){
                    $outData[$key]['stateState'] ='未撤销';
                }else{
                    $outData[$key]['stateState'] ='已撤销';
                }
                if($outData[$key]['ifDestroy'] == 0){
                    $outData[$key]['stateState'] = $outData[$key]['stateState'].',未销毁';
                }else{
                    $outData[$key]['stateState'] = $outData[$key]['stateState'].',已销毁';
                }
                $outData[$key]['assetsName'] = $listDataRe[$value['assetsId']]['assetsName'];
                $outData[$key]['assetsNumber'] = $listDataRe[$value['assetsId']]['assetsNumber'];
                $outData[$key]['assetsTypeId'] = $listDataRe[$value['assetsId']]['assetsTypeId'];
                $outData[$key]['onePrice'] = $listDataRe[$value['assetsId']]['onePrice'];
            }
            $tr = array(
                '0' => array(
                    'en' => 'assetsName',
                    'zh' => '资产名称'
                ),
                '1' => array(
                    'en' => 'assetsNumber',
                    'zh' => '资产编号'
                ),
                '2' => array(
                    'en' => 'assetsTypeId',
                    'zh' => '分类代码'
                ),
                '3' => array(
                    'en' => 'outTime',
                    'zh' => '出库时期'
                ),
                '4' => array(
                    'en' => 'approveTime',
                    'zh' => '创建时间'
                ),
                '5' => array(
                    'en' => 'spec',
                    'zh' => '单价'
                ),
                '6' => array(
                    'en' => 'useAddress',
                    'zh' => '使用地址'
                ),
                '7' => array(
                    'en' => 'approver',
                    'zh' => '负责人'
                ),
                '8' => array(
                    'en' => 'createUserName',
                    'zh' => '创建人'
                ),
                '9' => array(
                    'en' => 'explain',
                    'zh' => '说明'
                ),
                '10' => array(
                    'en' => 'stateState',
                    'zh' => '状态'
                )
            );
            $this->export($outData, $tr);
        }
    }
    private function needApporve($assetsTypeId,$data,$scId){
        global $arr;
        foreach($data as $key => $value){
            if($assetsTypeId == $value['assetsTypeParentId']){
                $arr[$value['assetsTypeId']] = $value;
                $this->needApporve($value['assetsTypeId'],$data,$scId);
            }
        }
        return $arr;
    }
    private function state($id){
        $array = array(
            0 => '未审批',
            1 => '已审批'
        );
        return $array[$id];
    }
    public function assetsApprove(){//资产审批
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        $userName = $jbXn['name'];
        if($type =='getApporveList'){
            $data = M('assets_approve')->where(array('scId' => $scId,'state' => 0))->select();
            $rev = M('assets_revice')->field('reciveId,assetsId,userId,userName,useAddress,explain')->where(array('scId' => $scId))->select();
            $revRe = array();
            foreach($rev as $key => $value){
                $revRe[$value['reciveId']] = $value;
            }
            $list = M('assets_list')->field('assetsId,assetsName,assetsNumber,assetsTypeId,num,onePrice')->where(array('scId' => $scId))->select();
            $listRe = array();
            foreach($list as $key => $value){
                $listRe[$value['assetsId']] = $value;
            }
            foreach($data as $key => $value){
                $data[$key]['assetsId'] = $revRe[$value['eventId']]['assetsId'];
                $data[$key]['userId'] = $revRe[$value['eventId']]['userId'];
                $data[$key]['userName'] = $revRe[$value['eventId']]['userName'];
                $data[$key]['useAddress'] = $revRe[$value['eventId']]['useAddress'];
                $data[$key]['explain'] = $revRe[$value['eventId']]['explain'];
                $data[$key]['assetsName'] = $listRe[ $data[$key]['assetsId']]['assetsName'];
                $data[$key]['assetsNumber'] = $listRe[ $data[$key]['assetsId']]['assetsNumber'];
                $data[$key]['assetsTypeId'] = $listRe[ $data[$key]['assetsId']]['assetsTypeId'];
                $data[$key]['num'] = $listRe[ $data[$key]['assetsId']]['num'];
                $data[$key]['onePrice'] = $listRe[ $data[$key]['assetsId']]['onePrice'];
                $data[$key]['allPrice'] =  $data[$key]['num']* $data[$key]['onePrice'];
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
        }
        if($type =='exportWaitApprove'){
            $data = M('assets_approve')->where(array('scId' => $scId,'state' => 0))->select();
            $rev = M('assets_revice')->field('reciveId,assetsId,userId,userName,useAddress,explain')->where(array('scId' => $scId))->select();
            $revRe = array();
            foreach($rev as $key => $value){
                $revRe[$value['reciveId']] = $value;
            }
            $list = M('assets_list')->field('assetsId,assetsName,assetsNumber,assetsTypeId,num,onePrice')->where(array('scId' => $scId))->select();
            $listRe = array();
            foreach($list as $key => $value){
                $listRe[$value['assetsId']] = $value;
            }
            foreach($data as $key => $value){
                $data[$key]['assetsId'] = $revRe[$value['eventId']]['assetsId'];
                $data[$key]['userId'] = $revRe[$value['eventId']]['userId'];
                $data[$key]['userName'] = $revRe[$value['eventId']]['userName'];
                $data[$key]['useAddress'] = $revRe[$value['eventId']]['useAddress'];
                $data[$key]['explain'] = $revRe[$value['eventId']]['explain'];
                $data[$key]['assetsName'] = $listRe[ $data[$key]['assetsId']]['assetsName'];
                $data[$key]['assetsNumber'] = $listRe[ $data[$key]['assetsId']]['assetsNumber'];
                $data[$key]['assetsTypeId'] = $listRe[ $data[$key]['assetsId']]['assetsTypeId'];
                $data[$key]['num'] = $listRe[ $data[$key]['assetsId']]['num'];
                $data[$key]['onePrice'] = $listRe[ $data[$key]['assetsId']]['onePrice'];
                $data[$key]['allPrice'] =  $data[$key]['num']* $data[$key]['onePrice'];
            }
            $tr = array(
                '0' => array(
                    'en' => 'approveName',
                    'zh' => '业务名称'
                ),
                '1' => array(
                    'en' => 'assetsName',
                    'zh' => '资产名称'
                ),
                '2' => array(
                    'en' => 'assetsNumber',
                    'zh' => '资产编号'
                ),
                '3' => array(
                    'en' => 'assetsTypeId',
                    'zh' => '分类代码'
                ),
                '4' => array(
                    'en' => 'allPrice',
                    'zh' => '总价'
                ),
                '5' => array(
                    'en' => 'businessTime',
                    'zh' => '业务日期'
                ),
                '6' => array(
                    'en' => 'createTime',
                    'zh' => '申请日期'
                ),
                '7' => array(
                    'en' => 'useAddress',
                    'zh' => '使用地址'
                ),
                '8' => array(
                    'en' => 'userName',
                    'zh' => '负责人'
                ),
                '9' => array(
                    'en' => 'explain',
                    'zh' => '说明'
                )
            );
            $this::export($data,$tr);
        }
        if($type == 'approveHandle'){
            $adpot = $_GET['adpot'];
            $approveOpinion = $_GET['approveOpinion'];
            $assetsId = $_GET['assetsId'];
            $approveId = $_GET['approveId'];
            $approve = M('assets_approve')->where(array('scId' => $scId,'approveId' => $approveId))->find();
            $eventId =  $approve['eventId'];
            $eventType = $approve['eventType'];
            if($adpot == 1){
                if(M('assets_approve')->where(array('scId' => $scId,'approveId' => $approveId))->setField(array('appResult' => 1,'approver' => $userName,'approverId' => $userId,'state' => 1,'approveTime' => date('Y-m-d H:i:s'),'approveOpinion' => $approveOpinion))){
                    if($eventType == 1){
                        M('assets_list')->where(array('scId' => $scId,'assetsId' => $assetsId))->setField(array('ifRecive' => 1));
                        M('assets_revice')->where(array('reciveId' => $eventId))->setField(array('approveStatu' => 1));
                        $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
                    }else{
                        M('assets_list')->where(array('scId' => $scId,'assetsId' => $assetsId))->setField(array('ifRecive' => 0));
                        M('assets_list')->where(array('scId' => $scId,'assetsId' => $assetsId))->setField(array('outStatu' => 0));
                        M('assets_revice')->where(array('reciveId' => $eventId))->setField(array('backStatu' => 2,'approveStatu'=>1));
                        $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
                    }
                }
                $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
            }else{
                if(M('assets_approve')->where(array('scId' => $scId,'approveId' => $approveId))->setField(array('appResult' => 2,'state' => 1,'approver' => $userName,'approverId' => $userId,'approveTime' => date('Y-m-d H:i:s'),'approveOpinion' => $approveOpinion))){
                    if($eventType == 1){
                        M('assets_revice')->where(array('reciveId' => $eventId))->setField(array('approveStatu' => 2));
                        $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
                    }else{
                        M('assets_list')->where(array('scId' => $scId,'assetsId' => $assetsId))->setField(array('ifRecive' => 0));
                        M('assets_revice')->where(array('reciveId' => $eventId))->setField(array('backStatu' => 3,'approveStatu'=>2));
                        $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
                    }
                }
                $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
            }
        }
        if($type == 'getHaveApprove'){
            $data = M('assets_approve')->where(array('scId' => $scId, 'state' => 1))->select();
            $rev = M('assets_revice')->field('reciveId,assetsId,userId,userName,useAddress,explain')->where(array('scId' => $scId))->select();
            $revRe = array();
            foreach ($rev as $key => $value) {
                $revRe[$value['reciveId']] = $value;
            }
            $list = M('assets_list')->field('assetsId,assetsName,assetsNumber,assetsTypeId,num,onePrice')->where(array('scId' => $scId))->select();
            $listRe = array();
            foreach ($list as $key => $value) {
                $listRe[$value['assetsId']] = $value;
            }
            foreach ($data as $key => $value) {
                $data[$key]['assetsId'] = $revRe[$value['eventId']]['assetsId'];
                $data[$key]['userId'] = $revRe[$value['eventId']]['userId'];
                $data[$key]['userName'] = $revRe[$value['eventId']]['userName'];
                $data[$key]['useAddress'] = $revRe[$value['eventId']]['useAddress'];
                $data[$key]['explain'] = $revRe[$value['eventId']]['explain'];
                $data[$key]['assetsName'] = $listRe[$data[$key]['assetsId']]['assetsName'];
                $data[$key]['assetsNumber'] = $listRe[$data[$key]['assetsId']]['assetsNumber'];
                $data[$key]['assetsTypeId'] = $listRe[$data[$key]['assetsId']]['assetsTypeId'];
                $data[$key]['num'] = $listRe[$data[$key]['assetsId']]['num'];
                $data[$key]['onePrice'] = $listRe[$data[$key]['assetsId']]['onePrice'];
                $data[$key]['allPrice'] = $data[$key]['num'] * $data[$key]['onePrice'];
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $data),true);
        }
        if($type == 'getHaveApproveExport') {
            $data = M('assets_approve')->where(array('scId' => $scId, 'state' => 1))->select();
            $rev = M('assets_revice')->field('reciveId,assetsId,userId,userName,useAddress,explain')->where(array('scId' => $scId))->select();
            $revRe = array();
            foreach ($rev as $key => $value) {
                $revRe[$value['reciveId']] = $value;
            }
            $list = M('assets_list')->field('assetsId,assetsName,assetsNumber,assetsTypeId,num,onePrice')->where(array('scId' => $scId))->select();
            $listRe = array();
            foreach ($list as $key => $value) {
                $listRe[$value['assetsId']] = $value;
            }
            foreach ($data as $key => $value) {
                $data[$key]['assetsId'] = $revRe[$value['eventId']]['assetsId'];
                $data[$key]['userId'] = $revRe[$value['eventId']]['userId'];
                $data[$key]['userName'] = $revRe[$value['eventId']]['userName'];
                $data[$key]['useAddress'] = $revRe[$value['eventId']]['useAddress'];
                $data[$key]['explain'] = $revRe[$value['eventId']]['explain'];
                $data[$key]['assetsName'] = $listRe[$data[$key]['assetsId']]['assetsName'];
                $data[$key]['assetsNumber'] = $listRe[$data[$key]['assetsId']]['assetsNumber'];
                $data[$key]['assetsTypeId'] = $listRe[$data[$key]['assetsId']]['assetsTypeId'];
                $data[$key]['num'] = $listRe[$data[$key]['assetsId']]['num'];
                $data[$key]['onePrice'] = $listRe[$data[$key]['assetsId']]['onePrice'];
                $data[$key]['allPrice'] = $data[$key]['num'] * $data[$key]['onePrice'];
            }
            $tr = array(
                '0' => array(
                    'en' => 'approveName',
                    'zh' => '业务名称'
                ),
                '1' => array(
                    'en' => 'assetsName',
                    'zh' => '资产名称'
                ),
                '2' => array(
                    'en' => 'assetsNumber',
                    'zh' => '资产编号'
                ),
                '3' => array(
                    'en' => 'assetsTypeId',
                    'zh' => '分类代码'
                ),
                '4' => array(
                    'en' => 'allPrice',
                    'zh' => '总价'
                ),
                '5' => array(
                    'en' => 'approveTime',
                    'zh' => '审批日期'
                ),
                '6' => array(
                    'en' => 'businessTime',
                    'zh' => '业务日期'
                ),
                '7' => array(
                    'en' => 'createTime',
                    'zh' => '申请日期'
                ),
                '8' => array(
                    'en' => 'useAddress',
                    'zh' => '使用地址'
                ),
                '9' => array(
                    'en' => 'userName',
                    'zh' => '负责人'
                ),
                '10' => array(
                    'en' => 'approver',
                    'zh' => '审批人'
                ),
                '11' => array(
                    'en' => 'explain',
                    'zh' => '说明'
                ),
                '12' => array(
                    'en' => 'approveOpinion',
                    'zh' => '审批意见'
                )
            );
            $this::export($data,$tr);
        }
    }
    public function assetsList(){
        $type = $_GET['type'];
        $jbXn = $this->get_session('loginCheck', false);
        $scId = $jbXn['scId'];
        $userId = $jbXn['userId'];
        $userRoleId = $jbXn['roleId'];
        $userName = $jbXn['name'];
        if($type == 'getList'){
            M('assets_list')->where(array('scId' => $scId))->select();
        }
        if ($type == 'getType') {
            $data = M('assets_type')->where(array('scId' => $scId, 'ifUser' => 1))->select();
            $this->returnJson(array('statu' => 1, 'message' => 'success', 'data' => $data), true);
        }
        if ($type == 'getAssetsList') {
            $assetsTypeId = $_GET['assetsTypeId'];
            $data = M('assets_list')->where(array('scId' => $scId,'outStatu' =>0,'state' => 1))->select();
            $type = M('assets_type')->where(array('scId' => $scId))->select();
            $typeRe = array();
            foreach($type as $key => $value){
                $typeRe[$value['assetsTypeId']] = $value;
            }
            $typeReturn = $this->getAll($assetsTypeId,$type,$scId);
            $count = count($typeReturn);
            if(count($typeReturn)>0){
                $typeReturn[$count] = $typeRe[$assetsTypeId];
            }else{
                $typeReturn[$assetsTypeId] = $typeRe[$assetsTypeId];
            }
            $dateRe = array();
            foreach($data as $key => $value){
                if(isset($typeReturn[$value['assetsTypeId']])){
                    $value['assetsTypeName'] =  $typeRe[$value['assetsTypeId']]['assetsTypeName'];
                    $dateRe[] = $value;
                }else{

                }
            }
            $this->returnJson(array('statu' => 1, 'message' => 'success','data' => $dateRe),true);
        }
        if($type == 'update'){
            $data = $_POST['data'];
            $assetsId = $data['assetsId'];
            unset($data['assetsId']);
            if($data){
                if(M('assets_list')->where(array('assetsId' => $assetsId,'scId' => $scId))->setField($data) === false){
                    $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
                }
                $this->returnJson(array('statu' => 1, 'message' => 'success'),true);
            }
            $this->returnJson(array('statu' => 0, 'message' => 'fail'),true);
        }
        if($type == 'export'){
            $assetsTypeId = $_GET['assetsTypeId'];
            $data = M('assets_list')->where(array('scId' => $scId,'outStatu' =>0,'state' => 1))->select();
            $type = M('assets_type')->where(array('scId' => $scId))->select();
            $typeRe = array();
            foreach($type as $key => $value){
                $typeRe[$value['assetsTypeId']] = $value;
            }
            $typeReturn = $this->getAll($assetsTypeId,$type,$scId);
            $count = count($typeReturn);
            if(count($typeReturn)>0){
                $typeReturn[$count] = $typeRe[$assetsTypeId];
            }else{
                $typeReturn[$assetsTypeId] = $typeRe[$assetsTypeId];
            }
            $dateRe = array();
            foreach($data as $key => $value){
                if(isset($typeReturn[$value['assetsTypeId']])){
                    $value['assetsTypeName'] =  $typeRe[$value['assetsTypeId']]['assetsTypeName'];
                    $dateRe[] = $value;
                }else{

                }
            }
            $tr = array(
                '0' => array(
                    'en' => 'assetsName',
                    'zh' => '资产名称'
                ),
                '1' => array(
                    'en' => 'assetsNumber',
                    'zh' => '资产编号'
                ),
                '2' => array(
                    'en' => 'assetsTypeId',
                    'zh' => '分类代码'
                ),
                '3' => array(
                    'en' => 'onePrice',
                    'zh' => '单价'
                ),
                '4' => array(
                    'en' => 'storageLocation',
                    'zh' => '存放地址'
                ),
                '5' => array(
                    'en' => 'spec',
                    'zh' => '规格'
                ),
                '6' => array(
                    'en' => 'brandModel',
                    'zh' => '品牌型号'
                ),
                '7' => array(
                    'en' => 'supplier',
                    'zh' => '供应商'
                ),
                '8' => array(
                    'en' => 'unit',
                    'zh' => '单位'
                ),
                '9' => array(
                    'en' => 'remarks',
                    'zh' => '备注'
                ),
                '10' => array(
                    'en' => 'ifRecive',
                    'zh' => '领取状态'
                )
            );
            $this->export($dateRe, $tr);
        }
    }
    private function leaveState($id){
        $array = array(
            0 => '未离校',
            1 => '已离校'
        );
        return $array[$id];
    }
    private function toLeave($id){
        $array = array(
            1 => '事假',
            2 => '病假',
            3 => '其他',
        );
        return $array[$id];
    }
    private function gradeToZhong($gradeName){
        $return = array(
            '1' => '一年级',
            '2' => '二年级',
            '3' => '三年级',
            '4' => '四年级',
            '5' => '五年级',
            '6' => '六年级',
            '7' => '初一',
            '8' => '初二',
            '9' => '初三',
            '10' => '高一',
            '11' => '高二',
            '12' => '高三',
        );
        return $return[$gradeName];
    }
}