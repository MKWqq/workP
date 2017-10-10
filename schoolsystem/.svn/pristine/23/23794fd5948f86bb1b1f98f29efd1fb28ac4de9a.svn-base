<?php
/**
 * Created by PhpStorm.
 * User: hujun
 * Date: 2017/8/1
 * Time: 17:36
 */

namespace Home\Common;
header("content-type:text/html;charset=utf-8");

class Accessory
{
    protected $file;
    protected $scId;
    protected $subName;
    protected $id;//
    protected $rootPath;
    public $i;

    public function __construct($file, $scId, $subName)
    {
        $this->file = $file;
        $this->scId = $scId;
        $this->subName = $subName;
        $this->rootPath =   './Public/Uploads/';

    }

    public function upload()
    {
        $config = array(
            'maxSize' => 3145728,
            'rootPath' => $this->rootPath,
            'savePath' => "{$this->scId}/",
            /*            'saveName' => array('getName', array('__FILE__', $this->id)),*/
            'saveName' => array('uniqid', ''),
            'exts' => '',
            'autoSub' => true,
            'subName' => $this->subName,
        );


        $upload = new \Think\Upload($config);

        // 上传文件

        $info = $upload->upload($this->file);

        if (!$info) {
            // 上传错误提示错误信息
            $response = array(
                'status' => false,
                'msg' => $upload->getError()
            );

        } else {
            // 上传成功 获取上传文件信息
            $response['status'] =1;
            foreach ($info as &$v) {
                $response['path'][] = $v['savepath'] . $v['savename'];
            }
        }
        return $response;

    }

/*
 * @param $filename 数组 文件的路径名
 * @param $single 布尔 是否下载单个文件
 * @param $aName 数组  文件名 与文件路径名一一对应
 * */
    final function download($filename,$aName,$single=false)
    {
        if(!$single){
            $zip = new \ZipArchive();
            $zipname = date('YmdHis', time());

            if ($zip->open($this->rootPath . $zipname . '.zip', \ZIPARCHIVE::CREATE) !== TRUE) {
                echo "<script>alert('无法打开文件，或者文件创建失败');</script>";
                die;
            }

            for ($i = 0; $i < count($filename); $i++) {
                $zip->addFile($this->rootPath . $filename[$i], $aName[$i]);
            }

            $zip->close();//关闭
            $file_name = $zipname . '.zip';
            $filepath =  './Public/Uploads/' . $file_name;
        }else{ //单个文件
            $filepath =  './Public/Uploads/' . $filename[0];
            $file_name = $aName[0];
        }

        clearstatcache(true, $filepath);
        if (file_exists($filepath)) {
//打开文件
            $file = fopen($filepath, "r");
//返回的文件类型
           // Header("Content-type: application/octet-stream");
//按照字节大小返回
            Header("Accept-Ranges: bytes");
//返回文件的大小
            Header("Accept-Length: " . filesize($filepath));
//这里对客户端的弹出对话框，对应的文件名
            Header("Content-Disposition: attachment; filename=" . $file_name);
            ob_clean();
            flush();
//修改之后，一次只传输1024个字节的数据给客户端
//向客户端回送数据
            $buffer = 1024;//
//判断文件是否读完
            $file_data='';
            while (!feof($file)) {
//将文件读入内存
                $file_data .= fread($file, $buffer);
//每次向客户端回送1024个字节的数据
            }
            echo $file_data;
            fclose($file);
        } else {
            echo "<script>alert('对不起,您要下载的文件不存在');</script>";
            //下载完成后要进行删除
        }
        if(!$single)
        unlink($filepath);
    }


    public function del($path)
    {

        if (!is_array($path)) {
            $file = $this->rootPath . $path;
            @unlink($file);
        }

        foreach ($path as &$v) {
            $file = $this->rootPath . $v;
            $result = @unlink($file);
            if (!$result) {
                continue;
            }
        }
        return true;

    }

    //更新附件

    /*
     * @param $preFile 数组 原来的文件路径
     * @param $upload 数组 修改过的文件名路径(不包含新文件路径)
     * @param $prefix 前缀
     * return
     * */
    public function update($preFile, $upload, $prefix = '')
    {
        $response = array(
            'msg' => '',
            'status' => -1
        );
        foreach ($upload as $k => $val) {
            $upload[$k] = $prefix . $val;
        }

        if (empty($upload)) {//没有附件 将原来的删除
            foreach ($preFile as &$v) {
                $this->del($v);
            }
            $nextFile = array();
        } else {
            //有附件
            //求差集
            $difference = array_merge(array_diff($upload, $preFile), array_diff($preFile, $upload));//求变化的文件名
            if (empty($difference)) {//附件没有改变
                $nextFile = $preFile;
            } else {
                if (empty($preFile)) { //原来没有附件
                    $newFile = $this->upload();
                    if (!$newFile['status']) {
                        $response['msg'] = $newFile['msg'];
                        return $response;
                    }
                    $nextFile = $newFile['path'];
                } else { //原来有附件 将变更的附件删除
                    foreach ($difference as &$v) {
                        if (in_array($v, $preFile)) {
                            $this->del($v);
                        };
                    }
                    $newFile = $this->upload();
                    if (!$newFile['status']) {
                        $response['msg'] = $newFile['msg'];
                        return $response;
                    }
                    $preFile = array_intersect($upload, $preFile);
                    if (empty($preFile))
                        $nextFile = $newFile['path'];
                    else
                        $nextFile = array_merge($preFile, $newFile['path']);
                }
            }
        }
        return $nextFile;
    }

    //导入excel
    public function uploadExcel(){
        $config = array(
            'maxSize' => 3145728,
            'rootPath' => $this->rootPath,
            'savePath' => "{$this->scId}/",
            /*            'saveName' => array('getName', array('__FILE__', $this->id)),*/
            'saveName' => array('uniqid', ''),
            'exts' => '',
            'autoSub' => true,
            'subName' => $this->subName,
        );

        if (! empty ($this->file))
        {
            $tmp_file = $_FILES ['import'] ['tmp_name'];
            $file_types = explode ( ".", $_FILES ['import'] ['name'] );
            $file_type = $file_types [count ( $file_types ) - 1];
            $file_type=strtolower ( $file_type );

            /*判别是不是.xls文件，判别是不是excel文件*/
            if (!in_array($file_type,array('xls','xlsx'))) //$file_type != "xls"||$file_type != "xlsx"
            {
                echo "<script>alert('不是Excel文件，重新上传');</script>";
                die;
            }
        }

        $upload = new \Think\Upload($config);

        // 上传文件

        $info = $upload->upload($this->file);

        if (!$info) {
            // 上传错误提示错误信息
            $response = array(
                'status' => false,
                'msg' => $upload->getError()
            );

        } else {
            // 上传成功 获取上传文件信息
            $response['status'] =1;
            foreach ($info as &$v) {
                $response['path'][] = $v['savepath'] . $v['savename'];
            }
        }
        return $response;
    }
}