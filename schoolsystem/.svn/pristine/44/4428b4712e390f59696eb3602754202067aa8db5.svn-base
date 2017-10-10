<?php
/**
 * Created by PhpStorm.
 * User: hujun
 * Date: 2017/9/26
 * Time: 15:30
 */

namespace Home\Common;
use PHPExcel_IOFactory;
use PHPExcel_Cell;
use PHPExcel_Reader_Excel5;
use PHPExcel_Reader_Excel2007;
use PHPExcel_Reader_CSV;
use PHPExcel;
/*
 * 公用批量导入
 * */
class Import {
    public function __construct() {
        /*导入phpExcel核心类*/
        Vendor('PHPExcel.PHPExcel');
        $this->rootPath =   './Public/Uploads/';
    }
    /**
     * 读取excel $filename 路径文件名 $encode 返回数据的编码 默认为utf8
     *以下基本都不要修改
     */


    public function read($filename,$encode='utf-8'){
      /*  $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objReader->setReadDataOnly(true);*/
        $extension = strtolower( pathinfo($filename, PATHINFO_EXTENSION) );

        if ($extension =='xlsx') {
            $objReader = new PHPExcel_Reader_Excel2007();
            $objPHPExcel = $objReader ->load($this->rootPath.$filename);
        } else if ($extension =='xls') {
            $objReader = new PHPExcel_Reader_Excel5();
            $objPHPExcel = $objReader ->load($this->rootPath.$filename);
        } /*else if ($extension=='csv') {
            $PHPReader = new PHPExcel_Reader_CSV();

            //默认输入字符集
            $PHPReader->setInputEncoding('utf-8');

            //默认的分隔符
            $PHPReader->setDelimiter(',');

            //载入文件
            $objPHPExcel = $PHPReader->load($this->rootPath.$filename);
        }*/
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $excelData = array();
        for ($row = 1; $row <= $highestRow; $row++) {
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $excelData[$row][] =(string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
         }
        return $excelData;
    }

}